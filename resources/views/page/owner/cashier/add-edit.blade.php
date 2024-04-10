<?php $page = 'menus'; ?>
@extends('layout.mainlayout')

@section('title', isset($data) ? 'Edit Kasir' : 'Tambah Kasir')

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
                            <li class="breadcrumb-item"><a href="{{ url('owner/orang/kasir') }}">Daftar Kasir</a></li>
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
                                action="{{ isset($data) ? route('owner.orang.kasir.update', Crypt::encrypt($data->id)) : route('owner.orang.kasir.store') }}"
                                method="post" enctype="multipart/form-data">
                                @csrf
                                @if (isset($data))
                                    {{ method_field('put') }}
                                @endif
                                <div class="row">
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Nama Lengkap</label>
                                            <input id="name" name="name" type="text"
                                                @if (isset($data)) readonly @endif
                                                class="form-control @error('name') is-invalid @enderror"
                                                value="{{ Str::headline(old('name') ?? ($data->name ?? null)) }}" autofocus>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="gender"class="form-label">Jenis Kelamin</label>
                                            <select name="gender" id="gender" class="select form-small">
                                                <option value="male"
                                                    @if (old('gender') == 'male' || (isset($data) && $data->gender == 'male')) selected disabled @endif>
                                                    {{ Str::ucfirst('laki-laki') }}
                                                </option>
                                                <option value="female"
                                                    @if (old('gender') == 'female' || (isset($data) && $data->gender == 'female')) selected disabled @endif>
                                                    {{ Str::ucfirst('perempuan') }}</option>
                                            </select>
                                            @error('gender')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Tanggal Lahir <span class="text-muted">(tidak wajib)</span></label>
                                            <div class="input-groupicon">
                                                <input id="birthDate" name="birthDate" type="text"
                                                    @if (isset($data)) readonly @endif
                                                    placeholder="Pilih Tanggal Lahir"
                                                    class="datetimepicker form-control @error('birthDate') is-invalid @enderror"
                                                    value="{{ old('birthDate') ?? (isset($data->birthDate) ? Carbon\Carbon::createFromFormat('Y-m-d', $data->birthDate)->format('d-m-Y') : null) }}" />
                                                <div class="addonset">
                                                    <img src="{{ URL::asset('assets/img/icons/calendars.svg') }}"
                                                        alt="img" />
                                                </div>
                                                @error('birthDate')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Alamat <span class="text-muted">(tidak wajib)</span></label>
                                            <input id="address" name="address" type="text"
                                                @if (isset($data)) readonly @endif
                                                class="form-control @error('address') is-invalid @enderror"
                                                value="{{ Str::headline(old('address') ?? ($data->address ?? null)) }}">
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input id="email" name="email" type="text"
                                                @if (isset($data)) readonly @endif
                                                class="form-control @error('email') is-invalid @enderror"
                                                value="{{ old('email') ?? ($data->email ?? null) }}">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Nama Pengguna</label>
                                            <input id="username" name="username" type="text"
                                                @if (isset($data)) readonly @endif
                                                class="form-control @error('username') is-invalid @enderror"
                                                value="{{ old('username') ?? ($data->username ?? null) }}">
                                            @error('username')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">*) Nama pengguna harus tanpa spasi
                                            </div>
                                        </div>
                                    </div>
                                    @if (isset($data))
                                        <div class="col-lg-3 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select name="status" id="status" class="select form-small">
                                                    <option value="0"
                                                        @if (old('status') == '0' || (isset($data) && $data->status == '0')) selected disabled @endif>
                                                        {{ Str::ucfirst('Aktif') }}
                                                    </option>
                                                    <option value="1"
                                                        @if (old('status') == '1' || (isset($data) && $data->status == '1')) selected disabled @endif>
                                                        {{ Str::ucfirst('Resign') }}</option>
                                                    <option value="2"
                                                        @if (old('status') == '2' || (isset($data) && $data->status == '2')) selected disabled @endif>
                                                        {{ Str::ucfirst('Keluar') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                    @if (!isset($data))
                                        <div class="col-lg-3 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label>Password</label>
                                                <div class="pass-group">
                                                    <input id="password" name="password" type="password"
                                                        class="form-control pass-input @error('password') is-invalid @enderror">
                                                    <span class="fas toggle-password fa-eye-slash"></span>
                                                    @error('password')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label>Ulangi Password</label>
                                                <div class="pass-group">
                                                    <input id="password_confirmation" name="password_confirmation"
                                                        type="password"
                                                        class="form-control pass-input @error('password_confirmation') is-invalid @enderror">
                                                    <span class="fas toggle-password fa-eye-slash"></span>
                                                    @error('password_confirmation')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Foto Profil <span class="text-muted">(tidak wajib)</span></label>
                                                <div class="image-upload">
                                                    <input id="imageUpload" name="picture" type="file"
                                                        class="form-control @error('picture') is-invalid @enderror">
                                                    <div class="image-uploads">
                                                        <img src="{{ URL::asset('assets/img/icons/upload.svg') }}"
                                                            alt="img">
                                                        <h4 id="imgNameUpload">Seret dan jatuhkan file untuk diunggah</h4>
                                                    </div>
                                                    @error('picture')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-submit me-2">Kirim</button>
                                        <a href="{{ route('owner.orang.kasir.index') }}" class="btn btn-cancel">Batal</a>
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
