<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $data['label'] = ["senin","selasa","rabu","kamis","jumat"];
        $data['data'] = [1,2,3,4,-5];
        $result['kiri_1'] = json_encode($data);
        $result['kiri_2'] = json_encode($data);
        $result['tengah_1'] = json_encode($data);
        $result['kanan_1'] = json_encode($data);
        // dd($data);
        return view('dashboard',$result);
    }
}
