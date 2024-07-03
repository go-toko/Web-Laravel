<?php $page="newcountry";?>
@extends('layout.mainlayout')
@section('content')
<div class="page-wrapper">
    <div class="content">
        @component('components.pageheader')                
			@slot('title') Places Management @endslot
			@slot('title_1') Add/Update Places @endslot
		@endcomponent
        <!-- /add -->
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Country Name</label>
                            <input type="text" >
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Region</label>
                            <input type="text" >
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <a href="javascript:void(0);" class="btn btn-submit me-2">Submit</a>
                        <a href="{{url('countrieslist')}}"  class="btn btn-cancel">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /add -->
    </div>
</div>
@endsection