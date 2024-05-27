<?php $page = 'menus'; ?>
@extends('layout.mainlayout')

@section('title', isset($data) ? 'Product Edit' : 'Product Add')

@section('forhead')
    {{-- Toastr Style --}}
    <link rel="stylesheet" href="{{ url('assets/plugins/toastr/toatr.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <div class="page-wrapper pagehead">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>@yield('title')</h4>
                    <h6>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('owner/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('owner/products/list') }}">Products</a></li>
                            <li class="breadcrumb-item active"> @yield('title') </li>
                        </ul>
                    </h6>
                </div>
            </div>

            {{-- Body Start --}}
            <div class="row">
                <div class="col-sm-12">
                    <section class="comp-section">
                        <div class="card-body">
                            <form
                                action="{{ isset($data) ? route('owner.products.update', Crypt::encrypt($data->id)) : route('owner.products.store') }}"
                                method="post" enctype="multipart/form-data">
                                @csrf
                                @if (isset($data))
                                    {{ method_field('put') }}
                                @endif
                                <div class="row">
                                    <div class="col-lg-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Category</label>
                                            <select name="category"
                                                class="form-control @error('category') is-invalid @enderror select"
                                                id="category">
                                                <option value="" disabled selected>Choose...</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        @if (old('category') == $category->id || (isset($data) && $data->category_id == $category->id)) selected @endif>
                                                        {{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('category')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6
                                    col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Brand</label>
                                            <select name="brand"
                                                class="form-control @error('brand') is-invalid @enderror select"
                                                id="brand">
                                                <option value="" disabled selected>Choose...</option>
                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand->id }}"
                                                        @if (old('brand') == $brand->id || (isset($data) && $data->brand_id == $brand->id)) selected @endif>
                                                        {{ $brand->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('brand')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input id="name" name="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror"
                                                value="{{ Str::headline(old('name') ?? ($data->name ?? null)) }}"
                                                autofocus>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- TODO: SKU auto generate ketika input name --}}
                                    <div class="col-lg-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>SKU</label>
                                            <input id="sku" name="sku" type="text"
                                                class="form-control @error('sku') is-invalid @enderror"
                                                value="{{ old('sku') ?? ($data->sku ?? null) }}">
                                            @error('sku')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- TODO: Buat price sesuai format Rp Indo --}}
                                    <div class="col-lg-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Buying Price</label>
                                            <input id="buying_price" name="buying_price" type="text"
                                                class="form-control @error('buying_price') is-invalid @enderror"
                                                value="{{ old('buying_price') ?? ($data->price_buy ?? null) }}">
                                            @error('buying_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Selling Price</label>
                                            <input id="selling_price" name="selling_price" type="text"
                                                class="form-control @error('selling_price') is-invalid @enderror"
                                                value="{{ old('selling_price') ?? ($data->price_sell ?? null) }}">
                                            @error('selling_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Quantity</label>
                                            <input id="quantity" name="quantity" type="text"
                                                class="form-control @error('quantity') is-invalid @enderror"
                                                value="{{ old('quantity') ?? ($data->quantity ?? null) }}">
                                            @error('quantity')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea id="description" name="description" class="form-control">{{ old('description') ?? ($data->description ?? null) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label> Product Image</label>
                                            <div class="image-upload">
                                                <input id="imageUpload" name="image" type="file"
                                                    class="form-control @error('image') is-invalid @enderror">
                                                <div class="image-uploads">
                                                    <img src="{{ URL::asset('assets/img/icons/upload.svg') }}"
                                                        alt="img">
                                                    <h4 id="imgNameUpload">Drag and drop a file to upload</h4>
                                                </div>
                                                @error('image')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-submit me-2">Submit</button>
                                        <a href="{{ URL::previous() }}" class="btn btn-cancel">Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('forscript')
    <script type="text/javascript">
        const input = document.getElementById('imageUpload');
        const name = document.getElementById('imgNameUpload');
        input.addEventListener('change', function() {
            const file = input.files[0];
            name.textContent = file.name;
        });
    </script>
    <script>
        $(window).ready(function() {
            $('.select').select2();
        })
    </script>
@endsection
