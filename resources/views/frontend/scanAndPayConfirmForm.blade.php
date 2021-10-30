@extends('frontend.layouts.app')
@section('title', 'Scan And Pay Confirm')
@section('subtitle', 'WavePay')

@section('content')
    <div class="transfer_confirm">
        <a href="#" class="btn_back">
            <i class="fas fa-arrow-left mb-4 ml-3"></i>
        </a>
        <div class="d-flex justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('user.scanAndPayComplete')}}" id="scan_and_pay_confirm" method="POST" autocomplete="off">
                            @csrf
                            <input type="hidden" name="to_phone" value="{{$to_account->phone}}">
                            <input type="hidden" name="amount" value="{{$amount}}">
                            <div class="text-center mb-4">
                                <h5 class="mb-3">@lang('public.send_money')</h5>
                                <h4 class="mb-4"><span class="text-primary">{{number_format($amount)}}</span> <span>@lang('public.kyat')</span></h4>
                                <h5 class="mb-4">@lang('public.to')</h5>
                                <h4 class="font-weight-bold">{{ str_replace(0, '', $to_account->phone) }}</h4>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-6 pl-3">
                                    <p class="mb-0">@lang('public.amount')</p> 
                                </div>
                                <div class="col-6 text-right">
                                    <p class="eng_letter mb-0"><span class="font-weight-bold">{{number_format($amount)}}</span> <span>@lang('public.kyat')</span></p>
                                </div>
                            </div>
                            <hr>
                            
                            <p class="mt-4 mb-0">@lang('public.balance') - <span class="eng_letter text-primary">{{number_format($remainingAmount)}}</span> <span>@lang('public.kyat')</span></p>
                            <button type="submit" class="btn btn-primary btn-block confirm-btn mt-5">@lang('public.confirm')</button>
                        </form>
    
                        @if ($errors->any())
                            <div class="card mt-3 border-danger">
                                <div class="card-body">
                                    @foreach ($errors->all() as $error)
                                        <div class="text-center">
                                            <p class="mb-0">{{$error}}</p>                                    
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    {!! JsValidator::formRequest('App\Http\Requests\ScanAndPayFormRequest', '#scan_and_pay_confirm') !!}
    <script>
        $(document).ready(function() {
            $('.confirm-btn').on('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: '@lang('public.enter_pin')',
                    html: '<input type="password" class="form-control password text-center"/>',
                    showCloseButton: true,
                    showCancelButton: true,
                    reverseButtons: true,
                    focusConfirm: true,
                    confirmButtonText: '@lang('public.confirm')',
                    cancelButtonText: '@lang('public.cancel')',
                    didOpen: () => {
                        Swal.getHtmlContainer().querySelector('.password').focus()
                    }
                }).then((result) => {
                    if(result.isConfirmed) {
                        let password = $('.password').val();
                        $.ajax({
                            url : `/password-check?password=${password}`,
                            type : `GET`,
                            success : function(res) {
                               if(res.status == 'success') {
                                    $('#scan_and_pay_confirm').submit();
                               }
                               if(res.status == 'fail') {
                                    Swal.fire({
                                        icon: 'error',
                                        text: res.message,
                                    })
                                }
                            }
                        })
                    }
                })
            })
        })
    </script>
@endsection