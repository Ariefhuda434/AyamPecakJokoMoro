<!DOCTYPE html>
<html>
<head>
    <title>KOT #{{ $order->Order_id }}</title>
    <style>
        body { 
            font-family: 'Consolas', monospace; 
            font-size: 8px; 
            margin: 0; 
            padding: 5px; 
            width: 80mm; 
        }
        .header { 
            text-align: center; 
            margin-bottom: 8px; 
            border-bottom: 1px dashed black; 
            padding-bottom: 5px; 
        }
        .title { 
            font-size: 14px; 
            font-weight: bold; 
        }
        .info-section { 
            margin-bottom: 8px; 
        }
        .info-section p { 
            margin: 2px 0; 
        }
        
        .table-highlight {
            font-size: 24px; 
            font-weight: 900; 
            color: #CC0000; 
            display: block;
            text-align: center;
            padding: 4px 0;
            border: 1px dashed #CC0000;
            margin-top: 4px;
        }

        .items-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px; 
        }
        .items-table th, .items-table td { 
            text-align: left; 
            padding: 3px 0; 
            vertical-align: top;
        }
        .items-table th { 
            border-bottom: 1px solid black; 
            font-size: 8px;
            padding-bottom: 3px;
        }
        
        .item-name { 
            font-weight: bold; 
            font-size: 10px; 
        }
        .item-qty {
            font-size: 16px; 
            font-weight: bold; 
            text-align: center;
            color: #CC0000; 
            width: 15%; 
        }
        .notes { 
            font-style: italic; 
            color: #555; 
            font-size: 7px; 
        }
        .footer { 
            text-align: center; 
            margin-top: 15px; 
            border-top: 1px dashed black; 
            padding-top: 5px; 
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">ORDER DAPUR</div>
        <p>Tgl: {{ now()->format('d/m H:i') }} | ID: {{ $order->Order_id }}</p>
    </div>

    <div class="info-section">
        <p><strong>PELAYAN:</strong> {{ $order->employee->name_employee ?? 'N/A' }}</p>
        <p><strong>CUSTOMER:</strong> {{ $order->customer->Name ?? 'Umum' }}</p>
        
        <span class="table-highlight">{{ $order->customer->table->No_Table ?? 'TAKEAWAY' }}</span>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 15%; text-align: center;">QTY</th>
                <th style="width: 85%;">MENU</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderDetails as $detail)
            <tr>
                <td class="item-qty">{{ $detail->Quantity }}</td>
                <td>
                    <div class="item-name">{{ $detail->menu->Name }}</div>
                    @if (!empty($detail->Notes))
                        <div class="notes">({{ $detail->Notes }})</div>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>ORDER STATUS: {{ $order->Order_Status }}</p>
        <p style="font-weight: bold;">— SEGERA PROSES —</p>
    </div>
</body>
</html>