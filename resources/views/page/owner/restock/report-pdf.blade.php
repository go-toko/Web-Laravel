<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan List Penjualan</title>
    <style>
        /* Style untuk kop laporan */
        .laporan-kop {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        /* Style untuk logo aplikasi */
        .laporan-logo {
            float: left;
            width: 100px;
            height: 100px;
            margin-right: 20px;
        }

        /* Style untuk informasi laporan */
        .laporan-info {
            margin-bottom: 20px;
            clear: both;
        }

        /* Style untuk tabel list user */
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        table th,
        table td {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
        }

        table th {
            background-color: #eee;
            font-weight: bold;
        }

        table td {
            font-size: 14px;
        }
    </style>
</head>

<body>
    <!-- Kop laporan -->
    <div class="laporan-kop">
        <img class="laporan-logo" src="{{ URL::asset('assets/img/Pos-gotoko-black.png') }}" alt="Logo Aplikasi">
        Laporan List Penjualan
    </div>

    <!-- Informasi laporan -->
    <div class="laporan-info">
        Aplikasi: Go-Toko<br>
        Laporan: List Penjualan<br>
        Periode Penjualan:
        {{ request()->query('startDate') ? request()->query('startDate') . ' sampai ' . request()->query('endDate') : 'Semua' }}<br>
        Dicetak oleh: {{ Auth::user()->userProfile->first_name . ' ' . Auth::user()->userProfile->last_name }}<br>
        Tanggal Cetak: {{ Carbon\Carbon::now()->format('d-m-Y') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Pelanggan</th>
                <th>Tanggal</th>
                <th>Produk yang dibeli</th>
                <th>Total harga</th>
                <th>Total bayar</th>
                <th>Kembalian</th>
                <th>Metode Pembayaran</th>
                <th>Status Pembayaran</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->cashier->userCashierProfile->name }}</td>
                    <td>{{ Carbon\Carbon::createFromFormat('Y-m-d', $item->date)->format('d-m-Y') }}</td>
                    <td>{{ implode(
                        ', ',
                        array_map(function ($item) {
                            return $item['product']['name'] . ' (' . $item['quantity'] . ') ';
                        }, $item->detail->toArray()),
                    ) }}
                    </td>
                    <td>{{ 'Rp' . number_format($item->total) }}</td>
                    <td>{{ 'Rp' . number_format($item->paid) }}</td>
                    <td>{{ 'Rp' . number_format($item->change) }}</td>
                    <td>{{ $item->payment_method }}</td>
                    <td>{{ $item->payment_status }}</td>
                    <td>{{ $item->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
