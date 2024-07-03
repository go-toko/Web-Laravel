@extends('layout.mainlayout')

@section('title', 'Detail User')

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
                        <h3 class="page-title">Profile User
                            {{ $user->userProfile->first_name . ' ' . $user->userProfile->last_name }}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">My Profile</li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="wordset">
                        <ul>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"
                                    href="{{ route('superadmin.people.user.report-detail-pdf', Crypt::encrypt($user->id)) }}"><img
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
                                            <img src="{{ $user->userProfile->picture }}" alt="img" id="blah">
                                            <div class="profileupload">
                                                <img type="file" id="imgInp" name="picture"
                                                    value="{{ $user->userProfile->picture }}">
                                            </div>
                                        </div>
                                        <div class="profile-contentname">
                                            <h2>{{ $user->userProfile->first_name . ' ' . $user->userProfile->last_name }}
                                            </h2>
                                            <h4>Personal details.</h4>
                                        </div>
                                    </div>
                                    <div class="ms-auto">

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input type="text" name="first_name"
                                            placeholder="{{ $user->userProfile->first_name }}"
                                            value="{{ $user->userProfile->first_name }}" readonly>
                                        <div class="invalid-feedback error-text">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input type="text" name="last_name"
                                            placeholder="{{ $user->userProfile->last_name }}"
                                            value="{{ $user->userProfile->last_name }}" readonly>
                                        <div class="invalid-feedback error-text">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Nickname</label>
                                        <input type="text" name="nickname" placeholder="Nickname"
                                            value="{{ $user->userProfile->nickname }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" name="email" placeholder="william@example.com"
                                            value="{{ $user->email }}" readonly>
                                        <div class="invalid-feedback error-text">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="text" name="phone" placeholder="+62123456789"
                                            value="{{ $user->userProfile->phone }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Birth of date </label>
                                        <div class="input-groupicon">
                                            <input type="text" name="birthdate" placeholder="DD-MM-YYYY"
                                                class="datetimepicker"
                                                value="{{ isset($user->userProfile->birthdate) ? Carbon\Carbon::createFromFormat('Y-m-d', $user->userProfile->birthdate)->format('d-m-Y') : null }}"
                                                readonly>
                                            <div class="addonset">
                                                <img src="{{ URL::asset('/assets/img/icons/calendars.svg') }}"
                                                    alt="img">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="d-block">Gender:</label>
                                        <li>{{ $user->userProfile->gender }}</li>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <textarea name="address" id="address" rows="5" cols="5" class="form-control" placeholder="Address"
                                            readonly>{{ $user->userProfile->address }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="container-shop">
                @if ($user->shop)
                    @foreach ($shops as $shop)
                        <div class="page-header">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h3 class="page-title">Profile Toko
                                        {{ $shop->name }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="profile-set">
                                            <div class="shop-head">
                                            </div>
                                            <div class="profile-top">
                                                <div class="profile-content">
                                                    <div class="profile-contentimg">
                                                        <img src="{{ isset($shop->logo)?$shop->logo:asset('images/noimage.png') }}" alt="img" id="blah">
                                                        <div class="profileupload">
                                                            <img type="file" id="imgInp" name="picture"
                                                                value="{{ isset($shop->logo)?$shop->logo:asset('images/noimage.png') }}">
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
                                            <div class="col-lg-3 col-sm-6 col-12 d-flex">
                                                <div class="dash-count">
                                                    <div class="dash-counts">
                                                        <h4 id="total-users">{{ $shop->product->count() }}</h4>
                                                        <h5>Product</h5>
                                                    </div>
                                                    <div class="dash-imgs">
                                                        <i data-feather="box"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-6 col-12 d-flex">
                                                <div class="dash-count das1">
                                                    <div class="dash-counts">
                                                        <h4 id="online-users">-</h4>
                                                        <h5></h5>
                                                    </div>
                                                    <div class="dash-imgs">
                                                        <i data-feather="user-check"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                    @endforeach
                @endif
            </div>
            <div class="row">
                <div class="col-12">
                    <button id="load_more" class="btn btn-primary">Load more</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('forscript')
    <script>
        // script.js

        $(document).ready(function() {
            var currentPage = {{ $shops->currentPage() }};
            var lastPage = {{ $shops->lastPage() }};
            var nextPage = currentPage + 1;

            if (currentPage === lastPage) {
                $('#load_more').hide();
            }
            $('#load_more').on('click', function() {
                $.ajax({
                    url: "{{ route('superadmin.people.user.show', Crypt::encrypt($user->id)) }}" +
                        '?page=' + nextPage,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        var ContainerShop = document.getElementById('container-shop');

                        console.log(response);
                        // Tambahkan data baru ke dalam kontainer
                        response.data.forEach(function(toko) {

                            var html = `
                                                            <div class="page-header">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h3 class="page-title">Profile Toko
                                                ${toko.name}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="profile-set">
                                                    <div class="shop-head">
                                                    </div>
                                                    <div class="profile-top">
                                                        <div class="profile-content">
                                                            <div class="profile-contentimg">
                                                                <img src="${toko.logo}" alt="img"
                                                                    id="blah">
                                                                <div class="profileupload">
                                                                    <img type="file" id="imgInp" name="picture"
                                                                        value="${toko.logo}">
                                                                </div>
                                                            </div>
                                                            <div class="profile-contentname">
                                                                <h2>${toko.name}
                                                                </h2>
                                                                <h4>Shop details.</h4>
                                                            </div>
                                                        </div>
                                                        <div class="ms-auto">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-6 col-12 d-flex">
                                                        <div class="dash-count">
                                                            <div class="dash-counts">
                                                                <h4 id="total-users">${toko.product.length}</h4>
                                                                <h5>Product</h5>
                                                            </div>
                                                            <div class="dash-imgs">
                                                                <i data-feather="box"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-6 col-12 d-flex">
                                                        <div class="dash-count das1">
                                                            <div class="dash-counts">
                                                                <h4 id="online-users">-</h4>
                                                                <h5></h5>
                                                            </div>
                                                            <div class="dash-imgs">
                                                                <i data-feather="user-check"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <h4 class="card-title">Products</h4>
                                                    <div class="table-responsive dataview">
                                                        <table class="table datatable ${toko.name}">
                                                            <thead>
                                                                <tr>
                                                                    <th>SKU</th>
                                                                    <th>Product Name</th>
                                                                    <th>Brand Name</th>
                                                                    <th>Category Name</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                ${toko.product.map(produk => `
                                                                                <tr>
                                                                                    <td>
                                                                                        <a
                                                                                            href="javascript:void(0);">${produk.sku.substring(0,5) + '...'}</a>
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="javascript:void(0);">${produk.name}</a>
                                                                                    </td>
                                                                                    <td>${produk.brand.name}</td>
                                                                                    <td>${produk.category.name}</td>
                                                                                </tr>
                                                                                `).join('')}

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;

                            ContainerShop.innerHTML += html;
                            feather.replace();
                        });

                        // Cek apakah halaman terakhir
                        if (response.current_page === response.last_page) {
                            $('#load_more').hide();
                        }

                        nextPage++;
                    }
                });
            });
        });
    </script>
@endsection
