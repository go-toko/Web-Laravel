<?php $page = 'blankpage';?>
@extends('layout.mainlayout')

@section('title', 'Payment Management')

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
                    <h3 class="page-title">Payment Management</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Payment Management</li>
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
                            @if(session('success'))
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
                                        <th>Nama Layanan</th>
                                        <th>Provider</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $key => $value)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $value->nama }}</td>
                                        <td>{{ $value->provider }}</td>
                                        <td>
                                            @if($value->status == "ACTIVE")
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($value->status == "ACTIVE")
                                                <a href="{{ route('superadmin.payment.edit', ['id' => $value->id, 'status' => 'INACTIVE']) }}" class="btn btn-danger btn-sm text-white">Disable</a>
                                            @else
                                                <a href="{{ route('superadmin.payment.edit', ['id' => $value->id, 'status' => 'ACTIVE']) }}" class="btn btn-success btn-sm text-white">Enable</a>
                                            @endif
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
