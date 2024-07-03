<?php $page="createexpense";?>
@extends('layout.mainlayout')
@section('content')	
<div class="page-wrapper">
    <div class="content">
        @component('components.pageheader')                
			@slot('title') Expense Add @endslot
			@slot('title_1') Add/Update Expenses @endslot
		@endcomponent
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Expense Category</label>
                            <select class="select">
                                <option>Choose Category</option>
                                <option>Category</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Expense Date </label>
                            <div class="input-groupicon">
                                <input type="text" placeholder="Choose Date" class="datetimepicker">
                                <div class="addonset">
                                    <img src="{{ URL::asset('/assets/img/icons/calendars.svg')}}" alt="img">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Amount</label>
                            <div class="input-groupicon">
                                <input type="text">
                                <div class="addonset">
                                    <img src="{{ URL::asset('/assets/img/icons/dollar.svg')}}" alt="img">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Reference No.</label>
                            <input type="text" >
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Expense for</label>
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
                        <a href="{{url('expenselist')}}"  class="btn btn-cancel">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection