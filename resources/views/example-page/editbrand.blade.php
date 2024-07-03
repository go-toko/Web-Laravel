<?php $page="editbrand";?>
@extends('layout.mainlayout')
@section('content')	
<div class="page-wrapper">
    <div class="content">
        @component('components.pageheader')                
			@slot('title') Brand Edit @endslot
			@slot('title_1') Update your Brand @endslot
		@endcomponent
        <!-- /add -->
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Brand Name</label>
                            <input type="text" value="samsung">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</textarea>
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
                    <div class="col-12">
                        <div class="product-list">
                            <ul class="row">
                                <li>
                                    <div class="productviews">
                                        <div class="productviewsimg">
                                            <img src="{{ URL::asset('/assets/img/brand/samsung.png')}}" alt="img">
                                        </div>
                                        <div class="productviewscontent">
                                            <div class="productviewsname">
                                                <h2>samsung</h2>
                                                <h3>581kb</h3>
                                            </div>
                                            <a href="javascript:void(0);">x</a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <a href="javascript:void(0);" class="btn btn-submit me-2">Submit</a>
                        <a href="{{url('brandlist')}}" class="btn btn-cancel">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /add -->
    </div>
</div>
@endsection