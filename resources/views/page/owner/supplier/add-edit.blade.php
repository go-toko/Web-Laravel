<?php $page = 'menus'; ?>
@extends('layout.mainlayout')

@section('title', isset($data) ? 'Edit Pemasok' : 'Tambah Pemasok')

@section('forhead')
    {{-- Toastr Style --}}
    <link rel="stylesheet" href="{{ url('assets/plugins/toastr/toatr.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <div class="page-wrapper pagehead">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>@yield('title')</h4>
                    <h6>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('owner/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('owner/orang/pemasok') }}">Daftar Pemasok</a></li>
                            <li class="breadcrumb-item active"> @yield('title') </li>
                        </ul>
                    </h6>
                </div>
            </div>

            {{-- Body Start --}}
            <div class="row">
                <div class="col-sm-12">
                    <section class="comp-section">
                        <div class="card-body">
                            <form
                                action="{{ isset($data) ? route('owner.orang.pemasok.update', Crypt::encrypt($data->id)) : route('owner.orang.pemasok.store') }}"
                                method="post" enctype="multipart/form-data">
                                @csrf
                                @if (isset($data))
                                    {{ method_field('put') }}
                                @endif
                                <div class="row">
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Nama Supplier</label>
                                            <input id="name" name="name" type="text"
                                                @if (isset($data))  @endif
                                                class="form-control @error('name') is-invalid @enderror"
                                                value="{{ (old('name') ?? ($data->name ?? null)) }}" autofocus>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Nomer Telepon</label>
                                            <input id="phone" name="phone" type="text"
                                                @if (isset($data))  @endif
                                                class="form-control @error('phone') is-invalid @enderror"
                                                value="{{ (old('phone') ?? ($data->phone ?? null)) }}"
                                                autofocus>
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Alamat</label>
                                            <input id="address" name="address" type="text"
                                                @if (isset($data))  @endif
                                                class="form-control @error('address') is-invalid @enderror"
                                                value="{{ (old('address') ?? ($data->address ?? null)) }}"
                                                autofocus>
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Deskripsi <span class="text-muted">(optional)</span></label>
                                            <textarea id="description" name="description" class="form-control">{{ old('description') ?? ($data->description ?? null) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-submit me-2">Kirim</button>
                                        <a href="{{ route('owner.orang.pemasok.index') }}" class="btn btn-cancel">Batal</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('forscript')
    <script type="text/javascript">
        const input = document.getElementById('imageUpload');
        const name = document.getElementById('imgNameUpload');
        input?.addEventListener('change', function() {
            const file = input.files[0];
            name.textContent = file.name;
        });
    </script>
    <script>
        $(window).ready(function() {
            $('.select').select2();
        })
    </script>
@endsection
