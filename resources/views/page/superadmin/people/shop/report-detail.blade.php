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

        /* Style untuk tabel list Toko */
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
        <img class="laporan-logo" src="path/to/logo.png" alt="Logo Aplikasi">
        Laporan Detail Toko
    </div>

    <!-- Informasi laporan -->
    <div class="laporan-info">
        Aplikasi: Go-Toko<br>
        Laporan: Detail Toko<br>
        Dicetak oleh: {{ Auth::user()->userProfile->first_name . ' ' . Auth::user()->userProfile->last_name }}<br>
        Tanggal Cetak: {{ Carbon\Carbon::now()->format('d M Y') }}
    </div>

    <h3>List Toko</h3>
    <table>
        <tr>
            <th>Pemilik Toko</th>
            <td>{{ $shop->user->userProfile->first_name . ' ' . $shop->user->userProfile->last_name }}</td>
        </tr>
        <tr>
            <th>Nama</th>
            <td>{{ $shop->name ? $shop->name : '-' }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $shop->email }}</td>
        </tr>
        <tr>
            <th>Nomor Hp</th>
            <td>{{ $shop->contact_person ? $shop->contact_person : '-' }}</td>
        </tr>
        <tr>
            <th>Alamat</th>
            <td>{{ $shop->address ? $shop->address : '-' }}</td>
        </tr>
        <tr>
            <th>Dibuat Pada</th>
            <td>{{ Carbon\Carbon::parse($shop->created_at)->format('d M Y') }}</td>
        </tr>
        <tr>
            <th>Diperbarui Pada</th>
            <td>{{ Carbon\Carbon::parse($shop->updated_at)->format('d M Y') }}</td>
        </tr>
    </table>

    <h3>List Produk</h3>
    <table>
        <tr>
            <th>No</th>
            <th>Produk</th>
            <th>Brand</th>
            <th>Kategori</th>
            <th>Harga Jual</th>
            <th>Harga Beli</th>
            <th>Dibuat Tanggal</th>
        </tr>
        @if ($shop->product->count() != 0)
            @foreach ($shop->product as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->brand->name }}</td>
                    <td>{{ $item->category->name }}</td>
                    <td>{{ $item->price_buy }}</td>
                    <td>{{ $item->price_sell }}</td>
                    <td>{{ Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                Belum ada produk
            </tr>
        @endif
    </table>
</body>

</html>
