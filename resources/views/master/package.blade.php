@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">List Paket</h1>
@stop

@section('content')
    <div class="card">
      <div class="card-header">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modaladd">
          ADD Product
        </button>
      </div>
      <div class="card-body">
        {{-- <table id="tableList" class="table table-striped table-bordered table-hover" >
           --}}
        <table id="tableList" class="table table-bordered" >
          <thead>
            <tr>
                <th>Photo</th>
                <th>Name</th>
                <th>Price</th>
                <th>Commission Rate</th>
                <th>Product</th>
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
      <form id="formadd" role="form" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="container text-center">
            <div class="row">
              <div class="col">
                <div class="form-group">
                  <label for="nama_add">Nama *</label>
                  <input type="nama_add" class="form-control" id="nama_add"  placeholder="Masukkan Nama" >
                </div>
                <div class="row">
                  <div class="col">
                    
                    <div class="form-group">
                      <label for="price_add">Price * (ex: 10000)</label>
                      <div class="input-group mb-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text">Rp</div>
                        </div>
                        <input type="price_add" class="form-control" id="price_add"  placeholder="Masukkan Harga Product (ex: 100000)" oninput="addDotPrice(this);">
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-group">
                      <label for="commision_rate_add">Commission Rate *</label>
                      <div class="input-group mb-2">
                        <input type="commision_rate_add" class="form-control" id="commision_rate_add"  placeholder="Masukkan Rate Komisi (ex: 2.5)" onkeyup="this.value = this.value.replace(/[^0-9.]/g, '');">
                        <div class="input-group-prepend">
                          <div class="input-group-text">%</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="desc_add">Description</label>
                  <textarea type="desc_add" class="form-control" id="desc_add" rows="4"  placeholder="Masukkan Informasi"></textarea>
                </div>
                <div class="form-group">
                  <input class="btn-check" type="checkbox" id="status_add" checked/>
                 <label for="status_add" class="form-check-label" >Status</label>
                </div>
                <div class="form-group" >
                  <img id="preview" style="width: 200px; height: 200px; border: 1px solid #ccc; background-color: #f0f0f0; ">
                </div>
                <div class="form-group" >
                  <label for="image_add">Image</label>
                  <input type="file" name="image_add" accept="image/*" id="image_add"  placeholder="Masukkan Image" onchange="previewImage(event)">
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <label for="category_product_add">Product</label>
                  <div id="dropadd" name="dropadd" class="form-group">
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item">
                        <div class="container text-center">
                          <div class="row">
                            <div class="col">
                              Name
                            </div>
                            <div class="col">
                              Qty
                            </div>
                          </div>
                        </div>
                      </li>
                      @foreach($data["dataProduct"] as $key => $item)
                      <li class="list-group-item">
                        <div class="container text-center">
                          <div class="row">
                            <div class="col">
                              {{ $item->name }}
                            </div>
                            <div class="col">
                              <div class="input-group mb-3">
                                <input type="text" class="form-control" aria-describedby="basic-addon2" name="input-data" data-id="{{ $item->id }}" oninput="addDotPrice(this);">
                                <span class="input-group-text" id="basic-addon2">{{ $item->unit }}</span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </li>
                      @endforeach
                    </ul>
                  </div>
                </div>
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
          {{-- <div class="form-group">
            <label for="qty_detail">Stock</label>
            <input type="qty_detail" class="form-control" id="qty_detail"  placeholder="Masukkan Stock" onkeyup="this.value = this.value.replace(/[^0-9]/g, '');" disabled>
          </div> --}}
          {{-- <div class="form-group">
            <label for="unit_detail">Unit Product</label>
            <input type="unit_detail" class="form-control" id="unit_detail"  placeholder="Masukkan Status" disabled>
          </div> --}}
          <div class="form-group">
            <label for="price_detail">Price (ex: 100000)</label>
            
            <div class="input-group mb-2">
              <div class="input-group-prepend">
                <div class="input-group-text">Rp</div>
              </div>
              <input type="price_detail" class="form-control" id="price_detail"  placeholder="Masukkan Harga Product" onkeyup="this.value = this.value.replace(/[^0-9]/g, '');" disabled>
            </div>
          </div>
          {{-- <div class="form-group">
            <label for="presentation_detail">Presentation (ex: 2.5)</label>
            <div class="input-group mb-2">
              <input type="presentation_detail" class="form-control" id="presentation_detail"  placeholder="Masukkan Presentasi" onkeyup="this.value = this.value.replace(/[^0-9.]/g, '');" disabled>
              <div class="input-group-prepend">
                <div class="input-group-text">%</div>
              </div>
            </div>
          </div> --}}
          <div class="form-group">
            <label for="commision_rate_detail">Commission Rate (ex: 2.5)</label>
            <div class="input-group mb-2">
              <input type="commision_rate_detail" class="form-control" id="commision_rate_detail"  placeholder="Masukkan Rate Komisi" onkeyup="this.value = this.value.replace(/[^0-9.]/g, '');" disabled>
              <div class="input-group-prepend">
                <div class="input-group-text">%</div>
              </div>
            </div>
          </div>
          {{-- <div class="form-group">
            <label for="mini_desc_detail">Mini Description</label>
            <textarea type="mini_desc_detail" class="form-control" id="mini_desc_detail" rows="1"  placeholder="Masukkan Informasi Mini" disabled></textarea>
          </div> --}}
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
          <div>
            <strong>List Product</strong>
            <div id="list-product">
            </div>
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
      // document.getElementById('category_product_add').value = '';
      document.getElementById('desc_add').value = '';
      document.getElementById('price_add').value = '';
      document.getElementsByName('input-data').value = '';
    }

    function getAllData(){
      $.ajax({
      type: "POST",
      url: "{{url('/')}}"+"/getProductBundles",
      beforeSend: $.LoadingOverlay("show"),
      afterSend:$.LoadingOverlay("hide"),
      data: { "_token": "{{ csrf_token() }}"},
      success: function (data) {
        console.log(data, "dataaa")
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
            img = `<img id="preview" style="width: 50px; height: 50px; border: 1px solid #ccc; background-color: #AFACAC; display:block; margin:auto;">`
          }

          str = item['product']
          strName = `<ul class="list-group list-group-flush">`
          str.forEach((element, idx) => {
            strName += `<li class="list-group-item" style="border-top: 0 none;">${element}</li>`
            if (idx == str.length - 1) {
              strName += `</ul>`
            }
          });
          
          stat = "Active"
          if(item['status']==0){
            stat = "InActive"
          }

          dataTable.row.add([
              img,
              item['name'],
              "Rp "+item['price'],
              item['commision_rate'] + "%",
              strName,
              stat,
              `<button class="btn btn-info" onclick="getItem(`+item['id']+`)">Detail</button>
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
      status = ""
      console.log($('#status_add').is(":checked"), "checked")
      // return
      if ($('#status_add').is(":checked")){
        // it is checked
        status = "1"
      } else {
        status = "0"
      }
      category_product = $("#category_product_add").val()
      price = $("#price_add").val()
      commision_rate = $("#commision_rate_add").val()
      desc = $("#desc_add").val()

      var arr = $("input[name=input-data]").map(function (index) { 
        if($(this).val() !== "") {
          return $(this).val() + "|" + $(this).attr('data-id').trim() 
        }
      }).get()
      arr = arr.join(",")

      var fileInput = document.getElementById('image_add');

      // Construct FormData object
      var formData = new FormData();
      formData.append('img', fileInput.files[0]); 
      formData.append('_token', '{{ csrf_token() }}');
      formData.append('name', name);
      formData.append('status', status);
      formData.append('category_product', category_product);
      formData.append('price', price);
      formData.append('commision_rate', commision_rate);
      formData.append('desc', desc);
      formData.append('product', arr);

      $.ajax({
        type: "POST",
        url: "{{url('/')}}"+"/addProductBundle",
        // data: { "_token": "{{ csrf_token() }}","name":name, "qty":qty, "status":status,"category_product":category_product,"unit":unit,
        // "price":price,"presentation":presentation,"commision_rate":commision_rate,"mini_desc":mini_desc, "desc":desc,"img":fileInput.files[0]},
        data:formData,
        processData: false,
        contentType: false,
        beforeSend: $.LoadingOverlay("show"),
        afterSend:$.LoadingOverlay("hide"),
        success: function (data) {
          console.log(data, "data")
          if(data=="sukses"){
            getAllData()
            $('#modaladd').modal("hide")
            AlertSuccess()
          }else{
            AlertError()
          }
        },
        error: function (result, status, err) {
          console.log(err, "error")
          $.LoadingOverlay("hide")
          AlertError()
        },
      });
    });

    function getItem(id){
      $.ajax({
        type: "POST",
        url: "{{url('/')}}"+"/getProductBundle",
        data: { "_token": "{{ csrf_token() }}","id":id},
        beforeSend: $.LoadingOverlay("show"),
        afterSend:$.LoadingOverlay("hide"),
        success: function (data) {
          console.log({data})
          $('#id_detail').val(data.id)
          $('#nama_detail').val(data.name)
          $('#qty_detail').val(data.qty)
          if (data.status==0){
            $('#status_detail').val("InActive")
          }else if (data.status==1){
            $('#status_detail').val("Active")
          }

          $("#price_detail").val(data.price)
          $("#commision_rate_detail").val(data.commision_rate)
          $("#desc_detail").val(data.desc)

          $('#created_by_detail').val(FormatTimeStamp(data.created_by,data.created_at))
          $('#updated_by_detail').val(FormatTimeStamp(data.updated_by,data.updated_at))
          $('#modalDetail').modal("show")
          ListProduct (data['product'])
        },
        error: function (result, status, err) {
          alert(err)
        }
      });
    };

    function ListProduct (product) { 
      let htmlElement = `
      <table class="table table-stripped">
        <thead>
          <tr>
            <th scope="col"> Name Product </th>
            <th scope="col"> Stock </th>
          </tr>
        </thead>
        <tbody>`
      for (let i = 0; i < product.length; i++) {
        const element = product[i];
        htmlElement += `
          <tr>
            <td> ${element['name']} </td>
            <td> ${element['stock']} </td>
          </tr>
        `
      }

      htmlElement += `
        </tbody>
      </table>
      `

      document.querySelector(`#list-product`).innerHTML = htmlElement      
    }

    function deleteItem(id){
      $.ajax({
        type: "POST",
        url: "{{url('/')}}"+"/deleteProductBundle",
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