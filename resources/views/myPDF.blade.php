{{-- <html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Hello, world!</title>
  </head>
  <body>
    
    <div class="grid-container">
        <div>
            <p>INVOICE</p>
            <p>NOMOR INVOICE</p>
            <p>MARET 14, 2024</p>
        </div>
        <div >
            <p><span style="font-weight: bold;">KEPADA: </span> DR DABUN</p>
            <p>NAMA KLINIK</p>
            <p>ALAMAT KLINIK</p>
        </div>
        <div >
            <p><span style="font-weight: bold;">Tanggal PO: </span> DR DABUN</p>
            <p><span style="font-weight: bold;">JATUH TEMPO: </span> DR DABUN</p>
            <p><span style="font-weight: bold;">M.R: </span> davidb</p>
        </div>
    </div>

    <table class="products">
        <tr>
            <th>Qty</th>
            <th>Description</th>
            <th>Price</th>
        </tr>
        <tr class="items">
            @foreach($data as $item)
                <td>
                    {{ $item['quantity'] }}
                </td>
                <td>
                    {{ $item['description'] }}
                </td>
                <td>
                    {{ $item['price'] }}
                </td>
            @endforeach
        </tr>
    </table>
  </body>
  <style>
    .grid-container {
    display: grid;
    grid-template-columns: auto auto auto;
    /* padding: 10px; */
    }

    .grid-container > div {
    background-color: rgba(255, 255, 255, 0.8);
    border: 1px solid black;
    text-align: center;
    font-size: 30px;
    }
  </style>
</html>
 --}}

{{-- <html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
    
    <div class="container" style="margin-top: 20px;">
        <div class="d-inline-flex">
            <div>
                <div >
                    <h1>INVOICE</h1>
                    <p>NOMOR INVOICE</p>
                    <p>MARET 14, 2024</p>
                </div>
                <div >
                    <p><span style="font-weight: bold;">KEPADA: </span> DR DABUN</p>
                    <p>NAMA KLINIK</p>
                    <p>ALAMAT KLINIK</p>
                </div>
                <div >
                    <p><span style="font-weight: bold;">Tanggal PO: </span> DR DABUN</p>
                    <p><span style="font-weight: bold;">JATUH TEMPO: </span> DR DABUN</p>
                    <p><span style="font-weight: bold;">M.R: </span> davidb</p>
                </div>
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>header1</th>
                    <th>header2</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>body1</th>
                    <th>body2</th>
                </tr>
            </tbody>
        </table>
        <br>
        <hr style="border-top: 2px solid black;">
        <div class="row" style="margin-bottom:20px;">
            <div class="col">
                <p style="font-weight: bold;">Grand Total:</p>
            </div>
            <div class="col" style="text-align: right;font-weight:bold;">
                <p>RP 10000</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p>HARAP MELAKUKAN PEMBAYARAN MELALUI:</p>
                <p style="font-weight: bold;">BCA 2880517131 an Maggie Princilla Chandra / MANDIRI 1650003234987 an Maggie Princilla Chandra</p>
                <p>intipratama@gmail.com</p>
                <p style="font-weight: bold;">(*) Harap cantumkan nomor invoice saat pembayaran</p>
            </div>
            <div class="col-md-auto" style="width: 250px;">
                <p>14 maret 2024</p>
                <br><br><br>
                <p>Corentius (JANGAN DIUBAH NAMANY)</p>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html> --}}


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
                {{-- <img src="{{ asset('laraveldaily.png') }}" alt="laravel daily" width="200" /> --}}
                <h2>INVOICE</h2>
                <h5>{Nomor Invoice}</h5>
                <h5>{Tanggal}</h5>
            </td>
            <td class="w-quarter" style="text-align: start">
                <h6>{KEPADA: Dr T Rini Puspasari}</h6>
                <h6>{Nomor Telpon}</h6>
                <h6>{Nama Klinik}</h6>
                <h6>{Alamat}</h6>
            </td>
            <td class="w-quarter" style="text-align: end">
                <h6>Tanggal PO</h6>
                <h6>Jatuh Tempo</h6>
                <h6>MR</h6>
            </td>
        </tr>
    </table>
 
    <div class="margin-top">
        <table class="products">
            <tr>
                <th>Product Name</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Discount</th>
                <th>Total Price</th>
            </tr>
            <tr class="items">
                @foreach($data as $item)
                    <td>
                        {{ $item['product_name'] }}
                    </td>
                    <td>
                        {{ $item['quantity'] }}
                    </td>
                    <td>
                        {{ $item['price'] }}
                    </td>
                    <td>
                        {{ $item['discount'] }}
                    </td>
                    <td>
                        {{ $item['total_price'] }}
                    </td>
                @endforeach
            </tr>
        </table>
    </div>
 
    <div class="total">
        Grand Total: $129.00 USD
    </div>
 
    {{-- <div class="flex-bottom">
        <div class="footer w-half-bottom">
           <div>HARAP MELAKUKAN PEMBAYARAN MELALUI:
            BCA 2880517131 an Maggie Princilla Chandra / MANDIRI 1650003234987 an Maggie Princilla Chandra
            intipratama@gmail.com
            (*) Harap cantumkan nomor invoice saat pembayaran</div>
        </div>
        <div class="footer w-half-bottom">
            <div>12 Maret 2024</div>
            <div>Corentius</div>
         </div>
    </div> --}}
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
                <div>Corentius</div>
            </td>
        </tr>
    </table>
</body>

<style>
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
}
table.products tr {
    background-color: rgb(96 165 250);
}
table.products th {
    color: #ffffff;
    padding: 0.5rem;
}
table tr.items {
    background-color: rgb(241 245 249);
}
table tr.items td {
    padding: 0.5rem;
    text-align: center;
}
.total {
    text-align: right;
    margin-top: 1rem;
    margin-bottom: 2rem;
    font-size: 0.875rem;
}
</style>
</html>