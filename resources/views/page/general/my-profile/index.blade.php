<?php
$user = Auth::user();
?>

@extends('layout.mainlayout')

@section('title', 'My Profile')

@section('forhead')
    {{-- Toastr Style --}}
    <link rel="stylesheet" href="{{ url('assets/plugins/toastr/toatr.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <div class="page-wrapper pagehead">
        <div class="content">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Profile
                            {{ $user->userProfile->first_name . ' ' . $user->userProfile->last_name }}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">My Profile</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form id="main_form" data-action="{{ route('my-profile.update', Crypt::encrypt($user->id)) }}"
                                data-method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="profile-set">
                                    <div class="profile-head">
                                    </div>
                                    <div class="profile-top">
                                        <div class="profile-content">
                                            <div class="profile-contentimg">
                                                <img src="{{ $user->userProfile->picture }}" alt="img" id="blah">
                                                <div class="profileupload">
                                                    <input type="file" id="imgInp" name="picture"
                                                        value="{{ $user->userProfile->picture }}">
                                                    <a href="javascript:void(0);"><img
                                                            src="{{ URL::asset('/assets/img/icons/edit-set.svg') }}"
                                                            alt="img"></a>
                                                </div>
                                            </div>
                                            <div class="profile-contentname">
                                                <h2>{{ $user->userProfile->first_name . ' ' . $user->userProfile->last_name }}
                                                </h2>
                                                <h4>Updates Your Photo and Personal Details.</h4>
                                            </div>
                                        </div>
                                        <div class="ms-auto">
                                            <button type="submit" id="submit_button" class="btn btn-submit me-2"
                                                disabled>Save</button>
                                            <button href="javascript:void(0);" onclick="reloadpage()"
                                                class="btn btn-cancel">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label>First Name</label>
                                            <input type="text" name="first_name"
                                                placeholder="{{ $user->userProfile->first_name }}"
                                                value="{{ $user->userProfile->first_name }}">
                                            <div class="invalid-feedback error-text">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Last Name</label>
                                            <input type="text" name="last_name"
                                                placeholder="{{ $user->userProfile->last_name }}"
                                                value="{{ $user->userProfile->last_name }}">
                                            <div class="invalid-feedback error-text">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Nickname</label>
                                            <input type="text" name="nickname" placeholder="Nickname"
                                                value="{{ $user->userProfile->nickname }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="text" name="email" placeholder="william@example.com"
                                                value="{{ $user->email }}" readonly>
                                            <div class="invalid-feedback error-text">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Phone</label>
                                            <input type="number" name="phone" placeholder="0833213124"
                                                value="{{ $user->userProfile->phone }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Birth of date </label>
                                            <div class="input-groupicon">
                                                <input type="text" name="birthdate" placeholder="DD-MM-YYYY"
                                                    class="datetimepicker"
                                                    value="{{ isset($user->userProfile->birthdate) ? Carbon\Carbon::createFromFormat('Y-m-d', $user->userProfile->birthdate)->format('d-m-Y') : null }}">
                                                <div class="addonset">
                                                    <img src="{{ URL::asset('/assets/img/icons/calendars.svg') }}"
                                                        alt="img">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="d-block">Gender:</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="gender"
                                                    id="gender_male" value="male"
                                                    @if ($user->userProfile->gender === 'male') checked @endif>
                                                <label class="form-check-label" for="gender_male">Male</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="gender"
                                                    id="gender_female" value="female"
                                                    @if ($user->userProfile->gender === 'female') checked @endif>
                                                <label class="form-check-label" for="gender_female">Female</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Address</label>
                                            <textarea name="address" id="address" rows="5" cols="5" class="form-control" placeholder="Address">{{ $user->userProfile->address }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('forscript')

    <script>
        function reloadpage() {
            location.reload();
        }
    </script>

    <script>
        $(document).ready(function() {
            // ambil semua input form
            var inputs = $('input');

            // tambahkan event listener pada setiap input
            inputs.each(function() {
                $(this).on('input', function() {
                    // jika terjadi perubahan pada salah satu input, aktifkan tombol submit
                    $('#submit_button').prop('disabled', false);
                });
            });

            $('#address').on('change', function() {
                // jika terjadi perubahan pada salah satu input, aktifkan tombol submit
                $('#submit_button').prop('disabled', false);
            })

        });
    </script>

    {{-- AJAX VALIDATOR && TRIGGER UPDATE OR CREATE URL --}}
    <script>
        $(function() {
            $("#main_form").on('submit', function(e) {
                e.preventDefault();
                
                var submit = document.getElementById('submit_button');
                submit.disabled = true;

                // create span class for spinning style
                var spinSpan = document.createElement('span');
                spinSpan.classList.add('spinner-border', 'spinner-border-sm');
                spinSpan.setAttribute('role', 'status');
                spinSpan.setAttribute('aria-hidden', 'true');

                // append span to submit button
                submit.append('...');
                submit.appendChild(spinSpan);
                
                $.ajax({
                    url: $(this).data('action'),
                    method: $(this).data('method'),
                    data: new FormData(this),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {
                        $(document).find('div.error-text').text('');
                        $('#main_form input').removeClass('is-valid is-invalid');
                        $('.invalid-feedback').text('');
                    },
                    success: function(data) {
                        if (data.status == 0) {
                            // enable button
                            submit.disabled = false;

                            // remove thing that has been added in html
                            var buttonText = submit.innerText.slice(0,-3);
                            submit.innerText = buttonText;
                            spinSpan.remove();

                            // add warning to html
                            $.each(data.error, function(prefix, val) {
                                var inputElem = $('input[name="' + prefix + '"]');
                                inputElem.addClass('is-invalid');
                                inputElem.next('.invalid-feedback').text(val[0]);
                            });

                            // show toast error
                            toastr.error(data.msg, 'Error')
                        } else {
                            toastr.success(data.msg, 'Success');
                            setTimeout(function() {
                                location.reload();
                            }, 1000)
                        }
                    }
                });
            });
        });
    </script>

    {{-- Toast Script --}}
    <script src="{{ URL::asset('/assets/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/plugins/toastr/toastr.js') }}"></script>
@endsection
