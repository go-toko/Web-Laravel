<?php $page="storelist";?>
@extends('layout.mainlayout')
@section('content')
<div class="page-wrapper">
    <div class="content">
        @component('components.pageheader')                
			@slot('title') Store List @endslot
			@slot('title_1') Manage your Store @endslot
		@endcomponent

        <!-- /product list -->
        <div class="card">
            <div class="card-body">
                <div class="table-top">
                    <div class="search-set">
                        <div class="search-path">
                            <a class="btn btn-filter" id="filter_search">
                                <img src="{{ URL::asset('/assets/img/icons/filter.svg')}}" alt="img">
                                <span><img src="{{ URL::asset('/assets/img/icons/closes.svg')}}" alt="img"></span>
                            </a>
                        </div>
                        <div class="search-input">
                            <a class="btn btn-searchset"><img src="{{ URL::asset('/assets/img/icons/search-white.svg')}}" alt="img"></a>
                        </div>
                    </div>
                    <div class="wordset">
                        <ul>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img src="{{ URL::asset('/assets/img/icons/pdf.svg')}}" alt="img"></a>
                            </li>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img src="{{ URL::asset('/assets/img/icons/excel.svg')}}" alt="img"></a>
                            </li>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img src="{{ URL::asset('/assets/img/icons/printer.svg')}}" alt="img"></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /Filter -->
                <div class="card" id="filter_inputs">
                    <div class="card-body pb-0">
                        <div class="row">
                            <div class="col-lg-2 col-sm-6 col-12">
                                <div class="form-group">
                                    <input type="text" placeholder="Store Name">
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-6 col-12">
                                <div class="form-group">
                                    <input type="text" placeholder="Enter Phone">
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-6 col-12">
                                <div class="form-group">
                                    <input type="text" placeholder="Enter Email">
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-6 col-12">
                                <div class="form-group">
                                    <select class="select">
                                        <option>Disable</option>
                                        <option>Enable</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-1 col-sm-6 col-12 ms-auto">
                                <div class="form-group">
                                    <a class="btn btn-filters ms-auto"><img src="{{ URL::asset('/assets/img/icons/search-whites.svg')}}" alt="img"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Filter -->
                <div class="table-responsive">
                    <table class="table  datanew">
                        <thead>
                            <tr>
                                <th>
                                    <label class="checkboxs">
                                        <input type="checkbox">
                                        <span class="checkmarks"></span>
                                    </label>
                                </th>
                                <th>Store name </th>
                                <th>User name </th>
                                <th>Phone</th>
                                <th>email</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <label class="checkboxs">
                                        <input type="checkbox" id="select-all">
                                        <span class="checkmarks"></span>
                                    </label>
                                </td>
                                <td>Thomas</td>
                                <td>Thomas21 </td>
                                <td>+12163547758 </td>
                                <td>thomas@example.com</td>
                                <td>
                                    <div class="status-toggle d-flex justify-content-between align-items-center">
                                        <input type="checkbox" id="user1" class="check" >
                                        <label for="user1" class="checktoggle">checkbox</label>
                                    </div>
                                </td>
                                <td>
                                        
                                    <a class="me-3" href="{{url('editstore')}}">
                                        <img src="{{ URL::asset('/assets/img/icons/edit.svg')}}" alt="img">
                                    </a>
                                    <a class="me-3 confirm-text" href="javascript:void(0);">
                                        <img src="{{ URL::asset('/assets/img/icons/delete.svg')}}" alt="img">
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="checkboxs">
                                        <input type="checkbox">
                                        <span class="checkmarks"></span>
                                    </label>
                                </td>
                                <td>Benjamin</td>
                                <td>504Benjamin </td>
                                <td>123-456-888</td>
                                <td>customer@example.com</td>
                                <td>
                                    <div class="status-toggle d-flex justify-content-between align-items-center">
                                        <input type="checkbox" id="user2" class="check" checked="">
                                        <label for="user2" class="checktoggle">checkbox</label>
                                    </div>
                                </td>
                                <td>
                                        
                                    <a class="me-3" href="{{url('editstore')}}">
                                        <img src="{{ URL::asset('/assets/img/icons/edit.svg')}}" alt="img">
                                    </a>
                                    <a class="me-3 confirm-text" href="javascript:void(0);">
                                        <img src="{{ URL::asset('/assets/img/icons/delete.svg')}}" alt="img">
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="checkboxs">
                                        <input type="checkbox">
                                        <span class="checkmarks"></span>
                                    </label>
                                </td>
                                <td>James</td>
                                <td>James 524 </td>
                                <td>+12163547758 </td>
                                <td>james@example.com</td>
                                <td>
                                    <div class="status-toggle d-flex justify-content-between align-items-center">
                                        <input type="checkbox" id="user3" class="check" checked="">
                                        <label for="user3" class="checktoggle">checkbox</label>
                                    </div>
                                </td>
                                <td>
                                        
                                    <a class="me-3" href="{{url('editstore')}}">
                                        <img src="{{ URL::asset('/assets/img/icons/edit.svg')}}" alt="img">
                                    </a>
                                    <a class="me-3 confirm-text" href="javascript:void(0);">
                                        <img src="{{ URL::asset('/assets/img/icons/delete.svg')}}" alt="img">
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="checkboxs">
                                        <input type="checkbox">
                                        <span class="checkmarks"></span>
                                    </label>
                                </td>
                                <td>Bruklin</td>
                                <td>Bruklin2022</td>
                                <td>123-456-888</td>
                                <td>bruklin@example.com</td>
                                <td>
                                    <div class="status-toggle d-flex justify-content-between align-items-center">
                                        <input type="checkbox" id="user4" class="check" checked="">
                                        <label for="user4" class="checktoggle">checkbox</label>
                                    </div>
                                </td>
                                <td>
                                        
                                    <a class="me-3" href="{{url('editstore')}}">
                                        <img src="{{ URL::asset('/assets/img/icons/edit.svg')}}" alt="img">
                                    </a>
                                    <a class="me-3 confirm-text" href="javascript:void(0);">
                                        <img src="{{ URL::asset('/assets/img/icons/delete.svg')}}" alt="img">
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="checkboxs">
                                        <input type="checkbox">
                                        <span class="checkmarks"></span>
                                    </label>
                                </td>
                                <td>Franklin</td>
                                <td>BeverlyWIN25</td>
                                <td>+12163547758 </td>
                                <td>Beverly@example.com</td>
                                <td>
                                    <div class="status-toggle d-flex justify-content-between align-items-center">
                                        <input type="checkbox" id="user5" class="check">
                                        <label for="user5" class="checktoggle">checkbox</label>
                                    </div>
                                </td>
                                <td>
                                        
                                    <a class="me-3" href="{{url('editstore')}}">
                                        <img src="{{ URL::asset('/assets/img/icons/edit.svg')}}" alt="img">
                                    </a>
                                    <a class="me-3 confirm-text" href="javascript:void(0);">
                                        <img src="{{ URL::asset('/assets/img/icons/delete.svg')}}" alt="img">
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="checkboxs">
                                        <input type="checkbox">
                                        <span class="checkmarks"></span>
                                    </label>
                                </td>
                                <td>B. Huber	</td>
                                <td>BeverlyWIN25</td>
                                <td>+12163547758 </td>
                                <td>Huber@example.com</td>
                                <td>
                                    <div class="status-toggle d-flex justify-content-between align-items-center">
                                        <input type="checkbox" id="user6" class="check">
                                        <label for="user6" class="checktoggle">checkbox</label>
                                    </div>
                                </td>
                                <td>
                                        
                                    <a class="me-3" href="{{url('editstore')}}">
                                        <img src="{{ URL::asset('/assets/img/icons/edit.svg')}}" alt="img">
                                    </a>
                                    <a class="me-3 confirm-text" href="javascript:void(0);">
                                        <img src="{{ URL::asset('/assets/img/icons/delete.svg')}}" alt="img">
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="checkboxs">
                                        <input type="checkbox">
                                        <span class="checkmarks"></span>
                                    </label>
                                </td>
                                <td>Alwin</td>
                                <td>Alwin243</td>
                                <td>+12163547758  </td>
                                <td>customer@example.com</td>
                                <td>
                                    <div class="status-toggle d-flex justify-content-between align-items-center">
                                        <input type="checkbox" id="user7" class="check">
                                        <label for="user7" class="checktoggle">checkbox</label>
                                    </div>
                                </td>
                                <td>
                                        
                                    <a class="me-3" href="{{url('editstore')}}">
                                        <img src="{{ URL::asset('/assets/img/icons/edit.svg')}}" alt="img">
                                    </a>
                                    <a class="me-3 confirm-text" href="javascript:void(0);">
                                        <img src="{{ URL::asset('/assets/img/icons/delete.svg')}}" alt="img">
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="checkboxs">
                                        <input type="checkbox">
                                        <span class="checkmarks"></span>
                                    </label>
                                </td>
                                <td>Fred john</td>
                                <td>FredJ25</td>
                                <td>+12163547758  </td>
                                <td>john@example.com</td>
                                <td>
                                    <div class="status-toggle d-flex justify-content-between align-items-center">
                                        <input type="checkbox" id="user15" class="check">
                                        <label for="user15" class="checktoggle">checkbox</label>
                                    </div>
                                </td>
                                <td>
                                        
                                    <a class="me-3" href="{{url('editstore')}}">
                                        <img src="{{ URL::asset('/assets/img/icons/edit.svg')}}" alt="img">
                                    </a>
                                    <a class="me-3 confirm-text" href="javascript:void(0);">
                                        <img src="{{ URL::asset('/assets/img/icons/delete.svg')}}" alt="img">
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="checkboxs">
                                        <input type="checkbox">
                                        <span class="checkmarks"></span>
                                    </label>
                                </td>
                                <td>Rasmussen	</td>
                                <td>Cras56</td>
                                <td>+12163547758   </td>
                                <td>Rasmussen@example.com</td>
                                <td>
                                    <div class="status-toggle d-flex justify-content-between align-items-center">
                                        <input type="checkbox" id="user9" class="check" checked>
                                        <label for="user9" class="checktoggle">checkbox</label>
                                    </div>
                                </td>
                                <td>
                                        
                                    <a class="me-3" href="{{url('editstore')}}">
                                        <img src="{{ URL::asset('/assets/img/icons/edit.svg')}}" alt="img">
                                    </a>
                                    <a class="me-3 confirm-text" href="javascript:void(0);">
                                        <img src="{{ URL::asset('/assets/img/icons/delete.svg')}}" alt="img">
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="checkboxs">
                                        <input type="checkbox">
                                        <span class="checkmarks"></span>
                                    </label>
                                </td>
                                <td>Grace	</td>
                                <td>Grace2022</td>
                                <td>+12163547758   </td>
                                <td>customer@example.com</td>
                                <td>
                                    <div class="status-toggle d-flex justify-content-between align-items-center">
                                        <input type="checkbox" id="user10" class="check" checked>
                                        <label for="user10" class="checktoggle">checkbox</label>
                                    </div>
                                </td>
                                <td>
                                        
                                    <a class="me-3" href="{{url('editstore')}}">
                                        <img src="{{ URL::asset('/assets/img/icons/edit.svg')}}" alt="img">
                                    </a>
                                    <a class="me-3 confirm-text" href="javascript:void(0);">
                                        <img src="{{ URL::asset('/assets/img/icons/delete.svg')}}" alt="img">
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="checkboxs">
                                        <input type="checkbox">
                                        <span class="checkmarks"></span>
                                    </label>
                                </td>
                                <td>Rasmussen	</td>
                                <td>Cras56</td>
                                <td>+12163547758   </td>
                                <td>Rasmussen@example.com</td>
                                <td>
                                    <div class="status-toggle d-flex justify-content-between align-items-center">
                                        <input type="checkbox" id="user19" class="check" checked>
                                        <label for="user19" class="checktoggle">checkbox</label>
                                    </div>
                                </td>
                                <td>
                                        
                                    <a class="me-3" href="{{url('editstore')}}">
                                        <img src="{{ URL::asset('/assets/img/icons/edit.svg')}}" alt="img">
                                    </a>
                                    <a class="me-3 confirm-text" href="javascript:void(0);">
                                        <img src="{{ URL::asset('/assets/img/icons/delete.svg')}}" alt="img">
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="checkboxs">
                                        <input type="checkbox">
                                        <span class="checkmarks"></span>
                                    </label>
                                </td>
                                <td>Grace	</td>
                                <td>Grace2022</td>
                                <td>+12163547758   </td>
                                <td>customer@example.com</td>
                                <td>
                                    <div class="status-toggle d-flex justify-content-between align-items-center">
                                        <input type="checkbox" id="user18" class="check" checked>
                                        <label for="user18" class="checktoggle">checkbox</label>
                                    </div>
                                </td>
                                <td>
                                        
                                    <a class="me-3" href="{{url('editstore')}}">
                                        <img src="{{ URL::asset('/assets/img/icons/edit.svg')}}" alt="img">
                                    </a>
                                    <a class="me-3 confirm-text" href="javascript:void(0);">
                                        <img src="{{ URL::asset('/assets/img/icons/delete.svg')}}" alt="img">
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /product list -->
    </div>
</div>
@endsection