<?php $page = 'menus'; ?>
@extends('layout.mainlayout')

@section('title', 'My Store')

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
                    <a href="{{ route('owner.settings.store.add') }}" class="btn btn-added">
                        <img src="{{ URL::asset('assets/img/icons/plus.svg') }}" class="me-1" alt="img">Add Store
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
                                        <th class="col-0">
                                            <label class="checkboxs">
                                                <input type="checkbox" id="select-all" />
                                                <span class="checkmarks"></span>
                                            </label>
                                        </th>
                                        <th class="col-2">Name</th>
                                        <th class="col-2">Description</th>
                                        <th class="col-5">Address</th>
                                        <th class="col-2">Status</th>
                                        <th class="col-1">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stores as $store)
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
                                            <td>
                                                <a class="me-3"
                                                    href="{{ route('owner.settings.store.edit', ['id' => Crypt::encrypt($store->id)]) }}">
                                                    <img src="{{ URL::asset('assets/img/icons/edit.svg') }}"
                                                        alt="img" />
                                                </a>
                                                <a class="me-3" id="confirm-delete"
                                                    data-action="{{ route('owner.settings.store.delete', ['id' => Crypt::encrypt($store->id)]) }}">
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
                @if ($deletedStores)
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
                                            <th class="col-2">Name</th>
                                            <th class="col-2">Description</th>
                                            <th class="col-5">Address</th>
                                            <th class="col-2">Status</th>
                                            <th class="col-1">Action</th>
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
                                                <td>
                                                    <a class="me-3"
                                                        href="{{ route('owner.settings.store.edit', ['id' => Crypt::encrypt($store->id)]) }}">
                                                        <img src="{{ URL::asset('assets/img/icons/edit.svg') }}"
                                                            alt="img" />
                                                    </a>
                                                    <a class="me-3" id="confirm-delete"
                                                        data-action="{{ route('owner.settings.store.delete', ['id' => Crypt::encrypt($store->id)]) }}">
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
                @endif
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

    <script>
        let type = {!! json_encode($type) !!};
        let msg = {!! json_encode($msg) !!};
        const title = {!! json_encode($title) !!};
        @if (Session::has($type))
            {
                toastr[type](msg, title, {
                    closeButton: !0,
                    tapToDismiss: !1,
                    positionClass: 'toast-top-center',
                })
            }
        @endif
    </script>
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
