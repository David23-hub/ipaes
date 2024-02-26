<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListProductModel extends Model
{
    use HasFactory;
    protected $table = 'items';
    public $timestamps = false;

    public function GetList(){
        return ListProductModel::all()->where('deleted_by',null);
    }
    
    public function GetItem($id){
        return $this
        ->where('id', '=', $id)
        ->get();
    }

    public function AddItem($data){
        $d = new ListProductModel;
        $d->name = $data['name'];
        $d->status = $data['status'];
        $d->qty = $data['qty'];

        $d->category_product = $data['category_product'];
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
