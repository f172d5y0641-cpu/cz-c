<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Berita Acara Pemeriksaan Pekerjaan</title>
    <style>
        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 13px;
            color: #111;
            line-height: 1.5;
            margin: 40px;
            position: relative;
        }

        h2 {
            text-align: center;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .nomor {
            text-align: center;
            margin-bottom: 25px;
        }

        .content p {
            text-align: justify;
            margin: 8px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            text-align: center;
        }

        .footer {
            margin-top: 30px;
        }

        .footer table {
            width: 100%;
            border: none;
        }

        .footer td {
            border: none;
            vertical-align: top;
            text-align: center;
        }

        #vendor-information {
            width: 75%;
        }

        #vendor-information td,
        #vendor-information th {
            border: 0 !important;
            text-align: left !important;
            background-color: transparent !important;
        }

        .signature-stamp {
            position: absolute;
            width: 160px;
            height: auto;
            z-index: 10;
        }
    </style>
</head>

<body>
    @if (!empty($signature['path'] ?? null))
        <img src="{{ $signature['path'] }}" class="signature-stamp"
            style="left: {{ $signature['left'] ?? 0 }}%; top: {{ $signature['top'] ?? 0 }}%; width: {{ $signature['width'] ?? 160 }}px;">
    @endif

    <h2>BERITA ACARA PEMERIKSAAN PEKERJAAN</h2>
    <div class="nomor">
        Nomor: {{ $dokumen->nomor_kontrak ?? '.../BA-PP/.../...' }}
    </div>

    <div class="content">
        <p>
            Pada hari ini, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}, kami yang bertanda
            tangan di bawah ini:
        </p>

        <p><strong>Pihak Pertama (Vendor / Pelaksana Pekerjaan):</strong><br></p>

        <table id="vendor-information" border="0">
            <tr>
                <th>Nama</th>
                <th>:</th>
                <th>{{ $dokumen->nama_vendor }}</th>
            </tr>
            <tr>
                <th>Jabatan</th>
                <th>:</th>
                <th>{{ $dokumen->jabatan ?? '-' }}</th>
            </tr>
            <tr>
                <th>Perusahaan</th>
                <th>:</th>
                <th>{{ $dokumen->perusahaan }}</th>
            </tr>
            <tr>
                <th>Alamat</th>
                <th>:</th>
                <th>{{ $dokumen->alamat }}</th>
            </tr>
        </table>

        <p>
            Telah melaksanakan pemeriksaan terhadap pekerjaan dengan rincian sebagai berikut:
        </p>

        <table>
            <thead>
                <tr>
                    <th style="width:40px;">No</th>
                    <th>Uraian Pekerjaan</th>
                    <th>Spesifikasi / Volume</th>
                    <th>Status Pekerjaan</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bapp as $i => $row)
                    <tr>
                        <td>{{ is_numeric($i) ? $i + 1 : $loop->iteration }}</td>
                        <td>{{ $row->uraian_pekerjaan }}</td>
                        <td>{{ $row->spesifikasi_volume }}</td>
                        <td>{{ $row->status_pekerjaan }}</td>
                        <td>{{ $row->keterangan }}</td>
                    </tr>
                @endforeach
                @if (count($bapp) === 0)
                    <tr>
                        <td colspan="5" style="text-align:center;">Tidak ada data</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <p>
            <strong>Hasil Pemeriksaan:</strong><br>
            Berdasarkan pemeriksaan yang dilakukan, pekerjaan tersebut
            <u>{{ $dokumen->status === 'sesuai' ? 'sesuai' : 'tidak sesuai' }}</u>
            dengan kontrak, spesifikasi teknis, dan kesepakatan kerja yang telah ditentukan.
        </p>

        <p>
            Demikian berita acara ini dibuat oleh pihak vendor dan telah diperiksa serta disetujui oleh direksi
            perusahaan.
        </p>
    </div>

    <div class="footer">
        <table style="width:100%; margin-top:20px; text-align:center;">
            <tr>
                <td style="border:none; width:50%;"></td>
                <td style="border:none; width:50%;">
                    {{ $dokumen->kota ?? 'Bandung' }}, {{ $date->translatedFormat('d F Y') }}
                </td>
            </tr>
            <tr>
                <td style="padding-top:5px;"><strong>Pihak Vendor</strong></td>
                <td style="padding-top:5px;"><strong>Direksi</strong></td>
            </tr>
            <tr>
                <td style="height:50px;"></td>
                <td style="height:50px;"></td>
            </tr>
            <tr>
                <td>
                    <u>{{ $dokumen->nama_vendor }}</u><br>
                    <span>{{ $dokumen->jabatan ?? '-' }}</span>
                </td>
                <td>
                    <u>{{ $dokumen->direksi ?? 'Nama Direksi' }}</u><br>
                    <span>{{ $dokumen->jabatan_direksi ?? 'Jabatan Direksi' }}</span>
                </td>
            </tr>
        </table>
    </div>

</body>

</html>
