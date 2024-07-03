<table>
    <thead>
        <tr>
            <th>No.</th>
            <th>Nama Produk</th>
            <th>Kategori</th>
            <th>Merek</th>
            <th>Deskripsi</th>
            <th>SKU</th>
            <th>Harga Beli</th>
            <th>Harga Jual</th>
            <th>Sisa Stok</th>
            <th>Terakhir perubahan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->category?->name }}</td>
                <td>{{ $item->brand?->name }}</td>
                <td>{{ $item->description }}</td>
                <td>{{ $item->sku }}</td>
                <td>{{ 'Rp' . number_format($item->price_buy) }}</td>
                <td>{{ 'Rp' . number_format($item->price_sell) }}</td>
                <td>{{ $item->quantity . ' ' . $item->unit }}</td>
                <td>{{ $item->updated_at->format('d-m-Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
