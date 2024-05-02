@extends('adminlte::master')

@php( $dashboard_url = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home') )

@if (config('adminlte.use_route_url', false))
    @php( $dashboard_url = $dashboard_url ? route($dashboard_url) : '' )
@else
    @php( $dashboard_url = $dashboard_url ? url($dashboard_url) : '' )
@endif

@section('adminlte_css')
    @stack('css')
    @yield('css')
@stop

{{-- @section('classes_body'){{ ($auth_type ?? 'login') . '-page' }}@stop --}}

@section('body')
    {{-- <div class="{{ $auth_type ?? 'login' }}-box"> --}}
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-12" style="margin-top: 15vh">
                <div class="card">
                    <div class="card-body">
                        {{-- Logo --}}
                        {{-- <div class="{{ $auth_type ?? 'login' }}-logo"> --}}
                        <div class="">
                            <a href="{{ $dashboard_url }}">
                
                                {{-- Logo Image --}}
                                @if (config('adminlte.auth_logo.enabled', false))
                                    <img class="img-fluid" src="{{ asset(config('adminlte.auth_logo.img.path')) }}"
                                        alt="{{ config('adminlte.auth_logo.img.alt') }}"
                                        @if (config('adminlte.auth_logo.img.class', null))
                                            class="{{ config('adminlte.auth_logo.img.class') }}"
                                        @endif
                                        @if (config('adminlte.auth_logo.img.width', null))
                                            width="{{ config('adminlte.auth_logo.img.width') }}"
                                        @endif
                                        @if (config('adminlte.auth_logo.img.height', null))
                                            height="{{ config('adminlte.auth_logo.img.height') }}"
                                        @endif
                                    >
                                @else
                                    <img src="{{ asset(config('adminlte.logo_img')) }}"
                                        alt="{{ config('adminlte.logo_img_alt') }}" height="50">
                                @endif
                
                                {{-- Logo Label --}}
                                {{-- {!! config('adminlte.logo', 'Title Store') !!} --}}
                
                            </a>
                        </div>

                        <div>
                            <h1 class="font-weight-bold" style="color:dodgerblue">Log in.</h1>
                        </div>

                        <div>
                            <p>Enter your username and password to enter application.</p>
                        </div>
                
                        {{-- Card Box --}}
                        {{-- <div class="card {{ config('adminlte.classes_auth_card', 'card-outline card-primary') }}"> --}}
                        <div class="">
                
                            {{-- Card Header --}}
                            {{-- @hasSection('auth_header')
                                <div class="card-header {{ config('adminlte.classes_auth_header', '') }}">
                                    <h3 class="card-title float-none text-center">
                                        @yield('auth_header')
                                    </h3>
                                </div>
                            @endif --}}
                
                            {{-- Card Body --}}
                            {{-- <div class="card-body {{ $auth_type ?? 'login' }}-card-body {{ config('adminlte.classes_auth_body', '') }}"> --}}
                            <div class="card-body {{ config('adminlte.classes_auth_body', '') }}">
                                @yield('auth_body')
                            </div>
                
                            {{-- Card Footer --}}
                            @hasSection('auth_footer')
                                <div class="card-footer {{ config('adminlte.classes_auth_footer', '') }}">
                                    @yield('auth_footer')
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block" style="margin-top: 15vh">
                <div class="owl-carousel owl-theme">
                    <div class="item">
                        <img class="img-fluid" src="{{ asset("vendor/adminlte/dist/img/exomide.png") }}">
                    </div>
                    <div class="item">
                        <img class="img-fluid" src="{{ asset("vendor/adminlte/dist/img/Group-42.png") }}">
                    </div>
                    <div class="item">
                        <img class="img-fluid" src="{{ asset("vendor/adminlte/dist/img/image-45.png") }}">
                    </div>
                    <div class="item">
                        <img class="img-fluid" src="{{ asset("vendor/adminlte/dist/img/image-47.png") }}">
                    </div>
                    <div class="item">
                        <img class="img-fluid" src="{{ asset("vendor/adminlte/dist/img/image-49.png") }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('js')
<script>
    $('.owl-carousel').owlCarousel({
        items: 1,
          loop:true,
          margin:10,
          // nav:true,
          autoplay:true,
          autoplayTimeout:1000,
          autoplayHoverPause:true,
          responsiveClass:true,
        //   responsive:{
        //       0:{
        //           items:1
        //       }
        //   }
      })
</script>
@endpush

@section('adminlte_js')
    @stack('js')
    @yield('js')
@stop