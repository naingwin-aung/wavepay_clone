@extends('frontend.layouts.app')
@section('title', 'ScanPay')
@section('subtitle', 'WavePay')

@section('content')
    <div class="scanPay">
        <div class="d-flex justify-content-center align-items-center" style="height: 60vh">
            <div class="col-md-8 p-0">
                @include('frontend.layouts.flash')
                <h5 class="text-center mb-4">Wave Pay QR ကို Scan ဖတ်ပါ။</h5>
                <div class="text-center">
                    <video id="preview" width="380"></video>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });

        scanner.addListener('scan', function (result) {
            if(result) {
                scanner.stop();
                let to_phone = result;
                window.location.replace(`scan-and-pay-form?to_phone=${to_phone}`);
            }
        });

        Instascan.Camera.getCameras().then(function (cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                console.error('No cameras found.');
            }
        }).catch(function (e) {
            console.error(e);
        });
  </script>
@endsection

