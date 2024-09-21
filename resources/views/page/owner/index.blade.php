<?php $page = 'menus'; ?>
@extends('layout.mainlayout')

@section('title', 'Dashboard')

@section('forhead')
    {{-- Toastr Style --}}
    <link rel="stylesheet" href="{{ url('assets/plugins/toastr/toatr.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@php
    $months = [
        'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember',
    ];
    $monthNow = Carbon\Carbon::now()->month;
@endphp

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
            </div>
            {{-- Body Start --}}
            @if (Session::has('active'))
                <div class="row">
                    <div class="col-lg-3 col-sm-6 col-12 d-flex">
                        <div class="dash-count">
                            <div class="dash-counts">
                                <h4>{{ $totalCashier }}</h4>
                                <h5>Total Kasir</h5>
                            </div>
                            <div class="dash-imgs">
                                <i data-feather="user"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12 d-flex">
                        <div class="dash-count das1">
                            <div class="dash-counts">
                                <h4>{{ $totalSupplier }}</h4>
                                <h5>Total Supplier</h5>
                            </div>
                            <div class="dash-imgs">
                                <i data-feather="user-check"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12 d-flex">
                        <div class="dash-count das2">
                            <div class="dash-counts">
                                <h4>{{ $totalProduct }}</h4>
                                <h5>Total Barang</h5>
                            </div>
                            <div class="dash-imgs">
                                <i data-feather="file-text"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12 d-flex">
                        <div class="dash-count das3">
                            <div class="dash-counts">
                                <h4>{{ $totalExpense }}</h4>
                                <h5>Jumlah Pengeluaran</h5>
                            </div>
                            <div class="dash-imgs">
                                <i data-feather="file"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header pb-0">
                                <h5 class="card-title mb-0">Penjualan dan Pengeluaran</h5>
                            </div>
                            <div class="card-body">
                                <div class="row justify-content-between">
                                    <div class="col-2">
                                        <div class="form-group">
                                            <select name="monthFilter" id="monthFilter"
                                                class="select @error('monthFilter') is-invalid @enderror">
                                                @foreach ($months as $index => $month)
                                                    <option value="{{ $index + 1 }}"
                                                        @if ($monthNow == $index + 1) selected @endif>
                                                        {{ $month }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-between">
                                    <div id="sale-chart" class="col-md-6"></div>
                                    <div id="expense-chart" class="col-md-6"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-md-6">
                        <div class="card">
                            <div class="card-header pb-0">
                                <h5 class="card-title mb-0">Pengeluaran</h5>
                            </div>
                            <div class="card-body">
                                <div class="row justify-content-between">
                                    <div class="col-3" id="monthFieldExpense">
                                        <div class="form-group">
                                            <select name="monthExpense" id="monthExpense"
                                                class="select @error('monthExpense') is-invalid @enderror">
                                                @foreach ($months as $index => $month)
                                                    <option value="{{ $index + 1 }}"
                                                        @if ($monthNow == $index + 1) selected @endif>
                                                        {{ $month }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group text-end">
                                            <div class="btn btn-primary" id="moreExpense">Selengkapnya</div>
                                        </div>
                                    </div>
                                </div>
                                <div id="expense-chart"></div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            @else
                <div class="row">
                    <div class="col-12">
                        <section class="comp-section">
                            <div class="row d-flex">
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Search</label>
                                        <input id="search" name="search" type="text"
                                            class="form-control @error('search') is-invalid @enderror"
                                            value="{{ request()->get('search') ?? null }}" autofocus
                                            placeholder="Masukkan nama toko">
                                        @error('search')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-3" style="margin-top: 27px">
                                    <div class="form-group d-flex align-items-center gap-3">
                                        <a class="btn btn-filters" id="filter"><img
                                                src="{{ URL::asset('assets/img/icons/search-whites.svg') }}" alt="img"
                                                data-bs-toggle="tooltip" title="Filter"></a>
                                        <a class="btn btn-filters" id="resetFilter"><i class="fa fa-undo"
                                                data-bs-toggle="tooltip" title="Reset Filter"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex">
                                @foreach ($shops as $shop)
                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                        <div class="card flex-fill bg-white">
                                            <div class="card-header d-flex justify-content-between">
                                                <h5 class="card-title mb-0">{{ $shop->name }}</h5>
                                                <div
                                                    class="status-toggle d-flex justify-content-between align-items-center">
                                                    <input type="checkbox" id="user3" class="check" checked="">
                                                    <label for="user3" class="checktoggle">checkbox</label>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text">{{ $shop->description }}</p>
                                                <a class="btn btn-primary"
                                                    href="{{ route('owner.setSession', Crypt::encrypt($shop->id)) }}">Manage</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    </div>
                </div>
            @endif
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

    @if ($type != null)
        <script>
            let type = {!! json_encode($type) !!};
            let msg = {!! json_encode($msg) !!};
            const title = {!! json_encode($title) !!};
            toastr[type](msg, title)
        </script>
    @endif

    <script>
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? prefix + rupiah : '');
        }
    </script>

    {{-- script statistic expense --}}
    <script>
        function runChartExpense(dataY, dataX, titleY = 'Jumlah Pengeluaran (Rp)', titleX = 'Bulan') {
            const optionsChartExpense = {
                chart: {
                    height: 350,
                    type: 'area',
                    toolbar: {
                        show: true,
                    },
                    zoom: {
                        enabled: false
                    }
                },
                colors: ['#ff8800'],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },
                series: [...dataY],
                xaxis: {
                    categories: dataX,
                    title: {
                        text: titleX
                    }
                },
                yaxis: {
                    title: {
                        text: titleY
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return formatRupiah(`${val}`, 'Rp')
                        }
                    }
                }
            }
            const chartExpense = new ApexCharts(document.querySelector('#expense-chart'),
                optionsChartExpense)
            chartExpense.render();
        }

        function runSpinnerExpense() {
            $('#expense-chart').empty();
            $('#expense-chart').append(`<div class="row">
                            <div class="col-2 mx-auto">
                                <div class="d-flex align-items-center justify-content-between">
                                    <strong>Loading...</strong>
                                    <div class="spinner-border" role="status" aria-hidden="true"></div>
                                </div>
                            </div>
                        </div>`)
        }

        async function showDataMonthExpense() {
            let dataExpense;
            const url =
                `{{ route('owner.getExpenses') }}?month=${$('#monthFilter').val()}`
            await $.ajax({
                url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                success: function(data) {
                    dataExpense = data.expense;
                    runSpinnerExpense();
                }
            })
            setTimeout(() => {
                $('#expense-chart').empty();
                const dataY = Object.values(dataExpense);
                const dataX = dataExpense.total.data.map((value, index) => index + 1)
                runChartExpense(dataY, dataX, undefined, 'Tanggal')
            }, 250);
        }
    </script>

    {{-- script statistic sale --}}
    <script>
        function runChartSale(dataY, dataX, titleY = 'Jumlah Penjualan (Rp)', titleX = 'Bulan') {
            const optionsChartSale = {
                chart: {
                    height: 350,
                    type: 'area',
                    toolbar: {
                        show: true,
                    },
                    zoom: {
                        enabled: false
                    }
                },
                colors: ['#4361ee'],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'straight'
                },
                series: [...dataY],
                xaxis: {
                    categories: dataX,
                    title: {
                        text: titleX
                    }
                },
                yaxis: {
                    title: {
                        text: titleY
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return formatRupiah(`${val}`, 'Rp')
                        }
                    }
                }
            }
            const chartSale = new ApexCharts(document.querySelector('#sale-chart'),
                optionsChartSale)
            chartSale.render();
        }

        function runSpinnerSale() {
            $('#sale-chart').empty();
            $('#sale-chart').append(`<div class="row">
                        <div class="col-2 mx-auto">
                            <div class="d-flex align-items-center justify-content-between">
                                <strong>Loading...</strong>
                                <div class="spinner-border" role="status" aria-hidden="true"></div>
                            </div>
                        </div>
                    </div>`)
        }

        async function showDataMonthSale() {
            let dataSale;
            const url =
                `{{ route('owner.getSales') }}?month=${$('#monthFilter').val()}`
            await $.ajax({
                url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                success: function(data) {
                    dataSale = data.sales;
                    runSpinnerSale();
                }
            })
            setTimeout(() => {
                $('#sale-chart').empty();
                const dataY = Object.values(dataSale);
                const dataX = dataSale.total.data.map((value, index) => index + 1)
                runChartSale(dataY, dataX, undefined, 'Tanggal')
            }, 250);
        }

        $(document).on('change', '#monthFilter', async function() {
            try {
                showDataMonthSale();
                showDataMonthExpense();
            } catch (error) {
                console.log(error);
            }
        })
    </script>
    @if (Session::has('active'))
        <script>
            $(document).ready(async function() {
                try {
                    showDataMonthExpense();
                    showDataMonthSale();
                } catch (error) {
                    console.log(error);
                }
            })
        </script>
    @endif

    <script>
        $(document).on('click', '#filter', function() {
            const searchToko = $('#search').val() ?? undefined;

            const url = `{{ route('owner.dashboard') }}?search=${searchToko}`
            window.location.href = url;
        })
        $(document).on('click', '#resetFilter', function() {
            const url = `{{ route('owner.dashboard') }}`
            window.location.href = url;
        })
    </script>
@endsection
