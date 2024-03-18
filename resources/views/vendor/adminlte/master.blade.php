<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    {{-- Base Meta Tags --}}
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Custom Meta Tags --}}
    @yield('meta_tags')

    {{-- Title --}}
    <title>
        @yield('title_prefix', config('adminlte.title_prefix', ''))
        @yield('title', config('adminlte.title', 'AdminLTE 3'))
        @yield('title_postfix', config('adminlte.title_postfix', ''))
    </title>

    {{-- Custom stylesheets (pre AdminLTE) --}}
    @yield('adminlte_css_pre')

    {{-- Base Stylesheets --}}
    @if(!config('adminlte.enabled_laravel_mix'))
        <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">

        @if(config('adminlte.google_fonts.allowed', true))
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        @endif
    @else
        <link rel="stylesheet" href="{{ mix(config('adminlte.laravel_mix_css_path', 'css/app.css')) }}">
    @endif

    {{-- Extra Configured Plugins Stylesheets --}}
    @include('adminlte::plugins', ['type' => 'css'])

    {{-- Livewire Styles --}}
    @if(config('adminlte.livewire'))
        @if(app()->version() >= 7)
            @livewireStyles
        @else
            <livewire:styles />
        @endif
    @endif

    {{-- Custom Stylesheets (post AdminLTE) --}}
    @yield('adminlte_css')

    {{-- Favicon --}}
    @if(config('adminlte.use_ico_only'))
        <link rel="shortcut icon" href="{{ asset('assets/img/icon-title.png') }}" />
    @elseif(config('adminlte.use_full_favicon'))
        <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}" />
        <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicons/apple-icon-57x57.png') }}">
        <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicons/apple-icon-60x60.png') }}">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicons/apple-icon-72x72.png') }}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicons/apple-icon-76x76.png') }}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicons/apple-icon-114x114.png') }}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicons/apple-icon-120x120.png') }}">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicons/apple-icon-144x144.png') }}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicons/apple-icon-152x152.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-icon-180x180.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicons/favicon-16x16.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicons/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicons/favicon-96x96.png') }}">
        <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('favicons/android-icon-192x192.png') }}">
        <link rel="manifest" crossorigin="use-credentials" href="{{ asset('favicons/manifest.json') }}">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="{{ asset('favicon/ms-icon-144x144.png') }}">
    @endif

</head>

<body class="@yield('classes_body')" @yield('body_data')>

    {{-- Body Content --}}
    @yield('body')

    {{-- Base Scripts --}}
    @if(!config('adminlte.enabled_laravel_mix'))

        {{-- <script src="{{ asset('vendor/moment/moment.min.js') }}"></script> --}}
        <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
        <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

        {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> --}}
        
       
        {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

        {{-- <script type="text/javascript" src="//code.jquery.com/jquery-1.11.3.min.js"></script> --}}
        {{-- <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> --}}
        
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
        <link href="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.css" rel="stylesheet"/>

        {{-- datatable plugin --}}
        {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>  --}}
        <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>

        <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
        <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
        
        {{-- loading animation --}}
        <!-- Add LoadingOverlay CSS from CDN -->
        
        <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
        

        
{{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> --}}
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

        


    @else
        <script src="{{ mix(config('adminlte.laravel_mix_js_path', 'js/app.js')) }}"></script>
    @endif

    <script>

        //NOTIF
        // $(document).ready(function() {
        //     function beep() {
        //         var sound = new Audio('/sounds/notification.mp3');  
        //         sound.play()
        //             .then(() => {
        //             })
        //             .catch(error => {
        //                 // Handle error
        //                 console.log('Failed to play audio:', error);
        //             });
        //     }

        //     function getNotif(){
        //             $.ajax({
        //                 type: "POST",
        //                 url: "{{url('/')}}"+"/getNotif",
        //                 data: { "_token": "{{ csrf_token() }}"},
        //                 success: function (data) {
        //                     if(data.length!=0){
        //                         var counting = document.getElementById('notif-body');
        //                         var count = document.getElementById('notif-count').innerHTML
        //                         if (count==-1 || count > data.length){
        //                             document.getElementById('notif-count').innerHTML=data.length;
        //                         }else if(count<data.length){
        //                             document.getElementById('notif-count').innerHTML=data.length;
        //                             beep();
        //                         }


        //                         counting.innerHTML=""
        //                         isi=""
        //                         data.forEach(item => {
        //                             if(item.deleted_by==null){
        //                                 isi+=`<a class="btn btn-primary btn-flat float-right btn-block
        //                                 href="#"><li class="fas fa-fw fa-exclamation-circle"></li>`+
        //                                 item.msg
        //                                 +`</a>`
        //                             }else{
        //                                 isi+=`<a class="btn btn-default btn-flat float-right btn-block
        //                                 href="#"><li class="fas fa-fw fa-exclamation-circle"></li>`+
        //                                 item.msg
        //                                 +`</a>`
        //                             }
                                    
        //                         });
        //                         counting.innerHTML+=isi;
        //                     }else{
        //                          document.getElementById('notif-count').innerHTML=0
        //                     }
        //                 },
        //                 error: function (result, status, err) {
        //                     alert(err)
        //                     AlertErrorWithMessage("Please Refresh The Page!")
        //                 }
        //             });
        //             setTimeout(function() {
        //                 getNotif()
        //             }, 5000);
        //     }

        //     getNotif()
        // });

    
    
    function FormatTimeStamp(str, date) {
      if(str==null || str=="" ){
        return "-"
      }
      var d = new Date(date),
      month = '' + d.getMonth(),
      day = '' + d.getDate(),
      year = d.getFullYear();

      if (month.length < 2) 
          month = '0' + month;
      if (day.length < 2) 
          day = '0' + day;

      hour = '' + d.getHours(),
      minutes = '' + d.getMinutes(),
      second = d.getSeconds();

      if (minutes.length < 2) 
          minutes = '0' + minutes;
      if (second.length < 2) 
          second = '0' + second;
      if (hour.length < 2) 
          hour = '0' + hour;
      
      temp1 = [day, month, year].join('-')
      temp2 = [hour,minutes,second].join(':')
      return str + " | " + temp1 + " " + temp2
    }

    function AlertSuccess(){
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Your data has been saved!',
        })
    }

    function AlertError(){
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Something went wrong!',
        })
    }
    function AlertErrorWithMessage(msg){
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: msg,
        })
    }

    function AlertWarningWithMsg(msg){
        Swal.fire({
            icon: 'warning',
            title: 'Error',
            text: msg,
        })
    }

    </script>

    {{-- Extra Configured Plugins Scripts --}}
    @include('adminlte::plugins', ['type' => 'js'])

    {{-- Livewire Script --}}
    @if(config('adminlte.livewire'))
        @if(app()->version() >= 7)
            @livewireScripts
        @else
            <livewire:scripts />
        @endif
    @endif

    {{-- Custom Scripts --}}
    @yield('adminlte_js')

</body>

</html>
