<?php $page = 'signin'; ?>
@extends('layout.mainlayout')

@section('title', 'Login')

@section('content')
    <Form id="login_form" action="" method="POST" class="account-content">
        @csrf
        <div class="login-wrapper">
            <div class="login-content">
                <div class="login-userset">
                    <div class="login-logo logo-normal">
                        <img src="{{ URL::asset('/assets/img/Pos-gotoko-colorfull.png') }}" alt="img">
                    </div>
                    <a href="{{ url('index') }}" class="login-logo logo-white">
                        <img src="{{ URL::asset('/assets/img/Pos-gotoko-white.png') }}" alt="">
                    </a>

                    <div class="login-userheading">
                        <h3>Sign In</h3>
                        <h4>Please login to your account</h4>
                    </div>
                    <span class="text danger" id="login-error"></span>
                    <div class="form-login">
                        <label>Store ID</label>
                        <div class="form-addons">
                            <input type="text" name="shop_id" id="shop_id" value="">
                        </div>
                        <div class="text-danger pt-2">
                            @error('0')
                                {{ $message }}
                            @enderror
                            @error('email')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="form-login">
                        <label>Username</label>
                        <div class="form-addons">
                            <input type="text" name="username" id="Username" value="">
                        </div>
                        <div class="text-danger pt-2">
                            @error('0')
                                {{ $message }}
                            @enderror
                            @error('email')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="form-login">
                        <label>Password</label>
                        <div class="pass-group">
                            <input type="password" class="pass-input" name="password" id="password" value="">
                            <span class="fas toggle-password fa-eye-slash"></span>
                        </div>
                        <div class="text-danger pt-2">
                            @error('0')
                                {{ $message }}
                            @enderror
                            @error('password')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="form-login">
                        <button class="btn btn-login" type="submit" id="submit">Sign In</button>
                    </div>
                </div>
                <a href="{{ route('login') }}">Login as Owner</a>
            </div>
            <div class="login-img">
                <img src="{{ URL::asset('/assets/img/login.jpg') }}" alt="img">
            </div>
        </div>
    </Form>

@endsection

@section('forscript')
    <script>
        $(function() {
            $("#login_form").on('submit', function(e) {
                e.preventDefault();

                var submit = document.getElementById('submit');
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
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: new FormData(this),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {
                        $(document).find('div.error-text').text('');
                        $('#login_form input').removeClass('is-valid is-invalid');
                        $('.invalid-feedback').text('');
                    },
                    success: function(data) {
                        if (data.status == 0) {
                            // enable button
                            submit.disabled = false;

                            // remove thing that has been added in html
                            var buttonText = submit.innerText.slice(0, -3);
                            submit.innerText = buttonText;
                            spinSpan.remove();

                            // add warning to html
                            var error = document.getElementById('')
                            error.append(data.error)
                            toastr.error(data.msg, 'Error')
                        }
                    }
                });
            });
        });
    </script>
@endsection
