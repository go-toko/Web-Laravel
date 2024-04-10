<?php $page = 'menus'; ?>
@extends('layout.mainlayout')

@section('title', 'Daftar Toko')

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
                    <a href="{{ route('owner.pengaturan.daftar-toko.add') }}" class="btn btn-added">
                        <img src="{{ URL::asset('assets/img/icons/plus.svg') }}" class="me-1" alt="img">Tambah Toko
                    </a>
                </div>
            </div>

            {{-- Body Start --}}
            <div class="row">
                <div class="col-sm-12 my-5">
                    <section class="comp-section">
                        <div class="table-responsive">
                            <table class="table datanew">
                                <thead>
                                    <tr>
                                        <th class="col-2">Nama</th>
                                        <th class="col-2">Deskripsi</th>
                                        <th class="col-5">Alamat</th>
                                        <th class="col-1">Saldo</th>
                                        <th class="col-1">Status</th>
                                        <th class="col-1">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stores as $store)
                                        <tr>
                                            <td>{{ Str::headline($store->name) }}</td>
                                            <td>{{ $store->description }}</td>
                                            <td>
                                                {{ $store?->address ? $store->address . ', ' . $store->village . ', ' . $store->district . ', ' . $store->regency . ', ' . $store->province : $store->village . ', ' . $store->district . ', ' . $store->regency . ', ' . $store->province }}
                                            </td>
                                            <td>{{ 'Rp' . number_format($store->balance, 0, ',', '.') }}</td>
                                            <td>{{ $store->isActive }}</td>
                                            <td>
                                                <a class="me-3"
                                                    href="{{ route('owner.pengaturan.daftar-toko.edit', ['id' => Crypt::encrypt($store->id)]) }}">
                                                    <img src="{{ URL::asset('assets/img/icons/edit.svg') }}"
                                                        alt="img" />
                                                </a>
                                                <a class="me-3" id="confirm-delete"
                                                    data-action="{{ route('owner.pengaturan.daftar-toko.delete', ['id' => Crypt::encrypt($store->id)]) }}">
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
                {{-- @if (count($deletedStores) > 0)
                    <div class="col-sm-12">
                        <div>
                            <h3 class="text-center">Deleted Store</h3>
                        </div>
                        <section class="comp-section">
                            <div class="table-responsive">
                                <table class="table datanew">
                                    <thead>
                                        <tr>
                                            <th class="col-0">
                                                <label class="checkboxs">
                                                    <input type="checkbox" id="select-all" />
                                                    <span class="checkmarks"></span>
                                                </label>
                                            </th>
                                            <th class="col-2">Nama</th>
                                            <th class="col-2">Deskripsi</th>
                                            <th class="col-5">Alamat</th>
                                            <th class="col-1">Status</th>
                                            <th class="col-1">Saldo</th>
                                            <th class="col-1">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($deletedStores as $store)
                                            @dump()
                                            <tr>
                                                <td>
                                                    <label class="checkboxs">
                                                        <input type="checkbox" />
                                                        <span class="checkmarks"></span>
                                                    </label>
                                                </td>
                                                <td>{{ Str::headline($store->name) }}</td>
                                                <td>{{ $store->description }}</td>
                                                <td>
                                                    {{ $store?->address ? $store->address . ', ' . $store->village . ', ' . $store->district . ', ' . $store->regency . ', ' . $store->province : $store->village . ', ' . $store->district . ', ' . $store->regency . ', ' . $store->province }}
                                                </td>
                                                <td>{{ $store->isActive }}</td>
                                                <td>{{ $store->balance }}</td>
                                                <td>
                                                    <a class="me-3"
                                                        href="{{ route('owner.pengaturan.daftar-toko.edit', ['id' => Crypt::encrypt($store->id)]) }}">
                                                        <img src="{{ URL::asset('assets/img/icons/edit.svg') }}"
                                                            alt="img" />
                                                    </a>
                                                    <a class="me-3" id="confirm-delete"
                                                        data-action="{{ route('owner.pengaturan.daftar-toko.delete', ['id' => Crypt::encrypt($store->id)]) }}">
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
                @endif --}}
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
            $('.storeBalance').each(function() {
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
                        type: 'GET',
                        success: function(data) {
                            Swal.fire({
                                title: 'Deleted!',
                                text: 'Your file has been deleted.',
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
    </script>
@endsection
