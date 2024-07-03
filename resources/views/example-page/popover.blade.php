<?php $page="popover";?>
@extends('layout.mainlayout')
@section('content')
<div class="page-wrapper cardhead">
    <div class="content">
        @component('components.pageheader')                
			@slot('title') Popover @endslot
			@slot('li_1') Dashboard @endslot
            @slot('li_2') Popover @endslot
		@endcomponent
        <div class="row">
        
            <!-- Popover -->
            <div class="col-md-12">	
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Basic Popover</h5>
                    </div>
                    <div class="card-body">
                        <div class="popover-list">
                            <button class="btn btn-primary" type="button" data-bs-toggle="popover" title="" data-bs-content="And here's some amazing content. It's very engaging. Right?" data-bs-original-title="Popover title" aria-describedby="popover249009">Click to toggle popover</button>
                            
                            <a class="example-popover btn btn-primary" tabindex="0" role="button" data-bs-toggle="popover" data-bs-trigger="focus" title="" data-bs-content="And here's some amazing content. It's very engaging. Right?" data-bs-original-title="Popover title">Dismissible popover</a>
                            
                            <button class="example-popover btn btn-primary" type="button" data-bs-trigger="hover" data-container="body" data-bs-toggle="popover" data-bs-placement="bottom" title="" data-offset="-20px -20px" data-bs-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-bs-original-title="Popover title">On Hover Tooltip</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Popover -->
            
            <!-- Popover -->
            <div class="col-md-12">	
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Direction Popover</h5>
                    </div>
                    <div class="card-body">
                        <div class="popover-list">
                            <button class="example-popover btn btn-primary" type="button" data-container="body" data-bs-toggle="popover" data-bs-placement="top" title="" data-bs-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-bs-original-title="Popover title">Popover on top</button>
                            <button class="example-popover btn btn-primary" type="button" data-container="body" data-bs-toggle="popover" data-bs-placement="right" data-bs-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-bs-original-title="" title="">Popover on right</button>
                            <button class="example-popover btn btn-primary" type="button" data-container="body" data-bs-toggle="popover" data-bs-placement="bottom" data-bs-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-bs-original-title="" title="">Popover on bottom</button>
                            <button class="example-popover btn btn-primary" type="button" data-container="body" data-bs-toggle="popover" data-bs-placement="left" data-bs-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-bs-original-title="" title="">Popover on left</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Popover -->
                
        </div>
    
    </div>

</div>
@endsection