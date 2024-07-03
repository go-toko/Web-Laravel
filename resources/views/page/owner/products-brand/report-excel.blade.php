<table>
    <thead>
        <tr>
            <th>No.</th>
            <th>Nama Merek</th>
            <th>Deskripsi</th>
            <th>Tanggal Dibuat</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($brands as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->description }}</td>
                <td>{{ Carbon\Carbon::create($item->created_at)->translatedFormat('d F Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
