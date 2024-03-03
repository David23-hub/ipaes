<?php

namespace App\Http\Controllers;

use App\Models\CartModel;
use App\Models\CategoryProductModel;
use App\Models\DokterModel;
use App\Models\ItemModel;
use App\Models\EkspedisiModel;
use App\Models\ExtraChargeModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ListPOController extends Controller
{
    private $model;
    private $cart;
    private $modelCategoryProduct;
    private $doctorModel;
    private $ekspedisi;
    private $extra_charge;
    
    public function __construct()
    {
        $this->middleware('auth');
        $this->model = new ItemModel;

        $this->cart = new CartModel;
        
        $this->modelCategoryProduct = new CategoryProductModel;

        $this->doctorModel = new DokterModel;
        $this->ekspedisi = new EkspedisiModel;
        $this->extra_charge = new ExtraChargeModel;
        
    }

    public function index()
    {
        $dataDokter = $this->doctorModel->GetList();
        $dataTransaction = $this->cart->GetListAll();
        foreach ($dataDokter as $valueDokter) {
          $total = 0;
          foreach ($dataTransaction as $valueTransaction) {
            if($valueDokter['id'] == $valueTransaction['doctor_id']) {
              $total++;
            }
          }
          $valueDokter['total_transaction'] = $total;
        }
        return view('master.listPO')->with('data', $dataDokter);
    }

    public function getAll()
    {
        $dataDokter = $this->doctorModel->GetList();
        $dataTransaction = $this->cart->GetListAll();
        foreach ($dataDokter as $valueDokter) {
          $total = 0;
          foreach ($dataTransaction as $valueTransaction) {
            if($valueDokter['id'] == $valueTransaction['doctor_id']) {
              $total++;
            }
          }
          $valueDokter['total_transaction'] = $total;
        }
        return $dataDokter;
    }

    public function detailPOIndex(string $id) {
        try {
            $dataCartDokter = $this->cart->GetListJoinDoctorWithDoctorId($id);
            $dokter = $this->doctorModel->SingleItem($id);
            $items = $this->model->GetListActive();
            $dataEkspedisi = $this->ekspedisi->GetList();
            $extraChargeAll = $this->extra_charge->GetListAll();
            $user = auth()->user();

            foreach ($dataCartDokter as $data) {
              $totalan = 0;
              $products = [];
              $extraChargeOne = [];

              if (strlen($data->cart)!=0){

                $carts = explode(",", $data->cart);
                // array product
                foreach ($carts as $valueCart) {
                  $temp = explode("|", $valueCart);
                  foreach ($items as $item) {
                    if($temp[0]==$item["id"]){
                      $product["name_product"]=$item["name"];
                      $product["price_product"]=$item["price"];
                      break;
                    }                      
                  }
                  
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
                    $totalan += $valueExtra['price'];
                    $valueExtra['price'] = number_format($valueExtra["price"],0,',','.');
                    array_push($extraChargeOne, $valueExtra);
                  }
                }
                $totalan = ceil($totalan);
                $data['total_price'] = $totalan;
                $data['total'] = number_format($totalan,0,',','.');
                $data['extra_charge'] = $extraChargeOne;
              } 
            }
            return view('master.detailPO')->with('dokter', $dokter)->with('user', $user)->with('dataEkspedisi', $dataEkspedisi)->with('dataCartDokter', $dataCartDokter)->with('extraChargeAll', $extraChargeAll);
            // return $dataCart;
        }catch(\Throwable $th) {
            Log::error("error di throwable");
            Log::error($th);
        }
            // return view('master.detailPO');
    }

    public function addPO(Request $request){
        $input = $request->all();

        if($input["id_cart"]==0 || $input["id_cart"]==""){
            return "Empty Cart!";
        }

        if($input["id_doctor"]==""){
            return "Select The Doctor Please!";
        }

        if ($input['management_order']!="1"){
            $input['management_order']="0";
        }

        $current_time = time();

        // Add 7 days to the current timestamp
        $new_time = strtotime('+'.$input["due_date"]. 'days', $current_time);

        // Format the new time as a readable date/time string
        $new_time_formatted = date('Y-m-d H:i:s', $new_time);

        $data = [
            'management_order' => $input['management_order'],
            'notes' => $input['notes_form'],
            'doctor_id' => $input['id_doctor'],
            'due_date' => $new_time_formatted,

            'updated_by' => Auth::user()->email,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $result = "";
        try {
            $temp = $this->cart->UpdateItem($input["id_cart"],$data);
            if($temp){
                $result="sukses";
            }else{
                $result="gagal";
            }
        } catch (\Throwable $th) {
            $result="gagal";
        }        

        return $result;

    }
   

    public function getListAllCart(Request $request) {
        try {
            $dataCart = $this->cart->GetListJoinDoctor();
            foreach($dataCart as $key => $cart) {
                // Convert the string to a Unix timestamp
                $timestamp = strtotime($cart->created_at);

                // Format the timestamp using the desired format
                $formattedDate = date("j F Y", $timestamp);
                $cart->created_at = $formattedDate;

                // Convert the string to a Unix timestamp
                $timestamp = strtotime($cart->due_date);

                // Format the timestamp using the desired format
                $formattedDate = date("d F Y", $timestamp);
                $cart->due_date = $formattedDate;
            }
            return $dataCart;
        }catch(\Throwable $th) {
            Log::error("error di throwable");
            Log::error($th);
        }
    }

    public function canceledOrder(Request $request) {
        try {
            $input = $request->all();
            $input['data']['cancel_by'] = Auth::user()->name;
            $input['data']['cancel_at'] = date('Y-m-d H:i:s');
            $this->cart->UpdateItem($input['data']['id'], $input['data']);
            return "sukses";
        }catch(\Throwable $th) {
            Log::error("error di throwable");
            Log::error($th);
            return "gagal";
        }
    }

    public function packingOrder(Request $request) {
        try {
            $input = $request->all();
            $input['data']['packing_by'] = Auth::user()->name;
            $input['data']['packing_at'] = date('Y-m-d H:i:s');
            $this->cart->UpdateItem($input['data']['id'], $input['data']);
            return "sukses";
        }catch(\Throwable $th) {
            Log::error("error di throwable");
            Log::error($th);
            return "gagal";
        }
    }

    public function sentOrder(Request $request) {
        try {
            $input = $request->all();
            $input['data']['sent_by'] = Auth::user()->name;
            $input['data']['sent_at'] = date('Y-m-d H:i:s');
            $this->cart->UpdateItem($input['data']['id'], $input['data']);
            return "sukses";
        }catch(\Throwable $th) {
            Log::error("error di throwable");
            Log::error($th);
            return "gagal";
        }
    }

    public function updateStatus(Request $request) {
        try {
            $input = $request->all();
            $this->cart->UpdateItem($input['data']['id'], $input['data']);
            return "sukses";
        }catch(\Throwable $th) {
            Log::error("error di throwable");
            Log::error($th);
            return "gagal";
        }
    }

    public function paymentOrder(Request $request) {
        try {
            $input = $request->all();
            $input['data']['paid_at'] = strtotime($input['data']['paid_at']);
            $input['data']['paid_at'] = date('Y-m-d H:i:s', $input['data']['paid_at']);
            $input['data']['paid_by'] = Auth::user()->name;
            $this->cart->UpdateItem($input['data']['id'], $input['data']);
            return "sukses";
        }catch(\Throwable $th) {
            Log::error("error di throwable");
            Log::error($th);
            return "gagal";
        }
    }

    public function addExtraCharge(Request $request) {
        try {
          $input = $request->all();
          $data['transaction_id'] = $input['data']['transaction_id'];
          $data['description'] = $input['data']['description'];
          $data['price'] = $input['data']['price'];
          $data['created_at'] = date('Y-m-d H:i:s');
          $data['created_by'] = Auth::user()->name;
          $data['updated_at'] = date('Y-m-d H:i:s');
          $data['updated_by'] = Auth::user()->name;
          $this->extra_charge->AddItem($data);
          $result['message'] = "sukses";
          $result['price'] = number_format($data["price"],0,',','.');
          return $result;
        }catch(\Throwable $th) {
            Log::error("error di throwable");
            Log::error($th);
            return "gagal";
        }
    }
}

/***
 *       <div class="card-header">
        <div class="container">
          <div class="row">
            <div class="col align-self-start">
            </div>
            <div class="col-8 align-self-center">

            </div>
            <div class="col align-self-end">
              <button class="btn btn-primary">
                Print
              </button>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-6">
            <div>
              <p class="text-start">PO Number</p>
              <p class="text-start">{{ $dataCart[0]->po_id }}</p>
            </div>
          </div>
          <div class="col-6">
            <div>
              <p class="text-start">Created Purchase Order at</p>
              <p class="text-start">{{ $dataCart[0]->created_at }}</p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-6">
            <div>
              <p class="text-start">Invoice Number</p>
              <p class="text-start">{{ $dataCart[0]->po_id }}</p>
            </div>
          </div>
          <div class="col-6">
            <div>
              <p class="text-start">Due Date</p>
              <p class="text-start">{{ $dataCart[0]->due_date }}</p>
            </div>
          </div>
        </div>
        <div class="row d-flex justify-content-end">
          <div class="col-6">
            <div>
              <p class="text-start">Created By</p>
              <p class="text-start">{{ $dataCart[0]->created_by }}</p>
            </div>
          </div>
        </div>
      </div>
 * 
 * 
 * 
 * <div class="col">
        <div class="card">
          <div class="card-body">
            <h5 style="font-weight: 600">Doctor</h5>

            <ul class="list-group list-group-flush">
              <li class="list-group-item">
                <p id="name_doc">{{ $dataCart[0]->name }}</p>
              </li>
              <li class="list-group-item">Clinic
                <p id="clinic_doc">{{ $dataCart[0]->clinic }}</p>
              </li>
              <li class="list-group-item">Billing Phone
                <p id="billing_phone_doc">{{ $dataCart[0]->billing_no_hp }}</p>
              </li>
              <li class="list-group-item">Doctor Phone
                <p id="no_hp_doc">{{ $dataCart[0]->no_hp }}</p>
              </li>
              <li class="list-group-item">Address
                <p id="address_doc">{{ $dataCart[0]->address }}</p>
              </li>
              <li class="list-group-item">Doctor Information
                <p id="information_doc">{{ $dataCart[0]->information }}</p>
              </li>
            </ul>
          </div>
        </div>
      </div>
 */