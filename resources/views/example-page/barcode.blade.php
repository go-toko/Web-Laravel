<?php $page="barcode";?>
@extends('layout.mainlayout')
@section('content')	
<div class="page-wrapper">
    <div class="content">
        @component('components.pageheader')                
			@slot('title') Print Barcode @endslot
			@slot('title_1') Print product barcodes @endslot
		@endcomponent
        <!-- /add -->
        <div class="card">
            <div class="card-body">
                <div class="requiredfield">
                    <h4>The field labels marked with * are required input fields.</h4>
                </div>
                <div class="form-group">
                    <label>Product Name</label>
                    <div class="input-groupicon">
                        <input type="text"  placeholder="Please type product code and select...">
                        <div class="addonset">
                            <img src="{{ URL::asset('/assets/img/icons/scanners.svg')}}" alt="img">
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive table-height">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>SKU</th>
                                <th>Qty</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr >
                                <td>Macbook pro</td>
                                <td>PT001</td>
                                <td>100.00</td>
                                <td class="text-end">
                                    <a class="delete-set"><img src="{{ URL::asset('/assets/img/icons/delete.svg')}}" alt="img"></a>
                                </td>
                            </tr>
                            <tr >
                                <td>Apple Earpods </td>
                                <td>PT002</td>
                                <td>1000.00</td>
                                <td class="text-end">
                                    <a class="delete-set"><img src="{{ URL::asset('/assets/img/icons/delete.svg')}}" alt="img"></a>
                                </td>
                            </tr>
                            <tr >
                                <td>Macbook Pro</td>
                                <td>PT003</td>
                                <td>5000.00</td>
                                <td class="text-end">
                                    <a class="delete-set"><img src="{{ URL::asset('/assets/img/icons/delete.svg')}}" alt="img"></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Paper Size</label>
                            <select class="select">
                                <option>36mm (1.4 inch)</option>
                                <option>12mm (1 inch)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <a href="javascript:void(0);" class="btn btn-submit me-2">Submit</a>
                        <a href="javascript:void(0);"  class="btn btn-cancel">Cancel</a>
                    </div>
                </div>
            </div>
        </div>	
        <!-- /add -->
    </div>
</div>
@component('components.modal-popup')                
@endcomponent
@endsection