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
