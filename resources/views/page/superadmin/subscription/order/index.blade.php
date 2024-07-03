<?php $page = 'blankpage'; ?>
@extends('layout.mainlayout')

@section('title', 'Subscription Order')

@section('forhead')
    {{-- Toastr Style --}}
    <link rel="stylesheet" href="{{ url('assets/plugins/toastr/toatr.css') }}">

@endsection

@section('content')
    <div class="page-wrapper pagehead">
        <div class="content">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Subscription Order</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Subscription Order</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <!-- /product list -->
                    <div class="card">
                        <div class="card-body">
                            <div class="table-top">
                                <div class="search-set"></div>
                                <div class="wordset">
                                    <ul>
                                        <li>
                                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"
                                                href="{{ route('superadmin.subscription.subscription-order.report-pdf') }}"><img
                                                    src="{{ URL::asset('/assets/img/icons/pdf.svg') }}" alt="img"></a>
                                        </li>
                                        <li>
                                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"
                                                href="{{ route('superadmin.subscription.subscription-order.report-excel') }}"><img
                                                    src="{{ URL::asset('/assets/img/icons/excel.svg') }}"
                                                    alt="img"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table datanew">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama User</th>
                                            <th>Nama Langganan</th>
                                            <th>Harga</th>
                                            <th>Jangka Waktu</th>
                                            <th>Waktu Berakhir</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td> {{ $loop->iteration }}</td>
                                                <td>{{ $item->user->userProfile->first_name . ' ' . $item->user->userProfile->last_name }}
                                                </td>
                                                <td>{{ $item->subscription_name }}</td>
                                                <td>Rp. {{ $item->subscription_price }}</td>
                                                <td>{{ $item->subscription_time }} bulan</td>
                                                <td>{{ Carbon\Carbon::parse($item->expire)->format('d M Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /product list -->
                </div>
            </div>
        </div>
    </div>
@endsection
