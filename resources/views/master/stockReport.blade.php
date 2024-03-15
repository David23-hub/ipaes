@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Stock Report</h1>
@stop

@section('content')
    <div class="card">
      <div class="card-body">
        <label for="dob_add">Period *</label>
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
              <button class="btn btn-info" id="src_summary_btn">View Summary Reports</button>
              <button class="btn btn-info" id="src_btn">View Reports</button>
            </div>
          </div>

          <label for="dob_add">Marketing</label>
          <p style="color: #a5a6a7">Leave product input empty to display all products data.</p>
          <div id="dropadd" name="dropadd" class="form-group">
            <select multiple class="form-select form-control" name="list_doctor" id="list_doctor"  style="width: 100%;max-width:100%">
                @foreach($items as $item)
                  <option value={{$item->id}}>{{$item->name}}</option>
                @endforeach

            </select>
          </div>
      </div>
    </div>

    <div id="tbl-body-sales-report" class="card" style="display:none">
      <div class="card-header">
        <div class="row">
          <div class="col">
            <h2 style="font-weight: bold">Detail Report</h2>
          </div>
          <div id="div-down" class="col" style="text-align: right; display:none;">
              <button id="dwnld-excl" class="btn btn-success">Download To Excel</button>
          </div>
        </div>
        <h5>Item Name: <span style="font-weight: bold" id="item-name"></span></h5>
        <h5>Period: <span style="font-weight: bold" id="periode"></span></h5>
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
      .select2-container .select2-selection--single {
          height: calc(1.5em + 0.75rem + 2px); /* Match Bootstrap input height */
          padding: 0.375rem 0.75rem; /* Match Bootstrap input padding */
          font-size: 1rem; /* Match Bootstrap input font size */
          line-height: 1.5; /* Match Bootstrap input line height */
          color: #495057; /* Match Bootstrap input text color */
          background-color: #fff; /* Match Bootstrap input background color */
          background-clip: padding-box;
          border: 1px solid #ced4da; /* Match Bootstrap input border */
          border-radius: 0.25rem; /* Match Bootstrap input border radius */
          transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
      }
      .select2-container--default .select2-selection--multiple .select2-selection__choice {
      background-color: #0080ff;
      color: #fff;
      border-radius: 15px; 
    }

    /* Style for the close button of selected options */
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
      color: #fff;
    }
    .select2-results__option[aria-selected=true] { display: none;}
    
    /* .select2-container--open .select2-dropdown {
            display: block !important;
        } */
    </style>

@stop

@push('js')
<script>
  window.onload = function() {
    cb(start, end);
    $('#list_doctor').select2( {
      closeOnSelect: false,
      placeholder: "Select Item",}
      ).on('select2:unselect', function (e) {
        setTimeout(function() {
            $('#list_doctor').select2('open');
        }, 0);
      });
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
    var listTemp = ""

    $('#src_btn').on('click', function(e) {
      var spanText = $('#reportrange span').text();
        var dateArray = spanText.split(' - '); // Split text by hyphen
       var startDate = formatDate(dateArray[0]);

        // Format end date
        var endDate = formatDate(dateArray[1]);

        var list = $('#list_doctor').val()
        if(list==""){
          list = "all"
        }
        listTemp = list
        startTemp= startDate
        endTemp = endDate

        $.ajax({
          type: "POST",
          url: "{{url('/')}}"+"/stock/getReport",
          beforeSend: $.LoadingOverlay("show"),
          afterSend:$.LoadingOverlay("hide"),
          data: { "_token": "{{ csrf_token() }}", "startDate":startDate,"endDate":endDate,"listUser":list},
          success: function (datas) {
            if(datas=="KOSONG"){
              var element = document.getElementById('tbl-body-sales-report');
              element.style.display = 'none';
              AlertWarningWithMsg("DATA NOT FOUND")
            }else{
              data = datas.data
              var marketing_name = document.getElementById('item-name');
              marketing_name.innerHTML = datas.marketing

              var container = document.getElementById('listTbl');
              container.innerHTML= datas.tbldiv;
              
              var period = document.getElementById('periode');
              period.innerHTML = datas.periode


              var element = document.getElementById('tbl-body-sales-report');
              element.style.display = 'block';

              var x = document.getElementById('div-down');
              x.style.display = "block";

            }
            
          },
          error: function (result, status, err) {
            console.log(err)
          }
        });


      });

      $('#src_summary_btn').on('click', function(e) {
      var spanText = $('#reportrange span').text();
        var dateArray = spanText.split(' - '); // Split text by hyphen
       var startDate = formatDate(dateArray[0]);

        // Format end date
        var endDate = formatDate(dateArray[1]);

        var list = $('#list_doctor').val()
        if(list==""){
          list = "all"
        }
        listTemp = list
        startTemp= startDate
        endTemp = endDate

        $.ajax({
          type: "POST",
          url: "{{url('/')}}"+"/stock/getReport/summary",
          beforeSend: $.LoadingOverlay("show"),
          afterSend:$.LoadingOverlay("hide"),
          data: { "_token": "{{ csrf_token() }}", "startDate":startDate,"endDate":endDate,"listUser":list},
          success: function (datas) {
            if(datas=="KOSONG"){
              var element = document.getElementById('tbl-body-sales-report');
              element.style.display = 'none';
              AlertWarningWithMsg("DATA NOT FOUND")
            }else{
              data = datas.data

              var marketing_name = document.getElementById('item-name');
              marketing_name.innerHTML = datas.marketing

              var container = document.getElementById('listTbl');
              container.innerHTML= datas.tbldiv;
              
              var period = document.getElementById('periode');
              period.innerHTML = datas.periode


              var element = document.getElementById('tbl-body-sales-report');
              element.style.display = 'block';

              var x = document.getElementById(`div-down`);
              x.style.display = "none"

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
          url: "{{url('/')}}"+"/stock/getReport/download",
          beforeSend: $.LoadingOverlay("show"),
          afterSend:$.LoadingOverlay("hide"),
          data: { "_token": "{{ csrf_token() }}", "startDate":startTemp,"endDate":endTemp,"listUser":listTemp},
          success: function (datas) {
            if(datas=="KOSONG"){
              AlertWarningWithMsg("DATA NOT FOUND")
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