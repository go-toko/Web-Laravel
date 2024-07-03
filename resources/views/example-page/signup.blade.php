<?php $page="signup";?>
@extends('layout.mainlayout')
@section('content')
<Form action="{{ route('signup.custom') }}" method="POST" class="account-content">
@csrf
    <div class="login-wrapper">
        <div class="login-content">
            <div class="login-userset">
                <div class="login-logo  logo-normal">
                    <img src="{{ URL::asset('/assets/img/logo.png')}}" alt="img">
                </div>
                <a href="{{url('index')}}" class="login-logo logo-white">
                    <img src="{{URL::asset('/assets/img/logo-white.png')}}"  alt="">
                </a>
                <div class="login-userheading">
                    <h3>Create an Account</h3>
                    <h4>Continue where you left off</h4>
                </div>
                <div class="form-login">
                    <label>Full Name</label>
                    <div class="form-addons">
                        <input type="text" id="name" placeholder="Enter your full name" name="name" value="{{old('name')}}">
                        <img src="{{ URL::asset('/assets/img/icons/users1.svg')}}" alt="img">
                        <div class="text-danger pt-2">
                            @error('name')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-login">
                    <label>Email</label>
                    <div class="form-addons">
                        <input type="text" id="email" name="email" placeholder="Enter your email address">
                        <img src="{{ URL::asset('/assets/img/icons/mail.svg')}}" alt="img">
                        <div class="text-danger pt-2">
                            @error('email')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-login">
                    <label>Password</label>
                    <div class="pass-group">
                        <input type="password" id="password" name="password" value="{{old('password')}}" class="pass-input" placeholder="Enter your password">
                        <span class="fas toggle-password fa-eye-slash"></span>
                        <div class="text-danger pt-2">
                            @error('password')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-login">
                    <button class="btn btn-login">Sign Up</button>
                </div>
                <div class="signinform text-center">
                    <h4>Already a user? <a href="{{url('signin')}}" class="hover-a">Sign In</a></h4>
                </div>
                <div class="form-setlogin">
                    <h4>Or sign up with</h4>
                </div>
                <div class="form-sociallink">
                    <ul>
                        <li>
                            <a href="javascript:void(0);">
                                <img src="{{URL::asset('/assets/img/icons/google.png')}}" class="me-2" alt="google">
                                Sign Up using Google
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);">
                                <img src="{{ URL::asset('/assets/img/icons/facebook.png')}}" class="me-2" alt="google">
                                Sign Up using Facebook
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="login-img">
            <img src="{{ URL::asset('/assets/img/login.jpg')}}" alt="img">
        </div>
    </div>
</Form>
@endsection