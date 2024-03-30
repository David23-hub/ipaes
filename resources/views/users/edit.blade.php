@extends('adminlte::page')

@section('title', 'Edit User')

@section('content_header')
    <h1 class="m-0 text-dark">Edit User</h1>
@stop

@section('content')
    <form action="{{route('users.update', $user)}}" method="post">
        @method('PUT')
        @csrf
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    {{-- <div class="form-group">
                        <label for="exampleInputName">Nama</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="exampleInputName" placeholder="Nama lengkap" name="name" value="{{$user->name ?? old('name')}}">
                        @error('name') <span class="text-danger">{{$message}}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail">Email address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail" placeholder="Masukkan Email" name="email" value="{{$user->email ?? old('email')}}">
                        @error('email') <span class="text-danger">{{$message}}</span> @enderror
                    </div> --}}
                    @if(auth()->user()->id != $user->id)
                    <div class="form-group">
                        <label for="exampleInputRole">Role</label>
                        <select  class="form-select form-control" value="{{$user->role}}" name="role" id="role" style="width: 100%;max-width:100%">
                            <option value="" disabled>-- Choose --</option>
                            <option value="admin" {{ "admin" == $user->role ? "selected" : "" }}>Admin</option>
                            <option value="marketing" {{ "marketing" == $user->role ? "selected" : "" }}>Marketing</option>
                            <option value="sales" {{ "sales" == $user->role ? "selected" : "" }}>Sales</option>
                            <option value="finance" {{ "finance" == $user->role ? "selected" : "" }}>Finance</option>
                            <option value="manager" {{ "manager" == $user->role ? "selected" : "" }}>Manager</option>
                            {{-- @foreach($dokter as $dok)
                              <option value={{$dok->id}}>{{$dok->name}}</option>
                            @endforeach --}}
                        </select>
                        {{-- <input type="text" class="form-control @error('role') is-invalid @enderror" id="exampleInputRole" placeholder="Masukkan Role" name="role" value="{{old('email')}}"> --}}

                        @error('role') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    @else
                    <div class="form-group" style="display: none">
                        <label for="exampleInputRole">Role</label>
                        <select  class="form-select form-control" value="{{$user->role}}" name="role" id="role" style="width: 100%;max-width:100%">
                            <option value="" disabled>-- Choose --</option>
                            <option value="admin" {{ "admin" == $user->role ? "selected" : "" }}>Admin</option>
                            <option value="marketing" {{ "marketing" == $user->role ? "selected" : "" }}>Marketing</option>
                            <option value="sales" {{ "sales" == $user->role ? "selected" : "" }}>Sales</option>
                            <option value="finance" {{ "finance" == $user->role ? "selected" : "" }}>Finance</option>
                            <option value="manager" {{ "manager" == $user->role ? "selected" : "" }}>Manager</option>
                            {{-- @foreach($dokter as $dok)
                              <option value={{$dok->id}}>{{$dok->name}}</option>
                            @endforeach --}}
                        </select>
                        {{-- <input type="text" class="form-control @error('role') is-invalid @enderror" id="exampleInputRole" placeholder="Masukkan Role" name="role" value="{{old('email')}}"> --}}

                        @error('role') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    @endif


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
@stop