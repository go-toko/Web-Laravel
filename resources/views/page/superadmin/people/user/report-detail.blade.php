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
        Laporan Detail User
    </div>

    <!-- Informasi laporan -->
    <div class="laporan-info">
        Aplikasi: Go-Toko<br>
        Laporan: Detail User<br>
        Dicetak oleh: {{ Auth::user()->userProfile->first_name . ' ' . Auth::user()->userProfile->last_name }}<br>
        Tanggal Cetak: {{ Carbon\Carbon::now()->format('d M Y') }}
    </div>

    <h3>Profil User</h3>
    <table>
        <tr>
            <th>Nama Lengkap</th>
            <td>{{ $user->userProfile->first_name . ' ' . $user->userProfile->last_name }}</td>
        </tr>
        <tr>
            <th>Nama Panggilan</th>
            <td>{{ $user->userProfile->nickname ? $user->userProfile->nickname : '-' }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $user->email }}</td>
        </tr>
        <tr>
            <th>Nomor Hp</th>
            <td>{{ $user->userProfile->phone ? $user->userProfile->phone : '-' }}</td>
        </tr>
        <tr>
            <th>Jenis Kelamin</th>
            <td>{{ Str::ucfirst($user->userProfile->gender) }}</td>
        </tr>
        <tr>
            <th>Alamat</th>
            <td>{{ $user->userProfile->address ? $user->userProfile->address : '-' }}</td>
        </tr>
        <tr>
            <th>Tanggal Bergabung</th>
            <td>{{ Carbon\Carbon::parse($user->created_at)->format('d M Y') }}</td>
        </tr>
        <tr>
            <th>Role</th>
            <td>{{ Str::ucfirst($user->role->name) }}</td>
        </tr>
    </table>

    <h3>Profil Toko</h3>
    @if ($user->shop)

        @foreach ($shops as $shop)
            <li>{{ $shop->name }}</li>
            <span>Profil</span>
            <table>
                <tr>
                    <th>Nama Toko</th>
                    <td>{{ $shop->name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $shop->user->email ? $shop->user->email : '-' }}</td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td>
                        {{ $shop?->address ? $shop->address . ', ' . $shop->village . ', ' . $shop->district . ', ' . $shop->regency . ', ' . $shop->province : $shop->village . ', ' . $shop->district . ', ' . $shop->regency . ', ' . $shop->province }}
                    </td>
                </tr>
                <tr>
                    <th>Contact Person</th>
                    <td>{{ $shop->user->contact_person ? $shop->user->contact_person : '-' }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ $shop->description }}</td>
                </tr>
                <tr>
                    <th>Dibuat Tanggal</th>
                    <td>{{ Carbon\Carbon::parse($shop->created_at)->format('d M Y') }}</td>
                </tr>
            </table>
            <span>Produk</span>
            @if ($shop->product->count() > 0)
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
                </table>
            @else
            -
            @endif
        @endforeach
    @else
        Belum memiliki toko
    @endif

</body>

</html>
