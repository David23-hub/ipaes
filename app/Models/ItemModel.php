<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function GetListCheckStock($arr) {
        return ItemModel::all()->whereIn('id',$arr);
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
        $d->qty_min = $data['qty_min'];

        $d->unit = $data['unit'];
        $d->price = $data['price'];
        $d->presentation = $data['presentation'];
        $d->commision_rate = $data['commision_rate'];
        $d->mini_desc = $data['mini_desc'];
        $d->desc = $data['desc'];
        $d->img = $data['img'];

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

    public function UpdateQtyStockPlus($id, $qty){
        DB::statement('UPDATE items SET qty = qty + ? WHERE id = ?', [$qty, $id]);

        return 1;

    }
    public function UpdateQtyStockMinus($id, $qty){
        DB::statement('UPDATE items SET qty = qty - ? WHERE id = ?', [$qty, $id]);

        return 1;

    }
}
