<table>
    <thead>
        <tr>
            <th>No.</th>
            <th>Nama Kategori</th>
            <th>Kode Unik</th>
            <th>Deskripsi</th>
            <th>Tanggal Dibuat</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($categories as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->code }}</td>
                <td>{{ $item->description }}</td>
                <td>{{ $item->created_at->format('d-m-Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
