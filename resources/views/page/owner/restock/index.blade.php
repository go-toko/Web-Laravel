<?php $page = 'menus'; ?>
@extends('layout.mainlayout')

@section('title', 'Daftar Restock')

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
                <div class="page-btn">
                    <a href="{{ route('owner.produk.restock.add') }}" class="btn btn-added">
                        <img src="{{ URL::asset('assets/img/icons/plus.svg') }}" class="me-1" alt="img">Tambah
                        Restock
                    </a>
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
                                        @error('startDate')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
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
                                        @error('endDate')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-3 col-md-3 offset-lg-3 offset-md-3">
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
                                        <th class="col-0">No</th>
                                        <th class="col-3">Tanggal</th>
                                        <th class="col-3">Nama Pemasok</th>
                                        <th class="col-2">Total</th>
                                        <th class="col-3">Deskripsi</th>
                                        <th class="col-1">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($restock as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ Carbon\Carbon::createFromDate($item->date)->format('d-m-Y') }}</td>
                                            <td>
                                                {{ $item->supplier->name }}
                                            </td>
                                            <td>{{ 'Rp' . number_format($item->total) }}</td>
                                            <td>{{ $item->description }}</td>
                                            <td>
                                                <a class="me-1"
                                                    href="{{ route('owner.produk.restock.detail', ['id' => Crypt::encrypt($item->id)]) }}">
                                                    <img src="{{ URL::asset('assets/img/icons/eye.svg') }}" alt="eye">
                                                </a>
                                                <a class="me-1"
                                                    href="{{ route('owner.produk.restock.edit', ['id' => Crypt::encrypt($item->id)]) }}">
                                                    <img src="{{ URL::asset('assets/img/icons/edit.svg') }}"
                                                        alt="img" />
                                                </a>
                                                <a class="me-1" id="confirm-delete"
                                                    data-action="{{ route('owner.produk.restock.delete', ['id' => Crypt::encrypt($item->id)]) }}">
                                                    <img src="{{ URL::asset('assets/img/icons/delete.svg') }}"
                                                        alt="img" />
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
        $(document).on('click', '#filter', function() {
            if (!$('#startDate').val() || $('#startDate').val() === '') {
                $('#startDateField').append(
                    `<div class="invalid-feedback" style="display: block">*Harap pilih tanggal awal untuk filter</div>`
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
                `{{ route('owner.penjualan.penjualan.index') }}?startDate=${startDate}&endDate=${endDate}`
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
            const currentDate = new Date();
            let dateYear = currentDate.getFullYear();
            let dateMonth = currentDate.getMonth() + 1;
            let dateDay = currentDate.getDate();

            dateMonth = `${dateMonth}`.length === 1 ? `0${dateMonth}` : dateMonth;

            const startDate = $('#startDate').val();
            const endDate = $('#endDate').val() ? $('#endDate').val() : `${dateDay}-${dateMonth}-${dateYear}`;
            const url =
                `{{ route('owner.penjualan.penjualan.reportPdf') }}?startDate=${startDate}&endDate=${endDate}`
            window.open(url, '_blank')
        })

        $(document).on('click', '#reportExcel', function() {
            const currentDate = new Date();
            let dateYear = currentDate.getFullYear();
            let dateMonth = currentDate.getMonth() + 1;
            let dateDay = currentDate.getDate();

            dateMonth = `${dateMonth}`.length === 1 ? `0${dateMonth}` : dateMonth;

            const startDate = $('#startDate').val();
            const endDate = $('#endDate').val() ? $('#endDate').val() : `${dateDay}-${dateMonth}-${dateYear}`;
            const url =
                `{{ route('owner.penjualan.penjualan.reportExcel') }}?startDate=${startDate}&endDate=${endDate}`
            window.open(url, '_blank')
        })
    </script>
@endsection
