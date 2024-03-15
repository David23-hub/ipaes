<?php

namespace App\Http\Controllers;

use App\Models\CategoryProductModel;
use App\Models\ItemModel;
use App\Models\PackageModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
  
use Illuminate\Http\Request;
use PDF;

/**
 * Untuk list di depan berarti butuh photo, name, price, commision_rate, list_products
 * Untuk Delimiter nya pake gini => id,qty;id,qty;id,qty
 */


class PDFController extends Controller
{
    private $model;
    private $modelCategoryProduct;
    private $modelProduct;
    public function __construct()
    {
        $this->middleware('auth');
        $this->model = new PackageModel;
        $this->modelCategoryProduct = new CategoryProductModel;
        $this->modelProduct = new ItemModel;
    }

    public function index()
    {
        $data = $this->modelCategoryProduct->GetListActive();
        $dataProduct = $this->modelProduct->GetListActive();
        $dataAll = array("dataCategory" => $data, "dataProduct" => $dataProduct);
        return view('master.package')->with('data', $dataAll);
    }

    public function generatePDF()
    {
        $data = [
            [
                'quantity' => 1,
                'product_name' => 'Elitox 100u',
                'description' => '1 Year Subscription',
                'discount' => '25%',
                'price' => '129.00',
                'total_price' => '120.00'
            ]
        ];
          
        $pdf = PDF::loadView('myPDF', ['data' => $data]);
    
        return $pdf->stream();
    }
}
