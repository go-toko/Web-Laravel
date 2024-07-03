<?php $page = 'blankpage'; ?>
@extends('layout.mainlayout')

@section('title', 'Subscription Management')

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
                        <h3 class="page-title">Subscription Management</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Subscription Management</li>
                        </ul>
                    </div>
                </div>
                <div class="page-btn">
                    <button type="button" class="btn btn-added add-subscription" data-bs-toggle="modal"
                        data-bs-target="#modalSubscription"
                        data-action="{{ route('superadmin.subscription.management.store') }}" data-method="POST">
                        <img src="{{ URL::asset('/assets/img/icons/plus.svg') }}" class="me-1" alt="img">Add
                        Subscription List
                    </button>
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
                                                href="{{ route('superadmin.subscription.management.report-pdf') }}"><img
                                                    src="{{ URL::asset('/assets/img/icons/pdf.svg') }}" alt="img"></a>
                                        </li>
                                        <li>
                                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel" href="{{ route('superadmin.subscription.management.report-excel') }}"><img
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
                                            <th>Nama Langganan</th>
                                            <th>Deskripsi </th>
                                            <th>Harga</th>
                                            <th>Jangka Waktu</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($subscriptions as $item)
                                            <tr>
                                                <td> {{ $loop->iteration }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->description }}</td>
                                                <td>Rp. {{ $item->price }}</td>
                                                <td>{{ $item->time }} bulan</td>
                                                <td>
                                                    @livewire('superadmin.subscribe.toggle-max', ['model' => $item, 'field' => 'isActive'], key($item->id))
                                                </td>
                                                <td>
                                                    <a class="me-3 edit-subscription" data-bs-toggle="modal"
                                                        data-bs-target="#modalSubscription"
                                                        data-action="{{ route('superadmin.subscription.management.update', Crypt::encrypt($item->id)) }}"
                                                        data-method="POST" data-subscription='{{ json_encode($item) }}'>
                                                        <img src="{{ URL::asset('/assets/img/icons/edit.svg') }}"
                                                            alt="img">
                                                    </a>
                                                    <a class="me-3 confirm-delete"
                                                        data-action="{{ route('superadmin.subscription.management.destroy', Crypt::encrypt($item->id)) }}"
                                                        href="javascript:void(0);">
                                                        <img src="{{ URL::asset('/assets/img/icons/delete.svg') }}"
                                                            alt="img">
                                                    </a>
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

    @include('page.superadmin.subscription.management.modal')
@endsection