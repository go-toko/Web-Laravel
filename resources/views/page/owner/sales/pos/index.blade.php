<?php $page = 'pos'; ?>
@extends('layout.mainlayout')

@section('forhead')
    {{-- Toastr Style --}}
    <link rel="stylesheet" href="{{ url('assets/plugins/toastr/toatr.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <div class="header">
        <!-- Logo -->
        <div class="header-left border-0 ">
            <a href="{{ url('index') }}" class="logo logo-normal">
                <img src="{{ URL::asset('/assets/img/Pos-gotoko-colorfull.png') }}" alt="">
            </a>
            <a href="{{ url('index') }}" class="logo logo-white">
                <img src="{{ URL::asset('/assets/img/Pos-gotoko-white.png') }}" alt="">
            </a>
            <a href="{{ url('index') }}" class="logo-small">
                <img src="{{ URL::asset('/assets/img/logo-small.png') }}" alt="">
            </a>
        </div>
        <!-- /Logo -->

        <!-- Header Menu -->
        <ul class="nav user-menu">


            <li class="nav-item my-auto">
                @if (Auth::user()->isSubscribe == 0)
                    <i class="fas fa-gift fa-lg"></i>
                    <span class="badge rounded-pill bg-primary">
                        Freemium
                    </span>
                @else
                    <i class="fas fa-crown"></i>
                    <span class="badge rouded-pill bg-success" data-bs-toggle="tooltip" data-bs-placement="bottom"
                        data-bs-original-title="{{ Carbon\Carbon::now()->diffInDays(Carbon\Carbon::parse(Auth::user()->subscription->expire)) }} days left">
                        Premium
                    </span>
                    <span class="badge rounded-pill bg-danger">
                        {{ Carbon\Carbon::now()->diffInDays(Carbon\Carbon::parse(Auth::user()->subscription->expire)) }}
                        days left
                    </span>
                @endif
            </li>

            <li class="nav-item dropdown has-arrow main-drop">
                <a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
                    <span class="user-img"><img src="{{ Auth::user()->userProfile->picture }}" alt="">
                        <span class="status online"></span></span>
                </a>
                <div class="dropdown-menu menu-drop-user">
                    <div class="profilename">
                        <div class="profileset">
                            <span class="user-img"><img src="{{ Auth::user()->userProfile->picture }}" alt="">
                            </span>
                            <div class="profilesets">
                                {{-- <h6>John Doe</h6> --}}
                                {{-- <h5>Admin</h5> --}}
                                <h6>{{ Auth::user()->userProfile->first_name . ' ' . Auth::user()->userProfile->last_name }}
                                </h6>
                                <h5>{{ Auth::user()->role->name }}</h5>
                            </div>
                        </div>
                        <hr class="m-0">
                        <a class="dropdown-item" href="{{ route('my-profile.index') }}"> <i class="me-2"
                                data-feather="user"></i> My Profile</a>
                        <a class="dropdown-item" href="{{ url('example-page/generalsettings') }}"><i class="me-2"
                                data-feather="settings"></i>Settings</a>
                        <hr class="m-0">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item logout pb-0"><img
                                    src="{{ URL::asset('/assets/img/icons/log-out.svg') }}" class="me-2"
                                    alt="img">Logout</button>
                        </form>
                    </div>
                </div>
            </li>
        </ul>
        <!-- /Header Menu -->

        <!-- Mobile Menu -->
        <div class="dropdown mobile-user-menu">
            <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="{{ url('profile') }}">My Profile</a>
                <a class="dropdown-item" href="{{ url('generalsettings') }}">Settings</a>
                <a class="dropdown-item" href="{{ url('signin') }}">Logout</a>
            </div>
        </div>
        <!-- /Mobile Menu -->
    </div>
    <div class="page-wrapper ms-0">
        <div class="content">
            <div class="row">
                <div class="col-lg-8 col-sm-12 tabs_wrapper">
                    <div class="page-header ">
                        <div class="page-title">
                            <h4>Categories</h4>
                            <h6>Manage your purchases</h6>
                        </div>
                    </div>
                    <ul class=" tabs owl-carousel owl-theme owl-product  border-0 ">
                        <li class="active" id="all">
                            <div class="product-details ">
                                <h6>All</h6>
                            </div>
                        </li>
                        @foreach ($categories as $item)
                            <li id="{{ Str::slug($item->name) }}">
                                <div class="product-details ">
                                    <img src="{{ URL::asset('/images/category/' . $item->images) }}" alt="img">
                                    <h6>{{ Str::title($item->name) }}</h6>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tabs_container">
                        <div class="tab_content active" data-tab="all">
                            <div class="row ">
                                @foreach ($products as $item)
                                    <div class="col-lg-3 col-sm-6 d-flex ">
                                        <div class="productset flex-fill" data-id="{{ $item->id }}"
                                            data-name="{{ $item->name }}" data-price="{{ $item->price_sell }}"
                                            data-image="{{ URL::asset('/images/products/' . $item->images) }}"
                                            data-quantity="{{ $item->quantity }}"
                                            onclick="addToCart(event)">
                                            <div class="productsetimg">
                                                <img src="{{ URL::asset('/images/products/' . $item->images) }}"
                                                    alt="img">
                                                <h6>Qty: {{ $item->quantity }}</h6>
                                                <div class="check-product">
                                                    <i class="fa fa-check"></i>
                                                </div>
                                            </div>
                                            <div class="productsetcontent">
                                                <h5>{{ $item->category->name }}</h5>
                                                <h4>{{ $item->name }}</h4>
                                                <h6>Rp. {{ $item->price_sell }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        @foreach ($categories as $category)
                            <div class="tab_content" data-tab="{{ Str::slug($category->name) }}">
                                <div class="row ">
                                    @foreach ($category->product as $item)
                                        <div class="col-lg-3 col-sm-6 d-flex ">
                                            <div class="productset flex-fill" data-id="{{ $item->id }}"
                                                data-name="{{ $item->name }}" data-price="{{ $item->price_sell }}"
                                                data-image="{{ URL::asset('/images/products/' . $item->images) }}"
                                                data-quantity="{{ $item->quantity }}"
                                                onclick="addToCart(event)">
                                                <div class="productsetimg">
                                                    <img src="{{ URL::asset('/images/products/' . $item->images) }}"
                                                        alt="img">
                                                    <h6>Qty: {{ $item->quantity }}</h6>
                                                    <div class="check-product">
                                                        <i class="fa fa-check"></i>
                                                    </div>
                                                </div>
                                                <div class="productsetcontent">
                                                    <h5>{{ $item->category->name }}</h5>
                                                    <h4>{{ $item->name }}</h4>
                                                    <h6>Rp. {{ $item->price_sell }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12 ">
                    <div class="order-list">
                        <div class="orderid">
                            <h4>Order List</h4>
                            <h5>Transaction id : #</h5>
                        </div>
                        <div class="actionproducts">
                            <ul>
                                <li>
                                    <a href="javascript:void(0);" class="deletebg confirm-text"><img
                                            src="{{ URL::asset('/assets/img/icons/delete-2.svg') }}" alt="img"></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card card-order">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="select-split ">
                                        <div class="select-group w-100">
                                            <select class="select">
                                                <option>Walk-in Customer</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="select-split">
                                        <div class="select-group w-100">
                                            <select class="select">
                                                <option>Product </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="split-card">
                        </div>
                        <div class="card-body pt-0">
                            <div class="totalitem">
                                <h4>Total items : <span id="total-items">4</span> </h4>
                                <a href="javascript:void(0);" onclick="removeAllCart()">Clear all</a>
                            </div>
                            <div class="product-table">

                            </div>
                        </div>
                        <div class="split-card">
                        </div>
                        <div class="card-body pt-0 pb-2">
                            <div class="setvalue">
                                <ul>
                                    <li>
                                        <h5>Subtotal </h5>
                                        <h6>IDR. <span id="subtotal">5000</span></h6>
                                    </li>
                                    <li>
                                        <h5>Tax </h5>
                                        <h6>IDR. <span id="tax">5000</span></h6>
                                    </li>
                                    <li class="total-value">
                                        <h5>Total </h5>
                                        <h6>IDR. <span id="total">10000</span></h6>
                                    </li>
                                </ul>
                            </div>
                            <div class="setvaluecash">
                                <ul>
                                    <li>
                                        <a href="javascript:void(0);" class="paymentmethod" onclick="sendData()">
                                            <img src="{{ URL::asset('/assets/img/icons/cash.svg') }}" alt="img"
                                                class="me-2">
                                            Cash
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="btn-totallabel">
                                <h5>Checkout</h5>
                                <h6>IDR. <span id="checkout"></span></h6>
                            </div>
                            <div class="btn-pos">
                                <ul>
                                    <li>
                                        <a class="btn"><img src="{{ URL::asset('/assets/img/icons/pause1.svg') }}"
                                                alt="img" class="me-1">Hold</a>
                                    </li>
                                    <li>
                                        <a class="btn"><img src="{{ URL::asset('/assets/img/icons/edit-6.svg') }}"
                                                alt="img" class="me-1">Quotation</a>
                                    </li>
                                    <li>
                                        <a class="btn"><img src="{{ URL::asset('/assets/img/icons/trash12.svg') }}"
                                                alt="img" class="me-1">Void</a>
                                    </li>
                                    <li>
                                        <a class="btn"><img src="{{ URL::asset('/assets/img/icons/wallet1.svg') }}"
                                                alt="img" class="me-1">Payment</a>
                                    </li>
                                    <li>
                                        <a class="btn" data-bs-toggle="modal" data-bs-target="#recents"><img
                                                src="{{ URL::asset('/assets/img/icons/transcation.svg') }}"
                                                alt="img" class="me-1"> Transaction</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- @component('components.modal-popup')
    @endcomponent --}}

    @include('page.owner.sales.pos.script')
@endsection
