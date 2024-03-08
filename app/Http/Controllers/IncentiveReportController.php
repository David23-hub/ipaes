<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\CartModel;
use App\Models\ExtraChargeModel;
use App\Models\ItemModel;
use App\Models\PackageModel;
use Illuminate\Http\Request;

class IncentiveReportController extends Controller
{
    private $model;
    private $item;
    private $users;
    private $bundle;
    private $extraCharge;
    public function __construct()
    {
        $this->middleware('auth');
        $this->model = new CartModel;
        $this->users = new User;
        
        $this->item = new ItemModel;
        $this->bundle = new PackageModel;
        $this->extraCharge = new ExtraChargeModel;
    }

    public function index()
    {

        $users = $this->users->all();
        return view('master.incentiveReport')->with('users',$users);
    }

    public function getAll(Request $request){

        $input = $request->all();
        $products = $this->item->GetAll();
        $bundle=$this->bundle->GetAll();
        if($input["listUser"]!="all"){
            $marketing=implode(', ', $input["listUser"]);
        }else{
            $marketing="All";
        }

        $data = $this->model->GetListJoinDoctorAndDateWithUser($input["startDate"],$input["endDate"],$input["listUser"]);

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

        $no = 0;
        $name=$data[0]["created_by"];
        $tbldiv="";
        $tempBody="";
        foreach ($data as $value) {
            $no++;
            if ($value["created_by"]!=$name){
                $tbldiv.='<div id="'.$value["created_by"].'">'.$this->rowData($tempBody,$name,true).'</div><hr class="split-line">';

                $tempBody = "";
                $tempBody = $this->getBody($value,$no);
                $name = $value["created_by"];
            }else{
                $tempBody = $this->getBody($value, $no);
            }
        };
        $tbldiv.='<div id="'.$name.'">'.$this->rowData($tempBody,$name,true).'</div><hr class="split-line">';
        
        $res = [
            "data"=>$data,
            "tbldiv"=>$tbldiv,
            "periode"=>$input["startDate"]." - ".$input["endDate"],
            "marketing"=>$marketing,
        ];
        // dd($res);
        return $res;
    }

    private function rowData($body,$name,$flag) {
        $tbody = '<tbody><tr>'.$body.'</tr></tbody>';

        // table.append(thead).append(tbody);
        $table = "";
        if($flag){
          $table.='<h5>Marketing: <span style="font-weight: bold">'.$name.'</span></h5>';
        };
        $table .= '<table class="table table-striped table-bordered table-hover"><thead><tr><th>No</th><th>Date</th><th>Doctor Name</th><th>PO Number</th><th>Status</th><th>Product</th><th>Qty</th><th>Total Price</th><th>Incentive (%)</th><th>Incentive (IDR)</th></tr></thead><tbody>'.$tbody.'</tbody></table>';
        return $table;
  }
  
  private function getBody($data,$number) {
        $body = "";
        $body .= $this->makeBody($number).$this->makeBody($data["created_at"]).$this->makeBody($data["doctor_name"]).$this->makeBody($data["po_id"]).$this->makeBody($data["status"]).$this->makeBody($data["product"]).$this->makeBody($data["qty"]).$this->makeBody($data["total"]).$this->makeBody($data["incentivePerc"]).$this->makeBody($data["incentiveIdr"]);
        
        $tbody = '<tr>'.$body.'</tr>';
        return $tbody;
  }

  private function makeBody($str){
    return '<td>'.$str.'</td>';
  }


}
