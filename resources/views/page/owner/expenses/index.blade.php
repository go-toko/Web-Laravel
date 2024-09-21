<?php $page = 'menus'; ?>
@extends('layout.mainlayout')

@section('title', 'Daftar Pengeluaran')

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
                    <a href="{{ route('owner.pengeluaran.pengeluaran.add') }}" class="btn btn-added">
                        <img src="{{ URL::asset('assets/img/icons/plus.svg') }}" class="me-1" alt="img">Tambah
                        Pengeluaran
                    </a>
                </div>
            </div>

            {{-- Body Start --}}
            <div class="row">
                <div class="col-sm-12">
                    <section class="comp-section">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-lg-3 col-md-3">
                                        <label for="">Tanggal Pelaksanaan Pengeluaran</label>
                                        <div class="form-group mt-1" id="startDateField">
                                            <div class="input-groupicon">
                                                <input id="startDate" name="startDate" type="text"
                                                    placeholder="Pilih Tanggal Awal"
                                                    class="datetimepicker form-control @error('startDate') is-invalid @enderror"
                                                    value="{{ old('startDate') ?? (request()->get('startDate') ?? null) }}"
                                                    required>
                                                <div class="addonset">
                                                    <img src="{{ URL::asset('assets/img/icons/calendars.svg') }}"
                                                        alt="img" />
                                                </div>
                                                @error('startDate')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3 col-md-3">
                                        <label for=""></label>
                                        <div class="form-group mt-1">
                                            <div class="input-groupicon">
                                                <input id="endDate" name="endDate" type="text"
                                                    placeholder="Pilih Tanggal Akhir"
                                                    class="datetimepicker form-control @error('endDate') is-invalid @enderror"
                                                    value="{{ old('endDate') ?? (request()->get('endDate') ?? null) }}">
                                                <div class="addonset">
                                                    <img src="{{ URL::asset('assets/img/icons/calendars.svg') }}"
                                                        alt="img" />
                                                </div>
                                                @error('endDate')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3 col-md-3">
                                        <label for=""></label>
                                        <div class="form-group d-flex align-items-center gap-3 mt-1">
                                            <a class="btn btn-filters" id="filter"><img
                                                    src="{{ URL::asset('assets/img/icons/search-whites.svg') }}"
                                                    alt="img" data-bs-toggle="tooltip" title="Filter"></a>
                                            <a class="btn btn-filters" id="resetFilter"><i class="fa fa-undo"
                                                    data-bs-toggle="tooltip" title="Reset Filter"></i></a>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3 col-md-3">
                                        <label for=""></label>
                                        <div class="form-group d-flex align-items-center gap-3 mt-3">
                                            <a class="ms-auto" data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="PDF" id="reportPdf"><img
                                                    src="{{ URL::asset('assets/img/icons/pdf.svg') }}" alt="img"></a>
                                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="Excel"
                                                id="reportExcel"><img src="{{ URL::asset('assets/img/icons/excel.svg') }}"
                                                    alt="img"></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table datanew">
                                        <thead>
                                            <tr>
                                                <th class="col-2">Pengeluaran Untuk</th>
                                                <th class="col-3">Deskripsi</th>
                                                <th class="col-2">Kategori</th>
                                                <th class="col-1">Jumlah</th>
                                                <th class="col-1">Status</th>
                                                <th class="col-2">Tanggal Pelaksanaan</th>
                                                <th class="col-1">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($expenses as $expense)
                                                <tr>
                                                    <td>
                                                        {{ $expense->name }}
                                                    </td>
                                                    <td>{{ $expense->description }}</td>
                                                    <td>{{ Str::title($expense->category->name) }}</td>
                                                    {{-- DONE: Implement amount format for Rupiah --}}
                                                    <td>{{ 'Rp' . number_format($expense->amount) }}</td>
                                                    @php
                                                        $bg = ['bg-lightyellow', 'bg-lightgreen', 'bg-lightred'];
                                                    @endphp
                                                    <td><span
                                                            class="badges {{ in_array($expense->status, $status) ? $bg[array_search($expense->status, $status)] : '' }}">{{ $expense->status }}</span>
                                                    </td>
                                                    <td>{{ Carbon\Carbon::create($expense->date)->translatedFormat('d F Y') }}
                                                    </td>
                                                    <td>
                                                        <a class="me-1"
                                                            href="{{ route('owner.pengeluaran.pengeluaran.detail', ['id' => Crypt::encrypt($expense->id)]) }}">
                                                            <img src="{{ URL::asset('assets/img/icons/eye.svg') }}"
                                                                alt="eye">
                                                        </a>
                                                        @if ($expense->status != 'SELESAI')
                                                            @if ($expense->status != 'BATAL')
                                                                <a class="me-1"
                                                                    href="{{ route('owner.pengeluaran.pengeluaran.edit', ['id' => Crypt::encrypt($expense->id)]) }}">
                                                                    <img src="{{ URL::asset('assets/img/icons/edit.svg') }}"
                                                                        alt="img" />
                                                                </a>
                                                            @endif
                                                            <a class="me-1" id="confirm-delete"
                                                                data-action="{{ route('owner.pengeluaran.pengeluaran.delete', ['id' => Crypt::encrypt($expense->id)]) }}">
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
                                <div class="row mt-1">
                                    <div class="col-3">Total Seluruh Pengeluaran :
                                        Rp{{ number_format($expenses->sum('amount'), 0, ',', '.') }}</div>
                                    @php
                                        $totalProses = $expenses->map(function ($data) {
                                            if ($data->status == 'PROSES') {
                                                return $data;
                                            }
                                        });
                                        $totalBatal = $expenses->map(function ($data) {
                                            if ($data->status == 'BATAL') {
                                                return $data;
                                            }
                                        });
                                        $totalSelesai = $expenses->map(function ($data) {
                                            if ($data->status == 'SELESAI') {
                                                return $data;
                                            }
                                        });
                                    @endphp
                                    <div class="col-3">Total Pengeluaran Diproses :
                                        Rp{{ number_format($totalProses->sum('amount'), 0, ',', '.') }}</div>
                                    <div class="col-3">Total Pengeluaran Batal :
                                        Rp{{ number_format($totalBatal->sum('amount'), 0, ',', '.') }}</div>
                                    <div class="col-3">Total Pengeluaran Selesai :
                                        Rp{{ number_format($totalSelesai->sum('amount'), 0, ',', '.') }}</div>
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
            if (!$('#startDate').val() || $('#startDate').val() === '') {
                $('#startDateField').append(
                    `<div class="invalid-feedback" style="display: block">*Harap pilih tanggal awal untuk filter</div>`
                )
                setTimeout(() => {
                    $('.invalid-feedback').remove()
                }, 2000);
                return;
            };
            const currentDate = new Date();
            let dateYear = currentDate.getFullYear();
            let dateMonth = currentDate.getMonth() + 1;
            let dateDay = currentDate.getDate();

            dateMonth = `${dateMonth}`.length === 1 ? `0${dateMonth}` : dateMonth;

            const startDate = $('#startDate').val();
            const endDate = $('#endDate').val() ? $('#endDate').val() : `${dateDay}-${dateMonth}-${dateYear}`;
            window.location.href =
                `{{ route('owner.pengeluaran.pengeluaran.index') }}?startDate=${startDate}&endDate=${endDate}`
        })

        $(document).on('click', '#resetFilter', function(event) {
            if (window.location.href === `{{ route('owner.pengeluaran.pengeluaran.index') }}`) {
                $('#startDateField').append(
                    `<div class="invalid-feedback" style="display: block">*Filter sudah tereset</div>`
                )
                setTimeout(() => {
                    $('.invalid-feedback').remove()
                }, 2000);
                return;
            }
            window.location.href = `{{ route('owner.pengeluaran.pengeluaran.index') }}`
        })

        $(document).on('click', '#reportPdf', function() {
            const currentDate = new Date();
            let dateYear = currentDate.getFullYear();
            let dateMonth = currentDate.getMonth() + 1;
            let dateDay = currentDate.getDate();

            dateMonth = `${dateMonth}`.length === 1 ? `0${dateMonth}` : dateMonth;

            const startDate = $('#startDate').val();
            const endDate = $('#endDate').val() ? $('#endDate').val() : `${dateDay}-${dateMonth}-${dateYear}`;
            const url =
                `{{ route('owner.pengeluaran.pengeluaran.reportPdf') }}?startDate=${startDate}&endDate=${endDate}`
            window.open(url, '_blank')
        })

        $(document).on('click', '#reportExcel', function() {
            const currentDate = new Date();
            let dateYear = currentDate.getFullYear();
            let dateMonth = currentDate.getMonth() + 1;
            let dateDay = currentDate.getDate();

            dateMonth = `${dateMonth}`.length === 1 ? `0${dateMonth}` : dateMonth;

            const startDate = $('#startDate').val();
            const endDate = $('#endDate').val() ? $('#endDate').val() : `${dateDay}-${dateMonth}-${dateYear}`;
            const url =
                `{{ route('owner.pengeluaran.pengeluaran.reportExcel') }}?startDate=${startDate}&endDate=${endDate}`
            window.open(url, '_blank')
        })
    </script>
@endsection
