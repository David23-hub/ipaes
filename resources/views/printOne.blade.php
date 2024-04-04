<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <link rel="stylesheet" href="{{ asset('pdf.css') }}" type="text/css">  --}}
    <title>Invoice</title>
</head>
<body>
    <table class="w-full">
        <tr>
            <td class="w-half">
                <h2>INVOICE</h2>
                <h5>{{ $data['inv_no'] }}</h5>
                <h5>{{ $data['created_at'] }}</h5>
            </td>
            <td class="w-quarter" style="text-align: start">
                <h6>{{ $data['dokter']['name'] }}</h6>
                <h6>{{ $data['dokter']['no_hp'] }}</h6>
                <h6>{{ $data['dokter']['clinic'] }}</h6>
                <h6>{{ $data['dokter']['address'] }}</h6>
            </td>
            <td class="w-quarter" style="text-align: end">
                <h6>Tanggal PO: {{ $data['created_at'] }}</h6>
                <h6>Jatuh Tempo: {{ $data['due_date'] }}</h6>
                <h6>M.R: {{ $data['user']['name'] }}</h6>
            </td>
        </tr>
    </table>
 
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
            @foreach($data['products'] as $item)
            <tr class="items">
                    <td>
                        {{ $item['name_product'] }}
                    </td>
                    <td>
                        {{ $item['qty'] }}
                    </td>
                    <td>
                        IDR {{ $item['price_product'] }}
                    </td>
                    <td>
                        {{ $item['disc'] }}%
                    </td>
                    <td>
                        IDR {{ $item['price'] }} - IDR {{ $item['disc_price'] }} = IDR {{ $item['total_price'] }}
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    @if (count($data['extra_charge']) > 0)
        <div class="margin-top">
            <h4>Extra Charge</h4>
            <table class="products">
                <tr>
                    <th>Description</th>
                    <th>Price</th>
                </tr>
                @foreach($data['extra_charge'] as $item)
                <tr class="items">
                        <td>
                            {{ $item['description'] }}
                        </td>
                        <td>
                            IDR {{ $item['price'] }}
                        </td>
                    </tr>
                @endforeach
                <tr class="items">
                    <td>Total Extra Charge</td>
                    <td>IDR {{ $data['totalan_extra_charge'] }}</td>
                </tr>
            </table>
        </div>
    @endif

    
    <div class="total">
        Grand Total: IDR {{ $data['total'] }}
    </div>
    <table>
        <tr>
            <td class="w-half-bottom-left">
                <div><p>HARAP MELAKUKAN PEMBAYARAN MELALUI:</p>
                    <p>BCA 2880517131 an Maggie Princilla Chandra / MANDIRI 1650003234987 an Maggie Princilla Chandra</p>
                    <p>intipratama@gmail.com</p>
                    <p>(*) Harap cantumkan nomor invoice saat pembayaran</p>
                </div>
            </td>
            <td class="w-half-bottom-right">
                <div>12 Maret 2024</div>
                <div class="pad-5">Corentius</div>
            </td>
        </tr>
    </table>
</body>

<style>
h4 {
    margin: 0;
}

.pad-5 {
    padding-top: 5em;
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
    /*background-color: rgb(96 165 250);*/
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
    /*background-color: rgb(241 245 249);*/
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