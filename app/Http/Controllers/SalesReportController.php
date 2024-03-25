<?php

namespace App\Http\Controllers;

use App\Models\CartModel;
use App\Models\ExtraChargeModel;
use App\Models\ItemModel;
use App\Models\PackageModel;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class SalesReportController extends Controller
{
    private $model;
    private $item;
    private $bundle;
    private $extraCharge;
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(function ($request, $next) {
            $role = auth()->user()->role;
            if($role!="superuser"&&$role!="finance"){
                    abort(403, 'Unauthorized access');
                }
            return $next($request);
          });


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

        $dateParts = explode('/', str_replace('-', '/', $input["startDate"]));

        // Rearrange the parts to form the desired format
        $formattedDateStart = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0];
    
        $dateParts = explode('/', str_replace('-', '/', $input["endDate"]));
    
        // Rearrange the parts to form the desired format
        $formattedDateEnd = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0];

        $data = $this->model->GetListJoinDoctorAndDate($formattedDateStart,$formattedDateEnd);
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
                            $tempPrice = $items[4];
                            $tempCommisionRate=$valueProd["commision_rate"];
                            break;
                        }
                    }
                }else if($items[1]=="paket"){
                    foreach ($bundle as $valueBundle) {
                        if($valueBundle["id"]==$items[0]){
                            $items[0]=$valueBundle["name"];
                            $tempPrice = $items[4];
                            $tempCommisionRate=$valueBundle["commision_rate"];
                            break;
                        }
                    }
                }

                if($i==count($carts)){
                    $product .= $items[0];
                    $qty .= $items[2];
                    $disc .= $items[3]."%";
                    $price .= "IDR ".number_format($tempPrice,0,',','.');
                }else{
                    $product .= $items[0].'<hr class="split-line">';
                    $qty .= $items[2].'<hr class="split-line">';
                    $disc .= $items[3]."%".'<hr class="split-line">';
                    $price .= "IDR ".number_format($tempPrice,0,',','.').'<hr class="split-line">';
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
            if(strlen($value->paid_at)>0 && $value->paid_at[strlen($value->paid_at)-1]=="|"){
                $value->paid_at = substr($value->paid_at,0,strlen($value->paid_at)-1);
            }
            if($value->paid_at != ""){
                $payments = explode("|", $value->paid_at);
            }else{
                $payments = [];
            }
            $stepPayment = "";
            $i=0;
            $counter=0;
            //if there's only 1 payment
            if(count($payments)!=0){
                $value->nominal = substr($value->nominal,0,strlen($value->nominal)-1);

                $nominals = explode("|", $value->nominal);

                foreach ($payments as $pay) {
                    $i++;
                    if($i==count($payments)){
                        $stepPayment .= $pay."  =>  IDR ".number_format($nominals[$counter],0,',','.');
                    }else{
                        $stepPayment .= $pay."  =>  IDR ".number_format($nominals[$counter],0,',','.').'<hr class="split-line">';
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
            $data[$count]["extras"]="IDR ".number_format($extraVal,0,',','.');
            $data[$count]["revenue"]="IDR ".number_format(($total-$value["shipping_cost"]),0,',','.');
            $data[$count]["total"]="IDR ".number_format($total,0,',','.');
            $data[$count]["stepPayment"]=($stepPayment);
            $data[$count]["incentiveIdr"]="IDR ".($incentiveIdr);
            $data[$count]["incentivePerc"]=round(($incentiveIdr*100)/$total,2).' %';
            
            $count++;
        }

        $no = 0;
        $tbldiv="";
        $tempBody="";
        foreach ($data as $value) {
            $no++;
            $tempBody .= $this->getBody($value,$no);
        };
       
        $tbldiv.=$this->rowData($tempBody);

        $res = [
            "data"=>$data,
            "tbldiv"=>$tbldiv,
            "periode"=>$input["startDate"]." - ".$input["endDate"],
        ];

        return $res;
    }

    private function rowData($body) {
        $tbody = '<tbody><tr>'.$body.'</tr></tbody>';

        $table = '<div class="table-responsive"><table class="table table-striped table-bordered table-hover"><thead><tr>
        <th>No</th>
        <th>Invoice</th>
        <th>PO Date</th>
        <th>Doctor</th>
        <th>Clinic</th>
        <th>Address</th>
        <th>Billing Phone</th>
        <th>Doctor Phone</th>
        <th>Product</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Discount</th>
        <th>Extra Charges</th>
        <th>Total Price</th>
        <th>Shipping Cost</th>
        <th>Revenue</th>
        <th>Payment Status</th>
        <th>Step Payment</th>
        <th>Marketing</th>
        <th>Paid At</th>
    </tr></thead><tbody>'.$tbody.'</tbody></table></div>';
        return $table;
    }

    private function getBody($data,$number) {
            $body = "";
            $body .= $this->makeBody($number).$this->makeBody($data["po_id"]).
            $this->makeBody($data["created_at"]).$this->makeBody($data["doctor_name"]).
            $this->makeBody($data["clinic"]).$this->makeBody($data["address"]).
            $this->makeBody($data["billing_no_hp"]).$this->makeBody($data["no_hp"]).
            $this->makeBody($data["product"]).$this->makeBody($data["qty"]).
            $this->makeBody($data["price"]).$this->makeBody($data["disc"]).
            $this->makeBody($data["extras"]).$this->makeBody($data["total"]).
            $this->makeBody("IDR. ".number_format($data["shipping_cost"],0,',','.')).$this->makeBody($data["revenue"]).
            $this->makeBody($data["status"]).$this->makeBody($data["stepPayment"]).
            $this->makeBody($data["created_by"]).$this->makeBody($data["paid_at"])
            ;
            
            $tbody = '<tr>'.$body.'</tr>';
            return $tbody;
    }

    private function makeBody($str){
        return '<td>'.$str.'</td>';
    }

    public function download(Request $request){
        $input = $request->all();

        $products = $this->item->GetAll();
        $bundle=$this->bundle->GetAll();

        $dateParts = explode('/', str_replace('-', '/', $input["startDate"]));

        // Rearrange the parts to form the desired format
        $formattedDateStart = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0];
    
        $dateParts = explode('/', str_replace('-', '/', $input["endDate"]));
    
        // Rearrange the parts to form the desired format
        $formattedDateEnd = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0];

        $data = $this->model->GetListJoinDoctorAndDate($formattedDateStart,$formattedDateEnd);
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
                    $price .= "IDR ".number_format($tempPrice,0,',','.');
                }else{
                    $product .= $items[0].'<hr class="split-line">';
                    $qty .= $items[2].'<hr class="split-line">';
                    $disc .= $items[3]."%".'<hr class="split-line">';
                    $price .= "IDR ".number_format($tempPrice,0,',','.').'<hr class="split-line">';
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
            if($value->paid_at[strlen($value->paid_at)-1]=="|"){
                $value->paid_at = substr($value->paid_at,0,strlen($value->paid_at)-1);
            }
            if($value->paid_at != ""){
                $payments = explode("|", $value->paid_at);
            }else{
                $payments = [];
            }
            $stepPayment = "";
            $i=0;
            $counter=0;
            //if there's only 1 payment
            if(count($payments)!=0){
                $value->nominal = substr($value->nominal,0,strlen($value->nominal)-1);
                $nominals = explode("|", $value->nominal);
                foreach ($payments as $pay) {
                    $i++;
                    if($i==count($payments)){
                        $stepPayment .= $pay."  =>  IDR ".number_format($nominals[$counter],0,',','.');
                    }else{
                        $stepPayment .= $pay."  =>  IDR ".number_format($nominals[$counter],0,',','.').'<hr class="split-line">';
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
            $data[$count]["extras"]="IDR ".number_format($extraVal,0,',','.');
            $data[$count]["revenue"]="IDR ".number_format(($total-$value["shipping_cost"]),0,',','.');
            $data[$count]["total"]="IDR ".number_format($total,0,',','.');
            $data[$count]["stepPayment"]=($stepPayment);
            $data[$count]["incentiveIdr"]="IDR ".($incentiveIdr);
            $data[$count]["incentivePerc"]=round(($incentiveIdr*100)/$total,2).' %';
            $count++;
        }


        $styleArray = [
            'font' => [
                'bold' => true,
            ],
        ];

        //start to convert
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $headers = ['No', 'Invoice', 'Date', 'Doctor','Clinic','Address','Billing Phone','Doctor Phone','Product','Quantity','Price','Discount','Extra Charge','Total Price','Shipping Cost','Revenue','Payment Status','Step Payment', 'Marketing','Paid At'];
        
        $rows = 2;
        $sheet->fromArray(['PERIODE', $input["startDate"]."  s/d  ".$input["endDate"]], NULL, 'A'.($rows-1));
        $sheet->getStyle('B'.($rows-1).':T'.($rows-1))->applyFromArray($styleArray);

        $sheet->fromArray([$headers], NULL, 'A2');
        
        $sheet->getStyle('A2:T2')->applyFromArray([
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
            $no++;
            $start = $rows;
            $tProduct = explode('<hr class="split-line">', $row->product);
            $tQty = explode('<hr class="split-line">', $row->qty);
            $tPrice = explode('<hr class="split-line">', $row->price);
            $tDisc = explode('<hr class="split-line">', $row->disc);
            $tStepPayment = explode('<hr class="split-line">', $row->stepPayment);
            foreach ($tProduct as $ke => $prod) {
                if(count($tStepPayment)<=$ke){
                    $rowData = [$no, $row->po_id,$row->created_at, $row->doctor_name,$row->clinic,$row->address,$row->billing_no_hp,$row->no_hp,$prod,$tQty[$ke],$tPrice[$ke],$tDisc[$ke],$row->extras,$row->total,"IDR ".$row->shipping_cost,$row->revenue,$row->status, "", $row->created_by, $row->paid_at];
                }else{
                    $rowData = [$no, $row->po_id,$row->created_at, $row->doctor_name,$row->clinic,$row->address,$row->billing_no_hp,$row->no_hp,$prod,$tQty[$ke],$tPrice[$ke],$tDisc[$ke],$row->extras,$row->total,"IDR ".$row->shipping_cost,$row->revenue,$row->status, $tStepPayment[$ke], $row->created_by, $row->paid_at];
                }
                $sheet->fromArray([$rowData], NULL, 'A' . ($rows + 1));
                $sheet->getStyle('A'.($start+1).':T'.($rows+1))->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                ]);
                $rows++;
            }

            

            if(count($tProduct)<count($tStepPayment)){
                foreach ($tStepPayment as $key => $value) {
                    if($key+1<=count($tProduct)){
                        continue;
                    }
                    $rowData = ["", "","", "","","","","","","","","","","","","","", $value, "",""];
                    $sheet->fromArray([$rowData], NULL, 'A' . ($rows + 1));
                    $sheet->getStyle('A'.($start+1).':T'.($rows+1))->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                            ],
                        ],
                    ]);
                    $rows++;
                }
            }

            if($rows-$start!=1){
                $sheet->mergeCells('A'.($start+1).':A'.($rows));
                $sheet->mergeCells('B'.($start+1).':B'.($rows));
                $sheet->mergeCells('C'.($start+1).':C'.($rows));
                $sheet->mergeCells('D'.($start+1).':D'.($rows));
                $sheet->mergeCells('E'.($start+1).':E'.($rows));
                $sheet->mergeCells('F'.($start+1).':F'.($rows));
                $sheet->mergeCells('G'.($start+1).':G'.($rows));
                $sheet->mergeCells('H'.($start+1).':H'.($rows));
                $sheet->mergeCells('M'.($start+1).':M'.($rows));
                $sheet->mergeCells('N'.($start+1).':N'.($rows));
                $sheet->mergeCells('O'.($start+1).':O'.($rows));
                $sheet->mergeCells('P'.($start+1).':P'.($rows));
                $sheet->mergeCells('Q'.($start+1).':Q'.($rows));
                $sheet->mergeCells('S'.($start+1).':S'.($rows));
                $sheet->mergeCells('T'.($start+1).':T'.($rows));
            }

        }


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
        $sheet->getColumnDimension('L')->setAutoSize(true);
        $sheet->getColumnDimension('M')->setAutoSize(true);
        $sheet->getColumnDimension('N')->setAutoSize(true);
        $sheet->getColumnDimension('O')->setAutoSize(true);
        $sheet->getColumnDimension('P')->setAutoSize(true);
        $sheet->getColumnDimension('Q')->setAutoSize(true);
        $sheet->getColumnDimension('R')->setAutoSize(true);
        $sheet->getColumnDimension('S')->setAutoSize(true);
        $sheet->getColumnDimension('T')->setAutoSize(true);

        //  // Set headers
        //  $headers = ['Column 1', 'Column 2', 'Column 3'];
        //  $sheet->fromArray([$headers], NULL, 'A1');

        // Add data rows
        // foreach ($data as $key => $row) {
        //     $rowData = [$row->created_by, $row->created_by, $row->address];
        //     $sheet->fromArray([$rowData], NULL, 'A' . ($key + 2));
        // }


        $writer = new Xlsx($spreadsheet);
        $filename = 'export_' . date('Y-m-d_H-i-s') . '.xlsx';
        $writer->save($filename);

        // Return download response
        return response()->json(['url' => asset($filename)]);
    }

}
