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
        return view('master.dokter');
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
        
        if (!preg_match('/^[a-zA-Z\s]+$/', $input["name"])) {
            return "Nama Harus Diisi!";
        }else if (!preg_match('/^[a-zA-Z\s]+$/', $input["address"])) {
            return "Alamat Harus Diisi!";
        }else if (!preg_match('/^[a-zA-Z\s]+$/', $input["clinic"])) {
            return "Klinik Harus Diisi!";
        }else if (!preg_match('/^[0-9]+$/', $input["no_hp"])) {
            return "Nomor Hp Harus Diisi!";
        }else if (!preg_match('/^[a-zA-Z\s]+$/', $input["dob"])) {
            return "Tanggal Lahir Harus Diisi!";
        }else if (!preg_match('/^[0-9]+$/', $input["billing_no_hp"])) {
            return "Billing Nomor Hp Harus Diisi!";
        }


        $data = [
            'name' => $input['name'],
            'status' => $input['status'],
            'address' => $input['address'],
            'clinic' => $input['clinic'],
            'no_hp' => $input['no_hp'],
            'information' => $input['information'],
            'dob' => $input['dob'],
            'billing_no_hp' => $input['billing_no_hp'],
            'created_by' => Auth::user()->name,
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

        if (!preg_match('/^[a-zA-Z\s]+$/', $input["name"])) {
            return "Nama Harus Diisi!";
        }else if (!preg_match('/^[a-zA-Z\s]+$/', $input["address"])) {
            return "Alamat Harus Diisi!";
        }else if (!preg_match('/^[a-zA-Z\s]+$/', $input["clinic"])) {
            return "Klinik Harus Diisi!";
        }else if (!preg_match('/^[0-9]+$/', $input["no_hp"])) {
            return "Nomor Hp Harus Diisi!";
        }else if (!preg_match('/^[a-zA-Z\s]+$/', $input["information"])) {
            return "Informasi Harus Diisi!";
        }else if (!preg_match('/^[a-zA-Z\s]+$/', $input["dob"])) {
            return "Tanggal Lahir Harus Diisi!";
        }else if (!preg_match('/^[0-9]+$/', $input["billing_no_hp"])) {
            return "Billing Nomor Hp Harus Diisi!";
        }

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
