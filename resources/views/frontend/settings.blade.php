@extends('frontend.layouts.app')
@section('title', 'Settings')
@section('subtitle')
    <p class="mb-0 text-dark h5">Settings</p>
@endsection

@section('content')
    <div class="scanPay">
        <div class="d-flex justify-content-center">
            <div class="col-md-8">
                <a href="{{route('user.changeLanguage')}}">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <p class="text-muted mb-0">Language/ ဘာသာစကား</p>
                                <div>
                                    <img src="{{asset('/images/uk.png')}}" alt="uk" width="25px" class="mr-2">
                                    <img src="{{asset('/images/myanmar.png')}}" alt="mynamar" width="25px">
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection