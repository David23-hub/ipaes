@extends('adminlte::page')

@section('title', 'Tambah User')

@section('content_header')
    <h1 class="m-0 text-dark">Tambah User</h1>
@stop

@section('content')
    <form action="{{route('users.store')}}" method="post" enctype="multipart/form-data">
        @csrf
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group" >
                        <img id="preview" style="width: 200px; height: 200px; border: 1px solid #ccc; background-color: #f0f0f0;">
                    </div>
                    <div class="form-group" >
                        <label for="img">Image</label>
                        <input type="file" name="img" accept="image/*" id="img"  placeholder="Masukkan Image" onchange="previewImage(event)">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputName">Nama</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="exampleInputName" placeholder="Nama lengkap" name="name" value="{{old('name')}}">
                        @error('name') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail">Email address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail" placeholder="Masukkan Email" name="email" value="{{old('email')}}">
                        @error('email') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPhoneNumber">Phone Number</label>
                        <input type="no_hp" class="form-control @error('no_hp') is-invalid @enderror" id="exampleInputPhoneNumber" placeholder="Masukkan Nomor HP" name="no_hp" value="{{old('no_hp')}}" oninput="addDotPrice(this);">
                        @error('no_hp') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputRole">Role</label>
                        <select  class="form-select form-control" name="role" id="role" style="width: 100%;max-width:100%">
                            <option value="" selected disabled>-- Choose --</option>
                            <option value="admin" >Admin</option>
                            <option value="marketing">Marketing</option>
                            <option value="sales">Sales</option>
                            <option value="finance">Finance</option>
                            <option value="manager">Manager</option>
                            {{-- @foreach($dokter as $dok)
                              <option value={{$dok->id}}>{{$dok->name}}</option>
                            @endforeach --}}
                        </select>
                        {{-- <input type="text" class="form-control @error('role') is-invalid @enderror" id="exampleInputRole" placeholder="Masukkan Role" name="role" value="{{old('email')}}"> --}}

                        @error('role') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="exampleInputPassword" placeholder="Password" name="password">
                        @error('password') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword" placeholder="Konfirmasi Password" name="password_confirmation">
                    </div>
                    
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{route('users.index')}}" class="btn btn-default">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
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
                console.log(reader.result)
                output.src = reader.result;
                output.style.display = 'block'; // Show the image preview
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        function addDotPrice(input) {
      
            input.value = input.value.replace(/[^0-9]/g, '')
        
        }
        
    </script>
@stop