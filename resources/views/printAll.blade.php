<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
</head>
<body>
    <table class="w-full">
        <tr>
            <td class="w-half">
                <h2>INVOICE ALL TRANSACTION</h2>
                {{-- <h5>{{ $data['po_id'] }}</h5>
                <h5>{{ $data['created_at'] }}</h5> --}}
                <h4>DOCTOR NAME: {{ $data['dokter']['name'] }}</h4>
                <h4>DOCTOR HP: {{ $data['dokter']['no_hp'] }}</h4>
                <h4>DOCTOR CLINIC: {{ $data['dokter']['clinic'] }}</h4>
                <h4>DOCTOR ADDRESS: {{ $data['dokter']['address'] }}</h4>
            </td>
        </tr>
    </table>
    @foreach ($data['data'] as $key => $item)
    @if ($key == 0)
    <div class="first-page">
        <h5>INVOICE NUMBER: {{ $item['po_id'] }}</h5>
        <h5>TANGGAL PO: {{ $item['created_at'] }}</h5>
        <h5>Jatuh Tempo: {{ $item['due_date'] }}</h5>
        <h5>M.R: {{ $item['user']['name'] }}</h5>
        <div class="margin-top">
            <h4>Products</h4>
            <table class="products">
                <tr>
                    <th>Product Name</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Discount</th>
                    <th>Total Price</th>
                </tr>
                {{-- <h6>{{ $data }}</h6> --}}
                @foreach($item['products'] as $itemProduct)
                <tr class="items">
                        <td>
                            {{ $itemProduct['name_product'] }}
                        </td>
                        <td>
                            {{ $itemProduct['qty'] }}
                        </td>
                        <td>
                            IDR {{ $itemProduct['price_product'] }}
                        </td>
                        <td>
                            {{ $itemProduct['disc'] }}%
                        </td>
                        <td>
                            IDR {{ $itemProduct['price'] }} - IDR {{ $itemProduct['disc_price'] }} = IDR {{ $itemProduct['total_price'] }}
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    
        @if ($item['count_extra'] != 0)
            <div class="margin-top">
                <h4>Extra Charge</h4>
                <table class="products">
                    <tr>
                        <th>Description</th>
                        <th>Price</th>
                    </tr>
                    @foreach($item['extra_charge'] as $itemExtra)
                    <tr class="items">
                            <td>
                                {{ $itemExtra['description'] }}
                            </td>
                            <td>
                                IDR {{ $itemExtra['price'] }}
                            </td>
                        </tr>
                    @endforeach
                    <tr class="items">
                        <td>Total Extra Charge</td>
                        <td>IDR {{ $item['totalan_extra_charge'] }}</td>
                    </tr>
                </table>
            </div>
        @endif
    </div>

    <div class="total">
        Grand Total: IDR {{ $item['total'] }}
    </div>
    @else
    <div class="new-page">
        <h5>INVOICE NUMBER: {{ $item['po_id'] }}</h5>
        <h5>TANGGAL PO: {{ $item['created_at'] }}</h5>
        <h5>Jatuh Tempo: {{ $item['due_date'] }}</h5>
        <h5>M.R: {{ $item['user']['name'] }}</h5>
        <div class="margin-top">
            <h4>Products</h4>
            <table class="products">
                <tr>
                    <th>Product Name</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Discount</th>
                    <th>Total Price</th>
                </tr>
                {{-- <h6>{{ $data }}</h6> --}}
                @foreach($item['products'] as $itemProduct)
                <tr class="items">
                        <td>
                            {{ $itemProduct['name_product'] }}
                        </td>
                        <td>
                            {{ $itemProduct['qty'] }}
                        </td>
                        <td>
                            IDR {{ $itemProduct['price_product'] }}
                        </td>
                        <td>
                            {{ $itemProduct['disc'] }}%
                        </td>
                        <td>
                            IDR {{ $itemProduct['price'] }} - IDR {{ $itemProduct['disc_price'] }} = IDR {{ $itemProduct['total_price'] }}
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    
        @if ($item['count_extra'] != 0)
            <div class="margin-top">
                <h4>Extra Charge</h4>
                <table class="products">
                    <tr>
                        <th>Description</th>
                        <th>Price</th>
                    </tr>
                    @foreach($item['extra_charge'] as $itemExtra)
                    <tr class="items">
                            <td>
                                {{ $itemExtra['description'] }}
                            </td>
                            <td>
                                IDR {{ $itemExtra['price'] }}
                            </td>
                        </tr>
                    @endforeach
                    <tr class="items">
                        <td>Total Extra Charge</td>
                        <td>IDR {{ $item['totalan_extra_charge'] }}</td>
                    </tr>
                </table>
            </div>
        @endif
    </div>

    <div class="total">
        Grand Total: IDR {{ $item['total'] }}
    </div>
    @endif
    @endforeach
    <table>
        <tr>
            <td class="w-half-bottom-left">
                <div>HARAP MELAKUKAN PEMBAYARAN MELALUI:
                    BCA 2880517131 an Maggie Princilla Chandra / MANDIRI 1650003234987 an Maggie Princilla Chandra
                    intipratama@gmail.com
                    (*) Harap cantumkan nomor invoice saat pembayaran</div>
            </td>
            <td class="w-half-bottom-right">
                <div>12 Maret 2024</div>
                <div class="pad-5">Corentius</div>
            </td>
        </tr>
    </table>
</body>

<style>
.pad-5 {
    padding-top: 5em;
}

.new-page {
    page-break-before: always;
}

.first-page {
    padding-top: 2em
}

h4 {
    margin: 0;
}
.w-full {
    width: 100%;
}
.w-quarter {
    width: 20%;
}

.flex-bottom{
    display: flex;
}
.w-half {
    width: 20%;
    margin-top: 1.5rem;
}

.w-half-bottom-left {
    width: 75%;
    margin-top: 5rem;
}

.w-half-bottom-right {
    width: 25%;
    margin-top: 5rem;
}
.margin-top {
    margin-top: 1.25rem;
}
.footer {
    font-size: 0.875rem;
    /* padding: 1rem; */
    background-color: rgb(241 245 249);
}
table {
    width: 100%;
    border-spacing: 0;
}
table.products {
    font-size: 0.875rem;
    border: 1px solid black;
    border-collapse: collapse;
}
table.products tr {
    /*background-color: rgb(96 165 250); */
    border: 1px solid black;
    border-collapse: collapse;
}
table.products th {
    /* color: #ffffff; */
    padding: 0.5rem;
    border: 1px solid black;
    border-collapse: collapse;
}
table tr.items {
    /*background-color: rgb(241 245 249); */
    border: 1px solid black;
    border-collapse: collapse;
}
table tr.items td {
    padding: 0.5rem;
    text-align: center;
    border: 1px solid black;
    border-collapse: collapse;
}
.total {
    text-align: right;
    margin-top: 1rem;
    margin-bottom: 2rem;
    font-size: 0.875rem;
}
</style>
</html>