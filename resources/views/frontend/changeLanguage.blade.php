@extends('frontend.layouts.app')
@section('title', 'Change Language')
@section('subtitle')
    <p class="mb-0 text-dark h5">Change Language</p>
@endsection

@section('content')
    <div class="scanPay">
        <div class="d-flex justify-content-center">
            <div class="col-md-8">
                <a href="{{route('user.setLang', 'mm')}}">
                    <div class="card mb-1">
                        <div class="card-body py-3">
                            @if (App::isLocale('mm'))
                                <p class="d-inline text-primary mr-2"><i class="fas fa-check"></i></p>
                            @endif
                            <img src="{{asset('/images/myanmar.png')}}" alt="myanmar" width="25px" class="mr-2">
                            <p class="d-inline-block mb-0">မြန်မာ(unicode)</p>
                        </div>
                    </div>
                </a>
                <a href="{{route('user.setLang', 'en')}}">
                    <div class="card">
                        <div class="card-body py-3">
                            @if (App::isLocale('en'))
                                <p class="d-inline text-primary mr-2"><i class="fas fa-check"></i></p>
                            @endif
                            <img src="{{asset('/images/uk.png')}}" alt="uk" width="25px" class="mr-2">
                            <p class="d-inline-block mb-0">English</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection