<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $booking->booking_number }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1a1a1a; background: #fff; }
        .page { padding: 40px; }
        /* Header */
        .header { border-bottom: 3px solid #C9A84C; padding-bottom: 20px; margin-bottom: 25px; }
        .hotel-name { font-size: 26px; font-weight: bold; color: #C9A84C; letter-spacing: 2px; }
        .hotel-sub { font-size: 10px; color: #888; letter-spacing: 3px; text-transform: uppercase; }
        .invoice-title { font-size: 22px; font-weight: bold; color: #1a1a1a; text-align: right; }
        .invoice-number { font-size: 14px; color: #C9A84C; font-weight: bold; text-align: right; letter-spacing: 1px; }
        /* Two-col layout */
        .row { display: table; width: 100%; }
        .col { display: table-cell; vertical-align: top; }
        .col-half { width: 50%; }
        .col-third { width: 33%; }
        /* Info boxes */
        .info-box { background: #f8f7f4; border-radius: 6px; padding: 15px; margin-bottom: 20px; }
        .info-box h4 { font-size: 10px; text-transform: uppercase; letter-spacing: 2px; color: #888; margin-bottom: 8px; border-bottom: 1px solid #e0ddd6; padding-bottom: 5px; }
        .info-box p { margin-bottom: 4px; font-size: 11px; }
        .info-box strong { color: #1a1a1a; }
        /* Status badge */
        .badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 10px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; }
        .badge-success { background: #d4edda; color: #155724; }
        .badge-warning { background: #fff3cd; color: #856404; }
        .badge-danger  { background: #f8d7da; color: #721c24; }
        /* Table */
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        thead th { background: #1a1a1a; color: #fff; padding: 10px 12px; font-size: 10px; text-transform: uppercase; letter-spacing: 1px; }
        tbody td { padding: 10px 12px; border-bottom: 1px solid #f0ede6; font-size: 11px; }
        tbody tr:nth-child(even) { background: #fafaf8; }
        /* Totals */
        .totals { margin-left: 50%; }
        .total-row { display: flex; justify-content: space-between; padding: 5px 0; font-size: 12px; }
        .total-row.final { border-top: 2px solid #C9A84C; padding-top: 10px; margin-top: 5px; font-size: 15px; font-weight: bold; color: #C9A84C; }
        /* Footer */
        .footer { border-top: 1px solid #e0ddd6; padding-top: 20px; margin-top: 30px; text-align: center; color: #aaa; font-size: 10px; }
        /* Gold divider */
        .gold-line { height: 2px; background: #C9A84C; margin: 15px 0; }
    </style>
</head>
<body>
<div class="page">
    <!-- Header -->
    <div class="header">
        <div class="row">
            <div class="col col-half">
                <div class="hotel-name">MONARCH HOTEL</div>
                <div class="hotel-sub">Luxury · Calasiao, Pangasinan</div>
                <div style="margin-top:8px; font-size:10px; color:#666;">
                    Calasiao, Pangasinan 2418, Philippines<br>
                    Tel: +63 75 123 4567 | info@monarchhotel.com
                </div>
            </div>
            <div class="col col-half" style="text-align:right;">
                <div class="invoice-title">INVOICE</div>
                <div class="invoice-number">{{ $booking->booking_number }}</div>
                <div style="font-size:10px;color:#888;margin-top:6px;">
                    Issued: {{ now()->format('F d, Y') }}<br>
                    <span class="badge badge-{{ $booking->status_badge }}">{{ strtoupper(str_replace('_',' ',$booking->status)) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Guest & Room Info -->
    <div class="row" style="margin-bottom:20px;">
        <div class="col col-half" style="padding-right:15px;">
            <div class="info-box">
                <h4>Bill To</h4>
                <p><strong>{{ $booking->guest_name }}</strong></p>
                <p>{{ $booking->guest_email }}</p>
                <p>{{ $booking->guest_phone }}</p>
                @if($booking->guest_address)<p>{{ $booking->guest_address }}</p>@endif
            </div>
        </div>
        <div class="col col-half" style="padding-left:15px;">
            <div class="info-box">
                <h4>Booking Details</h4>
                <p><strong>Room:</strong> {{ $booking->room->name }} ({{ $booking->room->room_number }})</p>
                <p><strong>Type:</strong> {{ $booking->room->roomType->name }}</p>
                <p><strong>Check-in:</strong> {{ $booking->check_in->format('D, M d, Y') }}</p>
                <p><strong>Check-out:</strong> {{ $booking->check_out->format('D, M d, Y') }}</p>
                <p><strong>Duration:</strong> {{ $booking->nights }} night(s)</p>
                <p><strong>Guests:</strong> {{ $booking->adults }} adult(s){{ $booking->children > 0 ? ', '.$booking->children.' child(ren)' : '' }}</p>
            </div>
        </div>
    </div>

    <!-- Itemized Table -->
    <table>
        <thead>
            <tr>
                <th style="width:50%;">Description</th>
                <th style="width:15%;text-align:center;">Nights</th>
                <th style="width:17%;text-align:right;">Rate/Night</th>
                <th style="width:18%;text-align:right;">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <strong>{{ $booking->room->name }}</strong><br>
                    <span style="color:#888;font-size:10px;">{{ $booking->room->roomType->name }} · Room {{ $booking->room->room_number }}</span>
                </td>
                <td style="text-align:center;">{{ $booking->nights }}</td>
                <td style="text-align:right;">₱{{ number_format($booking->room_price_per_night,2) }}</td>
                <td style="text-align:right;">₱{{ number_format($booking->subtotal,2) }}</td>
            </tr>
            @if($booking->discount_amount > 0)
            <tr>
                <td colspan="3" style="text-align:right;color:#28a745;">
                    Promo Discount{{ $booking->promotion ? ' ('.$booking->promotion->code.')' : '' }}
                </td>
                <td style="text-align:right;color:#28a745;">-₱{{ number_format($booking->discount_amount,2) }}</td>
            </tr>
            @endif
        </tbody>
    </table>

    <!-- Totals -->
    <div class="totals">
        <div class="total-row">
            <span style="color:#666;">Subtotal</span>
            <span>₱{{ number_format($booking->subtotal,2) }}</span>
        </div>
        @if($booking->discount_amount > 0)
        <div class="total-row" style="color:#28a745;">
            <span>Discount</span>
            <span>-₱{{ number_format($booking->discount_amount,2) }}</span>
        </div>
        @endif
        <div class="total-row">
            <span style="color:#666;">VAT (12%)</span>
            <span>₱{{ number_format($booking->tax_amount,2) }}</span>
        </div>
        <div class="total-row final">
            <span>TOTAL DUE</span>
            <span>₱{{ number_format($booking->total_amount,2) }}</span>
        </div>
        <div class="total-row" style="font-size:11px;">
            <span style="color:#666;">Payment Status</span>
            <span class="badge badge-{{ $booking->payment_status_badge }}">{{ strtoupper(str_replace('_',' ',$booking->payment_status)) }}</span>
        </div>
        @if($booking->payment_method)
        <div class="total-row" style="font-size:11px;">
            <span style="color:#666;">Payment Method</span>
            <span>{{ ucfirst($booking->payment_method) }}</span>
        </div>
        @endif
    </div>

    <!-- Notes -->
    @if($booking->special_requests)
    <div class="info-box" style="margin-top:20px;">
        <h4>Special Requests</h4>
        <p>{{ $booking->special_requests }}</p>
    </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <div class="gold-line"></div>
        <p><strong>Thank you for choosing Monarch Hotel!</strong></p>
        <p style="margin-top:5px;">For inquiries, please contact us at info@monarchhotel.com or +63 75 123 4567</p>
        <p style="margin-top:5px;">Calasiao, Pangasinan 2418, Philippines | www.monarchhotel.com</p>
        <p style="margin-top:8px;color:#ccc;">This is a computer-generated invoice. No signature required.</p>
    </div>
</div>
</body>
</html>
