@extends('layout.mainlayout')

@section('title', 'Subscription Page')

@section('forhead')
    <style type="text/css">
        .subscription-box {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <div class="page-wrapper pagehead">
        <div class="content">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Subscription Page</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <h4>List subscription</h4>
                <p>You can get more unlock feature when join the premium member!</p>
            </div>
            <div class="row mt-5">
                @foreach ($subs_type as $item)
                    <div class="col-md-4">
                        <div class="subscription-box">
                            <h3>{{ $item->name }}</h3>
                            <p class="text-muted">{{ $item->description }}</p>
                            <hr>
                            <h4>Rp. {{ $item->price }}</h4>
                            <p class="text-muted">{{ $item->time }} month</p>
                            <a id="{{ Auth::check() ? 'pay-button' : 'login' }}" class="btn btn-primary"
                                data-id="{{ $item->id }}">{{ Auth::check() ? 'Buy' : 'Sign in' }}</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('forscript')
    {{-- Toast Script --}}
    <script src="{{ URL::asset('/assets/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/plugins/toastr/toastr.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('body').on('click', '#pay-button', function(e) {
                e.preventDefault();
                var itemId = $(this).data('id');

                $.ajax({
                    url: "{{ route('subscription.payment') }}",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    data: {
                        id: itemId
                    },
                    success: function(response) {
                        // Tangkap snapToken dari respons JSON
                        var snapToken = response.snapToken;

                        // Jalankan window.snap.pay dengan snapToken yang diterima
                        window.snap.pay(snapToken, {
                            onSuccess: function(result) {
                                /* You may add your own implementation here */
                                $.ajax({
                                    url: "{{ route('subscription.add') }}",
                                    method: "POST",
                                    headers: {
                                        'X-CSRF-TOKEN': $(
                                                'meta[name="csrf-token"]')
                                            .attr('content')
                                    },
                                    dataType: 'json',
                                    data: {
                                        id: itemId
                                    },
                                    success: function(response) {
                                        console.log(response.status);
                                        if (response.status == 0) {
                                            toastr.error(response.msg,
                                                'Error')
                                        } else {
                                            toastr.success(response.msg,
                                                'Success');
                                            setTimeout(function() {
                                                window.location
                                                    .href =
                                                    "{{ route('owner.dashboard') }}"
                                            }, 1000)
                                        }
                                    }
                                })
                            },
                            onPending: function(result) {
                                /* You may add your own implementation here */
                                alert("waiting for your payment!");
                                console.log(result);
                            },
                            onError: function(result) {
                                /* You may add your own implementation here */
                                alert("payment failed!");
                                console.log(result);
                            },
                            onClose: function() {
                                /* You may add your own implementation here */
                                console.log('test');
                                window.alert(
                                    'you closed the popup without finishing the payment'
                                );
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        // Tangani kesalahan jika terjadi
                    }
                });
            })
        });
    </script>

@endsection
