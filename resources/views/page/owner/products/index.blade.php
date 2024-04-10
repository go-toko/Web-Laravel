<?php $page = 'menus'; ?>
@extends('layout.mainlayout')

@section('title', 'Daftar Produk')

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
                            <li class="breadcrumb-item active"> @yield('title') </li>
                        </ul>
                    </h6>
                </div>
                <div class="page-btn">
                    <a href="{{ route('owner.produk.daftar-produk.add') }}" class="btn btn-added">
                        <img src="{{ URL::asset('assets/img/icons/plus.svg') }}" class="me-1" alt="img">Tambah Produk
                    </a>
                </div>
            </div>

            {{-- Body Start --}}
            <div class="row">
                <div class="col-sm-12">
                    <section class="comp-section">
                        <div class="row">
                            <div class="col-12 col-lg-3 col-md-3">
                                <div class="form-group" id="categoryField">
                                    <select name="category" id="category"
                                        class="select @error('category') is-invalid @enderror">
                                        <option value="null" selected disabled>Filter Kategori</option>
                                        <option value="all" {{ request()->get('category') == 'all' ? 'selected' : '' }}>
                                            Semua Kategori</option>
                                        @foreach ($categories as $item)
                                            <option value="{{ $item->code }}"
                                                {{ request()->get('category') == $item->code ? 'selected' : '' }}>
                                                {{ Str::headline($item->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-lg-3 col-md-3">
                                <div class="form-group" id="brandField">
                                    <select name="brand" id="brand"
                                        class="select @error('brand') is-invalid @enderror">
                                        <option value="null" selected disabled>Filter Merek</option>
                                        <option value="all" {{ request()->get('brand') == 'all' ? 'selected' : '' }}>
                                            Semua Merek</option>
                                        @foreach ($brands as $item)
                                            <option value="{{ $item->id }}"
                                                {{ request()->get('brand') == $item->id ? 'selected' : '' }}>
                                                {{ Str::headline($item->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-lg-3 col-md-3 offset-lg-3 offset-md-3">
                                <div class="form-group d-flex align-items-center gap-3">
                                    <a class="btn btn-filters ms-auto" id="filter"><img
                                            src="{{ URL::asset('assets/img/icons/search-whites.svg') }}" alt="img"
                                            data-bs-toggle="tooltip" title="Filter"></a>
                                    <a class="btn btn-filters" id="resetFilter"><i class="fa fa-undo"
                                            data-bs-toggle="tooltip" title="Reset Filter"></i></a>
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="PDF" id="reportPdf"><img
                                            src="{{ URL::asset('assets/img/icons/pdf.svg') }}" alt="img"></a>
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="Excel" id="reportExcel"><img
                                            src="{{ URL::asset('assets/img/icons/excel.svg') }}" alt="img"></a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table datanew">
                                <thead>
                                    <tr>
                                        <th class="col-1">Nama</th>
                                        <th class="col-3">Deskripsi</th>
                                        <th class="col-1">Kategori</th>
                                        <th class="col-1">Merek</th>
                                        <th class="col-1">SKU</th>
                                        <th class="col-1">Jumlah</th>
                                        <th class="col-1">Satuan</th>
                                        <th class="col-1">Harga Beli</th>
                                        <th class="col-1">Harga Jual</th>
                                        <th class="col-1">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td class="productimgname">
                                                <a href="javascript:void(0);" class="product-img">
                                                    @if ($product->images != 'noimage.png')
                                                        <img src="{{ URL::asset('images/products/' . $product->images) }}"
                                                            alt="{{ Str::headline($product->name) }}" />
                                                    @elseif ($product->images == 'noimage.png')
                                                        <img src="{{ URL::asset('images/' . $product->images) }}"
                                                            alt="{{ Str::headline($product->name) }}" />
                                                    @endif

                                                </a>
                                                {{ Str::headline($product->name) }}
                                            </td>
                                            <td>{{ $product->description }}</td>
                                            <td>{{ Str::headline($product->category->name) }}</td>
                                            <td>{{ Str::headline($product->brand->name) }}</td>
                                            <td>{{ $product->sku }}</td>
                                            <td>{{ $product->quantity }}</td>
                                            <td>{{ $product->unit }}</td>
                                            <td class="buying_price">{{ $product->price_buy }}</td>
                                            <td class="selling_price">{{ $product->price_sell }}</td>
                                            <td>
                                                <a class="me-3"
                                                    href="{{ route('owner.produk.daftar-produk.edit', ['id' => Crypt::encrypt($product->id)]) }}">
                                                    <img src="{{ URL::asset('assets/img/icons/edit.svg') }}"
                                                        alt="img" />
                                                </a>
                                                <a class="me-3" id="confirm-delete"
                                                    data-action="{{ route('owner.produk.daftar-produk.delete', ['id' => Crypt::encrypt($product->id)]) }}">
                                                    <img src="{{ URL::asset('assets/img/icons/delete.svg') }}"
                                                        alt="img" />
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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

    @if ($type != null)
        <script>
            let type = {!! json_encode($type) !!};
            let msg = {!! json_encode($msg) !!};
            const title = {!! json_encode($title) !!};
            toastr[type](msg, title)
        </script>
    @endif
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
            $('.buying_price').each(function() {
                $(this).text(formatRupiah($(this).text(), 'Rp'))
            })
            $('.selling_price').each(function() {
                $(this).text(formatRupiah($(this).text(), 'Rp'))
            })
        })
    </script>
    <script>
        $(document).on('click', '#confirm-delete', function(event) {
            event.preventDefault();
            const url = $(this).data('action');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'DELETE',
                        success: function(data) {
                            Swal.fire({
                                title: 'Deleted!',
                                text: data.msg,
                                icon: 'success',
                                timer: 1500,
                                showConfirmButton: false
                            });
                            location.reload();
                        },
                        error: function(data) {
                            Swal.fire({
                                title: 'Oops...',
                                text: data.msg,
                                icon: 'error',
                                confirmButtonColor: '#dc3545'
                            })
                        }
                    });
                }
            });
        });

        $(document).on('click', '#filter', function() {
            const filterCategory = $('#category').val() ?? 'all';
            const filterBrand = $('#brand').val() ?? 'all';

            const url =
                `{{ route('owner.produk.daftar-produk.index') }}?category=${filterCategory}&brand=${filterBrand}`
            window.location.href = url;
        })

        $(document).on('click', '#resetFilter', function() {
            if (window.location.href === `{{ route('owner.produk.daftar-produk.index') }}`) {
                $('#categoryField').append(
                    `<div class="invalid-feedback" style="display: block">*Filter sudah tereset</div>`
                )
                setTimeout(() => {
                    $('.invalid-feedback').remove()
                }, 2000);
                return;
            }
            window.location.href = `{{ route('owner.produk.daftar-produk.index') }}`
        })

        $(document).on('click', '#reportPdf', function() {
            const filterCategory = $('#category').val() ?? 'all';
            const filterBrand = $('#brand').val() ?? 'all';

            const url =
                `{{ route('owner.produk.daftar-produk.reportPdf') }}?category=${filterCategory}&brand=${filterBrand}`
            window.open(url, '_blank')
        })
        $(document).on('click', '#reportExcel', function() {
            const filterCategory = $('#category').val() ?? 'all';
            const filterBrand = $('#brand').val() ?? 'all';

            const url =
                `{{ route('owner.produk.daftar-produk.reportExcel') }}?category=${filterCategory}&brand=${filterBrand}`
            window.open(url, '_blank')
        })
    </script>
@endsection
