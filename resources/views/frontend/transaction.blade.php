@extends('frontend.layouts.app')
@section('title', 'Transaction')
@section('subtitle')
    <span class="text-dark font-weight-bold h5">စာရင်း</span>
@endsection

@section('content')
    @if ($transactions->count())
        <div class="transaction">
            <div class="d-flex justify-content-center">
                <div class="col-md-8 px-1">
                    <div class="infinite_scroll">
                        @foreach ($transactions as $transaction)
                            <div class="card mb-1">
                                <div class="card-body py-3 px-3">
                                    <p class="mb-2 font-weight-bold">{{$transaction->created_at->toFormattedDateString()}}</p>
                                    <div class="row">
                                        <div class="col-1">
                                            @if ($transaction->type == 'expense')
                                                @if (!$transaction->source_id)
                                                    <img src="{{asset('/images/topup.png')}}" class="mt-1" width="25px" alt="bill">
                                                @else
                                                    <img src="{{asset('/images/transfer.png')}}" alt="money transfer" class="mt-1" width="25px">
                                                @endif
                                            @else 
                                                <img src="{{asset('/images/arrow.png')}}" alt="money transfer" class="mt-2" width="20px">
                                            @endif
                                        </div>
                                        <div class="col-7 ml-4 px-0">
                                        @if ($transaction->type == 'income')
                                                <p class="mb-1 font-weight-bold">ငွေသွင်း</p>
                                        @else @if ($transaction->type == 'expense')
                                                @if (!$transaction->source_id)
                                                    <p class="mb-1 font-weight-bold">ဖုန်းဘေလ်ဖြည့်ခြင်း</p>
                                                @else
                                                    <p class="mb-1 font-weight-bold">ငွေလွှဲ</p>
                                                @endif
                                            @endif
                                        @endif
                                            
                                        @if ($transaction->source_id)
                                                <p class="mb-1">{{$transaction->type == 'income' ? 'မှ' : 'သို့'}} - <span class="eng_letter">{{$transaction->source ? $transaction->source->phone : ' - '}}</span></p>
                                        @endif
                                        @if ($transaction->source_id === 0)
                                            <p class="mb-1">Wave Pay ဆိုင် မှ</span></p>
                                        @endif
                                        <p class="mb-1">လုပ်ငန်းစဥ်အမှတ်- {{$transaction->trx_id}}</p>
                                        </div>
                                        <div class="col-3 px-0 text-right">
                                            @if ($transaction->type == 'income')
                                                <p><span class="text-primary">+{{number_format($transaction->trx_amount)}} ကျပ်</span></p>
                                        @else @if ($transaction->type == 'expense')
                                                <p><span class="text-danger">-{{number_format($transaction->trx_amount)}} ကျပ်</span></p>
                                            @endif
                                        @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="d-none">
                            {{ $transactions->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else 
        <h5 class="text-muted text-center">No Notifications</h5>
    @endif
@endsection
@section('script')
<script>
    $('ul.pagination').hide();
    $(function() {
        let options = {
            autoTrigger: true,
            loadingHtml: '<div class="text-primary">Loading......</div>',
            padding: 0,
            nextSelector: '.pagination li.active + li a',
            contentSelector: 'div.infinite_scroll',
            callback: function() {
                $('ul.pagination').remove();
            }
        }

        $('.infinite_scroll').jscroll(options);
    })
</script>
@endsection
