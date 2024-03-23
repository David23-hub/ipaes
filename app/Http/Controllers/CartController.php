<?php

namespace App\Http\Controllers;

use App\Models\NotifModel;
use App\Models\PackageModel;
use App\Models\CartModel;
use App\Models\CategoryProductModel;
use App\Models\DokterModel;
use App\Models\ItemModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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

    
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(function ($request, $next) {
            $role = auth()->user()->role;
            if($role!="superuser"&&$role!="admin"&&$role!="marketing"){
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
        
    }

    public function index()
    {
        
        $category = $this->modelCategoryProduct->GetListActive();
        $dokter = $this->doctorModel->GetListActive();
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

        $current_time = time();

        // Add 7 days to the current timestamp
        $new_time = strtotime('+'.$input["due_date"]. 'days', $current_time);

        // Format the new time as a readable date/time string
        $new_time_formatted = date('Y-m-d H:i:s', $new_time);

        $po_id= "PO/".date('Y', $new_time)."/".date('mdHis', $new_time);

        $data = [
            'po_id'=>$po_id,
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
            $temp = $this->cart->UpdateItem($input["id_cart"],$data);
            if($temp){
                $result="sukses";
            }else{
                $result="gagal";
                return $result;
            }
            
            $products = [];
            $carts = $this->cart->GetItemWithoutEmail($input['id_cart']);
            $cart = explode(",",$carts[0]["cart"]);
            foreach ($cart as $value) {
                $temp = explode("|",$value);
                if($temp[1]=="product"){
                    $obj = [];
                    $obj["id_product"] = $temp[0];
                    $obj['stock_out'] = $temp[2];
                    $obj['cart_id'] = $input["id_cart"];
                    $obj['desc'] = "Dari Pesanan PO ".$po_id;
                    $obj['created_at'] = date('Y-m-d H:i:s');
                    array_push($products, $obj);
                }else if($temp[1]=="paket"){
                    $listProd = $this->bundle->GetItem($value[0]);
                    $tempProd = explode(",",$listProd[0]["product"]);
                    foreach ($tempProd as $valuePackage) {
                        $temp = explode("|",$valuePackage);
                        $obj = [];
                        $obj["id_product"] = $temp[0];
                        $obj['stock_out'] = $temp[1];
                        $obj['cart_id'] = $input["id_cart"];
                        $obj['desc'] = "Dari PAKET ".$listProd[0]["name"]." Pesanan PO ".$po_id;
                        $obj['created_at'] = date('Y-m-d H:i:s');
                        array_push($products, $obj);
                    }
                }
            }
        
            return $this->stockController->insert($products);

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
