<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Xác nhận đặt phòng - CloudStay</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f5f7;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }
        .header {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            padding: 30px 20px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }
        .header p {
            margin: 5px 0 0;
            opacity: 0.8;
            font-size: 14px;
        }
        .content {
            padding: 30px 20px;
        }
        .greeting {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #1e293b;
        }
        .intro {
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 25px;
            color: #475569;
        }
        .invoice-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
        }
        .invoice-title {
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
            margin-top: 0;
            margin-bottom: 15px;
            border-bottom: 1px solid #cbd5e1;
            padding-bottom: 10px;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 14px;
        }
        .detail-label {
            color: #64748b;
        }
        .detail-value {
            font-weight: 600;
            color: #1e293b;
        }
        .divider {
            border-top: 1px dashed #cbd5e1;
            margin: 15px 0;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            font-size: 16px;
            font-weight: 700;
        }
        .total-label {
            color: #0f172a;
        }
        .total-value {
            color: #ef4444;
        }
        .buttons-container {
            text-align: center;
            margin-top: 30px;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            text-decoration: none;
            margin: 5px;
        }
        .btn-primary {
            background-color: #4f46e5;
            color: #ffffff !important;
        }
        .btn-secondary {
            background-color: #db2777;
            color: #ffffff !important;
        }
        .footer {
            background-color: #f1f5f9;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>ĐẶT PHÒNG THÀNH CÔNG!</h1>
            <p>Mã hóa đơn: #{{ $booking->id }}</p>
        </div>
        <div class="content">
            <div class="greeting">Xin chào {{ $booking->user->name }},</div>
            <div class="intro">
                Cảm ơn bạn đã lựa chọn dịch vụ của <strong>CloudStay</strong>. Yêu cầu đặt phòng của bạn đã được ghi nhận thành công và đang chờ người quản trị phê duyệt. Dưới đây là thông tin chi tiết về hóa đơn của bạn:
            </div>
            
            <div class="invoice-box">
                <h3 class="invoice-title">Chi Tiết Hóa Đơn</h3>
                
                <div class="detail-row">
                    <span class="detail-label">Homestay:</span>
                    <span class="detail-value">{{ $booking->room->name }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Địa chỉ:</span>
                    <span class="detail-value">{{ $booking->room->location }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Ngày nhận phòng:</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($booking->checkin_date)->format('d/m/Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Ngày trả phòng:</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($booking->checkout_date)->format('d/m/Y') }}</span>
                </div>
                
                @php
                    $checkIn = \Carbon\Carbon::parse($booking->checkin_date);
                    $checkOut = \Carbon\Carbon::parse($booking->checkout_date);
                    $nights = $checkIn->diffInDays($checkOut) ?: 1;
                @endphp
                
                <div class="detail-row">
                    <span class="detail-label">Số đêm lưu trú:</span>
                    <span class="detail-value">{{ $nights }} đêm</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Số khách:</span>
                    <span class="detail-value">{{ $booking->guests }} người</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Trạng thái:</span>
                    <span class="detail-value" style="color: #f59e0b;">Chờ phê duyệt</span>
                </div>
                
                <div class="divider"></div>
                
                <div class="total-row">
                    <span class="total-label">TỔNG CỘNG:</span>
                    <span class="total-value">{{ number_format($booking->total_price) }} VNĐ</span>
                </div>
            </div>

            <div class="intro" style="margin-bottom: 10px;">
                Bạn có thể theo dõi trạng thái phê duyệt phòng hoặc thực hiện hủy phòng trực tiếp từ tài khoản cá nhân. 
                Ngoài ra, bạn cũng có thể lưu lịch trình này vào Google Calendar bằng nút phía dưới:
            </div>

            <div class="buttons-container">
                <a href="{{ url('/bookings/' . $booking->id) }}" class="btn btn-primary">Xem Chi Tiết Đặt Phòng</a>
                <a href="{{ \App\Services\GoogleCalendarService::getAddToCalendarUrl($booking) }}" target="_blank" class="btn btn-secondary">Đồng Bộ Google Calendar</a>
            </div>
        </div>
        <div class="footer">
            <p>Đây là email tự động từ hệ thống CloudStay. Vui lòng không trả lời email này.</p>
            <p>&copy; {{ date('Y') }} CloudStay Homestay Booking Group. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
