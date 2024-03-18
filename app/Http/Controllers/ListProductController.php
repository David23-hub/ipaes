<?php

namespace App\Http\Controllers;

use App\Models\CartModel;
use App\Models\CategoryProductModel;
use App\Models\ItemModel;
use App\Models\PackageModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ListProductController extends Controller
{
    private $model;
    private $itemPackage;
    private $cartDetail;
    private $modelCategoryProduct;
    public function __construct()
    {
        $this->middleware('auth');
        $this->model = new ItemModel;

        $this->itemPackage = new PackageModel;

        $this->cartDetail = new CartModel;
        
        $this->modelCategoryProduct = new CategoryProductModel;
        
    }

    public function index()
    {
        // $data = $this->model->GetList();

        $category = $this->modelCategoryProduct->GetListActive();
        $product = $this->model->GetListActive();
        $productBundle = $this->itemPackage->GetListActive();
        
        $email = Auth::user()->email;
        $cartsUser = $this->cartDetail->GetCart($email);
        

        $productVal=[];
        $resProduct = [];
        $resProductBundle = [];
        $bool = false;

        //if no item on cart
        if (count($cartsUser)==0){
            foreach ($product as  $productVal) {
                $productVal['qty_cart'] = '';
                $productVal['disc_cart'] = '';
                $productVal['priceNum'] = $productVal['price'];
                array_push($resProduct,$productVal);
            }
            foreach ($productBundle as  $value) {
                $value['qty_cart'] = '';
                $value['disc_cart'] = '';
                $resProductBundle['priceNum'] = $value['price'];
                array_push($resProductBundle,$value);
            }
            return view('master.listProduct')->with('category', $category)->with('product', $resProduct)->with('bundle',$resProductBundle);
        }

        $cartUser = $cartsUser[0];

        //add list item for each product
        foreach ($product as  $productVal) {
                $bool = false;

                $carts = explode(",", $cartUser->cart);
                foreach ($carts as $cartItem) {
                    $temp = explode("|", $cartItem);
                    if ($productVal["id"] == $temp[0] && $temp[1] == "product"){
                        $bool = true;
                        $productVal['qty_cart'] = $temp[2];
                        $productVal['disc_cart'] = $temp[3];
                        break;
                    }   
                }
                if(!$bool){
                    $productVal['qty_cart'] = '';
                    $productVal['disc_cart'] = '';
                }
                $productVal['priceNum']=$productVal["price"];
                $productVal['price']=number_format($productVal["price"],0,',','.');
                array_push($resProduct,$productVal);
        }

        //add list item for bundle
        foreach ($productBundle as  $productVal) {
                $bool = false;

                $carts = explode(",", $cartUser->cart);
                foreach ($carts as $cartItem) {
                    $temp = explode("|", $cartItem);
                    if ($productVal["id"] == $temp[0] && $temp[1] == "paket"){
                        $bool = true;
                        $productVal['qty_cart'] = $temp[2];
                        $productVal['disc_cart'] = $temp[3];
                        break;
                    }   
                }
                if(!$bool){
                    $productVal['qty_cart'] = '';
                    $productVal['disc_cart'] = '';
                }
                $productVal['unit'] = "Package";
                $productVal['priceNum']=$productVal["price"];
                $productVal['price']=number_format($productVal["price"],0,',','.');
                array_push($resProductBundle,$productVal);
        }

        return view('master.listProduct')->with('category', $category)->with('product', $resProduct)->with('bundle',$resProductBundle);
    }

    public function addCartDetail(Request $request){
        $input = $request->all();

        if (!preg_match('/^[0-9]+$/', $input["qty"])) {
            return "Kuantity Barang Harus Diisi!";
        }else if (!preg_match('/^[0-9]+$/', $input["disc"]) && $input["disc"]!="") {
            return "Diskon Harus Diisi!";
        }

        if ($input['disc']>100){
            $res="gagal";
            return $res;
        }else if ($input['disc']=="" || $input['disc']<0){
            $input['disc']=0;
        }

        $email=Auth::user()->email;

        $cartRes = $this->cartDetail->GetCart($email);
        $flag = false;
        $res = "";
        if(count($cartRes)!=0){
            $cartTemp = $cartRes[0];
            if($input['qty']!=0){
                if ($cartTemp->cart!=""){
                    $items = explode(",", $cartTemp->cart);
                    foreach ($items as $item) {
                        $temp = explode("|", $item);
                        if($temp[0]==$input["id"]&& $temp[1]==$input['category']){
                            if($temp[2]!=$input['qty']){
                                $temp[2] = $input['qty'];
                            }
                            $temp[3] = $input['disc'];
                            $flag=true;
                        }
                        $res .= $temp[0] . "|" . $temp[1] . "|" . $temp[2] . "|" . $temp[3]."|".$temp[4] . ",";
                    }
                    $len = strlen($res) - 1; 
                    $res = substr($res, 0, $len);
                }

                if(!$flag && $res!=""){
                    $res = $res."," . $input['id']."|".$input["category"]."|".$input["qty"]."|".$input["disc"]."|".$input['price'];
                }else if(!$flag){
                    $res = $res . $input['id']."|".$input["category"]."|".$input["qty"]."|".$input["disc"]."|".$input['price'];
                }
                return $this->updateCart($cartTemp["id"],$res);


            }else if($input['qty']==0){
                //delete item on cart
                if ($cartTemp->cart!=""){
                    $items = explode(",", $cartTemp->cart);
                    foreach ($items as $item) {
                        $temp = explode("|", $item);

                        if($temp[0]==$input["id"] && $input['qty']<=0){
                            continue;
                        }
                        if($temp[0]==$input["id"]){
                            $temp[2] = $input['qty'];
                            $temp[3] = $input['disc'];
                            $flag=true;
                        }
                        $res .= $temp[0] . "|" . $temp[1] . "|" . $temp[2] . "|" . $temp[3]."|".$temp[4] . ",";
                    }
                    $len = strlen($res) - 1; 
                    $res = substr($res, 0, $len);
                }
                
                if(strlen($res)==0){
                    $res = "";
                }

                return $this->updateCart($cartTemp["id"],$res);
            }
        }

        
        $res = $res . $input['id']."|".$input["category"]."|".$input["qty"]."|".$input["disc"]."|".$input["price"];
        $data = [
            'cart'=>$res,
            
            'created_by' => $email,
            'created_at' => date('Y-m-d H:i:s')
        ];


        $result = "";
        try {
            $temp = $this->cartDetail->AddItem($data);
            if($temp){
                $result="sukses";
            }else{
                $result="gagal1";
            }
        } catch (\Throwable $th) {
            $result="gagal2";
        }        

        return $result;
    }

    public function update(Request $request){
        $input = $request->all();

        $tempProd = "";

        $products = explode(',',$input["data"]);
        foreach ($products as $value) {
            $temp = explode('|', $value);
            if($temp[2]<=0){
                continue;
            }
            $tempProd.=$value.",";
        }
        


        $res = $this->updateCart($input["id"], substr($tempProd,0,strlen($tempProd)-1));
        return $res;
    }

    public function updateCart($id, $cart){
        $data = [
            'cart'=>$cart,

            'updated_by' => Auth::user()->email,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // var_dump($id, $disc, $qty);

        $result = "";
        try {
            $temp = $this->cartDetail->UpdateItem($id,$data);
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

    public function updateItem($id, $disc, $qty){

        $data = [
            'disc'=>$disc,
            'qty' => $qty,

            'updated_by' => Auth::user()->email,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // var_dump($id, $disc, $qty);

        $result = "";
        try {
            $temp = $this->cartDetail->UpdateItem($id,$data);
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

}
