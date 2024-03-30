@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Dashboard</h1>
@stop

@section('content')
    <h4><b>Home</b></h4>
    <p>Welcome back <b>{{ $user['name'] }}</b></p>
    <div class="card">
      <div class="container" style="margin-bottom: 20px;margin-top:20px;">
        <div class="row">
          <div class="col text-center">
            <div class="d-flex flex-column align-items-center">
                <div class="initials mb-2" id="initials"></div>
                <div><b>{{ $user['name'] }}</b></div>
                <div>{{ $user['role'] }}</div>
                <a class="btn btn-primary" id="edit-profile" href="{{ route('users.edit', $user) }}">Edit Profil</a>
            </div>
        </div>
          <div class="col">
            <div class="col">
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
      <div class="row">
        <div class="col">
          <div class="alert alert-info alert-dismissible fade show" role="alert">
            <h5>Today is {{ $item['name'] }} Birthday</h5>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
          </div>
        </div>
      </div>
    @endforeach

    <div style="text-align: end">
      <p style="font-weight: bold;font-size: 20px">Set Period</p>
      <div style="margin-bottom: 20px">
        <select id="month" name="month" onchange="GetAll(event)">
          <option value="all" selected>All Months</option>        

            @for ($i = 1; $i <= 12; $i++)
                {{-- @if ($i == $result['month_now'])
                  <option value="{{ $i }}" selected>{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                @else
                  <option value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>        
                @endif --}}
                <option value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>        

            @endfor
        </select>
        <select id="year" name="year" onchange="GetAll(event)">
          @for ($year = date("Y"); $year >= 1900; $year--)
              @if ($year == $result['year_now'])
               <option value="{{ $year }}" selected>{{ $year }}</option>    
              @else
                <option value="{{ $year }}">{{ $year }}</option>   
              @endif
          @endfor
        </select>
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
                Total Sales <p id="total_sales">IDR {{ $result['total_sales'] }}</p>
              </div>
              <hr/>
              <div class="d-flex justify-content-between">
                Total Incentive <p class="text-danger" id="total_insentive">IDR {{ $result['total_insentive'] }}</p>
              </div>
              <hr />
              <div class="d-flex justify-content-between">
                Shipping Cost <p class="text-danger" id="total_shipping">IDR {{ $result['total_shipping'] }}</p>
              </div>
              @if ($user['role'] == "superuser")
              <hr />
              <div class="d-flex justify-content-between">
                Total Salary <p class="text-danger" id="total_salary">IDR {{ $result['total_salary'] }}</p>
              </div>
              <hr />
              <div class="d-flex justify-content-between">
                Total Other Cost <p class="text-danger" id="total_other_cost">IDR {{ $result['total_other_cost'] }}</p>
              </div>
              @endif
              <hr />
              <div class="d-flex justify-content-between">
                Total Revenue <p class="text-success" id="total_revenue">IDR {{ $result['total_revenue'] }}</p>
              </div>
              <hr />
              <div class="d-flex justify-content-between">
                Total Paid <p class="text-success" id="total_paid">IDR {{ $result['total_paid'] }}</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card">
            <div class="card-body" id="map_product">
              <h4><b>Best Product of The Period</b></h4>
              @foreach ($result['map_product'] as $itemProduct)
                <div class="d-flex align-items-center justify-content-between py-2 px-3 border rounded mb-1">
                  <span>{{ $itemProduct['name'] }}</span>
                  <b class="p-2 border rounded bg-primary bg-opacity-10">{{ $itemProduct['stock_out'] }}</b>
                </div>
              @endforeach
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
                      <h5 class="font-extrabold mb-0" id="total_po">
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
                      <span class="font-extrabold mb-0">IN : <span class="badge bg-warning" id="total_stock_in">{{ $result['total_stock_in']}}</span> | OUT : <span class="badge bg-info" id="total_stock_out">{{ $result['total_stock_out'] }}</span></span>
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
                      <h5 class="font-extrabold mb-0" id="total_marketing_user">
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
                      <h5 class="font-extrabold mb-0" id="total_doctor">
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
                  <span class="badge bg-danger badge-pill badge-round ms-1" id="total_super_user"> {{ $result['total_super_user'] }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  <span>Manager 
                  </span>
                  <span class="badge bg-danger badge-pill badge-round ms-1" id="total_manager_user"> {{ $result['total_manager_user'] }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  <span>Finance 
                  </span>
                  <span class="badge bg-danger badge-pill badge-round ms-1" id="total_finance_user"> {{ $result['total_finance_user'] }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  <span>Admin 
                  </span>
                  <span class="badge bg-danger badge-pill badge-round ms-1" id="total_admin_user"> {{ $result['total_admin_user'] }}</span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="map_user">
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
    </div>

    <div class="container">
      <div class="row">
        <div class="col-md-8">
          <div class="card">
            <div class="card-body">
              <canvas id="pie-chart1" height="280" width="600"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>

    <style>
    .initials {
      width: 50px; /* Set the width of the initials circle */
      height: 50px; /* Set the height of the initials circle */
      border-radius: 50%;
      background-color: #007bff; /* Change this to the desired color */
      color: white;
      font-size: 20px; /* Adjust the font size as needed */
      line-height: 50px; /* Ensure the initials are vertically centered */
      text-transform: uppercase;
    }
    </style>
    
@stop

@push('js')
<script>
  // $(function() { 
  //   $("#datepicker1").datetimepicker({ dateFormat: 'yy' });
  // });


  window.onload = function() {
    var user = @json($user);

    // Function to get initials from a name
    function getInitials(name) {
      return name.split(' ').map(word => word.charAt(0)).join('').toUpperCase();
    }

    // Get the name from somewhere, e.g., from a variable or an input field
    var name = user.name;

    // Get the initials
    var initials = getInitials(name);

    // Update the initials div
    document.getElementById('initials').innerText = initials;
  };

  data = @json($data);
  result = @json($result);

  //options

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

  function CobaSelect(e) {
    // console.log()
    alert(e.target.value);
  }

  function GetAll(e) {
    // let val = e.target.value;
    let month = document.getElementById("month")
    let year = document.getElementById("year")
    month = month.value
    year = year.value

    let [startDate, endDate] = formatDate2(month, year)
    // alert(`${startDate}-${endDate}`)
    // return
    // return
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: "{{url('/')}}"+"/dashboard/getlist",
      beforeSend: $.LoadingOverlay("show"),
      afterSend:$.LoadingOverlay("hide"),
      data: { "_token": "{{ csrf_token() }}","end_date": endDate, "start_date": startDate},
      success: function (data) {
        // console.log({data}, "dataaa1")
        document.querySelector(`#total_sales`).innerHTML = `IDR ${data['result']['total_sales']}`
        document.querySelector(`#total_insentive`).innerHTML = `IDR ${data['result']['total_insentive']}`
        document.querySelector(`#total_shipping`).innerHTML = `IDR ${data['result']['total_shipping']}`
        document.querySelector(`#total_salary`).innerHTML = `IDR ${data['result']['total_salary']}`
        document.querySelector(`#total_other_cost`).innerHTML = `IDR ${data['result']['total_other_cost']}`
        document.querySelector(`#total_revenue`).innerHTML = `IDR ${data['result']['total_revenue']}`
        document.querySelector(`#total_paid`).innerHTML = `IDR ${data['result']['total_paid']}`
        document.querySelector(`#total_po`).innerHTML = `${data['result']['total_po']}`
        document.querySelector(`#total_marketing_user`).innerHTML = `${data['result']['total_marketing_user']}`
        document.querySelector(`#total_doctor`).innerHTML = `${data['result']['total_doctor']}`
        document.querySelector(`#total_super_user`).innerHTML = `${data['result']['total_super_user']}`
        document.querySelector(`#total_manager_user`).innerHTML = `${data['result']['total_manager_user']}`
        document.querySelector(`#total_finance_user`).innerHTML = `${data['result']['total_finance_user']}`
        document.querySelector(`#total_admin_user`).innerHTML = `${data['result']['total_admin_user']}`
        document.querySelector(`#total_stock_in`).innerHTML = `${data['result']['total_stock_in']}`
        document.querySelector(`#total_stock_out`).innerHTML = `${data['result']['total_stock_out']}`
        MapProduct(data['result'])
        MapUser(data['result'])
        MapGrafik(data['result'])
      },
      error: function (result, status, err) {
        console.log(err)
      }
    });
  }

  function MapProduct(result) {
    let htmlElement = `<h4><b>Best Product of The Period</b></h4>`
    for (let i = 0; i < result['map_product'].length; i++) {
      const element = result['map_product'][i];
      let el = `
      <div class="d-flex align-items-center justify-content-between py-2 px-3 border rounded mb-1">
        <span>${element['name']}</span>
        <b class="p-2 border rounded bg-primary bg-opacity-10">${element['stock_out']}</b>
      </div>
      `
      htmlElement += el
    }

    document.querySelector(`#map_product`).innerHTML = htmlElement;
  }

  function MapUser(result) {
    let count = 1
    let htmlElement = `<div class="owl-carousel owl-theme">`
    for(const user in result['map_user']) {
      const mapUser = result['map_user'][user]
      htmlElement += `        
      <div class="item">
          <div class="card">
            <div class="card-body px-4 py-4-0">
              <div>
                ${count}
                <div class=" d-flex justify-content-center card-profile-picture">
                  <img src="..." alt="">
                </div>
                <div class="divider">
                  <div class="divider-text">
                    <h4 class="mt-2">${mapUser['name']}</h4>
                  </div>
                </div>
              </div>
              <div class="row mt-3">
                <div class="col">
                  <div class="d-flex justify-content-between">
                    <h5>Purchase Order</h5>
                    <div>
                      <span>Total </span>
                      <span class="badge bg-primary ms-1">${mapUser['total_po']}</span>
                    </div>
                  </div>
                  <span class="text-success d-flex justify-content-start">IDR ${mapUser['total_po_idr']}</span>
                  <hr class="my-2">
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="d-flex justify-content-between">
                    <h5 class="mb-1">PO Sent</h5>
                    <div>
                      <span>Total</span>
                      <span class="badge bg-info ms-1">${mapUser['total_sent']}</span>
                    </div>
                  </div>
                  <span class="text-success d-flex justify-content-start">IDR ${mapUser['total_sent_idr']}</span>
                  <hr class="my-2">
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="d-flex justify-content-between">
                    <h5 class="mb-1">PO Paid</h5>
                    <div>
                      <span>Total</span>
                      <span class="badge bg-success ms-1">${mapUser['total_paid']}</span>
                    </div>
                  </div>
                  <strong class="text-success d-flex justify-content-start">IDR ${mapUser['total_paid_idr']}</strong>
                  <hr class="my-2">
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="d-flex justify-content-between">
                    <h5 class="mb-1">Incentive</h5>
                    <strong class="text-success d-flex justify-content-start">IDR ${mapUser['incentive']}</strong>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>`
        count++
      }
      htmlElement += `</div>`
      document.querySelector(`#map_user`).innerHTML = htmlElement;
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
  }

  function MapGrafik(result) {
    var ctx1 = $("#pie-chart1");
    var kiri1 = {
      labels: xValues,
      datasets: [{
        label: "All",
        data: [result['map_month'][1], result['map_month'][2], result['map_month'][3], result['map_month'][4], result['map_month'][5], result['map_month'][6], result['map_month'][7], result['map_month'][8], result['map_month'][9], result['map_month'][10], result['map_month'][11], result['map_month'][12]],
        borderColor: "red",
        fill: false
      },
    ]
    };  

    var chart1 = new Chart(ctx1, {
      type: 'line',
      data: kiri1,
      options: options,
    });
  }

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
    });

  function formatDate2(month, year) {
    if(month!="all"){
      let endDate = new Date(year, month + 1, 0);
      endDate = endDate.getDate();
      endDate = `${year}-${month}-${endDate}`
      let startDate = `${year}-${month}-01`
      return [startDate, endDate]
    }else{
      endDate = `${year}-12-31`
      startDate = `${year}-01-01`
      return [startDate, endDate]
    }
  }
  
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
  ]
  };  

  var chart1 = new Chart(ctx1, {
    type: 'line',
    data: kiri1,
    options: options,
  });
    
</script>
    
@endpush