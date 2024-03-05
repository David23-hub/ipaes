@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Detail Transaction</h1>
@stop

@section('content')
    <div class="card">
      <div class="card-header">
        <h5 style="font-weight: 600">Dokter</h5>
        <div class="row">
          <div class="col-6">
            <div class="border bg-light">
              <p class="text-center">Name</p>
              <p class="text-center">{{ $dokter->name }}</p>
            </div>
          </div>
          <div class="col-6">
            <div class="border bg-light">
              <p class="text-center">Clinic</p>
              <p class="text-center">{{ $dokter->clinic }}</p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-6">
            <div class="border bg-light">
              <p class="text-center">Billing Phone</p>
              <p class="text-center">{{ $dokter->billing_no_hp }}</p>
            </div>
          </div>
          <div class="col-6">
            <div class="border bg-light">
              <p class="text-center">Doctor Phone</p>
              <p class="text-center">{{ $dokter->no_hp }}</p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-6">
            <div class="border bg-light">
              <p class="text-center">Address</p>
              <p class="text-center">{{ $dokter->address }}</p>
            </div>
          </div>
          <div class="col-6">
            <div class="border bg-light">
              <p class="text-center">Doctor Information</p>
              <p class="text-center">{{ $dokter->information }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    @foreach ($dataCartDokter as $key => $itemDokter)`
    <div>
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-4">
              <div class="card">
                <div class="card-body">
                  <h5 style="font-weight: 600">Detail Information</h5>
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                      <p class="text-start">PO Number</p>
                      <p class="text-start">{{ $itemDokter->po_id }}</p>
                    </li>
                    <li class="list-group-item">
                      <p class="text-start">Created Purchase Order at</p>
                      <p class="text-start">{{ $itemDokter->created_at }}</p>
                    </li>
                    <li class="list-group-item">
                      <p class="text-start">Invoice Number</p>
                      <p class="text-start">{{ $itemDokter->po_id }}</p>
                    </li>
                    <li class="list-group-item">
                      <p class="text-start">Due Date</p>
                      <p class="text-start">{{ $itemDokter->due_date }}</p>
                    </li>
                    <li class="list-group-item">
                      <p class="text-start">Created By</p>
                      <p class="text-start">{{ $itemDokter->created_by }}</p>
                    </li>
                  </ul>
                  <div class="row">
                    <div class="col" style="text-align: left">
                      <strong class="text-black fs-2">
                        Status  | 
                      </strong>
                      <span id="span_status{{ $key }}"></span>
                      @if ($itemDokter['status'] == 4 || $itemDokter['status'] == 3 || $itemDokter['status'] == 5 )
                      <span class="p-2">
                      </span>                          
                      @else
                      <span class="p-2">
                        <button class="btn btn-light" data-toggle="modal" data-target="#modalEditStatus{{ $key }}">Edit Status</button>
                      </span>
                      @endif
                    </div>
                    <div class="col" style="text-align: right">
                      <button class="btn btn-primary">
                        Print
                      </button>
                    </div>
                  </div>
                  <br>
                  <div class="d-flex justify-content-end">
                    <div class="p-2" id="button-status-canceled{{ $key }}">
                      <button class="btn me-3 btn-outline-danger" id="cancel_status_btn" data-toggle="modal" data-target="#modalCancel{{ $key }}">
                        Cancel Purchase Order
                      </button>
                    </div>
                    <div class="p-2" id="button_status_update{{ $key }}">
                    </div>
                  </div>
                </div>
              </div>
              {{-- Column Packing Information --}}
            </div>
            <div class="col-sm-8">
              <div class="card">
                <div class="card-body">
                <h5 style="font-weight: 600">Transaction Details</h5>
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
                        @foreach ($itemDokter['products'] as $item)
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
                      </div>
                    </tbody>
                    <tfoot id="t-foot{{ $key }}">
                      <div id="extra_charge_list{{ $key }}">
                        @foreach ($itemDokter['extra_charge'] as $item)
                            <tr>
                              <td colspan="4">
                                <div class="d-flex justify-content-end">
                                  <p class="fw-bold"> 
                                    Extra Charge:
                                  </p>
                                </div>
                              </td>
                              <td>
                                IDR {{ $item['price'] }}
                              </td>
                            </tr>
                        @endforeach
                          <tr>
                            <td colspan="4">
                              <div class="d-flex justify-content-end">
                                <p class="fw-bold">
                                  Grand Total: 
                                </p>
                              </div>
                            </td>
                            <td>
                              <div id="grand_total{{ $key }}">
                                IDR {{ $itemDokter['total'] }}
                              </div>
                            </td>
                          </tr>
                      </tfoot>
                    </table>  
                  </div>
                  {{-- <p style="text-align: right; font-weight: 700;color:#AFACAC">Grand Total: Rp {{$total}}</p> --}}
                  <div class="d-flex justify-content-end">
                    <button class="btn btn-outline-success" data-target="#modalExtraCharge{{ $key }}" data-toggle="modal">
                      Add Extra Charges
                    </button>
                  </div>
                  <div class="form-group">
                    <label for="notes_form">Note For Admin</label>
                    <p class="text-start">{{ $itemDokter->notes }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="container">
            <div class="row">
              <div class="col-sm-4">
                <div id="column_cancel{{ $key }}"></div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-4">
                <div id="column_packing{{ $key }}">
                </div>
              </div>
              <div class="col-sm-8">
                <div id="column_sent{{ $key }}">
                </div>
              </div>
            </div>
          </div>
          <div class="container">
            <div class="row">
              <div class="col-sm-4"></div>
              <div class="col-sm-8">
                <div id="column_payment{{ $key }}">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Cancel-->
    <div class="modal fade" id="modalCancel{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="modalUpdateTitle" aria-hidden="true">
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
                <input type="nama_update" class="form-control" id="cancel_reason{{ $key }}"  placeholder="Masukkan Reason">
              </div>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" id="cancel_btn{{ $key }}" class="btn btn-primary" onclick="CancelButton({{ $itemDokter->id }}, {{ $key }})">Save changes</button>
          </div>
        </form>
        </div>
      </div>
    </div>

    <!-- Modal Extra Charge-->
    <div class="modal fade" id="modalExtraCharge{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="modalUpdateTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Add Extra Charge</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="formExtraCharge" role="form">
            <div class="modal-body d-flex">
              <div class="form-group p-2">
                <label for="extra_charge">Extra Charge *</label>
                <input type="text" class="form-control" id="extra_charge_desc{{ $key }}"  placeholder="description">
              </div>
              <div class="form-group p-2">
                <label for="extra_charge">Price *</label>
                <input type="text" class="form-control" id="extra_charge_price{{ $key }}"  placeholder="price">
              </div>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" id="extra_charge{{ $key }}" class="btn btn-primary" onclick="ExtraCharge({{ $itemDokter->id }}, {{ $key }})">Save changes</button>
          </div>
        </form>
        </div>
      </div>
    </div>

    <!-- Modal Sent-->
    <div class="modal fade" id="modalSent{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="modalUpdateTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Sent Form</h5>
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
                  <select class="form-select form-control" id="ekspedisi_select{{ $key }}">
                    @foreach($dataEkspedisi as $item)
                      <option value={{$item->id}}>{{$item->name}}</option>
                    @endforeach
                  </select> 
                </div>
              </div>
              <div class="form-group">
                <label for="receipt-number">Receipt Number</label>
                <input type="receipt-number" class="form-control" id="receipt_number_input{{ $key }}"  placeholder="Masukkan Receipt Number">
              </div>
              <div class="form-group">
                <label for="shipping-cost">Shipping Cost</label>
                <div class="input-group mb-3">
                  <span class="input-group-text" id="basic-addon1">IDR</span>
                  <input type="text" class="form-control" placeholder="Masukan Cost" aria-label="Username" aria-describedby="basic-addon1" value="" id="shipping_cost_input{{ $key }}">
                </div>
              </div>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" id="sent_btn{{ $key }}" class="btn btn-primary" onclick="SentButton({{ $itemDokter->id }}, {{ $key }})">Save changes</button>
          </div>
        </form>
        </div>
      </div>
    </div>

    <!-- Modal Edit Status-->
    <div class="modal fade" id="modalEditStatus{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="modalUpdateTitle" aria-hidden="true">
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
                  <select class="form-select form-control" id="status_select{{ $key }}">
                    @if ($itemDokter->status == 0)
                      <option value="0" selected>SUBMITED</option>
                    @elseif($itemDokter->status == 1)
                      <option value="0" id="">SUBMITED</option>
                      <option value="1" selected>PACKING</option>
                    @elseif($itemDokter->status == 2)
                      <option value="0">SUBMITED</option>
                      <option value="1">PACKING</option>
                      <option value="2" selected>SENT</option>
                    @elseif($itemDokter->status == 3 || $itemDokter->status == 5)
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
            <button type="button" id="status_btn{{ $key }}" class="btn btn-primary" onclick="UpdateStatus({{ $itemDokter->id }}, {{ $key }})">Save changes</button>
          </div>
        </form>
        </div>
      </div>
    </div>

    <!-- Modal Payment-->
    <div class="modal fade" id="modalPayment{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="modalUpdateTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Payment Form</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="formUpdate" role="form">
            <div class="modal-body">
              <div>
                <button type="button" class="btn btn-secondary" id="one_payment{{ $key }}" onclick="OnePaymentToggle({{ $key }})">One Payment</button>
                <button type="button" id="step_payment{{ $key }}" class="btn btn-primary" onclick="StepPaymentToggle({{ $key }})">Step Payment</button>
              </div>
              <div class="form-group">
                <label for="paid_at">Paid at *</label>
                <input type="date" class="form-control" id="paid_at{{ $key }}"  placeholder="Masukkan Tanggal Pembayaran">
              </div>
              <div class="form-group">
                <label for="bank_name">Bank Name *</label>
                <input type="text" class="form-control" id="bank_name{{ $key }}"  placeholder="Masukkan Bank Name">
              </div>
              <div class="form-group">
                <label for="bank_account_name">Bank Account Name *</label>
                <input type="text" class="form-control" id="bank_account_name{{ $key }}"  placeholder="Masukkan Account Bank Name">
              </div>
              <div class="form-group" style="display: none" id="container_nominal_input{{ $key }}">
                <label for="shipping-cost">Nominal *</label>
                <div class="input-group mb-3">
                  <span class="input-group-text" id="basic-addon1">IDR</span>
                  <input type="number" class="form-control" placeholder="Masukan Nominal" aria-label="Nominal" aria-describedby="basic-addon1" value="" id="nominal_payment_input{{ $key }}">
                </div>
              </div>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="clearModalPayment({{ $key }})">Close</button>
            <button type="button" id="payment_btn{{ $key }}" class="btn btn-primary" onclick="PaymentButton({{ $itemDokter->id }}, {{ $key }})">Save changes</button>
          </div>
        </form>
        </div>
      </div>
    </div>

    <!-- Modal Step Payment-->
    <div class="modal fade" id="modalStepPayment{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="modalUpdateTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Payment Form</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="formUpdate" role="form">
            <div class="modal-body">
              <input type="hidden" id="key_step_payment{{ $key }}" value="">
              <div>
                <button type="button" id="step_payment{{ $key }}" class="btn btn-primary" onclick="StepPayment({{ $key }})">Step Payment</button>
              </div>
              <div class="form-group">
                <label for="paid_at">Paid at *</label>
                <input type="date" class="form-control" id="step_paid_at{{ $key }}"  placeholder="Masukkan Tanggal Pembayaran">
              </div>
              <div class="form-group">
                <label for="bank_name">Bank Name *</label>
                <input type="text" class="form-control" id="step_bank_name{{ $key }}"  placeholder="Masukkan Bank Name">
              </div>
              <div class="form-group">
                <label for="bank_account_name">Bank Account Name *</label>
                <input type="text" class="form-control" id="step_bank_account_name{{ $key }}"  placeholder="Masukkan Account Bank Name">
              </div>
              <div class="form-group" id="container_step_nominal_input{{ $key }}">
                <label for="shipping-cost">Nominal *</label>
                <div class="input-group mb-3">
                  <span class="input-group-text" id="basic-addon1">IDR</span>
                  <input type="number" class="form-control" placeholder="Masukan Nominal" aria-label="Nominal" aria-describedby="basic-addon1" id="nominal_step_payment_input{{ $key }}">
                </div>
              </div>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="clearModalPayment({{ $key }})">Close</button>
            <button type="button" id="payment_btn{{ $key }}" class="btn btn-primary" onclick="StepPayment({{ $itemDokter->id }}, {{ $key }})">Save changes</button>
          </div>
        </form>
        </div>
      </div>
    </div>
    
    @endforeach

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
    user = @json($user);
    dataCartDokter = @json($dataCartDokter);
    console.log({dataCartDokter})
    window.onload = function() {
      checkForButtonStatus()
    };

    function OnePaymentToggle(key) {
      var x = document.getElementById(`container_nominal_input${key}`);
      x.style.display = "none"
    }

    function clearModalPayment(key) {
      document.getElementById(`paid_at${key}`).value = '';
      document.getElementById(`bank_name${key}`).value = '';
      document.getElementById(`bank_account_name${key}`).value = '';
      document.getElementById(`nominal_payment_input${key}`).value = '';
    }

    function StepPaymentToggle(key) {
      var x = document.getElementById(`container_nominal_input${key}`);
      x.style.display = "block"
    }

    function resetModalInput() {
      document.getElementById('cancel_reason').value = '';
    }

    function checkForButtonStatus() {
      /*
      submited = biru primary => 0
      packing = kuning => 1
      sent = biru laut => 2
      paid = ijo success => 3
      canceled = merah => 4
      paid step payment => 5
      */

      for (let i = 0; i < dataCartDokter.length; i++) {
        const element = dataCartDokter[i];
        
        if(dataCartDokter[i].status == 0) {
          document.querySelector(`#span_status${i}`).innerHTML = `
          <span class="badge bg-primary text-wrap fs-2">
            Submited
          </span>
          `
          document.querySelector(`#button_status_update${i}`).innerHTML = `
          <button type="button" class="btn btn-outline-warning" id="packing_btn" onclick="packing_btn(${dataCartDokter[i].id}, ${i})">
            Packing Purchase Order
          </button> 
          `
          document.querySelector(`#column_packing${i}`).innerHTML = ""
          document.querySelector(`#column_sent${i}`).innerHTML = ""
          document.querySelector(`#column_payment${i}`).innerHTML = ""
          document.querySelector(`#column_cancel${i}`).innerHTML = ""
        } else if (dataCartDokter[i].status == 1) {
          document.querySelector(`#span_status${i}`).innerHTML = `
          <span class="badge bg-warning text-wrap fs-2">
            Packing
          </span>
          `
          document.querySelector(`#button_status_update${i}`).innerHTML = `
          <button class="btn btn-outline-info" id="sent_btn_modal" data-toggle="modal" data-target="#modalSent${i}">
            Sent Order
          </button> 
          `

          document.querySelector(`#column_packing${i}`).innerHTML = `
          <div class="card">
                <div class="card-body">
                  <h5 style="font-weight: 600">Packing Information</h5>
                  <table class="table table-boredered table-responsive">
                    <tr>
                      <td class="border">Packing at</td>
                      <td class="border">${dataCartDokter[i].packing_at}</td>
                    </tr>
                    <tr>
                      <td class="border">Packing by</td>
                      <td class="border">${dataCartDokter[i].packing_by}</td>
                    </tr>
                  </table>
                </div>
              </div>
          `
          document.querySelector(`#column_sent${i}`).innerHTML = ""
          document.querySelector(`#column_payment${i}`).innerHTML = ""
          document.querySelector(`#column_cancel${i}`).innerHTML = ""
        } else if (dataCartDokter[i].status == 2) {
          document.querySelector(`#span_status${i}`).innerHTML = `
          <span class="badge bg-info text-wrap fs-2">
            Sent
          </span>
          `

          document.querySelector(`#column_payment${i}`).innerHTML = ""
          document.querySelector(`#column_cancel${i}`).innerHTML = ""
          document.querySelector(`#button_status_update${i}`).innerHTML = `
          <button class="btn btn-outline-success" id="payment_btn_modal" data-toggle="modal" data-target="#modalPayment${i}" onclick="clearModalPayment(${i})">
            Submit Payment
          </button> 
          `

          document.querySelector(`#column_packing${i}`).innerHTML = `
          <div class="card">
                <div class="card-body">
                  <h5 style="font-weight: 600">Packing Information</h5>
                  <table class="table table-boredered table-responsive">
                    <tr>
                      <td class="border">Packing at</td>
                      <td class="border">${dataCartDokter[i].packing_at}</td>
                    </tr>
                    <tr>
                      <td class="border">Packing by</td>
                      <td class="border">${dataCartDokter[i].packing_by}</td>
                    </tr>
                  </table>
                </div>
              </div>
          `

          document.querySelector(`#column_sent${i}`).innerHTML = `
          <div class="card">
                <div class="card-body">
                  <h5 style="font-weight: 600">Sent Information</h5>
                  <table class="table table-boredered">
                    <tr>
                      <td class="border">Sent at</td>
                      <td class="border">${dataCartDokter[i].sent_at}</td>
                    </tr>
                    <tr>
                      <td class="border">Expedition</td>
                      <td class="border">${dataCartDokter[i].expedition_id}</td>
                    </tr>
                    <tr>
                      <td class="border">Receipt Number</td>
                      <td class="border">${dataCartDokter[i].recepient_number}</td>
                    </tr>
                    <tr>
                      <td class="border">Shipping Cost</td>
                      <td class="border">IDR ${dataCartDokter[i].shipping_cost}</td>
                    </tr>
                    <tr>
                      <td class="border">Sent by</td>
                      <td class="border">${dataCartDokter[i].sent_by}</td>
                    </tr>
                  </table>
                  <span type="button" class="btn btn-block btn-outline-primary" onclick="EditSentButton(${i})">Edit Sent Infomartion</span>
                </div>
              </div>
          `
        } else if (dataCartDokter[i].status == 3) {
          document.querySelector(`#span_status${i}`).innerHTML = `
          <span class="badge bg-success text-wrap fs-2">
            Paid (Completed)
          </span>
          `
          document.querySelector(`#button_status_update${i}`).innerHTML = ""
          document.querySelector(`#button-status-canceled${i}`).innerHTML = ""

          document.querySelector(`#column_packing${i}`).innerHTML = `
          <div class="card">
                <div class="card-body">
                  <h5 style="font-weight: 600">Packing Information</h5>
                  <table class="table table-boredered table-responsive">
                    <tr>
                      <td class="border">Packing at</td>
                      <td class="border">${dataCartDokter[i].packing_at}</td>
                    </tr>
                    <tr>
                      <td class="border">Packing by</td>
                      <td class="border">${dataCartDokter[i].packing_by}</td>
                    </tr>
                  </table>
                </div>
              </div>
          `

          document.querySelector(`#column_sent${i}`).innerHTML = `
          <div class="card">
                <div class="card-body">
                  <h5 style="font-weight: 600">Sent Information</h5>
                  <table class="table table-boredered">
                    <tr>
                      <td class="border">Sent at</td>
                      <td class="border">${dataCartDokter[i].sent_at}</td>
                    </tr>
                    <tr>
                      <td class="border">Expedition</td>
                      <td class="border">${dataCartDokter[i].expedition_id}</td>
                    </tr>
                    <tr>
                      <td class="border">Receipt Number</td>
                      <td class="border">${dataCartDokter[i].recepient_number}</td>
                    </tr>
                    <tr>
                      <td class="border">Shipping Cost</td>
                      <td class="border">IDR ${dataCartDokter[i].shipping_cost}</td>
                    </tr>
                    <tr>
                      <td class="border">Sent by</td>
                      <td class="border">${dataCartDokter[i].sent_by}</td>
                    </tr>
                  </table>
                  <span type="button" class="btn btn-block btn-outline-primary" onclick="EditSentButton(${i})">Edit Sent Infomartion</span>
                </div>
              </div>
          `

          let checkNominal = `
          <div class="card">
                <div class="card-body">
                <h5 style="font-weight: 600">Payment Information</h5>
                  <table class="table table-boredered">
                    <tr>
                      <td class="border">Paid at</td>
                      <td class="border">${dataCartDokter[i].paid_at}</td>
                    </tr>
                    <tr>
                      <td class="border">Paid status by</td>
                      <td class="border">${dataCartDokter[i].paid_by}</td>
                    </tr>
                    <tr>
                      <td class="border">Bank Name</td>
                      <td class="border">${dataCartDokter[i].paid_bank_name}</td>
                    </tr>
                    <tr>
                      <td class="border">Bank Account Name</td>
                      <td class="border">${dataCartDokter[i].paid_account_bank_name}</td>
                    </tr>
                  </table>
                  <button type="button" class="btn btn-block btn-outline-success" onclick="EditPaymentButton(${i})">Edit Payment Information</button>
                </div>
              </div>
          `
          document.querySelector(`#column_payment${i}`).innerHTML = checkNominal
        } else if (dataCartDokter[i].status == 4) {
          document.querySelector(`#span_status${i}`).innerHTML = `
          <span class="badge bg-danger text-wrap fs-2">
            Canceled
          </span>
          `

          document.querySelector(`#column_cancel${i}`).innerHTML = `
          <div class="card">
                <div class="card-body">
                  <h5 style="font-weight: 600">Cancel Information</h5>
                  <table class="table table-boredered table-responsive">
                    <tr>
                      <td class="border">Cancel at</td>
                      <td class="border">${dataCartDokter[i].cancel_at}</td>
                    </tr>
                    <tr>
                      <td class="border">Cancel by</td>
                      <td class="border">${dataCartDokter[i].cancel_by}</td>
                    </tr>
                    <tr>
                      <td class="border">Cancel Reason</td>
                      <td class="border">${dataCartDokter[i].cancel_reason}</td>
                    </tr>
                  </table>
                </div>
              </div>
          `
          document.querySelector(`#column_packing${i}`).innerHTML = ""
          document.querySelector(`#column_sent${i}`).innerHTML = ""
          document.querySelector(`#column_payment${i}`).innerHTML = ""
          document.querySelector(`#button-status-canceled${i}`).innerHTML = ""
          document.querySelector(`#button_status_update${i}`).innerHTML =""
        } else if (dataCartDokter[i].status == 5) {
          document.querySelector(`#span_status${i}`).innerHTML = `
          <span class="badge bg-success text-wrap fs-2">
            Paid
          </span>
          `
          document.querySelector(`#button_status_update${i}`).innerHTML = `
          <button class="btn btn-outline-success" id="payment_btn_modal" data-toggle="modal" data-target="#modalStepPayment${i}" onclick="clearModalPayment(${i})">
            Submit Payment
          </button> 
          `
          document.querySelector(`#column_packing${i}`).innerHTML = `
          <div class="card">
                <div class="card-body">
                  <h5 style="font-weight: 600">Packing Information</h5>
                  <table class="table table-boredered table-responsive">
                    <tr>
                      <td class="border">Packing at</td>
                      <td class="border">${dataCartDokter[i].packing_at}</td>
                    </tr>
                    <tr>
                      <td class="border">Packing by</td>
                      <td class="border">${dataCartDokter[i].packing_by}</td>
                    </tr>
                  </table>
                </div>
              </div>
          `

          document.querySelector(`#column_sent${i}`).innerHTML = `
          <div class="card">
                <div class="card-body">
                  <h5 style="font-weight: 600">Sent Information</h5>
                  <table class="table table-boredered">
                    <tr>
                      <td class="border">Sent at</td>
                      <td class="border">${dataCartDokter[i].sent_at}</td>
                    </tr>
                    <tr>
                      <td class="border">Expedition</td>
                      <td class="border">${dataCartDokter[i].expedition_id}</td>
                    </tr>
                    <tr>
                      <td class="border">Receipt Number</td>
                      <td class="border">${dataCartDokter[i].recepient_number}</td>
                    </tr>
                    <tr>
                      <td class="border">Shipping Cost</td>
                      <td class="border">IDR ${dataCartDokter[i].shipping_cost}</td>
                    </tr>
                    <tr>
                      <td class="border">Sent by</td>
                      <td class="border">${dataCartDokter[i].sent_by}</td>
                    </tr>
                  </table>
                  <span type="button" class="btn btn-block btn-outline-primary" onclick="EditSentButton(${i})">Edit Sent Infomartion</span>
                </div>
              </div>
          `
          var checkNominal = ""
          for (let j = 0; j < dataCartDokter[i]['step_payment'].length; j++) {
              const element = dataCartDokter[i]['step_payment'][j];
              checkNominal += `
              <div class="card">
                    <div class="card-body">
                      <h5 style="font-weight: 600">Payment Information</h5>
                      <table class="table table-boredered">
                        <tr>
                          <td class="border">Paid at</td>
                          <td class="border" id="paid_at_${i}_${j}">
                            <p>${element.paid_at}</p></td>
                        </tr>
                        <tr>
                          <td class="border">Paid status by</td>
                          <td class="border" id="paid_by_${i}_${j}">
                            <p>${element.paid_by}</p></td>
                        </tr>
                        <tr>
                          <td class="border">Bank Name</td>
                          <td class="border" id="paid_bank_name_${i}_${j}" >
                            <p>${element.paid_bank_name}</p></td>
                        </tr>
                        <tr>
                          <td class="border">Bank Account Name</td>
                          <td class="border" id="paid_account_name_${i}_${j}" ><p>${element.paid_account_bank_name}</p></td>
                        </tr>
                        <tr>
                        <td class="border">Nominal</td>
                        <td class="border" id="paid_nominal_${i}_${j}"> <p>IDR ${element.nominal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.')}</p></td>
                      </tr>
                      </table>
                      <button type="button" class="btn btn-block btn-outline-success" onclick="EditStepPaymentButton(${i}, ${j})">Edit Payment Information</button>
                    </div>
                  </div>
              `
          }
          document.querySelector(`#column_payment${i}`).innerHTML = checkNominal
        }
      }
    }

    function EditSentButton(key) {
      document.getElementById(`ekspedisi_select${key}`).value = dataCartDokter[key].expedition_id
      document.getElementById(`shipping_cost_input${key}`).value = dataCartDokter[key].shipping_cost_number
      document.getElementById(`receipt_number_input${key}`).value = dataCartDokter[key].recepient_number
      $(`#modalSent${key}`).modal("show")
    }

    function EditPaymentButton(key) {
      document.getElementById(`paid_at${key}`).value = dataCartDokter[key].paid_at
      document.getElementById(`bank_name${key}`).value = dataCartDokter[key].paid_bank_name
      document.getElementById(`bank_account_name${key}`).value = dataCartDokter[key].paid_account_bank_name
      document.getElementById(`nominal_payment_input${key}`).value = dataCartDokter[key].nominal_number
      $(`#modalPayment${key}`).modal("show")
    }

    function EditStepPaymentButton(key, index) {
      console.log({key, index})
      document.getElementById(`step_paid_at${key}`).value = dataCartDokter[key]['step_payment'][index].paid_at
      document.getElementById(`step_bank_name${key}`).value = dataCartDokter[key]['step_payment'][index].paid_bank_name
      document.getElementById(`step_bank_account_name${key}`).value = dataCartDokter[key]['step_payment'][index].paid_account_bank_name
      document.getElementById(`nominal_step_payment_input${key}`).value = dataCartDokter[key]['step_payment'][index].nominal_number
      document.getElementById(`key_step_payment${key}`).value = index
      $(`#modalStepPayment${key}`).modal("show")
    }

    function UpdateStatus(id, key) {
      var select_id = document.getElementById(`status_select${key}`).value
      var objectStatus = {}
      if (select_id == "0") {
      objectStatus = {
          updated_by: user.name,
          status: select_id,
        }
      } else if(select_id == "1") {
        objectStatus = {
          updated_by: user.name,
          status: select_id,
          packing_by: user.name
        }
      } else if(select_id == "2") {
        objectStatus = {
          updated_by: user.name,
          status: select_id,
          sent_by: user.name
        }
      }
      console.log({
        id: id,
        ...objectStatus,
      })
      $.ajax({
        type: "POST",
        url: "{{url('/')}}"+"/updateStatus",
        data: { "_token": "{{ csrf_token() }}", data: {
          id: id,
          ...objectStatus,
        }},
        beforeSend: $.LoadingOverlay("show"),
        afterSend:$.LoadingOverlay("hide"),
        success: function (data) {
          if(data.message=="sukses"){
            $(`#modalEditStatus${key}`).modal("hide")
            dataCartDokter[key]['status'] = select_id
            checkForButtonStatus()
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
    }

    function ExtraCharge(id, key) {
      var desc = $(`#extra_charge_desc${key}`).val()
      var price = $(`#extra_charge_price${key}`).val()
      price = Number(price)
      $.ajax({
        type: "POST",
        url: "{{url('/')}}"+"/addExtraCharge",
        data: { "_token": "{{ csrf_token() }}", data: {
          transaction_id: id,
          description: desc,
          price: price,
          // total_price: 
        }},
        beforeSend: $.LoadingOverlay("show"),
        afterSend:$.LoadingOverlay("hide"),
        success: function (data) {
          if(data.message=="sukses"){
            $(`#modalExtraCharge${key}`).modal("hide")
            dataCartDokter[key]['extra_charge'].push({
              transaction_id: id,
              description: desc,
              price: price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.'),
            })
            refreshTableExtraCharge(key, dataCartDokter[key]['total_price'], price)
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
    }

    function refreshTableExtraCharge(key, total_price, extra_charge) {
      let divExtraCharge = ""
      console.log({dataCartDokter: dataCartDokter[key]})
      document.querySelector(`#t-foot${key}`).innerHTML = null
      for (let i = 0; i < dataCartDokter[key]['extra_charge'].length; i++) {
        console.log({total_price, extra_charge })
        divExtraCharge += `
        <tr>
          <td colspan="4">
            <div class="d-flex justify-content-end">
              <p class="fw-bold"> 
                Extra Charge:
              </p>
            </div>
          </td>
          <td>
            IDR ${dataCartDokter[key]['extra_charge'][i].price}
          </td>
        </tr>`
      }

      
      total = Number(total_price) + Number(extra_charge)
      console.log({total})
      total = total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.')
      divExtraCharge += `
      <tr>
        <td colspan="4">
          <div class="d-flex justify-content-end">
            <p class="fw-bold">
              Grand Total: 
            </p>
          </div>
        </td>
        <td>
          <div id="grand_total${key}">
            IDR ${total}
          </div>
        </td>
        </tr>`
      console.log(divExtraCharge)
      document.querySelector(`#t-foot${key}`).innerHTML = divExtraCharge
    }

    function SentButton(id, key) {
      var ekspedisi = $(`#ekspedisi_select${key}`).val()
      var shippingCost = $(`#shipping_cost_input${key}`).val()
      var receipt_number_input = $(`#receipt_number_input${key}`).val()
      $.ajax({
        type: "POST",
        url: "{{url('/')}}"+"/sentPO",
        data: { "_token": "{{ csrf_token() }}", data: {
          status: 2,
          expedition_id: ekspedisi,
          shipping_cost: shippingCost,
          recepient_number: receipt_number_input,
          id: id,
        }},
        beforeSend: $.LoadingOverlay("show"),
        afterSend:$.LoadingOverlay("hide"),
        success: function (data) {
          if(data['message']=="sukses"){
            dataCartDokter[key]['expedition_id'] = ekspedisi
            dataCartDokter[key]['recepient_number'] = receipt_number_input
            dataCartDokter[key]['shipping_cost'] = data['shipping_cost']
            dataCartDokter[key]['sent_by'] = data['sent_by']
            dataCartDokter[key]['sent_at'] = data['sent_at']
            dataCartDokter[key].status = 2
            $(`#modalSent${key}`).modal("hide")
            checkForButtonStatus()
            AlertSuccess()
          }else if(data['message']!='gagal'|| data['message']!="gagal2"){
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
    }

    function PaymentButton(id, key) {
      /*
      One Payment => 0
      Step Payment => 1
      */
      var paid_at = $(`#paid_at${key}`).val();
      var bank_name = $(`#bank_name${key}`).val();
      var bank_account_name = $(`#bank_account_name${key}`).val();
      var nominal_payment_input = $(`#nominal_payment_input${key}`).val();
      var nominal_input = document.getElementById(`container_nominal_input${key}`);
      var status_payment = 0
      var status = 3
      if(nominal_input.style.display == "none") {
        nominal_payment_input = 0
        status_payment = 1
        status = 5
      }
      $.ajax({
        type: "POST",
        url: "{{url('/')}}"+"/paymentOrder",
        data: { "_token": "{{ csrf_token() }}", data: {
          status: status,
          paid_at: paid_at,
          paid_bank_name: bank_name,
          paid_account_bank_name: bank_account_name,
          nominal: nominal_payment_input,
          id:id,
          status_payment: status_payment,
        }},
        beforeSend: $.LoadingOverlay("show"),
        afterSend:$.LoadingOverlay("hide"),
        success: function (data) {
          if(data['message']=="sukses"){
            dataCartDokter[key]['paid_bank_name'] = bank_name
            dataCartDokter[key]['paid_account_bank_name'] = bank_account_name
            dataCartDokter[key]['nominal'] = data['nominal']
            dataCartDokter[key]['paid_by'] = data['paid_by']
            dataCartDokter[key]['paid_at'] = data['paid_at']
            dataCartDokter[key].status = status
            $(`#modalPayment${key}`).modal("hide")
            checkForButtonStatus()
            AlertSuccess()
          }else if(data['message']!='gagal'|| data['message']!="gagal2"){
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
    }

    function StepPayment(id, key) {
      var indexEdit = document.getElementById(`key_step_payment${key}`).value;
      var paid_at = $(`#step_paid_at${key}`).val();
      var bank_name = $(`#step_bank_name${key}`).val();
      var bank_account_name = $(`#step_bank_account_name${key}`).val();
      var nominal_payment_input = $(`#nominal_step_payment_input${key}`).val();
      var status_payment = 1
      var paid_at_before = dataCartDokter[key]['paid_at']
      var paid_bank_name_before = dataCartDokter[key]['paid_bank_name']
      var paid_account_bank_name_before = dataCartDokter[key]['paid_account_bank_name']
      var nominal_before = dataCartDokter[key]['nominal']
      var paid_by_before = dataCartDokter[key]['paid_by']
      console.log({indexEdit})
      if (!indexEdit) {
        // add with status payment 1
        var paid_at_after = paid_at_before + "|" +paid_at
        var bank_name_after = paid_bank_name_before + "|" +bank_name
        var bank_account_name_after = paid_account_bank_name_before + "|" +bank_account_name
        var nominal_after = nominal_before + "|" + nominal_payment_input
        var paid_by_after = paid_by_before + "|" + user.name
        console.log({
          dataBefore: {
            status: 5,
            paid_at: paid_at,
            paid_bank_name: bank_name,
            paid_account_bank_name: bank_account_name,
            nominal: nominal_payment_input,
            id:id,
            status_payment: status_payment,
            paid_at_before: dataCartDokter[key]['paid_at'],
            paid_bank_name_before: dataCartDokter[key]['paid_bank_name'],
            paid_account_bank_name_before: dataCartDokter[key]['paid_account_bank_name'],
            nominal_before: dataCartDokter[key]['nominal'],
            paid_by_before: dataCartDokter[key]['paid_by'],
            indexEdit,
            paid_by: paid_by_after,
          }
        })
        $.ajax({
        type: "POST",
          url: "{{url('/')}}"+"/stepPaymentOrder",
          data: { "_token": "{{ csrf_token() }}", data: {
            status: 5,
            paid_at: paid_at_after,
            paid_bank_name: bank_name_after,
            paid_account_bank_name: bank_account_name_after,
            nominal: nominal_after,
            paid_by: paid_by_after,
            id:id,
          }},
          beforeSend: $.LoadingOverlay("show"),
          afterSend:$.LoadingOverlay("hide"),
          success: function (data) {
            console.log({data})
            if(data['message']=="sukses"){
              let obj = {
                paid_by: user.name,
                paid_at: paid_at,
                paid_bank_name: bank_name,
                paid_account_bank_name: bank_account_name,
                nominal: nominal_payment_input
              }
              dataCartDokter[key]['step_payment'].push(obj)
              // dataCartDokter[key]['paid_bank_name'] = bank_name
              // dataCartDokter[key]['paid_account_bank_name'] = bank_account_name
              // dataCartDokter[key]['nominal'] = data['nominal']
              // dataCartDokter[key]['paid_by'] = data['paid_by']
              // dataCartDokter[key]['paid_at'] = data['paid_at']
              dataCartDokter[key].status = 5
              $(`#modalStepPayment${key}`).modal("hide")
              checkForButtonStatus()
              AlertSuccess()
            }else if(data['message']!='gagal'|| data['message']!="gagal2"){
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
      } else {
        // edit with status payment 1

        // dataCartDokter[key]['step_payment'][indexEdit].paid_at = paid_at
        // dataCartDokter[key]['step_payment'][indexEdit].bank_name = bank_name
        // dataCartDokter[key]['step_payment'][indexEdit].bank_account_name = bank_account_name
        // dataCartDokter[key]['step_payment'][indexEdit].nominal = nominal_payment_input
        console.log({data: dataCartDokter[key]['step_payment'][indexEdit]})
        var paidSplit = paid_at_before.split("|")
        var paidBankNameSplit = paid_bank_name_before.split("|")
        var paidAccountBankNameSplit = paid_account_bank_name_before.split("|")
        var paidNominalSplit = nominal_before.split("|")
        var paidBySplit = paid_by_before.split("|")
        paidSplit[indexEdit] = paid_at
        paidBankNameSplit[indexEdit] = bank_name
        paidAccountBankNameSplit[indexEdit] = bank_account_name
        paidNominalSplit[indexEdit] = nominal_payment_input
        paidBySplit[indexEdit] = user.name
        paidSplit = paidSplit.join('|')
        paidBankNameSplit = paidBankNameSplit.join('|')
        paidAccountBankNameSplit = paidAccountBankNameSplit.join('|')
        paidNominalSplit = paidNominalSplit.join('|')
        paidBySplit = paidBySplit.join('|')
        console.log({split: {
          paidSplit,paidBankNameSplit,paidAccountBankNameSplit,paidNominalSplit,paidBySplit
        }})
        $.ajax({
        type: "POST",
          url: "{{url('/')}}"+"/editStepPaymentOrder",
          data: { "_token": "{{ csrf_token() }}", data: {
            id:id,
            status: 5,
            paid_at: paidSplit,
            paid_bank_name: paidBankNameSplit,
            paid_account_bank_name: paidAccountBankNameSplit,
            nominal: paidNominalSplit,
            paid_by: paidBySplit,
          }},
          beforeSend: $.LoadingOverlay("show"),
          afterSend:$.LoadingOverlay("hide"),
          success: function (data) {
            if(data['message']=="sukses"){
              dataCartDokter[key]['step_payment'][indexEdit].paid_at = paid_at
              dataCartDokter[key]['step_payment'][indexEdit].paid_bank_name = bank_name
              dataCartDokter[key]['step_payment'][indexEdit].paid_account_bank_name = bank_account_name
              dataCartDokter[key]['step_payment'][indexEdit].nominal = nominal_payment_input
              console.log(dataCartDokter[key]['step_payment'][indexEdit])

              // document.querySelector(`#paid_at_${key}_${indexEdit}`).innerHTML = `<p>${paid_at}</p>`
              // document.querySelector(`#paid_by_${key}_${indexEdit}`).innerHTML = `<p>${user.name}</p>`
              // document.querySelector(`#paid_bank_name_${key}_${indexEdit}`).innerHTML = `<p>${bank_name}</p>`
              // document.querySelector(`#paid_account_name_${key}_${indexEdit}`).innerHTML = `<p>${bank_account_name}</p>`
              // document.querySelector(`#paid_nominal_${key}_${indexEdit}`).innerHTML = `<p>IDR ${nominal_payment_input.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.')}</p>`
              dataCartDokter[key].status = 5
              $(`#modalStepPayment${key}`).modal("hide")
              checkForButtonStatus()
              AlertSuccess()
            }else if(data['message']!='gagal'|| data['message']!="gagal2"){
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
      }
    }

    function CancelButton(id, key) {
      var cancel_reason = $(`#cancel_reason${key}`).val()
        $.ajax({
        type: "POST",
        url: "{{url('/')}}"+"/canceledPO",
        data: { "_token": "{{ csrf_token() }}", data: {
          status: 4,
          cancel_reason: cancel_reason,
          id:id,
        }},
        beforeSend: $.LoadingOverlay("show"),
        afterSend:$.LoadingOverlay("hide"),
        success: function (data) {
          if(data=="sukses"){
            $(`#modalCancel${key}`).modal("hide")
            dataCartDokter[key].status = 4
            checkForButtonStatus()
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
    }

    function packing_btn(id, key) {
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
            id:id,
          }},
          beforeSend: $.LoadingOverlay("show"),
          afterSend:$.LoadingOverlay("hide"),
          success: function (data) {
            if(data.message=="sukses"){
              dataCartDokter[key].status = 1
              dataCartDokter[key]['packing_by'] = data['packing_by']
              dataCartDokter[key]['packing_at'] = data['packing_at']
              checkForButtonStatus()
              AlertSuccess()
            }else if(data.message !='gagal'|| data.message !="gagal2"){
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
      })
    }

</script>
    
@endpush