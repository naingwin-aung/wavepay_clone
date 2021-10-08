@extends('frontend.layouts.app')
@section('title', 'Transfer Confirm')

@section('content')
    <div class="transfer_confirm">
        <i class="fas fa-arrow-left mb-4 ml-3"></i>
        <div class="d-flex justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('user.transferComplete')}}" id="transfer" method="POST" autocomplete="off">
                            @csrf
                            <input type="hidden" name="to_phone" value="{{$to_account->phone}}">
                            <input type="hidden" name="amount" value="{{$amount}}">
                            <div class="text-center mb-4">
                                <h5 class="mb-3">ငွေလွှဲ</h5>
                                <h4 class="mb-4"><span class="text-primary">{{number_format($amount)}}</span> ကျပ်</h4>
                                <h5 class="mb-4">သို့</h5>
                                <h4 class="font-weight-bold">{{$to_account->phone}}</h4>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-6 pl-4">
                                    <p class="mb-0">ငွေပမာဏ</p> 
                                </div>
                                <div class="col-6 text-right">
                                    <p class="eng_letter mb-0"><span class="font-weight-bold">{{number_format($amount)}}</span> ကျပ်</p>
                                </div>
                            </div>
                            <hr>
    
                            <button type="submit" class="btn btn-primary btn-block confirm-btn mt-5">သေချာပါသည်။</button>
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
    {!! JsValidator::formRequest('App\Http\Requests\TransferFormRequest', '#transfer') !!}
    <script>
        $(document).ready(function() {
            $('.confirm-btn').on('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'လျို့၀ှက် နံပါတ်ထည့်ပါ။',
                    html: '<input type="password" class="form-control password text-center"/>',
                    showCloseButton: true,
                    showCancelButton: true,
                    reverseButtons: true,
                    focusConfirm: true,
                    confirmButtonText: 'သေချာပါသည်။',
                    cancelButtonText: 'မဟုတ်ပါ။',
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
                                    $('#transfer').submit();
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