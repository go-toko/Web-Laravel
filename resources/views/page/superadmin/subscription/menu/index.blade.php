<?php $page = 'menus'; ?>
@extends('layout.mainlayout')

@section('title', 'Settings Menu')

@section('forhead')
    {{-- Toastr Style --}}
    <link rel="stylesheet" href="{{ url('assets/plugins/toastr/toatr.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @livewireStyles
@endsection

@section('content')
    <div class="page-wrapper pagehead">
        <div class="content">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Subscribe Menu</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('superadmin/dashboard') }}">Subscribe</a></li>
                            <li class="breadcrumb-item active">Subscribe Menu</li>
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
                                    <div class="tab-pane show" id="{{ $role->name }}">
                                        <div class="container-fluid my-3">
                                            <div class="row">
                                                @foreach ($role->roleMenu as $roleMenu)
                                                    <div class="col-12">
                                                        <div class="d-flex justify-content-between align-items-center mb-3 rounded"
                                                            style="background-color: whitesmoke;">
                                                            <h3 class="p-3"><span
                                                                    class="{{ $roleMenu->menu->icon }} me-1"></span>{{ Str::title($roleMenu->menu->name) }}
                                                            </h3>
                                                            @livewire('superadmin.subscribe.toggle-switch', ['model' => $roleMenu, 'field' => 'subscribe'], key($roleMenu->menu->id))
                                                        </div>
                                                    </div>
                                                @endforeach
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

@section('forscript')
@livewireScripts
@endsection
