<?php $page = 'menus'; ?>
@extends('layout.mainlayout')

@section('title', 'Settings Menu')

@section('forhead')
    {{-- Toastr Style --}}
    <link rel="stylesheet" href="{{ url('assets/plugins/toastr/toatr.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <div class="page-wrapper pagehead">
        <div class="content">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Menu Management</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('superadmin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Menu Management</li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="wordset">
                        <ul>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"
                                    href="{{ route('superadmin.settings.menu.report-pdf') }}"><img
                                        src="{{ URL::asset('/assets/img/icons/pdf.svg') }}" alt="img"></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
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
                                    <div class="tab-pane  @if ($role->name == 'Superadmin') active @endif"
                                        id="{{ $role->name }}">
                                        <button type="button" class="btn btn-primary add-menu" data-bs-toggle="modal"
                                            data-role="{{ json_encode($role) }}"
                                            data-action="{{ route('superadmin.settings.menu.store') }}" data-method="POST"
                                            data-bs-target="#modalMenu">Create new
                                            Menu</button>
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
                                                                    <div>
                                                                        <button class="btn btn-sm btn-success add-submenu"
                                                                            data-bs-target="#modalSubmenu"
                                                                            data-bs-toggle="modal"
                                                                            data-menu="{{ Str::lower($roleMenu->menu) }}"
                                                                            data-action="{{ route('superadmin.settings.menu.submenu.store') }}"
                                                                            data-method="POST">
                                                                            Add Submenu</button>
                                                                        <button class="btn btn-sm btn-primary edit-menu"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#modalMenu"
                                                                            data-menu="{{ json_encode($roleMenu) }}"
                                                                            data-action="{{ route('superadmin.settings.menu.update', $roleMenu->menu->id) }}"
                                                                            data-method="POST">Edit</button>
                                                                        <button type="button" id="confirm-delete"
                                                                            class="btn btn-sm btn-danger"
                                                                            data-role_id="{{ $roleMenu->role_id }}"
                                                                            data-action="{{ route('superadmin.settings.menu.destroy', $roleMenu->menu->id) }}">Delete</button>
                                                                    </div>
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
                                                                                <div
                                                                                    class="col-2 d-flex justify-content-end">
                                                                                    <div>
                                                                                        <button
                                                                                            class="btn btn-sm btn-primary edit-submenu"
                                                                                            data-bs-toggle="modal"
                                                                                            data-bs-target="#modalSubmenu"
                                                                                            data-submenu="{{ json_encode($subMenu) }}"
                                                                                            data-action="{{ route('superadmin.settings.menu.submenu.update', $subMenu->id) }}"
                                                                                            data-method="POST">Edit</button>
                                                                                        <button
                                                                                            class="btn btn-sm btn-danger me-4"
                                                                                            id="confirm-delete"
                                                                                            data-action="{{ route('superadmin.settings.menu.submenu.destroy', $subMenu->id) }}">Delete</button>
                                                                                    </div>
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


@endsection
@include('page.superadmin.settings.menu.modal-menu')
{{-- @include('page.superadmin.settings.menu.modal-submenu') --}}
