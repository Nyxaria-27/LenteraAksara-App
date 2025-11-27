<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #2F4F4F;
            line-height: 1.6;
            padding: 30px;
        }
        
        .header {
            margin-bottom: 30px;
            border-bottom: 3px solid #4B5320;
            padding-bottom: 20px;
        }
        
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #4B5320;
            margin-bottom: 5px;
        }
        
        .tagline {
            color: #666;
            font-size: 11px;
        }
        
        .invoice-title {
            font-size: 24px;
            font-weight: bold;
            color: #2F4F4F;
            margin-bottom: 10px;
        }
        
        .invoice-info {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        
        .invoice-info-left,
        .invoice-info-right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        
        .info-box {
            background-color: #F5F5F5;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        
        .info-title {
            font-weight: bold;
            color: #4B5320;
            margin-bottom: 8px;
            font-size: 13px;
        }
        
        .info-content p {
            margin-bottom: 3px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 15px;
            font-size: 11px;
            font-weight: bold;
            margin-top: 5px;
        }
        
        .status-pending {
            background-color: #FEF3C7;
            color: #92400E;
        }
        
        .status-processing {
            background-color: #DBEAFE;
            color: #1E40AF;
        }
        
        .status-shipped {
            background-color: #E9D5FF;
            color: #6B21A8;
        }
        
        .status-completed {
            background-color: #D1FAE5;
            color: #065F46;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        table thead {
            background-color: #4B5320;
            color: white;
        }
        
        table th {
            padding: 12px 10px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
        }
        
        table td {
            padding: 10px;
            border-bottom: 1px solid #E5E7EB;
        }
        
        table tbody tr:hover {
            background-color: #F9FAFB;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .summary {
            margin-top: 30px;
            float: right;
            width: 300px;
        }
        
        .summary-row {
            display: table;
            width: 100%;
            margin-bottom: 8px;
        }
        
        .summary-label,
        .summary-value {
            display: table-cell;
            padding: 5px 0;
        }
        
        .summary-label {
            text-align: left;
        }
        
        .summary-value {
            text-align: right;
            font-weight: bold;
        }
        
        .summary-total {
            border-top: 2px solid #4B5320;
            margin-top: 10px;
            padding-top: 10px;
        }
        
        .summary-total .summary-label {
            font-size: 14px;
            font-weight: bold;
            color: #2F4F4F;
        }
        
        .summary-total .summary-value {
            font-size: 16px;
            color: #4B5320;
        }
        
        .notes {
            clear: both;
            margin-top: 40px;
            padding: 15px;
            background-color: #E0F2FE;
            border-left: 4px solid #0284C7;
            border-radius: 5px;
        }
        
        .notes-title {
            font-weight: bold;
            color: #0369A1;
            margin-bottom: 5px;
        }
        
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #E5E7EB;
            text-align: center;
            color: #6B7280;
            font-size: 10px;
        }
        
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <table style="width: 100%; border: none; margin-bottom: 0;">
            <tr>
                <td style="width: 50%; border: none; padding: 0;">
                    <div class="logo">🏮 Lentera Aksara</div>
                    <div class="tagline">Menerangi Dunia dengan Literasi</div>
                </td>
                <td style="width: 50%; border: none; padding: 0; text-align: right;">
                    <div class="invoice-title">INVOICE</div>
                    <p><strong>No:</strong> #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                    <p><strong>Tanggal:</strong> {{ $order->created_at->format('d F Y') }}</p>
                    @php
                        $statusLabels = [
                            'pending' => 'Menunggu Pembayaran',
                            'processing' => 'Diproses',
                            'shipped' => 'Dikirim',
                            'completed' => 'Selesai'
                        ];
                    @endphp
                    <span class="status-badge status-{{ $order->status }}">
                        {{ $statusLabels[$order->status] ?? $order->status }}
                    </span>
                </td>
            </tr>
        </table>
    </div>

    <!-- Customer & Order Info -->
    <div class="invoice-info">
        <div class="invoice-info-left">
            <div class="info-box">
                <div class="info-title">INFORMASI PELANGGAN</div>
                <div class="info-content">
                    <p><strong>Nama:</strong> {{ $order->user->name }}</p>
                    <p><strong>Email:</strong> {{ $order->user->email }}</p>
                    @if($order->address)
                    <p><strong>Alamat:</strong><br>{{ $order->address }}</p>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="invoice-info-right" style="padding-left: 20px;">
            <div class="info-box">
                <div class="info-title">DETAIL PEMBAYARAN</div>
                <div class="info-content">
                    <p><strong>Metode Pembayaran:</strong> {{ $order->payment_method }}</p>
                    <p><strong>Tanggal Pesanan:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>
                    @if($order->status == 'completed')
                    <p><strong>Tanggal Selesai:</strong> {{ $order->updated_at->format('d M Y, H:i') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 45%;">Nama Buku</th>
                <th style="width: 20%;">Penulis</th>
                <th style="width: 10%;" class="text-center">Jumlah</th>
                <th style="width: 10%;" class="text-right">Harga</th>
                <th style="width: 10%;" class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->book->title }}</td>
                <td>{{ $item->book->author }}</td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Summary -->
    <div class="summary">
        <div class="summary-row">
            <div class="summary-label">Subtotal:</div>
            <div class="summary-value">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
        </div>
        <div class="summary-row">
            <div class="summary-label">Biaya Pengiriman:</div>
            <div class="summary-value" style="color: #059669;">Gratis</div>
        </div>
        <div class="summary-row summary-total">
            <div class="summary-label">TOTAL:</div>
            <div class="summary-value">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
        </div>
    </div>

    <!-- Shipping Notes -->
    @if($order->shipping_notes)
    <div class="notes">
        <div class="notes-title">📦 Catatan Pengiriman</div>
        <p>{{ $order->shipping_notes }}</p>
    </div>
    @endif

    <div class="clearfix"></div>

    <!-- Footer -->
    <div class="footer">
        <p><strong>Lentera Aksara</strong> - Toko Buku Online Terpercaya</p>
        <p>Terima kasih atas kepercayaan Anda berbelanja di Lentera Aksara</p>
        <p style="margin-top: 10px;">Invoice ini dicetak pada {{ now()->format('d F Y, H:i') }} WIB</p>
    </div>
</body>
</html>
