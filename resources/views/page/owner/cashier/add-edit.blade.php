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
                                    <div class="col-lg-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Nama Depan</label>
                                            <input id="first_name" name="first_name" type="text"
                                                @if (isset($data)) readonly @endif
                                                class="form-control @error('first_name') is-invalid @enderror"
                                                value="{{ old('first_name') ?? ($data->first_name ?? null) }}" autofocus>
                                            @error('first_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Nama Belakang</label>
                                            <input id="last_name" name="last_name" type="text"
                                                @if (isset($data)) readonly @endif
                                                class="form-control @error('last_name') is-invalid @enderror"
                                                value="{{ old('last_name') ?? ($data->last_name ?? null) }}">
                                            @error('last_name')
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
                                            <label>Telepon</label>
                                            <input id="phone" name="phone" type="text"
                                                class="form-control @error('phone') is-invalid @enderror"
                                                value="{{ old('phone') ?? ($data->phone ?? null) }}">
                                            @error('phone')
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
                                            <label>Pilih Toko</label>
                                            <select name="shop" id="shop" class="select form-small">
                                                @foreach ($shops as $shop)
                                                    <option value="{{ $shop->id }}"
                                                        {{ isset($data) && $data->shop_id == $shop->id ? 'selected' : '' }}>
                                                        {{ $shop->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('shop')
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
                                            <input id="nickname" name="nickname" type="text"
                                                @if (isset($data)) readonly @endif
                                                class="form-control @error('nickname') is-invalid @enderror"
                                                value="{{ old('nickname') ?? ($data->nickname ?? null) }}">
                                            @error('nickname')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    @if (!isset($data))
                                        <div class="col-lg-3 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label>Password</label>
                                                <div class="pass-group">
                                                    <input id="password" name="password" type="password"
                                                        class="form-control pass-input @error('password') is-invalid @enderror">
                                                    <span class="fas toggle-password fa-eye-slash"></span>
                                                    @error('password')
                                                        <span class="invalid-feedback">{{ $message }}</span>
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
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-lg-12 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label>Alamat <span class="text-muted">(tidak wajib)</span></label>
                                            <textarea name="address" class="form-control" id="address" cols="30" rows="10">{{ old('address') ?? ($data->address ?? null) }}</textarea>
                                        </div>
                                    </div>
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

<?php
$title = e($__env->yieldContent('title'));
$type = Session::get('type');
$msg = Session::get($type);
?>

@section('forscript')
    <script type="text/javascript">
        const input = document.getElementById('imageUpload');
        const name = document.getElementById('imgNameUpload');
        input?.addEventListener('change', function() {
            const file = input.files[0];
            name.textContent = file.name;
        });
    </script>
    <script src="{{ URL::asset('/assets/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/plugins/toastr/toastr.js') }}"></script>
    @if ($type != null)
        <script>
            let type = {!! json_encode($type) !!};
            let msg = {!! json_encode($msg) !!};
            const title = {!! json_encode($title) !!};
            toastr[type](msg, title)
        </script>
    @endif
    <script>
        $(window).ready(function() {
            $('.select').select2();
        })
    </script>
@endsection
