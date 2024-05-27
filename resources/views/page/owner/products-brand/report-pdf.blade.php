<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan List Merek Produk</title>
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
        Laporan List Merek Produk
    </div>

    <!-- Informasi laporan -->
    <div class="laporan-info">
        Aplikasi: Go-Toko<br>
        Laporan: List Merek Produk<br>
        Toko: {{ Session::get('name') ?? 'Semua Toko' }}<br>
        Dicetak oleh: {{ Auth::user()->userProfile->first_name . ' ' . Auth::user()->userProfile->last_name }}<br>
        Tanggal Cetak: {{ Carbon\Carbon::now()->translatedFormat('d F Y') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Merek</th>
                <th>Deskripsi</th>
                <th>Tanggal Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($brands as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->description }}</td>
                    <td>{{ Carbon\Carbon::create($item->created_at)->translatedFormat('d F Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
