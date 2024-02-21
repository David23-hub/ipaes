<?php

namespace App\Http\Controllers;

use App\Models\DokterModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DokterController extends Controller
{
    private $model;
    public function __construct()
    {
        $this->middleware('auth');
        $this->model = new DokterModel;
    }

    public function index()
    {

        // $data = $this->model->GetList();

        // $data['data'] = json_encode($data);
        return view('master.dokter');
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
        // echo("masukkk ke function");
        // echo($input['dob']);
        // echo(gettype($input['dob']));
        // print_r($input['dob']);
        $data = [
            'name' => $input['name'],
            'status' => $input['status'],
            'address' => $input['address'],
            'clinic' => $input['clinic'],
            'no_hp' => $input['no_hp'],
            'information' => $input['information'],
            'dob' => $input['dob'],
            'billing_no_hp' => $input['billing_no_hp'],
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
            Log::info($th);
            echo("errorr catch");
            $result="gagal";
        }        

        return $result;
    }

    public function updateItem(Request $request){
        $input = $request->all();

        $data = [
            'name' => $input['name'],
            'status' => $input['status'],
            'address' => $input['address'],
            'clinic' => $input['clinic'],
            'no_hp' => $input['no_hp'],
            'information' => $input['information'],
            'dob' => $input['dob'],
            'billing_no_hp' => $input['billing_no_hp'],
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
