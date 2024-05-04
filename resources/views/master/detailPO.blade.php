@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Detail Transaction</h1>
@stop

@section('content')
    <div class="card">
      <div class="card-header">
        <h5 style="font-weight: 600">Dokter</h5>
        <p style="text-align: end">
          <a class="btn btn-primary" onclick="printPDF('{{ url('generate-pdf-all-dokter/'.$dokter['ids'].'/'.$params['start_date'].'/'.$params['end_date'].'/'.$params['status']) }}');">
            Print ALL
          </a>
        </p>
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
    @foreach ($dataCartDokter as $key => $itemDokter)

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
                      <p class="text-start">{{ $itemDokter->inv_no }}</p>
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
                      <div id="span-edit-status{{ $key }}">
                      @if ($user['role'] == "superuser" || $user['role'] == "finance" || $user['role'] == "admin")
                        <span class="p-2">
                            <button class="btn btn-light" data-toggle="modal" data-target="#modalEditStatus{{ $key }}">Edit Status</button>
                        </span>
                      @endif
                      </div>
                      @endif
                    </div>
                    <div class="col" style="text-align: right">
                      
                      <a class="btn btn-primary" onclick="printPDF('{{ route('generate.pdf.one.encrypt', ['ids'=>$itemDokter['id_encrypt']]) }}');">
                        Print
                      </a>
                    </div>
                  </div>
                  <br>
                  <div class="d-flex justify-content-end">
                    <div>
                      <div class="row">
                        <div class="col-sm-12 col-md-6">
                          <div class="p-2" id="button-status-canceled{{ $key }}">
                            @if ($user['role'] == "superuser" || $user['role'] == "finance" || $user['role'] == "admin")
                              <button class="btn me-3 btn-outline-danger" id="cancel_status_btn" data-toggle="modal" data-target="#modalCancel{{ $key }}">
                                  Cancel Purchase Order
                              </button>
                            @endif
                          </div>
                          
                        </div>
                        <div class="col-sm-12 col-md-6">
                          <div class="p-2" id="button_status_update{{ $key }}">
                          </div>
                        </div>
                      </div>
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
                <div class="form-group" id="table-product{{ $key }}">
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
                                Total Paid: 
                              </p>
                            </div>
                          </td>
                          <td id="grand-total-paid{{ $key }}">
                            <div>
                              - IDR {{ $itemDokter['total_paid'] }}
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="4">
                            <div class="d-flex justify-content-end">
                              <p class="fw-bold">
                                Grand Total: 
                              </p>
                            </div>
                          </td>
                          <td id="total_paid_sum_div{{ $key }}">
                            <div>
                              IDR {{ $itemDokter['total_paid_sum'] }}
                            </div>
                          </td>
                        </tr>
                      </div>
                    </tfoot>
                  </table>
                  <div class="d-flex justify-content-end" id="button-extra-charge{{ $key }}">
                  @if ($user['role'] == "superuser" || $user['role'] == "finance" || $user['role'] == "admin")
                    <button class="btn btn-outline-success" data-target="#modalExtraCharge{{ $key }}" data-toggle="modal">
                    Add Extra Charges
                    </button>
                  @endif
                  </div>
                  <div class="form-group">
                    <label for="notes_form">Note For Admin</label>
                    <p class="text-start">{{ $itemDokter->notes }}</p>
                  </div>
                  <div class="form-group" id="button-edit-product{{ $key }}">
                  @if ($user['role'] == "superuser" || $user['role'] == "admin")
                    <button class="btn me-3 btn-outline-success" id="edit_product{{ $key }}" onclick="EditProductShow({{ $key }})">
                    Edit Product
                    </button>
                  @endif
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
                <div id="column_payment{{ $key }}"></div>
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
                <input type="nama_update" class="form-control" id="cancel_reason{{ $key }}"  placeholder="Masukkan Reason" required>
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
                <input type="text" class="form-control" id="extra_charge_desc{{ $key }}"  placeholder="description" required>
              </div>
              <div class="form-group p-2">
                <label for="extra_charge">Price *</label>
                <input type="text" class="form-control" id="extra_charge_price{{ $key }}"  placeholder="price" oninput="addDotPrice(this)" required>
              </div>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="clearModalExtraCharge({{ $key }})">Close</button>
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
                <label for="category_product_add">Category Kurir</label>
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
                <input type="receipt-number" class="form-control" id="receipt_number_input{{ $key }}"  placeholder="Masukkan Receipt Number" required>
              </div>
              <div class="form-group">
                <label for="shipping-cost">Shipping Cost</label>
                <div class="input-group mb-3">
                  <span class="input-group-text" id="basic-addon1">IDR</span>
                  <input type="text" class="form-control" placeholder="Masukan Cost" aria-label="Username" aria-describedby="basic-addon1" value="" id="shipping_cost_input{{ $key }}" oninput="addDotPrice(this)" required>
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

    <!-- Modal Sent-->
    <div class="modal fade" id="modalEditSent{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="modalUpdateTitle" aria-hidden="true">
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
                <label for="category_product_add">Category Kurir</label>
                <div id="dropadd" name="dropadd" class="form-group">
                  <select class="form-select form-control" id="ekspedisi_edit_select{{ $key }}">
                    @foreach($dataEkspedisi as $item)
                      <option value={{$item->id}}>{{$item->name}}</option>
                    @endforeach
                  </select> 
                </div>
              </div>
              <div class="form-group">
                <label for="receipt-number">Receipt Number</label>
                <input type="receipt-number" class="form-control" id="receipt_edit_number_input{{ $key }}"  placeholder="Masukkan Receipt Number" required>
              </div>
              <div class="form-group">
                <label for="shipping-cost">Shipping Cost</label>
                <div class="input-group mb-3">
                  <span class="input-group-text" id="basic-addon1">IDR</span>
                  <input type="text" class="form-control" placeholder="Masukan Cost" aria-label="Username" aria-describedby="basic-addon1" value="" id="shipping_edit_cost_input{{ $key }}" oninput="addDotPrice(this)" required>
                </div>
              </div>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" id="sent_btn{{ $key }}" class="btn btn-primary" onclick="EditApiSentButton({{ $itemDokter->id }}, {{ $key }})">Save changes</button>
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
                <div id="dropaddstatus{{ $key }}" name="dropadd" class="form-group">
                  <select class="form-select form-control" id="status_select{{ $key }}" required>
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
                <input type="date" class="form-control" id="paid_at{{ $key }}"  placeholder="Masukkan Tanggal Pembayaran" required>
              </div>
              <div class="form-group">
                <label for="bank_name">Bank Name *</label>
                <input type="text" class="form-control" id="bank_name{{ $key }}"  placeholder="Masukkan Bank Name" required>
              </div>
              <div class="form-group">
                <label for="bank_account_name">Bank Account Name *</label>
                <input type="text" class="form-control" id="bank_account_name{{ $key }}"  placeholder="Masukkan Account Bank Name" required>
              </div>
              <div class="form-group" style="display: none" id="container_nominal_input{{ $key }}">
                <label for="shipping-cost">Nominal *</label>
                <div class="input-group mb-3">
                  <span class="input-group-text" id="basic-addon1">IDR</span>
                  <input type="text" class="form-control" placeholder="Masukan Nominal" aria-label="Nominal" aria-describedby="basic-addon1" value="" id="nominal_payment_input{{ $key }}" oninput="SetInputStepPayment(event, {{ $key }})" required>
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

    <!-- Modal Edit Payment-->
    <div class="modal fade" id="modalEditPayment{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="modalUpdateTitle" aria-hidden="true">
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
              </div>
              <div class="form-group">
                <label for="paid_at">Paid at *</label>
                <input type="date" class="form-control" id="edit_paid_at{{ $key }}"  placeholder="Masukkan Tanggal Pembayaran" required>
              </div>
              <div class="form-group">
                <label for="bank_name">Bank Name *</label>
                <input type="text" class="form-control" id="edit_bank_name{{ $key }}"  placeholder="Masukkan Bank Name" required>
              </div>
              <div class="form-group">
                <label for="bank_account_name">Bank Account Name *</label>
                <input type="text" class="form-control" id="edit_bank_account_name{{ $key }}"  placeholder="Masukkan Account Bank Name" required>
              </div>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="clearModalPayment({{ $key }})">Close</button>
            <button type="button" id="payment_btn{{ $key }}" class="btn btn-primary" onclick="EditPaymentButton({{ $itemDokter->id }}, {{ $key }})">Save changes</button>
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
            <h5 class="modal-title" id="exampleModalLongTitle">Step Payment Form</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="formUpdate" role="form">
            <div class="modal-body">
              {{-- <input type="hidden" id="key_step_payment{{ $key }}" value=""> --}}
              <div>
                <button type="button" id="step_payment{{ $key }}" class="btn btn-primary" onclick="StepPayment({{ $key }})">Step Payment</button>
              </div>
              <div class="form-group">
                <label for="paid_at">Paid at *</label>
                <input type="date" class="form-control" id="step_paid_at{{ $key }}"  placeholder="Masukkan Tanggal Pembayaran" required>
              </div>
              <div class="form-group">
                <label for="bank_name">Bank Name *</label>
                <input type="text" class="form-control" id="step_bank_name{{ $key }}"  placeholder="Masukkan Bank Name" required>
              </div>
              <div class="form-group">
                <label for="bank_account_name">Bank Account Name *</label>
                <input type="text" class="form-control" id="step_bank_account_name{{ $key }}"  placeholder="Masukkan Account Bank Name" required>
              </div>
              <div class="form-group" id="container_step_nominal_input{{ $key }}">
                <label for="shipping-cost">Nominal *</label>
                <div class="input-group mb-3">
                  <span class="input-group-text" id="basic-addon1">IDR</span>
                  <input type="text" class="form-control" placeholder="Masukan Nominal" aria-label="Nominal" aria-describedby="basic-addon1" id="nominal_step_payment_input{{ $key }}" oninput="SetInputStepPayment(event, {{ $key }})" max="{{ $itemDokter['total_paid_sum'] }}">
                </div>
              </div>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="clearModalPayment({{ $key }})">Close</button>
            <button type="button" id="payment_btn{{ $key }}" class="btn btn-primary" type="submit" onclick="StepPayment({{ $itemDokter->id }}, {{ $key }})">Save changes</button>
          </div>
        </form>
        </div>
      </div>
    </div>

    <!-- Modal Edit Step Payment-->
    <div class="modal fade" id="modalEditStepPayment{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="modalUpdateTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Step Payment Form</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="formUpdate" role="form">
            <div class="modal-body">
              <input type="hidden" id="key_edit_step_payment{{ $key }}" value="">
              <div>
                <button type="button" id="step_payment{{ $key }}" class="btn btn-primary">Step Payment</button>
              </div>
              <div class="form-group">
                <label for="paid_at">Paid at *</label>
                <input type="date" class="form-control" id="step_edit_paid_at{{ $key }}"  placeholder="Masukkan Tanggal Pembayaran" required>
              </div>
              <div class="form-group">
                <label for="bank_name">Bank Name *</label>
                <input type="text" class="form-control" id="step_edit_bank_name{{ $key }}"  placeholder="Masukkan Bank Name" required>
              </div>
              <div class="form-group">
                <label for="bank_account_name">Bank Account Name *</label>
                <input type="text" class="form-control" id="step_edit_bank_account_name{{ $key }}"  placeholder="Masukkan Account Bank Name" required>
              </div>
              <div class="form-group" id="container_step_nominal_input{{ $key }}">
                <label for="shipping-cost">Nominal *</label>
                <div class="input-group mb-3">
                  <span class="input-group-text" id="basic-addon1">IDR</span>
                  <input type="text" class="form-control" placeholder="Masukan Nominal" aria-label="Nominal" aria-describedby="basic-addon1" id="nominal_edit_step_payment_input{{ $key }}" oninput="SetInputEditStepPayment(event, {{ $key }})" required>
                </div>
              </div>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="clearModalPayment({{ $key }})">Close</button>
            <button type="button" id="payment_btn{{ $key }}" class="btn btn-primary" type="submit" onclick="EditStepPayment({{ $itemDokter->id }}, {{ $key }})">Save changes</button>
          </div>
        </form>
        </div>
      </div>
    </div>

    <!-- Modal Edit Product-->
    <div class="modal fade" id="modalEditProduct{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="modalUpdateTitle" aria-hidden="true">
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
              @foreach ($itemDokter['products'] as $keyProduct => $itemProduct)
                <div id="body-product{{ $key }}-{{ $keyProduct }}" class="input-group">
                  <div class="d-inline-flex p-2">
                    <div id="name-product">
                      <span class="input-group-text">Name</span>
                      <span class="input-group-text">{{ $itemProduct['name_product'] }}</span>
                    </div>
                    <div>
                      <span class="input-group-text">Stok</span>
                      <input type="number" class="form-control" id="productQty-{{ $key }}-{{ $keyProduct }}"  aria-describedby="inputGroupPrepend2" required value="{{ $itemProduct['qty'] }}" min="0" oninput="upperZero(this,0);">
                    </div>
                    <div>
                      <span class="input-group-text">Discount</span>
                      <input type="number" class="form-control" id="productDiscount-{{ $key }}-{{ $keyProduct }}"  aria-describedby="inputGroupPrepend2" required value="{{ $itemProduct['disc'] }}" min="0" oninput="upperZero(this,100);">
                    </div>
                  </div>
                </div>
                @endforeach
              <span>Extra Charge</span>
              <div id="extra-charge-edit-product{{ $key }}">
              </div>

            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" id="payment_btn{{ $key }}" class="btn btn-primary" onclick="EditProduct({{ $itemDokter->id }}, {{ $key }},'{{$itemDokter->po_id}}')">Save changes</button>
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

function printPDF(pdfUrl) {
        var win = window.open(pdfUrl);
        win.onload = function() {
            win.print();
        };
    }

function upperZero(input,max) {
      input.value = input.value.replace(/[^0-9]/g, '')
      if (input.value.charAt(0) === '0' && input.value.length !=1) {
        input.value = input.value.slice(1);
      }
      if (input.value < 0 || input.value=="") {
          input.value = 0
      }else if(input.value>max && max !=0){
        input.value=max
      }
        
    };

    // const Swal = require('sweetalert2');
    dokter = @json($dokter);
    user = @json($user);
    dataCartDokter = @json($dataCartDokter);
    
    dataEkspedisi = @json($dataEkspedisi);
    extraChargeAll = @json($extraChargeAll);

    productAwal = @json($dataCartDokter);

    
    window.onload = function() {
      checkForButtonStatus()
      console.log(productAwal)
    };

    function addDotPrice(input) {
      
      input.value = input.value.replace(/[^0-9]/g, '')
      
      if (input.value > 3) {
            input.value = input.value.replace(/(\d)(?=(\d{3})+$)/g, '$1.');
          }
    }

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

    function clearStepModalPayment(key) {
      document.getElementById(`step_paid_at${key}`).value = '';
      document.getElementById(`step_bank_name${key}`).value = '';
      document.getElementById(`step_bank_account_name${key}`).value = '';
      document.getElementById(`nominal_step_payment_input${key}`).value = '';
    }

    function clearEditStepModalPayment(key) {
      document.getElementById(`step_edit_paid_at${key}`).value = '';
      document.getElementById(`step_edit_bank_name${key}`).value = '';
      document.getElementById(`step_edit_bank_account_name${key}`).value = '';
      document.getElementById(`nominal_edit_step_payment_input${key}`).value = '';
    }

    function StepPaymentToggle(key) {
      var x = document.getElementById(`container_nominal_input${key}`);
      x.style.display = "block"
    }

    function SetInputStepPayment(e, key) {
      e.target.value = e.target.value.replace(/[^0-9]/g, '')      
      let val = e.target.value;
      
      if(dataCartDokter[key]['total_num_paid_sum'] < Number(val)) {
        val = dataCartDokter[key]['total_num_paid_sum'] + ""
        e.target.value = val.toString().replace(/(\d)(?=(\d{3})+$)/g, '$1.');
        return
      }

      if(e.target.value > 3) {
        e.target.value = val.toString().replace(/(\d)(?=(\d{3})+$)/g, '$1.');
      }
    }

    function SetInputEditStepPayment(e, key) {
      e.target.value = e.target.value.replace(/[^0-9]/g, '')
      
      if(e.target.value > 3) {
        let val = e.target.value;
        val = val.split(".").join("")
        let indexEdit = document.getElementById(`key_edit_step_payment${key}`).value
  
        let num = 0
        for (let i = 0; i < dataCartDokter[key]['step_payment'].length; i++) {
          const element = dataCartDokter[key]['step_payment'][i];
          if(i != indexEdit) {
            num += Number(element['nominal'])
          }
        }
  
        let sum = num + Number(val)
        if(dataCartDokter[key]['total_price'] < sum) {
          val = dataCartDokter[key]['total_price'] - num
        } 
        e.target.value = val.toString().replace(/(\d)(?=(\d{3})+$)/g, '$1.')
      }
      
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
          

          if (user['role'] == "superuser" || user['role'] == "finance" || user['role'] == "admin") {
            document.querySelector(`#button_status_update${i}`).innerHTML = `
            <button type="button" class="btn btn-outline-warning" id="packing_btn" onclick="packing_btn(${dataCartDokter[i].id}, ${i})">
            Packing Purchase Order
            </button> 
            `
          }

          document.querySelector(`#dropaddstatus${i}`).innerHTML = `
          <select class="form-select form-control" id="status_select${i}" required>
            <option value="0" selected>SUBMITED</option>
          </select>
          `

          if (user['role'] == "superuser" || user['role'] == "finance" || user['role'] == "admin") {
            document.querySelector(`#button-status-canceled${i}`).innerHTML = `
            <button class="btn me-3 btn-outline-danger" id="cancel_status_btn" data-toggle="modal" data-target="#modalCancel${i}">
              Cancel Purchase Order
            </button>
            `
          }

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

          if (user['role'] == "superuser" || user['role'] == "finance" || user['role'] == "admin") {
            document.querySelector(`#button_status_update${i}`).innerHTML = `
            <button class="btn btn-outline-info" id="sent_btn_modal" data-toggle="modal" data-target="#modalSent${i}">
            Sent Order
            </button> `
          }

          document.querySelector(`#dropaddstatus${i}`).innerHTML = `
          <select class="form-select form-control" id="status_select${i}" required>
            <option value="0" id="">SUBMITED</option>
            <option value="1" selected>PACKING</option>
          </select>
          `

          if (user['role'] == "superuser" || user['role'] == "finance" || user['role'] == "admin") {
            document.querySelector(`#button-status-canceled${i}`).innerHTML = `
            <button class="btn me-3 btn-outline-danger" id="cancel_status_btn" data-toggle="modal" data-target="#modalCancel${i}">
              Cancel Purchase Order
            </button>
            `
          }

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

          if(user['role'] == "superuser" || user['role'] == "finance" || user['role'] == "admin") {
            document.querySelector(`#button_status_update${i}`).innerHTML = `
            <button class="btn btn-outline-success" id="payment_btn_modal" data-toggle="modal" data-target="#modalPayment${i}" onclick="clearModalPayment(${i})">
            Submit Payment
            </button>`
          }

          document.querySelector(`#dropaddstatus${i}`).innerHTML = `
          <select class="form-select form-control" id="status_select${i}" required>
            <option value="0">SUBMITED</option>
            <option value="1">PACKING</option>
            <option value="2" selected>SENT</option>
          </select>
          `
          if (user['role'] == "superuser" || user['role'] == "finance" || user['role'] == "admin") {
            document.querySelector(`#button-status-canceled${i}`).innerHTML = `
            <button class="btn me-3 btn-outline-danger" id="cancel_status_btn" data-toggle="modal" data-target="#modalCancel${i}">
              Cancel Purchase Order
            </button>
            `
          }

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
        
          if(user['role'] == "superuser" || user['role'] == "finance" || user['role'] == "admin") {
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
                          <td class="border">IDR ${dataCartDokter[i].shipping_cost.replace(/(\d)(?=(\d{3})+$)/g, '$1.')}</td>
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
          } else {
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
                          <td class="border">IDR ${dataCartDokter[i].shipping_cost.replace(/(\d)(?=(\d{3})+$)/g, '$1.')}</td>
                        </tr>
                        <tr>
                          <td class="border">Sent by</td>
                          <td class="border">${dataCartDokter[i].sent_by}</td>
                        </tr>
                      </table>
                    </div>
                  </div>
              `
          }
        } else if (dataCartDokter[i].status == 3) {
          document.querySelector(`#span_status${i}`).innerHTML = `
          <span class="badge bg-success text-wrap fs-2">
            Paid (Completed)
          </span>
          `
          let queryStatus = document.querySelector(`#button_status_update${i}`)
          if(queryStatus) {
            queryStatus.innerHTML = ""
          }

          let queryStatusEdit = document.querySelector(`#span-edit-status${i}`)
          if(queryStatusEdit) {
            queryStatusEdit.innerHTML = ""
          }

          let queryCancel = document.querySelector(`#button-status-canceled${i}`)
          if(queryCancel) {
            queryCancel.innerHTML = ""
          }

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

          document.querySelector(`#dropaddstatus${i}`).innerHTML = `
          <select class="form-select form-control" id="status_select${i}" required>
            <option value="0">SUBMITED</option>
            <option value="1">PACKING</option>
            <option value="2">SENT</option>
            <option value="3" selected>PAID</option>
          </select>
          `

          if(user['role'] == "superuser" || user['role'] == "finance" || user['role'] == "admin") {
              let edit_product_button = document.querySelector(`#button-edit-product${i}`)
              if(edit_product_button) {
                edit_product_button.innerHTML = ""
              }

              let extra_charge_button = document.querySelector(`#button-extra-charge${i}`)
              if(extra_charge_button) {
                extra_charge_button.innerHTML = ""
              }

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
                          <td class="border">IDR ${dataCartDokter[i].shipping_cost.replace(/(\d)(?=(\d{3})+$)/g, '$1.')}</td>
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
          } else {
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
                          <td class="border">IDR ${dataCartDokter[i].shipping_cost.replace(/(\d)(?=(\d{3})+$)/g, '$1.')}</td>
                        </tr>
                        <tr>
                          <td class="border">Sent by</td>
                          <td class="border">${dataCartDokter[i].sent_by}</td>
                        </tr>
                      </table>
                    </div>
                  </div>
              `
          }

          let checkNominal = ``
          if (user['role'] == "superuser" || user['role'] == "finance" || user['role'] == "admin") {
            checkNominal = `
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
                    <button type="button" class="btn btn-block btn-outline-success" onclick="ModalEditPaymentButton(${i})">Edit Payment Information</button>
                </div>
            </div>`
          } else {
            checkNominal = `
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
                </div>
            </div>`
          }
          document.querySelector(`#grand-total-paid${i}`).innerHTML = `
          <div>
              - IDR ${dataCartDokter[i]['total_paid']}
            </div>
          `

          document.querySelector(`#total_paid_sum_div${i}`).innerHTML = `
          <div>
              IDR ${dataCartDokter[i]['total_paid_sum']}
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

          
          let queryStatus = document.querySelector(`#button_status_update${i}`)
          if(queryStatus) {
            queryStatus.innerHTML = ""
          }
          let queryCancel = document.querySelector(`#button-status-canceled${i}`)
          if(queryCancel) {
            queryCancel.innerHTML = ""
          }

        } else if (dataCartDokter[i].status == 5) {
          document.querySelector(`#span_status${i}`).innerHTML = `
          <span class="badge bg-success text-wrap fs-2">
            Paid
          </span>
          `
          let queryStatus = document.querySelector(`#span-edit-status${i}`)
          if(queryStatus) {
            queryStatus.innerHTML = ""
          }

          $(`#nominal_step_payment_input${i}`).attr({
              "max": dataCartDokter[i]['total_num_paid_sum'],
          })

          if(user['role'] == "superuser" || user['role'] == "finance" || user['role'] == "admin") {
            document.querySelector(`#button_status_update${i}`).innerHTML = `
            <button class="btn btn-outline-success" id="payment_btn_modal" data-toggle="modal" data-target="#modalStepPayment${i}" onclick="clearModalPayment(${i})">
            Submit Payment
            </button>`
          }

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
              </div>`
          
          document.querySelector(`#dropaddstatus${i}`).innerHTML = `
          <select class="form-select form-control" id="status_select${i}" required>
            <option value="0">SUBMITED</option>
            <option value="1">PACKING</option>
            <option value="2">SENT</option>
            <option value="3" selected>PAID</option>
          </select>
          `

          if(user['role'] == "superuser" || user['role'] == "finance" || user['role'] == "admin") {
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
              </div>`
          } else {
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
                      </div>
                  </div>`
          }
          var checkNominal = ""
          for (let j = 0; j < dataCartDokter[i]['step_payment'].length; j++) {
              const element = dataCartDokter[i]['step_payment'][j];
              if(!element.paid_at) {
                continue
              }

              if(user['role'] == "superuser" || user['role'] == "finance" || user['role'] == "admin") {
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
                            <td class="border" id="paid_nominal_${i}_${j}"> <p>IDR ${element.nominal.toString().replace(/(\d)(?=(\d{3})+$)/g, '$1.')}</p></td>
                          </tr>
                          </table>
                          <button type="button" class="btn btn-block btn-outline-success" onclick="EditStepPaymentButton(${i}, ${j})">Edit Payment Information</button>
                        </div>
                    </div>`
              } else {
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
                            <td class="border" id="paid_nominal_${i}_${j}"> <p>IDR ${element.nominal.toString().replace(/(\d)(?=(\d{3})+$)/g, '$1.')}</p></td>
                          </tr>
                          </table>
                        </div>
                    </div>`
              }
          }

          if (dataCartDokter[i]['total_paid_sum'] == "0") {
            if(user['role'] == "superuser" || user['role'] == "finance" || user['role'] == "admin") {
              let edit_product_button = document.querySelector(`#button-edit-product${i}`)
              if(edit_product_button) {
                edit_product_button.innerHTML = ""
              }
  
              let extra_charge_button = document.querySelector(`#button-extra-charge${i}`)
              if(extra_charge_button) {
                extra_charge_button.innerHTML = ""
              }
            }
            document.querySelector(`#button_status_update${i}`).innerHTML = ``
            document.querySelector(`#span_status${i}`).innerHTML = `
            <span class="badge bg-success text-wrap fs-2">
              Paid (Completed)
            </span>
            `


            let queryCancel = document.querySelector(`#button-status-canceled${i}`)
            if(queryCancel) {
              queryCancel.innerHTML = ""
            }
          } else {
            if(user['role'] == "superuser" || user['role'] == "admin") {
              let queryCancel = document.querySelector(`#button-status-canceled${i}`)
              if(queryCancel) {
                queryCancel.innerHTML = `
                <button class="btn me-3 btn-outline-danger" id="cancel_status_btn" data-toggle="modal" data-target="#modalCancel${i}">
                  Cancel Purchase Order
                </button>
                `
              }
  
              let edit_product_button = document.querySelector(`#button-edit-product${i}`)
              if(edit_product_button) {
                  edit_product_button.innerHTML = `
                  <button class="btn me-3 btn-outline-success" id="edit_product${i}" onclick="EditProductShow(${i})">
                      Edit Product
                  </button>
                  `
              }
  
              let extra_charge_button = document.querySelector(`#button-extra-charge${i}`)
              if(extra_charge_button) {
                extra_charge_button.innerHTML = `
                <button class="btn btn-outline-success" data-target="#modalExtraCharge${i}" data-toggle="modal">
                  Add Extra Charges
                </button>
                `
              }
            } else if(user['role'] == "finance") {
              let queryCancel = document.querySelector(`#button-status-canceled${i}`)
              if(queryCancel) {
                queryCancel.innerHTML = `
                <button class="btn me-3 btn-outline-danger" id="cancel_status_btn" data-toggle="modal" data-target="#modalCancel${i}">
                  Cancel Purchase Order
                </button>
                `
              }

              let extra_charge_button = document.querySelector(`#button-extra-charge${i}`)
              if(extra_charge_button) {
                extra_charge_button.innerHTML = `
                <button class="btn btn-outline-success" data-target="#modalExtraCharge${i}" data-toggle="modal">
                  Add Extra Charges
                </button>
                `
              }
            }

          }
          document.querySelector(`#column_payment${i}`).innerHTML = checkNominal

          document.querySelector(`#grand-total-paid${i}`).innerHTML = `
          <div>
              - IDR ${dataCartDokter[i]['total_paid']}
            </div>
          `

          document.querySelector(`#total_paid_sum_div${i}`).innerHTML = `
          <div>
              IDR ${dataCartDokter[i]['total_paid_sum']}
            </div>
          `
        }

        
        if (dataCartDokter[i]['status_due_date'] && dataCartDokter[i].status != 5 && dataCartDokter[i].status != 3) {
          document.querySelector(`#button_status_update${i}`).innerHTML = ``
        }
      }
    }

    function EditSentButton(key) {
      document.getElementById(`ekspedisi_edit_select${key}`).value = dataCartDokter[key].expedition_id
      document.getElementById(`shipping_edit_cost_input${key}`).value = dataCartDokter[key].shipping_cost.toString().replace(/(\d)(?=(\d{3})+$)/g, '$1.')
      // console.log({shipping})
      document.getElementById(`receipt_edit_number_input${key}`).value = dataCartDokter[key].recepient_number
      $(`#modalEditSent${key}`).modal("show")
    }

    function ModalEditPaymentButton(key) {
      document.getElementById(`edit_paid_at${key}`).value = dataCartDokter[key].paid_at
      document.getElementById(`edit_bank_name${key}`).value = dataCartDokter[key].paid_bank_name
      document.getElementById(`edit_bank_account_name${key}`).value = dataCartDokter[key].paid_account_bank_name
      $(`#modalEditPayment${key}`).modal("show")
    }

    function EditStepPaymentButton(key, index) {
      document.getElementById(`step_edit_paid_at${key}`).value = dataCartDokter[key]['step_payment'][index].paid_at
      document.getElementById(`step_edit_bank_name${key}`).value = dataCartDokter[key]['step_payment'][index].paid_bank_name
      document.getElementById(`step_edit_bank_account_name${key}`).value = dataCartDokter[key]['step_payment'][index].paid_account_bank_name
      document.getElementById(`nominal_edit_step_payment_input${key}`).value = dataCartDokter[key]['step_payment'][index].nominal.toString().replace(/(\d)(?=(\d{3})+$)/g, '$1.');
      document.getElementById(`key_edit_step_payment${key}`).value = index
      $(`#modalEditStepPayment${key}`).modal("show")
    }

    function EditProductShow(key) {
      let htmlExtraCharge = ``
      for (let i = 0; i < dataCartDokter[key]['extra_charge'].length; i++) {
        const element = dataCartDokter[key]['extra_charge'][i];
        htmlExtraCharge += `      
        <div id="body-product${key}-${i}" class="input-group">
            <div class="d-inline-flex p-2">
              <div id="name-product">
                <span class="input-group-text">Description</span>
                {{-- <span class="input-group-text">{{ ${element['description']} }}</span> --}}
                <input type="text" class="form-control" id="extraChargeDescription-${key}-${i}"  aria-describedby="inputGroupPrepend2" required value="${element['description']}">
              </div>
              <div>
                <span class="input-group-text">Price</span>
                <input type="text" class="form-control" id="extraChargePrice-${key}-${i}"  aria-describedby="inputGroupPrepend2" required value="${element['price']}" min="0">
              </div>
            </div>
          </div>
          `
      }
      document.querySelector(`#extra-charge-edit-product${key}`).innerHTML = htmlExtraCharge
      $(`#modalEditProduct${key}`).modal("show")
    }

    function UpdateStatus(id, key) {
      var select_id = document.getElementById(`status_select${key}`).value
      var objectStatus = {}

      if (select_id == "0") {
      objectStatus = {
          updated_by: user.name,
          status: select_id,
          packing_by: null,
          packing_at: null,
          expedition_id: null,
          shipping_cost: null,
          sent_by: null,
          sent_at: null,
          paid_at: null,
          paid_by: null,
          paid_bank_name: null,
          paid_account_bank_name: null,
          nominal: null,
        }
      } else if(select_id == "1") {
        objectStatus = {
          updated_by: user.name,
          status: select_id,
          packing_by: user.name,
          sent_by: null,
          expedition_id: null,
          shipping_cost: null,
          sent_at: null,
          paid_at: null,
          paid_by: null,
          paid_bank_name: null,
          paid_account_bank_name: null,
          nominal: null,
        }
      } else if(select_id == "2") {
        objectStatus = {
          updated_by: user.name,
          status: select_id,
          sent_by: user.name,
          paid_at: null,
          paid_by: null,
          paid_bank_name: null,
          paid_account_bank_name: null,
          nominal: null,
        }
      }
      $.ajax({
        type: "POST",
        url: "{{url('/')}}"+"/updateStatus",
        data: { "_token": "{{ csrf_token() }}", data: {
          id: id,
          ...objectStatus,
          nominal: dataCartDokter[key]['total_price']
        }},
        beforeSend: $.LoadingOverlay("show"),
        afterSend:$.LoadingOverlay("hide"),
        success: function (data) {
          if(data.message=="sukses"){
            $(`#modalEditStatus${key}`).modal("hide")
            if(dataCartDokter[key]['status'] == 3 || dataCartDokter[key]['status'] == 5) {
              dataCartDokter[key]['total_num_paid_sum'] = dataCartDokter[key]['total_price']
              dataCartDokter[key]['total_num_paid'] = 0
              dataCartDokter[key]['total_paid'] = 0
              dataCartDokter[key]['total_paid_sum'] = data['nominal']

              document.querySelector(`#grand-total-paid${key}`).innerHTML = `
              <div>
                  - IDR ${dataCartDokter[key]['total_paid']}
                </div>
              `

              document.querySelector(`#total_paid_sum_div${key}`).innerHTML = `
              <div>
                  IDR ${dataCartDokter[key]['total_paid_sum']}
                </div>
              `
              if(user['role'] == "superuser" || user['role'] == "admin") {
                let edit_product_button = document.querySelector(`#button-edit-product${key}`)
                if(edit_product_button) {
                  edit_product_button.innerHTML = `
                  <button class="btn me-3 btn-outline-success" id="edit_product${key}" onclick="EditProductShow(${key})">
                    Edit Product
                  </button>
                  `
                }
    
                let extra_charge_button = document.querySelector(`#button-extra-charge${key}`)
                if(extra_charge_button) {
                  extra_charge_button.innerHTML = `
                  <button class="btn btn-outline-success" data-target="#modalExtraCharge${key}" data-toggle="modal">
                    Add Extra Charges
                  </button>
                  `
                }
              } else if(user['role'] == "finance") {
                let extra_charge_button = document.querySelector(`#button-extra-charge${key}`)
                if(extra_charge_button) {
                  extra_charge_button.innerHTML = `
                  <button class="btn btn-outline-success" data-target="#modalExtraCharge${key}" data-toggle="modal">
                    Add Extra Charges
                  </button>
                  `
                }
              }
            }
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

    function clearModalExtraCharge(key) {
      document.getElementById(`extra_charge_desc${key}`).value = ""
      document.getElementById(`extra_charge_price${key}`).value = ""
    }

    function ExtraCharge(id, key) {
      var desc = $(`#extra_charge_desc${key}`).val()
      var price = $(`#extra_charge_price${key}`).val()
      price = price.split(".").join("")
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
            clearModalExtraCharge(key)
            $(`#modalExtraCharge${key}`).modal("hide")
            // data[key]['total_paid_sum'] += price
            dataCartDokter[key]['extra_charge'].push({
              id: data['id'],
              transaction_id: id,
              description: desc,
              price: price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.'),
            })
            refreshTableExtraCharge(key, dataCartDokter[key]['total_num_paid_sum'], price)

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
      document.querySelector(`#t-foot${key}`).innerHTML = null
      for (let i = 0; i < dataCartDokter[key]['extra_charge'].length; i++) {
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
      dataCartDokter[key]['total_price'] += Number(extra_charge)
      dataCartDokter[key]['total_num_paid_sum'] = total
      total = total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.')
      divExtraCharge += `
      <tr>
        <td colspan="4">
          <div class="d-flex justify-content-end">
            <p class="fw-bold">
              Total Paid: 
            </p>
          </div>
        </td>
        <td id="grand-total-paid${key}">
          <div>
            - IDR ${dataCartDokter[key]['total_paid']}
          </div>
        </td>
      </tr>
      <tr>
        <td colspan="4">
          <div class="d-flex justify-content-end">
            <p class="fw-bold">
              Grand Total: 
            </p>
          </div>
        </td>
        <td>
          <div id="total_paid_sum_div${key}">
            IDR ${total}
          </div>
        </td>
        </tr>`
      document.querySelector(`#t-foot${key}`).innerHTML = divExtraCharge
    }

    function SentButton(id, key) {
      var ekspedisi = $(`#ekspedisi_select${key}`).val()
      var shippingCost = $(`#shipping_cost_input${key}`).val()
      shippingCost = shippingCost.split('.').join('')
      // console.log({shippingCost})
      // return
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

    function EditApiSentButton(id, key) {
      var ekspedisi = $(`#ekspedisi_edit_select${key}`).val()
      var shippingCost = $(`#shipping_edit_cost_input${key}`).val()
      shippingCost = shippingCost.split('.').join('')
      // console.log({shippingCost})
      // return
      var receipt_number_input = $(`#receipt_edit_number_input${key}`).val()
      $.ajax({
        type: "POST",
        url: "{{url('/')}}"+"/sentPO",
        data: { "_token": "{{ csrf_token() }}", data: {
          // status: 2,
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
            // dataCartDokter[key].status = 2
            $(`#modalEditSent${key}`).modal("hide")
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
      var paid_at = $(`#paid_at${key}`).val();
      var bank_name = $(`#bank_name${key}`).val();
      var bank_account_name = $(`#bank_account_name${key}`).val();
      var nominal_payment_input = $(`#nominal_payment_input${key}`).val();
      nominal_payment_input = nominal_payment_input.split(".").join("")
      var nominal_input = document.getElementById(`container_nominal_input${key}`);

      var status = 5
      if(nominal_input.style.display == "none") {
        nominal_payment_input = 0
        status = 3
      }

      if (!paid_at) {
        AlertWarningWithMsg("must fill the paid at")
        return
      }

      if (!bank_name) {
        AlertWarningWithMsg("must fill the bank name")
        return
      }

      if (!bank_account_name) {
        AlertWarningWithMsg("must fill the bank account name")
        return
      }

      if (!nominal_payment_input && status == 5) {
        AlertWarningWithMsg("must fill the bank nominal payment")
        return
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
        }, 
        total: dataCartDokter[key]['total_num_paid_sum'],
        nominal: nominal_payment_input,
        },
        beforeSend: $.LoadingOverlay("show"),
        afterSend:$.LoadingOverlay("hide"),
        success: function (data) {
          if(data['message']=="sukses"){
            if(status == 3) {
              dataCartDokter[key]['paid_bank_name'] = bank_name
              dataCartDokter[key]['paid_account_bank_name'] = bank_account_name
              // dataCartDokter[key]['nominal'] = data['nominal']
              dataCartDokter[key]['paid_by'] = data['paid_by']
              dataCartDokter[key]['paid_at'] = data['paid_at']
              dataCartDokter[key]['total_paid'] = data['total_paid']
              dataCartDokter[key]['total_paid_sum'] = 0
              dataCartDokter[key]['total_num_paid'] = dataCartDokter[key]['total_num_paid_sum']
              dataCartDokter[key]['total_num_paid_sum'] = 0
              // dataCartDokter[key]['total_paid_sum'] = data['total_paid_sum']
            } else if(status == 5) {
              dataCartDokter[key]['paid_bank_name'] = data['paid_bank_name']
              dataCartDokter[key]['paid_account_bank_name'] = data['paid_account_bank_name']
              dataCartDokter[key]['nominal'] = data['nominal_step'] + "|"
              dataCartDokter[key]['paid_by'] = data['paid_by']
              dataCartDokter[key]['paid_at'] = data['paid_at']
              var paid_at = data['paid_at'].split('|')[0]
              dataCartDokter[key]['step_payment'] = [
                {
                  paid_by: user.name,
                  paid_at: paid_at,
                  paid_bank_name: bank_name,
                  paid_account_bank_name: bank_account_name,
                  nominal: nominal_payment_input,
                  nominal_number: nominal_payment_input
                }
              ]

              dataCartDokter[key]['total_paid'] = data['total_paid']
              dataCartDokter[key]['total_paid_sum'] = data['total_paid_sum']
              dataCartDokter[key]['total_num_paid_sum'] = data['total_num_paid_sum']
              dataCartDokter[key]['total_num_paid'] = Number(data['nominal_step'])
            }
            dataCartDokter[key].status = status
            $(`#modalPayment${key}`).modal("hide")
            clearModalPayment(key)
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

    function EditPaymentButton(id, key) {
      var paid_at = $(`#edit_paid_at${key}`).val();
      var bank_name = $(`#edit_bank_name${key}`).val();
      var bank_account_name = $(`#edit_bank_account_name${key}`).val();
      var status = 3

      if (!paid_at) {
        AlertWarningWithMsg("must fill the paid at")
        return
      }

      if (!bank_name) {
        AlertWarningWithMsg("must fill the bank name")
        return
      }

      if (!bank_account_name) {
        AlertWarningWithMsg("must fill the bank account name")
        return
      }

      $.ajax({
        type: "POST",
        url: "{{url('/')}}"+"/editPaymentOrder",
        data: { "_token": "{{ csrf_token() }}", data: {
          paid_at: paid_at,
          paid_bank_name: bank_name,
          paid_account_bank_name: bank_account_name,
          id:id,
        }, 
        },
        beforeSend: $.LoadingOverlay("show"),
        afterSend:$.LoadingOverlay("hide"),
        success: function (data) {
          if(data['message']=="sukses"){
            dataCartDokter[key]['paid_bank_name'] = bank_name
            dataCartDokter[key]['paid_account_bank_name'] = bank_account_name
            dataCartDokter[key]['paid_by'] = data['paid_by']
            dataCartDokter[key]['paid_at'] = data['paid_at']
            $(`#modalEditPayment${key}`).modal("hide")
            clearModalPayment(key)
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
      // var indexEdit = document.getElementById(`key_step_payment${key}`).value;
      var paid_at = $(`#step_paid_at${key}`).val();
      var bank_name = $(`#step_bank_name${key}`).val();
      var bank_account_name = $(`#step_bank_account_name${key}`).val();
      var nominal_payment_input = $(`#nominal_step_payment_input${key}`).val();
      nominal_payment_input = nominal_payment_input.split(".").join("")
      var paid_at_before = dataCartDokter[key]['paid_at']
      var paid_bank_name_before = dataCartDokter[key]['paid_bank_name']
      var paid_account_bank_name_before = dataCartDokter[key]['paid_account_bank_name']
      var nominal_before = dataCartDokter[key]['nominal']
      var paid_by_before = dataCartDokter[key]['paid_by']
      if (!paid_at) {
        AlertWarningWithMsg("must fill the paid at")
        return
      }

      if (!bank_name) {
        AlertWarningWithMsg("must fill the bank name")
        return
      }

      if (!bank_account_name) {
        AlertWarningWithMsg("must fill the bank account name")
        return
      }

      // return
      if (!nominal_payment_input && status == 5) {
        AlertWarningWithMsg("must fill the bank nominal payment")
        return
      }

      if (Number(nominal_payment_input) > dataCartDokter[key]['total_num_paid_sum']) {
        nominal_payment_input = `${dataCartDokter[key]['total_num_paid_sum']}`
      }

      // console.log({paid_at_before, paid_bank_name_before, paid_account_bank_name_before, nominal_before,paid_by_before})
      var paid_at_after = paid_at_before +paid_at + "|"
      var bank_name_after = paid_bank_name_before  +bank_name + "|"
      var bank_account_name_after = paid_account_bank_name_before  +bank_account_name + "|"
      var nominal_after = nominal_before  + nominal_payment_input + "|"
      var paid_by_after = paid_by_before  + user.name + "|"
      // console.log({
      //   dataBefore: {
      //     status: 5,
      //     paid_at: paid_at,
      //     paid_bank_name: bank_name,
      //     paid_account_bank_name: bank_account_name,
      //     nominal: nominal_payment_input,
      //     id:id,
      //     paid_at_before: dataCartDokter[key]['paid_at'],
      //     paid_bank_name_before: dataCartDokter[key]['paid_bank_name'],
      //     paid_account_bank_name_before: dataCartDokter[key]['paid_account_bank_name'],
      //     nominal_before: dataCartDokter[key]['nominal'],
      //     paid_by_before: dataCartDokter[key]['paid_by'],
      //     // indexEdit,
      //     paid_by: paid_by_after,
      //     nominal_paid: dataCartDokter[key]['total_num_paid'],
      //     total_num_paid_sum: dataCartDokter[key]['total_num_paid_sum'],
      //     must_paid: Number(dataCartDokter[key]['total_num_paid']) + Number(nominal_payment_input),
      //     left_paid:  Number(dataCartDokter[key]['total_num_paid_sum']) - nominal_payment_input,
      //   }
      // })
      // return
      $.ajax({
      type: "POST",
        url: "{{url('/')}}"+"/stepPaymentOrder",
        data: { "_token": "{{ csrf_token() }}", 
        nominal_payment_input: Number(nominal_payment_input),
        nominal_paid: Number(dataCartDokter[key]['total_num_paid']) ,
        total_num_paid_sum: Number(dataCartDokter[key]['total_num_paid_sum']),
        data: {
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
          // console.log({
          //   paid_at: paid_at_after,
          //   paid_bank_name: bank_name_after,
          //   paid_account_bank_name: bank_account_name_after,
          //   nominal: nominal_after,
          //   paid_by: paid_by_after,
          // })
          if(data['message']=="sukses"){
            let obj = {
              paid_by: user.name,
              paid_at: paid_at,
              paid_bank_name: bank_name,
              paid_account_bank_name: bank_account_name,
              nominal: nominal_payment_input
            }
            dataCartDokter[key]['step_payment'].push(obj)
            dataCartDokter[key]['paid_bank_name'] = bank_name_after
            dataCartDokter[key]['paid_account_bank_name'] = bank_account_name_after
            dataCartDokter[key]['nominal'] = nominal_after
            dataCartDokter[key]['paid_by'] = paid_by_after
            dataCartDokter[key]['paid_at'] = paid_at_after
            dataCartDokter[key]['total_num_paid'] += Number(nominal_payment_input)
            dataCartDokter[key]['total_num_paid_sum'] -= Number(nominal_payment_input)
            dataCartDokter[key]['total_paid'] = data['nominal']
            dataCartDokter[key]['total_paid_sum'] = data['nominal_num']
            dataCartDokter[key].status = 5
            $(`#modalStepPayment${key}`).modal("hide")
            $(`#nominal_step_payment_input${key}`).attr({
              "max": dataCartDokter[key]['total_num_paid_sum'],
            })
            clearStepModalPayment(key)
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

    function EditStepPayment(id, key) {
      var indexEdit = document.getElementById(`key_edit_step_payment${key}`).value;
      var paid_at = $(`#step_edit_paid_at${key}`).val();
      var bank_name = $(`#step_edit_bank_name${key}`).val();
      var bank_account_name = $(`#step_edit_bank_account_name${key}`).val();
      var nominal_payment_input = $(`#nominal_edit_step_payment_input${key}`).val();
      nominal_payment_input = nominal_payment_input.split(".").join("")
      var paid_at_before = dataCartDokter[key]['paid_at']
      var paid_bank_name_before = dataCartDokter[key]['paid_bank_name']
      var paid_account_bank_name_before = dataCartDokter[key]['paid_account_bank_name']
      var nominal_before = dataCartDokter[key]['nominal']
      var paid_by_before = dataCartDokter[key]['paid_by']
      if (!paid_at) {
        AlertWarningWithMsg("must fill the paid at")
        return
      }

      if (!bank_name) {
        AlertWarningWithMsg("must fill the bank name")
        return
      }

      if (!bank_account_name) {
        AlertWarningWithMsg("must fill the bank account name")
        return
      }

      if (!nominal_payment_input && status == 5) {
        AlertWarningWithMsg("must fill the bank nominal payment")
        return
      }

      let kurangin = nominal_payment_input - dataCartDokter[key]['step_payment'][indexEdit].nominal
      let kuranginTotal = dataCartDokter[key]['total_num_paid_sum'] - kurangin
      let totalan = dataCartDokter[key]['total_num_paid_sum']
      let totalTemp = dataCartDokter[key]['total_num_paid']
      let kuranginPaid = dataCartDokter[key]['total_num_paid'] + kurangin
      dataCartDokter[key]['total_num_paid'] += kurangin
      dataCartDokter[key]['total_num_paid_sum'] -= kurangin
      // if(kuranginTotal < 0) {
      //   let num = 0
      //   for (let i = 0; i < dataCartDokter[key]['step_payment'].length; i++) {
      //     const element = dataCartDokter[key]['step_payment'][i];
      //     if(i != indexEdit) {
      //       num += Number(element['nominal'])
      //     }
      //   }
      //   nominal_payment_input = Number(totalTemp) + Number(totalan) - Number(num)
      //   kurangin = Math.abs(kurangin)
      //   kuranginPaid = Number(totalTemp) + Number(totalan)
      //   kuranginTotal = 0
      //   dataCartDokter[key]['total_num_paid'] = Number(totalTemp) + Number(totalan)
      //   dataCartDokter[key]['total_num_paid_sum'] = 0
      //   // return
      // }

      // let totalan = dataCartDokter[key]['total_num_paid_sum']
      // let totalTemp = dataCartDokter[key]['total_num_paid']

      let num = 0
      for (let i = 0; i < dataCartDokter[key]['step_payment'].length; i++) {
        const element = dataCartDokter[key]['step_payment'][i];
        if(i != indexEdit) {
          num += Number(element['nominal'])
        }
      }

      let sum = num + Number(nominal_payment_input)
      if(dataCartDokter[key]['total_price'] < sum) {
        nominal_payment_input = dataCartDokter[key]['total_price'] - num
        kuranginPaid = dataCartDokter[key]['total_price']
        kuranginTotal = 0
        dataCartDokter[key]['total_num_paid'] = dataCartDokter[key]['total_price']
        dataCartDokter[key]['total_num_paid_sum'] = 0
      } 


      // console.log({
      //    nominal_payment_input: nominal_payment_input,
      //   nominal_paid: kuranginPaid,
      //   total_num_paid_sum: kuranginTotal
      // })

      // return

      // var paid_at_after = paid_at_before + "|" +paid_at
      // var bank_name_after = paid_bank_name_before + "|" +bank_name
      // var bank_account_name_after = paid_account_bank_name_before + "|" +bank_account_name
      // var nominal_after = nominal_before + "|" + nominal_payment_input
      var paidSplit = paid_at_before.split("|")
      var paidBankNameSplit = paid_bank_name_before.split("|")
      var paidAccountBankNameSplit = paid_account_bank_name_before.split("|")
      var paidNominalSplit = nominal_before.split("|")
      var paidBySplit = paid_by_before.split("|")
      // console.log({paidNominalSplit})
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
      // console.log({paidNominalSplit})
  
      $.ajax({
      type: "POST",
        url: "{{url('/')}}"+"/editStepPaymentOrder",
        data: { "_token": "{{ csrf_token() }}", 
        nominal_payment_input: nominal_payment_input,
        nominal_paid: kuranginPaid,
        total_num_paid_sum: kuranginTotal,
        data: {
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
            dataCartDokter[key]['total_paid'] = data['nominal']
            dataCartDokter[key]['total_paid_sum'] = data['nominal_num']
            dataCartDokter[key]['paid_at'] = paidSplit
            dataCartDokter[key]['paid_bank_name'] = paidBankNameSplit
            dataCartDokter[key]['paid_account_bank_name'] = paidAccountBankNameSplit
            dataCartDokter[key]['nominal'] = paidNominalSplit
            dataCartDokter[key]['paid_by'] = paidBySplit
            dataCartDokter[key].status = 5
            $(`#modalEditStepPayment${key}`).modal("hide")
            $(`#nominal_step_payment_input${key}`).attr({
              "max": dataCartDokter[key]['total_num_paid_sum'],
            })
            clearEditStepModalPayment(key)
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
          if(data['res']=="sukses"){
            $(`#modalCancel${key}`).modal("hide")
            dataCartDokter[key].status = 4
            dataCartDokter[key]['cancel_reason'] = cancel_reason
            dataCartDokter[key]['cancel_by'] = data['cancel_by']
            dataCartDokter[key]['cancel_at'] = data['cancel_at']
            checkForButtonStatus()
            AlertSuccess()
          }else if(data['res']!='gagal'&& data['res']!="gagal2"){
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

    function EditProduct(id, key, po_id) {
      let productJoin = ""
      for(let i = 0; i < dataCartDokter[key]['products'].length; i++) {
        let el = dataCartDokter[key]['products'][i]
        var quantity = $(`#productQty-${key}-${i}`).val()
        var discount = $(`#productDiscount-${key}-${i}`).val()
        
        dataCartDokter[key]['products'][i]['qty'] = quantity
        dataCartDokter[key]['products'][i]['disc'] = discount
        let price_product = dataCartDokter[key]['products'][i]['price_product_real']
        if(dataCartDokter[key]['products'].length -1 == i) {
          productJoin += `${el['id']}|${el['type']}|${quantity}|${discount}|${price_product}`
        } else {
          productJoin += `${el['id']}|${el['type']}|${quantity}|${discount}|${price_product},`
        }
      }


      let extraCharge = []
      for(let i = 0; i < dataCartDokter[key]['extra_charge'].length; i++) {
        // let el = dataCartDokter[key]['extra_charge'][i]
        var desc = $(`#extraChargeDescription-${key}-${i}`).val()
        var price = $(`#extraChargePrice-${key}-${i}`).val()
        extraCharge.push({
          id: dataCartDokter[key]['extra_charge'][i]['id'],
          transaction_id: dataCartDokter[key]['extra_charge'][i]['transaction_id'],
          description: desc,
          price: price,
        })      
      }

      $.ajax({
        type: "POST",
        url: "{{url('/')}}"+"/editProduct",
        data: { "_token": "{{ csrf_token() }}", data: {
          id: id,
          po_id: po_id,
          cart: productJoin,
          awal : productAwal[key]['products'],
          extra_charge: extraCharge
        }},
        beforeSend: $.LoadingOverlay("show"),
        afterSend:$.LoadingOverlay("hide"),
        success: function (data) {
          if(data=="sukses"){
            $(`#modalEditProduct${key}`).modal("hide")
            // dataCartDokter[key].status = 4
            // checkForButtonStatus()
            // AlertSuccess()
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

      // RefreshTable(key)
    }


</script>
    
@endpush