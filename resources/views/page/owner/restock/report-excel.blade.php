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
