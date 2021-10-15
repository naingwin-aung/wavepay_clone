@extends('frontend.layouts.app')
@section('title', 'Notificatios')
@section('subtitle', 'WavePay')

@section('content')
    @if ($notifications->count())
        <div class="notification">
            <div class="d-flex justify-content-center">
                <div class="col-md-8 px-1">
                    <div class="infinite-scroll">
                        @foreach ($notifications as $notification)
                            <a href="{{route('user.notificationshow', $notification->id)}}">
                                <div class="card mb-1">
                                    <div class="card-body py-3">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="font-weight-bold">{{$notification->data['title']}}</h6>
                                            @if (is_null($notification->read_at))
                                                <i class="fas fa-envelope text-danger" title="Mark as read"></i>
                                            @endif
                                        </div>
                                        <p class="mb-1">{{Illuminate\Support\Str::limit($notification->data['message'], 50)}}</p>
                                        <small class="text-muted">
                                            {{$notification->created_at->toFormattedDateString()}} - 
                                            {{$notification->created_at->format('h:i:s A')}}
                                        </small>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                        <div class="d-none">
                            {{$notifications->links()}}
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
            $('.infinite-scroll').jscroll({
                autoTrigger: true,
                loadingHtml: '<div class="text-primary">Loading......</div>',
                padding: 0,
                nextSelector: '.pagination li.active + li a',
                contentSelector: 'div.infinite-scroll',
                callback: function() {
                    $('ul.pagination').remove();
                }
            })
        })
    </script>
@endsection

