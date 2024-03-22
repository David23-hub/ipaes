@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Dashboard</h1>
@stop

@section('content')
    <h4><b>Home</b></h4>
    <p>Welcome back <b>{{ $user['name'] }}</b></p>
    <div class="card">
      <div class="container">
        <div class="row">
          <div class="col">
            <img src="..." alt="">
              <div><b>{{ $user['name'] }}</b></div>
              <div>{{ $user['role'] }}</div>
              <a class="btn-primary" id="edit-profile" href="{{route('users.edit', $user)}}">Edit Profil</a>
          </div>
          <div class="col">
            <img src="..." alt="">
          </div>
          <div class="col">
            <div class="col">
              <div><h4>Good Morning, <b>{{ $user['name'] }}</b></h4></div>
              <hr/>
              <div><h5>Usename      :{{ $user['name'] }}</h5></div>
              <div><h5>Email        : {{ $user['email'] }}</h5></div>
              <div><h5>Phone        : {{ $user['name'] }}</h5></div>
              <div><h5>Role         : {{ $user['role'] }}</h5></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Looping buat yang ultah dokter --}}
    @foreach ($result['mapDoktor'] as $item)
      <div class="card">
        <div><h5>Hari ini dokter {{ $item['name'] }} berulang tahun</h5></div>
      </div>
    @endforeach

    <div style="text-align: end">
      Set Period
      <div>
        <select name="tanggal" id="select-tanggal">
          <option value="All-Month">All Month</option>
          <option value="1">Januari</option>
          <option value="2">Februari</option>
          <option value="3">Maret</option>
          <option value="4">April</option>
          <option value="5">Mei</option>
          <option value="6">Juni</option>
          <option value="7">Juli</option>
          <option value="8">Agustus</option>
          <option value="9">September</option>
          <option value="10">Oktober</option>
          <option value="11">November</option>
          <option value="12">Desember</option>
        </select>
      </div>
      <div>
        <input type="text" id="datepicker1">
      </div>
    </div>

    <div class="container">
      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h4><b>Total Revenue This Period</b></h4>
              <br>
              <div class="d-flex justify-content-between">
                Total Sales <p>IDR {{ $result['total_sales'] }}</p>
              </div>
              <hr/>
              <div class="d-flex justify-content-between">
                Total Incentive <p class="text-danger">IDR {{ $result['total_insentive'] }}</p>
              </div>
              <hr />
              <div class="d-flex justify-content-between">
                Shipping Cost <p class="text-danger">IDR {{ $result['total_shipping'] }}</p>
              </div>
              <hr />
              <div class="d-flex justify-content-between">
                Total Salary <p class="text-danger">IDR 0</p>
              </div>
              <hr />
              <div class="d-flex justify-content-between">
                Total Other Cost <p class="text-danger">IDR {{ $result['total_other_cost'] }}</p>
              </div>
              <hr />
              <div class="d-flex justify-content-between">
                Total Revenue <p class="text-success">IDR {{ $result['total_revenue'] }}</p>
              </div>
              <hr />
              <div class="d-flex justify-content-between">
                Total Paid <p class="text-success">IDR {{ $result['total_paid'] }}</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h4><b>Best Product of The Period</b></h4>
              <div class="d-flex align-items-center justify-content-between py-2 px-3 border rounded mb-1">
                <span>Avalon Grand Plus</span>
                <b class="p-2 border rounded bg-primary bg-opacity-10">91</b>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="container">
      <div class="row">
        <div class="col-md-8">
          <div class="row">
            <div class="col-md-6">
              <div class="card">
                <div class="card-body px-4 py-4-0">
                  <div class="row">
                    <div class="col-md-3 d-flex justify-content-center">
                      <i class="bi bi-clipboard-plus"></i>
                    </div>
                    <div class="col-md">
                      <h6 class="text-muted font-semibold">Total PO This Period</h6>
                      <h5 class="font-extrabold mb-0">
                        {{ $result['total_po'] }}
                      </h5>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card">
                <div class="card-body px-4 py-4-0">
                  <div class="row">
                    <div class="col-md-3 d-flex justify-content-center">
                      <i class="bi bi-clipboard-plus"></i>
                    </div>
                    <div class="col-md">
                      <h6 class="text-muted font-semibold">Total Stock This Period</h6>
                      <span class="font-extrabold mb-0">IN : <span class="badge bg-warning">{{ $result['total_stock_in']}}</span> | OUT : <span class="badge bg-info">{{ $result['total_stock_out'] }}</span></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card">
                <div class="card-body px-4 py-4-0">
                  <div class="row">
                    <div class="col-md-3 d-flex justify-content-center">
                      <div class="stats-icon bg-dark mb-2">
                        <i class="bi bi-person-badge text-black"></i>
                      </div>
                    </div>
                    <div class="col-md">
                      <h6 class="text-muted font-semibold">Total Marketing Users</h6>
                      <h5 class="font-extrabold mb-0">
                        {{ $result['total_marketing_user'] }}
                      </h5>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card">
                <div class="card-body px-4 py-4-0">
                  <div class="row">
                    <div class="col-md-3 d-flex justify-content-center">
                      <div class="stats-icon bg-info mb-2">
                        <i class="bi bi-person-rolodex"></i>
                      </div>
                    </div>
                    <div class="col-md">
                      <h6 class="text-muted font-semibold">Total Doctor Users</h6>
                      <h5 class="font-extrabold mb-0">
                        {{ $result['total_doctor'] }}
                      </h5>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md">
          <div class="card">
            <div class="card-body">
              <h5>Total Users</h5>
              <ul class="list-group py-1">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  <span>Superuser 
                  </span>
                  <span class="badge bg-danger badge-pill badge-round ms-1"> {{ $result['total_super_user'] }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  <span>Manager 
                  </span>
                  <span class="badge bg-danger badge-pill badge-round ms-1"> {{ $result['total_manager_user'] }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  <span>Finance 
                  </span>
                  <span class="badge bg-danger badge-pill badge-round ms-1"> {{ $result['total_finance_user'] }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  <span>Admin 
                  </span>
                  <span class="badge bg-danger badge-pill badge-round ms-1"> {{ $result['total_admin_user'] }}</span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- <div class="card" style="width: calc(100%/3); margin: 0.5em">
      <div class="card-body px-4 py-4-0">
        <div>
          {#1}
          <div class=" d-flex justify-content-center card-profile-picture">
            <img src="..." alt="">
          </div>
          <div class="divider">
            <div class="divider-text">
              <h4 class="mt-2">{Nama}</h4>
            </div>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col">
            <div class="d-flex justify-content-between">
              <h5>Purchase Order</h5>
              <div>
                <span>Total </span>
                <span class="badge bg-primary ms-1">31</span>
              </div>
            </div>
            <span class="text-success d-flex justify-content-start">IDR 112.969.000</span>
            <hr class="my-2">
          </div>
        </div>
        <div class="row">
          <div class="col">
            <div class="d-flex justify-content-between">
              <h5 class="mb-1">PO Sent</h5>
              <div>
                <span>Total</span>
                <span class="badge bg-info ms-1">10</span>
              </div>
            </div>
            <span class="text-success d-flex justify-content-start">IDR 32.043.000</span>
            <hr class="my-2">
          </div>
        </div>
        <div class="row">
          <div class="col">
            <div class="d-flex justify-content-between">
              <h5 class="mb-1">PO Paid</h5>
              <div>
                <span>Total</span>
                <span class="badge bg-success ms-1">4</span>
              </div>
            </div>
            <strong class="text-success d-flex justify-content-start">IDR 10.987.000</strong>
            <hr class="my-2">
          </div>
        </div>
        <div class="row">
          <div class="col">
            <div class="d-flex justify-content-between">
              <h5 class="mb-1">Incentive</h5>
              <strong class="text-success d-flex justify-content-start">IDR 2.259.380</strong>
            </div>
          </div>
        </div>
      </div>
    </div> --}}

    <div class="owl-carousel owl-theme">
      @foreach ($result['map_user'] as $item)
        <div class="item">
          <div class="card">
            <div class="card-body px-4 py-4-0">
              <div>
                #{{ $count++ }}
                <div class=" d-flex justify-content-center card-profile-picture">
                  <img src="..." alt="">
                </div>
                <div class="divider">
                  <div class="divider-text">
                    <h4 class="mt-2">{{ $item['name'] }}</h4>
                  </div>
                </div>
              </div>
              <div class="row mt-3">
                <div class="col">
                  <div class="d-flex justify-content-between">
                    <h5>Purchase Order</h5>
                    <div>
                      <span>Total </span>
                      <span class="badge bg-primary ms-1">{{ $item['total_po'] }}</span>
                    </div>
                  </div>
                  <span class="text-success d-flex justify-content-start">IDR {{ $item['total_po_idr'] }}</span>
                  <hr class="my-2">
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="d-flex justify-content-between">
                    <h5 class="mb-1">PO Sent</h5>
                    <div>
                      <span>Total</span>
                      <span class="badge bg-info ms-1">{{ $item['total_sent'] }}</span>
                    </div>
                  </div>
                  <span class="text-success d-flex justify-content-start">IDR {{ $item['total_sent_idr'] }}</span>
                  <hr class="my-2">
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="d-flex justify-content-between">
                    <h5 class="mb-1">PO Paid</h5>
                    <div>
                      <span>Total</span>
                      <span class="badge bg-success ms-1">{{ $item['total_paid'] }}</span>
                    </div>
                  </div>
                  <strong class="text-success d-flex justify-content-start">IDR {{ $item['total_paid_idr'] }}</strong>
                  <hr class="my-2">
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="d-flex justify-content-between">
                    <h5 class="mb-1">Incentive</h5>
                    <strong class="text-success d-flex justify-content-start">IDR {{ $item['incentive'] }}</strong>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    {{-- <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <div class="cards-wrapper" style="display: flex">
            <div class="card">
              <div class="card-body px-4 py-4-0">
                <div>
                  {#1}
                  <div class=" d-flex justify-content-center card-profile-picture">
                    <img src="..." alt="">
                  </div>
                  <div class="divider">
                    <div class="divider-text">
                      <h4 class="mt-2">{Nama}</h4>
                    </div>
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col">
                    <div class="d-flex justify-content-between">
                      <h5>Purchase Order</h5>
                      <div>
                        <span>Total </span>
                        <span class="badge bg-primary ms-1">31</span>
                      </div>
                    </div>
                    <span class="text-success d-flex justify-content-start">IDR 112.969.000</span>
                    <hr class="my-2">
                  </div>
                </div>
                <div class="row">
                  <div class="col">
                    <div class="d-flex justify-content-between">
                      <h5 class="mb-1">PO Sent</h5>
                      <div>
                        <span>Total</span>
                        <span class="badge bg-info ms-1">10</span>
                      </div>
                    </div>
                    <span class="text-success d-flex justify-content-start">IDR 32.043.000</span>
                    <hr class="my-2">
                  </div>
                </div>
                <div class="row">
                  <div class="col">
                    <div class="d-flex justify-content-between">
                      <h5 class="mb-1">PO Paid</h5>
                      <div>
                        <span>Total</span>
                        <span class="badge bg-success ms-1">4</span>
                      </div>
                    </div>
                    <strong class="text-success d-flex justify-content-start">IDR 10.987.000</strong>
                    <hr class="my-2">
                  </div>
                </div>
                <div class="row">
                  <div class="col">
                    <div class="d-flex justify-content-between">
                      <h5 class="mb-1">Incentive</h5>
                      <strong class="text-success d-flex justify-content-start">IDR 2.259.380</strong>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card" style="width: calc(100%/3); margin: 0.5em">
              <div class="card-body">
                <h5 class="card-title">Card 1</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              </div>
            </div>
            <div class="card" style="width: calc(100%/3); margin: 0.5em">
              <div class="card-body">
                <h5 class="card-title">Card 1</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              </div>
            </div>
          </div>
        </div>
        <div class="carousel-item">
          <div class="cards-wrapper" style="display: flex">
            <div class="card" style="width: calc(100%/3); margin: 0.5em">
              <div class="card-body">
                <h5 class="card-title">Card 2</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              </div>
            </div>
            <div class="card" style="width: calc(100%/3); margin: 0.5em">
              <div class="card-body">
                <h5 class="card-title">Card 2</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              </div>
            </div>
            <div class="card" style="width: calc(100%/3); margin: 0.5em">
              <div class="card-body">
                <h5 class="card-title">Card 2</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              </div>
            </div>
          </div>
        </div>
        <div class="carousel-item">
          <div class="cards-wrapper" style="display: flex">
            <div class="card" style="width: calc(100%/3); margin: 0.5em">
              <div class="card-body">
                <h5 class="card-title">Card 3</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              </div>
            </div>
            <div class="card" style="width: calc(100%/3); margin: 0.5em">
              <div class="card-body">
                <h5 class="card-title">Card 3</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              </div>
            </div>
            <div class="card" style="width: calc(100%/3); margin: 0.5em">
              <div class="card-body">
                <h5 class="card-title">Card 3</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              </div>
            </div>
          </div>
        </div>
        <div class="carousel-item">
          <div class="cards-wrapper" style="display: flex">
            <div class="card" style="width: calc(100%/3); margin: 0.5em">
              <div class="card-body">
                <h5 class="card-title">Card 4</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              </div>
            </div>
            <div class="card" style="width: calc(100%/3); margin: 0.5em">
              <div class="card-body">
                <h5 class="card-title">Card 4</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              </div>
            </div>
            <div class="card" style="width: calc(100%/3); margin: 0.5em">
              <div class="card-body">
                <h5 class="card-title">Card 4</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> --}}

    <div class="container">
      <div class="row">
        <div class="col-md-8">
          <div class="card">
            <div class="card-body">
              <canvas id="pie-chart1" height="280" width="600"></canvas>
            </div>
          </div>
        </div>
        {{-- <div class="col-md">
          <div class="card">
            <div class="card-body">
              <h5>Top 5 Best Marketing by
                <strong class="text-primary">Omzet.</strong>
              </h5>
              <div id="top-5-marketing">
                <ul class="list-group mt-3">
                  <li class="list-group-item">
                    <div class="row">
                      <div class="col">
                        <div class="d-flex justify-content-between align-items-center">
                          <strong><img src="" alt="">
                          <br>
                          Yudiono
                          </strong>
                          <span>
                            <span class="badge bg-primary badge-pill badge-round ms-1">
                              {Omzet pencapaian}
                            </span>
                          </span>
                        </div>
                        <div class="progress progress-sm progress-primary my-2">
                          <div class="progress-bar" role="progressbar" style="width: 26.14%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <div class="row">
                      <div class="col">
                        <div class="d-flex justify-content-between align-items-center">
                          <strong><img src="" alt="">
                          <br>
                          Yudiono
                          </strong>
                          <span>
                            <span class="badge bg-primary badge-pill badge-round ms-1">
                              {Omzet pencapaian}
                            </span>
                          </span>
                        </div>
                        <div class="progress progress-sm progress-primary my-2">
                          <div class="progress-bar" role="progressbar" style="width: 26.14%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div> --}}
      </div>
    </div>
    
@stop

@push('js')
<script>
  // $(function() { 
  //   $("#datepicker1").datetimepicker({ dateFormat: 'yy' });
  // });

  data = @json($data);
  result = @json($result);

  console.log(data)
  console.log(result)
  //options

  $('.owl-carousel').owlCarousel({
    loop:true,
    margin:10,
    // nav:true,
    autoplay:true,
    autoplayTimeout:1000,
    autoplayHoverPause:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        }
    }
})

  var options = {
    responsive: true,
    title: {
      display: true,
      position: "top",
      text: "Last Week Registered Users -  Day Wise Count",
      fontSize: 18,
      fontColor: "#111"
    },
    legend: {
      display: true,
      position: "top",
      labels: {
        fontColor: "#333",
        fontSize: 16
      }
    }
  };
  
  const xValues = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober", "November", "Desember"];

  var ctx1 = $("#pie-chart1");
  var kiri1 = {
    labels: xValues,
    // datasets: [
    //   {
    //     label: "KIRI ATAS",
    //     data: dataKiri1.data,
    //     backgroundColor: [
    //       "#DEB887",
    //       "#A9A9A9",
    //       "#DC143C",
    //       "#F4A460",
    //       "#2E8B57",   
    //       "#1D7A46",
    //       "#CDA776",
    //     ],
    //     borderColor: [
    //       "#CDA776",
    //       "#989898",
    //       "#CB252B",
    //       "#E39371",
    //       "#1D7A46",
    //       "#F4A460",
    //       "#CDA776",
    //     ],
    //     borderWidth: [1, 1, 1, 1, 1,1,1]
    //   }
    // ]
    datasets: [{
      label: "All",
      // data: [860,1140,1060,1060,1070,1110,1330,2210,7830,2478],
      data: [result['map_month'][1], result['map_month'][2], result['map_month'][3], result['map_month'][4], result['map_month'][5], result['map_month'][6], result['map_month'][7], result['map_month'][8], result['map_month'][9], result['map_month'][10], result['map_month'][11], result['map_month'][12]],
      borderColor: "red",
      fill: false
    },
    {
      label: "transaction",
      data: [1600,1700,1700,1900,2000,2700,4000,5000,6000,7000],
      borderColor: "green",
      fill: false
    },{
      label: "input user",
      data: [300,700,2000,5000,6000,4000,2000,1000,200,100],
      borderColor: "blue",
      fill: false
    }
  ]
  };   

  if(result['map_user'].length > 0) {
    var chart1 = new Chart(ctx1, {
      type: 'line',
      data: kiri1,
      options: options,
    });
  }

      // var ctx2 = $("#pie-chart2");
      // var kiri2 = {
      //   labels: dataKiri2.label,
      //   datasets: [
      //     {
      //       label: "KIRI BAWAH",
      //       data: dataKiri2.data,
      //       backgroundColor: [
      //         "#DEB887",
      //         "#A9A9A9",
      //         "#DC143C",
      //         "#F4A460",
      //         "#2E8B57",
      //         "#1D7A46",
      //         "#CDA776",
      //       ],
      //       borderColor: [
      //         "#CDA776",
      //         "#989898",
      //         "#CB252B",
      //         "#E39371",
      //         "#1D7A46",
      //         "#F4A460",
      //         "#CDA776",
      //       ],
      //       borderWidth: [1, 1, 1, 1, 1,1,1]
      //     }
      //   ]
      // };
      // var chart2 = new Chart(ctx2, {
      //   type: 'bar',
      //   data: kiri2,
      //   options: options,
      // });

      // var ctx3 = $("#pie-chart3");
      // var tengah1 = {
      //   labels: dataTengah1.label,
      //   datasets: [
      //     {
      //       label: "TENGAH",
      //       data: dataTengah1.data,
      //       backgroundColor: [
      //         "#DEB887",
      //         "#A9A9A9",
      //         "#DC143C",
      //         "#F4A460",
      //         "#2E8B57",
      //         "#1D7A46",
      //         "#CDA776",
      //       ],
      //       borderColor: [
      //         "#CDA776",
      //         "#989898",
      //         "#CB252B",
      //         "#E39371",
      //         "#1D7A46",
      //         "#F4A460",
      //         "#CDA776",
      //       ],
      //       borderWidth: [1, 1, 1, 1, 1,1,1]
      //     }
      //   ]
      // };
      // var chart3 = new Chart(ctx3, {
      //   type: 'bar',
      //   data: tengah1,
      //   options: options,
      // });

      // var ctx4 = $("#pie-chart4");
      // var kanan1 = {
      //   labels: dataKanan1.label,
      //   datasets: [
      //     {
      //       label: "KANAN ATAS",
      //       data: dataKanan1.data,
      //       backgroundColor: [
      //         "#DEB887",
      //         "#A9A9A9",
      //         "#DC143C",
      //         "#F4A460",
      //         "#2E8B57",
      //         "#1D7A46",
      //         "#CDA776",
      //       ],
      //       borderColor: [
      //         "#CDA776",
      //         "#989898",
      //         "#CB252B",
      //         "#E39371",
      //         "#1D7A46",
      //         "#F4A460",
      //         "#CDA776",
      //       ],
      //       borderWidth: [1, 1, 1, 1, 1,1,1]
      //     }
      //   ]
      // };
      // var chart4 = new Chart(ctx4, {
      //   type: 'bar',
      //   data: kanan1,
      //   options: options,
      // });

      

      

      

</script>
    
@endpush