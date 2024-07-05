<?php $page = 'menus'; ?>
@extends('layout.mainlayout')

@section('title', isset($data) ? 'Edit Produk' : 'Tambah Produk')

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
                            <li class="breadcrumb-item"><a href="{{ url('owner/produk/daftar-produk') }}">Produk</a></li>
                            <li class="breadcrumb-item active"> @yield('title') </li>
                        </ul>
                    </h6>
                </div>
            </div>

            {{-- Body Start --}}
            <div class="row">
                <div class="col-sm-12">

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif


                    <section class="comp-section">
                        <div class="card-body">
                            <form
                                action="{{ isset($data) ? route('owner.produk.daftar-produk.update', Crypt::encrypt($data->id)) : route('owner.produk.daftar-produk.store') }}"
                                method="post" enctype="multipart/form-data">
                                @csrf
                                @if (isset($data))
                                    {{ method_field('put') }}
                                @endif
                                <div class="row">
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Kategori</label>
                                            <select name="category"
                                                class="form-control @error('category') is-invalid @enderror select"
                                                id="category">
                                                <option value="" disabled selected>Pilih...</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        @if (old('category') == $category->id || (isset($data) && $data->category_id == $category->id)) selected @endif>
                                                        {{ Str::ucfirst($category->name) }}</option>
                                                @endforeach
                                            </select>
                                            @error('category')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-3
                                    col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Merek</label>
                                            <select name="brand"
                                                class="form-control @error('brand') is-invalid @enderror select"
                                                id="brand">
                                                <option value="" disabled selected>Pilih...</option>
                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand->id }}"
                                                        @if (old('brand') == $brand->id || (isset($data) && $data->brand_id == $brand->id)) selected @endif>
                                                        {{ Str::ucfirst($brand->name) }}</option>
                                                @endforeach
                                            </select>
                                            @error('brand')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Nama</label>
                                            <input id="name" name="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror"
                                                value="{{ old('name') ?? ($data->name ?? null) }}" autofocus>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- TODO: SKU auto generate ketika input name --}}
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>SKU</label>
                                            <input id="sku" name="sku" type="text"
                                                class="form-control @error('sku') is-invalid @enderror"
                                                value="{{ old('sku') ?? ($data->sku ?? null) }}" readonly>
                                            @error('sku')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- TODO: Buat price sesuai format Rp Indo --}}
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Harga Beli</label>
                                            <input id="buying_price" name="buying_price" type="text"
                                                class="form-control @error('buying_price') is-invalid @enderror"
                                                value="{{ old('buying_price') ?? ($data->price_buy ?? null) }}">
                                            @error('buying_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Harga Jual</label>
                                            <input id="selling_price" name="selling_price" type="text"
                                                class="form-control @error('selling_price') is-invalid @enderror"
                                                value="{{ old('selling_price') ?? ($data->price_sell ?? null) }}">
                                            @error('selling_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Satuan</label>
                                            <input id="unit" name="unit" type="text"
                                                class="form-control @error('unit') is-invalid @enderror"
                                                value="{{ old('unit') ?? ($data->unit ?? null) }}">
                                            @error('unit')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Jumlah</label>
                                            <input id="quantity" name="quantity" type="text"
                                                class="form-control @error('quantity') is-invalid @enderror"
                                                value="{{ old('quantity') ?? ($data->quantity ?? null) }}">
                                            @error('quantity')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Deskripsi</label>
                                            <textarea id="description" name="description" class="form-control">{{ old('description') ?? ($data->description ?? null) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Gambar Produk</label>
                                            <div class="image-upload">
                                                <input id="imageUpload" name="image" type="file"
                                                    class="form-control @error('image') is-invalid @enderror">
                                                <div class="image-uploads">
                                                    <img src="{{ URL::asset('assets/img/icons/upload.svg') }}"
                                                        alt="img">
                                                    <h4 id="imgNameUpload">Seret dan jatuhkan file untuk diunggah</h4>
                                                </div>
                                                @error('image')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-submit me-2">Kirim</button>
                                        <a href="{{ route('owner.produk.daftar-produk.index') }}"
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
@section('forscript')
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
    </script>
    <script>
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
            $('#buying_price').val(formatRupiah($('#buying_price').val(), 'Rp'));
            $('#selling_price').val(formatRupiah($('#selling_price').val(), 'Rp'));
        })

        $(document).on('keyup', '#buying_price', function() {
            $('#buying_price').val(formatRupiah($(this).val(), 'Rp'));
        })
        $(document).on('keyup', '#selling_price', function() {
            $('#selling_price').val(formatRupiah($(this).val(), 'Rp'));
        })

        function autoCompleteSKU(nameProduct) {
            const name = nameProduct.split(' ').map(value => value[0]?.toUpperCase()).join('').trim();
            $.ajax({
                url: "{{ route('owner.produk.daftar-produk.checkSKU') }}",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    sku: name
                },
                type: 'POST',
                success: function(sku) {
                    $('#sku').val(sku)
                }
            })
        }

        $(document).on('change', '#name', function() {
            autoCompleteSKU($(this).val());
        })
    </script>
@endsection
