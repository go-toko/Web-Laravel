<?php $page = 'signin'; ?>
@extends('layout.mainlayout')

@section('title', 'Register')

@section('content')
    <div class="login-wrapper">
        <div class="login-content">
            <div class="login-userset">
                <div class="login-logo logo-normal">
                    <img src="{{ URL::asset('/assets/img/Pos-gotoko-colorfull.png') }}" alt="img">
                </div>
                <a href="{{ url('index') }}" class="login-logo logo-white">
                    <img src="{{ URL::asset('/assets/img/Pos-gotoko-white.png') }}" alt="">
                </a>

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ url('register') }}" method="POST">
                    @csrf
                    <div class="login-userheading">
                        <h3>Daftar</h3>
                        <h4>Silahkan isi data diri anda</h4>
                    </div>
                    <div class="form-login">
                        <label>Name</label>
                        <div class="form-addons">
                            <input type="text" name="name" id="name" placeholder="John Doe" value="">
                        </div>
                        <div class="text-danger pt-2">
                            @error('0')
                                {{ $message }}
                            @enderror
                            @error('name')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div class="form-login">
                        <label>Email</label>
                        <div class="form-addons">
                            <input type="text" name="email" id="Email" placeholder="john@doe.com" value="">
                            <img src="{{ URL::asset('/assets/img/icons/mail.svg') }}" alt="img">
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
                            <input type="password" class="pass-input" name="password" id="password" placeholder="********"
                                value="">
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

                    <!-- Kebijakan Privasi -->
                    <div class="form-login">
                        <label for="policy">Dengan mendaftar, saya menyetujui <a href="{{ url('privacy-policy') }}"
                                class="hover-a">Kebijakan Privasi</a> GoToko.ID</label>
                    </div>

                    <div class="form-login">
                        <button class="btn btn-login" type="submit">Daftar</button>
                    </div>
                </form>
                <div class="signinform text-center">
                    <h4>Sudah punya akun?<a href="{{ url('/') }}" class="hover-a"> Masuk</a></h4>
                </div>
                <div class="form-setlogin">
                    <h4>Atau</h4>
                </div>
                <div class="form-sociallink">
                    <ul class="d-flex justify-content-center">
                        <li>
                            <a href="{{ url('login/google') }}">
                                <img src="{{ URL::asset('/assets/img/icons/google.png') }}" class="me-2" alt="google">
                                Daftar dengan Google
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="login-img">
            <img src="{{ URL::asset('/assets/img/login.jpg') }}" alt="img">
        </div>
    </div>
@endsection
