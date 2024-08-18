<?php $page = 'menus'; ?>
@extends('layout.mainlayout')

@section('title', 'Detail Pengeluaran')

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
                <div class="col-lg-8 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="productdetails">
                                <ul class="product-bar">
                                    <li>
                                        <h4>Toko</h4>
                                        <h6>{{ $expense->shop->name }}</h6>
                                    </li>
                                    <li>
                                        <h4>Pengeluaran Untuk</h4>
                                        <h6>{{ $expense->name }}</h6>
                                    </li>
                                    <li>
                                        <h4>Kategori Pengeluaran</h4>
                                        <h6>{{ $expense->category->name }}</h6>
                                    </li>
                                    <li>
                                        <h4>Jumlah Pengeluaran</h4>
                                        <h6>{{ 'Rp' . number_format($expense->amount, 0, ',', '.') }}</h6>
                                    </li>
                                    <li>
                                        <h4>Tanggal Pelaksanaan</h4>
                                        <h6>{{ Carbon\Carbon::createFromFormat('Y-m-d', $expense->date)->translatedFormat('d F Y') }}
                                        </h6>
                                    </li>
                                    <li>
                                        <h4>Status</h4>
                                        @php
                                            $bg = ['bg-lightyellow', 'bg-lightgreen', 'bg-lightred'];
                                        @endphp
                                        <h6><span
                                                class="badges {{ in_array($expense->status, $status) ? $bg[array_search($expense->status, $status)] : '' }}">{{ $expense->status }}</span>
                                        </h6>
                                    </li>
                                    <li>
                                        <h4>Deskripsi</h4>
                                        <h6>{{ $expense->description ?? '-' }}</h6>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <label class="mb-2">Nota Pengeluaran</label>
                            <div class="slider-product-details">
                                <div class="owl-carousel owl-theme product-slide">
                                    <div class="slider-product">
                                        @if ($expense->image_nota && $expense->image_nota != 'noimage.png')
                                            <img src="{{ URL::asset('images/nota/' . $expense->image_nota) }}"
                                                alt="img">
                                            <h4>{{ $expense->image_nota ?? 'noimage.png' }}</h4>
                                        @else
                                            <img src="{{ URL::asset('images/noimage.png') }}" alt="img">
                                            <h4>{{ $expense->image_nota ?? 'Belum ada nota' }}</h4>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 ms-3">
                    @if ($expense->status == 'PROSES')
                        <a class="btn btn-success btn-md" id="selesaikan"
                            data-action="{{ route('owner.pengeluaran.pengeluaran.updateStatus', ['id' => Crypt::encrypt($expense->id)]) }}">Selesaikan</a>
                        <a class="btn btn-danger btn-md" id="batalkan"
                            data-action="{{ route('owner.pengeluaran.pengeluaran.updateStatus', ['id' => Crypt::encrypt($expense->id)]) }}">Batalkan</a>
                    @endif
                    <a href="{{ route('owner.pengeluaran.pengeluaran.index') }}"
                        class="btn btn-secondary btn-md">Kembali</a>
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
        $(document).on('click', '#selesaikan', function() {
            const url = $(this).data('action');
            const data = {
                status: 'SELESAI'
            }
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "Kamu akan menyelesaikan pengeluaran. Pengeluaran tidak bisa diedit atau dihapus setelah ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data,
                        type: 'PATCH',
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
                                text: 'Ada sesuatu yang salah. Coba lagi!!',
                                icon: 'error',
                                confirmButtonColor: '#dc3545'
                            })
                        }
                    });
                }
            });
        })

        $(document).on('click', '#batalkan', function() {
            const url = $(this).data('action');
            const data = {
                status: 'BATAL'
            }
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "Kamu akan membatalkan pengeluaran!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data,
                        type: 'PATCH',
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
                                text: 'Ada sesuatu yang salah. Coba lagi!!',
                                icon: 'error',
                                confirmButtonColor: '#dc3545'
                            })
                        }
                    });
                }
            });
        })
    </script>
@endsection
