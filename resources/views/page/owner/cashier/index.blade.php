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
                                        <th class="col-2">Nama</th>
                                        <th class="col-1">Jenis Kelamin</th>
                                        <th class="col-2">Tanggal Lahir</th>
                                        <th class="col-2">Toko</th>
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
                                                        src="{{ isset($cashier->user->userProfile->picture) && $cashier->user->userProfile->picture != 'default-profile.png' ? asset('images/cashier-profile/' . $cashier->user->userProfile->picture) : asset('images/default-profile.png') }}">
                                                </div>
                                            </td>
                                            <td>{{ $cashier->user->userProfile->first_name . ' ' . $cashier->user->userProfile->last_name }}
                                            </td>
                                            <td>
                                                @if ($cashier->user->userProfile->gender == 'male')
                                                    Laki-laki
                                                @elseif ($cashier->user->userProfile->gender == 'female')
                                                    Perempuan
                                                @endif
                                            </td>
                                            <td>{{ $cashier->user->userProfile->birthdate ? Carbon\Carbon::createFromFormat('Y-m-d', $cashier->user->userProfile->birthdate)->translatedFormat('d F Y') : 'Belum di isi' }}
                                            </td>
                                            <td>
                                                <select class="form-control select cashierShop"
                                                    data-url="{{ route('owner.orang.kasir.update', ['id' => Crypt::encrypt($cashier->id)]) }}">
                                                    @foreach ($shops as $shop)
                                                        <option value="{{ $shop->id }}"
                                                            @if ($shop->id == $cashier->shop_id) selected @endif>
                                                            {{ $shop->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>{{ $cashier->user->userProfile->address ?? 'Belum di isi' }}</td>
                                            <td class="form-group d-flex align-center m-0">
                                                <a class="me-1 btn btn-filters detail-cashier" data-bs-toggle="modal"
                                                    title="Detail" data-bs-target="#exampleModal"
                                                    data-url="{{ route('owner.orang.kasir.getCashierByEmail', ['email' => $cashier->user->email]) }}">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                @if ($cashier->isActive)
                                                    <a class="me-1 btn btn-filters" id="confirm-delete" title="Nonaktifkan"
                                                        data-action="{{ route('owner.orang.kasir.delete', ['id' => Crypt::encrypt($cashier->id)]) }}">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                @else
                                                    <a class="me-1 btn btn-filters" id="restore-cashier" title="Aktifkan"
                                                        data-action="{{ route('owner.orang.kasir.restore', ['id' => Crypt::encrypt($cashier->id)]) }}">
                                                        <i class="fa fa-undo"></i>
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
                                src="{{ env('AWS_ENDPOINT_BUCKET') }}/noimage.png" alt="Foto Profil">
                        </div>
                        <div class="col-8 col-xl-7">
                            <h3 id="cashier-name">Nama Lengkap</h3>
                            <h4 id="cashier-username">nama-pengguna</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 col-sm-4 col-md-4 offset-xl-1 col-xl-3"><strong>Email</strong></div>
                        <div class="col-8 col-sm-8 col-md-8 col-xl-7">
                            <p id="cashier-email">example@gmail.com</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 col-sm-4 col-md-4 offset-xl-1 col-xl-3"><strong>Jenis Kelamin</strong></div>
                        <div class="col-8 col-sm-8 col-md-8 col-xl-7">
                            <p id="cashier-gender">Laki-laki</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 col-sm-4 col-md-4 offset-xl-1 col-xl-3"><strong>Telepon</strong></div>
                        <div class="col-8 col-sm-8 col-md-8 col-xl-7">
                            <p id="cashier-phone">0892137834132</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 col-sm-4 col-md-4 offset-xl-1 col-xl-3"><strong>Tanggal Lahir</strong></div>
                        <div class="col-8 col-sm-8 col-md-8 col-xl-7">
                            <p id="cashier-birthDate">20 Maret 2002</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 col-sm-4 col-md-4 offset-xl-1 col-xl-3"><strong>Toko</strong></div>
                        <div class="col-8 col-sm-8 col-md-8 col-xl-7">
                            <p id="cashier-shop">Nama Toko</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 col-sm-4 col-md-4 offset-xl-1 col-xl-3"><strong>Tanggal dibuat akun</strong>
                        </div>
                        <div class="col-8 col-sm-8 col-md-8 col-xl-7">
                            <p id="cashier-created">1 Januari 2001</p>
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
                text: "Anda akan menonaktifkan kasir ini",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Nonaktifkan!',
                cancelButtonText: 'Batalkan'
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
        $(document).on('click', '#restore-cashier', function(event) {
            event.preventDefault();
            const url = $(this).data('action');

            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "Anda akan mengaktifkan kembali kasir ini",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#2de000',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Aktifkan!',
                cancelButtonText: 'Batalkan'
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
        const cashierPhotoProfil = $('#cashier-photo-profile');
        const titleDOM = $('#exampleModalLabel')
        const cashierName = $('#cashier-name');
        const cashierUsername = $('#cashier-username');
        const cashierEmail = $('#cashier-email');
        const cashierGender = $('#cashier-gender');
        const cashierPhone = $('#cashier-phone');
        const cashierBirthDate = $('#cashier-birthDate');
        const cashierShop = $('#cashier-shop');
        const cashierCreated = $('#cashier-created');
        const cashierAddress = $('#cashier-address');

        const resetDetail = function() {
            cashierPhotoProfil.attr('src', `{{ URL::asset('images/default-profile.png') }}`)
            titleDOM.text('')
            cashierName.text('')
            cashierUsername.text('')
            cashierEmail.text('')
            cashierGender.text('')
            cashierPhone.text('')
            cashierBirthDate.text('')
            cashierShop.text('')
            cashierCreated.text('')
            cashierAddress.text('')
        }

        function showDetail(user) {
            resetDetail();
            const birthDate = user.user_profile.birthdate ? new Date(user.user_profile.birthdate) : undefined;
            const createdAt = new Date(user.created_at);

            titleDOM.text(`Profil ${user.user_profile.first_name} ${user.user_profile.last_name}`);
            cashierName.text(`${user.user_profile.first_name} ${user.user_profile.last_name}`);
            cashierUsername.text(user.user_profile.nickname)
            cashierEmail.text(`${user.email}`)
            cashierGender.text(`${user.user_profile.gender === 'male' ? 'Laki-laki' : 'Perempuan'}`)
            cashierPhone.text(`${user.user_profile.phone}`)
            cashierBirthDate.text(
                `${birthDate ? birthDate.toLocaleString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'}) : 'Belum di isi'}`
            );
            cashierShop.text(`${user.user_cashier.shop.name}`);

            cashierCreated.text(`${createdAt.toLocaleString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'})}`)
            cashierAddress.text(`${user.user_profile.address ? user.user_profile.address : 'Belum di isi'}`)
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
        $(document).on('change', '.cashierShop', function(event) {
            event.preventDefault();
            const url = $(this).data('url');
            const shopId = $(this).val();
            $.ajax({
                url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    shop_id: shopId
                },
                type: 'PUT',
                success: function(data) {
                    toastr.success(data.msg, data.title)
                },
                error: function(error) {
                    toastr.error(error.msg, error.title)
                }
            })
        })
    </script>
@endsection
