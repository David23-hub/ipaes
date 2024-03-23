<?php

namespace App\Http\Controllers;

use App\Models\CategoryProductModel;
use App\Models\ItemModel;
use App\Models\PackageModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Untuk list di depan berarti butuh photo, name, price, commision_rate, list_products
 * Untuk Delimiter nya pake gini => id,qty;id,qty;id,qty
 */


class PackageController extends Controller
{
    private $model;
    private $modelCategoryProduct;
    private $modelProduct;
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

        $this->model = new PackageModel;
        $this->modelCategoryProduct = new CategoryProductModel;
        $this->modelProduct = new ItemModel;
    }

    public function index()
    {
        $data = $this->modelCategoryProduct->GetListActive();
        $dataProduct = $this->modelProduct->GetListActive();
        $dataAll = array("dataCategory" => $data, "dataProduct" => $dataProduct);
        return view('master.package')->with('data', $dataAll);
    }

    // 

    public function getAll(Request $request){
        try {
            $products = $this->modelProduct->GetList();
            $data = $this->model->GetList();
            $result = [];
            foreach ($data as $key => $index) {
                
                // foreach ($product as $key => $cat) {
                //     // if ($index->category_product == $cat->id){
                //     //     $index->product_name = $cat->name;
                //     //     break;
                //     // }
    
                // }
                $arrProduct = explode(",", $index->product);
                // Log::info("product", ['result' => $arrProduct]);
                $arrResultProduct = [];
                foreach ($arrProduct as $keyProduct => $singleProduct) {
                    // 1,1
                    $single = explode("|", $singleProduct);
                    foreach ($products as $keyP => $product) {
                        if ($single[1] == $product->id) {
                            $name = "$product->name ( $single[0] $product->unit )";
                            array_push($arrResultProduct, $name);
                            break;
                        }
                    }
                }
                $index->product = $arrResultProduct;
                $index["price"] = number_format( $index["price"],0,',','.');
                array_push($result, $index);
            }
            return $result;
        } catch (\Throwable $th) {
            Log::error("error di throwable");
            Log::error($th);
        }  
    }

    public function getItem(Request $request){
        $input = $request->all();

        Log::info("masuk", ['message masuk sini']);
        $category = $this->modelCategoryProduct->GetList();
        $data = $this->model->GetItem($input['id']);
        $result = [];


        foreach ($data as $key => $index) {
            foreach ($category as $key => $cat) {
                if(isset($index['category_product'])) {
                    if ($index->category_product == $cat->id){
                        $index->category = $cat->name;
                        break;
                    }
                }
            }
            array_push($result,$index);
        }


        return $result[0];
    }

    public function addItem(Request $request){
        $input = $request->all();

        if ($input["name"]=="" || trim($input['name']=="") ) {
            return "Nama Paket Harus Diisi!";
        }else if ($input["price"]=="" || trim($input['price']=="")) {
            return "Harga Paket Harus Diisi!";
        }else if ($input["commision_rate"]=="" || trim($input['commision_rate']=="")) {
            return "Rate Komisi Harus Diisi!";
        }

        $imageName = "";
        if(!empty($request->file('img'))) {
            $image = $request->file('img');
            $imageName = time().'.'.$image->getClientOriginalExtension(); // Generate a unique name for the image
            $image->move(public_path('images'), $imageName);
        }

        $input["price"] = str_replace('.', '', $input["price"]);
        $input["product"] = str_replace('.', '', $input["product"]);

        $data = [
            'name' => $input['name'],
            'product' => $input['product'],
            // 'category_product' => $input['category_product'],
            'price' => $input['price'],
            'commision_rate' => $input['commision_rate'],
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
            }
        } catch (\Throwable $th) {
            Log::error($th);
            dd($th);
            $result="gagal2";
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
