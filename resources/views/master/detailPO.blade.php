@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Cart Detail</h1>
@stop

@section('content')
    <div class="card">
      <div class="card-header">
        <div class="container">
          <div class="row">
            <div class="col align-self-start">
            </div>
            <div class="col-8 align-self-center">

            </div>
            <div class="col align-self-end">
              <button class="btn btn-primary">
                Print
              </button>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-6">
            <div>
              <p class="text-start">PO Number</p>
              <p class="text-start">{{ $dataCart[0]->po_id }}</p>
            </div>
          </div>
          <div class="col-6">
            <div>
              <p class="text-start">Created Purchase Order at</p>
              <p class="text-start">{{ $dataCart[0]->created_at }}</p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-6">
            <div>
              <p class="text-start">Invoice Number</p>
              <p class="text-start">{{ $dataCart[0]->po_id }}</p>
            </div>
          </div>
          <div class="col-6">
            <div>
              <p class="text-start">Due Date</p>
              <p class="text-start">{{ $dataCart[0]->due_date }}</p>
            </div>
          </div>
        </div>
        <div class="row d-flex justify-content-end">
          <div class="col-6">
            <div>
              <p class="text-start">Created By</p>
              <p class="text-start">{{ $dataCart[0]->created_by }}</p>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="container">
          <div class="row">
              <div class="col d-flex align-items-center">
                <strong class="text-black fs-2">
                  Status  | 
                </strong>
                <div id="span_status">
                </div>
                <div class="p-2">
                  <button class="btn btn-light" data-toggle="modal" data-target="#modalEditStatus">Edit Status</button>
                </div>
              </div>
            <div class="col text-end">
              <div class="d-flex justify-content-end">
                @if ($dataCart[0]->status != 4 && $dataCart[0]->status != 3)
                <div class="p-2" id="button-status-canceled">
                  <button class="btn me-3 btn-outline-danger" id="cancel_status_btn" data-toggle="modal" data-target="#modalCancel">
                    Cancel Purchase Order
                  </button>
                </div>
                <div class="p-2" id="button-status-update">
                </div>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-body">
            <h5 style="font-weight: 600">Doctor</h5>

            <ul class="list-group list-group-flush">
              <li class="list-group-item">
                <p id="name_doc">{{ $dataCart[0]->name }}</p>
              </li>
              <li class="list-group-item">Clinic
                <p id="clinic_doc">{{ $dataCart[0]->clinic }}</p>
              </li>
              <li class="list-group-item">Billing Phone
                <p id="billing_phone_doc">{{ $dataCart[0]->billing_no_hp }}</p>
              </li>
              <li class="list-group-item">Doctor Phone
                <p id="no_hp_doc">{{ $dataCart[0]->no_hp }}</p>
              </li>
              <li class="list-group-item">Address
                <p id="address_doc">{{ $dataCart[0]->address }}</p>
              </li>
              <li class="list-group-item">Doctor Information
                <p id="information_doc">{{ $dataCart[0]->information }}</p>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card">
          <div class="card-body">
          <div class="form-group">
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
                <tbody>
                  @foreach ($cart as $item)
                      <tr>
                        <td>{{ $item['name_product'] }}</td>
                        <td>{{ $item['qty'] }}</td>
                        <td>IDR {{ $item['price_product'] }}</td>
                        <td><div class="badge bg-secondary">{{ $item['disc'] }}%</div></td>
                        <td>IDR {{ $item['price'] }} <br>- IDR {{ $item['disc_price'] }}
                        <div style="border-top: 1px solid #ccc;"></div>
                        IDR {{ $item['total_price'] }}
                        </td>
                      </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <tr>
                      <td colspan="4">
                        <div class="d-flex justify-content-end">
                          <p class="fw-bold">
                            Grand Total: 
                          </p>
                        </div>
                      </td>
                      <td>
                       IDR {{ $total }}
                      </td>
                    </tr>
                  </tr>
                </tfoot>
              </table>  
            </div>
            {{-- <p style="text-align: right; font-weight: 700;color:#AFACAC">Grand Total: Rp {{$total}}</p> --}}
            <div class="d-flex justify-content-end">
              <button class="btn btn-outline-success">
                Add Extra Charges
              </button>
            </div>
            <div class="form-group">
              <label for="notes_form">Note For Admin</label>
              <p class="text-start">{{ $dataCart[0]->notes }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Cancel-->
    <div class="modal fade" id="modalCancel" tabindex="-1" role="dialog" aria-labelledby="modalUpdateTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Cancel Form</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="formUpdate" role="form">
            <div class="modal-body">
                <input type="hidden" class="form-control" id="id_update">
              <div class="form-group">
                <label for="nama_update">Cancel Reason</label>
                <input type="nama_update" class="form-control" id="cancel_reason"  placeholder="Masukkan Reason">
              </div>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" id="cancel_btn" class="btn btn-primary">Save changes</button>
          </div>
        </form>
        </div>
      </div>
    </div>

    <!-- Modal Sent-->
    <div class="modal fade" id="modalSent" tabindex="-1" role="dialog" aria-labelledby="modalUpdateTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Cancel Form</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="formUpdate" role="form">
            <div class="modal-body">
              <input type="hidden" class="form-control" id="id_update">
              <div class="form-group">
                <label for="category_product_add">Category Product</label>
                <div id="dropadd" name="dropadd" class="form-group">
                  <select class="form-select form-control" id="ekspedisi_select">
                    @foreach($dataEkspedisi as $item)
                      <option value={{$item->id}}>{{$item->name}}</option>
                    @endforeach
                  </select> 
                </div>
              </div>
              <div class="form-group">
                <label for="receipt-number">Receipt Number</label>
                <input type="receipt-number" class="form-control" id="receipt_number_input"  placeholder="Masukkan Receipt Number">
              </div>
              <div class="form-group">
                <label for="shipping-cost">Shipping Cost</label>
                <div class="input-group mb-3">
                  <span class="input-group-text" id="basic-addon1">IDR</span>
                  <input type="text" class="form-control" placeholder="Masukan Cost" aria-label="Username" aria-describedby="basic-addon1" value="0" id="shipping_cost_input">
                </div>
              </div>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" id="sent_btn" class="btn btn-primary">Save changes</button>
          </div>
        </form>
        </div>
      </div>
    </div>

    <!-- Modal Sent-->
    <div class="modal fade" id="modalEditStatus" tabindex="-1" role="dialog" aria-labelledby="modalUpdateTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Edit Status</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="formUpdate" role="form">
            <div class="modal-body">
              <input type="hidden" class="form-control" id="id_update">
              <div class="form-group">
                <label for="category_product_add">Status</label>
                <div id="dropadd" name="dropadd" class="form-group">
                  <select class="form-select form-control" id="ekspedisi_select">
                    @if ($dataCart[0]->status == 0)
                      <option value="0" selected>SUBMITED</option>
                    @elseif($dataCart[0]->status == 1)
                      <option value="0">SUBMITED</option>
                      <option value="1" selected>PACKING</option>
                    @elseif($dataCart[0]->status == 2)
                      <option value="0">SUBMITED</option>
                      <option value="1">PACKING</option>
                      <option value="2" selected>SENT</option>
                    @elseif($dataCart[0]->status == 3)
                      <option value="0">SUBMITED</option>
                      <option value="1">PACKING</option>
                      <option value="2">SENT</option>
                      <option value="3" selected>PAID</option>
                    @endif
                  </select> 
                </div>
              </div>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" id="status_btn" class="btn btn-primary">Save changes</button>
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
  // const Swal = require('sweetalert2');
  dokter = @json($dokter);
  cart = @json($cart);
  idCart = @json($idCart);
  dataCart = @json($dataCart);
  user = @json($user);
  // var user = $user

  window.onload = function() {
    // getAllData()
    checkForButtonStatus()
    // console.log({user})
    $('#list_doctor').select2({data:dokter,});
  };

      // Event listener for modal shown event
    $('#modalCancel').on('shown.bs.modal', function () {
      resetModalInput();
    });

    $('#modalCancel').on('hidden.bs.modal', function () {
      resetModalInput();
    });



    function resetModalInput() {
      document.getElementById('cancel_reason').value = '';
    }

  
    // var dataTable = $("#tableList").DataTable({
    //         "ordering": true,
    //         "destroy": true,
    //         "ordering": false,
    //         "searching": false,
    //         "paging": false,
    //         "info":false,
    //         //to turn off pagination
    //         // paging: false,
    //         // "bFilter": true,
    //         //turn off info current page data index
    //         // "bInfo": false,
    //         // pagingType: 'full_numbers',
    // });

    function checkForButtonStatus() {
      /*
      submited = biru primary => 0
      packing = kuning => 1
      sent = biru laut => 2
      paid = ijo success => 3
      canceled = merah => 4
      */
      if(dataCart[0].status == 0) {
        document.querySelector('#span_status').innerHTML = `
        <span class="badge bg-primary text-wrap fs-2">
          Submited
        </span>
        `

        document.querySelector('#button-status-update').innerHTML = `
        <button type="button" class="btn btn-outline-warning" id="packing_btn" onclick="packing_btn()">
          Packing Purchase Order
        </button> 
        `
      } else if (dataCart[0].status == 1) {
        document.querySelector('#span_status').innerHTML = `
        <span class="badge bg-warning text-wrap fs-2">
          Packing
        </span>
        `
        document.querySelector('#button-status-update').innerHTML = `
        <button class="btn btn-outline-info" id="sent_btn" data-toggle="modal" data-target="#modalSent">
          Sent Order
        </button> 
        `
      } else if (dataCart[0].status == 2) {
        document.querySelector('#span_status').innerHTML = `
        <span class="badge bg-info text-wrap fs-2">
          Sent
        </span>
        `
        document.querySelector('#button-status-update').innerHTML = `
        <button class="btn btn-outline-success" id="payment_btn">
          Submit Payment
        </button> 
        `
      } else if (dataCart[0].status == 3) {
        document.querySelector('#span_status').innerHTML = `
        <span class="badge bg-success text-wrap fs-2">
          Paid (Completed)
        </span>
        `
        document.querySelector('#button-status-update').innerHTML = ""
      } else if (dataCart[0].status == 4) {
        document.querySelector('#span_status').innerHTML = `
        <span class="badge bg-danger text-wrap fs-2">
          Canceled
        </span>
        `
      }
    }

    function getAllData(){
        // console.log({cart})
        // if($dataCart[0].status_id == 1) {
        //   $("#status_id").text()
        // }

        // $.each(cart,function(i, item){
        //   price = `Rp `+item['price']+`<br>- Rp `+item['disc_price']+`<br><div style="border-top: 1px solid #ccc;"></div>Rp `+item["total_price"];

        //   // price=

        //   dataTable.row.add([
        //       item['name_product'],
        //       item['qty'],
        //       item['price_product'],
        //       `<div class="badge bg-secondary">`+item['disc']+` %</div>`,
        //       price,
        //   ])
        //   dataTable.draw();

        // }
        // )


        // var data = dataTable.column(0).data();
        // console.log({data})
        // data.push("finiii")

    }

    $('#management_order').change(function() {
        // If checkbox is checked, set its value to "1"; otherwise, set it to "0"
        if ($(this).is(':checked')) {
            $(this).val('1');
        } else {
            $(this).val('0');
        }
    });

    $('#sent_btn').on('click', function (e) { 
      var ekspedisi = $('#ekspedisi_select').val()
      var shippingCost = $('#shipping_cost_input').val()
      var receipt_number_input = $('#receipt_number_input').val()
      $.ajax({
        type: "POST",
        url: "{{url('/')}}"+"/sentPO",
        data: { "_token": "{{ csrf_token() }}", data: {
          status: 2,
          expedition_id: ekspedisi,
          shipping_cost: shippingCost,
          recepient_number: receipt_number_input,
          id:dataCart[0].id,
        }},
        beforeSend: $.LoadingOverlay("show"),
        afterSend:$.LoadingOverlay("hide"),
        success: function (data) {
          if(data=="sukses"){
            $('#modalSent').modal("hide")
            AlertSuccess()
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
      })

    })

    $('#cancel_btn').on('click', function (e) { 
        // $dataCart[0].status = 2 
        // e.preventDefault();
        var cancel_reason = $("#cancel_reason").val()
        $.ajax({
        type: "POST",
        url: "{{url('/')}}"+"/canceledPO",
        data: { "_token": "{{ csrf_token() }}", data: {
          status: 4,
          cancel_reason: cancel_reason,
          id:dataCart[0].id,
        }},
        beforeSend: $.LoadingOverlay("show"),
        afterSend:$.LoadingOverlay("hide"),
        success: function (data) {
          if(data=="sukses"){
            $('#modalCancel').modal("hide")
            AlertSuccess()
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
        document.querySelector('#span_status').innerHTML = `                  <span class="badge bg-danger text-wrap">
                    Canceled
                  </span>
        `
        document.querySelector('#button-status-canceled').innerHTML = ""
        document.querySelector('#button-status-update').innerHTML = ""
    })

    function packing_btn() {
      Swal.fire({
        title: 'Are you sure to packing this?',
        text: 'Do you want to continue',
        icon: 'info',
        showDenyButton: true,
        confirmButtonText: "Yes",
        denyButtonText: `No`
      }).then((result)=> {
        if (result.value) {
          $.ajax({
          type: "POST",
          url: "{{url('/')}}"+"/packingPO",
          data: { "_token": "{{ csrf_token() }}", data: {
            status: 1,
            id:dataCart[0].id,
          }},
          beforeSend: $.LoadingOverlay("show"),
          afterSend:$.LoadingOverlay("hide"),
          success: function (data) {
            if(data=="sukses"){
              // $('#modalCancel').modal("hide")
              AlertSuccess()
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
          document.querySelector('#span_status').innerHTML = `                  <span class="badge bg-danger text-wrap">
                      Canceled
                    </span>
          `
          document.querySelector('#button-status-update').innerHTML = `
          <button class="btn btn-outline-info" id="sent_btn">
            Sent Order
          </button> 
          `
        }
      })
    }

   

</script>
    
@endpush