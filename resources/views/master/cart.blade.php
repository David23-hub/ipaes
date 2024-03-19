@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Cart Purchase Order</h1>
@stop

@section('content')
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-body">
            <h5 style="font-weight: 600">Doctor</h5>

            <ul class="list-group list-group-flush">
              <li class="list-group-item">
                <div id="dropadd" name="dropadd" class="form-group">
                  <select  class="form-select form-control" name="list_doctor" id="list_doctor" onchange="loadDoctorData()" style="width: 100%;max-width:100%">
                      <option value="kosong" selected disabled>-- Select --</option>
                      @foreach($dokter as $dok)
                        <option value={{$dok->id}}>{{$dok->name}}</option>
                      @endforeach
                  </select> 

                </div>
              </li>
              <li class="list-group-item">Clinic
                <p id="clinic_doc">-</p>
              </li>
              <li class="list-group-item">Billing Phone
                <p id="billing_phone_doc">-</p>
              </li>
              <li class="list-group-item">Doctor Phone
                <p id="no_hp_doc">-</p>
              </li>
              <li class="list-group-item">Address
                <p id="address_doc">-</p>
              </li>
              <li class="list-group-item">Doctor Information
                <p id="information_doc">-</p>
              </li>
            </ul>


          </div>
        </div>
      </div>
      <div class="col">
        <div class="card">
          <div class="card-body">

            <div class="form-group">
              <label for="due_date">Due Date</label>
              <div id="dropadd" name="dropadd" class="form-group">
                <select class="form-select form-control" id="due_date">
                  <option value="7">7 Days</option>
                  <option value="14">14 Days</option>
                  <option value="21">21 Days</option>
                  <option value="30">30 Days</option>
                </select> 
              </div>
              <div style="text-align: right;margin-bottom:10px">
                <button class="btn me-3 btn-outline-success" data-toggle="modal" data-target="#modalEditProduct" id="edit_product" >
                  Edit Product
                </button>
              </div>
            <div class="table-responsive">
              <table id="tableList" class="table table-bordered" >
                <thead>
                  <tr style="background-color: #E3EFFF;">
                      <th>Product</th>
                      <th>Qty</th>
                      <th>Price</th>
                      <th>Discount</th>
                      <th>TotalPrice</th>
                  </tr>
                </thead>
              </table>  
            </div>
            <p style="text-align: right; font-weight: 700;color:#AFACAC">Grand Total: Rp {{$total}}</p>
            <div class="form-group">
              <label for="notes_form">Note For Admin</label>
              <textarea type="notes_form" class="form-control" id="notes_form" rows="3"  placeholder="Masukkan Note For Admin"></textarea>
            </div>

              <div style="text-align: right">
                <input type="checkbox" id="management_order" name="management_order">
                <label for="management_order"> Management Order</label><br>
              </div>
            
            

            <p style="text-align: right;">
              <button class="btn btn-success" id="submit_po">Create Purchase Order</button>
            </p>

          </div>
        </div>
      </div>
    </div>

    <!-- Modal Edit Product-->
    <div class="modal fade" id="modalEditProduct" tabindex="-1" role="dialog" aria-labelledby="modalUpdateTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Product Form</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="formUpdate" role="form">
            <div class="modal-body">
              <span>Product</span>
              @foreach ($cart as $keyProduct => $itemProduct)
                <div id="body-product" class="input-group">
                  <div class="d-inline-flex p-2">
                    <div id="name-product">
                      <span class="input-group-text">Name</span>
                      <span class="input-group-text">{{ $itemProduct['name_product'] }}</span>
                    </div>
                    <div>
                      <span class="input-group-text">Stok</span>
                      <input type="number" class="form-control" id="productQty{{$keyProduct}}"  aria-describedby="inputGroupPrepend2" required value="{{ $itemProduct['qty'] }}" min="0" >
                    </div>
                    <div>
                      <span class="input-group-text">Price</span>
                      <input type="text" class="form-control" id="productPrice{{$keyProduct}}"  aria-describedby="inputGroupPrepend2" required value="{{ $itemProduct['price_product'] }}" min="0" oninput="removeLeadingZero(this);">
                    </div>
                    <div>
                      <span class="input-group-text">Discount</span>
                      <input type="number" class="form-control" id="productDiscount{{$keyProduct}}"  aria-describedby="inputGroupPrepend2" required value="{{ $itemProduct['disc'] }}" min="0" >
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" id="payment_btn" class="btn btn-primary" onclick="EditProduct()">Save changes</button>
          </div>
        </form>
        </div>
      </div>
    </div>

    <style>
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
    </style>
@stop

@push('js')
<script>

function removeLeadingZero(input) {
      
  input.value = input.value.replace(/[^0-9]/g, '')
  if (input.value.charAt(0) === '0' && input.value.length !=1) {
      input.value = input.value.slice(1);
    }
  if (input.value > 3) {
        input.value = input.value.replace(/(\d)(?=(\d{3})+$)/g, '$1.');
      }
    
}


  dokter = @json($dokter);
  cart = @json($cart);
  idCart = @json($idCart);

  window.onload = function() {
    getAllData()
    $('#list_doctor').select2({data:dokter,});
  };

  
    var dataTable = $("#tableList").DataTable({
            "ordering": true,
            "destroy": true,
            "ordering": false,
            "searching": false,
            "paging": false,
            "info":false,
            //to turn off pagination
            // paging: false,
            // "bFilter": true,
            //turn off info current page data index
            // "bInfo": false,
            // pagingType: 'full_numbers',
        });

        function autoSelectAndShow(value) {
          var selectElement = document.getElementById("list_doctor");
          
          // Find the option element with the specified value
          var option = selectElement.querySelector('option[value="' + value + '"]');
          
          if (option) {
            // Set selected attribute to true for the found option
            option.selected = true;
            
            // Update the displayed text to match the selected option
            selectElement.dispatchEvent(new Event('change'));
            $('#clinic_doc').text('')
            $('#billing_phone_doc').text('')
            $('#no_hp_doc').text('')
            $('#address_doc').text('')
            $('#information_doc').text('')
          } else {
            console.log("Option not found");
          }
        }


    function getAllData(){
        autoSelectAndShow("kosong")

        dataTable.destroy();
        $.each(cart,function(i, item){
          price = `Rp `+item['price']+`<br>- Rp `+item['disc_price']+`<br><div style="border-top: 1px solid #ccc;"></div>Rp `+item["total_price"];

          // price=

          dataTable.row.add([
              item['name_product'],
              item['qty'],
              `Rp `+item['price_product'],
              `<div class="badge bg-secondary">`+item['disc']+` %</div>`,
              price,
          ])
            dataTable.draw();
        }
        )

    }

    function loadDoctorData(){
      var id = document.getElementById("list_doctor").value;
    
      Object.keys(dokter).forEach(function(key) {
        let item = dokter[key];

        if(item.id==id){
          $('#clinic_doc').text(item.clinic)
          $('#billing_phone_doc').text(item.billing_no_hp)
          $('#no_hp_doc').text(item.no_hp)
          $('#address_doc').text(item.address)
          $('#information_doc').text(item.information)
        }
        
      });

    }

    $('#management_order').change(function() {
        // If checkbox is checked, set its value to "1"; otherwise, set it to "0"
        if ($(this).is(':checked')) {
            $(this).val('1');
        } else {
            $(this).val('0');
        }
    });

    $('#submit_po').on('click', function(e) {
      management_order = $("#management_order").val()
      notes_form = $("#notes_form").val()
      due_date = $("#due_date").val()
      id_doctor = $("#list_doctor").val()
      $.ajax({
        type: "POST",
        url: "{{url('/')}}"+"/addPO",
        data: { "_token": "{{ csrf_token() }}","id_cart":idCart,"management_order":management_order, "notes_form":notes_form, "due_date":due_date, "id_doctor":id_doctor},
        beforeSend: $.LoadingOverlay("show"),
        afterSend:$.LoadingOverlay("hide"),
        success: function (data) {
          if(data=="sukses"){
            getAllData()
            AlertSuccess()
            idCart=""
          }else if(data!='gagal'|| data!="gagal2"){
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

    function EditProduct(){
      let productJoin = ""
      for(let i = 0; i < cart.length; i++) {
        let el = cart[i]
        var quantity = $(`#productQty${i}`).val()
        var discount = $(`#productDiscount${i}`).val()
        var price = $(`#productPrice${i}`).val()
        if(quantity==""){
          quantity = 0;
        }
        if(discount==""){
          discount=0;
        }
        if(price==""){
          price=0;
        }
        

        if(cart.length -1 == i) {
          productJoin += `${el['prod_id']}|${el['type']}|${quantity}|${discount}|${price.replace(/\./g, "")}`
        } else {
          productJoin += `${el['prod_id']}|${el['type']}|${quantity}|${discount}|${price.replace(/\./g, "")},`
        }
      }

      console.log({productJoin})

      $.ajax({
        type: "POST",
        url: "{{url('/')}}"+"/updateCart",
        data: { "_token": "{{ csrf_token() }}", "id":idCart, "data":productJoin},
        beforeSend: $.LoadingOverlay("show"),
        afterSend:$.LoadingOverlay("hide"),
        success: function (data) {
          if(data=="sukses"){
            $(`#modalEditProduct`).modal("hide")
            $(document).ajaxStop(function(){
              window.location.reload();
            });
          }else if(data!='gagal'|| data!="gagal2"){
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

    }

   

</script>
    
@endpush