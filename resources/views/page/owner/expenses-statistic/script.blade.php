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

        function runChart(dataY, dataX, titleY = 'Jumlah Pengeluaran (Rp)', titleX = 'Bulan') {
            const colors = Array.from({
                length: dataY.length - 1
            }, () => `#${getRandomHex(6)}`);
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
                colors: ['#ff8800', ...colors],
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
            const chartExpense = new ApexCharts(document.querySelector('#expense-chart'),
                optionsChart)
            chartExpense.render();
        }

        function runSpinner() {
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
            let dataExpense;
            let category = 'all';
            let url =
                `{{ route('owner.pengeluaran.statistik.pengeluaran') }}?shop_id=${$('#shop_id').val()}&year=${$('#year').val()}&category=${$('#category').val() ?? category}`;
            await $.ajax({
                url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                success: function(data) {
                    dataExpense = data.expense;
                    runSpinner();
                }
            })
            setTimeout(() => {
                $('#expense-chart').empty();
                const dataY = Object.values(dataExpense);
                const dataX = dataExpense.total.data.map((value, index) => new Date(2023,
                    index, 1).toLocaleString(
                    'id-ID', {
                        month: 'long'
                    }))
                runChart(dataY, dataX)
            }, 250);
        }

        async function showDataMonth() {
            let dataExpense;
            const url =
                `{{ route('owner.pengeluaran.statistik.pengeluaran') }}?shop_id=${$('#shop_id').val()}&year=${$('#year').val()}&month=${$('#month').val()}&category=${$('#category').val()}`
            await $.ajax({
                url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                success: function(data) {
                    dataExpense = data.expense;
                    runSpinner();
                }
            })
            setTimeout(() => {
                $('#expense-chart').empty();
                const dataY = Object.values(dataExpense);
                const dataX = dataExpense.total.data.map((value, index) => index + 1)
                runChart(dataY, dataX, undefined, 'Tanggal')
            }, 250);
        }


        async function renderDataCategory() {
            const shopId = $('#shop_id').val();
            const url = `{{ route('owner.pengeluaran.statistik.kategori') }}?shop_id=${shopId}`;
            await $.ajax({
                url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                success: function(data) {
                    $('#category').empty();
                    data.category.length === 0 ? $('#category').append(
                        `<option value="null" selected disabled>Belum ada Kategori</option>`) : $(
                        '#category').append(
                        `<option value="all">Semua</option>`);
                    data?.category?.forEach(value => {
                        $('#category').append(
                            `<option value="${value.id}">${value.name.split(' ').map(name => name.charAt(0).toUpperCase() + name.slice(1)).join(' ')}</option>`
                        )
                    })
                }
            })
        }

        $(document).ready(async function() {
            try {
                await showDataYear();
                await renderDataCategory();
            } catch (error) {
                console.log(error);
            }
        })

        $(document).on('change', '#shop_id', async function() {
            await renderDataCategory();
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
