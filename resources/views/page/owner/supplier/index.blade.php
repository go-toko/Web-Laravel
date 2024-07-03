<?php $page = 'menus'; ?>
@extends('layout.mainlayout')

@section('title', 'Daftar Pemasok')

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
                    <a href="{{ route('owner.orang.pemasok.add') }}" class="btn btn-added">
                        <img src="{{ URL::asset('assets/img/icons/plus.svg') }}" class="me-1" alt="img">Tambah
                        Pemasok
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
                                        <th class="col-0">No</th>
                                        <th class="col-3">Nama Supplier</th>
                                        <th class="col-2">No Telepon</th>
                                        <th class="col-4">Alamat</th>
                                        <th class="col-2">Status</th>
                                        <th class="col-1">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($supplier as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->phone }}</td>
                                            <td>{{ $item->address }}</td>
                                            <td>
                                                <select class="form-control select supplierStatus"
                                                    data-url="{{ route('owner.orang.pemasok.update', ['id' => Crypt::encrypt($item->id)]) }}">
                                                    <option value="1" {{ $item->isActive == true ? 'selected' : '' }}>
                                                        Aktif</option>
                                                    <option value="0"
                                                        {{ $item->isActive == false ? 'selected' : '' }}>Non Aktif</option>
                                                </select>
                                            </td>
                                            <td>
                                                <a class="me-1 detail-supplier" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal"
                                                    data-url="{{ route('owner.orang.pemasok.show', ['id' => Crypt::encrypt($item->id)]) }}">
                                                    <img src="{{ URL::asset('assets/img/icons/eye.svg') }}" alt="eye">
                                                </a>
                                                <a class="me-1"
                                                    href="{{ route('owner.orang.pemasok.edit', ['id' => Crypt::encrypt($item->id)]) }}">
                                                    <img src="{{ URL::asset('assets/img/icons/edit.svg') }}"
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
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Profil Supplier</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4 col-sm-4 col-md-4 offset-xl-1 col-xl-3"><strong>Nama</strong></div>
                        <div class="col-8 col-sm-8 col-md-8 col-xl-7">
                            <p id="supplier-name">Nama Supplier</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 col-sm-4 col-md-4 offset-xl-1 col-xl-3"><strong>Telepon</strong></div>
                        <div class="col-8 col-sm-8 col-md-8 col-xl-7">
                            <p id="supplier-phone">no telepon supplier</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 col-sm-4 col-md-4 offset-xl-1 col-xl-3"><strong>Alamat</strong></div>
                        <div class="col-8 col-sm-8 col-md-8 col-xl-7">
                            <p id="supplier-address">Detail Lengkap Alamat Lorem ipsum, dolor sit amet consectetur
                                adipisicing elit. Recusandae
                                fuga vel esse, incidunt molestiae vitae.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 col-sm-4 col-md-4 offset-xl-1 col-xl-3"><strong>Deskripsi</strong></div>
                        <div class="col-8 col-sm-8 col-md-8 col-xl-7">
                            <p id="supplier-description">Deskripsi</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 col-sm-4 col-md-4 offset-xl-1 col-xl-3"><strong>Status</strong></div>
                        <div class="col-8 col-sm-8 col-md-8 col-xl-7">
                            <div class="badge bg-success" id="supplier-status">Aktif</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 col-sm-4 col-md-4 offset-xl-1 col-xl-3"><strong>Dibuat pada tanggal</strong>
                        </div>
                        <div class="col-8 col-sm-8 col-md-8 col-xl-7">
                            <p id="supplier-created">20 Bulan Tahun</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
        // select the DOM 
        const supplierName = $('#supplier-name');
        const supplierPhone = $('#supplier-phone');
        const supplierDescription = $('#supplier-description');
        const supplierStatus = $('#supplier-status');
        const supplierAddress = $('#supplier-address');
        const supplierCreated = $('#supplier-created');

        const resetDetail = function() {
            supplierName.text('')
            supplierPhone.text('')
            supplierDescription.text('')
            supplierStatus.text('')
            supplierAddress.text('')
            supplierCreated.text('')
        }

        function showDetail(data) {
            resetDetail();

            supplierName.text(data.name)
            supplierPhone.text(data.phone)
            supplierAddress.text(data.address)
            supplierDescription.text(data.description ?? 'Belum di isi')
            const createdAt = new Date(data.created_at);
            supplierCreated.text(`${createdAt.toLocaleString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'})}`)

            const status = ['Non Aktif', 'Aktif']
            const statusClass = ['bg-danger', 'bg-success']
            supplierStatus.text(status[data.isActive]);
            supplierStatus.removeClass('bg-success bg-warning bg-danger');
            supplierStatus.addClass(statusClass[data.isActive])
        }

        $(document).on('click', '.detail-supplier', function(e) {
            const url = $(this).data('url')
            $.ajax({
                url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                success: function(data) {
                    showDetail(data);
                }
            })
        })
    </script>

    <script>
        $(document).on('change', '.supplierStatus', function(event) {
            event.preventDefault();
            const url = $(this).data('url');
            const status = $(this).val();
            $.ajax({
                url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    status
                },
                type: 'PUT',
                success: function(data) {
                    toastr.success(data.msg, data.title)
                },
                error: function(error) {
                    toastr.error(data.msg, data.title)
                }
            })
        })

        $(document).on('click', '#reportPdf', function() {
            const url = `{{ route('owner.orang.pemasok.reportPdf') }}`
            window.open(url)
        });
        $(document).on('click', '#reportExcel', function() {
            const url = `{{ route('owner.orang.pemasok.reportExcel') }}`
            window.open(url)
        });
    </script>
@endsection
