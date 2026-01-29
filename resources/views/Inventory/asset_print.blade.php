<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Print Laporan Asset</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table th, table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
        table th {
            background-color: #ddd;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 10px;">
        <button onclick="window.print()">Print</button>
        <button onclick="window.close()">Tutup</button>
    </div>
    
    <div class="header">
        <h2>LAPORAN DATA ASSET</h2>
        <p>Tanggal: {{ date('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Nomor Asset</th>
                <th style="width: 20%;">Nama Asset</th>
                <th style="width: 12%;">Kategori</th>
                <th style="width: 20%;">Lokasi</th>
                <th style="width: 10%;">Kondisi</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 13%;">Harga</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; $total = 0; @endphp
            @foreach($assets as $asset)
            <tr>
                <td style="text-align: center;">{{ $no++ }}</td>
                <td>{{ $asset->asset_number }}</td>
                <td>{{ $asset->asset_name }}</td>
                <td>{{ $asset->category->name ?? '-' }}</td>
                <td><small>{{ $asset->location->full_location ?? '-' }}</small></td>
                <td style="text-align: center;">{{ $asset->condition_status }}</td>
                <td style="text-align: center;">{{ $asset->operational_status }}</td>
                <td style="text-align: right;">Rp {{ number_format($asset->purchase_price ?? 0, 0, ',', '.') }}</td>
            </tr>
            @php $total += ($asset->purchase_price ?? 0); @endphp
            @endforeach
            <tr>
                <td colspan="7" style="text-align: right;"><strong>TOTAL:</strong></td>
                <td style="text-align: right;"><strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak oleh: EDDY ADHA SAPUTRA</p>
        <p>Tanggal: {{ date('d/m/Y') }}</p>
        <br><br>
        <p>_______________________</p>
        <p>Mengetahui</p>
    </div>
</body>
</html>
