<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">

    <style>
    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 12px;
        margin: 60px 50px;
    }

    /* KOP SURAT */

    .kop {
        border-bottom: 3px solid black;
        padding-bottom: 10px;
        margin-bottom: 25px;
    }

    .kop-table {
        width: 100%;
    }

    .logo {
        width: 90px;
    }

    .kop-text {
        text-align: center;
    }

    .instansi {
        font-size: 18px;
        font-weight: bold;
    }

    .subinstansi {
        font-size: 14px;
    }

    /* JUDUL LAPORAN */

    .judul {
        text-align: center;
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .subjudul {
        text-align: center;
        margin-bottom: 25px;
    }

    /* TABEL */

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        background: #f2f2f2;
    }

    th,
    td {
        border: 1px solid black;
        padding: 6px;
        text-align: center;
    }

    /* FOOTER */

    .footer {
        position: fixed;
        bottom: 15px;
        left: 0;
        right: 0;
        text-align: center;
        font-size: 11px;
    }
    </style>

</head>

<body>

    <!-- KOP INSTANSI -->

    <div class="kop">

        <table class="kop-table">

            <tr>

                <td width="15%">
                    <img src="{{ public_path('logo.png') }}" class="logo">
                </td>

                <td class="kop-text">

                    <div class="instansi">
                        Pemerintah Provinsi Sulawesi Tengah
                    </div>

                    <div class="subinstansi">
                        Gubernur Provinsi Sulawesi Tengah
                    </div>

                    <div class="subinstansi">
                        Sistem Monitoring Wilayah SmartRegion
                    </div>

                </td>

                <td width="15%"></td>

            </tr>

        </table>

    </div>

    <!-- JUDUL LAPORAN -->

    <div class="judul">
        LAPORAN MONITORING WILAYAH
    </div>

    <div class="subjudul">
        Tanggal Cetak : {{ date('d M Y') }}
    </div>

    <!-- TABEL LAPORAN -->

    <table>

        <thead>

            <tr>
                <th>No</th>
                <th>Petugas</th>
                <th>Wilayah</th>
                <th>Jenis Data</th>
                <th>Progress</th>
                <th>Tanggal</th>
            </tr>

        </thead>

        <tbody>

            @foreach($data as $d)

            <tr>

                <td>{{ $loop->iteration }}</td>

                <td>{{ $d->petugas->name }}</td>

                <td>{{ $d->nama_wilayah }}</td>

                <td>{{ $d->jenis_data }}</td>

                <td>{{ $d->progress }}%</td>

                <td>{{ $d->tanggal_input }}</td>

            </tr>

            @endforeach

        </tbody>

    </table>

    <!-- FOOTER HALAMAN -->

    <div class="footer">

        <script type="text/php">

            if (isset($pdf)) {

$font = $fontMetrics->get_font("Arial","normal");

$pdf->page_text(260, 820, "Halaman {PAGE_NUM} / {PAGE_COUNT}", $font, 10);

}

</script>

    </div>

</body>

</html>