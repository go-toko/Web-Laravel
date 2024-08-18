<?php $page = 'menus'; ?>
@extends('layout.mainlayout')

@section('title', 'Daftar Produk')

@section('forhead')
    {{-- Toastr Style --}}
    <link rel="stylesheet" href="{{ url('assets/plugins/toastr/toatr.css') }}">
    <link rel="stylesheet" href="{{ url('assets/plugins/icons/feather/feather.css') }}">
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
                                            <option value="{{ $item->id }}"
                                                {{ request()->get('category') == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}</option>
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
                                                {{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-lg-3 col-md-3">
                                <div class="form-group d-flex align-items-center gap-3">
                                    <a class="btn btn-filters" id="filter"><img
                                            src="{{ URL::asset('assets/img/icons/search-whites.svg') }}" alt="img"
                                            data-bs-toggle="tooltip" title="Filter"></a>
                                    <a class="btn btn-filters" id="resetFilter"><i class="fa fa-undo"
                                            data-bs-toggle="tooltip" title="Reset Filter"></i></a>
                                </div>
                            </div>
                            <div class="col-12 col-lg-3 col-md-3">
                                <div class="d-flex align-items-center gap-3 mt-2">
                                    <a class="ms-auto" data-bs-toggle="tooltip" data-bs-placement="top" title="PDF"
                                        id="reportPdf"><img src="{{ URL::asset('assets/img/icons/pdf.svg') }}"
                                            alt="img"></a>
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
                                        <th class="col-2">Deskripsi</th>
                                        <th class="col-1">Kategori</th>
                                        <th class="col-1">Merek</th>
                                        <th class="col-1">SKU</th>
                                        <th class="col-1">Jumlah</th>
                                        <th class="col-1">Satuan</th>
                                        <th class="col-1">Harga Beli</th>
                                        <th class="col-1">Harga Jual</th>
                                        <th class="col-0">Diskon</th>
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
                                                            alt="{{ $product->name }}" />
                                                    @elseif ($product->images == 'noimage.png')
                                                        <img src="{{ URL::asset('images/' . $product->images) }}"
                                                            alt="{{ $product->name }}" />
                                                    @endif
                                                </a>
                                                {{ $product->name }}
                                            </td>
                                            <td>{{ $product->description }}</td>
                                            <td>{{ $product->category->name }}</td>
                                            <td>{{ $product->brand->name }}</td>
                                            <td>{{ $product->sku }}</td>
                                            <td>{{ $product->quantity }}</td>
                                            <td>{{ $product->unit }}</td>
                                            <td>{{ 'Rp' . number_format($product->price_buy, 0, ',', '.') }}</td>
                                            <td>{{ 'Rp' . number_format($product->price_sell, 0, ',', '.') }}
                                                @php
                                                    $titleMessage = 'Harga jual lebih kecil dari pada harga beli';
                                                    $colorMessage = 'text-danger';
                                                    if ($product->price_sell == $product->price_buy) {
                                                        $titleMessage = 'Harga jual sama dengan harga beli';
                                                        $colorMessage = 'text-warning';
                                                    }
                                                @endphp
                                                @if ($product->price_sell < $product->price_buy || $product->price_sell == $product->price_buy)
                                                    <i class="fa fa-exclamation-triangle {{ $colorMessage }}"
                                                        data-bs-toggle="tooltip" title="{{ $titleMessage }}"></i>
                                                @endif
                                            </td>
                                            <td>{{ 'Rp' . number_format($product->discount, 0, ',', '.') }}</td>
                                            <td class="mt-0">
                                                <a class="me-1" title="Ubah produk"
                                                    href="{{ route('owner.produk.daftar-produk.edit', ['id' => Crypt::encrypt($product->id)]) }}">
                                                    <i class="fa fa-edit" data-bs-toggle="tooltip" title="Ubah Produk"></i>
                                                </a>
                                                <a class="me-1 diskonField" data-bs-toggle="modal"
                                                    data-bs-target="#modalUbahDiskon"
                                                    data-action-get="{{ route('owner.produk.daftar-produk.getData', ['id' => Crypt::encrypt($product->id)]) }}"
                                                    data-action-update="{{ route('owner.produk.daftar-produk.updateDiskon', ['id' => Crypt::encrypt($product->id)]) }}">
                                                    <i class="fa fa-tag" data-bs-toggle="tooltip"
                                                        title="Beri Diskon"></i>
                                                </a>
                                                @if ($product->isActive)
                                                    <a class="me-1" id="confirm-delete" title="Delete produk"
                                                        data-action="{{ route('owner.produk.daftar-produk.delete', ['id' => Crypt::encrypt($product->id)]) }}">
                                                        <i class="fa fa-trash" data-bs-toggle="tooltip"
                                                            title="Nonaktifkan Produk"></i>
                                                    </a>
                                                @elseif (!$product->isActive)
                                                    <a class="me-1" id="restore-delete" title="Delete produk"
                                                        data-action="{{ route('owner.produk.daftar-produk.restore', ['id' => Crypt::encrypt($product->id)]) }}">
                                                        <i class="fa fa-undo" data-bs-toggle="tooltip"
                                                            title="Aktifkan Produk"></i>
                                                    </a>
                                                @endif
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

    <!-- Modal -->
    <div class="modal fade" id="modalUbahDiskon" tabindex="-1" aria-labelledby="modalUbahDiskonLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleProduk">Produk ...</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="diskonInput">Harga Diskon (Potongan Harga)</label>
                    <input type="number" value="" class="form-control" id="diskonInput"
                        placeholder="Masukkan jumlah diskon">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveDiskon">Save changes</button>
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
                title: 'Apakah kamu yakin?',
                text: "Kamu akan menonaktifkan produk!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, nonaktifkan!'
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
                                title: 'Berhasil!',
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
    <script>
        // select DOM
        const diskonInput = $('#diskonInput');
        const titleProduk = $('#titleProduk');
        const saveDiskon = $('#saveDiskon');

        $(document).on('click', '.diskonField', async function() {
            const actionGetData = $(this).data('actionGet');
            let produk = null;
            let urlUpdate = $(this).data('actionUpdate')
            await $.ajax({
                url: actionGetData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                success: function(data) {
                    produk = data;
                },
                error: function(error) {
                    console.log(error);
                }
            })
            resetInfoProduk();
            showInfoProduk(produk, urlUpdate)
        })

        $(document).on('click', '#saveDiskon', async function() {
            const url = saveDiskon.attr('data-action-update')
            const newDiskon = diskonInput.val();
            await $.ajax({
                url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    jumlahDiskon: newDiskon
                },
                type: 'PUT',
                success: function(data) {
                    location.reload();
                },
                error: function(error) {
                    console.log(error);
                }
            })
        })

        function resetInfoProduk() {
            diskonInput.prop('value', 0);
            titleProduk.text('Produk ...');
            saveDiskon.attr('data-action-update', null)
        }

        function showInfoProduk(produk, urlUpdate) {
            diskonInput.prop('value', produk.discount)
            titleProduk.text(`Produk ${produk.name}`)
            saveDiskon.attr('data-action-update', urlUpdate)
        }
    </script>

    <script>
        $(document).on('click', '#restore-delete', function(event) {
            event.preventDefault();
            const url = $(this).data('action');

            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "Kamu akan mengaktifkan kembali produk!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#2de000',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, aktifkan!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'PUT',
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
    </script>
@endsection
