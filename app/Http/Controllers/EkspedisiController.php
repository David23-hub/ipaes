<?php

namespace App\Http\Controllers;

use App\Models\EkspedisiModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EkspedisiController extends Controller
{
    private $model;
    public function __construct()
    {
        $this->middleware('auth');
        $this->model = new EkspedisiModel;
    }

    public function index()
    {

        // $data = $this->model->GetList();

        // $data['data'] = json_encode($data);
        return view('master.ekspedisi');
        // return view('items.list',$data);
    }

    public function getAll(Request $request){
        $data = $this->model->GetList();
        return $data;
    }

    public function getItem(Request $request){
        $input = $request->all();

        $data = $this->model->GetItem($input['id']);

        return $data[0];
    }

    public function addItem(Request $request){
        $input = $request->all();

        $data = [
            'name' => $input['name'],
            'status' => $input['status'],
            'created_by' => Auth::user()->email,
            'created_at' => date('Y-m-d H:i:s')
        ];
        // dd($data);

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
            'updated_by' => Auth::user()->email,
            'updated_at' => date('Y-m-d H:i:s')
        ];

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
