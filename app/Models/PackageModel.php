<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageModel extends Model
{
    use HasFactory;
    protected $table = 'package';
    public $timestamps = false;

    public function GetList(){
        return PackageModel::all()->where('deleted_by',null);
    }
    
    public function GetItem($id){
        return $this
        ->where('id', '=', $id)
        ->get();
    }

    public function AddItem($data){
        $d = new PackageModel;
        $d->name = $data['name'];
        $d->product = $data['product'];
        $d->category_product = $data['category_product'];
        $d->price = $data['price'];
        $d->commision_rate = $data['commision_rate'];
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
