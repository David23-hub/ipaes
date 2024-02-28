<?php

namespace App\Http\Controllers;

use App\Models\CartModel;
use App\Models\CategoryProductModel;
use App\Models\DokterModel;
use App\Models\ItemModel;
use App\Models\EkspedisiModel;
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
    
    public function __construct()
    {
        $this->middleware('auth');
        $this->model = new ItemModel;

        $this->cart = new CartModel;
        
        $this->modelCategoryProduct = new CategoryProductModel;

        $this->doctorModel = new DokterModel;
        $this->ekspedisi = new EkspedisiModel;
        
    }

    public function index()
    {
        $dataCart = $this->cart->GetListAll();
        return view('master.listPO')->with('data', $dataCart);
    }

    public function detailPOIndex(string $id) {
        try {
            $dataCart = $this->cart->GetListJoinDoctorWithId($id);
            $dokter = $this->doctorModel->GetListActive();
            $category = $this->modelCategoryProduct->GetListActive();
            $items = $this->model->GetListActive();
            $cartsUser = $this->cart->GetItem($id, Auth::user()->email);
            $dataEkspedisi = $this->ekspedisi->GetList();
            $user = auth()->user();
            $cart=[];
            $resCart = [];
            $total = 0;
            // if(count($cartsUser)==0){
            //     return view('master.detailPO')->with('idCart', "0")->with('category', $category)->with('dokter', $dokter)->with('cart', $resCart)->with('total', $total)->with('user', $user)->with('dataCart', $dataCart);
            // }
            $cartUser = $cartsUser[0];

            if (strlen($cartUser->cart)!=0){
                $carts = explode(",", $cartUser->cart);
                foreach ($carts as $cartItem) {
                    $temp = explode("|", $cartItem);
                    foreach ($items as $item) {
                        if($temp[0]==$item["id"]){
                            $cart["name_product"]=$item["name"];
                            $cart["price_product"]=$item["price"];
                            break;
                        }
                    }
    
                    $cart["qty"]=$temp[2];
                    $cart["disc"]=$temp[3];
                    $price = $cart["price_product"]*$temp[2];
                    $disc = $price*($temp[3]/100);
                    $cart["price"]=$price;
                    $cart["disc_price"]=$disc;
                    $cart["total_price"]=$price-$disc;
                    $total+=$cart["total_price"];
                    $cart["total_price"] = number_format($cart["total_price"],0,',','.');
                    $cart["disc_price"] = number_format($cart["disc_price"],0,',','.');
                    $cart["price"] = number_format($cart["price"],0,',','.');
                    $cart["price_product"] = number_format($cart["price_product"],0,',','.');
                    array_push($resCart, $cart);
                }
            } 
            $total = number_format($total,0,',','.');
            return view('master.detailPO')->with('idCart', $cartUser["id"])->with('category', $category)->with('dokter', $dokter)->with('cart', $resCart)->with('total', $total)->with('user', $user)->with('dataCart', $dataCart)->with('dataEkspedisi', $dataEkspedisi);
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
}
