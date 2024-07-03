<?php $page="calendar";?>
@extends('layout.mainlayout')
@section('content')	
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="row align-items-center w-100">
                <div class="col-lg-10 col-sm-12">
                    <h3 class="page-title">Calendar</h3>
                </div>
                <div class="col-lg-2 col-sm-12">
                    <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_event">Create Event</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-4">
                <h4 class="card-title">Drag & Drop Event</h4>
                <div id="calendar-events" class="mb-3">
                    <div class="calendar-events" data-class="bg-info"><i class="fas fa-circle text-info"></i> My Event One</div>
                    <div class="calendar-events" data-class="bg-success"><i class="fas fa-circle text-success"></i> My Event Two</div>
                    <div class="calendar-events" data-class="bg-danger"><i class="fas fa-circle text-danger"></i> My Event Three</div>
                    <div class="calendar-events" data-class="bg-warning"><i class="fas fa-circle text-warning"></i> My Event Four</div>
                </div>
                <div class="checkbox  mb-3">
                    <input id="drop-remove" type="checkbox">
                    <label for="drop-remove">
                        Remove after drop
                    </label>
                </div>
                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#add_new_event" class="btn mb-3 btn-primary btn-block w-100">
                    <i class="fas fa-plus"></i> Add Category
                </a>
            </div>
            <div class="col-lg-9 col-md-8">
                <div class="card bg-white">
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@component('components.modal-popup')                
@endcomponent
@endsection