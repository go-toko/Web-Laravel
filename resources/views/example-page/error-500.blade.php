<?php $page="error-500";?>
@extends('layout.mainlayout')
@section('content')	
<div class="error-box">
    <h1>500</h1>
    <h3 class="h2 mb-3"><i class="fas fa-exclamation-circle"></i> Oops! Something went wrong</h3>
    <p class="h4 font-weight-normal">The page you requested was not found.</p>
    <a href="{{url('index')}}" class="btn btn-primary">Back to Home</a>
</div>
@endsection