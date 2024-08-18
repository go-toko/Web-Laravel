<?php $page = 'menus'; ?>
@extends('layout.mainlayout')

@section('title', isset($data) ? 'Edit Restock Produk' : 'Tambah Restock Produk')

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
                            <li class="breadcrumb-item"><a href="{{ url('owner/produk/restock') }}">Restock</a></li>
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
                                action="{{ isset($data) ? route('owner.produk.restock.update', Crypt::encrypt($data->id)) : route('owner.produk.restock.store') }}"
                                method="post" enctype="multipart/form-data">
                                @csrf
                                @if (isset($data))
                                    {{ method_field('put') }}
                                @endif
                                <div class="row">
                                    <div class="col-lg-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Tanggal Restock</label>
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
                                    <div class="col-lg-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Supplier</label>
                                            <select name="supplier"
                                                class="form-control @error('supplier') is-invalid @enderror select"
                                                id="supplier">
                                                <option value="" disabled selected>Pilih...</option>
                                                @foreach ($supplier as $item)
                                                    <option value="{{ $item->id }}"
                                                        @if (old('supplier') == $item->id || (isset($data) && $data->supplier_id == $item->id)) selected @endif>
                                                        {{ Str::ucfirst($item->name) }}</option>
                                                @endforeach
                                            </select>
                                            @error('supplier')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12" id="dynamicInput">
                                        <div class="row">
                                            <div class="col-lg-3 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label>Produk</label>
                                                    <select name="product[0]" id="product[0]"
                                                        class="form-control @error('product[0]') is-invalid @enderror select">
                                                        <option disabled selected>Pilih...</option>
                                                        @foreach ($products as $item)
                                                            <option value="{{ $item->id }}">
                                                                {{ $item->name }} - {{ $item->unit }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label>Banyaknya</label>
                                                    <input id="quantity[0]" name="quantity[0]" type="number"
                                                        class="form-control @error('quantity[0]')
                                                is-invalid
                                            @enderror"
                                                        value="{{ old('quantity[0]') ?? ($data->quantity ?? null) }}">
                                                    @error('quantity[0]')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label>Harga Beli</label>
                                                    <input id="price_buy[0]" name="price_buy[0]" type="text"
                                                        class="form-control formatRupiah @error('price_buy[0]')
                                                is-invalid
                                            @enderror"
                                                        value="{{ old('price_buy[0]') ?? ($data->price_buy ?? null) }}">
                                                    @error('price_buy[0]')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label>Harga Jual Terbaru</label>
                                                    <input id="price_sell[0]" name="price_sell[0]" type="text"
                                                        class="form-control formatRupiah @error('price_sell[0]')
                                                is-invalid
                                            @enderror"
                                                        value="{{ old('price_sell[0]') ?? ($data->price_sell ?? null) }}">
                                                    @error('price_sell[0]')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-6 col-12" style="margin-top: 29px">
                                                <button type="button" name="add" id="dynamic-add"
                                                    class="btn btn-primary">Tambah Produk</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="test">Deskripsi</label>
                                            <textarea id="description" name="description" class="form-control">{{ old('description') ?? ($data->description ?? null) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-submit me-2">Kirim</button>
                                        <a href="{{ route('owner.produk.restock.index') }}"
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
?>

@section('forscript')
    {{-- Toast import js --}}
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
            $('.formatRupiah').each(function() {
                $(this).val(formatRupiah($(this).val(), 'Rp'))
            })
        })
        $(document).on('keyup', '.formatRupiah', function() {
            $(this).val(formatRupiah($(this).val(), 'Rp'))
        })
    </script>
    <script>
        let index = 0;
        $(document).on('click', '#dynamic-add', function() {
            index++
            $('#dynamicInput').append(`<div class="row item-dynamic">
                                            <div class="col-lg-3 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label>Produk</label>
                                                    <select name="product[${index}]" id="product[${index}]"
                                                        class="form-control @error('product[${index}]') is-invalid @enderror select">
                                                        <option value="" disabled selected>Pilih...</option>
                                                        @foreach ($products as $item)
                                                            <option value="{{ $item->id }}">
                                                                {{ $item->name }} - {{ $item->unit }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label>Banyaknya</label>
                                                    <input id="quantity[${index}]" name="quantity[${index}]" type="number"
                                                        class="form-control @error('quantity[${index}]')
                                                is-invalid
                                            @enderror"
                                                        value="{{ old('quantity[${index}]') ?? ($data->quantity ?? null) }}">
                                                    @error('quantity[${index}]')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label>Harga Beli</label>
                                                    <input id="price_buy[${index}]" name="price_buy[${index}]" type="text"
                                                        class="form-control formatRupiah @error('price_buy[${index}]')
                                                is-invalid
                                            @enderror"
                                                        value="{{ old('price_buy[${index}]') ?? ($data->price_buy ?? null) }}">
                                                    @error('price_buy[${index}]')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label>Harga Jual Terbaru</label>
                                                    <input id="price_sell[${index}]" name="price_sell[${index}]" type="text"
                                                        class="form-control formatRupiah @error('price_sell[${index}]')
                                                is-invalid
                                            @enderror"
                                                        value="{{ old('price_sell[${index}]') ?? ($data->price_sell ?? null) }}">
                                                    @error('price_sell[${index}]')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-6 col-12" style="margin-top: 29px">
                                                <button type="button" id="remove-dynamic-add"
                                                    class="btn btn-danger">Delete</button>
                                            </div>
                                        </div>`)
            $('.select').select2()
        })
        $(document).on('click', '#remove-dynamic-add', function() {
            $(this).parents('.item-dynamic').remove()
        })
    </script>
@endsection
