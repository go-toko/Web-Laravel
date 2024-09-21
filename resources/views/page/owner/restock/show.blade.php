<?php $page = 'menus'; ?>
@extends('layout.mainlayout')

@section('title', 'Detail Restock')

@section('forhead')
    {{-- Toastr Style --}}
    <link rel="stylesheet" href="{{ url('assets/plugins/toastr/toatr.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        p {
            margin-bottom: 3px;
        }
    </style>
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
                            <li class="breadcrumb-item"><a href="{{ url('owner/produk/restock') }}">Restock Produk</a>
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
                        <div class="card">
                            <div class="card-body">
                                {{-- Header Section --}}
                                <div class="card-sales-split">
                                    <h2>Restock Detail : {{ $restock->id }}</h2>
                                </div>
                                <div class="row my-2" style="padding-left: 5px">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                                        <h6 style="color: #7367F0" class="my-1">Informasi Supplier</h6>
                                        <p>{{ $restock->supplier->name }}</p>
                                        <p>{{ $restock->supplier->phone }}</p>
                                        <p>{{ $restock->supplier->address }}</p>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                                        <h6 style="color: #7367F0" class="my-1">Informasi Toko</h6>
                                        <p>{{ $restock->shop->name }}</p>
                                        <p>{{ $restock->shop->user->email }}</p>
                                        <p>{{ $restock->shop->user->userProfile->phone }}</p>
                                        <p>{{ Str::title($restock->shop?->address ? $restock->shop->address . ', ' . $restock->shop->village . ', ' . $restock->shop->district . ', ' . $restock->shop->regency . ', ' . $restock->shop->province : $restock->shop->village . ', ' . $restock->shop->district . ', ' . $restock->shop->regency . ', ' . $restock->shop->province) }}
                                        </p>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                                        <h6 style="color: #7367F0" class="my-1">Informasi Restock</h6>
                                        <div class="d-flex justify-content-between">
                                            @php
                                                $bg = [
                                                    'bg-lightgrey',
                                                    'bg-lightyellow',
                                                    'bg-lightgreen',
                                                    'bg-lightred',
                                                ];
                                            @endphp
                                            <p>Status Restock</p>
                                            <p><span
                                                    class="badges {{ in_array($restock->status, $status) ? $bg[array_search($restock->status, $status)] : '' }}">{{ $restock->status }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Product Section --}}
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="col-3">Nama Product</th>
                                                <th class="col-2 text-end">Jumlah</th>
                                                <th class="col-2 text-end">Harga Satuan</th>
                                                <th class="col-2 text-end">Harga Jual Terbaru</th>
                                                <th class="col-3 text-end">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($restock->detail as $detail)
                                                <tr>
                                                    <td>
                                                        {{ $detail->product->name }}
                                                    </td>
                                                    <td class="text-end">{{ $detail->quantity }}
                                                        {{ Str::lower($detail->product->unit) }}
                                                    </td>
                                                    <td class="formatRupiah text-end">{{ $detail->price_buy }}</td>
                                                    <td class="formatRupiah text-end">{{ $detail->price_sell }}</td>
                                                    <td class="formatRupiah text-end">
                                                        {{ $detail->price_buy * $detail->quantity }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                {{-- Footer Section --}}
                                <div class="row my-3">
                                    <div class="offset-lg-6 col-lg-6 ">
                                        <div class="total-order w-100 max-widthauto m-auto mb-4">
                                            <ul>
                                                <li class="total">
                                                    <h4>Total</h4>
                                                    <h5 class="formatRupiah">{{ $restock->total }}</h5>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        @if ($restock->status == 'PROSES')
                                            <a class="btn btn-primary" id="validasi-data"
                                                data-action="{{ route('owner.produk.restock.validasiData', ['id' => Crypt::encrypt($restock->id)]) }}">Validasi</a>
                                        @endif
                                        @if ($restock->status == 'SIAP DITAMBAHKAN')
                                            <a class="btn btn-success" id="tambahkan"
                                                data-action="{{ route('owner.produk.restock.tambahkanStok', ['id' => Crypt::encrypt($restock->id)]) }}">Tambahkan
                                                Stok</a>
                                        @endif
                                        @if ($restock->status == 'PROSES')
                                            <a href="{{ route('owner.produk.restock.edit', ['id' => Crypt::encrypt($restock->id)]) }}"
                                                class="btn btn-info">Edit</a>
                                        @endif
                                        @if ($restock->status != 'BATAL' && $restock->status != 'SELESAI')
                                            <a class="btn btn-danger" id="batalkan"
                                                data-action="{{ route('owner.produk.restock.batalkan', ['id' => Crypt::encrypt($restock->id)]) }}">Batalkan</a>
                                        @endif
                                        <a href="{{ route('owner.produk.restock.index') }}"
                                            class="btn btn-secondary">Kembali</a>
                                    </div>
                                </div>
                            </div>
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
            $('.formatRupiah').each(function() {
                $(this).text(formatRupiah($(this).text(), 'Rp'));
            })
        })

        $(document).on('click', '#validasi-data', function(event) {
            event.preventDefault();
            const url = $(this).data('action');

            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "Kamu akan mengubah status restock dari 'Proses' menjadi 'Siap Ditambahkan' dan tidak bisa diedit lagi",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff9f43',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, ubah!'
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
                                title: data.title,
                                text: data.msg,
                                icon: data.type,
                                timer: 1500,
                                showConfirmButton: false
                            });
                            if (data.type == 'success') location.reload();
                        },
                        error: function(data) {
                            Swal.fire({
                                title: 'Oops...',
                                text: 'Ada sesuatu yang salah',
                                icon: 'error',
                                confirmButtonColor: '#dc3545'
                            })
                        }
                    });
                }
            });
        });

        $(document).on('click', '#tambahkan', function(event) {
            event.preventDefault();
            const url = $(this).data('action');

            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "Kamu akan menyelesaikan restock ini. Harga beli, harga jual dan stok akan disesuaikan",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff9f43',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'PUT',
                        success: function(data) {
                            console.log(data);
                            Swal.fire({
                                title: data.title,
                                text: data.msg,
                                icon: data.type,
                                timer: 1500,
                                showConfirmButton: false
                            });
                            if (data.type == 'success') location.reload();
                        },
                        error: function(data) {
                            Swal.fire({
                                title: 'Oops...',
                                text: 'Ada sesuatu yang salah',
                                icon: 'error',
                                confirmButtonColor: '#dc3545'
                            })
                        }
                    });
                }
            });
        });

        $(document).on('click', '#batalkan', function(event) {
            event.preventDefault();
            const url = $(this).data('action');

            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "Kamu akan menyelesaikan restock ini. Harga beli, harga jual dan stok akan disesuaikan",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff9f43',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'PUT',
                        success: function(data) {
                            console.log(data);
                            Swal.fire({
                                title: data.title,
                                text: data.msg,
                                icon: data.type,
                                timer: 1500,
                                showConfirmButton: false
                            });
                            if (data.type == 'success') location.reload();
                        },
                        error: function(data) {
                            Swal.fire({
                                title: 'Oops...',
                                text: 'Ada sesuatu yang salah',
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
