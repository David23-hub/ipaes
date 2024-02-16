@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-4">
          <div class="row">
            <div class="col">
              <div class="card">
                <div class="card-body">
                    <canvas id="pie-chart1" height="280" width="600"></canvas>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card">
                <div class="card-body">
                    <canvas id="pie-chart2" height="280" width="600"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-4">
          <div class="row">
            <div class="col">
              <div class="card">
                <div class="card-body">
                    <canvas id="pie-chart3" height="280" width="600"></canvas>
                </div>
            </div>
            </div>
          </div>
        </div>
        <div class="col-4">
          <div class="row">
            <div class="col">
              <div class="card">
                <div class="card-body">
                    <canvas id="pie-chart4" height="280" width="600"></canvas>
                </div>
            </div>
            </div>
          </div>
        </div>
    </div>
@stop

@push('js')
<script>

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
          position: "bottom",
          labels: {
            fontColor: "#333",
            fontSize: 16
          }
        }
      };
      
      var dataKiri1 = JSON.parse(`<?php echo $kiri_1; ?>`);
      var dataKiri2 = JSON.parse(`<?php echo $kiri_2; ?>`);
      var dataTengah1 = JSON.parse(`<?php echo $tengah_1; ?>`);
      var dataKanan1 = JSON.parse(`<?php echo $kanan_1; ?>`);

      var ctx1 = $("#pie-chart1");
      var kiri1 = {
        labels: dataKiri1.label,
        datasets: [
          {
            label: "KIRI ATAS",
            data: dataKiri1.data,
            backgroundColor: [
              "#DEB887",
              "#A9A9A9",
              "#DC143C",
              "#F4A460",
              "#2E8B57",
              "#1D7A46",
              "#CDA776",
            ],
            borderColor: [
              "#CDA776",
              "#989898",
              "#CB252B",
              "#E39371",
              "#1D7A46",
              "#F4A460",
              "#CDA776",
            ],
            borderWidth: [1, 1, 1, 1, 1,1,1]
          }
        ]
      };   
      var chart1 = new Chart(ctx1, {
        type: 'bar',
        data: kiri1,
        options: options,
      });

      var ctx2 = $("#pie-chart2");
      var kiri2 = {
        labels: dataKiri2.label,
        datasets: [
          {
            label: "KIRI BAWAH",
            data: dataKiri2.data,
            backgroundColor: [
              "#DEB887",
              "#A9A9A9",
              "#DC143C",
              "#F4A460",
              "#2E8B57",
              "#1D7A46",
              "#CDA776",
            ],
            borderColor: [
              "#CDA776",
              "#989898",
              "#CB252B",
              "#E39371",
              "#1D7A46",
              "#F4A460",
              "#CDA776",
            ],
            borderWidth: [1, 1, 1, 1, 1,1,1]
          }
        ]
      };
      var chart2 = new Chart(ctx2, {
        type: 'bar',
        data: kiri2,
        options: options,
      });

      var ctx3 = $("#pie-chart3");
      var tengah1 = {
        labels: dataTengah1.label,
        datasets: [
          {
            label: "TENGAH",
            data: dataTengah1.data,
            backgroundColor: [
              "#DEB887",
              "#A9A9A9",
              "#DC143C",
              "#F4A460",
              "#2E8B57",
              "#1D7A46",
              "#CDA776",
            ],
            borderColor: [
              "#CDA776",
              "#989898",
              "#CB252B",
              "#E39371",
              "#1D7A46",
              "#F4A460",
              "#CDA776",
            ],
            borderWidth: [1, 1, 1, 1, 1,1,1]
          }
        ]
      };
      var chart3 = new Chart(ctx3, {
        type: 'bar',
        data: tengah1,
        options: options,
      });

      var ctx4 = $("#pie-chart4");
      var kanan1 = {
        labels: dataKanan1.label,
        datasets: [
          {
            label: "KANAN ATAS",
            data: dataKanan1.data,
            backgroundColor: [
              "#DEB887",
              "#A9A9A9",
              "#DC143C",
              "#F4A460",
              "#2E8B57",
              "#1D7A46",
              "#CDA776",
            ],
            borderColor: [
              "#CDA776",
              "#989898",
              "#CB252B",
              "#E39371",
              "#1D7A46",
              "#F4A460",
              "#CDA776",
            ],
            borderWidth: [1, 1, 1, 1, 1,1,1]
          }
        ]
      };
      var chart4 = new Chart(ctx4, {
        type: 'bar',
        data: kanan1,
        options: options,
      });

      

      

      

</script>
    
@endpush