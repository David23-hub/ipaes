<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\CartModel;
use App\Models\ExtraChargeModel;
use App\Models\ItemModel;
use App\Models\PackageModel;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;

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


        $dateParts = explode('/', str_replace('-', '/', $input["startDate"]));

        // Rearrange the parts to form the desired format
        $formattedDateStart = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0];

        $dateParts = explode('/', str_replace('-', '/', $input["endDate"]));

        // Rearrange the parts to form the desired format
        $formattedDateEnd = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0];

        $data = $this->model->GetListJoinDoctorAndDateWithUser($formattedDateStart,$formattedDateEnd,$input["listUser"]);
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
                            $tempCommisionRate=$valueBundle["commision_rate"];
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
                $no=1;

                $tbldiv.='<div id="'.$value["created_by"].'">'.$this->rowData($tempBody,$name,true).'</div><hr class="split-line">';
                $tempBody = "";
                $tempBody = $this->getBody($value,$no);
                $name = $value["created_by"];
            }else{
                $tempBody .= $this->getBody($value, $no);
            }
        };
        $tbldiv.='<div id="'.$name.'">'.$this->rowData($tempBody,$name,true).'</div><hr class="split-line">';
        
        $res = [
            "data"=>$data,
            "tbldiv"=>$tbldiv,
            "periode"=>$input["startDate"]." - ".$input["endDate"],
            "marketing"=>$marketing,
        ];
        return $res;
    }

    private function rowData($body,$name,$flag) {
        $tbody = '<tbody><tr>'.$body.'</tr></tbody>';

        // table.append(thead).append(tbody);
        $table = "";
        if($flag){
          $table.='<h5>Marketing: <span style="font-weight: bold">'.$name.'</span></h5>';
        };
        $table .= '<div class="table-responsive"><table class="table table-striped table-bordered table-hover"><thead><tr><th>No</th><th>Date</th><th>Doctor Name</th><th>PO Number</th><th>Status</th><th>Product</th><th>Qty</th><th>Total Price</th><th>Incentive (%)</th><th>Incentive (IDR)</th></tr></thead><tbody>'.$tbody.'</tbody></table></div>';
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

  private function rowDataSummary($body) {
    $tbody = '<tbody><tr>'.$body.'</tr></tbody>';

    $table = "";
    
        
        $table .= '<div class="table-responsive"><table class="table table-striped table-bordered table-hover"><thead><tr><th>No</th><th>Marketing</th><th>Total Price (IDR)</th><th>Incentive (IDR)</th></tr></thead><tbody>'.$tbody.'</tbody></table></div>';
    return $table;
}

private function getBodySummary($created_by, $total, $incentive ,$number) {
    $body = "";
    $body .= $this->makeBody($number).$this->makeBody($created_by).$this->makeBody($total).$this->makeBody($incentive);
    
    $tbody = '<tr>'.$body.'</tr>';
    return $tbody;
}

  public function getSummary(Request $request){
    $input = $request->all();
    $products = $this->item->GetAll();
    $bundle=$this->bundle->GetAll();
    if($input["listUser"]!="all"){
        $marketing=implode(', ', $input["listUser"]);
    }else{
        $marketing="All";
    }

    $dateParts = explode('/', str_replace('-', '/', $input["startDate"]));

    // Rearrange the parts to form the desired format
    $formattedDateStart = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0];

    $dateParts = explode('/', str_replace('-', '/', $input["endDate"]));

    // Rearrange the parts to form the desired format
    $formattedDateEnd = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0];

    $data = $this->model->GetListJoinDoctorAndDateWithUser($formattedDateStart,$formattedDateEnd,$input["listUser"]);
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
                        $tempCommisionRate=$valueBundle["commision_rate"];
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


        $total += $extraVal;

        $data[$count]["total"]=($total);
        $data[$count]["incentiveIdr"]=($incentiveIdr);
        $count++;
    }


    $no = 1;
    $tempBody="";
    $tot = 0;
    $incen = 0;

    $name=$data[0]["created_by"];


    foreach ($data as $value) {
        
        if($name!=$value->created_by){
            $tempBody .= $this->getBodySummary($name,"IDR. ".$tot,"IDR. ".$incen, $no);
            $name = $value["created_by"];
            $no++;
            $tot=0;
            $incen=0;
        }
        $tot+=$value["total"];
        $incen+=$value["incentiveIdr"];
    };
    $tempBody .= $this->getBodySummary($name,"IDR. ".$tot,"IDR. ".$incen, $no);

    $tempBody = $this->rowDataSummary($tempBody);
    
    $res = [
        "periode"=>$input["startDate"]." - ".$input["endDate"],
        "tbldiv"=>$tempBody,
        "marketing"=>$marketing,
    ];
    // dd($res);
    return $res;
}

  public function download(Request $request){

    $input = $request->all();

    $products = $this->item->GetAll();
    $bundle=$this->bundle->GetAll();
    if($input["listUser"]!="all"){
        $marketing=implode(', ', $input["listUser"]);
    }else{
        $marketing="All";
    }

    $dateParts = explode('/', str_replace('-', '/', $input["startDate"]));

    // Rearrange the parts to form the desired format
    $formattedDateStart = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0];

    $dateParts = explode('/', str_replace('-', '/', $input["endDate"]));

    // Rearrange the parts to form the desired format
    $formattedDateEnd = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0];

    $data = $this->model->GetListJoinDoctorAndDateWithUser($formattedDateStart,$formattedDateEnd,$input["listUser"]);
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
                        $tempCommisionRate=$valueBundle["commision_rate"];
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

    $name=$data[0]["created_by"];

    $styleArray = [
        'font' => [
            'bold' => true,
        ],
    ];

    //start to convert
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->fromArray(['PERIODE', $input["startDate"]."  s/d  ".$input["endDate"]], NULL, 'A1');
    $sheet->getStyle('B1'.':T1')->applyFromArray($styleArray);


    $headers = ['No', 'Date','Marketing', 'Doctor Name', 'PO Number', 'Status', 'Product', 'Qty', 'Total Price', 'Incentive (%)', 'Incentive (IDR)'];
    
    $rows = 4;
    $sheet->fromArray(['Marketing',$name], NULL, 'A'.($rows-1));
    $sheet->getStyle('B'.($rows-1).':B'.($rows-1))->applyFromArray($styleArray);

    $sheet->fromArray([$headers], NULL, 'A4');
    
    $sheet->getStyle('A4:K4')->applyFromArray([
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
            ],
        ],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['rgb' => '00B6FF'], // Specify the color in RGB format
        ],
    ]);

    //row untuk menentukan posisi keberapa kebawah
    $no = 0;
    foreach ($data as $key => $row) {
        if ($name != $row->created_by){
            $no=0;
            $name = $row->created_by;
            $rows+=3;
            $sheet->fromArray([$headers], NULL, 'A'.$rows);
            $sheet->fromArray(['Marketing',$name], NULL, 'A'.($rows-1));
            $sheet->getStyle('A'.($rows).':K'.($rows))->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '00B6FF'], // Specify the color in RGB format
                ],
            ]);
            $sheet->getStyle('B'.($rows-1).':B'.($rows-1))->applyFromArray($styleArray);

        }
        $no++;
        // Set headers
        $start = $rows;
        $tProduct = explode('<hr class="split-line">', $row->product);
        $tQty = explode('<hr class="split-line">', $row->qty);
        foreach ($tProduct as $ke => $prod) {
            $rowData = [$no, $row->created_at,$row->created_by, $row->doctor_name,$row->po_id,$row->status,$prod,$tQty[$ke],$row->total,$row->incentivePerc,$row->incentiveIdr];
            $sheet->fromArray([$rowData], NULL, 'A' . ($rows + 1));
            $sheet->getStyle('A'.($start+1).':K'.($rows+1))->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ],
            ]);
            $rows++;
        }
        
        if($rows-$start!=1){
            $sheet->mergeCells('A'.($start+1).':A'.($rows));
            $sheet->mergeCells('B'.($start+1).':B'.($rows));
            $sheet->mergeCells('C'.($start+1).':C'.($rows));
            $sheet->mergeCells('D'.($start+1).':D'.($rows));
            $sheet->mergeCells('E'.($start+1).':E'.($rows));
            $sheet->mergeCells('F'.($start+1).':F'.($rows));
            $sheet->mergeCells('I'.($start+1).':I'.($rows));
            $sheet->mergeCells('J'.($start+1).':J'.($rows));
            $sheet->mergeCells('K'.($start+1).':K'.($rows));
        }

    };
    

    $sheet->getColumnDimension('A')->setAutoSize(true);
    $sheet->getColumnDimension('B')->setAutoSize(true);
    $sheet->getColumnDimension('C')->setAutoSize(true);
    $sheet->getColumnDimension('D')->setAutoSize(true);
    $sheet->getColumnDimension('E')->setAutoSize(true);
    $sheet->getColumnDimension('F')->setAutoSize(true);
    $sheet->getColumnDimension('G')->setAutoSize(true);
    $sheet->getColumnDimension('H')->setAutoSize(true);
    $sheet->getColumnDimension('I')->setAutoSize(true);
    $sheet->getColumnDimension('J')->setAutoSize(true);
    $sheet->getColumnDimension('K')->setAutoSize(true);
    $res = [
        "data"=>$data,
        "periode"=>$input["startDate"]." - ".$input["endDate"],
        "marketing"=>$marketing,
    ];

    


    //  // Set headers
    //  $headers = ['Column 1', 'Column 2', 'Column 3'];
    //  $sheet->fromArray([$headers], NULL, 'A1');

     // Add data rows
    // foreach ($data as $key => $row) {
    //     $rowData = [$row->created_by, $row->created_by, $row->address];
    //     $sheet->fromArray([$rowData], NULL, 'A' . ($key + 2));
    // }


    $writer = new Xlsx($spreadsheet);
    $filename = 'INCENTIVE_REPORT_' . date('Y-m-d_H-i-s') . '.xlsx';
    $writer->save($filename);

    // Return download response
    return response()->json(['url' => asset($filename)]);

}

}
