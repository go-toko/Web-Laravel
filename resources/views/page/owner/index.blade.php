<?php $page = 'menus'; ?>
@extends('layout.mainlayout')

@section('title', 'Dashboard')

@section('forhead')
    {{-- Toastr Style --}}
    <link rel="stylesheet" href="{{ url('assets/plugins/toastr/toatr.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <div class="page-wrapper pagehead">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>@yield('title')</h4>
                    <h6>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('owner/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active"> @yield('title') </li>
                        </ul>
                    </h6>
                </div>
            </div>

            {{-- Body Start --}}
            @if (Session::has('active'))
                <div class="row">
                    <div class="col-12">
                        <section class="comp-section">
                            <div class="row d-flex">
                                <h4>{{ Str::headline($shop->name) }}</h4>
                            </div>
                        </section>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-12">
                        <section class="comp-section">
                            <div class="row d-flex">
                                @foreach ($shops as $shop)
                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                        <div class="card flex-fill bg-white">
                                            <div class="card-header d-flex justify-content-between">
                                                <h5 class="card-title mb-0">{{ Str::headline($shop->name) }}</h5>
                                                <div
                                                    class="status-toggle d-flex justify-content-between align-items-center">
                                                    <input type="checkbox" id="user3" class="check" checked="">
                                                    <label for="user3" class="checktoggle">checkbox</label>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text">{{ $shop->description }}</p>
                                                <a class="btn btn-primary"
                                                    href="{{ route('owner.setSession', Crypt::encrypt($shop->id)) }}">Manage</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </section>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection
<?php
$title = e($__env->yieldContent('title'));
$type = Session::get('type');
$msg = Session::get($type);
// dd($type);
?>

@section('forscript')
    {{-- Toast import js --}}
    <script src="{{ URL::asset('/assets/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/plugins/toastr/toastr.js') }}"></script>

    <script>
        let type = {!! json_encode($type) !!};
        let msg = {!! json_encode($msg) !!};
        const title = {!! json_encode($title) !!};
        @if (Session::has($type))
            {
                toastr[type](msg, title, {
                    closeButton: !0,
                    tapToDismiss: !1,
                    positionClass: 'toast-top-center',
                })
            }
        @endif
        // @if (Session::has('success'))
        //     {
        //         toastr.success("{!! Session::get('success') !!}", "Category", {
        //             closeButton: !0,
        //             tapToDismiss: !1,
        //             positionClass: 'toast-top-center',
        //         });
        //     }
        // @endif
    </script>

@endsection
