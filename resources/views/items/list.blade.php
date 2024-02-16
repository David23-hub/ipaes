@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">List Item</h1>
@stop

@section('content')
    <div class="card">
      <div class="card-header">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modaladd">
          ADD ITEM
        </button>
      </div>
      <div class="card-body">
        <table id="tableList" class="table table-striped table-bordered table-hover" width="100%">
          <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Status</th>
                <th>STATUS</th>
                <th>Action</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>

<!-- Modal Add-->
<div class="modal fade" id="modaladd" tabindex="-1" role="dialog" aria-labelledby="modaladdTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formadd" role="form">
        <div class="modal-body">
          <div class="form-group">
            <label for="nama_add">Nama</label>
            <input type="nama_add" class="form-control" id="nama_add"  placeholder="Masukkan Nama">
          </div>
          <div class="form-group">
            <label for="status_add">Status</label>
            <div id="dropadd" name="dropadd" class="form-group">
              <select class="form-select form-control" id="status_add">
                <option value="0">Belum Di Packing</option>
                <option value="1">Sudah Di Packing</option>
              </select> 
            </div>
          </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="add_btn" class="btn btn-primary">Save changes</button>
      </div>
    </form>
    </div>
  </div>
</div>

<!-- Modal Update-->
<div class="modal fade" id="modalUpdate" tabindex="-1" role="dialog" aria-labelledby="modalUpdateTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Update Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formUpdate" role="form">
        <div class="modal-body">
            <input type="hidden" class="form-control" id="id_update">
          <div class="form-group">
            <label for="nama_update">Nama</label>
            <input type="nama_update" class="form-control" id="nama_update"  placeholder="Masukkan Nama">
          </div>
          <div class="form-group">
            <label for="status_update">Status</label>
            <div id="dropupdate" name="dropupdate" class="form-group">
              <select class="form-select form-control" id="status_update">
                <option value="0">Belum Di Packing</option>
                <option value="1">Sudah Di Packing</option>
              </select> 
            </div>
          </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="update_btn" class="btn btn-primary">Save changes</button>
      </div>
    </form>
    </div>
  </div>
</div>

<!-- Modal Update2-->
<div class="modal fade" id="modalUpdate2" tabindex="-1" role="dialog" aria-labelledby="modalUpdateTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Update Form2</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formUpdate" role="form">
        <div class="modal-body">
            <input type="hidden" class="form-control" id="id_update">
          <div class="form-group">
            <label for="nama_update">Nama</label>
            <input type="nama_update" class="form-control" id="nama_update"  placeholder="Masukkan Nama">
          </div>
          <div class="form-group">
            <label for="status_update">Status</label>
            <input id="toggle-demo" type="checkbox" checked data-toggle="toggle" data-on="Ready" data-off="Not Ready" data-onstyle="success" data-offstyle="danger">
          </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="update_btn" class="btn btn-primary">Save changes</button>
      </div>
    </form>
    </div>
  </div>
</div>

<!-- Modal Detail-->
<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="modalDetailTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Detail Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="nama_detail">Nama</label>
            <input type="nama_detail" class="form-control" id="nama_detail"  placeholder="Masukkan Nama" disabled>
          </div>
          <div class="form-group">
            <label for="status_detail">Status</label>
            <input type="status_detail" class="form-control" id="status_detail"  placeholder="Masukkan Status" disabled>
          </div>
          <div class="form-group">
            <label for="created_by_detail">Dibuat Oleh</label>
            <input type="created_by_detail" class="form-control" id="created_by_detail"  placeholder="Masukkan Status" disabled>
          </div>
          <div class="form-group">
            <label for="updated_by_detail">Diubah Oleh</label>
            <input type="updated_by_detail" class="form-control" id="updated_by_detail"  placeholder="Masukkan Status" disabled>
          </div>
        </div>

    </div>
  </div>
</div>
@stop

@push('js')
<script>
  window.onload = function() {
    getAllData()
  };

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
      url: "{{url('/')}}"+"/getItems",
    //   crossDomain: true,
      beforeSend: $.LoadingOverlay("show"),
      data: { "_token": "{{ csrf_token() }}"},
      success: function (data) {
        dataTable.clear();
        no = 0
        $.each(data,function(i, item){
          no++
          stat = "Sudah Di Packing"
          if(item['status']==0){
            stat = "Belum Di Packing"
          }
          btn = '<input id="toggle-demo" type="checkbox" checked data-toggle="toggle" data-on="Ready" data-off="Not Ready" data-onstyle="success" data-offstyle="danger">'
          
          dataTable.row.add([
              no,
              item['name'],
              stat,
              btn
              ,
              `<button class="btn btn-info" onclick="getItem(`+item['id']+`)">Detail</button>
              <button class="btn btn-primary" onclick="getItemUpdate(`+item['id']+`)">Update</button>
              <button class="btn btn-primary" onclick="getItemUpdate2(`+item['id']+`)">Update2</button>
              <button class="btn btn-danger" onclick="deleteItem(`+item['id']+`)">Delete</button>`,
          ])
            dataTable.draw();
        }
        )
        
        $('#toggle-demo').bootstrapToggle();
        

        $.LoadingOverlay("hide")
      },
      error: function (result, status, err) {
      }
    });
    }

    $('#add_btn').on('click', function(e) {
      name = $("#nama_add").val()
      status = $("#status_add").val()
      $.ajax({
        type: "POST",
        url: "{{url('/')}}"+"/addItem",
        data: { "_token": "{{ csrf_token() }}","name":name, "status":status},
        beforeSend: $.LoadingOverlay("show"),
        success: function (data) {
          console.log(data)
          if(data=="sukses"){
            getAllData()
            $('#modaladd').modal("hide")
            $.LoadingOverlay("hide")
            AlertSuccess()
          }else{
            AlertError()
          }
        },
        error: function (result, status, err) {
          $.LoadingOverlay("hide")
          AlertError()
        },
      });
    });

    function getItem(id){
      $.ajax({
        type: "POST",
        url: "{{url('/')}}"+"/getItem",
        data: { "_token": "{{ csrf_token() }}","id":id},
        beforeSend: $.LoadingOverlay("show"),
        success: function (data) {
          $('#id_detail').val(data.id)
          $('#nama_detail').val(data.name)
          if (data.status==0){
            $('#status_detail').val("Belum Di Packing")
          }else if (data.status==1){
            $('#status_detail').val("Sudah Di Packing")
          }
          $('#created_by_detail').val(FormatTimeStamp(data.created_by,data.created_at))
          $('#updated_by_detail').val(FormatTimeStamp(data.updated_by,data.updated_at))
          $('#modalDetail').modal("show")
          $.LoadingOverlay("hide")
        },
        error: function (result, status, err) {
          alert(err)
        }
      });
    };

    function getItemUpdate(id){
      $.ajax({
        type: "POST",
        url: "{{url('/')}}"+"/getItem",
        beforeSend: $.LoadingOverlay("show"),
        data: { "_token": "{{ csrf_token() }}","id":id},
        success: function (data) {
          $('#id_update').val(data.id)
          $('#nama_update').val(data.name)
          $('#status_update').val(data.status)
          $('#modalUpdate').modal("show")
          $.LoadingOverlay("hide")
        },
        error: function (result, status, err) {
        }
      });
    };

    function getItemUpdate2(id){
      $.ajax({
        type: "POST",
        url: "{{url('/')}}"+"/getItem",
        beforeSend: $.LoadingOverlay("show"),
        data: { "_token": "{{ csrf_token() }}","id":id},
        success: function (data) {
          $('#id_update').val(data.id)
          $('#nama_update').val(data.name)
          $('#status_update').val(data.status)
          $('#modalUpdate2').modal("show")
          $.LoadingOverlay("hide")
        },
        error: function (result, status, err) {
        }
      });
    };

    $('#update_btn').on('click', function(e) {
      name = $("#nama_update").val()
      status = $("#status_update").val()
      id = $("#id_update").val()
      $.ajax({
        type: "POST",
        url: "{{url('/')}}"+"/updateItem",
        data: { "_token": "{{ csrf_token() }}","name":name, "status":status, "id":id},
        beforeSend: $.LoadingOverlay("show"),
        success: function (data) {
          if(data=="sukses"){
            getAllData()
            $('#modalUpdate').modal("hide")
            $.LoadingOverlay("hide")
            AlertSuccess()
          }else{
            AlertError()
          }
          
        },
        error: function (result, status, err) {
          alert(err)
          $.LoadingOverlay("hide")
        },
      });
    });

    function deleteItem(id){
      $.ajax({
        type: "POST",
        url: "{{url('/')}}"+"/deleteItem",
        data: { "_token": "{{ csrf_token() }}", "id":id},
        beforeSend: $.LoadingOverlay("show"),
        success: function (data) {
          if(data=="sukses"){
            getAllData()
            $.LoadingOverlay("hide")
          }
        },
        error: function (result, status, err) {
          alert(err)
          $.LoadingOverlay("hide")
        },
      });
    };
    

</script>
    
@endpush