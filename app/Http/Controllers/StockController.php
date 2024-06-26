<?php

namespace App\Http\Controllers;

use App\Models\ItemModel;
use App\Models\StockModel;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
class StockController extends Controller
{
    private $model;

    private $item;
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

          
        $this->model = new StockModel;
        $this->item = new ItemModel;
    }

    public function index()
    {

        $items = $this->item->GetAll();

        return view('master.stockReport')->with('items',$items);
    }

    public function insert($data,$update_item){

        try {
            $temp = $this->model->AddItems($data);

            if(!$temp){
                return "Gagal Menambahkan di reporting stock!! Hubungi admin untuk mencocokan kembali jumlah stock product dan reporting";
            }

            $result = "Gagal Update Stock Product Dengan id: ";

            foreach ($data as $value) {
                $res = 0;
                if(isset($value["stock_in"]) && $value["stock_in"]!=0 && $update_item=="1"){
                    $res = $this->item->UpdateQtyStockPlus($value['id_product'],$value["stock_in"]);
                }else if(isset($value["stock_out"]) &&$value["stock_out"]!=0 && $update_item=="1" ){
                    $res = $this->item->UpdateQtyStockMinus($value['id_product'],($value["stock_out"] ));
                }

                if ($res != 1 && $update_item =="1"){
                    $result .= $value["id_product"].", ";
                }
            }

            

            if($result == "Gagal Update Stock Product Dengan id: "){
                return "sukses";
            }
            
            return $result;
        } catch (\Throwable $th) {
            return "Gagal mengurangi stock atau menambahkan reporting stock! Hubungi developer untuk mencocokan data kembali!";
        }
    }

    public function cancelPO(string $id){
        $products = [];
        try {
            $datas = $this->model->GetItems($id,1);

            if(count($datas)==0){
                return "Data Tidak Ditemukan didalam Stock";
            }


            foreach ($datas as $value) {
                $obj = [];
                $obj["id_product"] = $value->id_product;
                $obj['stock_in'] = $value->stock_out;
                $obj['cart_id'] = $value->cart_id;
                $obj['desc'] = "CANCEL ORDER ".$value->desc;
                $obj['status'] = "0";
                $obj['created_at'] = date('Y-m-d H:i:s');
                array_push($products, $obj);
            }
            

            $temp = $this->model->AddItems($products);

            if(!$temp){
                return "Gagal mengurangi stock!! Tolong di cek lagi bagian stock!";
            }


            $result = "Gagal Update Stock Product Dengan id: ";
            foreach ($datas as $value) {
                $res = 0;

                $res = $this->item->UpdateQtyStockPlus($value['id_product'],($value["stock_out"]));

                if ($res != 1){
                    $result .= $value["product_id"].", ";
                }
            }

            if($result == "Gagal Update Stock Product Dengan id: "){
                return "sukses";
            }
            
            return $result;


        } catch (\Throwable $th) {
            return "Gagal mengurangi stock! Tolong di cek lagi bagian stock!";
        }
    }

    public function getAll(Request $request){

        $tempMarketing = [];

        $dateParts = explode('/', str_replace('-', '/', $request["startDate"]));

        // Rearrange the parts to form the desired format
        $formattedDateStart = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0];

        $dateParts = explode('/', str_replace('-', '/', $request["endDate"]));

        // Rearrange the parts to form the desired format
        $formattedDateEnd = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0];

        $data = $this->model->GetList($formattedDateStart,$formattedDateEnd,$request["listUser"]);
        
        if(count($data)==0){
            return "KOSONG";
        }

        $tempBody="";
        $no=0;
        $name=$data[0]["name"];
        $tbldiv = "";

        if($request["listUser"]!="all"){
            array_push($tempMarketing, $data[0]["name"]);
        }
        foreach ($data as $value) {
            $no++;
            if($value["name"]!=$name){
                if($request["listUser"]!="all"){
                    array_push($tempMarketing, $value["name"]);
                }
                $no = 1;
                $tbldiv .= $this->rowData($tempBody,$name,true);
                $value["stock_masuk"] = number_format($value["stock_in"],0,',','.')." ".$value["unit"];
                $value["stock_keluar"] = number_format($value["stock_out"],0,',','.')." ".$value["unit"];
                $tempBody = $this->getBody($value,$no);
                $name = $value["name"];
            }else{
                $value["stock_masuk"] = number_format($value["stock_in"],0,',','.')." ".$value["unit"];
                $value["stock_keluar"] = number_format($value["stock_out"],0,',','.')." ".$value["unit"];
                $tempBody .= $this->getBody($value,$no);
            }
            
        }
        $tbldiv .= $this->rowData($tempBody,$name,true);

        if($request["listUser"]=="all"){
            $marketing="All";
        }else{
            $marketing=implode(', ', $tempMarketing);
        }


        $res = [
            "data"=>$data,
            "tbldiv"=>$tbldiv,
            "periode"=>$request["startDate"]." - ".$request["endDate"],
            "marketing"=>$marketing,
        ];

        return $res;
    }

    private function rowData($body,$name,$flag) {
        $tbody = '<tbody><tr>'.$body.'</tr></tbody>';

        // table.append(thead).append(tbody);
        $table = "";
        if($flag){
          $table.='<h5>Product Name: <span style="font-weight: bold">'.$name.'</span></h5>';
        };
        $table .= '<div class="table-responsive"><table class="table table-striped table-bordered table-hover"><thead><tr><th>No</th><th>Date</th><th>Information</th><th>Stock In</th><th>Stock Out</th></tr></thead><tbody>'.$tbody.'</tbody></table></div>';
        return $table;
  }

  
  
    private function getBody($data,$number) {
        $body = "";
        $body .= $this->makeBody($number).$this->makeBody($data["created_at"]).$this->makeBody($data["desc"]).$this->makeBody($data["stock_masuk"]).$this->makeBody($data["stock_keluar"]);
        
        $tbody = '<tr>'.$body.'</tr>';
        return $tbody;
    }

        private function makeBody($str){
            return '<td>'.$str.'</td>';
        }

        private function rowDataSummary($body) {
            $tbody = '<tbody><tr>'.$body.'</tr></tbody>';

            $table = "";
            $table .= '<div class="table-responsive"><table class="table table-striped table-bordered table-hover"><thead><tr><th>No</th><th>Product</th><th>Total Stock In</th><th>Total Stock Out</th><th>Grand Stock Out</th></tr></thead><tbody>'.$tbody.'</tbody></table></div>';
        return $table;
        }

        private function getBodySummary($product, $stock_in, $stock_out, $total ,$number) {
            $body = "";
            $body .= $this->makeBody($number).$this->makeBody($product).$this->makeBody($stock_in).$this->makeBody($stock_out).$this->makeBody($total);
            
            $tbody = '<tr>'.$body.'</tr>';
            return $tbody;
        }

        public function getSummary(Request $request){
        $tempMarketing = [];

        $dateParts = explode('/', str_replace('-', '/', $request["startDate"]));

        // Rearrange the parts to form the desired format
        $formattedDateStart = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0];

        $dateParts = explode('/', str_replace('-', '/', $request["endDate"]));

        // Rearrange the parts to form the desired format
        $formattedDateEnd = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0];

        $data = $this->model->GetList($formattedDateStart,$formattedDateEnd,$request["listUser"]);
        if(count($data)==0){
            return "KOSONG";
        }

        $tempBody="";
        $no=0;
        $name=$data[0]["name"];
        $tbldiv = "";
        $tempStockIn=0;
        $tempStockOut=0;

        if($request["listUser"]!="all"){
            array_push($tempMarketing, $data[0]["name"]);
        }
        foreach ($data as $value) {
            if($value["name"]!=$name){
                if($request["listUser"]!="all"){
                    array_push($tempMarketing, $value["name"]);
                }
                
                $no++;
                $tempBody .= $this->getBodySummary($name,number_format($tempStockIn,0,',','.'),number_format($tempStockOut,0,',','.'),number_format($tempStockIn+($tempStockOut*-1),0,',','.'),$no);

                $tempStockIn=0;
                $tempStockOut=0;
                $tempStockIn+=$value["stock_in"];
                $tempStockOut+=$value["stock_out"];


                $name = $value["name"];
            }else{
                $tempStockIn+=$value["stock_in"];
                $tempStockOut+=$value["stock_out"];

            }
        }

        $no++;
        $tempBody .= $this->getBodySummary($name,number_format($tempStockIn,0,',','.'),number_format($tempStockOut,0,',','.'),number_format($tempStockIn+($tempStockOut*-1),0,',','.'),$no);
        $tbldiv .= $this->rowDataSummary($tempBody);

        if($request["listUser"]=="all"){
            $marketing="All";
        }else{
            $marketing=implode(', ', $tempMarketing);
        }


        $res = [
            "data"=>$data,
            "tbldiv"=>$tbldiv,
            "periode"=>$request["startDate"]." - ".$request["endDate"],
            "marketing"=>$marketing,
        ];

        return $res;

        }


        public function download(Request $request){

            $tempMarketing = [];
    
            $dateParts = explode('/', str_replace('-', '/', $request["startDate"]));
    
            // Rearrange the parts to form the desired format
            $formattedDateStart = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0];
    
            $dateParts = explode('/', str_replace('-', '/', $request["endDate"]));
    
            // Rearrange the parts to form the desired format
            $formattedDateEnd = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0];
    
            $data = $this->model->GetList($formattedDateStart,$formattedDateEnd,$request["listUser"]);
            if(count($data)==0){
                return "KOSONG";
            }
            $no=0;
            $name=$data[0]["name"];

            if($request["listUser"]!="all"){
                array_push($tempMarketing, $data[0]["name"]);
            }
            foreach ($data as $value) {
                $no++;
                if($value["name"]!=$name){
                    if($request["listUser"]!="all"){
                        array_push($tempMarketing, $value["name"]);
                    }
                }
                
            }

            if($request["listUser"]=="all"){
                $marketing="All";
                $tempMarketing[0]="All";
            }else{
                $marketing=implode(', ', $tempMarketing);
            }
    
            $styleArray = [
                'font' => [
                    'bold' => true,
                ],
            ];



            //start to convert
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->fromArray(['PERIODE', $request["startDate"]."  s/d  ".$request["endDate"]], NULL, 'A1');
            $sheet->getStyle('B1'.':T1')->applyFromArray($styleArray);


            $headers = ['No', 'Date','Information', 'Stock In', 'Stock Out'];
            
            $name = $tempMarketing[0];
            
            $rows = 2;
            // $sheet->fromArray(['Product Name',$name], NULL, 'A'.($rows-1));
            // $sheet->getStyle('B'.($rows-1).':B'.($rows-1))->applyFromArray($styleArray);

            // $sheet->fromArray([$headers], NULL, 'A4');
            
            // $sheet->getStyle('A4:E4')->applyFromArray([
            //     'borders' => [
            //         'allBorders' => [
            //             'borderStyle' => Border::BORDER_THIN,
            //         ],
            //     ],
            //     'fill' => [
            //         'fillType' => Fill::FILL_SOLID,
            //         'startColor' => ['rgb' => '00B6FF'], // Specify the color in RGB format
            //     ],
            // ]);

            //row untuk menentukan posisi keberapa kebawah
            $no = 0;
            foreach ($data as $key => $row) {
                if ($name != $row->name){
                    $no=0;
                    $name = $row->name;
                    $rows+=3;
                    $sheet->fromArray([$headers], NULL, 'A'.$rows);
                    $sheet->fromArray(['Product',$name], NULL, 'A'.($rows-1));
                    $sheet->getStyle('A'.($rows).':E'.($rows))->applyFromArray([
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
                    if($row->stock_in==""){
                        $row->stock_in="0";
                        
                    }
                    if($row->stock_out==""){
                        $row->stock_out="0";
                    }
                    $row->stock_in=number_format($row->stock_in,0,',','.')." ".$row->unit;
                    $row->stock_out=number_format($row->stock_out,0,',','.')." ".$row->unit;

                    $rowData = [$no, $row->created_at,$row->desc, $row->stock_in,$row->stock_out];
                    $sheet->fromArray([$rowData], NULL, 'A' . ($rows + 1));
                    $sheet->getStyle('A'.($start+1).':E'.($rows+1))->applyFromArray([
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
                }

            };
            

            $sheet->getColumnDimension('A')->setAutoSize(true);
            $sheet->getColumnDimension('B')->setAutoSize(true);
            $sheet->getColumnDimension('C')->setAutoSize(true);
            $sheet->getColumnDimension('D')->setAutoSize(true);
            $sheet->getColumnDimension('E')->setAutoSize(true);

            //  // Set headers
            //  $headers = ['Column 1', 'Column 2', 'Column 3'];
            //  $sheet->fromArray([$headers], NULL, 'A1');

            // Add data rows
            // foreach ($data as $key => $row) {
            //     $rowData = [$row->created_by, $row->created_by, $row->address];
            //     $sheet->fromArray([$rowData], NULL, 'A' . ($key + 2));
            // }


            $writer = new Xlsx($spreadsheet);
            $filename = 'STOCK_REPORT_' . date('Y-m-d_H-i-s') . '.xlsx';
            $writer->save($filename);

            // Return download response
            return response()->json(['url' => asset($filename)]);
        }

}
