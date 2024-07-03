<?php $page="tooltip";?>
@extends('layout.mainlayout')
@section('content')
<div class="page-wrapper cardhead">
    <div class="content ">
        @component('components.pageheader')                
			@slot('title') Tooltip @endslot
			@slot('li_1') Dashboard @endslot
            @slot('li_2') Tooltip @endslot
		@endcomponent
        <div class="row">
        
            <!-- Tooltip -->
            <div class="col-md-12">	
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Html Element</h5>
                    </div>
                    <div class="card-body">
                        <div class="popover-list">
                            <button class="example-popover btn btn-primary" type="button" data-container="body" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Popover title">Hover Me</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Tooltip -->
        
            <!-- Popover -->
            <div class="col-md-12">	
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Direction Tooltip</h5>
                    </div>
                    <div class="card-body">
                        <div class="tooltip-list">
                            <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Tooltip on top">
                                Tooltip on top
                            </button>
                            <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="" data-bs-original-title="Tooltip on right">
                                Tooltip on right
                            </button>
                            <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Tooltip on bottom">
                                Tooltip on bottom
                            </button>
                            <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="left" title="" data-bs-original-title="Tooltip on left">
                                Tooltip on left
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Popover -->
            
            <!-- Tooltip -->
            <div class="col-md-12">	
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Html Element</h5>
                    </div>
                    <div class="card-body">
                        <div class="popover-list">
                            <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-html="true" title="" data-bs-original-title="<em>Tooltip</em> <u>with</u> <b>HTML</b>">
                                Tooltip with HTML
                            </button>
                            <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-trigger="click" data-bs-html="true" data-bs-placement="bottom" title="" data-bs-original-title="<em>Tooltip</em> <u>with</u> <b>HTML</b>">
                                Click Me
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Tooltip -->
                
        </div>
    
    </div>
</div>
@endsection