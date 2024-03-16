<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CartModel extends Model
{
    use HasFactory;
    protected $table = 'cart';
    public $timestamps = false;

    public function GetList($email){
        return CartModel::all()->where('deleted_by',null)->where('created_by',$email);
    }

    public function GetListAll(){
        return CartModel::all()->where('deleted_by',null);
    }

    public function GetListJoinDoctor() {
        return $this->join('dokter', 'cart.doctor_id', '=', 'dokter.id')->select('cart.*', 'dokter.name as doctor_name', 'dokter.clinic as clinic')->get();
    }

    public function GetListJoinDoctorAndDate($start,$end) {
        return $this->join('dokter', 'cart.doctor_id', '=', 'dokter.id')
        ->select('cart.*', 'dokter.name as doctor_name', 'dokter.clinic as clinic', 'dokter.address as address', 'dokter.billing_no_hp as billing_no_hp', 'dokter.no_hp as no_hp')
        ->whereBetween(DB::raw('DATE(cart.created_at)'),[$start,$end])
        ->where('cart.deleted_by',null)
        ->get();
    }

    public function GetListJoinDoctorAndDateWithUser($start,$end,$listUser) {
        if($listUser!="all"){
            return $this->join('dokter', 'cart.doctor_id', '=', 'dokter.id')
            ->select('cart.*', 'dokter.name as doctor_name', 'dokter.clinic as clinic', 'dokter.address as address', 'dokter.billing_no_hp as billing_no_hp', 'dokter.no_hp as no_hp')
            ->whereBetween(DB::raw('DATE(cart.created_at)'),[$start,$end])
            ->whereIn('cart.created_by', $listUser)
            ->where('cart.deleted_by',null)
            ->orderBy('cart.created_by', 'desc')
            ->get();
        }else if($listUser=="all"){
            return $this->join('dokter', 'cart.doctor_id', '=', 'dokter.id')
            ->select('cart.*', 'dokter.name as doctor_name', 'dokter.clinic as clinic', 'dokter.address as address', 'dokter.billing_no_hp as billing_no_hp', 'dokter.no_hp as no_hp')
            ->whereBetween(DB::raw('DATE(cart.created_at)'),[$start,$end])
            ->where('cart.deleted_by',null)
            ->orderBy('cart.created_by', 'desc')
            ->get();
        }
        
    }

    public function GetListJoinDoctorWithId($id) {
        return $this->join('dokter', 'cart.doctor_id', '=', 'dokter.id')->where('cart.id', '=', $id)->select('cart.*', 'dokter.name as name', 'dokter.clinic as clinic', 'dokter.billing_no_hp as billing_no_hp', 'dokter.no_hp as no_hp', 'dokter.address as address', 'dokter.information as information' )->get();
    }

    public function GetListJoinDoctorWithDoctorId($id) {
        return $this->join('dokter', 'cart.doctor_id', '=', 'dokter.id')->where('dokter.id', '=', $id)->select('cart.*' )->get();
    }
    
    public function GetItem($id,$email){
        return $this
        ->where('id', '=', $id)
        ->where('created_by', '=', $email)
        ->where('deleted_by',null)
        ->get();
    }

    public function GetItemWithoutEmail($id){
        return $this
        ->where('id', '=', $id)
        ->where('deleted_by',null)
        ->get();
    }

    public function GetItemWithEmail($email){
        return $this
        ->where('created_by', '=', $email)
        ->where('deleted_by',null)
        ->get();
    }

    public function GetCart($email){
        return $this
        ->where('created_by', '=', $email)
        ->where('po_id',null)
        ->where('deleted_by',null)
        ->get();
    }

    public function AddItem($data){
        $d = new CartModel;
        $d->cart = $data['cart'];

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
