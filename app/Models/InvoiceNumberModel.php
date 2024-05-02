<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class InvoiceNumberModel extends Model
{
    use HasFactory;
    protected $table = 'invoice_number';
    public $timestamps = false;

    public function GetNumber(){
        $inv = $this->select("*")->get();
        return $inv[0];
    }

    public function UpdateInvoiceNumber($data,$month){
        return $this->where('month','=',$month)->update($data);
	}
    
}
