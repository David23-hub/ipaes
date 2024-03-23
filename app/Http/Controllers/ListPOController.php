<?php

namespace App\Http\Controllers;

use App\Models\CartModel;
use App\Models\CategoryProductModel;
use App\Models\DokterModel;
use App\Models\ItemModel;
use App\Models\EkspedisiModel;
use App\Models\ExtraChargeModel;
use App\Models\PackageModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ListPOController extends Controller
{
    private $model;
    private $bundle;
    private $cart;
    private $modelCategoryProduct;
    private $doctorModel;
    private $ekspedisi;
    private $extra_charge;
    
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(function ($request, $next) {
          $role = auth()->user()->role;
          if($role!="superuser"&&$role!="admin"&&$role!="marketing"&&$role!="manager"){
                  abort(403, 'Unauthorized access');
              }
          return $next($request);
        });
      
        $this->model = new ItemModel;

        $this->cart = new CartModel;
        $this->bundle = new PackageModel;
        
        $this->modelCategoryProduct = new CategoryProductModel;

        $this->doctorModel = new DokterModel;
        $this->ekspedisi = new EkspedisiModel;
        $this->extra_charge = new ExtraChargeModel;
        
    }

    public function index()
    {
        $user = auth()->user();
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
        return view('master.listPO')->with('data', $dataDokter)->with('user', $user);
    }

    public function getAll(Request $request)
    {
      $input = $request->all();
      $user = auth()->user();
      // Log::info("input", $input);
      $dateParts = explode('/', str_replace('-', '/', $input["startDate"]));

      // Rearrange the parts to form the desired format
      $formattedDateStart = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0];
  
      $dateParts = explode('/', str_replace('-', '/', $input["endDate"]));
  
      // Rearrange the parts to form the desired format
      $formattedDateEnd = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0];

      $dataTransaction = $this->cart->GetListJoinDoctorAndDateAndStatus($formattedDateStart, $formattedDateEnd, $input['status'], $user['role'], $user['email']);
      $arrayDokter = [];

      foreach ($dataTransaction as $valueTransaction) {
        // Log::info("bool", ['bolean' => !in_array($valueTransaction['doctor_id'], $arrayDokter, true)]);
        if(!in_array($valueTransaction['doctor_id'], $arrayDokter, true)) {
          array_push($arrayDokter, $valueTransaction['doctor_id']);
        }
      }

      // Log::info("array dokter", ["array" => $arrayDokter]);
      $dataDokterFilter = $this->doctorModel->GetListWhereIn($arrayDokter);
      foreach ($dataDokterFilter as $value) {
        $total = 0;
        foreach ($dataTransaction as $valueTransaction) {
          if($value['id'] == $valueTransaction['doctor_id']) {
            $total++;
          }
        }
        $value['total_transaction'] = $total;
        $value['role'] = $user['role'];
      }

      // Log::info("array dokter", ['dokter' => $dataDokterFilter]);
      // $dataDokter['sub_doctor'] = $dataDokterFilter;
      return $dataDokterFilter;
    }

    public function getAllTransaction(Request $request)
    {
      $input = $request->all();
      $user = auth()->user();
      // Log::info("input", $input);
      $dateParts = explode('/', str_replace('-', '/', $input["startDate"]));

      // Rearrange the parts to form the desired format
      $formattedDateStart = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0];
  
      $dateParts = explode('/', str_replace('-', '/', $input["endDate"]));
  
      // Rearrange the parts to form the desired format
      $formattedDateEnd = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0];

      $dataTransaction = [];
      $dataTransaction = $this->cart->GetListJoinDoctorAndDateAndStatus($formattedDateStart, $formattedDateEnd, $input['status'], $user['role'], $user['email']);

      // Log::info("array transaction", ['transaction' => $dataTransaction]);
      foreach ($dataTransaction as $valueTransaction) {
        $createdAt = explode(' ',$valueTransaction['created_at']);
        $valueTransaction['created_at'] = $createdAt[0];
        $dueDate = explode(' ',$valueTransaction['due_date']);
        $valueTransaction['due_date'] = $dueDate[0];
      }

      return $dataTransaction;
    }

    public function detailPOIndex(string $id) {
        try {
            $user = auth()->user();
            $dataCartDokter = $this->cart->GetListJoinDoctorWithDoctorIdAndEmail($id, $user['role'], $user['email']);
            $dokter = $this->doctorModel->SingleItem($id);
            $items = $this->model->getAll();
            $bundles = $this->bundle->getAll();
            $dataEkspedisi = $this->ekspedisi->GetList();
            $extraChargeAll = $this->extra_charge->GetListAll();

            foreach ($dataCartDokter as $data) {
              $totalan = 0;
              $products = [];
              $totalPaid = 0;
              $extraChargeOne = [];
              $stepPayment = [];

              if (strlen($data->cart)!=0){

                $carts = explode(",", $data->cart);
                // array product
                foreach ($carts as $valueCart) {
                  $temp = explode("|", $valueCart);

                  if($temp[1]=="product"){
                    foreach ($items as $item) {
                      if($temp[0]==$item["id"]){
                        $product["name_product"]=$item["name"];
                        // $product["price_product"]=$item["price"];
                        break;
                      }                      
                    }
                  }else if($temp[1]=="paket"){
                    foreach ($bundles as $bundle) {
                      if($temp[0]==$bundle["id"]){
                        $product["name_product"]=$bundle["name"];
                        // $product["price_product"]=$bundle["price"];
                        break;
                      }                      
                    }
                  }

                  $product['price_product'] = $temp[4];
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
                    $totalan += $valueExtra['price'];
                    $valueExtra['real_price'] = $valueExtra['price'];
                    $valueExtra['price'] = number_format($valueExtra["price"],0,',','.');
                    array_push($extraChargeOne, $valueExtra);
                  }
                }
                $totalan = ceil($totalan);
                $data['total_price'] = $totalan;
                $data['total'] = number_format($totalan,0,',','.');
                $data['shipping_cost_number'] = $data['shipping_cost'];
                $data['shipping_cost'] = number_format($data['shipping_cost'],0,',','.');
                $data['nominal_number'] = $data['nominal'];
                // $data['nominal'] = number_format($data['nominal'],0,',','.');
                $data['extra_charge'] = $extraChargeOne;

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
              
              $newDate = date('Y-m-d H:i:s');
              // $dueDate = explode(" ", $data['due_date']);
              Log::info("comparing date", [
                'boolean' => strtotime($data['due_date']) <= strtotime($newDate),
                'due_date' => $data['due_date'],
                'new_date' => $newDate
              ]);
              if(strtotime($data['due_date']) <= strtotime($newDate)) {
                $data['status'] = 4;
                $data['cancel_at'] = $data['due_date'];
                $data['cancel_by'] = "system";
                $data['cancel_reason'] = "due date is passed";
              }
              
            }
            return view('master.detailTransaction')->with('dokter', $dokter)->with('user', $user)->with('dataEkspedisi', $dataEkspedisi)->with('dataCartDokter', $dataCartDokter)->with('extraChargeAll', $extraChargeAll);
            // return $dataCart;
        }catch(\Throwable $th) {
            Log::error("error di throwable");
            Log::error($th);
        }
            // return view('master.detailPO');
    }

    public function detailTransaksiIndex(string $id) {
      try {
          $dataCartDokter = $this->cart->GetListJoinDoctorWithCartId($id);
          $dokter = $this->doctorModel->SingleItem($dataCartDokter[0]['doctor_id']);
          $items = $this->model->getAll();
          $bundles = $this->bundle->getAll();
          $dataEkspedisi = $this->ekspedisi->GetList();
          $extraChargeAll = $this->extra_charge->GetListAll();
          $user = auth()->user();

          foreach ($dataCartDokter as $data) {
            $totalan = 0;
            $products = [];
            $totalPaid = 0;
            $extraChargeOne = [];
            $stepPayment = [];

            if (strlen($data->cart)!=0){

              $carts = explode(",", $data->cart);
              // array product
              foreach ($carts as $valueCart) {
                $temp = explode("|", $valueCart);

                if($temp[1]=="product"){
                  foreach ($items as $item) {
                    if($temp[0]==$item["id"]){
                      $product["name_product"]=$item["name"];
                      // $product["price_product"]=$item["price"];
                      break;
                    }                      
                  }
                }else if($temp[1]=="paket"){
                  foreach ($bundles as $bundle) {
                    if($temp[0]==$bundle["id"]){
                      $product["name_product"]=$bundle["name"];
                      // $product["price_product"]=$bundle["price"];
                      break;
                    }                      
                  }
                }

                $product['price_product'] = $temp[4];
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
                  $totalan += $valueExtra['price'];
                  $valueExtra['real_price'] = $valueExtra['price'];
                  $valueExtra['price'] = number_format($valueExtra["price"],0,',','.');
                  array_push($extraChargeOne, $valueExtra);
                }
              }
              $totalan = ceil($totalan);
              $data['total_price'] = $totalan;
              $data['total'] = number_format($totalan,0,',','.');
              $data['shipping_cost_number'] = $data['shipping_cost'];
              $data['shipping_cost'] = number_format($data['shipping_cost'],0,',','.');
              $data['nominal_number'] = $data['nominal'];
              // $data['nominal'] = number_format($data['nominal'],0,',','.');
              $data['extra_charge'] = $extraChargeOne;

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

            $newDate = date('Y-m-d H:i:s');
              // $dueDate = explode(" ", $data['due_date']);
              Log::info("comparing date", [
                'boolean' => strtotime($data['due_date']) <= strtotime($newDate),
                'due_date' => $data['due_date'],
                'new_date' => $newDate
              ]);
              if(strtotime($data['due_date']) <= strtotime($newDate)) {
                $data['status'] = 4;
                $data['cancel_at'] = $data['due_date'];
                $data['cancel_by'] = "system";
                $data['cancel_reason'] = "due date is passed";
              }
          }
          return view('master.detailTransaction')->with('dokter', $dokter)->with('user', $user)->with('dataEkspedisi', $dataEkspedisi)->with('dataCartDokter', $dataCartDokter)->with('extraChargeAll', $extraChargeAll);
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
            $data['message'] = "sukses";
            $data['packing_by'] = $input['data']['packing_by'];
            $data['packing_at'] = $input['data']['packing_at'];
            return $data;
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
            $data['message'] = "sukses";
            $data['shipping_cost'] = number_format($input['data']['shipping_cost'],0,',','.');
            $data['sent_by'] = $input['data']['sent_by'];
            $data['sent_at'] = $input['data']['sent_at'];
            return $data;
        }catch(\Throwable $th) {
            Log::error("error di throwable");
            Log::error($th);
            return "gagal";
        }
    }

    public function updateStatus(Request $request) {
        try {
            $input = $request->all();
            $input['data']['updated_at'] = date('Y-m-d H:i:s');
            if ($input['data']['status'] == "1") {
              $input['data']['packing_at'] = date('Y-m-d H:i:s');
            } else if($input['data']['status'] == "2") {
              $input['data']['sent_at'] = date('Y-m-d H:i:s');
            }
            $this->cart->UpdateItem($input['data']['id'], $input['data']);
            $data['message'] = "sukses";
            return $data;
        }catch(\Throwable $th) {
            Log::error("error di throwable");
            Log::error($th);
            $data['message'] = "gagal";
            return $data;
        }
    }

    public function paymentOrder(Request $request) {
      try {
          $input = $request->all();
          $input['data']['paid_at'] = strtotime($input['data']['paid_at']);
          $input['data']['paid_at'] = date('Y-m-d', $input['data']['paid_at']);
          $input['data']['paid_by'] = Auth::user()->name;
          if($input['data']['status'] == 5) {
            $input['data']['paid_at'] .= "|";
            $input['data']['paid_by'] .= "|";
            $input['data']['paid_bank_name'] .= "|";
            $input['data']['paid_account_bank_name'] .= "|";
            $input['data']['nominal'] .= "|";
          } else {
            $input['data']['nominal'] = $input['total'];
          }
          $this->cart->UpdateItem($input['data']['id'], $input['data']);
          $data['message'] = "sukses";
          if($input['data']['status'] == 3) {
            // $data['nominal'] = number_format($input['data']['nominal'],0,',','.');
            $data['total_paid'] = number_format($input['total'],0,',','.');
            // $data['total_paid_sum'] = number_format($input['total'] - $input['nominal'],0,',','.');
          } else {
            $data['nominal_step'] = $input['data']['nominal'];
            $data['total_paid'] = number_format($input['nominal'],0,',','.');
            $data['total_num_paid_sum'] = $input['total'] - $input['nominal'];
            $data['total_paid_sum'] = number_format($input['total'] - $input['nominal'],0,',','.');
          }
          
          $data['paid_by'] = $input['data']['paid_by'];
          $data['paid_at'] = $input['data']['paid_at'];
          $data['paid_bank_name'] = $input['data']['paid_bank_name'];
          $data['paid_account_bank_name'] = $input['data']['paid_account_bank_name'];
          return $data;
      }catch(\Throwable $th) {
          Log::error("error di throwable");
          Log::error($th);
          return "gagal";
      }
    }

    public function stepPaymentOrder(Request $request) {
      try {
        $input = $request->all();
        $this->cart->UpdateItem($input['data']['id'], $input['data']);
        $data['message'] = "sukses";
        return $data;
      }catch(\Throwable $th) {
          Log::error("error di throwable");
          Log::error($th);

          return "gagal";
      }
    }

    public function editStepPaymentOrder(Request $request) {
      try {
        $input = $request->all();
        $this->cart->UpdateItem($input['data']['id'], $input['data']);
        $data['message'] = "sukses";
        return $data;
        return $data;
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

    public function editProduct(Request $request) {
        try {
          $input = $request->all();
          $data['extra_charge'] = $input['data']['extra_charge'];
          $this->cart->UpdateItem($input['data']['id'], $input['data']['cart']);
          $this->extra_charge->UpdatesItem($data['extra_charge']);
          $result = "sukses";
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