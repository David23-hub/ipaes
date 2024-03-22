<?php

namespace App\Http\Controllers;

use App\Models\EkspedisiModel;
use App\Models\SalaryModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    private $model;
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(function ($request, $next) {
            $role = auth()->user()->role;
            if($role!="superuser"){
                    abort(403, 'Unauthorized access');
                }
            return $next($request);
          });
          
        $this->model = new SalaryModel;
    }

    public function index()
    {

        // $data = $this->model->GetList();

        return view('master.salary');
        // return view('items.list',$data);
    }

    public function getAll(Request $request){
        $res = [];
        $data = $this->model->GetList();
        foreach ($data as  $value) {
            $value["price"]="Rp ".number_format($value["price"],0,',','.');
            array_push($res,$value);
        }
        return $res;
    }

    public function getItem(Request $request){
        $input = $request->all();

        $data = $this->model->GetItem($input['id']);

        $timestamp = strtotime($data[0]['date']);
        $data[0]['date'] = date('Y-m', $timestamp);

        return $data[0];
    }

    public function addItem(Request $request){
        $input = $request->all();

        if ($input["month"]=="" || trim($input['month']=="")) {
            return "Bulan Salary Harus Diisi!";
        }else if ($input["price"]=="" || trim($input['price']=="")) {
            return "Value Salary Harus Diisi!";
        }

        $input["price"] = str_replace('.', '', $input["price"]);

        $date = \DateTime::createFromFormat('Y-m', $input["month"]);
        $formattedDate = $date->format('Y F');

        $data = [
            'date' => $formattedDate,
            'price' => $input['price'],
            'note' => $input['note'],
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

        if ($input["month"]=="" || trim($input['month']=="")) {
            return "Bulan Salary Harus Diisi!";
        }else if ($input["price"]=="" || trim($input['price']=="")) {
            return "Value Salary Harus Diisi!";
        }

        $input["price"] = str_replace('.', '', $input["price"]);

        $date = \DateTime::createFromFormat('Y-m', $input["month"]);
        $formattedDate = $date->format('Y F');

        $data = [
            'date' => $formattedDate,
            'price' => $input['price'],
            'note' => $input['note'],
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
