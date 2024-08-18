<?php $page = 'menus'; ?>
@extends('layout.mainlayout')

@section('title', 'Detail Penjualan')

@section('forhead')
    {{-- Toastr Style --}}
    <link rel="stylesheet" href="{{ url('assets/plugins/toastr/toatr.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        p {
            margin-bottom: 3px;
        }
    </style>
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
                            <li class="breadcrumb-item"><a href="{{ url('owner/penjualan/penjualan') }}">Penjualan</a>
                            </li>
                            <li class="breadcrumb-item active"> @yield('title') </li>
                        </ul>
                    </h6>
                </div>
            </div>

            {{-- Body Start --}}
            <div class="row">
                <div class="col-sm-12">
                    <section class="comp-section">
                        <div class="card">
                            <div class="card-body">
                                {{-- Header Section --}}
                                <div class="card-sales-split">
                                    <h2>Sale Detail : {{ $sale->id }}</h2>
                                </div>
                                <div class="row my-2" style="padding-left: 5px">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                                        <h6 style="color: #7367F0" class="my-1">Informasi Penjualan</h6>
                                        <div class="d-flex justify-content-between">
                                            <p>Dibuat pada </p>
                                            <p>{{ Carbon\Carbon::create($sale->created_at)->translatedFormat('d F Y H:i:s') }}
                                            </p>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <p>Terakhir diubah pada </p>
                                            <p>{{ Carbon\Carbon::create($sale->updated_at)->translatedFormat('d F Y H:i:s') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                                        <h6 style="color: #7367F0" class="my-1">Informasi Toko</h6>
                                        <p>{{ $sale->shop->name }}</p>
                                        <p>{{ $sale->shop->description }}</p>
                                        <p>{{ Str::title($sale->shop?->address ? $sale->shop->address . ', ' . $sale->shop->village . ', ' . $sale->shop->district . ', ' . $sale->shop->regency . ', ' . $sale->shop->province : $sale->shop->village . ', ' . $sale->shop->district . ', ' . $sale->shop->regency . ', ' . $sale->shop->province) }}
                                        </p>
                                    </div>
                                    @php
                                        $bg = ['bg-lightgreen', 'bg-lightyellow', 'bg-lightgrey', 'bg-lightred'];
                                    @endphp
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                                        <h6 style="color: #7367F0" class="my-1">Informasi Pembayaran</h6>
                                        <div class="d-flex justify-content-between">
                                            <p>Metode Pembayaran</p>
                                            <p>{{ $sale->payment_method }}</p>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <p>Status Pembayaran</p>
                                            <p
                                                class="badges {{ in_array($sale->status, $status) ? $bg[array_search($sale->status, $status)] : '' }}">
                                                {{ in_array($sale->status, $status) ? $displayStatus[array_search($sale->status, $status)] : '' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Product Section --}}
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="col-6">Nama Product</th>
                                                <th class="col-1 text-end">Jumlah</th>
                                                <th class="col-1 text-end">Harga Satuan</th>
                                                <th class="col-1 text-end">Diskon Satuan</th>
                                                <th class="col-1 text-end">Subtotal Diskon</th>
                                                <th class="col-2 text-end">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sale->detail as $detail)
                                                <tr>
                                                    <td>
                                                        {{ $detail->name }}
                                                    </td>
                                                    <td class="text-end">{{ $detail->quantity }}
                                                        {{ Str::lower($detail->product->unit) }}
                                                    </td>
                                                    <td class="text-end">{{ 'Rp' . number_format($detail->unit_price) }}
                                                    </td>
                                                    <td class="text-end">{{ 'Rp' . number_format($detail->discount) }}</td>
                                                    <td class="text-end">
                                                        {{ 'Rp' . number_format($detail->discount * $detail->quantity) }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ 'Rp' . number_format($detail->unit_price * $detail->quantity - $detail->discount * $detail->quantity) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                {{-- Footer Section --}}
                                <div class="row my-3">
                                    <div class="offset-lg-6 col-lg-6 ">
                                        <div class="total-order w-100 max-widthauto m-auto mb-4">
                                            <ul>
                                                <li class="total">
                                                    <h4>Total tagihan</h4>
                                                    <h5>{{ 'Rp' . number_format($sale->total_bill) }}</h5>
                                                </li>
                                            </ul>
                                            <ul>
                                                <li class="total">
                                                    <h4>Jumlah yang dibayarkan</h4>
                                                    <h5>{{ 'Rp' . number_format($sale->total_paid) }}</h5>
                                                </li>
                                            </ul>
                                            <ul>
                                                <li class="total">
                                                    <h4>Kembalian</h4>
                                                    <h5>{{ 'Rp' . number_format($sale->changes) }}</h5>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <a href="{{ route('owner.penjualan.penjualan.index') }}"
                                            class="btn btn-cancel">Kembali</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
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

    @if ($type != null)
        <script>
            let type = {!! json_encode($type) !!};
            let msg = {!! json_encode($msg) !!};
            const title = {!! json_encode($title) !!};
            toastr[type](msg, title)
        </script>
    @endif
@endsection
