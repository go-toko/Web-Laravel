<?php $page="editexpense";?>
@extends('layout.mainlayout')
@section('content')	
<div class="page-wrapper">
    <div class="content">
        @component('components.pageheader')                
			@slot('title') Expense EDIT @endslot
			@slot('title_1') Add/Update Expenses @endslot
		@endcomponent
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Expense Category</label>
                            <select class="select">
                                <option>Petrol</option>
                                <option>Diesel</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Expense Date </label>
                            <div class="input-groupicon">
                                <input type="text" placeholder="Choose Date" class="datetimepicker" value="2/27/2022">
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
                                <input type="text" value="120">
                                <div class="addonset">
                                    <img src="{{ URL::asset('/assets/img/icons/dollar.svg')}}" alt="img">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Reference No.</label>
                            <input type="text" value="555444">
                        </div>
                    </div>
                    <div class="col-lg-12 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Expense for</label>
                            <input type="text" value="Employee">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text </textarea>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <a class="btn btn-submit me-2">Update</a>
                        <a href="{{url('expenselist')}}" class="btn btn-cancel">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection