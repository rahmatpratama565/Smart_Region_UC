<h2>Rekap Laporan Wilayah</h2>

<table border="1" width="100%" cellpadding="5">
    <thead>
        <tr>
            <th>No</th>
            <th>Petugas</th>
            <th>Wilayah</th>
            <th>Jenis Data</th>
            <th>Target</th>
            <th>Realisasi</th>
            <th>Progress</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>

        @foreach($data as $d)

        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $d->petugas->name }}</td>
            <td>{{ $d->nama_wilayah }}</td>
            <td>{{ $d->jenis_data }}</td>
            <td>{{ $d->target }}</td>
            <td>{{ $d->nilai_data }}</td>
            <td>{{ round($d->progress) }}%</td>
            <td>{{ $d->status_validasi }}</td>
        </tr>

        @endforeach

    </tbody>

</table>