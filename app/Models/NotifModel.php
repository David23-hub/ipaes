<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifModel extends Model
{
    use HasFactory;
    protected $table = 'notif';
    public $timestamps = false;

    public function GetList(){
        // return NotifModel::all()->sortByDesc('created_at');;
        return NotifModel::orderBy('created_at', 'desc')->get();
    }
    public function GetListActive(){
        return NotifModel::all()->where('deleted_by',null)->where("status",1);
    }
    
    public function GetItem($id){
        return $this
        ->where('id', '=', $id)
        ->get();
    }

    public function AddItem($data){
        $d = new NotifModel;
        $d->msg = $data['msg'];
        $d->created_by = $data['created_by'];
        $d->created_at = $data['created_at'];
        return $d->save();
    }

    public function DeleteItem($id, $data){
        return $this
        ->where('id', '=', $id)
        ->update( $data);
    }
}
