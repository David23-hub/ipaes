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
        ->join('users', 'cart.created_by', '=', DB::raw('users.email collate utf8mb4_unicode_ci'))
        ->select('cart.*', 'dokter.name as doctor_name', 'dokter.clinic as clinic', 'dokter.address as address', 'dokter.billing_no_hp as billing_no_hp', 'dokter.no_hp as no_hp','users.name as created_by')
        ->whereBetween(DB::raw('DATE(cart.created_at)'),[$start,$end])
        ->where('cart.deleted_by',null)
        ->get();
    }

    public function GetListJoinDoctorAndDateAndStatus($start,$end,$status, $role, $email) {
        if($status == "all") {
            if($role == "superuser" || $role == "admin" || $role == "manager") {
                return $this
                ->join('users', 'cart.created_by', '=', DB::raw('users.email collate utf8mb4_unicode_ci'))
                ->join('dokter', 'cart.doctor_id', '=', 'dokter.id')
                ->select('cart.*', 'dokter.name as doctor_name', 'dokter.clinic as clinic', 'dokter.address as address', 'dokter.billing_no_hp as billing_no_hp', 'dokter.no_hp as no_hp', 'users.role as role','users.name as user_name')
                ->whereBetween(DB::raw('DATE(cart.created_at)'),[$start,$end])
                ->where('cart.deleted_by',null)
                ->orderBy('cart.created_at', 'desc')
                ->get();
            } else {
                return $this
                ->join('users', 'cart.created_by', '=', DB::raw('users.email collate utf8mb4_unicode_ci'))
                ->join('dokter', 'cart.doctor_id', '=', 'dokter.id')
                ->select('cart.*', 'dokter.name as doctor_name', 'dokter.clinic as clinic', 'dokter.address as address', 'dokter.billing_no_hp as billing_no_hp', 'dokter.no_hp as no_hp', 'users.role as role','users.name as user_name')
                ->whereBetween(DB::raw('DATE(cart.created_at)'),[$start,$end])
                ->where('cart.management_order', '=', '0')
                ->where('cart.created_by', '=', $email)
                ->where('cart.deleted_by',null)
                ->orderBy('cart.created_at', 'desc')
                ->get();
            }
        } else {
            if($role == "superuser" || $role == "admin") {
                return $this
                ->join('users', 'cart.created_by', '=', DB::raw('users.email collate utf8mb4_unicode_ci'))
                ->join('dokter', 'cart.doctor_id', '=', 'dokter.id')
                ->select('cart.*', 'dokter.name as doctor_name', 'dokter.clinic as clinic', 'dokter.address as address', 'dokter.billing_no_hp as billing_no_hp', 'dokter.no_hp as no_hp', 'users.name as user_name')
                ->whereBetween(DB::raw('DATE(cart.created_at)'),[$start,$end])
                ->whereIn('cart.status', $status)
                ->where('cart.deleted_by',null)
                ->orderBy('cart.created_at', 'desc')
                ->get();
            } else {
                return $this
                ->join('users', 'cart.created_by', '=', DB::raw('users.email collate utf8mb4_unicode_ci'))
                ->join('dokter', 'cart.doctor_id', '=', 'dokter.id')
                ->select('cart.*', 'dokter.name as doctor_name', 'dokter.clinic as clinic', 'dokter.address as address', 'dokter.billing_no_hp as billing_no_hp', 'dokter.no_hp as no_hp', 'users.name as user_name')
                ->whereBetween(DB::raw('DATE(cart.created_at)'),[$start,$end])
                ->where('cart.created_by', '=', $email)
                ->where('cart.management_order', '=', '0')
                ->whereIn('cart.status', $status)
                ->where('cart.deleted_by',null)
                ->orderBy('cart.created_at', 'desc')
                ->get();
            }
        }
    }
    
    public function GetListJoinDoctorDashboard($start,$end) {
        return $this
            ->join('users', 'cart.created_by', '=', DB::raw('users.email collate utf8mb4_unicode_ci'))
            ->join('dokter', 'cart.doctor_id', '=', 'dokter.id')
            ->select('cart.*', 'dokter.name as doctor_name', 'dokter.clinic as clinic', 'dokter.address as address', 'dokter.billing_no_hp as billing_no_hp', 'dokter.no_hp as no_hp', 'users.name as user_name', DB::raw('DATE(cart.created_at) as created'))
            ->whereBetween(DB::raw('DATE(cart.created_at)'),[$start,$end])
            ->where('cart.status', "0")
            ->where('cart.deleted_by',null)
            ->orderBy('cart.id', 'desc')
            ->take(10)
            ->get();
    }

    // public function GetListJoinCartAndDateAndStatus($start,$end,$status) {
    //     if($status == "all") {
    //         return $this->join('dokter', 'cart.doctor_id', '=', 'dokter.id')
    //         ->select('cart.*', 'dokter.name as doctor_name', 'dokter.clinic as clinic', 'dokter.address as address', 'dokter.billing_no_hp as billing_no_hp', 'dokter.no_hp as no_hp')
    //         ->whereBetween(DB::raw('DATE(cart.created_at)'),[$start,$end])
    //         ->where('cart.deleted_by',null)
    //         ->get();
    //     } else {
    //         return $this->join('dokter', 'cart.doctor_id', '=', 'dokter.id')
    //         ->select('cart.*', 'dokter.name as doctor_name', 'dokter.clinic as clinic', 'dokter.address as address', 'dokter.billing_no_hp as billing_no_hp', 'dokter.no_hp as no_hp')
    //         ->whereBetween(DB::raw('DATE(cart.created_at)'),[$start,$end])
    //         ->where('cart.status', $status)
    //         ->where('cart.deleted_by',null)
    //         ->get();
    //     }
    // }

    public function GetListJoinDoctorAndDateWithUser($start,$end,$listUser) {
        if($listUser!="all"){
            return $this->join('dokter', 'cart.doctor_id', '=', 'dokter.id')
            ->join('users', 'cart.created_by', '=', DB::raw('users.email collate utf8mb4_unicode_ci'))
            ->select('cart.*', 'dokter.name as doctor_name', 'dokter.clinic as clinic', 'dokter.address as address', 'dokter.billing_no_hp as billing_no_hp', 'dokter.no_hp as no_hp','users.name as created_by')
            ->whereBetween(DB::raw('DATE(cart.created_at)'),[$start,$end])
            ->whereIn('cart.created_by', $listUser)
            ->where('cart.deleted_by',null)
            ->orderBy('cart.created_by', 'desc')
            ->get();
        }else if($listUser=="all"){
            return $this->join('dokter', 'cart.doctor_id', '=', 'dokter.id')
            ->join('users', 'cart.created_by', '=', DB::raw('users.email collate utf8mb4_unicode_ci'))
            ->select('cart.*', 'dokter.name as doctor_name', 'dokter.clinic as clinic', 'dokter.address as address', 'dokter.billing_no_hp as billing_no_hp', 'dokter.no_hp as no_hp','users.name as created_by')
            ->whereBetween(DB::raw('DATE(cart.created_at)'),[$start,$end])
            ->where('cart.deleted_by',null)
            ->orderBy('cart.created_by', 'desc')
            ->get();
        }
    }

    public function GetListJoinDoctorAndDateWithUserAndManagementOrder($start,$end,$roleUser, $listUser) {
        if($roleUser == "manager"){
            return $this->join('dokter', 'cart.doctor_id', '=', 'dokter.id')
            ->join('users', 'cart.created_by', '=', DB::raw('users.email collate utf8mb4_unicode_ci'))
            ->select('cart.*', 'dokter.name as doctor_name', 'dokter.clinic as clinic', 'dokter.address as address', 'dokter.billing_no_hp as billing_no_hp', 'dokter.no_hp as no_hp', 'users.img as img')
            ->whereBetween(DB::raw('DATE(cart.created_at)'),[$start,$end])
            ->where('cart.management_order', '0')
            ->where('cart.deleted_by',null)
            ->orderBy('cart.created_by', 'desc')
            ->get();
        }else if($roleUser=="superuser" || $roleUser == "admin" || $roleUser=="finance"){
            return $this->join('dokter', 'cart.doctor_id', '=', 'dokter.id')
            ->select('cart.*', 'dokter.name as doctor_name', 'dokter.clinic as clinic', 'dokter.address as address', 'dokter.billing_no_hp as billing_no_hp', 'dokter.no_hp as no_hp')
            ->whereBetween(DB::raw('DATE(cart.created_at)'),[$start,$end])
            ->where('cart.deleted_by',null)
            ->orderBy('cart.created_by', 'desc')
            ->get();
        } else {
            return $this->join('dokter', 'cart.doctor_id', '=', 'dokter.id')
            ->select('cart.*', 'dokter.name as doctor_name', 'dokter.clinic as clinic', 'dokter.address as address', 'dokter.billing_no_hp as billing_no_hp', 'dokter.no_hp as no_hp')
            ->whereBetween(DB::raw('DATE(cart.created_at)'),[$start,$end])
            ->where('cart.created_by', $listUser)
            ->where('cart.management_order', '0')
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

    public function GetListJoinDoctorWithDoctorIdAndEmail($id, $role, $email, $status, $startDate, $endDate) {
        if($status[0] == "all") {
            if($role == "superuser" || $role == "admin" || $role == "manager") {
                return $this->join('dokter', 'cart.doctor_id', '=', 'dokter.id')
                ->where('dokter.id', '=', $id)
                ->whereBetween(DB::raw('DATE(cart.created_at)'),[$startDate,$endDate])
                ->orderBy('cart.created_at', 'desc')->select('cart.*' )->get();        
            } else {
                return $this->join('dokter', 'cart.doctor_id', '=', 'dokter.id')->where('dokter.id', '=', $id)
                ->where('cart.created_by', '=', $email)
                ->where('cart.management_order', '==', '0')
                ->whereBetween(DB::raw('DATE(cart.created_at)'),[$startDate,$endDate])
                ->orderBy('cart.created_at', 'desc')->select('cart.*' )->get();
            }
        }else{
            if($role == "superuser" || $role == "admin" || $role == "manager") {
                return $this->join('dokter', 'cart.doctor_id', '=', 'dokter.id')
                ->where('dokter.id', '=', $id)
                ->whereBetween(DB::raw('DATE(cart.created_at)'),[$startDate,$endDate])
                ->whereIn('cart.status', $status)
                ->orderBy('cart.created_at', 'desc')->select('cart.*' )->get();        
            } else {
                return $this->join('dokter', 'cart.doctor_id', '=', 'dokter.id')->where('dokter.id', '=', $id)
                ->where('cart.created_by', '=', $email)
                ->whereBetween(DB::raw('DATE(cart.created_at)'),[$startDate,$endDate])
                ->where('cart.management_order', '==', '0')
                ->whereIn('cart.status', $status)
                ->orderBy('cart.created_at', 'desc')->select('cart.*' )->get();
            }
        }
    }

    public function GetListJoinDoctorWithCartId($id) {
        return $this->join('dokter', 'cart.doctor_id', '=', 'dokter.id')->where('cart.id', '=', $id)->orderBy('cart.id', 'desc')->select('cart.*' )->get();
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
