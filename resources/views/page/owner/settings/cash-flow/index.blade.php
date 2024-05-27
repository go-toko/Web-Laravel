<?php $page = 'menus'; ?>
@extends('layout.mainlayout')

@section('title', 'Arus Kas')

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
                            <div class="col-6 col-lg-2">
                                <div class="form-group">
                                    <label>Toko</label>
                                    <select name="shop_id" id="shop_id"
                                        class="select @error('shop_id') is-invalid @enderror">
                                        <option value="null" selected disabled>-- Select --</option>
                                        @foreach ($shops as $shop)
                                            <option value="{{ $shop->id }}"
                                                {{ $shop->id == $latest_shop_id ? 'selected' : '' }}>
                                                {{ Str::ucfirst($shop->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 col-lg-2">
                                <div class="form-group">
                                    <label>Tampilkan berdasarkan</label>
                                    <select name="filter" id="filter"
                                        class="select @error('filter') is-invalid @enderror">
                                        <option value="null" selected disabled>-- Select --</option>
                                        <option value="year" selected>Tahun</option>
                                        <option value="month">Bulan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 col-lg-2" id="yearField">
                                <div class="form-group">
                                    <label>Tahun</label>
                                    <input id="year" year="year" type="number" min="1900" max="2200"
                                        maxlength="4" class="form-control @error('year') is-invalid @enderror"
                                        value="{{ Carbon\Carbon::now()->year }}">
                                    @error('year')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6 col-lg-2 d-none" id="monthField">
                                <div class="form-group">
                                    <label>Bulan</label>
                                    <select name="month" id="month"
                                        class="select @error('month') is-invalid @enderror">
                                        @php
                                            $months = [
                                                'January',
                                                'February',
                                                'March',
                                                'April',
                                                'May',
                                                'June',
                                                'July',
                                                'August',
                                                'September',
                                                'October',
                                                'November',
                                                'December',
                                            ];
                                        @endphp
                                        @foreach ($months as $index => $month)
                                            <option value="{{ $index + 1 }}">{{ $month }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div id="cash-flow-chart">
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

@include('page.owner.settings.cash-flow.script')
