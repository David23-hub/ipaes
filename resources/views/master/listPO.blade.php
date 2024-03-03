@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Transaction</h1>
@stop

@section('content')
    <div class="card">
      <div class="card-header">
        <h5 style="font-weight: 600">Transaction List</h5>
      </div>
      <div class="card-body">
        <table id="tableList" class="table table-bordered" >
          <thead>
            <tr>
                <th>Doctor</th>
                <th>Clinic</th>
                <th>NoHp</th>
                <th>Transaction</th>
                <th>Action</th>
            </tr>
          </thead>
          {{-- <tbody>
            @foreach ($data as $item)
            <tr>
              <td>{{ $item['name'] }}</td>
              <td>{{ $item['clinic'] }}</td>
              <td>{{ $item['no_hp'] }}</td>
              <td>{{ $item['total_transaction'] }}</td>
              <td><a class="btn btn-info" href="{{url('detailPO/'. $item['id'])}}">Detail</a></td>
            </tr>
            @endforeach
          </tbody> --}}
        </table>
      </div>
    </div>

@stop

@push('js')
<script>
  dokter = @json($data);
  console.log(dokter, 'current_page')
  window.onload = function() {
    getAllData()
  };

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

    $('#tableList').on('search.dt', function () {
      var value = $('.dataTables_filter input').val();
      console.log(value); // <-- the value
    })

    function getAllData(){
      $.ajax({
      type: "POST",
      url: "{{url('/')}}"+"/getAllPO",
      beforeSend: $.LoadingOverlay("show"),
      afterSend:$.LoadingOverlay("hide"),
      data: { "_token": "{{ csrf_token() }}"},
      success: function (data) {
        console.log({data}, "dataaa")
        dataTable.clear();
        dataTable.draw();
        no = 0
        $.each(data,function(i, item){
          no++
          stat = "Active"
          if(item['status']==0){
            stat = "InActive"
          }

          const urlDetail = "detailPO/" + item["id"]
          // alert(urlDetail)
          // console.log("detailPO/" + item["id"], "url")
          dataTable.row.add([
              item['name'],
              item['clinic'],
              item['no_hp'],
              item['total_transaction'],
              `<a class="btn btn-info" href="{{url('${urlDetail}')}}">Detail</a>`
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

</script>
    
@endpush