<?php

namespace App\Http\Controllers;

use App\Models\CartModel;
use App\Models\CategoryProductModel;
use App\Models\ItemModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ListProductController extends Controller
{
    private $model;
    private $cartDetail;
    private $modelCategoryProduct;
    public function __construct()
    {
        $this->middleware('auth');
        $this->model = new ItemModel;

        $this->cartDetail = new CartModel;
        
        $this->modelCategoryProduct = new CategoryProductModel;
        
    }

    public function index()
    {
        // $data = $this->model->GetList();

        $category = $this->modelCategoryProduct->GetListActive();
        $product = $this->model->GetListActive();
        
        $email = Auth::user()->email;
        $cartsUser = $this->cartDetail->GetCart($email);
        

        $productVal=[];
        $resProduct = [];
        $bool = false;
        if (count($cartsUser)==0){
            foreach ($product as  $productVal) {
                $productVal['qty_cart'] = '';
                $productVal['disc_cart'] = '';
                array_push($resProduct,$productVal);
            }
            return view('master.listProduct')->with('category', $category)->with('product', $resProduct)->with('resProduct', $resProduct);
        }
        $cartUser = $cartsUser[0];

        foreach ($product as  $productVal) {
            if (strlen($cartUser->cart)!=0){
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
                array_push($resProduct,$productVal);
            }
        }

        return view('master.listProduct')->with('category', $category)->with('product', $resProduct)->with('resProduct', $resProduct);
    }

    public function addCartDetail(Request $request){
        $input = $request->all();

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
                        if($temp[0]==$input["id"]){
                            if($temp[2]!=$input['qty']){
                                $temp[2] = $temp[2]+$input['qty'];
                            }
                            $temp[3] = $input['disc'];
                            $flag=true;
                        }
                        $res .= $temp[0] . "|" . $temp[1] . "|" . $temp[2] . "|" . $temp[3] . ",";
                    }
                    $len = strlen($res) - 1; 
                    $res = substr($res, 0, $len);
                }

                if(!$flag && $res!=""){
                    $res = $res."," . $input['id']."|".$input["category"]."|".$input["qty"]."|".$input["disc"];
                }else if(!$flag){
                    $res = $res . $input['id']."|".$input["category"]."|".$input["qty"]."|".$input["disc"];
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
                            $temp[2] = $temp[2]+$input['qty'];
                            $temp[3] = $input['disc'];
                            $flag=true;
                        }
                        $res .= $temp[0] . "|" . $temp[1] . "|" . $temp[2] . "|" . $temp[3] . ",";
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

        
        $res = $res . $input['id']."|".$input["category"]."|".$input["qty"]."|".$input["disc"];
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
                $result="sukses_update";
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
                $result="sukses_update";
            }else{
                $result="gagal";
            }
        } catch (\Throwable $th) {
            $result="gagal";
        }        

        return $result;
    }

}