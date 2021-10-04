<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/frontend/style.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <div class="side_nav">
            <div class="user_info text-center my-2 mb-4">
                <img src="{{auth()->user()->profile_img_path()}}" alt="User Image" class="profile_img">
                <h4>{{auth()->user()->name}}</h4>
                <p>{{number_format(Auth::user()->wallet->amount)}} <span>ကျပ်</span></p>
            </div>
            <div>
                <a href="#" class="">
                    <div class="d-flex justify-content-between">
                        <div>
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="mr-4">
                            ကိုယ်ရေးအချက်အလက်
                        </div>
                    </div>
                </a>
                <hr>
            </div>
        </div>
        <div class="app_bar">
            <div class="d-flex justify-content-center">
                <div class="col-md-8 d-flex justify-content-between">
                    <a href="#" id="show_sidenav"><i class="fas fa-bars"></i></a>
                    <h4 class="mb-0 logo">WAVEPAY</h4>
                    <a href="#"></a>
                </div>
            </div>
        </div>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#show_sidenav').click(function(e) {
                e.preventDefault();
                $('.side_nav').css("display", "block");
                $('.side_nav').css("animation-name", "fade_in_show");
                $('.side_nav').css("animation-duration", "0.8s");
            })

            document.addEventListener('click', function(event) {
                if(document.getElementById('show_sidenav') && document.getElementById('show_sidenav').contains(event.target)) {
                    $('.side_nav').css("display", "block");
                    $('.side_nav').css("animation-name", "fade_in_show");
                    $('.side_nav').css("animation-duration", "0.8s");
                    document.body.style.backgroundColor = 'rgba(0,0,0,0.4)';
                }else if(!document.getElementById('show_sidenav').contains(event.target)) {
                    $('.side_nav').css("display", "none");
                    document.body.style.backgroundColor = 'white';
                }
            });
        })
    </script>
</body>
</html>
