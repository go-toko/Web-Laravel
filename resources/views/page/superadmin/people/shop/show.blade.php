@extends('layout.mainlayout')

@section('title', 'Detail Shop')

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
                        <h3 class="page-title">Profile
                            {{ $shop->name }}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Shop Profile</li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="wordset">
                        <ul>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"
                                    href="{{ route('superadmin.people.shop.report-detail-pdf', Crypt::encrypt($shop->id)) }}"><img
                                        src="{{ URL::asset('/assets/img/icons/pdf.svg') }}" alt="img"></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="profile-set">
                                <div class="profile-head">
                                </div>
                                <div class="profile-top">
                                    <div class="profile-content">
                                        <div class="profile-contentimg">
                                            <img src="{{ $shop->logo }}" alt="img" id="blah">
                                            <div class="profileupload">
                                                <img type="file" id="imgInp" name="picture"
                                                    value="{{ $shop->logo }}">
                                            </div>
                                        </div>
                                        <div class="profile-contentname">
                                            <h2>{{ $shop->name }}
                                            </h2>
                                            <h4>Shop details.</h4>
                                        </div>
                                    </div>
                                    <div class="ms-auto">

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Shop Name</label>
                                        <input type="text" name="first_name" placeholder="{{ $shop->name }}"
                                            value="{{ $shop->name }}" readonly>
                                        <div class="invalid-feedback error-text">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Owner Name</label>
                                        <a
                                            href="{{ route('superadmin.people.user.show', Crypt::encrypt($shop->user->id)) }}"><span
                                                class="badge rounded-pill bg-secondary"
                                                style="font-size: 1.2em">{{ $shop->user->userProfile->first_name . ' ' . $shop->user->userProfile->last_name }}</span></a>
                                        <div class="invalid-feedback error-text">

                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Nickname</label>
                                        <input type="text" name="nickname" placeholder="Nickname"
                                            value="{{ $user->userProfile->nickname }}" readonly>
                                    </div>
                                </div> --}}
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" name="email" placeholder="william@example.com"
                                            value="{{ $shop->email }}" readonly>
                                        <div class="invalid-feedback error-text">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="text" name="phone" placeholder="+62123456789"
                                            value="{{ $shop->contact_person }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="d-block">Operational Hour:</label>
                                        <li>{{ $shop->operational_hour ? $shop->operational_hour : '-' }}</li>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <textarea name="address" id="address" rows="5" cols="5" class="form-control" placeholder="Address"
                                            readonly>{{ $shop->address }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea name="address" id="address" rows="5" cols="5" class="form-control" placeholder="Address"
                                            readonly>{{ $shop->description }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($shop->product->count() > 0)
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Product</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <h4 class="card-title">Products</h4>
                                            <div class="table-responsive dataview">
                                                <table class="table datatable ">
                                                    <thead>
                                                        <tr>
                                                            <th>SKU</th>
                                                            <th>Product Name</th>
                                                            <th>Brand Name</th>
                                                            <th>Category Name</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($shop->product as $item)
                                                            <tr>
                                                                <td>
                                                                    <a
                                                                        href="javascript:void(0);">{{ Str::limit($item->sku, 5, '...') }}</a>
                                                                </td>
                                                                <td>
                                                                    <a href="javascript:void(0);">{{ $item->name }}</a>
                                                                </td>
                                                                <td>{{ $item->brand->name }}</td>
                                                                <td>{{ $item->category->name }}</td>
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
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
