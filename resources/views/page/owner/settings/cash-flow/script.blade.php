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

        function runChart(dataY, dataX, titleY = 'Jumlah Pengeluaran (Rp)', titleX = 'Bulan') {
            const optionsChart = {
                chart: {
                    height: 600,
                    type: 'area',
                    toolbar: {
                        show: true,
                    },
                    zoom: {
                        enabled: false
                    }
                },
                colors: ['#ff8800', '#3904cc'],
                dataLabels: {
                    enabled: true
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
            const chartExpense = new ApexCharts(document.querySelector('#cash-flow-chart'),
                optionsChart)
            chartExpense.render();
        }

        function runSpinner() {
            $('#cash-flow-chart').empty();
            $('#cash-flow-chart').append(`<div class="row">
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
            let dataCashFlow
            let url =
                `{{ route('owner.pengaturan.arus-kas.getData') }}?shop_id=${$('#shop_id').val()}&year=${$('#year').val()}`;
            await $.ajax({
                url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                success: function(data) {
                    dataCashFlow = data;
                    runSpinner();
                }
            })
            setTimeout(() => {
                $('#cash-flow-chart').empty();
                const dataY = Object.values(dataCashFlow);
                const dataX = dataCashFlow.expenses?.data?.map((value, index) => new Date(2023,
                    index, 1).toLocaleString(
                    'id-ID', {
                        month: 'long'
                    }))
                runChart(dataY, dataX, 'Jumlah (Rp)')
            }, 250);
        }

        async function showDataMonth() {
            let dataCashFlow;
            const url =
                `{{ route('owner.pengaturan.arus-kas.getData') }}?shop_id=${$('#shop_id').val()}&year=${$('#year').val()}&month=${$('#month').val()}`
            await $.ajax({
                url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                success: function(data) {
                    dataCashFlow = data;
                    runSpinner();
                }
            })
            setTimeout(() => {
                $('#cash-flow-chart').empty();
                const dataY = Object.values(dataCashFlow);
                const dataX = dataCashFlow.expenses?.data?.map((value, index) => index + 1)
                runChart(dataY, dataX, 'Jumlah (Rp)', 'Tanggal')
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

        $(document).on('change', '#category', async function() {
            $('#filter').val() === 'month' ? await showDataMonth() : await showDataYear();
        })
    </script>
@endsection
