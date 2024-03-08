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

        if(count($data)==0){
            return "KOSONG";
        }
        
        
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
            $incentiveIdr=0;
            
            // loop for get item name,qty,disc,total,revenue
            foreach ($carts as $cart) {
                $items = explode("|", $cart);
                $i++;
                $tempPrice="";
                $tempCommisionRate = 0;

                if($items[1]=="product"){
                    foreach ($products as $valueProd) {
                        if($valueProd["id"]==$items[0]){
                            $items[0]=$valueProd["name"];
                            $tempPrice = $valueProd["price"];
                            $tempCommisionRate=$valueProd["commision_rate"];
                            break;
                        }
                    }
                }else if($items[1]=="paket"){
                    foreach ($bundle as $valueBundle) {
                        if($valueBundle["id"]==$items[0]){
                            $items[0]=$valueBundle["name"];
                            $tempPrice = $valueBundle["price"];
                            $tempCommisionRate=$valueProd["commision_rate"];
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
                    $tempTotal = $tempPrice *$items[2] * ((100-$items[3])/100);
                    $total += $tempTotal;
                }else{
                    $tempTotal = $tempPrice*$items[2];
                    $total += $tempTotal;
                }

                $incentiveIdr += ($tempTotal * $tempCommisionRate)/100;


            }

            //loop for extra charge
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

            //loop for payment step
            $payments = explode("|", $value->paid_at);
            $stepPayment = "";
            $i=0;
            $counter=0;
            //if there's only 1 payment
            if(count($payments)!=0){
                $nominals = explode("|", $value->nominal);
                foreach ($payments as $pay) {
                    $i++;
                    if($i==count($payments)){
                        $stepPayment .= $pay."  =>  IDR ".$nominals[$counter];
                    }else{
                        $stepPayment .= $pay."  =>  IDR ".$nominals[$counter].'<hr class="split-line">';
                    }
                    $counter++;
                    $value["paid_at"]=$pay;
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
            $data[$count]["stepPayment"]=($stepPayment);
            $data[$count]["incentiveIdr"]="IDR ".($incentiveIdr);
            $data[$count]["incentivePerc"]=round(($incentiveIdr*100)/$total,2).' %';
            $count++;
        }
        

        return $data;
    }

}
