@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Transaction</h1>
@stop

@section('content')
    <div class="card">
      <div class="card-header">
        <h5 style="font-weight: 600">Transaction List By Doctor</h5>
      </div>
      <div class="d-flex">
        {{-- <input type="text" class="form-control" name="daterange" id="daterange" placeholder="Range Date"> --}}
        <div style="width: 50%">
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
        <div style="width: 50%; text-align:end">
          <span>Status: </span>
          <select name="status-select" id="status-select" class="form-select form-select-lg mb-3">
            <option value="all">All</option>
            <option value="0">Submited</option>
            <option value="1">Packing</option>
            <option value="2">Sent</option>
            <option value="3">Paid</option>
            <option value="4">Canceled</option>
          </select>
        </div>
      </div>
      
      <div class="card-body">
        <div class="table-responsive">
          <table id="tableList" class="table table-bordered" >
            <thead>
              <tr>
                  <th>Doctor</th>
                  <th>Clinic</th>
                  <th>NoHp</th>
                  <th>Transaction</th>
                  <th>Action</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-header">
        <h5 style="font-weight: 600">Transaction List</h5>
      </div>
      <div class="d-flex">
        {{-- <input type="text" class="form-control" name="daterange" id="daterange" placeholder="Range Date"> --}}
        <div style="width: 50%">
          <div id="reportrangeTransaction" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; display: flex; align-items: center; justify-content: space-between; width: 100%">
            <div>
                <i class="fa fa-calendar"></i>&nbsp;
                <span id="date_input"></span>
            </div>
            <div>
                <i class="fa fa-caret-down"></i>
            </div>
          </div>
        </div>
        <div style="width: 50%; text-align:end">
          <span>Status: </span>
          <select name="status-select-transaction" id="status-select-transaction" class="form-select form-select-lg mb-3">
            <option value="all">All</option>
            <option value="0">Submited</option>
            <option value="1">Packing</option>
            <option value="2">Sent</option>
            <option value="3">Paid</option>
            <option value="4">Canceled</option>
          </select>
        </div>
      </div>
      
      <div class="card-body">
        <div class="table-responsive">
          <table id="tableListTransaction" class="table table-bordered" >
            <thead>
              <tr>
                  <th>PO Number</th>
                  <th>PO Date</th>
                  <th>Doctor</th>
                  <th>Clinic</th>
                  <th>Payment Due Date</th>
                  <th>Marketing</th>
                  <th>Status</th>
                  <th>Action</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>

@stop

@push('js')
<script>
  dokter = @json($data);
  user = @json($user);
  console.log(dokter, 'current_page')
  console.log({user}, 'user')
  var dataTable = $("#tableList").DataTable({
            "ordering": true,
            "destroy": true,
            //to turn off pagination
            paging: true,
            responsive: true,
            // "bFilter": true,
            //turn off info current page data index
            // "bInfo": false,
            // pagingType: 'full_numbers',
    });

    var dataTable2 = $("#tableListTransaction").DataTable({
            "ordering": true,
            "destroy": true,
            //to turn off pagination
            paging: true,
            responsive: true,
            // "bFilter": true,
            //turn off info current page data index
            // "bInfo": false,
            // pagingType: 'full_numbers',
    });

  window.onload = function() {
    // getAllData()
    cb(start, end)
    cb2(startTransaction, endTransaction)
  };
    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        $(document).trigger('myCustomEvent');
    }

    function cb2(start, end) {
      $('#reportrangeTransaction span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
      $(document).trigger('myCustomEvent2');
    }

    var startTransaction = moment().subtract(6, 'days');
    var endTransaction = moment();
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

    $('#reportrangeTransaction').daterangepicker({
        startDate: startTransaction,
        endDate: endTransaction,
        ranges: {
          'Today': [moment(), moment()],
          'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days': [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month': [moment().startOf('month'), moment().endOf('month')],
          'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb2);

    $('#status-select').on('change', function (e) { 
      $(document).trigger('myCustomEvent');
    })

    $('#status-select-transaction').on('change', function (e) { 
      $(document).trigger('myCustomEvent2');
    })

    // console.log()
    $(document).on('myCustomEvent', function (e) { 
      e.preventDefault();
      var spanText = $('#reportrange span').text();
      var dateArray = spanText.split(' - '); // Split text by hyphen
      console.log(dateArray, "date array")
      var startDate = formatDate(dateArray[0]);

      // Format end date
      var endDate = formatDate(dateArray[1]);
      var selectStatus = $('#status-select').val();
      console.log(selectStatus, "select status")
      if(selectStatus != "all") {
        if(selectStatus == 3) {
          selectStatus = [3, 5]
        } else {
          selectStatus = [selectStatus]
        }
      }
      
      startTemp = startDate
      endTemp = endDate
        $.ajax({
        type: "POST",
        url: "{{url('/')}}"+"/getAllPO",
        beforeSend: $.LoadingOverlay("show"),
        afterSend:$.LoadingOverlay("hide"),
        data: { "_token": "{{ csrf_token() }}", "startDate": startDate, "endDate": endDate, "status": selectStatus },
        success: function (data) {
          console.log({data}, "dataaa1")
          dataTable.clear();
          dataTable.draw();
          no = 0
          $.each(data,function(i, item){
            no++
            stat = "Active"
            if(item['status']==0){
              stat = "InActive"
            }

            const urlDetail = "detailPO/" + item["id"]
            // alert(urlDetail)
            // console.log("detailPO/" + item["id"], "url")
            let detailButton = ``
            detailButton = `<a class="btn btn-info" href="{{url('${urlDetail}')}}">Detail</a>`
            

            dataTable.row.add([
                item['name'],
                item['clinic'],
                item['no_hp'],
                item['total_transaction'],
                detailButton,
            ])
            dataTable.draw();
          })
          
          $('#toggle-demo').bootstrapToggle();
          
        },
        error: function (result, status, err) {
          console.log(err)
        }
      });
    })

    $(document).on('myCustomEvent2', function (e) { 
      e.preventDefault();
      var spanText = $('#reportrangeTransaction span').text();
      var dateArray = spanText.split(' - '); // Split text by hyphen
      // console.log(dateArray, "date array")
      var startDate = formatDate(dateArray[0]);

      // Format end date
      var endDate = formatDate(dateArray[1]);
      var selectStatus = $('#status-select-transaction').val();
      console.log(selectStatus, "select status")
      if(selectStatus != "all") {
        if(selectStatus == 3) {
          selectStatus = [3, 5]
        } else {
          selectStatus = [selectStatus]
        }
      }

      startTemp = startDate
      endTemp = endDate
        $.ajax({
        type: "POST",
        url: "{{url('/')}}"+"/getAllTransaction",
        beforeSend: $.LoadingOverlay("show"),
        afterSend:$.LoadingOverlay("hide"),
        data: { "_token": "{{ csrf_token() }}", "startDate": startDate, "endDate": endDate, "status": selectStatus },
        success: function (data) {
          console.log({data}, "dataaa2")
          dataTable2.clear();
          dataTable2.draw();
          no = 0
          $.each(data,function(i, item){
            // no++
            // stat = "Active"
            // if(item['status']==0){
            //   stat = "InActive"
            // }

            const urlDetail = "detailTransaction/" + item["id"]
            // alert(urlDetail)
            // console.log("detailPO/" + item["id"], "url")
            let htmlStatus = ``
            switch (item['status']) {
              case 0:
                htmlStatus = `<span class="badge bg-primary">SUBMITED</span>`
                break;
              case 1:
                htmlStatus = `<span class="badge bg-waring">PURCHASE</span>`
                break;
              case 2:
                htmlStatus = `<span class="badge bg-info">SENT</span>`
                break;
              case 3:
                htmlStatus = `<span class="badge bg-success">PAID (completed)</span>`
                break;
              case 4:
                htmlStatus = `<span class="badge bg-danger">CANCELED</span>`
                break;
              case 5:
                htmlStatus = `<span class="badge bg-success">PAID</span>`
                if(item['total_paid']) {
                  htmlStatus = `<span class="badge bg-success">PAID (completed)</span>`
                }
                break;
              default:
                break;
            }

            let detailButton = ``
            detailButton = `<a class="btn btn-info" href="{{url('${urlDetail}')}}">Detail</a>`

            dataTable2.row.add([
                item['po_id'],
                item['created_at'],
                item['doctor_name'],
                item['clinic'],
                item['due_date'],
                item['user_name'],
                htmlStatus,
                detailButton
            ])
            dataTable2.draw();
          })
          
          $('#toggle-demo').bootstrapToggle();
          
        },
        error: function (result, status, err) {
          console.log(err)
        }
      });
    })

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

    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('preview');
            output.src = reader.result;
            output.style.display = 'block'; // Show the image preview
        }
        reader.readAsDataURL(event.target.files[0]);
    }

    function previewImageUpdate(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('preview_update');
            output.src = reader.result;
            output.style.display = 'block'; // Show the image preview
        }
        reader.readAsDataURL(event.target.files[0]);
    }


    $('#tableList').on('search.dt', function () {
      var value = $('.dataTables_filter input').val();
      // console.log(value); // <-- the value
    })

    $('#tableListTransaction').on('search.dt', function () {
      var value = $('.dataTables_filter input').val();
      // console.log(value); // <-- the value
    })

    function getAllData(){
      $.ajax({
      type: "POST",
      url: "{{url('/')}}"+"/getAllPO",
      beforeSend: $.LoadingOverlay("show"),
      afterSend:$.LoadingOverlay("hide"),
      data: { "_token": "{{ csrf_token() }}"},
      success: function (data) {
        console.log({data}, "dataaa")
        dataTable.clear();
        dataTable.draw();
        no = 0
        $.each(data,function(i, item){
          no++
          stat = "Active"
          if(item['status']==0){
            stat = "InActive"
          }

          const urlDetail = "detailPO/" + item["id"]
          // alert(urlDetail)
          // console.log("detailPO/" + item["id"], "url")
          dataTable.row.add([
              item['name'],
              item['clinic'],
              item['no_hp'],
              item['total_transaction'],
              `<a class="btn btn-info" href="{{url('${urlDetail}')}}">Detail</a>`
          ])
          dataTable.draw();
        })
        
        $('#toggle-demo').bootstrapToggle();
        
      },
      error: function (result, status, err) {
        console.log(err)
      }
    });
    }

</script>
    
@endpush