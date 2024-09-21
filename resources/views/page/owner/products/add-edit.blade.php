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
                    <section class="comp-section">
                        <div class="card-body">
                            @if (Route::is('owner.produk.daftar-produk.add'))
                                <div class="row">
                                    <div class="col-lg-5 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Pencarian Berdasarkan Barcode</label>
                                            <input id="searchBarcode" name="searchBarcode" type="text"
                                                class="form-control" value="{{ old('searchBarcode') }}" autofocus>
                                        </div>
                                    </div>
                                    <div class="col-lg-1 form-group mt-4 pt-1">
                                        <a class="btn btn-filters" id="clickSearch"><img
                                                src="{{ URL::asset('assets/img/icons/search-whites.svg') }}" alt="img"
                                                data-bs-toggle="tooltip" title="Cari"></a>
                                    </div>
                                    <div class="col-lg-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Hasil pencarian</label>
                                            <select class="form-control select" name="resultSearch" id="resultSearch">
                                                <option value="" disabled selected>Pilih...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label class="text-danger" id="messageErrorSearch"></label>
                                            <label id="messageSuccessSearch"></label>
                                        </div>
                                    </div>
                                </div>
                            @endif
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
                                                    <option value="{{ $category->name }}"
                                                        @if (strtolower(old('category')) == strtolower($category->name) || (isset($data) && $data->category_id == $category->id)) selected @endif>
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
                                                    <option value="{{ $brand->name }}"
                                                        @if (strtolower(old('brand')) == strtolower($brand->name) || (isset($data) && $data->brand_id == $brand->id)) selected @endif>
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
                                                value="{{ old('name') ?? ($data->name ?? null) }}">
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
                                                value="{{ old('sku') ?? ($data->sku ?? null) }}"
                                                @if (Route::is('owner.produk.daftar-produk.edit')) readonly @endif>
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
        if ({{ Route::is('owner.produk.daftar-produk.add') }}) {
            $(document).on('change', '#name', function() {
                autoCompleteSKU($(this).val());
            })
        }

        $(document).on('click', '#clickSearch', async function() {
            const value = $('#searchBarcode').val();
            if (!value) {
                return false;
            }
            let dataProducts = null;
            const url = "{{ route('owner.produk.daftar-produk.getProductsDatabase') }}"
            await $.ajax({
                url,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    sku: value
                },
                type: 'GET',
                success: function(data) {
                    if (data.status == 'error') {
                        $('#messageErrorSearch').text(data.msg)
                        $('#messageSuccessSearch').text('')
                        return;
                    }
                    $('#messageErrorSearch').text('')
                    $('#messageSuccessSearch').text(`${data.msg}. Total Data ${data.jmlData}`)
                    dataProducts = data.data;
                },
                error: function(error) {
                    console.error(error);
                }
            })

            const defaultOpt = `<option value="" disabled selected>Pilih...</option>`;
            const optProduk = dataProducts.map((produk) => {
                return `<option value="${produk.sku}">${produk.name} - ${produk.category || 'No Kategori'} - ${produk.brand || 'No Brand'}</option>`
            })
            $('#resultSearch').html(`${defaultOpt}${optProduk}`)
        })

        $('#resultSearch').on('change', async function() {
            const value = $(this).val();
            const url = "{{ route('owner.produk.daftar-produk.getOneProductsDatabase') }}"
            let product = null;
            await $.ajax({
                url,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    sku: value
                },
                type: 'GET',
                success: function(data) {
                    product = data.data;
                    $('#name').unbind('change')
                },
                error: function(error) {
                    console.error(error);
                }
            })
            $('#category').append(`<option value="${product.category}" selected>${product.category}</option>`)
            $('#brand').append(`<option value="${product.brand}" selected>${product.brand}</option>`)
            $('#name').val(product.name)
            $('#sku').val(product.sku)
            console.log(product);
        })
    </script>
@endsection
