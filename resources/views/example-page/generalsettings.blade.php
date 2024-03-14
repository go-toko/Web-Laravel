<?php $page="generalsettings";?>
@extends('layout.mainlayout')
@section('content')	
<div class="page-wrapper">
    <div class="content">
        @component('components.pageheader')                
			@slot('title') General Setting @endslot
			@slot('title_1') Manage General Setting @endslot
		@endcomponent
        <!-- /add -->
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Title <span class="manitory">*</span></label>
                            <input type="text" placeholder="Enter Title">
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Time Zone </label>
                            <select class="select">
                                <option>Choose Time Zone </option>
                                <option>USD Time Zone</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Currency <span class="manitory">*</span></label>
                            <select class="select">
                                <option>Choose Currency </option>
                                <option>INR</option>
                                <option>USA</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Date Format<span class="manitory">*</span></label>
                            <select class="select">
                                <option>Choose Date Format </option>
                                <option>DD/MM/YYYY</option>
                                <option>MM/DD/YYYY</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Email<span class="manitory">*</span></label>
                            <input type="text" placeholder="Enter email">
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Phone<span class="manitory">*</span></label>
                            <input type="text" placeholder="Enter Phone">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <label>Address<span class="manitory">*</span> </label>
                            <input type="text" placeholder="Enter Address">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>	Product Image</label>
                            <div class="image-upload">
                                <input type="file">
                                <div class="image-uploads">
                                    <img src="{{ URL::asset('/assets/img/icons/upload.svg')}}" alt="img">
                                    <h4>Drag and drop a file to upload</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <a href="javascript:void(0);" class="btn btn-submit me-2">Submit</a>
                            <a href="javascript:void(0);" class="btn btn-cancel">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /add -->
    </div>
</div>
@endsection