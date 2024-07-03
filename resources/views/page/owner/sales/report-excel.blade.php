<table>
    <thead>
        <tr>
            <th>No.</th>
            <th>Tanggal</th>
            <th>Produk yang dibeli</th>
            <th>Total tagihan</th>
            <th>Total bayar</th>
            <th>Kembalian</th>
            <th>Metode Pembayaran</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($sales as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ Carbon\Carbon::create($item->created_at)->format('d-m-Y') }}</td>
                <td>{{ implode(
                    ', ',
                    array_map(function ($item) {
                        return $item['product']['name'] . ' (' . $item['quantity'] . ') ';
                    }, $item->detail->toArray()),
                ) }}
                </td>
                <td>{{ 'Rp' . number_format($item->total_bill) }}</td>
                <td>{{ 'Rp' . number_format($item->total_paid) }}</td>
                <td>{{ 'Rp' . number_format($item->changes) }}</td>
                <td>{{ $item->payment_method }}</td>
                <td>{{ $displayStatus[array_search($item->status, $status)] }}</td>
            </tr>
        @endforeach
    </tbody>
