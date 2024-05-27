<?php $page = 'menus'; ?>
@extends('layout.mainlayout')

@section('title', isset($data) ? 'Product Edit Brand' : 'Product Add Brand')

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
                            <li class="breadcrumb-item"><a href="{{ url('owner/products/brand') }}">Brand</a></li>
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
                                action="{{ isset($data) ? route('owner.products.brand.update', Crypt::encrypt($data->id)) : route('owner.products.brand.store') }}"
                                method="post" enctype="multipart/form-data">
                                @csrf
                                @if (isset($data))
                                    {{ method_field('put') }}
                                @endif
                                <div class="row">
                                    <div class="col-lg-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Brand Name</label>
                                            <input id="name" name="name" type="text"
                                                class="form-control @error('name')
                                                is-invalid
                                            @enderror"
                                                autofocus value="{{ old('name') ?? ($data->name ?? null) }}"required>
                                            @error('name')
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
                                                <input id="imageUpload" class="@error('image') is-invalid @enderror"
                                                    name="image" type="file">
                                                <div class="image-uploads">
                                                    <img src="{{ URL::asset('assets/img/icons/upload.svg') }}"
                                                        alt="img">
                                                    <h4 id="img-upload">Drag and drop a file to upload</h4>
                                                </div>
                                                @error('image')
                                                    <div class="text-danger">{{ $message }}</div>
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

<script type="text/javascript">
    const input = document.getElementById('imageUpload');
    const name = document.getElementById('img-upload');
    input.addEventListener('change', function() {
        const file = input.files[0];
        name.textContent = file.name;
    });
</script>
