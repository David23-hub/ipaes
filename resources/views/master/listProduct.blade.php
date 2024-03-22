@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">List Product</h1>
@stop

@section('content')
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-md-at">
            <p style="color: #95948E;">Category</p>
            <select class="custom-select" id="category_select" onchange="getAllDataByCategory(this.value)">
              <option value="all" selected>All</option>
              @foreach($category as $item)
                <option value={{$item->name}}>{{$item->name}}</option>
              @endforeach
            </select>
          </div>
          <div class="col">
            <p style="color: #95948E;">Search</p>
            <div class="input-group mb-2">
              <input type="search_product" class="form-control" id="search_product"  placeholder="Masukkan Nama Produk">
              <div class="input-group-prepend">
                <div class="input-group-text"><i class="fas fa-search"></i></div>
              </div>
            </div>
          </div>
          <div class="col-md-auto d-flex align-items-center" >
            <a href="{{route('viewCart')}}" class="btn btn-info">Go to Cart</a>
          </div>
        </div>
      </div>
    </div>

    {{-- CONTENT --}}
    <div id="content_field" >
      {{-- <div class="row">
        
        <div class="col col-sm-4">
          <div class="card" style="width: 18rem;">
            <div class="card-body">
              <img id="image" id ="image_update" src="..." class="card-img-top" alt="Product Image">
              <h5 class="card-title">Card title</h5>
              <p class="card-text">asdsad</p>
              <div class="row">
                <div class="col">
                  <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
                <div class="col">
                  <a href="#" class="btn btn-primary">Add To Cart</a>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div> --}}

    </div>

<!-- Modal Detail-->
<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="modalDetailTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">View Product</h5>
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
            <label for="presentation_detail">Presentation</label>
            <div class="input-group mb-2">
              <input type="presentation_detail" class="form-control" id="presentation_detail"  placeholder="Masukkan Presentasi" onkeyup="this.value = this.value.replace(/[^0-9.]/g, '');" disabled>
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

let timeoutId;
document.getElementById('search_product').addEventListener('input', function(event) {
    var inputValue = event.target.value;
    if (timeoutId) {
        clearTimeout(timeoutId); // Clear previous timeout if exists
    }
    timeoutId = setTimeout(function() {
      cat = $('#category_select').val();
      getAllDataByCategory(cat)

        timeoutId = null; // Reset timeoutId after alert
    }, 50); // Delay of 1 second (1000 milliseconds)
});
function removeLeadingZero(input) {
    if (input.value.charAt(0) === '0') {
        input.value = input.value.slice(1);
    }
}

  data = @json($product);
  dataBundle = @json($bundle);
  

  window.onload = function() {
    getAllData()
  };

  function getAllData(){ 
    var container = document.getElementById('content_field');
    container.innerHTML= "";
    
    // template = `<div class="row">`
    isi = `<div class="container"><div class="row">`
    
    Object.keys(data).forEach(function(key) {
      let item = data[key];

      path = "images/"+item.img
      if (item.img!=""){
        img = `<img id="image" id ="image_update" src="{{asset("`+path+`")}}" class="card-img-top img-fluid" alt="Product Image">`
      }else{
        img = `<img id="preview" style="width:100px;height:150px; border: 1px solid #ccc; background-color: #AFACAC; display:block; margin:auto;" class="card-img-top img-fluid">`
      }

      isi += `<div class="col col-md-4"><div class="card" style="max-width: 350px;border-radius:20px"><div class="card-body">`
        +
        img
        +
        `<h5 class="card-title" style ="margin-top:10px">`+item.name+`</h5>
        <p class="card-text" style="color: #A5A5A5;">`+item.mini_desc+`</p>

        <h5 class="card-title" style="font-weight: bold;">Presentation</h5>
        <p class="card-text" style="color: #A5A5A5;">`+item.presentation+`</p>
        
        <h5 class="card-title" style="font-weight: bold;">Price</h5>
        <p class="card-text" style="font-weight: bold;color: #5AFF1C;font-size: 20px;"> Rp `+item.price+`</p>
        
        <p style="color: #A5A5A5;">stock: `+item.qty+` `+item.unit+` left</p>

        <button class="btn btn-info" onclick="getItem(`+item.id+`)"> <i class="fas fa-clipboard-list"></i> Show Detail</button>


        <div class="card-body" style="margin-top:10px">
            
          <div >
            <div class="row">
              <div class="col">

                <div class="form-group">
                  <div class="input-group">
                    <input style="max-width:75px;min-width:50px" class="form-control" id="qty_`+item.name+`" value="`+item.qty_cart+`"  placeholder="Qty" onkeyup="this.value = this.value.replace(/[^0-9]/g, '');" >
                    <div class="input-group-prepend">
                      <div class="input-group-text">`+item.unit+`</div>
                    </div>
                  </div>
                </div>

              </div>
              <div class="col">

                <div class="form-group">
                  <div class="input-group">
                    <input style="max-width:75px;min-width:50px" class="form-control" id="disc_`+item.name+`" value="`+item.disc_cart+`" placeholder="Disc" onkeyup="this.value = this.value.replace(/[^0-9]/g, '');" max=100 oninput="removeLeadingZero(this);">
                    <div class="input-group-prepend">
                      <div class="input-group-text">%</div>
                    </div>
                  </div>
                </div>

              </div>

              </div>
            </div>

          <div ><a class="btn btn-success" onclick="addtoCart(`+item.id+`,'`+item.name+`','product',`+item.priceNum+`)">Add To Cart</a></div>
        </div></div></div></div>
        `
    });

    Object.keys(dataBundle).forEach(function(key) {
      let item = dataBundle[key];

      path = "images/"+item.img
      if (item.img!=""){
        img = `<img id="image" id ="image_update" src="{{asset("`+path+`")}}" class="card-img-top img-fluid" alt="Product Image">`
      }else{
        img = `<img id="preview" style="width:100px;height:150px; border: 1px solid #ccc; background-color: #AFACAC; display:block; margin:auto;" class="card-img-top img-fluid">`
      }

      isi += `<div class="col col-md-4"><div class="card" style="max-width: 350px;border-radius:20px"><div class="card-body">`
        +
        img
        +
        `<h5 class="card-title" style ="margin-top:10px">`+item.name+`</h5>
        <p class="card-text" style="color: #A5A5A5;">`+item.desc+`</p>
        
        <h5 class="card-title" style="font-weight: bold;">Price</h5>
        <p class="card-text" style="font-weight: bold;color: #5AFF1C;font-size: 20px;"> Rp `+item.price+`</p>
        
        <button class="btn btn-info" onclick="getItem(`+item.id+`)"> <i class="fas fa-clipboard-list"></i> Show Detail</button>


        <div class="card-body" style="margin-top:10px">
            
          <div >
            <div class="row">
              <div class="col">

                <div class="form-group">
                  <div class="input-group">
                    <input style="max-width:75px;min-width:50px" class="form-control" id="qty_`+item.name+`" value="`+item.qty_cart+`"  placeholder="Qty" onkeyup="this.value = this.value.replace(/[^0-9]/g, '');" >
                    <div class="input-group-prepend">
                      <div class="input-group-text">Package</div>
                    </div>
                  </div>
                </div>

              </div>
              <div class="col">

                <div class="form-group">
                  <div class="input-group">
                    <input style="max-width:75px;min-width:50px" class="form-control" id="disc_`+item.name+`" value="`+item.disc_cart+`" placeholder="Disc" onkeyup="this.value = this.value.replace(/[^0-9]/g, '');" max=100 oninput="removeLeadingZero(this);">
                    <div class="input-group-prepend">
                      <div class="input-group-text">%</div>
                    </div>
                  </div>
                </div>

              </div>

              </div>
            </div>

          <div ><a class="btn btn-success" onclick="addtoCart(`+item.id+`,'`+item.name+`','paket',`+item.priceNum+`)">Add To Cart</a></div>
        </div></div></div></div>
        `
    });

    isi+=`</div></div>`
    container.innerHTML+=isi;
    
  }


  function getAllDataByCategory(cat){ 
    name = $('#search_product').val();

    var container = document.getElementById('content_field');
    container.innerHTML= "";
    
    // template = `<div class="row">`
    isi = `<div class="container"><div class="row">`

    if(cat=="paket"){
      Object.keys(dataBundle).forEach(function(key) {
        let item = dataBundle[key];

        if(item.name!= "" && !item.name.toLowerCase().includes(name.toLowerCase())){
          return;
        }
        path = "images/"+item.img
        if (item.img!=""){
          img = `<img id="image" id ="image_update" src="{{asset("`+path+`")}}" class="card-img-top img-fluid" alt="Product Image">`
        }else{
          img = `<img id="preview" style="width:100px;height:150px; border: 1px solid #ccc; background-color: #AFACAC; display:block; margin:auto;" class="card-img-top img-fluid">`
        }

        isi += `<div class="col col-md-4"><div class="card" style="max-width: 350px;border-radius:20px"><div class="card-body">`
          +
          img
          +
          `<h5 class="card-title" style ="margin-top:10px">`+item.name+`</h5>
          <p class="card-text" style="color: #A5A5A5;">`+item.desc+`</p>
          
          <h5 class="card-title" style="font-weight: bold;">Price</h5>
          <p class="card-text" style="font-weight: bold;color: #5AFF1C;font-size: 20px;"> Rp `+item.price+`</p>
          
          <button class="btn btn-info" onclick="getItem(`+item.id+`)"> <i class="fas fa-clipboard-list"></i> Show Detail</button>


          <div class="card-body" style="margin-top:10px">
              
            <div >
              <div class="row">
                <div class="col">

                  <div class="form-group">
                    <div class="input-group">
                      <input style="max-width:75px;min-width:50px" class="form-control" id="qty_`+item.name+`" value="`+item.qty_cart+`"  placeholder="Qty" onkeyup="this.value = this.value.replace(/[^0-9]/g, '');" >
                      <div class="input-group-prepend">
                        <div class="input-group-text">Package</div>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="col">

                  <div class="form-group">
                    <div class="input-group">
                      <input style="max-width:75px;min-width:50px" class="form-control" id="disc_`+item.name+`" value="`+item.disc_cart+`" placeholder="Disc" onkeyup="this.value = this.value.replace(/[^0-9]/g, '');" max=100 oninput="removeLeadingZero(this);">
                      <div class="input-group-prepend">
                        <div class="input-group-text">%</div>
                      </div>
                    </div>
                  </div>

                </div>

                </div>
              </div>

            <div ><a class="btn btn-success" onclick="addtoCart(`+item.id+`,'`+item.name+`','paket',`+item.priceNum+`)">Add To Cart</a></div>
          </div></div></div></div>
          `
      });
    }else if(cat=="product"){
      Object.keys(data).forEach(function(key) {
        let item = data[key];
        if(item.name!= "" && !item.name.toLowerCase().includes(name.toLowerCase())){
          return;
        }
        path = "images/"+item.img
        if (item.img!=""){
          img = `<img id="image" id ="image_update" src="{{asset("`+path+`")}}" class="card-img-top img-fluid" alt="Product Image">`
        }else{
          img = `<img id="preview" style="width:100px;height:150px; border: 1px solid #ccc; background-color: #AFACAC; display:block; margin:auto;" class="card-img-top img-fluid">`
        }

        isi += `<div class="col col-md-4"><div class="card" style="max-width: 350px;border-radius:20px"><div class="card-body">`
          +
          img
          +
          `<h5 class="card-title" style ="margin-top:10px">`+item.name+`</h5>
          <p class="card-text" style="color: #A5A5A5;">`+item.mini_desc+`</p>

          <h5 class="card-title" style="font-weight: bold;">Presentation</h5>
          <p class="card-text" style="color: #A5A5A5;">`+item.presentation+`</p>
          
          <h5 class="card-title" style="font-weight: bold;">Price</h5>
          <p class="card-text" style="font-weight: bold;color: #5AFF1C;font-size: 20px;"> Rp `+item.price+`</p>
          
          <p style="color: #A5A5A5;">stock: `+item.qty+` `+item.unit+` left</p>

          <button class="btn btn-info" onclick="getItem(`+item.id+`)"> <i class="fas fa-clipboard-list"></i> Show Detail</button>


          <div class="card-body" style="margin-top:10px">
              
            <div >
              <div class="row">
                <div class="col">

                  <div class="form-group">
                    <div class="input-group">
                      <input style="max-width:75px;min-width:50px" class="form-control" id="qty_`+item.name+`" value="`+item.qty_cart+`"  placeholder="Qty" onkeyup="this.value = this.value.replace(/[^0-9]/g, '');" >
                      <div class="input-group-prepend">
                        <div class="input-group-text">`+item.unit+`</div>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="col">

                  <div class="form-group">
                    <div class="input-group">
                      <input style="max-width:75px;min-width:50px" class="form-control" id="disc_`+item.name+`" value="`+item.disc_cart+`" placeholder="Disc" onkeyup="this.value = this.value.replace(/[^0-9]/g, '');" max=100 oninput="removeLeadingZero(this);">
                      <div class="input-group-prepend">
                        <div class="input-group-text">%</div>
                      </div>
                    </div>
                  </div>

                </div>

                </div>
              </div>

            <div ><a class="btn btn-success" onclick="addtoCart(`+item.id+`,'`+item.name+`','product',`+item.priceNum+`)">Add To Cart</a></div>
          </div></div></div></div>
          `
      });
    }else if(cat=="all"){
      
      Object.keys(data).forEach(function(key) {
        let item = data[key];

        if(item.name!= "" && !item.name.toLowerCase().includes(name.toLowerCase())){
          return;
        }

        path = "images/"+item.img
        if (item.img!=""){
          img = `<img id="image" id ="image_update" src="{{asset("`+path+`")}}" class="card-img-top img-fluid" alt="Product Image">`
        }else{
          img = `<img id="preview" style="width:100px;height:150px; border: 1px solid #ccc; background-color: #AFACAC; display:block; margin:auto;" class="card-img-top img-fluid">`
        }

        isi += `<div class="col col-md-4"><div class="card" style="max-width: 350px;border-radius:20px"><div class="card-body">`
          +
          img
          +
          `<h5 class="card-title" style ="margin-top:10px">`+item.name+`</h5>
          <p class="card-text" style="color: #A5A5A5;">`+item.mini_desc+`</p>

          <h5 class="card-title" style="font-weight: bold;">Presentation</h5>
          <p class="card-text" style="color: #A5A5A5;">`+item.presentation+`</p>
          
          <h5 class="card-title" style="font-weight: bold;">Price</h5>
          <p class="card-text" style="font-weight: bold;color: #5AFF1C;font-size: 20px;"> Rp `+item.price+`</p>
          
          <p style="color: #A5A5A5;">stock: `+item.qty+` `+item.unit+` left</p>

          <button class="btn btn-info" onclick="getItem(`+item.id+`)"> <i class="fas fa-clipboard-list"></i> Show Detail</button>


          <div class="card-body" style="margin-top:10px">
              
            <div >
              <div class="row">
                <div class="col">

                  <div class="form-group">
                    <div class="input-group">
                      <input style="max-width:75px;min-width:50px" class="form-control" id="qty_`+item.name+`" value="`+item.qty_cart+`"  placeholder="Qty" onkeyup="this.value = this.value.replace(/[^0-9]/g, '');" >
                      <div class="input-group-prepend">
                        <div class="input-group-text">`+item.unit+`</div>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="col">

                  <div class="form-group">
                    <div class="input-group">
                      <input style="max-width:75px;min-width:50px" class="form-control" id="disc_`+item.name+`" value="`+item.disc_cart+`" placeholder="Disc" onkeyup="this.value = this.value.replace(/[^0-9]/g, '');" max=100 oninput="removeLeadingZero(this);">
                      <div class="input-group-prepend">
                        <div class="input-group-text">%</div>
                      </div>
                    </div>
                  </div>

                </div>

                </div>
              </div>

            <div ><a class="btn btn-success" onclick="addtoCart(`+item.id+`,'`+item.name+`','product',`+item.priceNum+`)">Add To Cart</a></div>
          </div></div></div></div>
          `
      });


      Object.keys(dataBundle).forEach(function(key) {
        let item = dataBundle[key];
        if(item.name!= "" && !item.name.toLowerCase().includes(name.toLowerCase())){
          return;
        }
        path = "images/"+item.img
        if (item.img!=""){
          img = `<img id="image" id ="image_update" src="{{asset("`+path+`")}}" class="card-img-top img-fluid" alt="Product Image">`
        }else{
          img = `<img id="preview" style="width:100px;height:150px; border: 1px solid #ccc; background-color: #AFACAC; display:block; margin:auto;" class="card-img-top img-fluid">`
        }

        isi += `<div class="col col-md-4"><div class="card" style="max-width: 350px;border-radius:20px"><div class="card-body">`
          +
          img
          +
          `<h5 class="card-title" style ="margin-top:10px">`+item.name+`</h5>
          <p class="card-text" style="color: #A5A5A5;">`+item.desc+`</p>
          
          <h5 class="card-title" style="font-weight: bold;">Price</h5>
          <p class="card-text" style="font-weight: bold;color: #5AFF1C;font-size: 20px;"> Rp `+item.price+`</p>
          
          <button class="btn btn-info" onclick="getItem(`+item.id+`)"> <i class="fas fa-clipboard-list"></i> Show Detail</button>


          <div class="card-body" style="margin-top:10px">
              
            <div >
              <div class="row">
                <div class="col">

                  <div class="form-group">
                    <div class="input-group">
                      <input style="max-width:75px;min-width:50px" class="form-control" id="qty_`+item.name+`" value="`+item.qty_cart+`"  placeholder="Qty" onkeyup="this.value = this.value.replace(/[^0-9]/g, '');" >
                      <div class="input-group-prepend">
                        <div class="input-group-text">Package</div>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="col">

                  <div class="form-group">
                    <div class="input-group">
                      <input style="max-width:75px;min-width:50px" class="form-control" id="disc_`+item.name+`" value="`+item.disc_cart+`" placeholder="Disc" onkeyup="this.value = this.value.replace(/[^0-9]/g, '');" max=100 oninput="removeLeadingZero(this);">
                      <div class="input-group-prepend">
                        <div class="input-group-text">%</div>
                      </div>
                    </div>
                  </div>

                </div>
                
                </div>
              </div>

            <div ><a class="btn btn-success" onclick="addtoCart(`+item.id+`,'`+item.name+`','paket',`+item.priceNum+`)">Add To Cart</a></div>
          </div></div></div></div>
          `
      });
    }

    isi+=`</div></div>`
    container.innerHTML+=isi;
  }

  function addtoCart(id, name, category, price){
  var qty = document.getElementById("qty_"+name).value;
  var disc = document.getElementById("disc_"+name).value;
  $.ajax({
        type: "POST",
        url: "{{url('/')}}"+"/addCart",
        data: { "_token": "{{ csrf_token() }}","id":id,"qty":qty, "category":category, "disc":disc, "price":price},
        beforeSend: $.LoadingOverlay("show"),
        afterSend:$.LoadingOverlay("hide"),
        success: function (data) {
          if(data=="sukses" || data=="sukses_update"){
            AlertSuccess()
          }else if(data=="sukses_delete"){
            document.getElementById("qty_"+name).value= '';
            document.getElementById("disc_"+name).value='';
            AlertSuccess()
          }else{
            AlertError()
          }
        },
        error: function (result, status, err) {
          alert(err)
          AlertError()
        }
      });
}

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


</script>
    
@endpush