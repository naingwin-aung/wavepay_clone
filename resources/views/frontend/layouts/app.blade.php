<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
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
    <div id="overlay"></div>
    <div id="app">
        <div class="side_nav">
            <div class="user_info text-center mb-4">
                <img src="{{auth()->user()->profile_img_path()}}" alt="User Image" class="profile_img mb-3">
                <h5>{{auth()->user()->name}}</h5>
                <p class="text-primary">{{Auth::user()->wallet ? number_format(Auth::user()->wallet->amount) : ' - '}} <span>ကျပ်</span></p>
            </div>
            <div>
                <a href="{{route('user.info')}}" class="">
                    <div class="d-flex justify-content-around">
                        <div>
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="mr-4">
                            ကိုယ်ရေးအချက်အလက်
                        </div>
                    </div>
                </a>
                <hr>
                <a href="#" class="logout_btn">
                    <div class="d-flex justify-content-around">
                        <div>
                            <i class="fas fa-sign-out-alt"></i>
                        </div>
                        <div class="mr-4">
                            ထွက်မည်။
                        </div>
                        <form action="{{route('logout')}}" method="POST" id="logout_submit">
                            @csrf
                        </form>
                    </div>
                </a>
                <hr>
            </div>
        </div>
        
        <div class="app_bar">
            <div class="d-flex justify-content-center">
                <div class="col-md-8">
                    <div class="d-flex justify-content-between">
                        @if (Request::is('transaction'))
                            <a href="#" class="btn_back">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        @else
                            <a href="#" id="show_sidenav"><i class="fas fa-bars"></i></a>
                        @endif
                        <h4 class="mb-0 logo">@yield('subtitle')</h4>
                        <a href="#"></a>
                    </div>
                </div>
            </div>
            @yield('user_home')
        </div>
        
        <main class="py-4 px-1">
            @yield('content')
        </main>

        <div class="bottom_bar">
            <div class="d-flex justify-content-center">
                <div class="col-md-8">
                    <div class=" d-flex justify-content-between">
                        <div class="text-center">
                            <a href="{{route('user.home')}}"><i class="fas fa-home p-0"></i> <p class="mb-0">ပင်မ</p></a>
                        </div>
                        <div class="text-center">
                            <a href="#"><img src="{{asset('images/qr-code.png')}}" alt="Qr-code"> <p class="mb-0">My QR</p></a>
                        </div>
                        <div class="text-center">
                            <a href="#"><img src="{{asset('images/scan.png')}}" alt="Qr-code"> <p class="mb-0">QR ပေး</p></a>
                        </div>
                        <div class="text-center">
                            <a href="#"><img src="{{asset('images/envelope.png')}}" alt="Qr-code"> <p class="mb-0">၀င်စာ</p></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {{-- Sweet Alert --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    {{-- Push Noti --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/push.js/1.0.8/push.min.js" integrity="sha512-eiqtDDb4GUVCSqOSOTz/s/eiU4B31GrdSb17aPAA4Lv/Cjc8o+hnDvuNkgXhSI5yHuDvYkuojMaQmrB5JB31XQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @yield('script')
    <script>
        $(document).ready(function() {
            $('#show_sidenav').click(function(e) {
                e.preventDefault();
                $('.side_nav').css("width", "67%");
                document.getElementById("overlay").style.display = "block";    
            })

            document.addEventListener('click', function(event) {
                if(document.getElementById('show_sidenav') && document.getElementById('show_sidenav').contains(event.target)) {
                    $('.side_nav').css("width", "67%");
                    document.getElementById("overlay").style.display = "block";    
                }else if(!document.querySelector('.side_nav').contains(event.target)) {
                    $('.side_nav').css("width", "0");
                    document.getElementById("overlay").style.display = "none";    
                }
            });

            $('.btn_back').click(function(e) {
                e.preventDefault();
                window.history.go(-1);
                return false;
            })

            $('.logout_btn').click(function(e) {
                e.preventDefault();
                swal({
                    text: "You want to Logout!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    width : '28px'
                    })
                    .then((willLogout) => {
                    if (willLogout) {
                        $('#logout_submit').submit();
                    }
                });
            })
        })
    </script>
</body>
</html>
