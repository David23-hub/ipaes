<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartModel;
use App\Models\OtherCostModel;
use App\Models\DokterModel;
use App\Models\ItemModel;
use App\Models\User;
use App\Models\EkspedisiModel;
use App\Models\ExtraChargeModel;
use App\Models\PackageModel;
use App\Models\StockModel;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    private $model;
    private $bundle;
    private $cart;
    private $user;
    private $doctorModel;
    private $ekspedisi;
    private $extra_charge;
    private $otherCost;
    private $stock;
    public function __construct()
    {
        $this->middleware('auth');
        $this->model = new ItemModel;

        $this->cart = new CartModel;
        $this->bundle = new PackageModel;

        $this->doctorModel = new DokterModel;
        $this->user = new User;
        $this->ekspedisi = new EkspedisiModel;
        $this->extra_charge = new ExtraChargeModel;
        $this->stock = new StockModel;
        $this->otherCost = new OtherCostModel;
    }

    public function index()
    {
        $user = auth()->user();
        $products = $this->model->GetAll();
        $bundle=$this->bundle->GetAll();
        $formattedDateEnd = date("Y-m-d H:i:s");
        $formattedDateStart = mktime(0, 0, 0, 1, 1, date("Y"));
        $formattedDateStart = date("Y-m-d H:i:s", $formattedDateStart);

        $data = $this->cart->GetListJoinDoctorAndDateWithUserAndManagementOrder($formattedDateStart,$formattedDateEnd,$user['role'], $user['email']);
        $userAll = $this->user->GetUserAll();
        $stockAll = $this->stock->GetList($formattedDateStart,$formattedDateEnd,"all");
        $doctorAll = $this->doctorModel->GetListDoctorAndDate();
        $otherCost = $this->otherCost->GetAllByRange($formattedDateStart, $formattedDateEnd);

        $newDate = date('Y-m-d');
        $incentiveIdr=0;
        $total =0;
        $totalShippingCost = 0;
        $totalOtherCost = 0;
        $extraVal = 0;
        $totalPaid = 0;
        $totalSuperUser = 0;
        $totalManagerUser = 0;
        $totalFinanceUser = 0;
        $totalAdminUser = 0;
        $totalMarketingUser = 0;
        $stockIn = 0;
        $stockOut = 0;
        $mapProduct = [];
        $mapUser = [];
        $mapDoktor = [];
        $mapTotalPerMonth = [
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0,
            6 => 0,
            7 => 0,
            8 => 0,
            9 => 0,
            10 => 0,
            11 => 0,
            12 => 0
        ];

        foreach ($doctorAll as $value) {
            if(strtotime($value['dob']) == strtotime($newDate)) {
                array_push($mapDoktor, [
                    'name' => $value['name'],
                ]);
            }
        }

        foreach ($otherCost as $valueOtherCost) {
            $extraVal += $valueOtherCost['price'];
            $totalOtherCost += $valueOtherCost['price'];
        }

        foreach ($stockAll as $valueStock) {
            $stockIn += $valueStock['stock_in'];
            $stockOut += $valueStock['stock_out'];
            if($valueStock['stock_out'] != 0) {
                if(isset($mapProduct[$valueStock['id_product']])) {
                    $mapProduct[$valueStock['id_product']]['stock_out'] += $valueStock['stock_out'];
                } else {
                    $mapProduct[$valueStock['id_product']]['stock_out'] = $valueStock['stock_out'];
                }
            }
        }

        foreach ($products as $valueProduct) {
            if(isset($mapProduct[$valueProduct['id']])) {
                $mapProduct[$valueProduct['id']]['name'] = $valueProduct['name'];
            }
        }

        usort($mapProduct, function($a, $b) {
            return $a['stock_out'] < $b['stock_out'];
        });

        if(count($data) > 0) {
            foreach ($data as $value) {
                // $i=0;
                $totalPerorang = 0;
                $revenuePerorang = 0;
                $incentivePerorang = 0;
                $carts = explode(",", $value->cart);
                foreach ($carts as $key => $cart) {
                    $items = explode("|", $cart);
                    // $i++;
                    // $tempPrice="";
                    $tempTotal = 0;
                    $tempCommisionRate = 0;
                    $tempPrice = (int)$items[4];
                    if($items[1]=="product"){
                        foreach ($products as $valueProd) {
                            if($valueProd["id"]==$items[0]){
                                $items[0]=$valueProd["name"];
                                $tempCommisionRate=$valueProd["commision_rate"];
                                break;
                            }
                        }
                    }else if($items[1]=="paket"){
                        foreach ($bundle as $valueBundle) {
                            if($valueBundle["id"]==$items[0]){
                                $items[0]=$valueBundle["name"];
                                $tempCommisionRate=$valueBundle["commision_rate"];
                                break;
                            }
                        }
                    }
    
                    if($items[3]!=0){
                        $tempTotal = $tempPrice *$items[2] * ((100-$items[3])/100);
                        $total += $tempTotal;
                        $totalPerorang += $tempTotal;
                    }else{
                        $tempTotal = $tempPrice*$items[2];
                        $total += $tempTotal;
                        $totalPerorang += $tempTotal;
                    }
    
                    $incentiveIdr += ($tempTotal * $tempCommisionRate)/100;
                    $incentivePerorang += ceil(($tempTotal * $tempCommisionRate)/100);
                }
    
                $revenuePerorang = $totalPerorang - $incentivePerorang;
    
                $month = date("n", strtotime($value['created_at']));
    
                $mapTotalPerMonth[$month] += $totalPerorang;
    
                $totalpaidItem = 0;
                $totalpoIdr = 0;
                $totalsentIdr = 0;
                $countPo = 0;
                $countSent = 0;
                $countPaid = 0;
                if($value['status'] == 3) {
                    $totalpaidItem = $value['nominal'];
                    $totalPaid += $value['nominal'];
                    $countPaid++;
                } else if($value['status'] == 5) {
                    $paidArray = explode('|', $value['nominal']);
                    $totalpaidItem = array_sum($paidArray);
                    $totalPaid += $totalpaidItem;
                    $countPaid++;
                } else if($value['status'] == 0) {
                    $totalpoIdr = $totalPerorang;
                    $countPo++;
                } else if($value['status'] == 2) {
                    $totalsentIdr = $totalPerorang;
                    $countSent++;
                } else if($value['status'] == 1) {
                    $totalpoIdr = $totalPerorang;
                    $countPo++;
                }
                if(!isset($mapUser[$value['created_by']])) {
                    $mapUser[$value['created_by']] = [
                        'revenue' => $revenuePerorang,
                        'incentive' => $incentivePerorang,
                        'total' => $totalPerorang,
                        'total_po' => $countPo,
                        'total_po_idr' => $totalpoIdr,
                        'total_sent' => $countSent,
                        'total_sent_idr' => $totalsentIdr,
                        'total_paid' => $countPaid,
                        'total_paid_idr' => $totalpaidItem,
                    ];
                } else {
                    $arrTemp =[
                        'revenue' => $revenuePerorang + $mapUser[$value['created_by']]['revenue'],
                        'incentive' => $incentivePerorang + $mapUser[$value['created_by']]['incentive'],
                        'total' => $totalPerorang + $mapUser[$value['created_by']]['total'],
                        'total_po' => $mapUser[$value['created_by']]['total_po'] + $countPo,
                        'total_po_idr' => $mapUser[$value['created_by']]['total_po_idr'] + $totalpoIdr,
                        'total_sent' => $mapUser[$value['created_by']]['total_sent'] + $countSent,
                        'total_sent_idr' => $mapUser[$value['created_by']]['total_sent_idr'] + $totalsentIdr,
                        'total_paid' => $mapUser[$value['created_by']]['total_paid'] + $countPaid,
                        'total_paid_idr' => $mapUser[$value['created_by']]['total_paid_idr'] + $totalpaidItem,
                    ];
                    $mapUser[$value['created_by']] = $arrTemp;
                }
                //loop for extra charge
                $extras = $this->extra_charge->GetList($value["id"]);
                foreach ($extras as $extraValue) {
                    $extraVal += $extraValue["price"];
                }
    
                if($value['shipping_cost']) {
                    $totalShippingCost+= $value['shipping_cost'];
                }
    
                // if($value['status'] == 3 || $value['status'] == 5) {
                //     if($value->nominal) {
                //         $payment = explode("|", $value->nominal);
                //         foreach ($payment  as $valuePayment) {
                //             $totalPaid += (int)$valuePayment;
                //         }
                //     }
                // }
    
            }
            $mapUser = collect($mapUser)->sortBy('incentive')->reverse()->toArray();
        }


        foreach ($userAll as $valueUser) {
            if (count($data) > 0 ) {
                if(isset($mapUser[$valueUser['email']])) {
                    $mapUser[$valueUser['email']]['name'] = $valueUser['name'];
                    $mapUser[$valueUser['email']]['revenue'] = number_format($mapUser[$valueUser['email']]['revenue'],0,',','.');
    
                    $mapUser[$valueUser['email']]['incentive'] = number_format($mapUser[$valueUser['email']]['incentive'],0,',','.');
                    
                    $mapUser[$valueUser['email']]['total'] = number_format($mapUser[$valueUser['email']]['total'],0,',','.');
    
                    $mapUser[$valueUser['email']]['total_po_idr'] = number_format($mapUser[$valueUser['email']]['total_po_idr'],0,',','.');
    
                    $mapUser[$valueUser['email']]['total_sent_idr'] = number_format($mapUser[$valueUser['email']]['total_sent_idr'],0,',','.');
    
                    $mapUser[$valueUser['email']]['total_paid_idr'] = number_format($mapUser[$valueUser['email']]['total_paid_idr'],0,',','.');
                }
            }
            if($valueUser['role'] == "superuser") {
                $totalSuperUser++;
            } else if($valueUser['role'] == "manager") {
                $totalManagerUser++;
            } else if($valueUser['role'] == "finance") {
                $totalFinanceUser++;
            } else if($valueUser['role'] == "admin") {
                $totalAdminUser++;
            } else if($valueUser['role'] == "marketing") {
                $totalMarketingUser++;
            }
        }

        Log::info("other cost", [$totalOtherCost]);

        $result['total_insentive'] = number_format(ceil($incentiveIdr),0,',','.');
        // $result['insentivePerc'] = round(($incentiveIdr*100)/$total,2);
        $result['total_sales'] = number_format(ceil($total),0,',','.');
        $result['total_shipping'] = number_format($totalShippingCost,0,',','.');
        $result['total_other_cost'] = number_format($totalOtherCost,0,',','.');
        $totalRevenue = ($total + $extraVal) - ceil($totalShippingCost);
        $result['total_revenue'] = number_format($totalRevenue,0,',','.');
        $result['total_paid'] = number_format($totalPaid,0,',','.');
        $result['total_po'] = count($data);
        // $result['user'] = $userAll;
        $result['total_super_user'] = $totalSuperUser;
        $result['total_manager_user'] = $totalManagerUser;
        $result['total_finance_user'] = $totalFinanceUser;
        $result['total_admin_user'] = $totalAdminUser;
        $result['total_stock_in'] = $stockIn;
        $result['total_stock_out'] = $stockOut;
        $result['map_product'] = $mapProduct;
        $result['total_salary'] = 0;
        $result['total_marketing_user'] = $totalMarketingUser;
        $result['total_doctor'] = count($doctorAll);
        $result['map_user'] = $mapUser;
        $count = 1;
        $result['map_month'] = $mapTotalPerMonth;
        $result['mapDoktor'] = $mapDoktor;


        return view('dashboard')->with('user', $user)->with('data', $data)->with('result', $result)->with('count', $count);
    }

    public function getAll(Request $request)
    {
        $input = $request->all();
        $user = auth()->user();
        $products = $this->model->GetAll();
        $bundle=$this->bundle->GetAll();
        $endDate = strtotime($input['end_date']);
        $startDate = strtotime($input['start_date']);
        $formattedDateEnd = date("Y-m-d H:i:s", $endDate);
        $formattedDateStart = date("Y-m-d H:i:s", $startDate);
        $data = $this->cart->GetListJoinDoctorAndDateWithUserAndManagementOrder($formattedDateStart,$formattedDateEnd,$user['role'], $user['email']);
        $userAll = $this->user->GetUserAll();
        $stockAll = $this->stock->GetList($formattedDateStart,$formattedDateEnd,"all");
        $doctorAll = $this->doctorModel->GetListDoctorAndDate();
        $otherCost = $this->otherCost->GetAllByRange($formattedDateStart, $formattedDateEnd);

        Log::info('data', [
            'formated_start' => $formattedDateStart,
            'formated_end' => $formattedDateEnd,
            'stockAll' => $stockAll,
            'data' => $data,
            'otherCost' => $otherCost
        ]);

        $newDate = date('Y-m-d');
        $incentiveIdr=0;
        $total =0;
        $totalShippingCost = 0;
        $extraVal = 0;
        $totalPaid = 0;
        $totalOtherCost = 0;
        $totalSuperUser = 0;
        $totalManagerUser = 0;
        $totalFinanceUser = 0;
        $totalAdminUser = 0;
        $totalMarketingUser = 0;
        $stockIn = 0;
        $stockOut = 0;
        $mapProduct = [];
        $mapUser = [];
        $mapDoktor = [];
        $mapTotalPerMonth = [
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0,
            6 => 0,
            7 => 0,
            8 => 0,
            9 => 0,
            10 => 0,
            11 => 0,
            12 => 0
        ];

        foreach ($doctorAll as $value) {
            if(strtotime($value['dob']) == strtotime($newDate)) {
                array_push($mapDoktor, [
                    'name' => $value['name'],
                ]);
            }
        }

        foreach ($otherCost as $valueOtherCost) {
            $extraVal += $valueOtherCost['price'];
            $totalOtherCost += $valueOtherCost['price'];
        }

        foreach ($stockAll as $valueStock) {
            $stockIn += $valueStock['stock_in'];
            $stockOut += $valueStock['stock_out'];
            if($valueStock['stock_out'] != 0) {
                if(isset($mapProduct[$valueStock['id_product']])) {
                    $mapProduct[$valueStock['id_product']]['stock_out'] += $valueStock['stock_out'];
                } else {
                    $mapProduct[$valueStock['id_product']]['stock_out'] = $valueStock['stock_out'];
                }
            }
        }

        foreach ($products as $valueProduct) {
            if(isset($mapProduct[$valueProduct['id']])) {
                $mapProduct[$valueProduct['id']]['name'] = $valueProduct['name'];
            }
        }

        usort($mapProduct, function($a, $b) {
            return $a['stock_out'] < $b['stock_out'];
        });

        if(count($data) > 0) {
            foreach ($data as $value) {
                // $i=0;
                $totalPerorang = 0;
                $revenuePerorang = 0;
                $incentivePerorang = 0;
                $carts = explode(",", $value->cart);
                foreach ($carts as $key => $cart) {
                    $items = explode("|", $cart);
                    // $i++;
                    // $tempPrice="";
                    $tempTotal = 0;
                    $tempCommisionRate = 0;
                    $tempPrice = (int)$items[4];
                    if($items[1]=="product"){
                        foreach ($products as $valueProd) {
                            if($valueProd["id"]==$items[0]){
                                $items[0]=$valueProd["name"];
                                $tempCommisionRate=$valueProd["commision_rate"];
                                break;
                            }
                        }
                    }else if($items[1]=="paket"){
                        foreach ($bundle as $valueBundle) {
                            if($valueBundle["id"]==$items[0]){
                                $items[0]=$valueBundle["name"];
                                $tempCommisionRate=$valueBundle["commision_rate"];
                                break;
                            }
                        }
                    }
    
                    if($items[3]!=0){
                        $tempTotal = $tempPrice *$items[2] * ((100-$items[3])/100);
                        $total += $tempTotal;
                        $totalPerorang += $tempTotal;
                    }else{
                        $tempTotal = $tempPrice*$items[2];
                        $total += $tempTotal;
                        $totalPerorang += $tempTotal;
                    }
    
                    $incentiveIdr += ($tempTotal * $tempCommisionRate)/100;
                    $incentivePerorang += ceil(($tempTotal * $tempCommisionRate)/100);
                }
    
                $revenuePerorang = $totalPerorang - $incentivePerorang;
    
                $month = date("n", strtotime($value['created_at']));
    
                $mapTotalPerMonth[$month] += $totalPerorang;
    
                $totalpaidItem = 0;
                $totalpoIdr = 0;
                $totalsentIdr = 0;
                $countPo = 0;
                $countSent = 0;
                $countPaid = 0;
                if($value['status'] == 3) {
                    $totalpaidItem = $value['nominal'];
                    $totalPaid += $value['nominal'];
                    $countPaid++;
                } else if($value['status'] == 5) {
                    $paidArray = explode('|', $value['nominal']);
                    $totalpaidItem = array_sum($paidArray);
                    $totalPaid += $totalpaidItem;
                    $countPaid++;
                } else if($value['status'] == 0) {
                    $totalpoIdr = $totalPerorang;
                    $countPo++;
                } else if($value['status'] == 2) {
                    $totalsentIdr = $totalPerorang;
                    $countSent++;
                } else if($value['status'] == 1) {
                    $totalpoIdr = $totalPerorang;
                    $countPo++;
                }
                if(!isset($mapUser[$value['created_by']])) {
                    $mapUser[$value['created_by']] = [
                        'revenue' => $revenuePerorang,
                        'incentive' => $incentivePerorang,
                        'total' => $totalPerorang,
                        'total_po' => $countPo,
                        'total_po_idr' => $totalpoIdr,
                        'total_sent' => $countSent,
                        'total_sent_idr' => $totalsentIdr,
                        'total_paid' => $countPaid,
                        'total_paid_idr' => $totalpaidItem,
                    ];
                } else {
                    $arrTemp =[
                        'revenue' => $revenuePerorang + $mapUser[$value['created_by']]['revenue'],
                        'incentive' => $incentivePerorang + $mapUser[$value['created_by']]['incentive'],
                        'total' => $totalPerorang + $mapUser[$value['created_by']]['total'],
                        'total_po' => $mapUser[$value['created_by']]['total_po'] + $countPo,
                        'total_po_idr' => $mapUser[$value['created_by']]['total_po_idr'] + $totalpoIdr,
                        'total_sent' => $mapUser[$value['created_by']]['total_sent'] + $countSent,
                        'total_sent_idr' => $mapUser[$value['created_by']]['total_sent_idr'] + $totalsentIdr,
                        'total_paid' => $mapUser[$value['created_by']]['total_paid'] + $countPaid,
                        'total_paid_idr' => $mapUser[$value['created_by']]['total_paid_idr'] + $totalpaidItem,
                    ];
                    $mapUser[$value['created_by']] = $arrTemp;
                }
                //loop for extra charge
                $extras = $this->extra_charge->GetList($value["id"]);
                foreach ($extras as $extraValue) {
                    $extraVal += $extraValue["price"];
                }
    
                if($value['shipping_cost']) {
                    $totalShippingCost+= $value['shipping_cost'];
                }
    
                // if($value['status'] == 3 || $value['status'] == 5) {
                //     if($value->nominal) {
                //         $payment = explode("|", $value->nominal);
                //         foreach ($payment  as $valuePayment) {
                //             $totalPaid += (int)$valuePayment;
                //         }
                //     }
                // }
    
            }
            $mapUser = collect($mapUser)->sortBy('incentive')->reverse()->toArray();
        }


        foreach ($userAll as $valueUser) {
            if (count($data) > 0 ) {
                if(isset($mapUser[$valueUser['email']])) {
                    $mapUser[$valueUser['email']]['name'] = $valueUser['name'];
                    $mapUser[$valueUser['email']]['revenue'] = number_format($mapUser[$valueUser['email']]['revenue'],0,',','.');
    
                    $mapUser[$valueUser['email']]['incentive'] = number_format($mapUser[$valueUser['email']]['incentive'],0,',','.');
                    
                    $mapUser[$valueUser['email']]['total'] = number_format($mapUser[$valueUser['email']]['total'],0,',','.');
    
                    $mapUser[$valueUser['email']]['total_po_idr'] = number_format($mapUser[$valueUser['email']]['total_po_idr'],0,',','.');
    
                    $mapUser[$valueUser['email']]['total_sent_idr'] = number_format($mapUser[$valueUser['email']]['total_sent_idr'],0,',','.');
    
                    $mapUser[$valueUser['email']]['total_paid_idr'] = number_format($mapUser[$valueUser['email']]['total_paid_idr'],0,',','.');
                }
            }
            if($valueUser['role'] == "superuser") {
                $totalSuperUser++;
            } else if($valueUser['role'] == "manager") {
                $totalManagerUser++;
            } else if($valueUser['role'] == "finance") {
                $totalFinanceUser++;
            } else if($valueUser['role'] == "admin") {
                $totalAdminUser++;
            } else if($valueUser['role'] == "marketing") {
                $totalMarketingUser++;
            }
        }

        $result['total_insentive'] = number_format(ceil($incentiveIdr),0,',','.');
        // $result['insentivePerc'] = round(($incentiveIdr*100)/$total,2);
        $result['total_sales'] = number_format(ceil($total),0,',','.');
        $result['total_shipping'] = number_format($totalShippingCost,0,',','.');
        $result['total_other_cost'] = number_format($totalOtherCost,0,',','.');
        $totalRevenue = ($total + $extraVal) - ceil($totalShippingCost);
        $result['total_revenue'] = number_format($totalRevenue,0,',','.');
        $result['total_paid'] = number_format($totalPaid,0,',','.');
        $result['total_po'] = count($data);
        // $result['user'] = $userAll;
        $result['total_salary'] = 0;
        $result['total_super_user'] = $totalSuperUser;
        $result['total_manager_user'] = $totalManagerUser;
        $result['total_finance_user'] = $totalFinanceUser;
        $result['total_admin_user'] = $totalAdminUser;
        $result['total_stock_in'] = $stockIn;
        $result['total_stock_out'] = $stockOut;
        $result['map_product'] = $mapProduct;
        $result['total_marketing_user'] = $totalMarketingUser;
        $result['total_doctor'] = count($doctorAll);
        $result['map_user'] = $mapUser;
        $count = 1;
        $result['map_month'] = $mapTotalPerMonth;
        $result['mapDoktor'] = $mapDoktor;

        $returned = [
            'result' => $result,
            'count' => $count,
            'data' => $data
        ];
        
        return $returned;
    }
}
