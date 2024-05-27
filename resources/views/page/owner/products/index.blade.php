<?php $page = 'menus'; ?>
@extends('layout.mainlayout')

@section('title', 'Products List')

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
                            <li class="breadcrumb-item active"> @yield('title') </li>
                        </ul>
                    </h6>
                </div>
                <div class="page-btn">
                    <a href="{{ route('owner.products.add') }}" class="btn btn-added">
                        <img src="{{ URL::asset('assets/img/icons/plus.svg') }}" class="me-1" alt="img">Add Product
                    </a>
                </div>
            </div>

            {{-- Body Start --}}
            <div class="row">
                <div class="col-sm-12">
                    <section class="comp-section">
                        <div class="table-responsive" id="table-data">
                            <table class="table datanew">
                                <thead>
                                    <tr>
                                        <th class="col-0">
                                            <label class="checkboxs">
                                                <input type="checkbox" id="select-all" />
                                                <span class="checkmarks"></span>
                                            </label>
                                        </th>
                                        <th class="col-2">Name</th>
                                        <th class="col-3">Description</th>
                                        <th class="col-1">Category</th>
                                        <th class="col-1">Brand</th>
                                        <th class="col-1">SKU</th>
                                        <th class="col-1">Quantity</th>
                                        <th class="col-1">Buying Price</th>
                                        <th class="col-1">Selling Price</th>
                                        <th class="col-1">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>
                                                <label class="checkboxs">
                                                    <input type="checkbox" />
                                                    <span class="checkmarks"></span>
                                                </label>
                                            </td>
                                            <td class="productimgname">
                                                <a href="javascript:void(0);" class="product-img">
                                                    @if ($product->images != 'noimage.png')
                                                        <img src="{{ URL::asset('images/products/' . $product->images) }}"
                                                            alt="{{ Str::headline($product->name) }}" />
                                                    @elseif ($product->images == 'noimage.png')
                                                        <img src="{{ URL::asset('images/' . $product->images) }}"
                                                            alt="{{ Str::headline($product->name) }}" />
                                                    @endif

                                                </a>
                                                {{ Str::headline($product->name) }}
                                            </td>
                                            <td>{{ $product->description }}</td>
                                            <td>{{ $product->category->name }}</td>
                                            <td>{{ $product->brand->name }}</td>
                                            <td>{{ $product->sku }}</td>
                                            <td>{{ $product->quantity }}</td>
                                            <td>{{ $product->price_buy }}</td>
                                            <td>{{ $product->price_sell }}</td>
                                            <td>
                                                <a class="me-3"
                                                    href="{{ route('owner.products.edit', ['id' => Crypt::encrypt($product->id)]) }}">
                                                    <img src="{{ URL::asset('assets/img/icons/edit.svg') }}"
                                                        alt="img" />
                                                </a>
                                                <a class="me-3" id="confirm-delete"
                                                    data-action="{{ route('owner.products.delete', ['id' => Crypt::encrypt($product->id)]) }}">
                                                    <img src="{{ URL::asset('assets/img/icons/delete.svg') }}"
                                                        alt="img" />
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

@endsection
<?php
$title = e($__env->yieldContent('title'));
$type = Session::get('type');
$msg = Session::get($type);
// dd($type);
?>

@section('forscript')
    {{-- Toast import js --}}
    <script src="{{ URL::asset('/assets/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/plugins/toastr/toastr.js') }}"></script>

    <script>
        let type = {!! json_encode($type) !!};
        let msg = {!! json_encode($msg) !!};
        const title = {!! json_encode($title) !!};
        @if (Session::has($type))
            {
                toastr[type](msg, title, {
                    closeButton: !0,
                    tapToDismiss: !1,
                    positionClass: 'toast-top-center',
                })
            }
        @endif
        // @if (Session::has('success'))
        //     {
        //         toastr.success("{!! Session::get('success') !!}", "Category", {
        //             closeButton: !0,
        //             tapToDismiss: !1,
        //             positionClass: 'toast-top-center',
        //         });
        //     }
        // @endif
    </script>
    <script>
        $(document).on('click', '#confirm-delete', function(event) {
            event.preventDefault();
            const url = $(this).data('action');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'DELETE',
                        success: function(data) {
                            Swal.fire({
                                title: 'Deleted!',
                                text: data.msg,
                                icon: 'success',
                                timer: 1500,
                                showConfirmButton: false
                            });
                            // location.reload();
                            $('#table-data').load(`${window.location.href}#table-data`);
                        },
                        error: function(data) {
                            Swal.fire({
                                title: 'Oops...',
                                text: data.msg,
                                icon: 'error',
                                confirmButtonColor: '#dc3545'
                            })
                        }
                    });
                }
            });
        });
    </script>
@endsection
