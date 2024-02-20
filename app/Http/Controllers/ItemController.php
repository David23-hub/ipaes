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
    public function __construct()
    {
        $this->middleware('auth');
        $this->model = new ItemModel;
        $this->modelCategoryProduct = new CategoryProductModel;
    }

    public function index()
    {

        // $data = $this->model->GetList();

        $data = $this->modelCategoryProduct->GetListActive();
        return view('master.item')->with('data', $data);
        // return view('items.list',$data);
    }

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

        $data = [
            'name' => $input['name'],
            'status' => $input['status'],
            'qty' => $input['qty'],
            'category_product' => $input['category_product'],
            'unit' => $input['unit'],
            'price' => $input['price'],
            'presentation' => $input['presentation'],
            'commision_rate' => $input['commision_rate'],
            'mini_desc' => $input['mini_desc'],
            'desc' => $input['desc'],

            'created_by' => Auth::user()->email,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $result = "";
        try {
            $temp = $this->model->AddItem($data);
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

    public function updateItem(Request $request){
        $input = $request->all();

        $data = [
            'name' => $input['name'],
            'status' => $input['status'],
            'qty' => $input['qty'],
            'category_product' => $input['category_product'],
            'unit' => $input['unit'],
            'price' => $input['price'],
            'presentation' => $input['presentation'],
            'commision_rate' => $input['commision_rate'],
            'mini_desc' => $input['mini_desc'],
            'desc' => $input['desc'],

            'updated_by' => Auth::user()->email,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        // var_dump($input["id"]);

        $result = "";
        try {
            $temp = $this->model->UpdateItem($input["id"],$data);
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
