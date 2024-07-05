@extends('layout.mainlayout')

@section('title', 'User Management')

@section('forhead')
    {{-- Toastr Style --}}
    <link rel="stylesheet" href="{{ url('assets/plugins/toastr/toatr.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @livewireStyles
@endsection

@section('content')
    <div class="page-wrapper pagehead">
        <div class="content">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">User Management</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">User Management</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">List of User</h4>
                            <p class="card-text">
                                This is List of user that has been registered to the system.
                            </p>
                        </div>
                        <div class="card-body">
                            <div class="table-top">
                                <div class="search-set">
                                </div>
                                <div class="wordset">
                                    <ul>
                                        <li>
                                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"
                                                href="{{ route('superadmin.people.user.report-pdf') }}"><img
                                                    src="{{ URL::asset('/assets/img/icons/pdf.svg') }}" alt="img"></a>
                                        </li>
                                        <li>
                                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"
                                                href="{{ route('superadmin.people.user.report-excel') }}"><img
                                                    src="{{ URL::asset('/assets/img/icons/excel.svg') }}"
                                                    alt="img"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table  user-datatable ">
                                    <thead>
                                        <tr>
                                            <th>Picture</th>
                                            <th>Name</th>
                                            <th>E-Mail</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>
                                                    <div class="avatar">
                                                        <img class="avatar-img rounded-circle" alt="User Image"
                                                            src="{{ filter_var($item->userProfile->picture, FILTER_VALIDATE_URL) ? $item->userProfile->picture : URL::asset('assets/img/profiles/avatar-01.jpg') }}">
                                                    </div>
                                                </td>
                                                <td>{{ $item->userProfile->first_name ?? 'User' }}
                                                    {{ $item->userProfile->last_name ?? '' }}
                                                    @if ($item->isSubscribe === 1)
                                                        <i class="fas fa-crown"></i>
                                                    @endif
                                                </td>
                                                <td> {{ $item->email }} </td>
                                                <td>{{ $item->userProfile ? (isset($item->userProfile->phone) ? $item->userProfile->phone : '-') : (isset($item->userCashierProfile->phone) ? $item->userCashierProfile - phone : '-') }}
                                                </td>
                                                <td>{{ $item->userProfile ? ($item->userProfile->address ? $item->userProfile->address : '-') : $item->userCashierProfile->address ?? '-' }}
                                                </td>
                                                <td>@livewire('role-selector', ['model' => $item, 'field' => 'role_id'], key($item->role_id))</td>
                                                <td>
                                                    @if (Cache::has('is_online' . $item->id))
                                                        <span class="text-success">Online</span>
                                                    @else
                                                        <span class="text-danger">Offline</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a class="me-3"
                                                        href="{{ route('superadmin.people.user.show', Crypt::encrypt($item->id)) }}">
                                                        <img src="{{ URL::asset('assets/img/icons/eye.svg') }}"
                                                            alt="img">
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('forscript')

    @livewireScripts

    <script>
        window.addEventListener('show-toast', event => {
            toastr[event.detail.type](event.detail.message, event.detail.title);
        });
    </script>

    <script>
        $(document).ready(function() {
            // Mengambil token CSRF dari meta tag
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $('.user-datatable').DataTable({
                "bFilter": true,
                "sDom": 'fBtlpi',
                'pagingType': 'numbers',
                "ordering": true,
                "language": {
                    search: ' ',
                    sLengthMenu: '_MENU_',
                    searchPlaceholder: "Search...",
                    info: "_START_ - _END_ of _TOTAL_ items",
                },
                initComplete: (settings, json) => {
                    $('.dataTables_filter').appendTo('#tableSearch');
                    $('.dataTables_filter').appendTo('.search-input');
                },
            });
        })
    </script>

    {{-- Toast Script --}}
    <script src="{{ URL::asset('/assets/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/plugins/toastr/toastr.js') }}"></script>
@endsection
