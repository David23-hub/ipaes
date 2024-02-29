<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokterModel extends Model
{
    use HasFactory;
    protected $table = 'dokter';
    public $timestamps = false;

    public function GetList(){
        return DokterModel::all()->where('deleted_by',null);
    }

    public function GetListActive(){
        return DokterModel::all()->where('deleted_by',null)->where('status',1);
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
