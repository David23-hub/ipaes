@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Sales Report</h1>
@stop

@section('content')
    <div class="card">
      <div class="card-body">
        <label for="dob_add">Period*</label>
        <p style="color: #a5a6a7">This date is a reference of the paid date.</p>
          <div class="row">
            <div class="col">
              <div style="width: 50%">
                {{-- <input type="text" class="form-control" name="daterange" id="daterange" placeholder="Range Date"> --}}
                <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; display: flex; align-items: center; justify-content: space-between; width: 100%">
                  <div>
                      <i class="fa fa-calendar"></i>&nbsp;
                      <span id="date_input"></span>
                  </div>
                  <div>
                      <i class="fa fa-caret-down"></i>
                  </div>
                </div>
              </div>
            </div>
            <div class="col">
              <button class="btn btn-info" id="src_btn">View Reports</button>
            </div>
          </div>
      </div>
    </div>

    <div id="tbl-body-sales-report" class="card" style="display:none">
      <div class="card-header">
        <div class="row">
          <div class="col">
            <h2 style="font-weight: bold">Detail Report</h2>
          </div>
          <div id="div-down" class="col" style="text-align: right;">
            <button id="dwnld-excl" class="btn btn-success">Download To Excel</button>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div id="listTbl">
        </div>
      </div>
    </div>
    <style>
      .th, td {
        white-space: nowrap;
      }
    </style>

@stop

@push('js')
<script>
  window.onload = function() {
    cb(start, end);
    
  };
      function cb(start, end) {
          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
      }
      var start = moment().subtract(6, 'days');
      var end = moment();
      $('#reportrange').daterangepicker({
          startDate: start,
          endDate: end,
          ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          }
      }, cb);

    var dataTable = $("#tableList").DataTable({
            "ordering": true,
            "destroy": true,
            "paging": false

            //to turn off pagination
            // paging: false,
            // "bFilter": true,
            //turn off info current page data index
            // "bInfo": false,
            // pagingType: 'full_numbers',
        });

    function formatDate(dateString) {
            var parts = dateString.split(' ');
            var day = parts[1].slice(0, -1); // Remove comma from the day
            var month = parts[0];
            var year = parts[2];
            // Convert month name to month number
            var monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            var monthIndex = monthNames.indexOf(month) + 1;
            return day.padStart(2, '0') + '/' + monthIndex.toString().padStart(2, '0') + '/' + year;
    }
        
        var startTemp = ""
    var endTemp = ""

    $('#src_btn').on('click', function(e) {
      var spanText = $('#reportrange span').text();
        var dateArray = spanText.split(' - '); // Split text by hyphen
       var startDate = formatDate(dateArray[0]);

        // Format end date
        var endDate = formatDate(dateArray[1]);

        startTemp= startDate
        endTemp = endDate

        

        $.ajax({
          type: "POST",
          url: "{{url('/')}}"+"/sales/getReport",
          beforeSend: $.LoadingOverlay("show"),
          afterSend:$.LoadingOverlay("hide"),
          data: { "_token": "{{ csrf_token() }}", "startDate":startDate,"endDate":endDate},
          success: function (datas) {
            dataTable.clear();
            dataTable.draw();
            if(datas=="KOSONG"){
              AlertWarningWithMsg("DATA NOT FOUND")
            }else{
              data = datas.data
              

              var container = document.getElementById('listTbl');
              container.innerHTML= datas.tbldiv;

              var element = document.getElementById('tbl-body-sales-report');
              element.style.display = 'block';
              
              var period = document.getElementById('periode');
              period.innerHTML = datas.periode
              alert("woi")
            }
            
          },
          error: function (result, status, err) {
            console.log(err)
          }
        });


      });

      $('#dwnld-excl').on('click', function(e) {
        $.ajax({
          type: "POST",
          url: "{{url('/')}}"+"/sales/getReport/download",
          beforeSend: $.LoadingOverlay("show"),
          afterSend:$.LoadingOverlay("hide"),
          data: { "_token": "{{ csrf_token() }}", "startDate":startTemp,"endDate":endTemp},
          success: function (datas) {
            dataTable.draw();
            if(datas=="KOSONG"){
              AlertWarningWithMsg("DATA NOT FOUND")
              dataTable.clear();

            }else{
              alert(datas.url)
              window.location.href = datas.url;

            }
            
          },
          error: function (result, status, err) {
            console.log(err)
          }
        });


      });
    

</script>
    
@endpush