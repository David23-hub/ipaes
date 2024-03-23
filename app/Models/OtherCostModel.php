<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OtherCostModel extends Model
{
    use HasFactory;
    protected $table = 'other_cost';
    public $timestamps = false;

    public function GetAll(){
        return OtherCostModel::all();
    }

    public function GetAllByRange($start,$end) {
        return $this->whereBetween(DB::raw('DATE(created_at)'),[$start,$end]);
    }

    public function GetList(){
        return OtherCostModel::all()->where('deleted_by',null);
    }

    public function GetListActive() {
        return OtherCostModel::all()->where('deleted_by',null)->where("status",1);
    }
    
    public function GetItem($id){
        return $this
        ->where('id', '=', $id)
        ->get();
    }

    public function AddItem($data){
        $d = new OtherCostModel;
        $d->name = $data['date'];
        $d->status = $data['price'];
        $d->qty = $data['note'];
        $d->created_by = $data['created_by'];
        $d->created_at = $data['created_at'];

        $d->save();
        return $d->id;
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
