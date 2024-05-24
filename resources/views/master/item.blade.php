@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">List Product</h1>
@stop

@section('content')
    <div class="card">
      <div class="card-header">
          @if (auth()->user()->role != 'manager')
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modaladd">
          ADD Product
        </button>
        @endif
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="tableList" class="table table-striped table-bordered table-hover" >
            <thead>
              <tr>
                <th>No</th>
                  <th>Image</th>
                  <th>Nama</th>
                  <th>Stock</th>
                  <th>Stock Minimum</coth>
                  <th>Price</th>
                  <th>Status</th>
                  <th>Action</th>
              </tr>
            </thead>
          </table>

        </div>
        
      </div>
    </div>

<!-- Modal Add-->
<div class="modal fade" id="modaladd" tabindex="-1" role="dialog" aria-labelledby="modaladdTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formadd" role="form" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-group" >
            <img id="preview" style="width: 200px; height: 200px; border: 1px solid #ccc; background-color: #f0f0f0;">
          </div>
          <div class="form-group" >
            <label for="image_add">Image</label>
            <input type="file" name="image_add" accept="image/*" id="image_add"  placeholder="Masukkan Image" onchange="previewImage(event)">
          </div>
          <div class="form-group">
            <label for="nama_add">Nama *</label>
            <input type="nama_add" class="form-control" id="nama_add"  placeholder="Masukkan Nama" >
          </div>
          <div class="form-group">
            <label for="unit_add">Unit Product</label>
            <div id="dropadd" name="dropadd" class="form-group">
              <select class="form-select form-control" id="unit_add">
                  <option value="Box" selected>Box</option>
                  <option value="Vial">Vial</option>
              </select> 
            </div>
          </div>
          <div class="form-group">
            <label for="qty_add">Stock *</label>
            <input type="qty_add" class="form-control" id="qty_add"  placeholder="Masukkan Stock (Numeric Only)" oninput="addDotPrice(this);">
          </div>
          <div class="form-group">
            <label for="qty_min_add">Stock Min (Untuk Peringatan di Dashboard) *</label>
            <input type="qty_min_add" class="form-control" id="qty_min_add"  placeholder="Masukkan Stock (Numeric Only)" oninput="addDotPrice(this);">
          </div>
          <div class="form-group">
            <label for="price_add">Price *</label>
            <div class="input-group mb-2">
              <div class="input-group-prepend">
                <div class="input-group-text">Rp</div>
              </div>
              <input type="price_add" class="form-control" id="price_add"  placeholder="Masukkan Harga Product (ex: 100000)"  oninput="addDotPrice(this);">
            </div>
          </div>
          <div class="form-group">
            <label for="presentation_add">Presentation *</label>
            <div class="input-group mb-2">
              <input type="presentation_add" class="form-control" id="presentation_add"  placeholder="Masukkan Presentasi" >
            </div>
          </div>
          <div class="form-group">
            <label for="commision_rate_add">Commission Rate *</label>
            <div class="input-group mb-2">
              <input type="commision_rate_add" class="form-control" id="commision_rate_add"  placeholder="Masukkan Rate Komisi (ex: 2.5)" onkeyup="this.value = this.value.replace(/[^0-9.]/g, '');">
              <div class="input-group-prepend">
                <div class="input-group-text">%</div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="mini_desc_add">Mini Description *</label>
            <textarea type="mini_desc_add" class="form-control" id="mini_desc_add" rows="1"  placeholder="Masukkan Informasi Mini"></textarea>
          </div>
          <div class="form-group">
            <label for="desc_add">Description *</label>
            <textarea type="desc_add" class="form-control" id="desc_add" rows="4"  placeholder="Masukkan Informasi"></textarea>
          </div>
          <div class="form-group">
            <div id="dropadd" name="dropadd" class="form-group">
              <div style="text-align: right">
                <input type="checkbox" id="status_add" name="status_add">
                <label for="status_add"> Active</label><br>
              </div>
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
            <div class="form-group" >
              <img id="preview_update" style="width: 200px; height: 200px; border: 1px solid #ccc; background-color: #f0f0f0; ">
            </div>
            <div class="form-group" >
              <label for="image_update">Image</label>
              <input type="file" name="image_update" accept="image/*" id="image_update"  placeholder="Masukkan Image" onchange="previewImageUpdate(event)">
            </div>
            <div class="form-group">
              <label for="name_update">Nama *</label>
              <input type="name_update" class="form-control" id="name_update"  placeholder="Masukkan Nama">
            </div>
            <div class="form-group">
              <label for="unit_update">Unit Product</label>
              <div id="dropunitupdate" name="dropunitupdate" class="form-group">
                <select class="form-select form-control" id="unit_update">
                    <option value="Box">Box</option>
                    <option value="Vial">Vial</option>
                </select> 
              </div>
            </div>
            <div class="form-group" hidden>
              <label for="qty_update">Stock *</label>
              <input type="qty_update" class="form-control" id="qty_update"  placeholder="Masukkan Stock (Numeric Only)" oninput="addDotPrice(this);" disabled>
            </div>
            <div class="form-group">
              <label for="qty_min_update">Stock Min (Untuk Peringatan di Dashboard) *</label>
              <input type="qty_min_update" class="form-control" id="qty_min_update"  placeholder="Masukkan Stock (Numeric Only)" oninput="addDotPrice(this);">
            </div>
            <div class="form-group">
              <label for="price_update">Price *</label>
              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <div class="input-group-text">Rp</div>
                </div>
                <input type="price_update" class="form-control" id="price_update"  placeholder="Masukkan Harga Product (ex: 100000)" oninput="addDotPrice(this);">
              </div>
            </div>
            <div class="form-group">
              <label for="presentation_update">Presentation *</label>
              <div class="input-group mb-2">
                <input type="presentation_update" class="form-control" id="presentation_update"  placeholder="Masukkan Presentasi" >
              </div>
            </div>
            <div class="form-group">
              <label for="commision_rate_update">Commission Rate *</label>
              <div class="input-group mb-2">
                <input type="commision_rate_update" class="form-control" id="commision_rate_update"  placeholder="Masukkan Rate Komisi (ex: 2.5)" onkeyup="this.value = this.value.replace(/[^0-9.]/g, '');">
                <div class="input-group-prepend">
                  <div class="input-group-text">%</div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="mini_desc_update">Mini Description *</label>
              <textarea type="mini_desc_update" class="form-control" id="mini_desc_update" rows="1"  placeholder="Masukkan Informasi Mini"></textarea>
            </div>
            <div class="form-group">
              <label for="desc_update">Description *</label>
              <textarea type="desc_update" class="form-control" id="desc_update" rows="4"  placeholder="Masukkan Informasi"></textarea>
            </div>
            <div class="form-group">
              <div id="dropadd" name="dropadd" class="form-group">
                <div style="text-align: right">
                  <input type="checkbox" id="status_update" name="status_update">
                  <label for="status_update"> Active</label><br>
                </div>
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

<!-- Modal Update Stock-->
<div class="modal fade" id="modalUpdateQty" tabindex="-1" role="dialog" aria-labelledby="modalUpdateTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Update Stock Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formUpdate" role="form">
        <div class="modal-body">
            <input type="hidden" class="form-control" id="id_update_stck">
            <div class="form-group">
              
            </div>
            <label for="qty_update_stck">Stock <span id="name_stck_update"></span> *</label>
            <div class="form-group" >
              <div class="row">
                <div class="col-4">
                    <div id="dropunitupdate" name="dropunitupdate" class="form-group">
                      <select class="form-select form-control" id="stock_update">
                          <option value="in">In</option>
                          <option value="out">Out</option>
                      </select> 
                  </div>
                </div>
                <div class="col-8">
                  <input type="qty_update_stck" class="form-control" id="qty_update_stck"  placeholder="Masukkan Stock (Numeric Only)" oninput="addDotPrice(this);" >
                </div>
              </div>
                
            </div>
            
            <div class="form-group">
              <label for="desc_update_stck">Description *</label>
              <textarea type="desc_update_stck" class="form-control" id="desc_update_stck" rows="4"  placeholder="Masukkan Informasi"></textarea>
            </div>
            
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="update_btn_stck" class="btn btn-primary">Save changes</button>
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
            <label for="unit_detail">Unit Product</label>
            <input type="unit_detail" class="form-control" id="unit_detail"  placeholder="Masukkan Status" disabled>
          </div>
          <div class="form-group">
            <label for="qty_detail">Stock</label>
            <input type="qty_detail" class="form-control" id="qty_detail"  placeholder="Masukkan Stock" onkeyup="this.value = this.value.replace(/[^0-9]/g, '');" disabled>
          </div>
          <div class="form-group">
            <label for="qty_min_detail">Stock Min (Untuk Peringatan di Dashboard) *</label>
            <input type="qty_min_detail" class="form-control" id="qty_min_detail"  placeholder="Masukkan Stock (Numeric Only)" oninput="addDotPrice(this);" disabled>
          </div>
          <div class="form-group">
            <label for="price_detail">Price</label>
            <div class="input-group mb-2">
              <div class="input-group-prepend">
                <div class="input-group-text">Rp</div>
              </div>
              <input type="price_detail" class="form-control" id="price_detail"  placeholder="Masukkan Harga Product" onkeyup="this.value = this.value.replace(/[^0-9]/g, '');" disabled>
            </div>
          </div>
          <div class="form-group">
            <label for="presentation_detail">Presentation</label>
            <div class="input-group mb-2">
              <input type="presentation_detail" class="form-control" id="presentation_detail"  placeholder="Masukkan Presentasi" onkeyup="this.value = this.value.replace(/[^0-9.]/g, '');" disabled>
            </div>
          </div>
          <div class="form-group">
            <label for="commision_rate_detail">Commission Rate</label>
            <div class="input-group mb-2">
              <input type="commision_rate_detail" class="form-control" id="commision_rate_detail"  placeholder="Masukkan Rate Komisi" onkeyup="this.value = this.value.replace(/[^0-9.]/g, '');" disabled>
              <div class="input-group-prepend">
                <div class="input-group-text">%</div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="mini_desc_detail">Mini Description</label>
            <textarea type="mini_desc_detail" class="form-control" id="mini_desc_detail" rows="1"  placeholder="Masukkan Informasi Mini" disabled></textarea>
          </div>
          <div class="form-group">
            <label for="desc_detail">Description</label>
            <textarea type="desc_detail" class="form-control" id="desc_detail" rows="4"  placeholder="Masukkan Informasi" disabled></textarea>
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
  function addDotPrice(input) {
      
    input.value = input.value.replace(/[^0-9]/g, '')
    
    if (input.value > 3) {
          input.value = input.value.replace(/(\d)(?=(\d{3})+$)/g, '$1.');
        }
  }

  $('#status_add').change(function() {
        // If checkbox is checked, set its value to "1"; otherwise, set it to "0"
        if ($(this).is(':checked')) {
            $(this).val('1');
        } else {
            $(this).val('0');
        }
    });
    $('#status_update').change(function() {
        // If checkbox is checked, set its value to "1"; otherwise, set it to "0"
        if ($(this).is(':checked')) {
            $(this).val('1');
        } else {
            $(this).val('0');
        }
    });

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


    // Event listener for modal shown event
    $('#modaladd').on('shown.bs.modal', function () {
      resetModalInput();
    });

    $('#modaladd').on('hidden.bs.modal', function () {
      resetModalInput();
    });

    function resetModalInput() {
      document.getElementById('nama_add').value = '';
      document.getElementById('qty_add').value = '';
      document.getElementById('qty_min_add').value = '';
      document.getElementById('price_add').value = '';
      document.getElementById('presentation_add').value = '';
      document.getElementById('commision_rate_add').value = '';
      document.getElementById('mini_desc_add').value = '';
      document.getElementById('desc_add').value = '';
      document.getElementById('status_add').value = '0';
      document.getElementById('preview').src = '';
    document.getElementById('image_add').value = '';
    }

    function getAllData(){
      $.ajax({
      type: "POST",
      url: "{{url('/')}}"+"/getItems",
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

          path = "images/"+item['img']
          if(item['img']!=""){
            img = `<img style="display:block; margin:auto;" src="{{asset("`+path+`")}}" height="50px" width="50px"/>`
          }else{
            img = `<img style="width: 50px; height: 50px; border: 1px solid #ccc; background-color: #AFACAC; display:block; margin:auto;">`
          }
         
        

          dataTable.row.add([
              no,
              img,
              item['name'],
              item['qty'] +" "+ item['unit'],
              item['qty_min'] +" "+ item['unit'],
              "Rp "+item['price'],
              stat,
              item['btn'],
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
      qty = $("#qty_add").val()
      qty_min = $("#qty_min_add").val()
      // var fileInput = document.getElementById('image_add');
      // img = fileInput.files[0]

      unit = $("#unit_add").val()
      price = $("#price_add").val()
      presentation = $("#presentation_add").val()
      commision_rate = $("#commision_rate_add").val()
      mini_desc = $("#mini_desc_add").val()
      desc = $("#desc_add").val()


      var fileInput = document.getElementById('image_add');

      // Construct FormData object
      var formData = new FormData();
      formData.append('img', fileInput.files[0]); 
      formData.append('_token', '{{ csrf_token() }}');
      formData.append('name', name);
      formData.append('qty', qty);
      formData.append('qty_min', qty_min);
      formData.append('status', status);
      formData.append('unit', unit);
      formData.append('price', price);
      formData.append('presentation', presentation);
      formData.append('commision_rate', commision_rate);
      formData.append('mini_desc', mini_desc);
      formData.append('desc', desc);

      $.ajax({
        type: "POST",
        url: "{{url('/')}}"+"/addItem",
        data:formData,
        processData: false,
        contentType: false,
        beforeSend: $.LoadingOverlay("show"),
        afterSend:$.LoadingOverlay("hide"),
        success: function (data) {
          if(data=="sukses"){
            getAllData()
            $('#modaladd').modal("hide")
            AlertSuccess()
          }else if(data!="gagal"){
            AlertWarningWithMsg(data)
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
        afterSend:$.LoadingOverlay("hide"),
        success: function (data) {
          $('#id_detail').val(data.id)
          $('#nama_detail').val(data.name)
          $('#qty_detail').val(data.qty)
          $('#qty_min_detail').val(data.qty_min)
          if (data.status==0){
            $('#status_detail').val("InActive")
          }else if (data.status==1){
            $('#status_detail').val("Active")
          }

          $("#unit_detail").val(data.unit)
          $("#price_detail").val(data.price)
          $("#presentation_detail").val(data.presentation)
          $("#commision_rate_detail").val(data.commision_rate)
          $("#mini_desc_detail").val(data.mini_desc)
          $("#desc_detail").val(data.desc)

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
        url: "{{url('/')}}"+"/getItem",
        beforeSend: $.LoadingOverlay("show"),
        afterSend:$.LoadingOverlay("hide"),
        data: { "_token": "{{ csrf_token() }}","id":id},
        success: function (data) {

          path = "images/"+data.img

          if(data.img!=""){
            $('#preview_update').attr('src', path);
          }else{
            $('#preview_update').attr('src', "");

          }

          $('#id_update').val(data.id)
          $('#name_update').val(data.name)
          $('#qty_update').val(data.qty)
          $('#qty_min_update').val(data.qty_min)
          // $('#status_update').val(data.status)
          if (data.status==1){
            $('#status_update').prop('checked', true);
            $('#status_update').val("1");
          }else{
            $('#status_update').prop('checked', false);
            $('#status_update').val("0");
          }

          $("#unit_update").val(data.unit)
          $("#price_update").val(data.price)
          $("#presentation_update").val(data.presentation)
          $("#commision_rate_update").val(data.commision_rate)
          $("#mini_desc_update").val(data.mini_desc)
          $("#desc_update").val(data.desc)

          $('#modalUpdate').modal("show")
        },
        error: function (result, status, err) {
        }
      });
    };

    $('#update_btn').on('click', function(e) {
      name = $("#name_update").val()
      status = $("#status_update").val()
      qty = $("#qty_update").val()
      qty_min = $("#qty_min_update").val()
      id = $("#id_update").val()
      
      unit = $("#unit_update").val()
      price = $("#price_update").val()
      presentation = $("#presentation_update").val()
      commision_rate = $("#commision_rate_update").val()
      mini_desc = $("#mini_desc_update").val()
      desc = $("#desc_update").val()
      var fileInput = document.getElementById('image_update');

      var formData = new FormData();
      formData.append('img', fileInput.files[0]); 
      formData.append('_token', '{{ csrf_token() }}');
      formData.append('name', name);
      formData.append('qty', qty);
      formData.append('qty_min', qty_min);
      formData.append('status', status);
      formData.append('unit', unit);
      formData.append('price', price);
      formData.append('presentation', presentation);
      formData.append('commision_rate', commision_rate);
      formData.append('mini_desc', mini_desc);
      formData.append('desc', desc);
      formData.append('id', id);
      
      
      $.ajax({
        type: "POST",
        url: "{{url('/')}}"+"/updateItem",
        data:formData,
        processData: false,
        contentType: false,
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

    function getItemUpdateQty(id){
      $.ajax({
        type: "POST",
        url: "{{url('/')}}"+"/getItem",
        beforeSend: $.LoadingOverlay("show"),
        afterSend:$.LoadingOverlay("hide"),
        data: { "_token": "{{ csrf_token() }}","id":id},
        success: function (data) {

          path = "images/"+data.img

          if(data.img!=""){
            $('#preview_update').attr('src', path);
          }else{
            $('#preview_update').attr('src', "");

          }

          $('#id_update_stck').val(data.id)
          $('#name_stck_update').text(data.name)

          $('#modalUpdateQty').modal("show")
        },
        error: function (result, status, err) {
        }
      });
    };

    $('#update_btn_stck').on('click', function(e) {
      qty = $("#qty_update_stck").val()
      id = $("#id_update_stck").val()
      
      desc = $("#desc_update_stck").val()
      type = $("#stock_update").val()
      var fileInput = document.getElementById('image_update');

      var formData = new FormData();
      formData.append('_token', '{{ csrf_token() }}');
      formData.append('qty', qty);
      formData.append('desc', desc);
      formData.append('type', type);
      formData.append('id', id);
      
      
      $.ajax({
        type: "POST",
        url: "{{url('/')}}"+"/updateItemQty",
        data:formData,
        processData: false,
        contentType: false,
        beforeSend: $.LoadingOverlay("show"),
        afterSend:$.LoadingOverlay("hide"),
        success: function (data) {
          if(data=="sukses"){
            getAllData()
            $('#modalUpdateQty').modal("hide")
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