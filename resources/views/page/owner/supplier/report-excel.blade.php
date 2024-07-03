<table>
    <thead>
        <tr>
            <th>No.</th>
            <th>Nama Supplier</th>
            <th>No Telepon</th>
            <th>Alamat</th>
            <th>Deskripsi</th>
            <th>Status</th>
            <th>Terakhir perubahan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($suppliers as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->phone }}</td>
                <td>{{ $item->address }}</td>
                <td>{{ $item->description }}</td>
                <td>{{ $item->isActive ? 'Aktif' : 'Non Aktif' }}</td>
                <td>{{ $item->updated_at->format('d-m-Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
