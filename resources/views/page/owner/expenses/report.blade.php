<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan List Pengeluaran</title>
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
        Laporan List Pengeluaran
    </div>

    <!-- Informasi laporan -->
    <div class="laporan-info">
        Aplikasi: Go-Toko<br>
        Laporan: List Pengeluaran<br>
        Periode Pengeluaran:
        {{ request()->query('startDate') ? request()->query('startDate') . ' sampai ' . request()->query('endDate') : 'Semua' }}<br>
        Dicetak oleh: {{ Auth::user()->userProfile->first_name . ' ' . Auth::user()->userProfile->last_name }}<br>
        Tanggal Cetak: {{ Carbon\Carbon::now()->translatedFormat('d F Y') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Pengeluaran Untuk</th>
                <th>Deskripsi</th>
                <th>Kategori</th>
                <th>Jumlah</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($expenses as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->description }}</td>
                    <td>{{ Str::title($item->category->name) }}</td>
                    <td>{{ 'Rp' . number_format($item->amount, 0, ',', '.') }}</td>
                    <td>{{ Carbon\Carbon::create($item->date)->translatedFormat('d F Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
