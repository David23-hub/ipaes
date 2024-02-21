@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">List Dokter</h1>
@stop

@section('content')
    <div class="card">
      <div class="card-header">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modaladd">
          ADD Dokter
        </button>
      </div>
      <div class="card-body">
        <table id="tableList" class="table table-striped table-bordered table-hover" >
          <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Clinic</th>
                <th>Phone Number</th>
                <th>Status</th>
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
            <label for="alamat_add">Address</label>
            <input type="alamat_add" class="form-control" id="alamat_add"  placeholder="Masukkan Alamat">
          </div>
          <div class="form-group">
            <label for="clinic_add">Clinic</label>
            <input type="clinic_add" class="form-control" id="clinic_add"  placeholder="Masukkan Klinik">
          </div>
          <div class="form-group">
            <label for="no_hp_add">Phone Number</label>
            <input type="no_hp_add" class="form-control" id="no_hp_add"  placeholder="Masukkan No Handphone" onkeyup="this.value = this.value.replace(/[^0-9]/g, '');">
          </div>
          <div class="form-group">
            <label for="dob_add">Date of Birth</label>
            <input type="date" class="form-control" id="dob_add"  placeholder="Masukkan Tanggal Lahir">
          </div>
          <div class="form-group">
            <label for="billing_no_hp_add">Billing Phone Number</label>
            <input type="billing_no_hp_add" class="form-control" id="billing_no_hp_add"  placeholder="Masukkan No Handphone Billing" onkeyup="this.value = this.value.replace(/[^0-9]/g, '');">
          </div>
          <div class="form-group">
            <label for="status_add">Status</label>
            <div id="dropadd" name="dropadd" class="form-group">
              <select class="form-select form-control" id="status_add">
                <option value="0">InActive</option>
                <option value="1">Active</option>
              </select> 
            </div>
          </div>
          <div class="form-group">
            <label for="information_add">Information</label>
            <textarea type="information_add" class="form-control" id="information_add" rows="3"  placeholder="Masukkan Informasi"></textarea>
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
            <label for="alamat_update">Address</label>
            <input type="alamat_update" class="form-control" id="alamat_update"  placeholder="Masukkan Alamat">
          </div>
          <div class="form-group">
            <label for="clinic_update">Clinic</label>
            <input type="clinic_update" class="form-control" id="clinic_update"  placeholder="Masukkan Klinik">
          </div>
          <div class="form-group">
            <label for="no_hp_update">Phone Number</label>
            <input type="no_hp_update" class="form-control" id="no_hp_update"  placeholder="Masukkan No Handphone" onkeyup="this.value = this.value.replace(/[^0-9]/g, '');">
          </div>
          <div class="form-group">
            <label for="dob_update">Date of Birth</label>
            <input type="date" class="form-control" id="dob_update"  placeholder="Masukkan Tanggal Lahir">
          </div>
          <div class="form-group">
            <label for="billing_no_hp_update">Billing Phone Number</label>
            <input type="billing_no_hp_update" class="form-control" id="billing_no_hp_update"  placeholder="Masukkan No Handphone Billing" onkeyup="this.value = this.value.replace(/[^0-9]/g, '');">
          </div>
          <div class="form-group">
            <label for="status_update">Status</label>
            <div id="dropupdate" name="dropupdate" class="form-group">
              <select class="form-select form-control" id="status_update">
                <option value="0">InActive</option>
                <option value="1">Active</option>
              </select> 
            </div>
          </div>
          <div class="form-group">
            <label for="information_update">Information</label>
            <textarea type="information_update" class="form-control" id="information_update"  placeholder="Masukkan Informasi" rows="3"></textarea>
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
            <label for="alamat_detail">Address</label>
            <input type="alamat_detail" class="form-control" id="alamat_detail"  placeholder="Masukkan Alamat" disabled>
          </div>
          <div class="form-group">
            <label for="clinic_detail">Clinic</label>
            <input type="clinic_detail" class="form-control" id="clinic_detail"  placeholder="Masukkan Klinik" disabled>
          </div>
          <div class="form-group">
            <label for="no_hp_detail">Phone Number</label>
            <input type="no_hp_detail" class="form-control" id="no_hp_detail"  placeholder="Masukkan No Handphone" onkeyup="this.value = this.value.replace(/[^0-9]/g, '');" disabled>
          </div>
          <div class="form-group">
            <label for="dob_detail">Date of Birth</label>
            <input type="date" class="form-control" id="dob_detail"  placeholder="Masukkan Tanggal Lahir" disabled>
          </div>
          <div class="form-group">
            <label for="billing_no_hp_detail">Billing Phone Number</label>
            <input type="billing_no_hp_detail" class="form-control" id="billing_no_hp_detail"  placeholder="Masukkan No Handphone Billing" onkeyup="this.value = this.value.replace(/[^0-9]/g, '');" disabled>
          </div>
          <div class="form-group">
            <label for="status_detail">Status</label>
            <input type="status_detail" class="form-control" id="status_detail"  placeholder="Masukkan Status" disabled>
          </div>
          <div class="form-group">
            <label for="information_detail">Information</label>
            <textarea type="information_detail" class="form-control" id="information_detail"  placeholder="Masukkan Informasi" rows="3" disabled></textarea>
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
    getAllData();
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


    // Event listener for modal shown event
    $('#modaladd').on('shown.bs.modal', function () {
      resetModalInput();
    });

    $('#modaladd').on('hidden.bs.modal', function () {
      resetModalInput();
    });

    function resetModalInput() {
      document.getElementById('nama_add').value = '';
      document.getElementById('status_add').value = '0';
    }

    function getAllData(){
      $.ajax({
      type: "POST",
      url: "{{url('/')}}"+"/getDokters",
      beforeSend: $.LoadingOverlay("show"),
      afterSend:$.LoadingOverlay("hide"),
      data: { "_token": "{{ csrf_token() }}"},
      success: function (data) {
        dataTable.clear();
        dataTable.draw();
        no = 0
        $.each(data,function(i, item){
          no++
          stat = "Active"
          if(item['status']==0){
            stat = "InActive"
          }
          
          dataTable.row.add([
              no,
              item['name'],
              item['clinic'],
              item['no_hp'],
              stat,
              `<button class="btn btn-info" onclick="getItem(`+item['id']+`)">Detail</button>
              <button class="btn btn-primary" onclick="getItemUpdate(`+item['id']+`)">Update</button>
              <button class="btn btn-danger" onclick="deleteItem(`+item['id']+`)">Delete</button>`,
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

    $('#add_btn').on('click', function(e) {
      name = $("#nama_add").val()
      status = $("#status_add").val()
      address = $("#alamat_add").val()
      clinic = $("#clinic_add").val()
      no_hp = $("#no_hp_add").val()
      information = $("#information_add").val()
      dob = $("#dob_add").val()
      billing_no_hp = $("#billing_no_hp_add").val()
      
      $.ajax({
        type: "POST",
        url: "{{url('/')}}"+"/addDokter",
        data: { "_token": "{{ csrf_token() }}","name":name, "status":status, "address":address, "clinic":clinic, "no_hp":no_hp, "dob":dob, "billing_no_hp":billing_no_hp,"information":information},
        beforeSend: $.LoadingOverlay("show"),
        afterSend:$.LoadingOverlay("hide"),
        success: function (data) {
          if(data=="sukses"){
            getAllData()
            $('#modaladd').modal("hide")
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
        url: "{{url('/')}}"+"/getDokter",
        data: { "_token": "{{ csrf_token() }}","id":id},
        beforeSend: $.LoadingOverlay("show"),
        afterSend:$.LoadingOverlay("hide"),
        success: function (data) {
          $('#id_detail').val(data.id)
          $('#nama_detail').val(data.name)
          if (data.status==0){
            $('#status_detail').val("InActive")
          }else if (data.status==1){
            $('#status_detail').val("Active")
          }
          $('#alamat_detail').val(data.address)
          $('#clinic_detail').val(data.clinic)
          $('#no_hp_detail').val(data.no_hp)
          $('#dob_detail').val(data.dob)
          $('#billing_no_hp_detail').val(data.billing_no_hp)
          $('#information_detail').val(data.information)


          console.log("view"+data.created_at)
          $('#created_by_detail').val(FormatTimeStamp(data.created_by,data.created_at))
          $('#updated_by_detail').val(FormatTimeStamp(data.updated_by,data.updated_at))
          $('#modalDetail').modal("show")
        },
        error: function (result, status, err) {
          alert(err)
        }
      });
    };

    function getItemUpdate(id){
      $.ajax({
        type: "POST",
        url: "{{url('/')}}"+"/getDokter",
        beforeSend: $.LoadingOverlay("show"),
        afterSend:$.LoadingOverlay("hide"),
        data: { "_token": "{{ csrf_token() }}","id":id},
        success: function (data) {
          $('#id_update').val(data.id)
          $('#nama_update').val(data.name)
          $('#status_update').val(data.status)
          
          $('#alamat_update').val(data.address)
          $('#clinic_update').val(data.clinic)
          $('#no_hp_update').val(data.no_hp)
          $('#dob_update').val(data.dob)
          $('#billing_no_hp_update').val(data.billing_no_hp)
          $('#information_update').val(data.information)

          $('#modalUpdate').modal("show")
        },
        error: function (result, status, err) {
        }
      });
    };

    $('#update_btn').on('click', function(e) {
      name = $("#nama_update").val()
      status = $("#status_update").val()
      id = $("#id_update").val()

      address = $("#alamat_update").val()
      clinic = $("#clinic_update").val()
      no_hp = $("#no_hp_update").val()
      information = $("#information_update").val()
      dob = $("#dob_update").val()
      billing_no_hp = $("#billing_no_hp_update").val()
      $.ajax({
        type: "POST",
        url: "{{url('/')}}"+"/updateDokter",
        data: { "_token": "{{ csrf_token() }}","name":name, "status":status, "id":id, "address":address, "clinic":clinic, "no_hp":no_hp, "dob":dob, "billing_no_hp":billing_no_hp,"information":information},
        beforeSend: $.LoadingOverlay("show"),
        afterSend:$.LoadingOverlay("hide"),
        success: function (data) {
          if(data=="sukses"){
            getAllData()
            $('#modalUpdate').modal("hide")
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
        url: "{{url('/')}}"+"/deleteDokter",
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