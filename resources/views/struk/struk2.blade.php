<!DOCTYPE html>
<html>
<head>
    <title>Struk Pembayaran - Meja {{ $order->nomor_meja ?? 'TAKEAWAY' }}</title>
    <style>
        body {
            font-family: monospace;
            font-size: 10px;
            width: 80mm; 
            margin: 0;
            padding: 0;
        }
        .container {
            padding: 5px;
        }
        .header, .footer {
            text-align: center;
            margin-bottom: 5px;
        }
        .separator {
            border-top: 1px dashed #000;
            margin: 5px 0;
        }
        .text-right {
            text-align: right;
        }
        .bold {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h3 class="bold" style="margin: 0; font-size: 14px;">NAMA RESTORAN ANDA</h3>
            <p style="margin: 0;">Terima Kasih Atas Kunjungan Anda</p>
        </div>
        
        <div class="separator"></div>

        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 50%;">Order ID: {{ $order->Order_id }}</td>
                <td style="width: 50%; text-align: right;">Meja: <span class="bold">{{ $order->nomor_meja ?? 'TAKEAWAY' }}</span></td>
            </tr>
            <tr>
                <td>Tanggal: {{ Carbon::parse($transaction->created_at)->format('d/m/Y H:i') }}</td>
                <td style="text-align: right;">Kasir: {{ $namaKasir }}</td>
            </tr>
            <tr>
                <td colspan="2">Pelanggan: {{ $order->nama_customer ?? 'Umum' }}</td>
            </tr>
        </table>
        
        <div class="separator"></div>
        
        <table style="width: 100%; border-collapse: collapse;">
            <tr class="bold">
                <td style="width: 50%;">Item</td>
                <td style="width: 15%; text-align: right;">Qty</td>
                <td style="width: 35%; text-align: right;">Subtotal</td>
            </tr>
            
            @foreach ($items as $item)
                <tr>
                    <td>{{ $item->nama_menu }}</td>
                    <td class="text-right">{{ $item->jumlah_pesanan }}</td>
                    <td class="text-right">{{ number_format($item->harga_satuan * $item->jumlah_pesanan, 0, ',', '.') }}</td>
                </tr>
                @if (!empty($item->catatan))
                    <tr>
                        <td colspan="3" style="font-size: 9px; padding-left: 5px;">* Catatan: {{ $item->catatan }}</td>
                    </tr>
                @endif
            @endforeach
        </table>

        <div class="separator"></div>

        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 70%;">SUBTOTAL</td>
                <td style="width: 30%;" class="text-right">{{ number_format($order->total_harga, 0, ',', '.') }}</td>
            </tr>

            
            <tr>
                <td class="bold" style="font-size: 12px; padding-top: 5px;">TOTAL BAYAR</td>
                <td class="text-right bold" style="font-size: 12px; padding-top: 5px;">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
            </tr>
            
            <tr style="height: 10px;"><td></td><td></td></tr>

            <tr>
                <td>Metode Pembayaran</td>
                <td class="text-right bold">{{ $paymentMethod }}</td>
            </tr>
            <tr>
                <td>Bayar</td>
                <td class="text-right">{{ number_format($paidAmount, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Kembalian</td>
                <td class="text-right">{{ number_format($changeAmount, 0, ',', '.') }}</td>
            </tr>
        </table>
        
        <div class="separator"></div>

        <div class="footer">
            <p style="margin: 0; font-size: 12px;">TERIMA KASIH TELAH BERKUNJUNG</p>
        </div>
    </div>
</body>
</html>