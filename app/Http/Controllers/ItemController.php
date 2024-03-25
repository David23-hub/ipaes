<?php

namespace App\Http\Controllers;

use App\Models\CategoryProductModel;
use App\Models\ItemModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
            if($role!="superuser"&&$role!="admin"){
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

        // $data = $this->model->GetList();

        $data = $this->modelCategoryProduct->GetListActive();
        
        return view('master.item')->with('data', $data);
        // return view('items.list',$data);
    }

    public function getAll(Request $request){
        $result = $this->model->GetList();
        foreach ($result as $key => $value) {
            $result[$key]["price"] = number_format( $result[$key]["price"],0,',','.');
            $result[$key]["qty"] = number_format( $result[$key]["qty"],0,',','.');
        }
        return $result;
    }

    public function getItem(Request $request){
        $input = $request->all();

        $index = $this->model->GetItem($input['id']);
        $index[0]["price"] = number_format($index[0]["price"],0,',','.');
        $index[0]["qty"] = number_format($index[0]["qty"],0,',','.');

        return $index[0];
    }

    public function addItem(Request $request){
        $input = $request->all();

        if ($input["name"]=="" || trim($input['name']=="")) {
            return "Nama Category Harus Diisi!";
        }else if ($input["qty"]=="" || trim($input['qty']=="")) {
            return "Jumlah Barang Harus Diisi!";
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

        $data = [
            'name' => $input['name'],
            'status' => $input['status'],
            'qty' => $input['qty'],

            'unit' => $input['unit'],
            'price' => $input['price'],
            'presentation' => $input['presentation'],
            'commision_rate' => $input['commision_rate'],
            'mini_desc' => $input['mini_desc'],
            'desc' => $input['desc'],
            'img' => $imageName,

            'created_by' => Auth::user()->email,
            'created_at' => date('Y-m-d H:i:s')
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
            $obj['desc'] = "Penambahan Produk ".$data['name'];
            $obj['status'] = "1";
            $obj['created_at'] = date('Y-m-d H:i:s');
            array_push($products, $obj);

            $result = $this->stockController->insert($products);
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
        $input["price"] = str_replace('.', '', $input["price"]);

        $index = $this->model->GetItem($input['id']);
        if(count($index)==0){
            return "gagal";
        }
        $qtyAwal = (int)$index[0]['qty'];

        if ($request->hasFile('img')) {
            // Image is uploaded
            $image = $request->file('img');
            $imageName = time().'.'.$image->getClientOriginalExtension(); // Generate a unique name for the image
            $image->move(public_path('images'), $imageName);

            $data = [
                'name' => $input['name'],
                'status' => $input['status'],
                'qty' => $input['qty'],
                'unit' => $input['unit'],
                'price' => $input['price'],
                'presentation' => $input['presentation'],
                'commision_rate' => $input['commision_rate'],
                'mini_desc' => $input['mini_desc'],
                'desc' => $input['desc'],
                'img' => $imageName,
    
                'updated_by' => Auth::user()->email,
                'updated_at' => date('Y-m-d H:i:s')
            ];
        } else {
            // Image is not uploaded
            $data = [
                'name' => $input['name'],
                'status' => $input['status'],
                'qty' => $input['qty'],
                'unit' => $input['unit'],
                'price' => $input['price'],
                'presentation' => $input['presentation'],
                'commision_rate' => $input['commision_rate'],
                'mini_desc' => $input['mini_desc'],
                'desc' => $input['desc'],
    
                'updated_by' => Auth::user()->email,
                'updated_at' => date('Y-m-d H:i:s')
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
            $obj["id_product"] = $temp;

            if((int)$input['qty']<$qtyAwal){
                $obj['stock_out'] = $qtyAwal-$input['qty'];
                $obj['status'] = "1";
                $obj['desc'] = "Pengurangan Produk Saat Update Stock ".$data['name'];
                $obj['created_at'] = date('Y-m-d H:i:s');
                array_push($products, $obj);

                $result = $this->stockController->insert($products);
            }else if((int)$input['qty']>$qtyAwal){
                $obj['stock_in'] = $input['qty']-$qtyAwal;
                $obj['status'] = "1";
                $obj['desc'] = "Penambahan Produk Saat Update Stock".$data['name'];
                $obj['created_at'] = date('Y-m-d H:i:s');
                array_push($products, $obj);

                $result = $this->stockController->insert($products);
            }
            
            
            return $result;
        } catch (\Throwable $th) {
            $result="gagal";
        }        

        return $result;
    }

    public function deleteItem(Request $request){
        $input = $request->all();
        $data = [
            'deleted_by' => Auth::user()->email,
            'deleted_at' => date('Y-m-d H:i:s')
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
