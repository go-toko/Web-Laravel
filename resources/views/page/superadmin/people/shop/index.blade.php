@extends('layout.mainlayout')

@section('title', 'Shop Management')

@section('forhead')
    {{-- Toastr Style --}}
    <link rel="stylesheet" href="{{ url('assets/plugins/toastr/toatr.css') }}">
    @livewireStyles
@endsection

@section('content')
    <div class="page-wrapper pagehead">
        <div class="content">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Shop Management</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Shop Management</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">List of Shop</h4>
                            <p class="card-text">
                                This is List of shop that has been registered to the system.
                            </p>
                        </div>
                        <div class="card-body">
                            <div class="table-top">
                                <div class="search-set">
                                </div>
                                <div class="wordset">
                                    <ul>
                                        <li>
                                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"
                                                href="{{ route('superadmin.people.shop.report-pdf') }}"><img
                                                    src="{{ URL::asset('/assets/img/icons/pdf.svg') }}" alt="img"></a>
                                        </li>
                                        <li>
                                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"
                                                href="{{ route('superadmin.people.shop.report-excel') }}"><img
                                                    src="{{ URL::asset('/assets/img/icons/excel.svg') }}"
                                                    alt="img"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table  datanew ">
                                    <thead>
                                        <tr>
                                            <th class="col-2">Picture</th>
                                            <th class="col-2">Name</th>
                                            <th class="col-2">Description</th>
                                            <th class="col-5">Address</th>
                                            <th class="col-2">Status</th>
                                            <th class="col-1">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>
                                                    <div class="avatar">
                                                        <img class="avatar-img rounded-circle" alt="User Image"
                                                            src="{{ isset($item->logo) ? $item->logo : asset('images/noimage.png')}}">
                                                    </div>
                                                </td>
                                                <td>{{ Str::headline($item->name) }}</td>
                                                <td>{{ $item->description }}</td>
                                                <td>
                                                    {{ $item?->address ? $item->address . ', ' . $item->village . ', ' . $item->district . ', ' . $item->regency . ', ' . $item->province : $item->village . ', ' . $item->district . ', ' . $item->regency . ', ' . $item->province }}
                                                </td>
                                                <td>{{ $item->isActive? 'Aktif':'Tidak Aktif' }}</td>
                                                <td>
                                                    <a class="me-3"
                                                        href="{{ route('superadmin.people.shop.show', Crypt::encrypt($item->id)) }}">
                                                        <img src="{{ URL::asset('assets/img/icons/eye.svg') }}"
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
                </div>
            </div>
        </div>
    </div>
@endsection

@section('forscript')

    @livewireScripts

    <script>
        window.addEventListener('show-toast', event => {
            toastr[event.detail.type](event.detail.message, event.detail.title);
        });
    </script>

    {{-- Toast Script --}}
    <script src="{{ URL::asset('/assets/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/plugins/toastr/toastr.js') }}"></script>
@endsection
