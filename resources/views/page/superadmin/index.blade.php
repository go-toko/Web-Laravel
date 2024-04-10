<?php $page = 'blankpage'; ?>
@extends('layout.mainlayout')

@section('title', 'Dashboard')

@section('content')
    <div class="page-wrapper pagehead">
        <div class="content">
            <div class="row">
                <div class="col-lg-3 col-sm-6 col-12 d-flex">
                    <div class="dash-count">
                        <div class="dash-counts">
                            <h4 id="total-users">-</h4>
                            <h5>User</h5>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="user"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12 d-flex">
                    <div class="dash-count das1">
                        <div class="dash-counts">
                            <h4 id="online-users">-</h4>
                            <h5>User Online</h5>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="user-check"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12 d-flex">
                    <div class="dash-count das2">
                        <div class="dash-counts">
                            <h4 id="subscription-users">-</h4>
                            <h5>Subscriber</h5>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="dollar-sign"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12 d-flex">
                    <div class="dash-count das3">
                        <div class="dash-counts">
                            <h4 id="total-shops">-</h4>
                            <h5>Shops</h5>
                        </div>
                        <div class="dash-imgs">
                            <i data-feather="home"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-sm-12 col-12 d-flex">
                    <div class="card flex-fill">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Subscription Graph</h5>
                        </div>
                        <div class="card-body" style="position: relative;">
                            <canvas id="SubscriptionChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12 col-12 d-flex">
                    <div class="card flex-fill">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Users</h5>
                        </div>
                        <div class="card-body" style="position: relative;">
                            <div class="table-responsive">
                                <table class="table  dataview ">
                                    <thead>
                                        <tr>
                                            <th>Picture</th>
                                            <th>Name</th>
                                            <th>E-Mail</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $item)
                                            <tr>
                                                <td>
                                                    <div class="avatar">
                                                        <img class="avatar-img rounded-circle" alt="User Image"
                                                            src="{{ isset($item->userProfile->picture) ? $item->userProfile->picture : asset('category/images/noimage.png') }}">
                                                    </div>
                                                </td>
                                                <td>{{ $item->userProfile ? $item->userProfile->first_name . ' ' . $item->userProfile->last_name : $item->userCashierProfile->name }}
                                                    @if ($item->isSubscribe === 1)
                                                        <i class="fas fa-crown"></i>
                                                    @endif
                                                </td>
                                                {{-- <td> @hideEmail("$item->email") </td> --}}
                                                <td> {{ $item->email }} </td>
                                                <td>{{ $item->role->name }}</td>
                                                <td>
                                                    @if (Cache::has('is_online' . $item->id))
                                                        <span class="text-success">Online</span>
                                                    @else
                                                        <span class="text-danger">Offline</span>
                                                    @endif
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
            <div class="card mb-0">
                <div class="card-body">
                    <h4 class="card-title">
                        List Menu
                    </h4>
                    <div class="row">
                        <div class="col-sm-12">
                            <section class="comp-section">
                                <div class="card-body">
                                    <ul class="nav nav-tabs nav-tabs-solid nav-justified">
                                        @foreach ($roles as $role)
                                            <li class="nav-item"><a class="nav-link" href="#{{ $role->name }}"
                                                    data-bs-toggle="tab">{{ $role->name }}</a></li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content">
                                        @foreach ($roles as $role)
                                            <div class="tab-pane" id="{{ $role->name }}">
                                                <div class="container-fluid my-3">
                                                    <div class="row">
                                                        <div class="menu">
                                                            @foreach ($role->roleMenu as $roleMenu)
                                                                <div id="menu-set" data-id="{{ $roleMenu->id }}">
                                                                    <div class="col-12">
                                                                        <div class="d-flex justify-content-between align-items-center mb-3 rounded"
                                                                            style="background-color: whitesmoke;">
                                                                            <h3 class="p-3"><span
                                                                                    class="{{ $roleMenu->menu->icon }} me-1"></span>{{ Str::title($roleMenu->menu->name) }}
                                                                            </h3>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        @if ($roleMenu->menu->subMenu->count() > 0)
                                                                            <ul>
                                                                                @foreach ($roleMenu->menu->subMenu as $subMenu)
                                                                                    <li class="d-flex justify-content-between align-items-center mb-2 rounded ms-4"
                                                                                        style="background-color: gainsboro;">
                                                                                        <div class="col-10 my-1 p-3">
                                                                                            {{ Str::title($subMenu->name) }}
                                                                                        </div>
                                                                                    </li>
                                                                                @endforeach
                                                                            </ul>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('page.superadmin.script')
