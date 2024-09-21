<?php $page = 'menus'; ?>
@extends('layout.mainlayout')

@section('title', isset($data) ? 'Edit Pengeluaran' : 'Tambah Pengeluaran')

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
                            <li class="breadcrumb-item"><a href="{{ url('owner/pengeluaran/pengeluaran') }}">Pengeluaran</a>
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
                                action="{{ isset($data) ? route('owner.pengeluaran.pengeluaran.update', Crypt::encrypt($data->id)) : route('owner.pengeluaran.pengeluaran.store') }}"
                                method="post" enctype="multipart/form-data">
                                @csrf
                                @if (isset($data))
                                    {{ method_field('put') }}
                                @endif
                                <div class="row">
                                    <div class="col-lg-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Kategori</label>
                                            <select name="category"
                                                class="form-control @error('category') is-invalid @enderror select"
                                                id="category">
                                                <option value="" disabled selected>Pilih...</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        @if (old('category') == $category->id || (isset($data) && $data->category_id == $category->id)) selected @endif>
                                                        {{ Str::title($category->name) }}</option>
                                                @endforeach
                                            </select>
                                            @error('category')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Tanggal Pelaksanaan</label>
                                            <div class="input-groupicon">
                                                <input id="date" name="date" type="text"
                                                    placeholder="Pilih Tanggal"
                                                    class="datetimepicker form-control @error('date') is-invalid @enderror"
                                                    value="{{ old('date') ?? (isset($data->date) ? Carbon\Carbon::createFromFormat('Y-m-d', $data->date)->format('d-m-Y') : Carbon\Carbon::now()->format('d-m-Y')) }}"
                                                    required>
                                                <div class="addonset">
                                                    <img src="{{ URL::asset('assets/img/icons/calendars.svg') }}"
                                                        alt="img" />
                                                </div>
                                                @error('date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    {{-- DONE: Buat price sesuai format Rp Indo --}}
                                    <div class="col-lg-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Jumlah Pengeluaran</label>
                                            <input id="amount" name="amount" type="text"
                                                class="form-control @error('amount') is-invalid @enderror"
                                                value="{{ old('amount') ?? ($data->amount ?? null) }}" required>
                                            @error('amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Pengeluaran Untuk</label>
                                            <input id="name" name="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror"
                                                value="{{ old('name') ?? ($data->name ?? null) }}" autofocus required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Deskripsi <span class="text-muted">(tidak wajib)</span></label>
                                            <textarea id="description" name="description" class="form-control">{{ old('description') ?? ($data->description ?? null) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Nota Pengeluaran</label>
                                            <div class="image-upload mb-0">
                                                <input id="imageUpload" name="image" type="file"
                                                    class="form-control @error('image') is-invalid @enderror">
                                                <div class="image-uploads">
                                                    <img src="{{ URL::asset('assets/img/icons/upload.svg') }}"
                                                        alt="img">
                                                    <h4 id="imgNameUpload">Seret dan jatuhkan file untuk diunggah</h4>
                                                </div>
                                            </div>
                                            <div class="text-danger">Ukuran file maximal 2MB (2048KB)</div>
                                            @error('image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-submit me-2">Kirim</button>
                                        <a href="{{ route('owner.pengeluaran.pengeluaran.index') }}"
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
    <script type="text/javascript">
        const input = document.getElementById('imageUpload');
        const name = document.getElementById('imgNameUpload');
        input.addEventListener('change', function() {
            const file = input.files[0];
            name.textContent = file.name;
        });
    </script>
    <script>
        $(window).ready(function() {
            $('.select').select2();
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
            $('#amount').val(formatRupiah($('#amount').val(), 'Rp'))
        })
        $(document).on('keyup', '#amount', function() {
            $(this).val(formatRupiah($(this).val(), 'Rp'))
        })
    </script>
@endsection
