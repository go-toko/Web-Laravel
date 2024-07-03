<?php $page="lightbox";?>
@extends('layout.mainlayout')
@section('content')
<div class="page-wrapper cardhead">
    <div class="content">
        @component('components.pageheader')                
			@slot('title') Lightbox @endslot
			@slot('li_1') Dashboard @endslot
            @slot('li_2') Lightbox @endslot
		@endcomponent
        <div class="row">
        
            <!-- Lightbox -->
            <div class="col-md-12">	
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Single Image Lightbox</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-2 mb-md-0">
                                <a href="{{url('assets/img/img-01.jpg')}}" class="image-popup">
                                    <img src="{{ URL::asset('/assets/img/img-01.jpg')}}" class="img-fluid" alt="image">
                                </a>
                            </div>
                            <div class="col-md-4 mb-2 mb-md-0">
                                <a href="{{url('assets/img/img-02.jpg')}}" class="image-popup">
                                    <img src="{{ URL::asset('/assets/img/img-02.jpg')}}" class="img-fluid" alt="image">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Lightbox -->
            
            <!-- Lightbox -->
            <div class="col-md-12">	
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Image with Description</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-2 mb-md-0">
                                <a href="{{url('assets/img/img-03.jpg')}}" class="image-popup-desc" data-title="Title 01" data-description="Lorem ipsum dolor sit amet, consectetuer adipiscing elit">
                                    <img src="{{ URL::asset('/assets/img/img-03.jpg')}}" class="img-fluid" alt="work-thumbnail">
                                </a>
                            </div>
                            <div class="col-md-4 mb-2 mb-md-0">
                                <a href="{{url('assets/img/img-04.jpg')}}" class="image-popup-desc" data-title="Title 02" data-description="Lorem ipsum dolor sit amet, consectetuer adipiscing elit">
                                    <img src="{{ URL::asset('/assets/img/img-04.jpg')}}" class="img-fluid" alt="work-thumbnail">
                                </a>
                            </div>
                            <div class="col-md-4 mb-2 mb-md-0">
                                <a href="{{url('assets/img/img-05.jpg')}}" class="image-popup-desc" data-title="Title 03" data-description="Lorem ipsum dolor sit amet, consectetuer adipiscing elit">
                                    <img src="{{ URL::asset('/assets/img/img-05.jpg')}}" class="img-fluid" alt="work-thumbnail">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Lightbox -->
            
        </div>
    
    </div>				
</div>
@endsection