<?php $page = 'menus'; ?>
@extends('layout.mainlayout')

@section('title', 'Daftar Restock')

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
                    <a href="{{ route('owner.produk.restock.add') }}" class="btn btn-added">
                        <img src="{{ URL::asset('assets/img/icons/plus.svg') }}" class="me-1" alt="img">Tambah
                        Restock
                    </a>
                </div>
            </div>

            {{-- Body Start --}}
            <div class="row">
                <div class="col-sm-12">
                    <section class="comp-section">
                        <div class="table-responsive">
                            <table class="table datanew">
                                <thead>
                                    <tr>
                                        <th class="col-0">No</th>
                                        <th class="col-2">Tanggal</th>
                                        <th class="col-2">Nama Pemasok</th>
                                        <th class="col-2">Total</th>
                                        <th class="col-3">Deskripsi</th>
                                        <th class="col-2">Status</th>
                                        <th class="col-1">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($restock as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ Carbon\Carbon::createFromDate($item->date)->translatedFormat('d F Y') }}
                                            </td>
                                            <td>
                                                {{ $item->supplier->name }}
                                            </td>
                                            <td>{{ 'Rp' . number_format($item->total) }}</td>
                                            <td>{{ $item->description }}</td>
                                            @php
                                                $bg = [
                                                    'bg-lightgrey',
                                                    'bg-lightyellow',
                                                    'bg-lightgreen',
                                                    'bg-lightred',
                                                ];
                                            @endphp
                                            <td><span
                                                    class="badges {{ in_array($item->status, $status) ? $bg[array_search($item->status, $status)] : '' }}">{{ $item->status }}</span>
                                            </td>
                                            <td>
                                                <a class="me-1"
                                                    href="{{ route('owner.produk.restock.detail', ['id' => Crypt::encrypt($item->id)]) }}">
                                                    <img src="{{ URL::asset('assets/img/icons/eye.svg') }}" alt="eye">
                                                </a>
                                                @if ($item->status == 'PROSES')
                                                    <a class="me-1"
                                                        href="{{ route('owner.produk.restock.edit', ['id' => Crypt::encrypt($item->id)]) }}">
                                                        <img src="{{ URL::asset('assets/img/icons/edit.svg') }}"
                                                            alt="img" />
                                                    </a>
                                                @endif
                                                @if ($item->status != 'SELESAI')
                                                    <a class="me-1" id="confirm-delete"
                                                        data-action="{{ route('owner.produk.restock.delete', ['id' => Crypt::encrypt($item->id)]) }}">
                                                        <img src="{{ URL::asset('assets/img/icons/delete.svg') }}"
                                                            alt="img" />
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
        $(document).on('click', '#confirm-delete', function(event) {
            event.preventDefault();
            const url = $(this).data('action');

            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "Stok dalam produkmu akan berkurang!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya!',
                cancelButtonText: 'Cancel'
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
                                text: 'Berhasil menghapus data!',
                                icon: 'success',
                                timer: 1500,
                                showConfirmButton: false
                            });
                            location.reload();
                        },
                        error: function(data) {
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Ada sesuatu yang salah!',
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
