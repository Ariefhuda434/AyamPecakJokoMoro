<!DOCTYPE html>
<html>
<head>
    <title>Struk Ayam Pecak Joko Moro</title>
    <style>
        body { 
            font-family: monospace;
            font-size: 10px; 
            width: 58mm;
            margin: 0; 
            padding: 0; 
        }
        .center { text-align: center; }
        .right { text-align: right; }
        .separator { 
            border-top: 1px dashed #000; 
            margin: 5px 0; 
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }
        th, td {
            padding: 2px 0;
            vertical-align: top;
        }
        .col-qty { width: 15%; text-align: left; }
        .col-name { width: 55%; }
        .col-price { width: 30%; text-align: right; }
        .total-row { font-weight: bold; font-size: 11px; }
    </style>
</head>
<body>
    
    <div class="center">
        <h3 style="margin: 0; font-size: 13px; font-weight: bold;">AYAM PECAK JOKO MORO</h3>
        <p style="margin: 2px 0; font-size: 8px;">Jl. Raya Kuliner No. 45, Medan</p>
        <p style="margin: 0; font-size: 8px;">Telp: (021) 1234567</p>
    </div>

    <div class="separator"></div>
    
    <table style="font-size: 9px;">
        <tr>
            <td style="width: 35%;">TX ID</td>
            <td>: {{ $transaction->Transaction_id }}</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>: {{ $tanggal }}</td>
        </tr>
        <tr>
            <td>Kasir</td>
            <td>: {{ $kasir }}</td>
        </tr>
    </table>

    <div class="separator"></div>
    
    <table>
        <thead>
            <tr style="font-weight: bold;">
                <td class="col-qty">QTY</td>
                <td class="col-name">ITEM</td>
                <td class="col-price">TOTAL</td>
            </tr>
        </thead>
        <tbody>
            @php $subtotal = 0; @endphp
            @foreach ($items as $item)
                @php 
                    $totalItem = $item->jumlah_pesanan * $item->harga_satuan;
                    $subtotal += $totalItem;
                @endphp
                <tr>
                    <td class="col-qty">{{ $item->jumlah_pesanan }}</td> 
                    <td class="col-name">{{ $item->nama_menu }}</td> 
                    <td class="col-price">{{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="separator"></div>

    <table>
        <tr>
            <td style="width: 65%;">Subtotal</td>
            <td class="col-price">{{ number_format($transaction->total_harga_kotor, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Pajak (11%)</td>
            <td class="col-price">{{ number_format($transaction->jumlah_pajak ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr class="total-row">
            <td>TOTAL BAYAR</td>
            <td class="col-price">{{ number_format($transaction->total_harga_bersih, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Metode</td>
            <td class="col-price">{{ $transaction->Method_Payment ?? 'TUNAI' }}</td>
        </tr>
    </table>
    
    <div class="separator"></div>

    <div class="center" style="margin-top: 8px;">
        <p style="margin: 0; font-weight: bold;">TERIMA KASIH</p>
        <p style="margin: 2px 0; font-size: 8px;">Selamat Menikmati!</p>
    </div>
    
</body>
</html>