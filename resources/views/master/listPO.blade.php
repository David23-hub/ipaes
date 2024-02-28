@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Transaction</h1>
@stop

@section('content')
    <div class="card">
      <div class="card-header">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modaladd">
          Transaction List
        </button>
      </div>
      <div class="card-body">
        <table id="tableList" class="table table-bordered" >
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

@stop

@push('js')
<script>
  window.onload = function() {
    getAllData()
  };

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

    var dataTable = $("#tableList").DataTable({
            "ordering": true,
            "destroy": true,
            //to turn off pagination
            // paging: false,
            // "bFilter": true,
            //turn off info current page data index
            // "bInfo": false,
            // pagingType: 'full_numbers',
        });

    function getAllData(){
      $.ajax({
      type: "POST",
      url: "{{url('/')}}"+"/getCart",
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
              item['po_id'],
              item['created_at'],
              item['doctor_name'],
              item['clinic'],
              item['due_date'],
              item['created_by'],
              item['management_order'],
              `<a class="btn btn-info" href="{{url('${urlDetail}')}}">Detail</a>`
          ])
            dataTable.draw();
        }
        )

        
        $('#toggle-demo').bootstrapToggle();
        
      },
      error: function (result, status, err) {
        console.log(err)
      }
    });
    }

    function getItem(id){
      $.ajax({
        type: "POST",
        url: "{{url('/')}}"+"/detailPO",
        data: { "_token": "{{ csrf_token() }}","id":id},
        beforeSend: $.LoadingOverlay("show"),
        afterSend:$.LoadingOverlay("hide"),
        success: function (data) {
          console.log({data})
        },
        error: function (result, status, err) {
          alert(err)
        }
      });
    };

    function deleteItem(id){
      $.ajax({
        type: "POST",
        url: "{{url('/')}}"+"/deleteItem",
        data: { "_token": "{{ csrf_token() }}", "id":id},
        beforeSend: $.LoadingOverlay("show"),
        afterSend:$.LoadingOverlay("hide"),
        success: function (data) {
          console.log(data)
          if(data=="sukses"){
            getAllData()
            AlertSuccess()
          }else{
            AlertError()
          }
        },
        error: function (result, status, err) {
          alert(err)
          AlertError()
        },
      });
    };
    

</script>
    
@endpush