<?php $page="rating";?>
@extends('layout.mainlayout')
@section('content')
<div class="page-wrapper cardhead">
    <div class="content">
        @component('components.pageheader')                
			@slot('title') Rating @endslot
			@slot('li_1') Dashboard @endslot
            @slot('li_2') Rating @endslot
		@endcomponent
        <div class="row">
        
            <!-- Rating -->
            <div class="col-md-6">	
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Default Rating</h5>
                    </div>
                    <div class="card-body">
                        <p>This is the most basic example of ratings.</p>
                        <div class="rating rating-default"></div>
                    </div>
                </div>
            </div>
            <!-- /Rating -->
            
            <!-- Rating -->
            <div class="col-md-6">	
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Score</h5>
                    </div>
                    <div class="card-body">
                        <p>Stars with a saved rating.</p>
                        <div class="rating rating-score"></div>
                    </div>
                </div>
            </div>
            <!-- /Rating -->
            
            <!-- Rating -->
            <div class="col-md-6">	
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Max Number</h5>
                    </div>
                    <div class="card-body">
                        <p>Change the max numbers of stars</p>
                        <div class="rating rating-number"></div>
                    </div>
                </div>
            </div>
            <!-- /Rating -->
            
            <!-- Rating -->
            <div class="col-md-6">	
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Read Only</h5>
                    </div>
                    <div class="card-body"> 
                        <p>Prevent users from voting</p>
                        <div class="rating rating-read-only2"></div>
                    </div>
                </div>
            </div>
            <!-- /Rating -->
            
            <!-- Rating -->
            <div class="col-md-6">	
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Half Rating</h5>
                    </div>
                    <div class="card-body">
                        <p>You can represent a float score as a half star icon.</p>
                        <div class="rating rating-half-enable"></div>
                    </div>
                </div>
            </div>
            <!-- /Rating -->
            
            <!-- Rating -->
            <div class="col-md-6">	
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Custom Icon</h5>
                    </div>
                    <div class="card-body">
                        <p>Use any icon you want.</p>
                        <div class="rating rating-custom-icon"></div>
                    </div>
                </div>
            </div>
            <!-- /Rating -->
                
        </div>
    
    </div>			
</div>
@endsection