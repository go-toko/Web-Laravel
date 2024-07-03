<?php $page = 'blankpage'; ?>
@extends('layout.mainlayout')

@section('title', 'Merchant Transactions')

@section('forhead')
{{-- Toastr Style --}}
<link rel="stylesheet" href="{{ url('assets/plugins/toastr/toatr.css') }}">

{{-- CSRF Token --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- Livewire --}}
@livewireStyles
@endsection

@section('content')
<div class="page-wrapper pagehead">
    <div class="content">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Merchant Transactions</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Merchant Transactions</li>
                    </ul>
                </div>
            </div>
            <div class="page-btn">

            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <!-- /product list -->
                <div class="card">
                    <div class="row">
                        <div class="col-md-12">
                            @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @elseif(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-top">
                            <div class="search-set"></div>
                            <div class="wordset">

                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table datanew">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Merchant</th>
                                        <th>Transaksi</th>
                                        <th>Bank</th>
                                        <th>Detail</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $key => $value)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $value->shop->name }}</td>
                                        <td>
                                            <a href="{{ route('superadmin.payment.shop.show', $value->shop->id) }}" class="btn btn-primary btn-sm text-white">Transaksi</a>
                                        </td>
                                        <td> {{ $value->bank }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Detail
                                                </button>

                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <li><a class="dropdown-item">Nomor Rekening :
                                                            {{ $value->account_number }}</a></li>
                                                    <li><a class="dropdown-item">Nama Pemilik Rekening :
                                                            {{ $value->account_name }}</a></li>
                                                </ul>
                                            </div>
                                        <td>Rp. {{ number_format($value->amount, 0, ',', '.') }}</td>
                                        <td>
                                            @if ($value->status == 'created')
                                            <span class="badge bg-warning">Created</span>
                                            @elseif ($value->status == 'process')
                                            <span class="badge bg-primary">Process</span>
                                            @elseif ($value->status == 'success')
                                            <span class="badge bg-success">Success</span>
                                            @elseif ($value->status == 'failed')
                                            <span class="badge bg-danger">Failed</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                @if ($value->status == 'created')
                                                <a href="{{ url('superadmin/payment/withdrawal/' . $value->id . '/process') }}" class="btn btn-success btn-sm text-white me-2">
                                                    Accept
                                                </a>
                                                <a href="{{ url('superadmin/payment/withdrawal/' . $value->id . '/failed') }}" class="btn btn-danger btn-sm text-white">
                                                    Reject
                                                </a>
                                                @elseif ($value->status == 'process')
                                                <a href="{{ url('superadmin/payment/withdrawal/' . $value->id . '/success') }}" class="btn btn-success btn-sm text-white me-2">
                                                    Confirm
                                                </a>
                                                <a href="{{ url('superadmin/payment/withdrawal/' . $value->id . '/failed') }}" class="btn btn-danger btn-sm text-white">
                                                    Failed
                                                </a>
                                                @endif
                                            </div>
                                        </td>
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