<?php $page = 'menus'; ?>
@extends('layout.mainlayout')

@section('title', 'Laba Penjualan')

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
            </div>

            {{-- Body Start --}}
            <div class="row">
                <div class="col-sm-12">
                    <section class="comp-section">
                        <div class="row">
                            <div class="col-6 col-lg-2">
                                <div class="form-group">
                                    <label>Toko</label>
                                    <select name="shop_id" id="shop_id"
                                        class="select @error('shop_id') is-invalid @enderror">
                                        <option value="null" selected disabled>-- Select --</option>
                                        @foreach ($shops as $shop)
                                            <option value="{{ $shop->id }}"
                                                {{ $shop->id == $latest_shop_id ? 'selected' : '' }}>
                                                {{ Str::ucfirst($shop->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 col-lg-2">
                                <div class="form-group">
                                    <label>Tampilkan berdasarkan</label>
                                    <select name="filter" id="filter"
                                        class="select @error('filter') is-invalid @enderror">
                                        <option value="null" selected disabled>-- Select --</option>
                                        <option value="year" selected>Tahun</option>
                                        <option value="month">Bulan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 col-lg-2" id="yearField">
                                <div class="form-group">
                                    <label>Tahun</label>
                                    <input id="year" year="year" type="number" min="1900" max="2200"
                                        maxlength="4" class="form-control @error('year') is-invalid @enderror"
                                        value="{{ Carbon\Carbon::now()->year }}">
                                    @error('year')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6 col-lg-2 d-none" id="monthField">
                                <div class="form-group">
                                    <label>Bulan</label>
                                    <select name="month" id="month"
                                        class="select @error('month') is-invalid @enderror">
                                        @php
                                            $months = [
                                                'January',
                                                'February',
                                                'March',
                                                'April',
                                                'May',
                                                'June',
                                                'July',
                                                'August',
                                                'September',
                                                'October',
                                                'November',
                                                'December',
                                            ];
                                        @endphp
                                        @foreach ($months as $index => $month)
                                            <option value="{{ $index + 1 }}">{{ $month }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div id="sales-chart">
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

        function getRandomHex(length) {
            var hex = '';
            for (var i = 0; i < length; i++) {
                hex += Math.floor(Math.random() * 16).toString(16);
            }
            return hex;
        }

        function runChart(dataY, dataX, titleY = 'Jumlah Penjualan (Rp)', titleX = 'Bulan') {
            const colors = Array.from({
                length: dataY.length - 1
            }, () => `#${getRandomHex(6)}`);
            const optionsChart = {
                chart: {
                    height: 600,
                    type: 'bar',
                    toolbar: {
                        show: false,
                    },
                    zoom: {
                        enabled: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '80%',
                        endingShape: 'rounded',
                    },
                },
                // colors: ['#ff8800', ...colors],
                dataLabels: {
                    enabled: true
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
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
                fill: {
                    opactiy: 1,
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return formatRupiah(`${val}`, 'Rp')
                        }
                    }
                }
            }
            const chartExpense = new ApexCharts(document.querySelector('#sales-chart'),
                optionsChart)
            chartExpense.render();
        }

        function runSpinner() {
            $('#sales-chart').empty();
            $('#sales-chart').append(`<div class="row">
                        <div class="col-2 mx-auto">
                            <div class="d-flex align-items-center justify-content-between">
                                <strong>Loading...</strong>
                                <div class="spinner-border" role="status" aria-hidden="true"></div>
                            </div>
                        </div>
                    </div>`)
        }

        function showField(...idField) {
            idField.forEach(id => {
                $(`#${id}`).removeClass('d-none')
            })
        }

        function hideField(...idField) {
            idField.forEach(id => {
                $(`#${id}`).addClass('d-none')
            })
        }

        async function showDataYear() {
            let dataProfit;
            let url =
                `{{ route('owner.penjualan.laba-penjualan.laba') }}?shop_id=${$('#shop_id').val()}&year=${$('#year').val()}`;
            console.log(url);
            await $.ajax({
                url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                success: function(data) {
                    dataProfit = data.profit;
                    runSpinner();
                }
            })
            setTimeout(() => {
                $('#sales-chart').empty();
                const dataY = Object.values(dataProfit);
                const dataX = dataProfit.total.data.map((value, index) => new Date(2023,
                    index, 1).toLocaleString(
                    'id-ID', {
                        month: 'long'
                    }))
                runChart(dataY, dataX)
            }, 250);
        }

        async function showDataMonth() {
            let dataProfit;
            const url =
                `{{ route('owner.penjualan.laba-penjualan.laba') }}?shop_id=${$('#shop_id').val()}&year=${$('#year').val()}&month=${$('#month').val()}`
            await $.ajax({
                url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                success: function(data) {
                    dataProfit = data.profit;
                    runSpinner();
                }
            })
            setTimeout(() => {
                $('#sales-chart').empty();
                const dataY = Object.values(dataProfit);
                const dataX = dataProfit.total.data.map((value, index) => index + 1)
                runChart(dataY, dataX, undefined, 'Tanggal')
            }, 250);
        }

        $(document).ready(async function() {
            showDataYear();
        })

        $(document).on('change', '#shop_id', async function() {
            await showDataYear();
            showField('yearField');
            hideField('monthField');
            $('#filter').empty();
            $('#filter').append(`<option value="null" selected disabled>-- Select --</option>
                                    <option value="year" selected>Tahun</option>
                                    <option value="month">Bulan</option>`);
        })

        $(document).on('change', '#filter', async function() {
            if ($(this).val() === 'year') {
                showField('yearField');
                hideField('monthField');
                await showDataYear();
            }
            if ($(this).val() === 'month') {
                showField('yearField', 'monthField');
                await showDataMonth();
            }
        })

        $(document).on('change', '#year', async function() {
            $('#filter').val() === 'month' ? await showDataMonth() : await showDataYear();
        })

        $(document).on('change', '#month', async function() {
            await showDataMonth();
        })
    </script>
@endsection
