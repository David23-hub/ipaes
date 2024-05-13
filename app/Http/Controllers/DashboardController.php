<?php

namespace App\Http\Controllers;

use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use App\Models\CartModel;
use App\Models\OtherCostModel;
use App\Models\DokterModel;
use App\Models\ItemModel;
use App\Models\User;
use App\Models\EkspedisiModel;
use App\Models\ExtraChargeModel;
use App\Models\PackageModel;
use App\Models\SalaryModel;
use App\Models\StockModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

// use App\Models\OtherCostModel;

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
    private $salary;

    private $textDashboard; 
    private $textWA; 
    private $urlBase;
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
        $this->salary = new SalaryModel;
        $this->textDashboard = "Pesanan <strong>#NAMA_DOKTER#</strong> TINGGAL <strong>#DUE_DATE#</strong> Hari lagi Sebelum Jatuh Tempo!";
        $this->textWA = "Halo *#NAMA_DOKTER#*,%0A%0ASaat ini, anda memiliki tagihan yang belum dibayar. Masa Tenggak Waktu anda selama *#DUE_DATE#* hari lagi.%0ADimohon untuk melakukan pelunasan segera.%0ABerikut untuk link invoice: #NO_INVOICE#%0A%0ATerima kasih, salam hormat%0A*IPAES*.";
        $this->urlBase = "https://intipersada.id/generate-pdf-all/";
        }

        private function encryptUrl(string $url) {
            $encryptedUrl = Crypt::encryptString($url);
            return $encryptedUrl;
          }

    public function index()
    {
        // finance dan admin cuma tampil list po bentuk card list ul
        // isi nya itu berarti user profile, map doktor untuk ultah, map stock untuk product
        // else role nya tampil kayak biasa

        $user = auth()->user();
        $products = $this->model->GetAll();
        $bundle=$this->bundle->GetAll();
        $formattedDateEnd = mktime(0, 0, 0, 12, 31, date("Y"));
        $formattedDateEnd = date("Y-m-d H:i:s", $formattedDateEnd);
        $formattedDateStart = mktime(0, 0, 0, 1, 1, date("Y"));
        $formattedDateStart = date("Y-m-d H:i:s", $formattedDateStart);
        
        $formattedSalary = "all";
        
        $data = $this->cart->GetListJoinDoctorAndDateWithUserAndManagementOrder($formattedDateStart,$formattedDateEnd,$user['role'], $user['email']);
        Log::info("data", [
            "list cart" => $data
        ]);

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
        $totalSalary = 0;
        $stockIn = 0;
        $stockOut = 0;
        $mapProduct = [];
        $mapUser = [];
        $mapReminderPO = [];
        $mapDoktor = [];
        $mapStock = [];
        $mapMarketingStock = [];
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
        $result['mapReminder'] = [];

        //untuk reminder
        foreach ($data as $value) {
            if($value->status==3 || $value->status==5 || $value->status==4){
                continue;
            }

            $temp = [];
            if(Auth::user()->role=="marketing" && $value->management_order==0 && $value->created_by == Auth::user()->email){
                $reminder = $this->getDayAgo($value['due_date']);
                if ($reminder!=""){
                    $text = $this->textDashboard;
                    $text = str_replace("#NAMA_DOKTER#", $value->doctor_name, $text);
                    $text = str_replace("#DUE_DATE#", $reminder, $text);
                    

                    $link = $this->textWA;
                    $link = str_replace("#NAMA_DOKTER#", $value->doctor_name, $link);
                    $link = str_replace("#DUE_DATE#", $reminder, $link);
                    
                    $url = $this->urlBase . $this->encryptUrl($value['id']);
                    $link = str_replace("#NO_INVOICE#", $url, $link);

                    $temp['text'] = $text;
                    $temp['link'] = "https://wa.me/62".substr($value['billing_no_hp'], 0, strlen($value['billing_no_hp'])-1)."/?text=".$link;
                    array_push($mapReminderPO, $temp);
                }
            }else if (Auth::user()->role!="marketing"){
                $reminder = $this->getDayAgo($value['due_date']);
                if ($reminder!=""){
                    $text = $this->textDashboard;
                    $text = str_replace("#NAMA_DOKTER#", $value->doctor_name, $text);
                    $text = str_replace("#DUE_DATE#", $reminder, $text);
                    $temp['text'] = $text;

                    $link = $this->textWA;
                    $link = str_replace("#NAMA_DOKTER#", $value->doctor_name, $link);
                    $link = str_replace("#DUE_DATE#", $reminder, $link);
                    $url = $this->urlBase . $this->encryptUrl($value['id']);
                    $link = str_replace("#NO_INVOICE#", $url, $link);

                    $temp['link'] = "https://wa.me/62".substr($value['billing_no_hp'], 1, strlen($value['billing_no_hp']))."/?text=".$link;

                    array_push($mapReminderPO, $temp);
                }
            }
        }
        $result['mapReminder'] =  $mapReminderPO;

        //without total sales di dashboard
        if ($user['role'] == "admin" || $user['role'] == "finance") {
            $doctorAll = $this->doctorModel->GetListDoctorAndDate();
            $dataTransaction = $this->cart->GetListJoinDoctorDashboard($formattedDateStart, $formattedDateEnd);

            foreach ($doctorAll as $value) {
                $dateDoctor = new DateTime($value['dob']);  
                $currentDate = new DateTime();
    
                // Extract month and day from the dates
                $month_day_1 = $dateDoctor->format('md');
                $month_day_2 = $currentDate->format('md');

                Log::info("dob", [
                    "day1" => $month_day_1,
                    "day2" => $month_day_2
                ]);
    
                if ($month_day_1 == $month_day_2) {
                    $initial = explode(" ", $value['name']);
                    if(count($initial) >= 2) {
                        $initial1 = $initial[0][0];
                        $initial2 = $initial[1][0];
                        $initial = strtoupper($initial1) . strtoupper($initial2);
                    } else if (count($initial) == 1) {
                        $initial = strtoupper($initial[0][0]);
                    }
                    array_push($mapDoktor, [
                        'name' => $value['name'],
                        'dob' => 'today',
                        'initial' => $initial
                    ]);
                } else {
                    $dateDoctor->modify('-1 day');
                    $tomorrow_month_day = $dateDoctor->format('md');
                    $initial = explode(" ", $value['name']);
                    if(count($initial) >= 2) {
                        $initial1 = $initial[0][0];
                        $initial2 = $initial[1][0];
                        $initial = strtoupper($initial1) . strtoupper($initial2);
                    } else if (count($initial) == 1) {
                        $initial = strtoupper($initial[0][0]);
                    }
                    // Check if $date2 is tomorrow's date relative to $date1
                    if ($month_day_2 == $tomorrow_month_day) {
                        array_push($mapDoktor, [
                            'name' => $value['name'],
                            'dob' => 'tomorrow',
                            'initial' => $initial
                        ]);
                    }
                }      
            }

            foreach ($products as $valueProduct) {
                if($valueProduct['qty'] <= $valueProduct['qty_min'] && $value['deleted_by']==null ) {
                    array_push($mapStock, [
                        'name'=> $valueProduct['name'],
                        'stock' => $valueProduct['qty']
                    ]);
                }
            }

            foreach ($dataTransaction as $valueTransaction) {
                # code...
                $timestamp = $this->getTimeAgo($valueTransaction['created_at']);
                $valueTransaction['timestamp'] = $timestamp;
            }

            $result['month_now'] = (int)date("m");
            $result['year_now'] = (int)date("Y");
            $result['mapDoktor'] = $mapDoktor;
            $result['mapStock'] = $mapStock;
            $result['mapTransaction'] = $dataTransaction;
            $result['map_month'] = $mapTotalPerMonth;

            return view('dashboard')->with('user', $user)->with('result', $result)->with('data', $data);
        }

        $dataCarousel = $this->cart->GetListJoinDoctorAndDateWithUserAndManagementOrder($formattedDateStart,$formattedDateEnd,'superuser', $user['email']);
        $userAll = $this->user->GetUserAll();
        $stockAll = $this->stock->GetList($formattedDateStart,$formattedDateEnd,"all");
        // if($user['role'] == "marketing") {
        //     $stockAll = $this->stock->GetList($formattedDateStart,$formattedDateEnd,"all");
        // }
        $doctorAll = $this->doctorModel->GetListDoctorAndDate();
        $otherCost = $this->otherCost->GetAllByRange($formattedDateStart, $formattedDateEnd);
        $salaryAll = $this->salary->GetListFilter($formattedSalary);

        //ultah dokter
        foreach ($doctorAll as $value) {
            $dateDoctor = new DateTime($value['dob']);  
            $currentDate = new DateTime();

            // Extract month and day from the dates
            $month_day_1 = $dateDoctor->format('md');
            $month_day_2 = $currentDate->format('md');

            if ($month_day_1 == $month_day_2) {
                $initial = explode(" ", $value['name']);
                if(count($initial) >= 2) {
                    $initial1 = $initial[0][0];
                    $initial2 = $initial[1][0];
                    $initial = strtoupper($initial1) . strtoupper($initial2);
                } else if (count($initial) == 1) {
                    $initial = strtoupper($initial[0][0]);
                }
                array_push($mapDoktor, [
                    'name' => $value['name'],
                    'dob' => 'today',
                    'initial' => $initial
                ]);
            } else {
                $dateDoctor->modify('-1 day');
                $tomorrow_month_day = $dateDoctor->format('md');
                $initial = explode(" ", $value['name']);
                if(count($initial) >= 2) {
                    $initial1 = $initial[0][0];
                    $initial2 = $initial[1][0];
                    $initial = strtoupper($initial1) . strtoupper($initial2);
                } else if (count($initial) == 1) {
                    $initial = strtoupper($initial[0][0]);
                }
                // Check if $date2 is tomorrow's date relative to $date1
                if ($month_day_2 == $tomorrow_month_day) {
                    array_push($mapDoktor, [
                        'name' => $value['name'],
                        'dob' => 'tomorrow',
                        'initial' => $initial
                    ]);
                }
            }      
        }


        //total other cost
        foreach ($otherCost as $valueOtherCost) {
            $totalOtherCost += $valueOtherCost['price'];
        }

        //total salary
        foreach ($salaryAll as $valueSalary) {
            $totalSalary += $valueSalary['price'];
        }

        // data table total sales, incentive, dll
        if(count($data) > 0) {
            foreach ($data as $value) {
                $tempIncen = 0;
                
                if($value['status'] == 4) {
                    continue;
                }

                if($user['role'] == "marketing") {
                    array_push($mapMarketingStock, $value['id']);
                }

                // $i=0;
                $totalPerorang = 0;
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
                    
                    $incentiveIdr += ($tempTotal * ($tempCommisionRate/100));
                    $tempIncen += ($tempTotal * ($tempCommisionRate/100));
                }
                
                

                $month = date("n", strtotime($value['created_at']));
    
                //loop for extra charge
                $extras = $this->extra_charge->GetList($value["id"]);
                $tempExtra = 0;
                foreach ($extras as $extraValue) {
                    $extraVal += $extraValue["price"];
                    $tempExtra += $extraValue["price"];
                }
    
                $tempShip = 0;
                if($value['shipping_cost']) {
                    $total += $value['shipping_cost'];
                    $totalPerorang += $value['shipping_cost'];
                    $totalShippingCost+= $value['shipping_cost'];
                    $tempShip += $value['shipping_cost'];
                }
    
                if($value['status'] == 5 || $value['status'] == 3) {
                    if($value['nominal']) {
                        $paidArray = explode('|', $value['nominal']);
                        $totalPaid += array_sum($paidArray);
                    }
                }


                $mapTotalPerMonth[$month] += $totalPerorang + $tempExtra - $tempShip - $tempIncen;
            }
        }

        Log::info('data all', [
            "total paid" => $totalPaid
        ]);

        // data carousel
        if(count($dataCarousel) > 0) {

            foreach ($dataCarousel as $valueCarousel) {
                if($valueCarousel['status'] == 4) {
                    continue;
                }
                // $i=0;
                $totalPerorang = 0;
                $revenuePerorang = 0;
                $incentivePerorang = 0;
                $carts = explode(",", $valueCarousel->cart);
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
                        $totalPerorang += $tempTotal;
                    }else{
                        $tempTotal = $tempPrice*$items[2];
                        $totalPerorang += $tempTotal;
                    }

                    
                    
                    $incentivePerorang += ceil(($tempTotal * $tempCommisionRate)/100);
                }
    
                $revenuePerorang = $totalPerorang - $incentivePerorang;
                $totalpaidItem = 0;
                $totalpoIdr = 0;
                $totalsentIdr = 0;
                $countPo = 0;
                $countSent = 0;
                $countPaid = 0;
                if($valueCarousel['status'] == 3) {
                    $totalpoIdr = $totalPerorang;
                    $totalpaidItem = $valueCarousel['nominal'];
                    $countPo++;
                    $countPaid++;
                } else if($valueCarousel['status'] == 5) {
                    $paidArray = explode('|', $valueCarousel['nominal']);
                    $totalpaidItem = array_sum($paidArray);
                      $totalpoIdr = $totalpaidItem;
                    $countPo++;
                    $countPaid++;
                } else if($valueCarousel['status'] == 0) {
                    $totalpoIdr = $totalPerorang;
                    $countPo++;
                } else if($valueCarousel['status'] == 2) {
                    $totalpoIdr = $totalPerorang;
                    $totalsentIdr = $totalPerorang; 
                    $countPo++;
                    $countSent++;
                } else if($valueCarousel['status'] == 1) {
                    $totalpoIdr = $totalPerorang;
                    $countPo++;
                }

                $month = date("n", strtotime($valueCarousel['created_at']));
    
                //loop for extra charge
                $extras = $this->extra_charge->GetList($valueCarousel["id"]);
                $tempExtra = 0;
                foreach ($extras as $extraValue) {
                    $totalpoIdr += $extraValue["price"];
                }
    
                if($valueCarousel['shipping_cost']) {
                    $totalpoIdr += $valueCarousel['shipping_cost'];
                }
                
                if(!isset($mapUser[$valueCarousel['created_by']])) {
                    $mapUser[$valueCarousel['created_by']] = [
                        'revenue' => $revenuePerorang,
                        'incentive' => $incentivePerorang,
                        'total' => $totalPerorang,
                        'total_po' => $countPo,
                        'total_po_idr' => $totalpoIdr,
                        'total_sent' => $countSent,
                        'total_sent_idr' => $totalsentIdr,
                        'total_paid' => $countPaid,
                        'total_paid_idr' => $totalpaidItem,
                        'img'=>$valueCarousel['img'],
                    ];
                } else {
                    $arrTemp =[
                        'revenue' => $revenuePerorang + $mapUser[$valueCarousel['created_by']]['revenue'],
                        'incentive' => $incentivePerorang + $mapUser[$valueCarousel['created_by']]['incentive'],
                        'total' => $totalPerorang + $mapUser[$valueCarousel['created_by']]['total'],
                        'total_po' => $mapUser[$valueCarousel['created_by']]['total_po'] + $countPo,
                        'total_po_idr' => $mapUser[$valueCarousel['created_by']]['total_po_idr'] + $totalpoIdr,
                        'total_sent' => $mapUser[$valueCarousel['created_by']]['total_sent'] + $countSent,
                        'total_sent_idr' => $mapUser[$valueCarousel['created_by']]['total_sent_idr'] + $totalsentIdr,
                        'total_paid' => $mapUser[$valueCarousel['created_by']]['total_paid'] + $countPaid,
                        'total_paid_idr' => $mapUser[$valueCarousel['created_by']]['total_paid_idr'] + $totalpaidItem,
                        'img'=>$valueCarousel['img'],
                    ];
                    $mapUser[$valueCarousel['created_by']] = $arrTemp;
                }
    
            }
            $mapUser = collect($mapUser)->sortBy('incentive')->reverse()->toArray();
        }

        
        foreach ($userAll as $valueUser) {
            if (count($dataCarousel) > 0 ) {
                if(isset($mapUser[$valueUser['email']])) {
                    $mapUser[$valueUser['email']]['name'] = $valueUser['name'];
                    $mapUser[$valueUser['email']]['revenue'] = number_format($mapUser[$valueUser['email']]['revenue'],0,',','.');
    
                    $mapUser[$valueUser['email']]['incentive'] = number_format($mapUser[$valueUser['email']]['incentive'],0,',','.');
                    
                    $mapUser[$valueUser['email']]['total'] = number_format($mapUser[$valueUser['email']]['total'],0,',','.');
    
                    $mapUser[$valueUser['email']]['total_po_idr'] = number_format($mapUser[$valueUser['email']]['total_po_idr'],0,',','.');
    
                    $mapUser[$valueUser['email']]['total_sent_idr'] = number_format($mapUser[$valueUser['email']]['total_sent_idr'],0,',','.');
    
                    $mapUser[$valueUser['email']]['total_paid_idr'] = number_format($mapUser[$valueUser['email']]['total_paid_idr'],0,',','.');

                    $mapUser[$valueUser['email']]['img'] = $valueUser['img'];

                    $mapUser[$valueUser['email']]['initial'] = "";

                    if($valueUser['img']=="" || $valueUser['img']==null) {
                        $named = explode(" ", $valueUser['name']);
                        $initialsName = "";
                        foreach ($named as $valueInitial) {
                            # code...
                            $initialsName .= $valueInitial[0];
                        }
                        $mapUser[$valueUser['email']]['initial'] = $initialsName;
                    }
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

        //untuk list product di samping kanan
        if($user['role'] == "marketing") {
            foreach ($stockAll as $valueStock) {
                $stockIn += $valueStock['stock_in'];
                $stockOut += $valueStock['stock_out'];
                foreach ($mapMarketingStock as $valueStockMarketing) {
                    if($valueStock['stock_out'] != 0 && $valueStock['cart_id'] == $valueStockMarketing) {
                        if(isset($mapProduct[$valueStock['id_product']])) {
                            $mapProduct[$valueStock['id_product']]['stock_out'] += $valueStock['stock_out'];
                        } else {
                            $mapProduct[$valueStock['id_product']]['stock_out'] = $valueStock['stock_out'];
                        }
                    }
                    
                    if($valueStock['stock_in'] != 0 && $valueStock['cart_id'] == $valueStockMarketing && strpos($valueStock['desc'], "CANCEL") === 0) {
                        if(isset($mapProduct[$valueStock['id_product']])) {
                            $mapProduct[$valueStock['id_product']]['stock_out'] += $valueStock['stock_in'] * -1;
                        } else {
                            $mapProduct[$valueStock['id_product']]['stock_out'] = $valueStock['stock_in'] * -1;
                        }
                    }
                }
            }
        } else {
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
                
                if($valueStock['stock_in'] != 0 && strpos($valueStock['desc'], "CANCEL") === 0) {
                    if(isset($mapProduct[$valueStock['id_product']]) ) {
                        $mapProduct[$valueStock['id_product']]['stock_out'] += $valueStock['stock_in'] * -1;
                    } else {
                        $mapProduct[$valueStock['id_product']]['stock_out'] = $valueStock['stock_in'] * -1;
                    }
                }
            }
        }

        //alert stock
        foreach ($products as $valueProduct) {
            if(isset($mapProduct[$valueProduct['id']])) {
                $mapProduct[$valueProduct['id']]['name'] = $valueProduct['name'];
            }

            if($valueProduct['qty'] <= $valueProduct['qty_min']) {
                array_push($mapStock, [
                    'name'=> $valueProduct['name'],
                    'stock' => $valueProduct['qty']
                ]);
            }
        }

        usort($mapProduct, function($a, $b) {
            return $a['stock_out'] < $b['stock_out'];
        });

        // Log::info("other total paid", [$totalPaid]);

        $result['total_insentive'] = number_format($incentiveIdr,0,',','.');
        // $result['insentivePerc'] = round(($incentiveIdr*100)/$total,2);
        $totalSales = ceil($total) + ceil($extraVal);
        $result['total_sales'] = number_format($totalSales,0,',','.');
        $result['total_shipping'] = number_format($totalShippingCost,0,',','.');
        $result['total_other_cost'] = number_format($totalOtherCost,0,',','.');

        $totalRevenue = $totalSales - $totalShippingCost - ceil($incentiveIdr) - $totalSalary - $totalOtherCost;

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
        $result['total_salary'] = number_format($totalSalary,0,',','.');
        $result['total_marketing_user'] = $totalMarketingUser;
        $result['total_doctor'] = count($doctorAll);
        $result['map_user'] = $mapUser;
        $result['month_now'] = (int)date("m");
        $result['year_now'] = (int)date("Y");
        $count = 1;
        $result['map_month'] = $mapTotalPerMonth;
        $result['mapDoktor'] = $mapDoktor;
        $result['mapStock'] = $mapStock;


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
        if($request->temp_mon=="all"){
            $formattedSalaryDate = "all";
        }else{
            $formattedSalaryDate = date("Y F", $startDate);
        }
        $data = $this->cart->GetListJoinDoctorAndDateWithUserAndManagementOrder($formattedDateStart,$formattedDateEnd,$user['role'], $user['email']);

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
        $totalSalary = 0;
        $stockIn = 0;
        $stockOut = 0;
        $mapProduct = [];
        $mapUser = [];
        $mapReminderPO = [];
        $mapDoktor = [];
        $mapStock = [];
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


        $mapMarketingStock = [];
        $result['mapReminder'] = [];

        foreach ($data as $value) {
            if($value->status==3 || $value->status==5 || $value->status==4){
                continue;
            }
            
            $temp = [];
            if(Auth::user()->role=="marketing" && $value->management_order==0 && $value->created_by == Auth::user()->email){
                $reminder = $this->getDayAgo($value['due_date']);
                if ($reminder!=""){
                    $text = $this->textDashboard;
                    $text = str_replace("#NAMA_DOKTER#", $value->doctor_name, $text);
                    $text = str_replace("#DUE_DATE#", $reminder, $text);

                    $link = $this->textWA;
                    $link = str_replace("#NAMA_DOKTER#", $value->doctor_name, $link);
                    $link = str_replace("#DUE_DATE#", $reminder, $link);
                    $url = $this->urlBase . $this->encryptUrl($value['id']);
                    $link = str_replace("#NO_INVOICE#", $url, $link);


                    $temp['text'] = $text;
                    $temp['link'] = "https://wa.me/62".substr($value['billing_no_hp'], 0, strlen($value['billing_no_hp'])-1)."/?text=".$link;
                    array_push($mapReminderPO, $temp);
                }
            }else if (Auth::user()->role!="marketing"){
                $reminder = $this->getDayAgo($value['due_date']);
                if ($reminder!=""){
                    $text = $this->textDashboard;
                    $text = str_replace("#NAMA_DOKTER#", $value->doctor_name, $text);
                    $text = str_replace("#DUE_DATE#", $reminder, $text);
                    $temp['text'] = $text;

                    $link = $this->textWA;
                    $link = str_replace("#NAMA_DOKTER#", $value->doctor_name, $link);
                    $link = str_replace("#DUE_DATE#", $reminder, $link);
                    $url = $this->urlBase . $this->encryptUrl($value['id']);
                    $link = str_replace("#NO_INVOICE#", $url, $link);

                    $temp['link'] = "https://wa.me/62".substr($value['billing_no_hp'], 1, strlen($value['billing_no_hp']))."/?text=".$link;

                    array_push($mapReminderPO, $temp);
                }
            }
        }
        $result['mapReminder'] =  $mapReminderPO;

        if ($user['role'] == "admin" || $user['role'] == "finance") {
            $doctorAll = $this->doctorModel->GetListDoctorAndDate();
            $dataTransaction = $this->cart->GetListJoinDoctorDashboard($formattedDateStart, $formattedDateEnd);

            foreach ($products as $valueProduct) {
                if($valueProduct['qty'] <= $valueProduct['qty_min']) {
                    array_push($mapStock, [
                        'name'=> $valueProduct['name'],
                        'stock' => $valueProduct['qty']
                    ]);
                }
            }

            foreach ($dataTransaction as $valueTransaction) {
                # code...
                $timestamp = $this->getTimeAgo($valueTransaction['created_at']);
                $valueTransaction['timestamp'] = $timestamp;
            }

            $result['month_now'] = (int)date("m");
            $result['year_now'] = (int)date("Y");
            $result['mapStock'] = $mapStock;
            $result['mapTransaction'] = $dataTransaction;
            $result['map_month'] = $mapTotalPerMonth;

            $returned = [
                'result' => $result,
                'data' => $data
            ];
            return $returned;
        }

        $dataCarousel = $this->cart->GetListJoinDoctorAndDateWithUserAndManagementOrder($formattedDateStart,$formattedDateEnd,'superuser', $user['email']);
        $userAll = $this->user->GetUserAll();
        $stockAll = $this->stock->GetList($formattedDateStart,$formattedDateEnd,"all");
        $doctorAll = $this->doctorModel->GetListDoctorAndDate();
        $otherCost = $this->otherCost->GetAllByRange($formattedDateStart, $formattedDateEnd);
        $salaryAll = $this->salary->GetListFilter($formattedSalaryDate);

        
        Log::info('data', [
            'formated_start' => $formattedDateStart,
            'formated_end' => $formattedDateEnd,
            'stockAll' => $stockAll,
            'data' => $data,
            'otherCost' => $otherCost
        ]);

        foreach ($salaryAll as $valueSalary) {
            # code...
            $totalSalary += $valueSalary['price'];
        }

        foreach ($doctorAll as $value) {
            $date = date_create($value['dob']);  
            date_sub($date, date_interval_create_from_date_string('1 days'));  
            $substractOneDay = date_format($date, 'Y-m-d');
            // $newDate1 = date('Y-m-d H:i:s');
            // Log::info('date', [($value['dob']), ($newDate), ($substractOneDay), ($newDate1)]);
            if(strtotime($value['dob']) == strtotime($newDate) || strtotime($substractOneDay) == strtotime($newDate)) {
                array_push($mapDoktor, [
                    'name' => $value['name'],
                ]);
            }
        }

        foreach ($otherCost as $valueOtherCost) {
            $totalOtherCost += $valueOtherCost['price'];
        }

        // data product
        if(count($data) > 0) {
            foreach ($data as $value) {
                
                if($value['status'] == 4) {
                    continue;
                }
                if($user['role'] == "marketing") {
                    array_push($mapMarketingStock, $value['id']);
                }
                // $i=0;
                $totalPerorang = 0;
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
                    
                    $incentiveIdr += ($tempTotal * ($tempCommisionRate/100));
                    $tempIncen += ($tempTotal * ($tempCommisionRate/100));
                }
                $total += $value['shipping_cost'];
                $month = date("n", strtotime($value['created_at']));
    
                //loop for extra charge
                $extras = $this->extra_charge->GetList($value["id"]);
                $tempExtra = 0;
                foreach ($extras as $extraValue) {
                    $extraVal += $extraValue["price"];
                    $tempExtra += $extraValue["price"];
                }
    
                $tempShip = 0;
                if($value['shipping_cost']) {
                    $total += $value['shipping_cost'];
                    $totalPerorang += $value['shipping_cost'];
                    $totalShippingCost+= $value['shipping_cost'];
                    $tempShip += $value['shipping_cost'];
                }
    
                if($value['status'] == 5 || $value['status'] == 3) {
                    if($value['nominal']) {
                        // $payment = explode("|", $value->nominal);
                        // foreach ($payment  as $valuePayment) {
                        //     $totalPaid += (int)$valuePayment;
                        // }
                        $paidArray = explode('|', $value['nominal']);
                        $totalPaid += array_sum($paidArray);
                    }
                }


                $mapTotalPerMonth[$month] += $totalPerorang + $tempExtra - $tempShip - $tempIncen;
    
            }
        }

        if(count($dataCarousel) > 0) {

            foreach ($dataCarousel as $valueCarousel) {
                if($valueCarousel['status'] == 4) {
                    continue;
                }
                // $i=0;
                $totalPerorang = 0;
                $revenuePerorang = 0;
                $incentivePerorang = 0;
                $carts = explode(",", $valueCarousel->cart);
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
                        $totalPerorang += $tempTotal;
                    }else{
                        $tempTotal = $tempPrice*$items[2];
                        $totalPerorang += $tempTotal;
                    }

                    $incentivePerorang += ceil(($tempTotal * $tempCommisionRate)/100);
                }
    
                $revenuePerorang = $totalPerorang - $incentivePerorang;
                $totalpaidItem = 0;
                $totalpoIdr = 0;
                $totalsentIdr = 0;
                $countPo = 0;
                $countSent = 0;
                $countPaid = 0;
                if($valueCarousel['status'] == 3) {
                    $totalpoIdr = $totalPerorang;
                    $totalpaidItem = $valueCarousel['nominal'];
                    $countPo++;
                    $countPaid++;
                } else if($valueCarousel['status'] == 5) {
                    $paidArray = explode('|', $valueCarousel['nominal']);
                    $totalpaidItem = array_sum($paidArray);
                    $totalpoIdr = $totalpaidItem;
                    $countPo++;
                    $countPaid++;
                } else if($valueCarousel['status'] == 0) {
                    $totalpoIdr = $totalPerorang;
                    $countPo++;
                } else if($valueCarousel['status'] == 2) {
                    $totalpoIdr = $totalPerorang;
                    $totalsentIdr = $totalPerorang; 
                    $countPo++;
                    $countSent++;
                } else if($valueCarousel['status'] == 1) {
                    $totalpoIdr = $totalPerorang;
                    $countPo++;
                }

                 $month = date("n", strtotime($valueCarousel['created_at']));
    
                //loop for extra charge
                $extras = $this->extra_charge->GetList($valueCarousel["id"]);
                $tempExtra = 0;
                foreach ($extras as $extraValue) {
                    $totalpoIdr += $extraValue["price"];
                }
    
                if($valueCarousel['shipping_cost']) {
                    $totalpoIdr += $value['shipping_cost'];
                }

                if(!isset($mapUser[$valueCarousel['created_by']])) {
                    $mapUser[$valueCarousel['created_by']] = [
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
                        'revenue' => $revenuePerorang + $mapUser[$valueCarousel['created_by']]['revenue'],
                        'incentive' => $incentivePerorang + $mapUser[$valueCarousel['created_by']]['incentive'],
                        'total' => $totalPerorang + $mapUser[$valueCarousel['created_by']]['total'],
                        'total_po' => $mapUser[$valueCarousel['created_by']]['total_po'] + $countPo,
                        'total_po_idr' => $mapUser[$valueCarousel['created_by']]['total_po_idr'] + $totalpoIdr,
                        'total_sent' => $mapUser[$valueCarousel['created_by']]['total_sent'] + $countSent,
                        'total_sent_idr' => $mapUser[$valueCarousel['created_by']]['total_sent_idr'] + $totalsentIdr,
                        'total_paid' => $mapUser[$valueCarousel['created_by']]['total_paid'] + $countPaid,
                        'total_paid_idr' => $mapUser[$valueCarousel['created_by']]['total_paid_idr'] + $totalpaidItem,
                    ];
                    $mapUser[$valueCarousel['created_by']] = $arrTemp;
                }
    
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

                    $mapUser[$valueUser['email']]['img'] = $valueUser['img'];
                    if($valueUser['img']=="") {
                        $named = explode(",", $valueUser['name']);
                        $initialsName = "";
                        foreach ($named as $valueInitial) {
                            # code...
                            $initialsName .= $valueInitial[0];
                        }
                        $mapUser[$valueUser['email']]['initial'] = $initialsName;
                    } 
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

        if($user['role'] == "marketing") {
            foreach ($stockAll as $valueStock) {
                $stockIn += $valueStock['stock_in'];
                $stockOut += $valueStock['stock_out'];
                foreach ($mapMarketingStock as $valueStockMarketing) {
                    if($valueStock['stock_out'] != 0 && $valueStock['cart_id'] == $valueStockMarketing) {
                        if(isset($mapProduct[$valueStock['id_product']])) {
                            $mapProduct[$valueStock['id_product']]['stock_out'] += $valueStock['stock_out'];
                        } else {
                            $mapProduct[$valueStock['id_product']]['stock_out'] = $valueStock['stock_out'];
                        }
                    }
                }
                if($valueStock['stock_in'] != 0 && $valueStock['cart_id'] == $valueStockMarketing && strpos($valueStock['desc'], "CANCEL") === 0) {
                        if(isset($mapProduct[$valueStock['id_product']])) {
                            $mapProduct[$valueStock['id_product']]['stock_out'] += $valueStock['stock_in'] * -1;
                        } else {
                            $mapProduct[$valueStock['id_product']]['stock_out'] = $valueStock['stock_in'] * -1;
                        }
                    }
            }
        } else {
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
                
                if($valueStock['stock_in'] != 0 && strpos($valueStock['desc'], "CANCEL") === 0) {
                    if(isset($mapProduct[$valueStock['id_product']]) ) {
                        $mapProduct[$valueStock['id_product']]['stock_out'] += $valueStock['stock_in'] * -1;
                    } else {
                        $mapProduct[$valueStock['id_product']]['stock_out'] = $valueStock['stock_in'] * -1;
                    }
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

        $result['total_insentive'] = number_format(ceil($incentiveIdr),0,',','.');
        // $result['insentivePerc'] = round(($incentiveIdr*100)/$total,2);
        $totalSales = ceil($total) + ceil($extraVal);
        $result['total_sales'] = number_format($totalSales,0,',','.');
        $result['total_shipping'] = number_format($totalShippingCost,0,',','.');
        $result['total_other_cost'] = number_format($totalOtherCost,0,',','.');
        $totalRevenue = $totalSales - ceil($totalShippingCost);
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
        $result['total_salary'] = number_format($totalSalary,0,',','.');
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

    private function getTimeAgo($timestamp) {
    $timezone = 'Asia/Jakarta';
    $now = new DateTime('now', new DateTimeZone('UTC'));
    $now->setTimezone(new DateTimeZone($timezone));
    $time = new DateTime($timestamp, new DateTimeZone($timezone));

    $interval = $now->diff($time);

    if ($interval->y > 0) {
        return $interval->format('%y years ago');
    } elseif ($interval->m > 0) {
        return $interval->format('%m months ago');
    } elseif ($interval->d > 0) {
        return $interval->format('%d days ago');
    } elseif ($interval->h > 0) {
        return $interval->format('%h hours ago');
    } elseif ($interval->i > 0) {
        return $interval->format('%i minutes ago');
    } else {
        return 'Just now';
    }
    }

    private function getDayAgo($timestamp) {
        $timezone = 'Asia/Jakarta';
        $now = new DateTime('now', new DateTimeZone('UTC'));
        $now->setTimezone(new DateTimeZone($timezone));
        $now->setTime(0, 0, 0);

        $time = new DateTime($timestamp, new DateTimeZone($timezone));
        $time->setTime(0, 0, 0);
    
        $interval = $now->diff($time);


        if ($interval->d <= 4 && $interval->invert==0) {
            return $interval->format('%d');
        }

        return "";
    }

}
