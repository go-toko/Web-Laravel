@extends('layout.profile-layout-form')

@section('title', 'Lengkapi Profilmu')

@section('forhead')
    <meta name="csrf-token"content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ url('assets/plugins/twitter-bootstrap-wizard/form-wizard.css') }}">
@endsection

@section('content')
    <!-- Wizard -->
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Lengkapi Profilmu</h4>
            </div>
            <div class="card-body">
                <div id="progrss-wizard" class="twitter-bs-wizard">
                    <ul class="twitter-bs-wizard-nav nav nav-pills nav-justified">
                        <li class="nav-item">
                            <a href="#progress-seller-details" class="nav-link" data-toggle="tab">
                                <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Detail Pengguna">
                                    <i class="far fa-user"></i>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#progress-company-document" class="nav-link" data-toggle="tab">
                                <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Detail Bisnis">
                                    <i class="fas fa-map-pin"></i>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <!-- wizard-nav -->
                    <div id="bar" class="progress mt-4">
                        <div class="progress-bar bg-success progress-bar-striped progress-bar-animated"></div>
                    </div>
                    <form action="{{ route('owner.complete-profile.update', Crypt::encrypt($userProfile->id)) }}"
                        method="post" class="">
                        @method('put')
                        @csrf
                        <div class="tab-content twitter-bs-wizard-tab-content">
                            @include('page.owner.fill-profile.form.user')
                            @include('page.owner.fill-profile.form.business')
                            {{-- <div class="tab-pane" id="progress-bank-detail">
                                <div>
                                    <div class="mb-4">
                                        <h5>Payment Details</h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="progresspill-namecard-input" class="form-label">Name on
                                                    Card</label>
                                                <input type="text" class="form-control" id="progresspill-namecard-input">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label">Credit Card Type</label>
                                                <select class="form-select">
                                                    <option selected>Select Card Type</option>
                                                    <option value="AE">American Express</option>
                                                    <option value="VI">Visa</option>
                                                    <option value="MC">MasterCard</option>
                                                    <option value="DI">Discover</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="progresspill-cardno-input" class="form-label">Credit Card
                                                    Number</label>
                                                <input type="text" class="form-control" id="progresspill-cardno-input">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="progresspill-card-verification-input" class="form-label">Card
                                                    Verification Number</label>
                                                <input type="text" class="form-control"
                                                    id="progresspill-card-verification-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="progresspill-expiration-input" class="form-label">Expiration
                                                    Date</label>
                                                <input type="text" class="form-control"
                                                    id="progresspill-expiration-input">
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="pager wizard twitter-bs-wizard-pager-link justify-content-between">
                                        <li class="previous"><a href="javascript: void(0);" class="btn btn-primary"
                                                onclick="nextTab()"><i class="bx bx-chevron-left me-1"></i> Previous</a>
                                        </li>
                                        <li class="float-end">
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </li>
                                    </ul>
                                </div>
                            </div> --}}
                        </div>
                    </form>
                </div>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
    </div>
    <!-- /Wizard -->
@endsection

@section('forscript')
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
        })

        // get and display kabupaten
        $(function() {
            $('#provinceBusiness').on('change', function() {
                let idProvince = $('#provinceBusiness').val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('owner.complete-profile.getRegencies') }}',
                    data: {
                        id_province: idProvince
                    },
                    cache: false,
                    success: function(regency) {
                        $('#regencyBusiness').html(regency)
                    },
                })
            })
        })

        // get and display kecamatan
        $(function() {
            $('#regencyBusiness').on('change', function() {
                let idRegency = $('#regencyBusiness').val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('owner.complete-profile.getDistrict') }}',
                    data: {
                        id_regency: idRegency
                    },
                    cache: false,
                    success: function(district) {
                        $('#districtBusiness').html(district)
                    },
                })
            })
        })

        // get and display desa
        $(function() {
            $('#districtBusiness').on('change', function() {
                let idDistrict = $('#districtBusiness').val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('owner.complete-profile.getVillage') }}',
                    data: {
                        id_district: idDistrict
                    },
                    cache: false,
                    success: function(villages) {
                        $('#villageBusiness').html(villages)
                    }
                })
            })
        })

        $(document).ready(function() {
            $('.select').select2()
        })
    </script>
    <!-- Wizard JS -->
    <script src="{{ URL::asset('/assets/plugins/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/plugins/twitter-bootstrap-wizard/prettify.js') }}"></script>
    <script src="{{ URL::asset('/assets/plugins/twitter-bootstrap-wizard/form-wizard.js') }}"></script>
@endsection
