<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan List User</title>
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
        }

        table th {
            background-color: #eee;
            font-weight: bold;
            text-align: left;
        }

        table td {
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>

<body>
    <!-- Kop laporan -->
    <div class="laporan-kop">
        <img class="laporan-logo" src="{{ URL::asset('/assets/img/Pos-gotoko-black.png') }}" alt="Logo Aplikasi">
        Laporan Pembelian Langganan
    </div>

    <!-- Informasi laporan -->
    <div class="laporan-info">
        Aplikasi: Go-Toko<br>
        Laporan: Pembelian Langganan<br>
        Dicetak oleh: {{ Auth::user()->userProfile->first_name . ' ' . Auth::user()->userProfile->last_name }}<br>
        Tanggal Cetak: {{ Carbon\Carbon::now()->format('d M Y') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama User</th>
                <th>Nama Langganan</th>
                <th>Harga</th>
                <th>Jangka Waktu</th>
                <th>Waktu Berakhir</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->user->userProfile->first_name . ' ' . $item->user->userProfile->last_name }}</td>
                    <td>{{ $item->subscription_name }}</td>
                    <td>Rp. {{ $item->subscription_price }}</td>
                    <td>{{ $item->subscription_time }} bulan</td>
                    <td>{{ Carbon\Carbon::parse($item->expire)->format('d M Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
