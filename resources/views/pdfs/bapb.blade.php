<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Berita Acara Pemeriksaan Barang</title>
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
        th, td {
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
            padding-top: 50px;
        }
        .footer strong {
            display: block;
            margin-top: 5px;
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
        <img src="{{ $signature['path'] }}"
            class="signature-stamp"
            style="left: {{ $signature['left'] ?? 0 }}%; top: {{ $signature['top'] ?? 0 }}%; width: {{ $signature['width'] ?? 160 }}px;">
    @endif

    <h2>BERITA ACARA PEMERIKSAAN BARANG</h2>
    <div class="nomor">
        Nomor: {{ $dokumen->nomor_kontrak ?? '.../BA-PB/.../...' }}
    </div>

    <div class="content">
        <p>
            Pada hari ini, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}, kami dari Vendor
            <strong>{{ $dokumen->nama_vendor }}</strong>, yang berkedudukan di 
            <strong>{{ $dokumen->alamat ?? '-' }}</strong>, menyampaikan berita acara pemeriksaan barang kepada pihak perusahaan. 
            Pemeriksaan dilakukan oleh PIC gudang perusahaan dengan rincian sebagai berikut:
        </p>

       <table>
            <thead>
                <tr>
                    <th class="border" style="width:40px">No</th>
                    <th class="border">Nama Barang</th>
                    <th class="border">Merk/Type</th>
                    <th class="border" style="width:70px">Jumlah</th>
                    <th class="border" style="width:80px">Kondisi</th>
                    <th class="border">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <!-- nanti uncomment  kalau udh buat model bapb nya -->
                @foreach ($bapb as $i => $row)
                    <tr>
                        <td class="border">{{ is_numeric($i) ? $i + 1 : $loop->iteration }}</td>
                        <td class="border">{{ $row->nama_barang }}</td>
                        <td class="border">{{ $row->merk_type }}</td>
                        <td class="border">{{ $row->jumlah }}</td>
                        <td class="border">{{ $row->kondisi }}</td>
                        <td class="border">{{ $row->keterangan }}</td>
                    </tr>
                @endforeach
                @if (count($bapb) === 0)
                    <tr>
                        <td colspan="6" style="text-align:center">Tidak ada data</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <p>
            <strong>Hasil Pemeriksaan:</strong><br>
            Berdasarkan pemeriksaan yang dilakukan oleh PIC gudang, barang-barang tersebut 
            <u>{{ $dokumen->status === 'sesuai' ? 'sesuai' : 'tidak sesuai' }}</u> 
            dengan dokumen pengiriman dan daftar inventaris perusahaan.
        </p>

        <p>
            Demikian berita acara ini dibuat oleh vendor dan telah diperiksa serta disetujui oleh PIC gudang.
        </p>
    </div>

   <div class="footer">
    <table style="width:100%; margin-top:20px; text-align:center; border:none;">
        <tr>
            <td style="border:none; width:50%;"></td>
            <td style="border:none; width:50%;">
                Bandung, {{ $date->translatedFormat('d F Y') }}
            </td>
        </tr>
        <tr>
            <td style="border:none; padding-top:5px;">
                <strong>Pihak Vendor</strong>
            </td>
            <td style="border:none; padding-top:5px;">
                <strong>Pemeriksa / PIC Gudang</strong>
            </td>
        </tr>
        <tr>
            <td style="border:none; height:50px;"></td>
            <td style="border:none; height:50px;"></td>
        </tr>
        <tr>
            <td style="border:none;">
                <u>{{ $dokumen->nama_vendor }}</u><br>
                <span>{{ $dokumen->jabatan }}</span>
            </td>
            <td style="border:none;">
                <u>pic gudang</u><br>
                <span>pic</span>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
