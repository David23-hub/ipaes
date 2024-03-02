<?php

namespace App\Http\Controllers;
use App\Models\ItemModel;
use App\Models\PackageModel;



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * 
     * @return void
     */

    private $model;
    private $package;
     
    public function __construct()
    {
        // $this->middleware('auth');
        $this->model = new ItemModel;
        $this->package = new PackageModel;


    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $items = $this->model->GetListActive();
        $package = $this->package->GetListActive();
        return view('part/home')->with('items',$items)->with('package',$package);
    }
}
