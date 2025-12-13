<!DOCTYPE html>
<html>
<head>
    <title>Pesanan Dapur (KOT) #{{ $order->Order_id }}</title>
    {{-- CSS Inline adalah penting untuk DomPDF --}}
    <style>
        body { font-family: sans-serif; font-size: 11px; margin: 0; padding: 10px; }
        .header { text-align: center; margin-bottom: 15px; border-bottom: 2px solid black; padding-bottom: 5px; }
        .title { font-size: 16px; font-weight: bold; margin-bottom: 3px; }
        .info-section { margin-bottom: 10px; }
        .info-section p { margin: 3px 0; }
        .items-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .items-table th, .items-table td { text-align: left; padding: 5px 0; }
        .items-table th { border-bottom: 1px dashed black; font-size: 12px; }
        .item-name { font-weight: bold; font-size: 14px; }
        .notes { font-style: italic; color: #555; font-size: 10px; }
        .footer { text-align: center; margin-top: 20px; border-top: 1px dashed black; padding-top: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">ORDER DAPUR / KOT</div>
        <p style="font-size: 10px;">Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

    <div class="info-section">
        <p><strong>ORDER ID:</strong> {{ $order->Order_id }}</p>
        <p><strong>MEJA:</strong> <span style="font-size: 18px; color: red;">{{ $order->customer->table->No_Table ?? 'TAKEAWAY' }}</span></p>
        <p><strong>PELAYAN:</strong> {{ $order->employee->name_employee ?? 'N/A' }}</p>
        <p><strong>CUSTOMER:</strong> {{ $order->customer->Name ?? 'Umum' }}</p>
        <p><strong>STATUS ORDER:</strong> <span style="font-weight: bold; color: blue;">{{ $order->Order_Status }}</span></p>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 10%;">QTY</th>
                <th style="width: 90%;">NAMA MASAKAN / ITEM</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderDetails as $detail)
            <tr>
                <td style="font-size: 18px; font-weight: bold;">{{ $detail->Quantity }}</td>
                <td>
                    <div class="item-name">{{ $detail->menu->Name }}</div>
                    @if (!empty($detail->Notes))
                        <div class="notes">Catatan: {{ $detail->Notes }}</div>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p style="font-weight: bold;">MOHON SEGERA DIPROSES</p>
    </div>
</body>
</html>