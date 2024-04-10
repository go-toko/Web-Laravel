<?php $page = 'menus'; ?>
@extends('layout.mainlayout')

@section('title', 'Detail Penjualan')

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
                            <li class="breadcrumb-item"><a href="{{ url('owner/penjualan/penjualan') }}">Penjualan</a>
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
                                        <p>{{ Str::headline($restock->shop->name) }}</p>
                                        <p>{{ $restock->shop->user->email }}</p>
                                        <p>{{ $restock->shop->user->userProfile->phone }}</p>
                                        <p>{{ Str::title($restock->shop?->address ? $restock->shop->address . ', ' . $restock->shop->village . ', ' . $restock->shop->district . ', ' . $restock->shop->regency . ', ' . $restock->shop->province : $restock->shop->village . ', ' . $restock->shop->district . ', ' . $restock->shop->regency . ', ' . $restock->shop->province) }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Product Section --}}
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="col-3">Nama Product</th>
                                                <th class="col-3 text-end">Jumlah</th>
                                                <th class="col-3 text-end">Harga Satuan</th>
                                                <th class="col-3 text-end">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($restock->detail as $detail)
                                                <tr>
                                                    <td>
                                                        {{ Str::headline($detail->product->name) }}
                                                    </td>
                                                    <td class="text-end">{{ $detail->quantity }}
                                                        {{ Str::lower($detail->product->unit) }}
                                                    </td>
                                                    <td class="formatRupiah text-end">{{ $detail->price_buy }}</td>
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
                                        <a href="{{ route('owner.penjualan.penjualan.index') }}"
                                            class="btn btn-cancel">Kembali</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="table-responsive">
                            <table class="table datanew">
                                <thead>
                                    <tr>
                                        <th class="col-1">Tanggal</th>
                                        <th class="col-2">Nama Pelanggan</th>
                                        <th class="col-1">Total</th>
                                        <th class="col-1">Jumlah Bayar</th>
                                        <th class="col-1">Kembalian</th>
                                        <th class="col-1">Metode Pembayaran</th>
                                        <th class="col-1">Status Pembayaran</th>
                                        <th class="col-2">Kasir</th>
                                        <th class="col-1">Status</th>
                                        <th class="col-1">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sales as $sale)
                                        <tr>
                                            <td>{{ $sale->date }}</td>
                                            <td>
                                                {{ Str::headline($sale->customer_name) }}
                                            </td>
                                            <td class="formatRupiah">{{ $sale->total }}</td>
                                            <td class="formatRupiah">{{ $sale->paid }}</td>
                                            <td class="formatRupiah">{{ $sale->change }}</td>
                                            <td>{{ $sale->payment_method }}</td>
                                            <td><span
                                                    class="badges {{ $sale->payment_status == 'lunas' ? 'bg-lightgreen' : 'bg-lightred' }}">{{ Str::headline($sale->payment_status) }}</span>
                                            </td>
                                            <td>{{ Str::title($sale->cashier->userCashierProfile->name) }}</td>
                                            <td><span
                                                    class="badges @if ($sale->status == 'selesai') bg-lightgreen @elseif($sale->status == 'tertunda') bg-lightyellow @elseif($sale->status == 'batal') bg-lightred @endif">{{ Str::headline($sale->status) }}</span>
                                            </td>
                                            <td>
                                                <a class="me-1 detail-cashier" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal"
                                                    data-url="{{ route('owner.orang.kasir.getCashierByUsername', ['username' => $cashier->username]) }}">
                                                    <img src="{{ URL::asset('assets/img/icons/eye.svg') }}" alt="eye">
                                                </a>
                                                <a class="me-3"
                                                    href="{{ route('owner.penjualan.penjualan.edit', ['id' => Crypt::encrypt($sale->id)]) }}">
                                                    <img src="{{ URL::asset('assets/img/icons/edit.svg') }}"
                                                        alt="img" />
                                                </a>
                                                <a class="me-3" id="confirm-delete"
                                                    data-action="{{ route('owner.penjualan.penjualan.delete', ['id' => Crypt::encrypt($sale->id)]) }}">
                                                    <img src="{{ URL::asset('assets/img/icons/delete.svg') }}"
                                                        alt="img" />
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> --}}
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
    </script>
@endsection
