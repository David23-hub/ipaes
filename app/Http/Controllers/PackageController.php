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
        $category = $this->modelCategoryProduct->GetList();
        $data = $this->model->GetList();
        $result = [];

        foreach ($data as $key => $index) {
            foreach ($category as $key => $cat) {
                if ($index->category_product == $cat->id){
                    $index->category = $cat->name;
                    break;
                }
            }
            array_push($result,$index);
        }


        
        return $result;
    }

    public function getItem(Request $request){
        $input = $request->all();

        $category = $this->modelCategoryProduct->GetList();
        $data = $this->model->GetItem($input['id']);
        $result = [];

        foreach ($data as $key => $index) {
            foreach ($category as $key => $cat) {
                if ($index->category_product == $cat->id){
                    $index->category = $cat->name;
                    break;
                }
            }
            array_push($result,$index);
        }


        return $result[0];
    }

    public function addItem(Request $request){
        $input = $request->all();
        $imageName = "";
        if(!empty($request->file('img'))) {
            $image = $request->file('img');
            $imageName = time().'.'.$image->getClientOriginalExtension(); // Generate a unique name for the image
            $image->move(public_path('images'), $imageName);
        }

        $data = [
            'name' => $input['name'],
            'product' => $input['product'],
            'category_product' => $input['category_product'],
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
