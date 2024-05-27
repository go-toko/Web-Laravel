<?php $page = 'menus'; ?>
@extends('layout.mainlayout')

@section('title', isset($data) ? 'Edit Toko' : 'Tambah Toko')

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
                            <li class="breadcrumb-item"><a href="{{ url('owner/pengaturan/daftar-toko') }}">Daftar Toko</a>
                            </li>
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
                                action="{{ isset($data) ? route('owner.pengaturan.daftar-toko.update', Crypt::encrypt($data->id)) : route('owner.pengaturan.daftar-toko.store') }}"
                                method="post">
                                @csrf
                                @if (isset($data))
                                    {{ method_field('put') }}
                                @endif
                                <div class="row">
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Nama Toko</label>
                                            <input id="name" name="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror"
                                                value="{{ old('name') ?? ($data->name ?? null) }}" autofocus required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Deskripsi</label>
                                            <input id="description" name="description" type="text"
                                                class="form-control @error('description')
                                                is-invalid
                                            @enderror"
                                                value="{{ old('description') ?? ($data->description ?? null) }}" required>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="balance">Saldo</label>
                                            <input type="text" name="balance" id="balance"
                                                class="form-control @error('balance') is-invalid @enderror"
                                                value="{{ old('balance') ?? ($data->balance ?? null) }}"
                                                {{ isset($data) ? 'readonly' : '' }}>
                                            @error('balance')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div> --}}
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Provinsi</label>
                                            <select name="province" id="province"
                                                class="select @error('province') is-invalid @enderror">
                                                <option value="null" selected disabled>-- Select --</option>
                                                @foreach ($provinces as $province)
                                                    <option value="{{ $province->id }}"
                                                        {{ old('province') === $province->id ? 'selected' : '' }}>
                                                        {{ $province->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('province')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Kabupaten</label>
                                            <select name="regency" id="regency"
                                                class="select  @error('regency') is-invalid @enderror">
                                                <option value="null" selected disabled>-- Select --</option>
                                            </select>
                                            @error('regency')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Kecamatan</label>
                                            <select name="district" id="district"
                                                class="select @error('district') is-invalid @enderror">
                                                <option value="null" selected disabled>-- Select --</option>
                                            </select>
                                            @error('district')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Desa</label>
                                            <select name="village" id="village"
                                                class="select @error('village') is-invalid @enderror">
                                                <option value="null" selected disabled>-- Select --</option>
                                            </select>
                                            @error('village')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Alamat <span class="text-muted">(tidak wajib)</span></label>
                                            <textarea id="address" name="address" class="form-control">{{ old('address') ?? ($data->address ?? null) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-submit me-2">Kirim</button>
                                        <a href="{{ route('owner.pengaturan.daftar-toko.index') }}"
                                            class="btn btn-cancel">Batal</a>
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
// dd($type);
?>

@section('forscript')
    {{-- Toast import js --}}
    <script src="{{ URL::asset('/assets/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/plugins/toastr/toastr.js') }}"></script>

    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
        })

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? prefix + rupiah : '');
        }

        $(document).ready(function() {
            $('#balance').val(formatRupiah($('#balance').val() ?? 0, 'Rp'))
        })

        $(document).on('keyup', '#balance', function() {
            $(this).val(formatRupiah($(this).val() ?? 0, 'Rp'))
        })

        // get and display kabupaten
        $(function() {
            $('#province').on('change', function() {
                let idProvince = $('#province').val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('owner.complete-profile.getRegencies') }}',
                    data: {
                        id_province: idProvince
                    },
                    cache: false,
                    success: function(regency) {
                        $('#regency').html(regency)
                    },
                })
            })
        })

        // get and display kecamatan
        $(function() {
            $('#regency').on('change', function() {
                let idRegency = $('#regency').val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('owner.complete-profile.getDistrict') }}',
                    data: {
                        id_regency: idRegency
                    },
                    cache: false,
                    success: function(district) {
                        $('#district').html(district)
                    },
                })
            })
        })

        // get and display desa
        $(function() {
            $('#district').on('change', function() {
                let idDistrict = $('#district').val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('owner.complete-profile.getVillage') }}',
                    data: {
                        id_district: idDistrict
                    },
                    cache: false,
                    success: function(villages) {
                        $('#village').html(villages)
                    }
                })
            })
        })
    </script>
    <script>
        $(document).ready(function() {
            $('.select').select2()
        })
    </script>
    @if ($type != null)
        <script>
            let type = {!! json_encode($type) !!};
            let msg = {!! json_encode($msg) !!};
            const title = {!! json_encode($title) !!};

            toastr[type](msg, title)
        </script>
    @endif
@endsection
