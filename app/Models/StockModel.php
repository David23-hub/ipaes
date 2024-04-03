<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StockModel extends Model
{
    use HasFactory;
    protected $table = 'stock';
    public $timestamps = false;

    public function GetList($start,$end,$listItem){
        if($listItem=="all"){
            return $this->join('items','items.id','=','stock.id_product')
            ->select('stock.*','items.name','items.unit')
            ->whereBetween(DB::raw('DATE(stock.created_at)'),[$start,$end])
            ->orderBy('stock.id_product', 'asc')
            ->get();
        }else{
            return $this->join('items','items.id','=','stock.id_product')
            ->select('stock.*','items.name','items.unit')
            ->whereIn('stock.id_product', $listItem)
            ->whereBetween(DB::raw('DATE(stock.created_at)'),[$start,$end])
            ->orderBy('stock.id_product', 'asc')
            ->get();
        }
    }
    

    public function AddItem($data){
        $d = new StockModel;
        $d->id_product = $data['id_product'];
        $d->stock_in = $data['stock_in'];
        $d->stock_out = $data['stock_out'];
        $d->desc = $data['desc'];
        $d->cart_id = $data['cart_id'];
        $d->created_at = $data['created_at'];
        return $d->save();
    }

    public function AddItems($data){
        return StockModel::insert($data);        
    }

    public function GetItems($id,$status){
        return StockModel::all()->where('cart_id',$id)->where('status',$status);
    }
}
