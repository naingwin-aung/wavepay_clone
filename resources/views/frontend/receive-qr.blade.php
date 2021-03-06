@extends('frontend.layouts.app')
@section('title', 'Receive-qr')
@section('subtitle', 'WavePay')

@section('content')
    <div class="receive-qr">
        <div class="d-flex justify-content-center">
            <div class="col-md-8">
                <h5 class="pb-5 text-center">@lang('public.show_qr')</h5>
                <div class="d-flex justify-content-center mt-5">
                    <div class="text-center p-4 qr-code">
                        {!! QrCode::size(170)->generate($user->phone); !!}
                    </div>
                </div>
                <div class="text-center mt-2">
                    <p class="mb-2">@lang('public.my_number')</p>
                    <h5 class="font-weight-bold">{{ str_replace('0', '', $user->phone)}}</h5>
                </div>
            </div>
        </div>
    </div>
@endsection

