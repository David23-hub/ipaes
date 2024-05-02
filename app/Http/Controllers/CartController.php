<?php

namespace App\Http\Controllers;
use App\Models\InvoiceNumberModel;
use App\Models\NotifModel;
use App\Models\PackageModel;
use App\Models\CartModel;
use App\Models\CategoryProductModel;
use App\Models\DokterModel;
use App\Models\ItemModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DateTime;

class CartController extends Controller
{
    private $model;
    private $bundle;

    private $itemPackage;

    private $cart;
    private $modelCategoryProduct;
    private $doctorModel;

    private $notif;

    private $stockController;
    private $invNoModel;

    
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(function ($request, $next) {
            $role = auth()->user()->role;
                if($role!="superuser"&&$role!="marketing"){
                    abort(403, 'Unauthorized access');
                }
            return $next($request);
        });
        
        $this->model = new ItemModel;
        $this->bundle = new PackageModel;

        $this->itemPackage = new PackageModel;

        $this->cart = new CartModel;
        
        $this->modelCategoryProduct = new CategoryProductModel;

        $this->doctorModel = new DokterModel;
        $this->notif = new NotifModel;

        $this->stockController = new StockController;
         $this->invNoModel = new InvoiceNumberModel;
        
    }

    public function index()
    {
        $category = $this->modelCategoryProduct->GetListActive();
        $dokter = $this->doctorModel->GetListActive(Auth::user()->name,Auth::user()->role);
        $items = $this->model->GetListActive();
        $itemsBundle = $this->itemPackage->GetListActive();
        $cartsUser = $this->cart->GetCart(Auth::user()->email);
        
        $user = auth()->user();
        
        $cart=[];
        $resCart = [];
        $total = 0;
        if(count($cartsUser)==0){
            return view('master.cart')->with('idCart', "0")->with('category', $category)->with('dokter', $dokter)->with('cart', $resCart)->with('total', $total)->with('user', $user);
        }
        $cartUser = $cartsUser[0];


        if (strlen($cartUser->cart)!=0){
            $carts = explode(",", $cartUser->cart);
            foreach ($carts as $cartItem) {
                $temp = explode("|", $cartItem);
                if ($temp[1]=="product"){
                    foreach ($items as $item) {
                        if($temp[0]==$item["id"]){
                            $cart["name_product"]=$item["name"];
                            $cart["price_product"]=$temp[4];
                            break;
                        }
                    }

                    $cart["qty"]=$temp[2];
                    $cart["disc"]=$temp[3];
                    $price = $cart["price_product"]*$temp[2];
                    $disc = $price*($temp[3]/100);
                    $cart["price"]=number_format($price,0,',','.');
                    $cart["disc_price"]=number_format($disc,0,',','.');;
                    $cart["total_price"]=number_format($price-$disc,0,',','.');
                    $cart["prod_id"]=$temp[0];
                    $cart["type"]="product";
                    $cart["price_product"]=number_format($cart["price_product"],0,',','.');
                    $total+=$price-$disc;
                    array_push($resCart, $cart);
                }else if ($temp[1]=="paket"){
                    foreach ($itemsBundle as $item) {
                        if($temp[0]==$item["id"]){
                            $cart["name_product"]=$item["name"];
                            $cart["price_product"]=$temp[4];
                            break;
                        }
                    }

                    $cart["qty"]=$temp[2];
                    $cart["disc"]=$temp[3];
                    $price = $cart["price_product"]*$temp[2];
                    $disc = $price*($temp[3]/100);
                    $cart["price"]=number_format($price,0,',','.');
                    $cart["disc_price"]=number_format($disc,0,',','.');;
                    $cart["prod_id"]=$temp[0];
                    $cart["total_price"]=number_format($price-$disc,0,',','.');
                    $cart["type"]="paket";
                    $cart["price_product"]=number_format($cart["price_product"],0,',','.');

                    $total+=$price-$disc;
                    array_push($resCart, $cart);
                }

            }
            
        }
        return view('master.cart')->with('idCart', $cartUser["id"])->with('category', $category)->with('dokter', $dokter)->with('cart', $resCart)->with('total', number_format($total,0,',','.'))->with('user', $user);
    }

    public function addPO(Request $request){
        $input = $request->all();

        

        if($input["id_cart"]==0 || $input["id_cart"]==""){
            return "Empty Cart!";
        }

        if($input["id_doctor"]=="" || $input["id_doctor"]=="kosong"){
            return "Select The Doctor Please!";
        }

        if ($input['management_order']!="1"){
            $input['management_order']="0";
        }
        
        $invNo = $this->invNoModel->GetNumber();
        $time_api_url = 'http://worldtimeapi.org/api/timezone/Asia/Jakarta';

        // Make a GET request to fetch the time data
        $response = file_get_contents($time_api_url);

        // Decode the JSON response
        $time_data = json_decode($response, true);

        // Extract the current time from the response
        $current_time = $time_data['datetime'];
        $datetime = new DateTime($current_time);

        // Get the month from the DateTime object
        $month = intVal($datetime->format('m'));


        $no = $invNo['counting'];

        if($invNo['month']==$month){
            $no++;
            
        }else{
            $no=1;
        }
        $inv = [
            'counting'=>$no,
            'month' => $month,
        ];
        $this->invNoModel->UpdateInvoiceNumber($inv,$invNo['month']);

        $current_time = time();

        // Add 7 days to the current timestamp
        $new_time = strtotime('+'.$input["due_date"]. 'days', $current_time);

        // Format the new time as a readable date/time string
        $new_time_formatted = date('Y-m-d 23:59:59', $new_time);

        $po_id= "PO/".date('Y', $new_time)."/".date('mdHis', $new_time);
        
        $inv_no = "INV/".$datetime->format('m')."/".str_pad($no, 5, "0", STR_PAD_LEFT);


        $data = [
            'po_id'=>$po_id,
            'inv_no'=>$inv_no,
            'management_order' => $input['management_order'],
            'notes' => $input['notes_form'],
            'doctor_id' => $input['id_doctor'],
            'due_date' => $new_time_formatted,
            'status' => "0", 
            'updated_by' => Auth::user()->email,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $result = "";
        try {
            $products = [];
            $carts = $this->cart->GetItemWithoutEmail($input['id_cart']);
            $cart = explode(",",$carts[0]["cart"]);
            $date = date('Y-m-d H:i:s');

            foreach ($cart as $value) {
                $temp = explode("|",$value);
                if($temp[1]=="product"){
                    $obj = [];
                    $obj["id_product"] = $temp[0];
                    $obj['stock_out'] = $temp[2];
                    $obj['cart_id'] = $input["id_cart"];
                    $obj['status'] = "1";
                    $obj['desc'] = "Dari Pesanan PO ".$po_id;
                    $obj['created_at'] = $date;
                    array_push($products, $obj);
                }else if($temp[1]=="paket"){
                    $listProd = $this->bundle->GetItem($value[0]);
                    $tempProd = explode(",",$listProd[0]["product"]);
                    foreach ($tempProd as $valuePackage) {
                        $temp = explode("|",$valuePackage);
                        $obj = [];
                        $obj["id_product"] = $temp[1];
                        $obj['stock_out'] = $temp[0];
                        $obj['cart_id'] = $input["id_cart"];
                        $obj['status'] = "1";
                        $obj['desc'] = "Dari PAKET ".$listProd[0]["name"]." Pesanan PO ".$po_id;
                        $obj['created_at'] = $date;
                        array_push($products, $obj);
                    }
                }
            }



            $tempObj = [];
            foreach ($products as $key => $value) {
                # code...
                if(isset($tempObj[$value['id_product']])) {
                    $tempObj[$value['id_product']] += $value['stock_out'];
                } else {
                    $tempObj[$value['id_product']] = (int)$value['stock_out'];
                }
            }

            $indexArray = array_keys($tempObj);

            $itemStocks = $this->model->GetListCheckStock($indexArray);
            
            foreach ($itemStocks as $key => $value) {
                if($value['deleted_by']!=null){
                    return "Product ".$value['name']. " Tidak Ditemukan";
                }else if($value['status']!=1){
                    return "Product ".$value['name']. " Tidak Aktif";
                }else if($value['qty']<$tempObj[$value['id']]){
                    return "Stock ".$value['name']." Tidak Cukup.";
                }
            }

            $temp = $this->cart->UpdateItem($input["id_cart"],$data);
            if($temp){
                $result="sukses";
            }else{
                $result="gagal";
                return $result;
            }

            return $this->stockController->insert($products,"1");

        } catch (\Throwable $th) {
            $result="gagal";
        }


        // ADD NOTIF DATA
        // $notif = [
        //     'msg'=>$po_id." Has Been Create By ".Auth::user()->name,
        //     'created_by' => Auth::user()->email,
        //     'created_at' => date('Y-m-d H:i:s')
        // ];
        // $this->notif->AddItem($notif);

        return $result;

    }

}
