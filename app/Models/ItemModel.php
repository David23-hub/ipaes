<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemModel extends Model
{
    use HasFactory;
    protected $table = 'items';
    public $timestamps = false;

    public function GetAll(){
        return ItemModel::all();
    }

    public function GetList(){
        return ItemModel::all()->where('deleted_by',null);
    }

    public function GetListActive() {
        return ItemModel::all()->where('deleted_by',null)->where("status",1);
    }
    
    public function GetItem($id){
        return $this
        ->where('id', '=', $id)
        ->get();
    }

    public function AddItem($data){
        $d = new ItemModel;
        $d->name = $data['name'];
        $d->status = $data['status'];
        $d->qty = $data['qty'];

        $d->unit = $data['unit'];
        $d->price = $data['price'];
        $d->presentation = $data['presentation'];
        $d->commision_rate = $data['commision_rate'];
        $d->mini_desc = $data['mini_desc'];
        $d->desc = $data['desc'];
        $d->img = $data['img'];

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
