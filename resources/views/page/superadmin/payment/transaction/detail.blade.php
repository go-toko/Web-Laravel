<?php $page = 'blankpage'; ?>
@extends('layout.mainlayout')

@section('title', 'Merchant Detail Transactions')

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
                        <h3 class="page-title">Merchant Detail Transactions</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Merchant Detail Transactions</li>
                        </ul>
                    </div>
                </div>
                <div class="page-btn">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-lg-4 col-sm-4 col-12 d-flex">
                    <div class="dash-count">
                        <div class="dash-counts">
                            <h4 id="total-users">{{ count($data) }}</h4>
                            <h5>Total Transactions</h5>
                        </div>
                        <div class="dash-imgs">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                                <path fill="#ffffff"
                                    d="M535 41c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l64 64c4.5 4.5 7 10.6 7 17s-2.5 12.5-7 17l-64 64c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l23-23L384 112c-13.3 0-24-10.7-24-24s10.7-24 24-24l174.1 0L535 41zM105 377l-23 23L256 400c13.3 0 24 10.7 24 24s-10.7 24-24 24L81.9 448l23 23c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L7 441c-4.5-4.5-7-10.6-7-17s2.5-12.5 7-17l64-64c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9zM96 64H337.9c-3.7 7.2-5.9 15.3-5.9 24c0 28.7 23.3 52 52 52l117.4 0c-4 17 .6 35.5 13.8 48.8c20.3 20.3 53.2 20.3 73.5 0L608 169.5V384c0 35.3-28.7 64-64 64H302.1c3.7-7.2 5.9-15.3 5.9-24c0-28.7-23.3-52-52-52l-117.4 0c4-17-.6-35.5-13.8-48.8c-20.3-20.3-53.2-20.3-73.5 0L32 342.5V128c0-35.3 28.7-64 64-64zm64 64H96v64c35.3 0 64-28.7 64-64zM544 320c-35.3 0-64 28.7-64 64h64V320zM320 352a96 96 0 1 0 0-192 96 96 0 1 0 0 192z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-4 col-12 d-flex">
                    <div class="dash-count">
                        <div class="dash-counts">
                            <h4 id="total-users">Rp {{ number_format($groupByStatus['success'] ?? 0, 2) }}</h4>
                            <h5>Transaction Success</h5>
                        </div>
                        <div class="dash-imgs">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                <path fill="#ffffff"
                                    d="M64 64C28.7 64 0 92.7 0 128V384c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V128c0-35.3-28.7-64-64-64H64zm64 320H64V320c35.3 0 64 28.7 64 64zM64 192V128h64c0 35.3-28.7 64-64 64zM448 384c0-35.3 28.7-64 64-64v64H448zm64-192c-35.3 0-64-28.7-64-64h64v64zM288 160a96 96 0 1 1 0 192 96 96 0 1 1 0-192z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-4 col-12 d-flex">
                    <div class="dash-count">
                        <div class="dash-counts">
                            <h4 id="total-users">Rp {{ number_format($groupByStatus['pending'] ?? 0, 2) }}</h4>
                            <h5>Transaction Pending</h5>
                        </div>
                        <div class="dash-imgs">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                <path fill="#ffffff"
                                    d="M64 64C28.7 64 0 92.7 0 128V384c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V128c0-35.3-28.7-64-64-64H64zm64 320H64V320c35.3 0 64 28.7 64 64zM64 192V128h64c0 35.3-28.7 64-64 64zM448 384c0-35.3 28.7-64 64-64v64H448zm64-192c-35.3 0-64-28.7-64-64h64v64zM288 160a96 96 0 1 1 0 192 96 96 0 1 1 0-192z" />
                            </svg>
                        </div>
                    </div>
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
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @elseif(session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
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
                                            <th>No</th>
                                            <th>Payment</th>
                                            <th>Payment Type</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key => $value)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $value->payment->name }} {{ $value->payment->provider }}</td>
                                                <td>{{ $value->payment_type }}</td>
                                                <td>{{ $value->amount }}</td>
                                                <td>
                                                    @if ($value->status == 'pending')
                                                        <span class="badge bg-warning">Pending</span>
                                                    @elseif($value->status == 'success')
                                                        <span class="badge bg-success">Success</span>
                                                    @else
                                                        <span class="badge bg-danger">Failed</span>
                                                    @endif
                                                </td>
                                                <td>{{ Carbon\Carbon::parse($value->created_at)->format('d M Y H:i') }}
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
