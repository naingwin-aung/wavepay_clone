@extends('frontend.layouts.app')
@section('title', 'TopUp Complete')
@section('subtitle', 'WavePay')

@section('content')
    <div class="topup_complete">
        <a href="#" class="btn_back">
            <i class="fas fa-arrow-left mb-4 ml-3"></i>
        </a>
        <div class="d-flex justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('user.topUpComplete')}}" method="POST" autocomplete="off" id="top_up_complete">
                            @csrf
                            <input type="hidden" name="bill_amount" value="{{$bill_amount}}">
                            <input type="hidden" name="bill_phone" value="{{$bill_phone}}">
                            <input type="hidden" name="billPhoneName" value="{{$billPhoneName}}">
                            <div class="text-center mb-4">
                                <h5 class="mb-3">@lang('public.topup')</h5>
                                <h4 class="mb-3"><span class="text-primary">{{number_format($bill_amount)}}</span> <span>@lang('public.kyat')</span></h4>
                                <h5 class="mb-3">@lang('public.for')</h5>
                                <h4 class="font-weight-bold">{{ str_replace(0, '', $bill_phone) }}</h4>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-6 pl-3">
                                    <p class="mb-0">@lang('public.operator')</p> 
                                </div>
                                <div class="col-6 text-right">
                                    <p class="eng_letter mb-0"><span class="font-weight-bold">{{ucfirst($billPhoneName)}}</span></p>
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-6 pl-3">
                                    <p class="mb-0">@lang('public.amount')</p> 
                                </div>
                                <div class="col-6 text-right">
                                    <p class="eng_letter mb-0"><span class="font-weight-bold">{{number_format($bill_amount)}}</span> <span>@lang('public.kyat')</span></p>
                                </div>
                            </div>
                            <hr>
                            
                            <p class="mt-4 mb-3">@lang('public.balance') - <span class="eng_letter text-primary">{{number_format($remainingAmount)}}</span> <span>@lang('public.kyat')</span></p>

                            @include('frontend.layouts.flash')

                            <button type="submit" class="btn btn-primary btn-block confirm-btn mt-5">@lang('public.confirm')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
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
                                    $('#top_up_complete').submit();
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

