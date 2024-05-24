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
        
        $this->middleware(function ($request, $next) {
            $role = auth()->user()->role;
            if($role!="superuser"&&$role!="admin"&&$role!="manager"&&$role!="marketing"){
                    abort(403, 'Unauthorized access');
                }
            return $next($request);
          });

        $this->model = new DokterModel;
    }

    public function index()
    {
        return view('master.dokter');
    }

    public function getAll(Request $request){
        if(Auth::user()->role=="superuser"||Auth::user()->role=="admin"){
            $data = $this->model->GetList();
        }else{
            $data = $this->model->GetListBaseOnRole(Auth::user()->name, Auth::user()->role);
        }

        foreach ($data as $key=> $value) {
            if(Auth::user()->role=="superuser"||Auth::user()->role=="admin" ||Auth::user()->role=="marketing"){
                $data[$key]['btn'] = '
                <button class="btn btn-info" onclick="getItem(' . $value['id'] . ')">Detail</button>
                <button class="btn btn-primary" onclick="getItemUpdate(' . $value['id'] . ')">Update</button>
                <button class="btn btn-danger" onclick="deleteItem(' . $value['id'] . ')">Delete</button>';
            }else if(Auth::user()->role=="manager"){
                $data[$key]['btn'] = '
                <button class="btn btn-info" onclick="getItem(' . $value['id'] . ')">Detail</button>';
            }else  {
                $data[$key]['btn'] = 'Cannot Do Action';
            }
        }
        return $data;
    }

    public function getItem(Request $request){
        $input = $request->all();

        $data = $this->model->GetItem($input['id']);

        return $data[0];
    }

    public function addItem(Request $request){
        $input = $request->all();
        
        if ($input["name"]=="" || trim($input['name']=="")) {
            return "Nama Harus Diisi!";
        }else if ($input["address"]=="" || trim($input['address']=="")) {
            return "Alamat Harus Diisi!";
        }else if ($input["clinic"]=="" || trim($input['clinic']=="")) {
            return "Klinik Harus Diisi!";
        }else if ($input["no_hp"]=="" || trim($input['no_hp']=="")) {
            return "Nomor Hp Harus Diisi!";
        }else if($input["dob"]=="" || trim($input['dob']=="") || $input["dob"]==null){
            return "Tanggal Lahir Harus Diisi!";
        }else if ($input["billing_no_hp"]=="" || trim($input['billing_no_hp']=="")) {
            return "Billing Nomor Hp Harus Diisi!";
        }


        $visible_lower = 0;
        if(Auth::user()->role=="superuser"||Auth::user()->role=="admin"){
            $visible_lower = 1;
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
            'visible_lower' => $input['visible_lower'],
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

        if ($input["name"]=="" || trim($input['name']=="")) {
            return "Nama Harus Diisi!";
        }else if ($input["address"]=="" || trim($input['address']=="")) {
            return "Alamat Harus Diisi!";
        }else if ($input["clinic"]=="" || trim($input['clinic']=="")) {
            return "Klinik Harus Diisi!";
        }else if ($input["no_hp"]=="" || trim($input['no_hp']=="")) {
            return "Nomor Hp Harus Diisi!";
        }else if($input["dob"]=="" || trim($input['dob']=="") || $input["dob"]==null){
            return "Tanggal Lahir Harus Diisi!";
        }else if ($input["billing_no_hp"]=="" || trim($input['billing_no_hp']=="")) {
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
