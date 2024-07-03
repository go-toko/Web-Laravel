<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan List Menu</title>
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

        /* Style untuk tabel list menu */
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
        Laporan List Menu
    </div>

    <!-- Informasi laporan -->
    <div class="laporan-info">
        Aplikasi: Go-Toko<br>
        Laporan: List Menu<br>
        Dicetak oleh: {{ Auth::user()->userProfile->first_name . ' ' . Auth::user()->userProfile->last_name }}<br>
        Tanggal Cetak: {{ Carbon\Carbon::now()->format('d-m-Y') }}
    </div>

    <h3>Daftar Menu:</h3>

    <ul>
        @foreach ($roles as $role)
            <h4>{{ $role->name }}</h4>
            @if ($role->roleMenu->count() > 0)
                @foreach ($role->roleMenu as $roleMenu)
                    <li>
                        {{ $roleMenu->menu->name }}
                        @if ($roleMenu->menu->subMenu->count() > 0)
                            <ul>
                                @foreach ($roleMenu->menu->subMenu as $subMenu)
                                    <li>{{ $subMenu->name }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            @else
            Data Kosong
            @endif
        @endforeach
    </ul>

    <p><strong>Catatan:</strong> Di bawah setiap parent menu terdapat daftar sub menu.</p>
</body>

</html>
