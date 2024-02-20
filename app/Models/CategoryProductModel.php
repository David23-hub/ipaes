<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryProductModel extends Model
{
    use HasFactory;
    protected $table = 'category_product';
    public $timestamps = false;

    public function GetList(){
        return CategoryProductModel::all()->where('deleted_by',null);
    }
    public function GetListActive(){
        return CategoryProductModel::all()->where('deleted_by',null)->where("status",1);
    }
    
    public function GetItem($id){
        return $this
        ->where('id', '=', $id)
        ->get();
    }

    public function AddItem($data){
        $d = new CategoryProductModel;
        $d->name = $data['name'];
        $d->status = $data['status'];
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
