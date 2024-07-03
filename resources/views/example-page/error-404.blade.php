<?php $page="error-404";?>
@extends('layout.mainlayout')
@section('content')	
<div class="error-box">
    <h1>404</h1>
    <h3 class="h2 mb-3"><i class="fas fa-exclamation-circle"></i> Oops! Page not found!</h3>
    <p class="h4 font-weight-normal">The page you requested was not found.</p>
    <a href="{{url('index')}}" class="btn btn-primary">Back to Home</a>
</div>
@endsection