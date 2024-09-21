<?php $page = 'menus'; ?>
@extends('layout.mainlayout')

@section('title', 'Kategori Produk')

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
                    <a href="{{ route('owner.produk.kategori.add') }}" class="btn btn-added">
                        <img src="{{ URL::asset('assets/img/icons/plus.svg') }}" class="me-1" alt="img">Tambah
                        Kategori
                    </a>
                </div>
            </div>
            {{-- Body Start --}}
            <div class="row">
                <div class="col-sm-12">
                    <section class="comp-section">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-end">
                                <div class="form-group d-flex align-items-center gap-3">
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
                                        <th class="col-3">Nama Kategori</th>
                                        <th class="col-5">Deskripsi</th>
                                        <th class="col-1">Status</th>
                                        <th class="col-1">Keterangan</th>
                                        <th class="col-2">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td>
                                                {{ $category->name }}
                                            </td>
                                            <td>{{ $category->description }}</td>
                                            <td><span
                                                    class="badges {{ $category->isActive ? 'bg-lightgreen' : 'bg-lightred' }}">{{ $category->isActive ? 'Aktif' : 'Nonaktif' }}</span>
                                            </td>
                                            <td><span
                                                    class="badges {{ $category->isParent ? 'bg-lightyellow' : 'bg-lightred' }}">{{ $category->isParent ? 'Global' : Session::get('name') }}</span>
                                            </td>
                                            <td>
                                                <a class="me-1"
                                                    href="{{ route('owner.produk.kategori.edit', ['id' => Crypt::encrypt($category->id)]) }}">
                                                    <img src="{{ URL::asset('assets/img/icons/edit.svg') }}"
                                                        alt="img" />
                                                </a>
                                                @if ($category->isActive)
                                                    <a class="me-1" id="confirm-nonaktif"
                                                        data-action="{{ route('owner.produk.kategori.nonaktif', ['id' => Crypt::encrypt($category->id)]) }}">
                                                        <img src="{{ URL::asset('assets/img/icons/delete.svg') }}"
                                                            alt="img" />
                                                    </a>
                                                @endif
                                                @if (!$category->isActive)
                                                    <a class="me-1" id="restore-nonaktif"
                                                        data-action="{{ route('owner.produk.kategori.restore', ['id' => Crypt::encrypt($category->id)]) }}">
                                                        <img src="{{ URL::asset('assets/img/icons/return1.svg') }}"
                                                            alt="img" height="18" width="20" />
                                                    </a>
                                                @endif
                                                <a class="me-1" id="confirm-delete"
                                                    data-action="{{ route('owner.produk.kategori.destroy', ['id' => Crypt::encrypt($category->id)]) }}">
                                                    <img src="{{ URL::asset('assets/img/icons/close-circle1.svg') }}"
                                                        alt="img" height="18" width="20"
                                                        title="Hapus Permanen" />
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
        $(document).on('click', '#confirm-nonaktif', function(event) {
            event.preventDefault();
            const url = $(this).data('action');

            Swal.fire({
                title: 'Apa kamu yakin ?',
                text: "Kamu akan menonaktifkan kategori!",
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
                        type: 'DELETE',
                        success: function(data) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Berhasil.',
                                icon: 'success',
                                timer: 1500,
                                showConfirmButton: false
                            });
                            location.reload();
                        },
                        error: function(data) {
                            Swal.fire({
                                title: 'Oops...',
                                text: 'Something went wrong!',
                                icon: 'error',
                                confirmButtonColor: '#dc3545'
                            })
                        }
                    });
                }
            });
        });

        $(document).on('click', '#reportPdf', function() {
            const url = `{{ route('owner.produk.kategori.reportPdf') }}`
            window.open(url, '_blank')
        })
        $(document).on('click', '#reportExcel', function() {
            const url = `{{ route('owner.produk.kategori.reportExcel') }}`
            window.open(url, '_blank')
        })

        $(document).on('click', '#restore-nonaktif', function(event) {
            event.preventDefault();
            const url = $(this).data('action');

            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "Kamu akan mengaktifkan kategori!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#2de000',
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
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Berhasil mengaktifkan kategori.',
                                icon: 'success',
                                timer: 1500,
                                showConfirmButton: false
                            });
                            location.reload();
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
        });
        $(document).on('click', '#confirm-delete', function(event) {
            event.preventDefault();
            const url = $(this).data('action');

            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "Kamu akan menghapus kategori secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#2de000',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya!'
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
        });
    </script>
@endsection
