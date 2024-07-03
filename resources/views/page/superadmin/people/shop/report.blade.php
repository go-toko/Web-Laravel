<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan List Toko</title>
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

        /* Style untuk tabel list Shop */
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
        <img class="laporan-logo" src="path/to/logo.png" alt="Logo Aplikasi">
        Laporan List Toko
    </div>

    <!-- Informasi laporan -->
    <div class="laporan-info">
        Aplikasi: Go-Toko<br>
        Laporan: List Toko<br>
        Dicetak oleh: {{ Auth::user()->userProfile->first_name . ' ' . Auth::user()->userProfile->last_name }}<br>
        Tanggal Cetak: {{ Carbon\Carbon::now()->format('d M Y') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Pemilik</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Telephone</th>
                <th>Alamat</th>
                <th>Status</th>
                <th>Dibuat Pada</th>
                <th>Diperbarui Pada</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($shops as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->user->userProfile->first_name . ' ' . $item->user->userProfile->last_name }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->user->email }}</td>
                    <td>{{ $item->user->userProfile->phone }}</td>
                    <td>
                        {{ $item?->address ? $item->address . ', ' . $item->village . ', ' . $item->district . ', ' . $item->regency . ', ' . $item->province : $item->village . ', ' . $item->district . ', ' . $item->regency . ', ' . $item->province }}
                    </td>
                    <td>{{ $item->isActive?'Aktif':'Tidak Aktif' }}</td>
                    <td>{{ Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</td>
                    <td>{{ Carbon\Carbon::parse($item->updated_at)->format('d M Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
