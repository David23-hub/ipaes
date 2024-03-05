<?php

namespace App\Http\Controllers;

use App\Models\CartModel;
use App\Models\ExtraChargeModel;
use App\Models\ItemModel;
use App\Models\PackageModel;
use Illuminate\Http\Request;

class SalesReportController extends Controller
{
    private $model;
    private $item;
    private $bundle;
    private $extraCharge;
    public function __construct()
    {
        $this->middleware('auth');
        $this->model = new CartModel;
        $this->item = new ItemModel;
        $this->bundle = new PackageModel;
        $this->extraCharge = new ExtraChargeModel;
    }

    public function index()
    {
        return view('master.salesReport');
    }

    public function getAll(Request $request){

        $input = $request->all();

        $products = $this->item->GetAll();
        $bundle=$this->bundle->GetAll();
        $data = $this->model->GetListJoinDoctorAndDate($input["startDate"],$input["endDate"]);
        
        
        $carts = explode(",", $data[0]->cart);
        
        $count=0;

        foreach ($data as $value) {
            $product = "";
            $qty = "";
            $disc = "";
            $price="";
            $extraVal = 0;
            $extra = "";
            $carts = explode(",", $value->cart);
            $i=0;
            $total =0;
            foreach ($carts as $cart) {
                $items = explode("|", $cart);
                $i++;
                $tempPrice="";
                if($items[1]=="product"){
                    foreach ($products as $valueProd) {
                        if($valueProd["id"]==$items[0]){
                            $items[0]=$valueProd["name"];
                            $tempPrice = $valueProd["price"];
                            break;
                        }
                    }
                }else if($items[1]=="paket"){
                    foreach ($bundle as $valueBundle) {
                        if($valueBundle["id"]==$items[0]){
                            $items[0]=$valueBundle["name"];
                            $tempPrice = $valueBundle["price"];
                            break;
                        }
                    }
                }

                

                if($i==count($carts)){
                    $product .= $items[0];
                    $qty .= $items[2];
                    $disc .= $items[3]."%";
                    $price .= "IDR ".$tempPrice;
                }else{
                    $product .= $items[0].'<hr class="split-line">';
                    $qty .= $items[2].'<hr class="split-line">';
                    $disc .= $items[3]."%".'<hr class="split-line">';
                    $price .= "IDR ".$tempPrice.'<hr class="split-line">';
                }
                

                if($items[3]!=0){
                    $total += ($tempPrice *$items[2] * $items[3])/100;
                }else{
                    $total +=$tempPrice*$items[2];
                }


            }

            $extras = $this->extraCharge->GetList($value["id"]);
            $i=0;
            foreach ($extras as $extraValue) {
                $i++;
                if($i==count($extras)){
                    $extraVal += $extraValue["price"];
                    $extra .= "IDR ".$extraValue["price"];
                }else{
                    $extraVal += $extraValue["price"];
                    $extra .= "IDR ".$extraValue["price"].'<hr class="split-line">';
                }
            }            

            $total += $extraVal;
            $data[$count]["product"]=$product;
            $data[$count]["qty"]=$qty;
            $data[$count]["disc"]=$disc;
            $data[$count]["price"]=$price;
            $data[$count]["extras"]="IDR ".$extraVal;
            $data[$count]["revenue"]="IDR ".($total-$value["shipping_cost"]);
            $data[$count]["total"]="IDR ".($total);

            $count++;
        }
        

        return $data;
    }

}
