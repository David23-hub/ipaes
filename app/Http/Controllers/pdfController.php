<?php

namespace App\Http\Controllers;

use App\Models\CartModel;
use App\Models\CategoryProductModel;
use App\Models\DokterModel;
use App\Models\ItemModel;
use App\Models\EkspedisiModel;
use App\Models\ExtraChargeModel;
use App\Models\PackageModel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
  
use Illuminate\Http\Request;
use PDF;

/**
 * Untuk list di depan berarti butuh photo, name, price, commision_rate, list_products
 * Untuk Delimiter nya pake gini => id,qty;id,qty;id,qty
 */


class PDFController extends Controller
{
    private $model;
    private $bundle;
    private $cart;
    private $modelCategoryProduct;
    private $doctorModel;
    private $ekspedisi;
    private $extra_charge;
    private $user;
    public function __construct()
    {
        $this->middleware('auth');
        $this->model = new ItemModel;

        $this->cart = new CartModel;
        $this->bundle = new PackageModel;
        
        $this->modelCategoryProduct = new CategoryProductModel;

        $this->doctorModel = new DokterModel;
        $this->ekspedisi = new EkspedisiModel;
        $this->extra_charge = new ExtraChargeModel;
        $this->user = new User;
    }

    public function index()
    {
        $data = $this->modelCategoryProduct->GetListActive();
        $dataProduct = $this->cart->GetListActive();
        $dataAll = array("dataCategory" => $data, "dataProduct" => $dataProduct);
        return view('master.package')->with('data', $dataAll);
    }

    public function generatePDF()
    {
        $data = [
            [
                'quantity' => 1,
                'product_name' => 'Elitox 100u',
                'description' => '1 Year Subscription',
                'discount' => '25%',
                'price' => '129.00',
                'total_price' => '120.00'
            ]
        ];
          
        $pdf = PDF::loadView('myPDF', ['data' => $data]);
    
        return $pdf->stream();
    }

    public function generatePDFOneTransaction(string $id)
    {
        $cart = $this->cart->GetItemWithoutEmail($id);
        $cart = $cart[0];
        $dokter = $this->doctorModel->SingleItem($cart['doctor_id']);
        $items = $this->model->getAll();
        $usersCreate = $this->user->GetUserWithEmail($cart['created_by']);
        $bundles = $this->bundle->getAll();
        $extraChargeAll = $this->extra_charge->GetListAll();

        $carts = explode(",", $cart->cart);
        $products = [];
        $extraChargeOne = [];
        $stepPayment = [];
        $totalan = 0;
        $totalExtraCharge = 0;
        $cart['dokter'] = $dokter;
        $cart['user'] = $usersCreate[0];
        $cart['po_id'] = str_replace("PO", "INV", $cart['po_id']);
        $cart['created_at'] = date("d F Y", strtotime($cart['created_at']));
        $cart['due_date'] = date("d F Y", strtotime($cart['due_date']));
        Log::info("po_id", [
          "po_id" => $cart['po_id']
        ]);
        foreach ($carts as $valueCart) {
            $temp = explode("|", $valueCart);

    
            if($temp[1]=="product"){
                foreach ($items as $item) {
                    if($temp[0]==$item["id"]){
                    $product["name_product"]=$item["name"];
                    $product["price_product"]=$item["price"];
                    break;
                    }                      
            }
            }else if($temp[1]=="paket"){
                foreach ($bundles as $bundle) {
                    if($temp[0]==$bundle["id"]){
                    $product["name_product"]=$bundle["name"];
                    $product["price_product"]=$bundle["price"];
                    break;
                    }                      
                }
            }

            $product["type"] = $temp[1];
            $product["id"] = $temp[0];
            $product["qty"]=$temp[2];
            $product["disc"]=$temp[3];
            $price = $product["price_product"]*$temp[2];
            $disc = $price*($temp[3]/100);
            $product["price"]=$price;
            $product["disc_price"]=$disc;
            $product["total_price"]=$price-$disc;
            $totalan+=$product["total_price"];
            $product["total_price"] = number_format($product["total_price"],0,',','.');
            $product["disc_price"] = number_format($product["disc_price"],0,',','.');
            $product["price"] = number_format($product["price"],0,',','.');
            $product["price_product"] = number_format($product["price_product"],0,',','.'); 
            array_push($products, $product);            
        }

        $cart['products'] = $products;
                
        foreach ($extraChargeAll as $valueExtra) {
            if ($cart['id'] == $valueExtra['transaction_id']) {
                $totalExtraCharge += $valueExtra['price'];
                $valueExtra['real_price'] = $valueExtra['price'];
                $totalan += $valueExtra['price'];
                $valueExtra['price'] = number_format($valueExtra["price"],0,',','.');
                array_push($extraChargeOne, $valueExtra);
            }
        }
        $totalan = ceil($totalan);
        $cart['total_price'] = $totalan;
        $cart['total'] = number_format($totalan,0,',','.');
        $cart['total_extra_charge'] = $totalExtraCharge;
        $cart['totalan_extra_charge'] = number_format($totalExtraCharge,0,',','.');
        $cart['shipping_cost_number'] = $cart['shipping_cost'];
        $cart['shipping_cost'] = number_format($cart['shipping_cost'],0,',','.');
        $cart['nominal_number'] = $cart['nominal'];
        // $cart['nominal'] = number_format($cart['nominal'],0,',','.');
        $cart['extra_charge'] = $extraChargeOne;

        // step payment
        if($cart['status'] == 5) {
            $cartPaidBy = explode("|", $cart['paid_by']);
            $cartPaidAt = explode("|", $cart['paid_at']);
            $cartPaidBankName = explode("|", $cart['paid_bank_name']);
            $cartPaidAccountBankName = explode("|", $cart['paid_account_bank_name']);
            $cartNominal = explode("|", $cart['nominal']);
            foreach ($cartPaidBy as $key => $value) {
                $cartStepPayment['paid_by'] = $value;
                $cartStepPayment['paid_at'] = $cartPaidAt[$key];
                $cartStepPayment['paid_bank_name'] = $cartPaidBankName[$key];
                $cartStepPayment['paid_account_bank_name'] = $cartPaidAccountBankName[$key];
                $cartStepPayment['nominal'] = $cartNominal[$key];
                array_push($stepPayment, $cartStepPayment);
            }

            $cart['step_payment'] = $stepPayment;
        }
        $pdf = PDF::loadView('printOne', ['data' => $cart]);
    
        return $pdf->download($cart['po_id'] . '.pdf');
    }

    public function generatePDFAllTransaction(string $id)
    {
        $dataCartDokter = $this->cart->GetListJoinDoctorWithDoctorId($id);
        $dokter = $this->doctorModel->SingleItem($id);
        $items = $this->model->getAll();
        $bundles = $this->bundle->getAll();
        $dataEkspedisi = $this->ekspedisi->GetList();
        $extraChargeAll = $this->extra_charge->GetListAll();
        $user = auth()->user();

        $datas['dokter'] = $dokter;


        foreach ($dataCartDokter as $data) {
          $totalan = 0;
          $products = [];
          $extraChargeOne = [];
          $stepPayment = [];
          $countExtra = 0;
          $totalExtraCharge = 0;
          $usersCreate = $this->user->GetUserWithEmail($data['created_by']);
          $data['user'] = $usersCreate[0];
          $data['po_id'] = str_replace("PO", "INV", $data['po_id']);

          if (strlen($data->cart)!=0){

            $carts = explode(",", $data->cart);
            // array product
            foreach ($carts as $valueCart) {
              $temp = explode("|", $valueCart);

              if($temp[1]=="product"){
                foreach ($items as $item) {
                  if($temp[0]==$item["id"]){
                    $product["name_product"]=$item["name"];
                    $product["price_product"]=$item["price"];
                    break;
                  }                      
                }
              }else if($temp[1]=="paket"){
                foreach ($bundles as $bundle) {
                  if($temp[0]==$bundle["id"]){
                    $product["name_product"]=$bundle["name"];
                    $product["price_product"]=$bundle["price"];
                    break;
                  }                      
                }
              }

              
              $product["type"] = $temp[1];
              $product["id"] = $temp[0];
              $product["qty"]=$temp[2];
              $product["disc"]=$temp[3];
              $price = $product["price_product"]*$temp[2];
              $disc = $price*($temp[3]/100);
              $product["price"]=$price;
              $product["disc_price"]=$disc;
              $product["total_price"]=$price-$disc;
              $totalan+=$product["total_price"];
              $product["total_price"] = number_format($product["total_price"],0,',','.');
              $product["disc_price"] = number_format($product["disc_price"],0,',','.');
              $product["price"] = number_format($product["price"],0,',','.');
              $product["price_product"] = number_format($product["price_product"],0,',','.'); 
              array_push($products, $product);
            }

            $data['products'] = $products;
            
            foreach ($extraChargeAll as $valueExtra) {
              if ($data['id'] == $valueExtra['transaction_id']) {
                $totalExtraCharge += $valueExtra['price'];
                $totalan += $valueExtra['price'];
                $valueExtra['real_price'] = $valueExtra['price'];
                $valueExtra['price'] = number_format($valueExtra["price"],0,',','.');
                $countExtra++;
                array_push($extraChargeOne, $valueExtra);
              }
            }

            $data['total_extra_charge'] = $totalExtraCharge;
            $data['totalan_extra_charge'] = number_format($totalExtraCharge,0,',','.');

            $totalan = ceil($totalan);
            $data['total_price'] = $totalan;
            $data['total'] = number_format($totalan,0,',','.');
            $data['shipping_cost_number'] = $data['shipping_cost'];
            $data['shipping_cost'] = number_format($data['shipping_cost'],0,',','.');
            $data['nominal_number'] = $data['nominal'];
            // $data['nominal'] = number_format($data['nominal'],0,',','.');
            $data['extra_charge'] = $extraChargeOne;
            $data['count_extra'] = $countExtra;

            // step payment
            if($data['status'] == 5) {
              $dataPaidBy = explode("|", $data['paid_by']);
              $dataPaidAt = explode("|", $data['paid_at']);
              $dataPaidBankName = explode("|", $data['paid_bank_name']);
              $dataPaidAccountBankName = explode("|", $data['paid_account_bank_name']);
              $dataNominal = explode("|", $data['nominal']);
              $sum = array_sum(explode("|", $data['nominal']));
              foreach ($dataPaidBy as $key => $value) {
                $dataStepPayment['paid_by'] = $value;
                $dataStepPayment['paid_at'] = $dataPaidAt[$key];
                $dataStepPayment['paid_bank_name'] = $dataPaidBankName[$key];
                $dataStepPayment['paid_account_bank_name'] = $dataPaidAccountBankName[$key];
                $dataStepPayment['nominal'] = $dataNominal[$key];
                // $totalPaid += $dataStepPayment['nominal'];
                array_push($stepPayment, $dataStepPayment);
              }

              $data['total_num_paid'] = $sum;
              $data['total_paid'] = number_format($sum,0,',','.');
              $data['total_num_paid_sum'] = $data['total_price'] - $sum;
              $data['total_paid_sum'] = number_format($data['total_price'] - $sum,0,',','.');
              $data['step_payment'] = $stepPayment;
            } else if($data['status'] == 3) {
              $data['total_num_paid'] = $data['total_price'];
              $data['total_paid'] = number_format($data['total_price'],0,',','.');
              $data['total_num_paid_sum'] = $data['total_price'];
              $data['total_paid_sum'] = number_format($data['total_price'],0,',','.');
            } else {
              $sum = 0;
              $data['total_num_paid'] = $sum;
              $data['total_paid'] = number_format($sum,0,',','.');
              $data['total_num_paid_sum'] = $data['total_price'];
              $data['total_paid_sum'] = number_format($data['total_price'],0,',','.');
            }
          }
          
          $data['created_at'] = date("d F Y", strtotime($data['created_at']));
          $data['due_date'] = date("d F Y", strtotime($data['due_date']));
        }
        $datas['data'] = $dataCartDokter;
        $pdf = PDF::loadView('printAll', ['data' => $datas]);
    
        return $pdf->download($datas['dokter']['name'] . " all transaksi" . ".pdf");
    }
}
