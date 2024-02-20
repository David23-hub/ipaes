@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">List Product</h1>
@stop

@section('content')
    <div class="card">
      <div class="card-header">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modaladd">
          ADD Product
        </button>
      </div>
      <div class="card-body">
        <table id="tableList" class="table table-striped table-bordered table-hover" >
          <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Category</th>
                <th>Stock</th>
                <th>Price</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
          </thead>
        </table>
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
      <form id="formadd" role="form">
        <div class="modal-body">
          <div class="form-group">
            <label for="nama_add">Nama</label>
            <input type="nama_add" class="form-control" id="nama_add"  placeholder="Masukkan Nama">
          </div>

          <div class="form-group">
            <label for="category_product_add">Category Product</label>
            <div id="dropadd" name="dropadd" class="form-group">
              <select class="form-select form-control" id="category_product_add">
                @foreach($data as $item)
                  <option value={{$item->id}}>{{$item->name}}</option>
                @endforeach
              </select> 
            </div>
          </div>
          <div class="form-group">
            <label for="unit_add">Unit Product</label>
            <div id="dropadd" name="dropadd" class="form-group">
              <select class="form-select form-control" id="unit_add">
                  <option value="Box">Box</option>
                  <option value="Vial">Vial</option>
              </select> 
            </div>
          </div>
          <div class="form-group">
            <label for="price_add">Price (ex: 100000)</label>
            <div class="input-group mb-2">
              <div class="input-group-prepend">
                <div class="input-group-text">Rp</div>
              </div>
              <input type="price_add" class="form-control" id="price_add"  placeholder="Masukkan Harga Product" onkeyup="this.value = this.value.replace(/[^0-9]/g, '');">
            </div>
          </div>
          <div class="form-group">
            <label for="presentation_add">Presentation (ex: 2.5)</label>
            <div class="input-group mb-2">
              <input type="presentation_add" class="form-control" id="presentation_add"  placeholder="Masukkan Presentasi" onkeyup="this.value = this.value.replace(/[^0-9.]/g, '');">
              <div class="input-group-prepend">
                <div class="input-group-text">%</div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="commision_rate_add">Commission Rate (ex: 2.5)</label>
            <div class="input-group mb-2">
              <input type="commision_rate_add" class="form-control" id="commision_rate_add"  placeholder="Masukkan Rate Komisi" onkeyup="this.value = this.value.replace(/[^0-9.]/g, '');">
              <div class="input-group-prepend">
                <div class="input-group-text">%</div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="qty_add">Stock (Numeric Only)</label>
            <input type="qty_add" class="form-control" id="qty_add"  placeholder="Masukkan Stock" onkeyup="this.value = this.value.replace(/[^0-9]/g, '');">
          </div>
          <div class="form-group">
            <label for="mini_desc_add">Mini Description</label>
            <textarea type="mini_desc_add" class="form-control" id="mini_desc_add" rows="1"  placeholder="Masukkan Informasi Mini"></textarea>
          </div>
          <div class="form-group">
            <label for="desc_add">Description</label>
            <textarea type="desc_add" class="form-control" id="desc_add" rows="4"  placeholder="Masukkan Informasi"></textarea>
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
              <label for="name_update">Nama</label>
              <input type="name_update" class="form-control" id="name_update"  placeholder="Masukkan Nama">
            </div>
  
            <div class="form-group">
              <label for="category_product_update">Category Product</label>
              <div id="dropcategoryupdate" name="dropcategoryupdate" class="form-group">
                <select class="form-select form-control" id="category_product_update">
                  @foreach($data as $item)
                    <option value={{$item->id}}>{{$item->name}}</option>
                  @endforeach
                </select> 
              </div>
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
  
            <div class="form-group">
              <label for="price_update">Price (ex: 100000)</label>
              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <div class="input-group-text">Rp</div>
                </div>
                <input type="price_update" class="form-control" id="price_update"  placeholder="Masukkan Harga Product" onkeyup="this.value = this.value.replace(/[^0-9]/g, '');">
              </div>
            </div>
            <div class="form-group">
              <label for="presentation_update">Presentation (ex: 2.5)</label>
              <div class="input-group mb-2">
                <input type="presentation_update" class="form-control" id="presentation_update"  placeholder="Masukkan Presentasi" onkeyup="this.value = this.value.replace(/[^0-9.]/g, '');">
                <div class="input-group-prepend">
                  <div class="input-group-text">%</div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="commision_rate_update">Commission Rate (ex: 2.5)</label>
              <div class="input-group mb-2">
                <input type="commision_rate_update" class="form-control" id="commision_rate_update"  placeholder="Masukkan Rate Komisi" onkeyup="this.value = this.value.replace(/[^0-9.]/g, '');">
                <div class="input-group-prepend">
                  <div class="input-group-text">%</div>
                </div>
              </div>
            </div>
  
            <div class="form-group">
              <label for="qty_update">Stock (Numeric Only)</label>
              <input type="qty_update" class="form-control" id="qty_update"  placeholder="Masukkan Stock" onkeyup="this.value = this.value.replace(/[^0-9]/g, '');">
            </div>
            <div class="form-group">
              <label for="mini_desc_update">Mini Description</label>
              <textarea type="mini_desc_update" class="form-control" id="mini_desc_update" rows="1"  placeholder="Masukkan Informasi Mini"></textarea>
            </div>
            <div class="form-group">
              <label for="desc_update">Description</label>
              <textarea type="desc_update" class="form-control" id="desc_update" rows="4"  placeholder="Masukkan Informasi"></textarea>
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
            <label for="category_product_detail">Category Product</label>
            <input type="category_product_detail" class="form-control" id="category_product_detail"  placeholder="Masukkan Status" disabled>
          </div>
          <div class="form-group">
            <label for="qty_detail">Stock</label>
            <input type="qty_detail" class="form-control" id="qty_detail"  placeholder="Masukkan Stock" onkeyup="this.value = this.value.replace(/[^0-9]/g, '');" disabled>
          </div>
          <div class="form-group">
            <label for="unit_detail">Unit Product</label>
            <input type="unit_detail" class="form-control" id="unit_detail"  placeholder="Masukkan Status" disabled>
          </div>
          <div class="form-group">
            <label for="price_detail">Price (ex: 100000)</label>
            
            <div class="input-group mb-2">
              <div class="input-group-prepend">
                <div class="input-group-text">Rp</div>
              </div>
              <input type="price_detail" class="form-control" id="price_detail"  placeholder="Masukkan Harga Product" onkeyup="this.value = this.value.replace(/[^0-9]/g, '');" disabled>
            </div>
          </div>
          <div class="form-group">
            <label for="presentation_detail">Presentation (ex: 2.5)</label>
            <div class="input-group mb-2">
              <input type="presentation_detail" class="form-control" id="presentation_detail"  placeholder="Masukkan Presentasi" onkeyup="this.value = this.value.replace(/[^0-9.]/g, '');" disabled>
              <div class="input-group-prepend">
                <div class="input-group-text">%</div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="commision_rate_detail">Commission Rate (ex: 2.5)</label>
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
      document.getElementById('status_add').value = '0';
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
          
          dataTable.row.add([
              no,
              item['name'],
              item['category'],
              item['qty'] +" "+ item['unit'],
              "Rp "+item['price'],
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
      qty = $("#qty_add").val()
      
      category_product = $("#category_product_add").val()
      unit = $("#unit_add").val()
      price = $("#price_add").val()
      presentation = $("#presentation_add").val()
      commision_rate = $("#commision_rate_add").val()
      mini_desc = $("#mini_desc_add").val()
      desc = $("#desc_add").val()

      $.ajax({
        type: "POST",
        url: "{{url('/')}}"+"/addItem",
        data: { "_token": "{{ csrf_token() }}","name":name, "qty":qty, "status":status,"category_product":category_product,"unit":unit,
        "price":price,"presentation":presentation,"commision_rate":commision_rate,"mini_desc":mini_desc, "desc":desc},
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
        url: "{{url('/')}}"+"/getItem",
        data: { "_token": "{{ csrf_token() }}","id":id},
        beforeSend: $.LoadingOverlay("show"),
        afterSend:$.LoadingOverlay("hide"),
        success: function (data) {
          $('#id_detail').val(data.id)
          $('#nama_detail').val(data.name)
          $('#qty_detail').val(data.qty)
          if (data.status==0){
            $('#status_detail').val("InActive")
          }else if (data.status==1){
            $('#status_detail').val("Active")
          }

          $("#category_product_detail").val(data.category)
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
          $('#id_update').val(data.id)
          $('#name_update').val(data.name)
          $('#qty_update').val(data.qty)
          $('#status_update').val(data.status)

          $("#category_product_update").val(data.category_product)
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
      id = $("#id_update").val()
      
      category_product = $("#category_product_update").val()
      unit = $("#unit_update").val()
      price = $("#price_update").val()
      presentation = $("#presentation_update").val()
      commision_rate = $("#commision_rate_update").val()
      mini_desc = $("#mini_desc_update").val()
      desc = $("#desc_update").val()
      
      
      $.ajax({
        type: "POST",
        url: "{{url('/')}}"+"/updateItem",
        data: { "_token": "{{ csrf_token() }}","id":id,"name":name, "qty":qty, "status":status,"category_product":category_product,"unit":unit,
        "price":price,"presentation":presentation,"commision_rate":commision_rate,"mini_desc":mini_desc, "desc":desc},
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