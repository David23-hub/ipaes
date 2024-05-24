<?php

namespace App\Http\Controllers;

use App\Models\CategoryProductModel;
use App\Models\ItemModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DateTime;

class ItemController extends Controller
{
    private $model;
    private $modelCategoryProduct;
    private $stockController;

    public function __construct()
    {
        $this->middleware('auth');
        
        $this->middleware(function ($request, $next) {
            $role = auth()->user()->role;
            if($role!="superuser"&&$role!="admin" && $role!="manager" && $request->route()->getName() != "getItem"){
                    abort(403, 'Unauthorized access');
                }
            return $next($request);
          });

        $this->model = new ItemModel;
        $this->modelCategoryProduct = new CategoryProductModel;
        $this->stockController = new StockController;

    }

    public function index()
    {
        $data = $this->modelCategoryProduct->GetListActive();
    
        
        return view('master.item')->with('data', $data);
    }
    
    public function getAll(Request $request){
        $result = $this->model->GetList();
        foreach ($result as $key => $value) {
            $result[$key]["price"] = number_format( $result[$key]["price"],0,',','.');
            $result[$key]["qty"] = number_format( $result[$key]["qty"],0,',','.');
            $result[$key]["qty_min"] = number_format( $result[$key]["qty_min"],0,',','.');

            if(auth()->user()->role=="manager"){
                $result[$key]['btn'] = '<button class="btn btn-info" onclick="getItem('. $value['id'] . ')">Detail</button>';
                
            }else{
                $result[$key]['btn'] = '<button class="btn btn-info" onclick="getItem(' . $value['id'] . ')">Detail</button><button class="btn btn-primary" onclick="getItemUpdate(' . $value['id'] . ')">Update</button><button class="btn btn-warning" onclick="getItemUpdateQty(' . $value['id'] . ')">Update Stock</button><button class="btn btn-danger" onclick="deleteItem(' . $value['id'] . ')">Delete</button>';
                
            }

        }
        return $result;
    }

    public function getItem(Request $request){
        $input = $request->all();

        $index = $this->model->GetItem($input['id']);
        $index[0]["price"] = number_format($index[0]["price"],0,',','.');
        $index[0]["qty"] = number_format($index[0]["qty"],0,',','.');
        $index[0]["qty_min"] = number_format($index[0]["qty_min"],0,',','.');

        return $index[0];
    }

    public function addItem(Request $request){
        $input = $request->all();

        if ($input["name"]=="" || trim($input['name']=="")) {
            return "Nama Category Harus Diisi!";
        }else if ($input["qty"]=="" || trim($input['qty']=="")) {
            return "Jumlah Barang Harus Diisi!";
        }else if ($input["qty_min"]=="" || trim($input['qty_min']=="")) {
            return "Jumlah Minimum Barang Harus Diisi!";
        }else if ($input["price"]=="" || trim($input['price']=="")) {
            return "Harga Barang Harus Diisi!";
        }else if (!preg_match('/^[a-zA-Z\s]+$/', $input["unit"])) {
            return "Unit Barang Harus Diisi!";
        }else if ($input["presentation"]=="" || trim($input['presentation']=="") ) {
            return "Presentasi Harus Diisi!";
        }else if (!preg_match('/^[0-9]+(\.[0-9]+)?$/', $input["commision_rate"])) {
            return "Rate Komisi Harus Diisi!";
        }else if ($input["mini_desc"]=="" || trim($input['mini_desc']=="")) {
            return "Mini Deskripsi Harus Diisi!";
        }else if ($input["desc"]=="" || trim($input['desc']=="") ) {
            return "Deskripsi Harus Diisi!";
        }

        $input["qty"] = str_replace('.', '', $input["qty"]);
        $input["qty_min"] = str_replace('.', '', $input["qty_min"]);
        $input["price"] = str_replace('.', '', $input["price"]);

        if ($request->hasFile('img')) {
            // Image is uploaded
            $image = $request->file('img');
            $imageName = time().'.'.$image->getClientOriginalExtension(); // Generate a unique name for the image
            $image->move(public_path('images'), $imageName);
        } else {
            // Image is not uploaded
            $imageName="";
        }

        $time_api_url = 'http://worldtimeapi.org/api/timezone/Asia/Jakarta';

        // Make a GET request to fetch the time data
        $response = file_get_contents($time_api_url);

        // Decode the JSON response
        $time_data = json_decode($response, true);

        // Extract the current time from the response
        $current_time = $time_data['datetime'];
        $datetime = new DateTime($current_time);

        $data = [
            'name' => $input['name'],
            'status' => $input['status'],
            'qty' => $input['qty'],
            'qty_min' => $input['qty_min'],

            'unit' => $input['unit'],
            'price' => $input['price'],
            'presentation' => $input['presentation'],
            'commision_rate' => $input['commision_rate'],
            'mini_desc' => $input['mini_desc'],
            'desc' => $input['desc'],
            'img' => $imageName,

            'created_by' => Auth::user()->email,
            'created_at' => $datetime
        ];

        $result = "";
        try {
            $temp = $this->model->AddItem($data);

            if($temp){
                $result="sukses";
            }else{
                $result="gagal1";
                return;
            }

            $products=[];
            $obj = [];
            $obj["id_product"] = $temp;
            $obj['stock_in'] = $data['qty'];
            $obj['desc'] = "Penambahan Produk Saat Insert Stock".$data['name'];
            $obj['status'] = "1";
            $obj['created_at'] = $datetime;
            array_push($products, $obj);

            $result = $this->stockController->insert($products,"0");
            return $result;

        } catch (\Throwable $th) {
            $result="gagal";
            return;
        }        

    }

    public function updateItem(Request $request){
        $input = $request->all();

        if ($input["name"]=="" || trim($input['name']=="")) {
            return "Nama Category Harus Diisi!";
        }else if ($input["qty"]=="" || trim($input['qty']=="")) {
            return "Jumlah Barang Harus Diisi!";
        }else if ($input["qty_min"]=="" || trim($input['qty_min']=="")) {
            return "Jumlah Minimum Barang Harus Diisi!";
        }else if ($input["price"]=="" || trim($input['price']=="")) {
            return "Harga Barang Harus Diisi!";
        }else if (!preg_match('/^[a-zA-Z\s]+$/', $input["unit"])) {
            return "Unit Barang Harus Diisi!";
        }else if ($input["presentation"]=="" || trim($input['presentation']=="") ) {
            return "Presentasi Harus Diisi!";
        }else if (!preg_match('/^[0-9]+(\.[0-9]+)?$/', $input["commision_rate"])) {
            return "Rate Komisi Harus Diisi!";
        }else if ($input["mini_desc"]=="" || trim($input['mini_desc']=="")) {
            return "Mini Deskripsi Harus Diisi!";
        }else if ($input["desc"]=="" || trim($input['desc']=="") ) {
            return "Deskripsi Harus Diisi!";
        }
        
        $input["qty"] = str_replace('.', '', $input["qty"]);
        $input["qty_min"] = str_replace('.', '', $input["qty_min"]);
        $input["price"] = str_replace('.', '', $input["price"]);

        $index = $this->model->GetItem($input['id']);
        if(count($index)==0){
            return "gagal";
        }
        $qtyAwal = (int)$index[0]['qty'];

        // if (!strpos("Pengurangan Produk Saat Update", "Pengurangan")) {
        //     print_r("The string contains 'hello'");die();
        // } else {
        //     print_r("GAK ");die();
        // }

        $time_api_url = 'http://worldtimeapi.org/api/timezone/Asia/Jakarta';

        // Make a GET request to fetch the time data
        $response = file_get_contents($time_api_url);

        // Decode the JSON response
        $time_data = json_decode($response, true);

        // Extract the current time from the response
        $current_time = $time_data['datetime'];
        $datetime = new DateTime($current_time);


        if ($request->hasFile('img')) {
            // Image is uploaded
            $image = $request->file('img');
            $imageName = time().'.'.$image->getClientOriginalExtension(); // Generate a unique name for the image
            $image->move(public_path('images'), $imageName);

            $data = [
                'name' => $input['name'],
                'status' => $input['status'],
                'qty' => $input['qty'],
                'qty_min' => $input['qty_min'],
                'unit' => $input['unit'],
                'price' => $input['price'],
                'presentation' => $input['presentation'],
                'commision_rate' => $input['commision_rate'],
                'mini_desc' => $input['mini_desc'],
                'desc' => $input['desc'],
                'img' => $imageName,
    
                'updated_by' => Auth::user()->email,
                'updated_at' => $datetime
            ];
        } else {
            // Image is not uploaded
            $data = [
                'name' => $input['name'],
                'status' => $input['status'],
                'qty' => $input['qty'],
                'qty_min' => $input['qty_min'],
                'unit' => $input['unit'],
                'price' => $input['price'],
                'presentation' => $input['presentation'],
                'commision_rate' => $input['commision_rate'],
                'mini_desc' => $input['mini_desc'],
                'desc' => $input['desc'],
    
                'updated_by' => Auth::user()->email,
                'updated_at' => $datetime
            ];
        }
        $result = "";
        try {
            $temp = $this->model->UpdateItem($input["id"],$data);
            if($temp){
                $result="sukses";
            }else{
                $result="gagal";
                return;
            }

            $products=[];
            $obj = [];
            $obj["id_product"] = $input["id"];
            if((int)$input['qty']<$qtyAwal){
                $obj['stock_out'] = $qtyAwal-$input['qty'];
                $obj['status'] = "1";
                $obj['desc'] = "Pengurangan Produk Saat Update Stock ".$data['name'];
                $obj['created_at'] = $datetime;
                array_push($products, $obj);

                $result = $this->stockController->insert($products,"0");
            }else if((int)$input['qty']>$qtyAwal){
                $obj['stock_in'] = $input['qty']-$qtyAwal;
                $obj['status'] = "1";
                $obj['desc'] = "Penambahan Produk Saat Update Stock".$data['name'];
                $obj['created_at'] = $datetime;
                array_push($products, $obj);

                $result = $this->stockController->insert($products,"0");
            }
            
            return $result;
        } catch (\Throwable $th) {
            $result="gagal";
        }        

        return $result;
    }

    public function updateItemQty(Request $request){
        $input = $request->all();

        if ($input["qty"]=="" || trim($input['qty']=="")) {
            return "Jumlah Barang Harus Diisi!";
        }else if ($input["desc"]=="" || trim($input['desc']=="") ) {
            return "Deskripsi Harus Diisi!";
        }
        
        $input["qty"] = str_replace('.', '', $input["qty"]);

        $index = $this->model->GetItem($input['id']);
        if(count($index)==0){
            return "gagal";
        }
        $qtyAwal = (int)$index[0]['qty'];

        // if (!strpos("Pengurangan Produk Saat Update", "Pengurangan")) {
        //     print_r("The string contains 'hello'");die();
        // } else {
        //     print_r("GAK ");die();
        // }

        $time_api_url = 'http://worldtimeapi.org/api/timezone/Asia/Jakarta';

        // Make a GET request to fetch the time data
        $response = file_get_contents($time_api_url);

        // Decode the JSON response
        $time_data = json_decode($response, true);

        // Extract the current time from the response
        $current_time = $time_data['datetime'];
        $datetime = new DateTime($current_time);


        $result = "";
        try {
            $qty = 0;
            if($input["type"]=="in"){
                $qty = $qtyAwal+$input["qty"];
            }else if($input["type"]=="out"){
                $qty = $qtyAwal-$input["qty"];
                
            }

            $data = [
                'qty' => $qty,
                'updated_by' => Auth::user()->email,
                'updated_at' => $datetime
            ];

            $temp = $this->model->UpdateItem($input["id"],$data);
            if($temp){
                $result="sukses";
            }else{
                $result="gagal";
                return;
            }


            $products=[];
            $obj = [];
            $obj["id_product"] = $input["id"];
            if($input['type'] == "in"){
                $obj['stock_in'] = $input['qty'];
                $obj['status'] = "1";
                $obj['desc'] = $input['desc'];
                $obj['created_at'] = $datetime;
                array_push($products, $obj);

                $result = $this->stockController->insert($products,"0");
            }else{
                $obj['stock_out'] = $input['qty'];
                $obj['status'] = "1";
                $obj['desc'] =$input['desc'];
                $obj['created_at'] = $datetime;
                array_push($products, $obj);

                $result = $this->stockController->insert($products,"0");
            }

            return $result;
        } catch (\Throwable $th) {
            $result="gagal";
        }        

        return $result;
    }

    public function deleteItem(Request $request){

        $time_api_url = 'http://worldtimeapi.org/api/timezone/Asia/Jakarta';

        // Make a GET request to fetch the time data
        $response = file_get_contents($time_api_url);

        // Decode the JSON response
        $time_data = json_decode($response, true);

        // Extract the current time from the response
        $current_time = $time_data['datetime'];
        $datetime = new DateTime($current_time);


        $input = $request->all();
        $data = [
            'deleted_by' => Auth::user()->email,
            'deleted_at' => $datetime
        ];

        $result = "";
        try {
            $temp = $this->model->DeleteItem($input["id"],$data);
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
