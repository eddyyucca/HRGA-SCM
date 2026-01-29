<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Asset</title>
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
            button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <button onclick="window.print()" style="margin-bottom: 10px;">Print / Save as PDF</button>
    
    <div class="header">
        <h2>LAPORAN DATA ASSET</h2>
        <p>Tanggal: {{ date('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Asset</th>
                <th>Nama Asset</th>
                <th>Kategori</th>
                <th>Lokasi</th>
                <th>Kondisi</th>
                <th>Status</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($assets as $asset)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $asset->asset_number }}</td>
                <td>{{ $asset->asset_name }}</td>
                <td>{{ $asset->category->name ?? '-' }}</td>
                <td>{{ $asset->location->full_location ?? '-' }}</td>
                <td>{{ $asset->condition_status }}</td>
                <td>{{ $asset->operational_status }}</td>
                <td style="text-align: right;">{{ number_format($asset->purchase_price ?? 0, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak oleh: EDDY ADHA SAPUTRA</p>
        <p>Tanggal: {{ date('d/m/Y') }}</p>
    </div>

    <script>
        // Auto print saat halaman dimuat
        setTimeout(function() {
            // window.print();
        }, 500);
    </script>
</body>
</html>
