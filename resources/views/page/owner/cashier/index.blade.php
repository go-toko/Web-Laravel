<?php $page = 'menus'; ?>
@extends('layout.mainlayout')

@section('title', 'Daftar Kasir')

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
                    <a href="{{ route('owner.orang.kasir.add') }}" class="btn btn-added">
                        <img src="{{ URL::asset('assets/img/icons/plus.svg') }}" class="me-1" alt="img">Tambah Kasir
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
                                        <th class="col-0">Foto</th>
                                        <th class="col-3">Nama Lengkap</th>
                                        <th class="col-2">Jenis Kelamin</th>
                                        <th class="col-1">Tanggal Lahir</th>
                                        <th class="col-1">Status</th>
                                        <th class="col-4">Alamat</th>
                                        <th class="col-1">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cashiers as $cashier)
                                        <tr>
                                            <td>
                                                <div class="avatar">
                                                    <img class="avatar-img rounded-circle" alt="User Image"
                                                        src="{{ isset($cashier->picture) && $cashier->picture != 'default-profile.png' ? asset('images/cashier-profile/' . $cashier->picture) : asset('images/default-profile.png') }}">
                                                </div>
                                            </td>
                                            <td>{{ $cashier->name }}</td>
                                            <td>
                                                @if ($cashier->gender == 'male')
                                                    Laki-laki
                                                @else
                                                    Perempuan
                                                @endif
                                            </td>
                                            <td>{{ Carbon\Carbon::createFromFormat('Y-m-d', $cashier->birthDate)->format('d-m-Y') }}
                                            </td>
                                            <td>
                                                <select class="form-control select cashierStatus"
                                                    data-url="{{ route('owner.orang.kasir.update', ['id' => Crypt::encrypt($cashier->id)]) }}">
                                                    @foreach ($status as $index => $value)
                                                        <option value="{{ $index }}"
                                                            @if ($cashier->status == $index) selected @endif>
                                                            {{ $value }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>{{ $cashier->address }}</td>
                                            <td>
                                                <a class="me-1 detail-cashier" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal"
                                                    data-url="{{ route('owner.orang.kasir.getCashierByUsername', ['username' => $cashier->username]) }}">
                                                    <img src="{{ URL::asset('assets/img/icons/eye.svg') }}" alt="eye">
                                                </a>
                                                <a class="me-1" id="confirm-delete"
                                                    data-action="{{ route('owner.orang.kasir.delete', ['id' => Crypt::encrypt($cashier->id)]) }}">
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
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Profil ...</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row align-items-center mb-2">
                        <div class="col-4 offset-xl-1 col-xl-3 text-center">
                            <img id="cashier-photo-profile" class="rounded-circle"
                                style="height: 100px; width: 100px; object-fit: cover; object-position: center center"
                                src="{{ URL::asset('images/default-profile.png') }}" alt="">
                        </div>
                        <div class="col-8 col-xl-7">
                            <h3 id="cashier-name">Arif Rahman Mubarok</h3>
                            <h4 id="cashier-username">arifrm28</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 col-sm-4 col-md-4 offset-xl-1 col-xl-3"><strong>Jenis Kelamin</strong></div>
                        <div class="col-8 col-sm-8 col-md-8 col-xl-7">
                            <p id="cashier-gender">Laki-laki</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 col-sm-4 col-md-4 offset-xl-1 col-xl-3"><strong>Tanggal Lahir</strong></div>
                        <div class="col-8 col-sm-8 col-md-8 col-xl-7">
                            <p id="cashier-birthDate">20 Maret 2002</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 col-sm-4 col-md-4 offset-xl-1 col-xl-3"><strong>Status</strong></div>
                        <div class="col-8 col-sm-8 col-md-8 col-xl-7">
                            <div class="badge bg-success" id="cashier-status">Aktif</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 col-sm-4 col-md-4 offset-xl-1 col-xl-3"><strong>Alamat</strong></div>
                        <div class="col-8 col-sm-8 col-md-8 col-xl-7">
                            <p id="cashier-address">Detail Lengkap Alamat Lorem ipsum, dolor sit amet consectetur
                                adipisicing elit. Recusandae
                                fuga vel esse, incidunt molestiae vitae.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 col-sm-4 col-md-4 offset-xl-1 col-xl-3"><strong>Akun dibuat pada tanggal</strong>
                        </div>
                        <div class="col-8 col-sm-8 col-md-8 col-xl-7">
                            <p id="cashier-created">20 Bulan Tahun</p>
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
    <script>
        // select the DOM 
        const titleDOM = $('#exampleModalLabel')
        const cashierPhotoProfil = $('#cashier-photo-profile');
        const cashierName = $('#cashier-name');
        const cashierUsername = $('#cashier-username');
        const cashierGender = $('#cashier-gender');
        const cashierBirthDate = $('#cashier-birthDate');
        const cashierStatus = $('#cashier-status');
        const cashierCreated = $('#cashier-created');
        const cashierAddress = $('#cashier-address');

        const resetDetail = function() {
            cashierPhotoProfil.attr('src', `{{ URL::asset('images/default-profile.png') }}`)
            titleDOM.text('')
            cashierName.text('')
            cashierUsername.text('')
            cashierGender.text('')
            cashierBirthDate.text('')
            cashierStatus.text('')
            cashierCreated.text('')
        }

        function showDetail(data) {
            resetDetail();

            titleDOM.text(`Profil ${data.name}`)
            if (data.picture && data.picture != 'default-profile.png')
                cashierPhotoProfil.attr('src', `{{ URL::asset('images/cashier-profile/${data.picture}') }}`)
            cashierName.text(data.name);
            cashierUsername.text(data.username)
            cashierGender.text(`${data.gender === 'male' ? 'Laki-laki' : 'Perempuan'}`)
            cashierAddress.text(`${data.address ? data.address : 'Belum di isi'}`)

            const status = ['Aktif', 'Resign', 'Keluar']
            const statusClass = ['bg-success', 'bg-warning text-dark', 'bg-danger']
            cashierStatus.text(status[data.status]);
            cashierStatus.removeClass('bg-success bg-warning bg-danger');
            cashierStatus.addClass(statusClass[data.status])

            const birthDate = new Date(data.birthDate);
            cashierBirthDate.text(
                `${birthDate.toLocaleString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'})}`)
            const createdAt = new Date(data.created_at);
            cashierCreated.text(`${createdAt.toLocaleString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'})}`)
        }

        $(document).on('click', '.detail-cashier', function(e) {
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
        $(document).on('change', '.cashierStatus', function(event) {
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
    </script>
@endsection
