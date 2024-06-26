<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DokterModel extends Model
{
    use HasFactory;
    protected $table = 'dokter';
    public $timestamps = false;

    public function GetList(){
        return DokterModel::all()->where('deleted_by',null);
    }
    
    public function GetListBaseOnRole(string $created, string $role){
        
        if($role=="manager"){
            return DokterModel::all()->where('visible_lower',0)->where('deleted_by',null);
        }else if($role=="marketing"){
            return DokterModel::all()->where('created_by',$created)->where('deleted_by',null);
        }
    }

    public function GetListWhereIn($in){
        $arr = [];
        foreach ($in as $value) {
            # code...
            $check = $this->where('id', $value)->get();
            array_push($arr, $check[0]);
        }
        return $arr;
    }

    public function GetListActive(string $email, string $role){
        
        if($role=="superuser"||$role=="admin"){
            return DokterModel::all()->where('deleted_by',null)->where('status',1);
        }else if($role=="manager"){
            return DokterModel::all()->where("visible_lower",0)->where('deleted_by',null)->where('status',1);
        }else{
            return DokterModel::all()->where('created_by',$email)->where("visible_lower",0)->where('deleted_by',null)->where('status',1);
        }
    }

    public function GetListWithOrderTransaction() {
        return $this->leftJoin('cart', 'dokter.id', '=', 'cart.doctor_id')->orderBy('cart.created_at', 'desc')->select('dokter.*')->get();
    }

    public function GetListDoctorAndDate() {
        return $this
        ->where('deleted_by',null)
        ->get();
    }
    
    
    public function GetItem($id){
        return $this
        ->where('id', '=', $id)
        ->get();
    }

    public function SingleItem($id){
        return $this
        ->where('id', '=', $id)
        ->first();
    }

    public function AddItem($data){
        $d = new DokterModel;
        $d->name = $data['name'];
        $d->status = $data['status'];
        $d->address = $data['address'];
        $d->clinic = $data['clinic'];
        $d->no_hp = $data['no_hp'];
        $d->information = $data['information'];
        $d->dob = $data['dob'];
        $d->billing_no_hp = $data['billing_no_hp'];
        $d->visible_lower = $data['visible_lower'];
        $d->created_by = $data['created_by'];
        $d->created_at = $data['created_at'];
        return $d->save();
    }

    public function UpdateItem($id, $data){
        return $this
        ->where('id', '=', $id)
        ->update($data);
    }

    public function DeleteItem($id, $data){
        return $this
        ->where('id', '=', $id)
        ->update( $data);
    }
}
