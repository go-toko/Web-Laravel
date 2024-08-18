<?php $page = 'menus'; ?>
@extends('layout.mainlayout')

@section('title', 'Daftar Penjualan')

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
            <div class="row">
                <div class="col-sm-12">
                    <section class="comp-section">
                        <div class="row">
                            <div class="col-12 col-lg-3 col-md-3">
                                <div class="form-group" id="startDateField">
                                    <div class="input-groupicon">
                                        <input id="startDate" name="startDate" type="text"
                                            placeholder="Pilih Tanggal Awal"
                                            class="datetimepicker form-control @error('startDate') is-invalid @enderror"
                                            value="{{ old('startDate') ?? (request()->get('startDate') ?? null) }}"
                                            required>
                                        <div class="addonset">
                                            <img src="{{ URL::asset('assets/img/icons/calendars.svg') }}" alt="img" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-3 col-md-3">
                                <div class="form-group">
                                    <div class="input-groupicon">
                                        <input id="endDate" name="endDate" type="text"
                                            placeholder="Pilih Tanggal Akhir"
                                            class="datetimepicker form-control @error('endDate') is-invalid @enderror"
                                            value="{{ old('endDate') ?? (request()->get('endDate') ?? null) }}">
                                        <div class="addonset">
                                            <img src="{{ URL::asset('assets/img/icons/calendars.svg') }}" alt="img" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-2 col-md-2">
                                <div class="form-group" id="paymentMethodField">
                                    <div class="input-groupicon">
                                        <select name="payment_method" id="payment_method" class="select">
                                            <option value="all" selected>Semua</option>
                                            @foreach ($payment_methods as $method)
                                                <option value="{{ $method }}"
                                                    {{ request()->get('payment_method') == $method ? 'selected' : '' }}>
                                                    {{ $method }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-2 col-md-2">
                                <div class="form-group" id="statusField">
                                    <div class="input-groupicon">
                                        <select name="status" id="status" class="select">
                                            <option value="all" selected>Semua</option>
                                            @foreach ($status as $stts)
                                                <option value="{{ $stts }}"
                                                    {{ request()->get('status') == $stts ? 'selected' : '' }}>
                                                    {{ $displayStatus[array_search($stts, $status)] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-2 col-md-2">
                                <div class="form-group d-flex align-items-center gap-3">
                                    <a class="btn btn-filters ms-auto" id="filter"><img
                                            src="{{ URL::asset('assets/img/icons/search-whites.svg') }}" alt="img"
                                            data-bs-toggle="tooltip" title="Filter"></a>
                                    <a class="btn btn-filters" id="resetFilter"><i class="fa fa-undo"
                                            data-bs-toggle="tooltip" title="Reset Filter"></i></a>
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="PDF" id="reportPdf"><img
                                            src="{{ URL::asset('assets/img/icons/pdf.svg') }}" alt="img"></a>
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="Excel" id="reportExcel"><img
                                            src="{{ URL::asset('assets/img/icons/excel.svg') }}" alt="img"></a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table datanew">
                                <thead>
                                    <tr>
                                        <th class="col-2">Tanggal</th>
                                        <th class="col-1">Total Tagihan</th>
                                        <th class="col-1">Total Diskon</th>
                                        <th class="col-1">Tagihan yang harus dibayar</th>
                                        <th class="col-1">Jumlah Pembayaran</th>
                                        <th class="col-1">Kembalian</th>
                                        <th class="col-1">Metode Pembayaran</th>
                                        <th class="col-1">Status</th>
                                        <th class="col-2">Kasir</th>
                                        <th class="col-0">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sales as $sale)
                                        <tr>
                                            <td>{{ Carbon\Carbon::create($sale->created_at)->translatedFormat('d F Y H:i:s') }}
                                            </td>
                                            <td>{{ 'Rp' . number_format($sale->total_bill) }}</td>
                                            <td>{{ 'Rp' . number_format($sale->total_discount) }}</td>
                                            <td>{{ 'Rp' . number_format($sale->total_bill - $sale->total_discount) }}</td>
                                            <td>{{ 'Rp' . number_format($sale->total_paid) }}</td>
                                            <td>{{ 'Rp' . number_format($sale->changes) }}</td>
                                            <td>{{ $sale->payment_method }}</td>
                                            @php
                                                $bg = [
                                                    'bg-lightgreen',
                                                    'bg-lightyellow',
                                                    'bg-lightgrey',
                                                    'bg-lightred',
                                                ];
                                            @endphp
                                            <td><span
                                                    class="badges d-flex justify-content-center {{ in_array($sale->status, $status) ? $bg[array_search($sale->status, $status)] : '' }}">{{ in_array($sale->status, $status) ? $displayStatus[array_search($sale->status, $status)] : '' }}</span>
                                            </td>
                                            <td>{{ $sale->cashier->userProfile->first_name . ' ' . $sale->cashier->userProfile->last_name }}
                                            </td>
                                            <td>
                                                <a class="me-1"
                                                    href="{{ route('owner.penjualan.penjualan.detail', ['id' => Crypt::encrypt($sale->id)]) }}">
                                                    <img src="{{ URL::asset('assets/img/icons/eye.svg') }}"
                                                        alt="eye">
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
    <script>
        $(window).ready(function() {
            $('.select').select2();
        })

        $(document).on('click', '#filter', function() {
            const paymentMethod = $('#payment_method').val();
            const status = $('#status').val();

            if ((!$('#startDate').val() || $('#startDate').val() === '') && paymentMethod == 'all' && status ==
                'all') {
                $('#startDateField').append(
                    `<div class="invalid-feedback" style="display: block">*Harap pilih tanggal awal untuk filter</div>`
                )
                $('#paymentMethodField').append(
                    `<div class="invalid-feedback" style="display: block">*Harap pilih selain "Semua"</div>`
                )
                $('#statusField').append(
                    `<div class="invalid-feedback" style="display: block">*Harap pilih selain "Semua"</div>`
                )
                setTimeout(() => {
                    $('.invalid-feedback').remove()
                }, 2000);
                return;
            };

            const currentDate = new Date();
            let dateYear = currentDate.getFullYear();
            let dateMonth = currentDate.getMonth() + 1;
            let dateDay = currentDate.getDate();

            dateMonth = `${dateMonth}`.length === 1 ? `0${dateMonth}` : dateMonth;

            const startDate = $('#startDate').val();
            const endDate = $('#endDate').val() ? $('#endDate').val() : `${dateDay}-${dateMonth}-${dateYear}`;
            window.location.href =
                `{{ route('owner.penjualan.penjualan.index') }}?startDate=${startDate}&endDate=${endDate}&payment_method=${paymentMethod}&status=${status}`
        })

        $(document).on('click', '#resetFilter', function(event) {
            if (window.location.href === `{{ route('owner.penjualan.penjualan.index') }}`) {
                $('#startDateField').append(
                    `<div class="invalid-feedback" style="display: block">*Filter sudah tereset</div>`
                )
                setTimeout(() => {
                    $('.invalid-feedback').remove()
                }, 2000);
                return;
            }
            window.location.href = `{{ route('owner.penjualan.penjualan.index') }}`
        })

        $(document).on('click', '#reportPdf', function() {
            const paymentMethod = $('#payment_method').val();
            const status = $('#status').val();

            const currentDate = new Date();
            let dateYear = currentDate.getFullYear();
            let dateMonth = currentDate.getMonth() + 1;
            let dateDay = currentDate.getDate();

            dateMonth = `${dateMonth}`.length === 1 ? `0${dateMonth}` : dateMonth;

            const startDate = $('#startDate').val();
            const endDate = $('#endDate').val() ? $('#endDate').val() : `${dateDay}-${dateMonth}-${dateYear}`;
            const url =
                `{{ route('owner.penjualan.penjualan.reportPdf') }}?startDate=${startDate}&endDate=${endDate}&payment_method=${paymentMethod}&status=${status}`
            window.open(url, '_blank')
        })

        $(document).on('click', '#reportExcel', function() {
            const paymentMethod = $('#payment_method').val();
            const status = $('#status').val();

            const currentDate = new Date();
            let dateYear = currentDate.getFullYear();
            let dateMonth = currentDate.getMonth() + 1;
            let dateDay = currentDate.getDate();

            dateMonth = `${dateMonth}`.length === 1 ? `0${dateMonth}` : dateMonth;

            const startDate = $('#startDate').val();
            const endDate = $('#endDate').val() ? $('#endDate').val() : `${dateDay}-${dateMonth}-${dateYear}`;
            const url =
                `{{ route('owner.penjualan.penjualan.reportExcel') }}?startDate=${startDate}&endDate=${endDate}&payment_method=${paymentMethod}&status=${status}`
            window.open(url, '_blank')
        })
    </script>
@endsection
