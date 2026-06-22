<?php

namespace App\Services;

class GoogleCalendarService
{
    /**
     * Generate standard Google Calendar template URL for adding event client-side.
     */
    public static function getAddToCalendarUrl($booking): string
    {
        $title = 'Đặt phòng Homestay: ' . $booking->room->name;
        
        // Google Calendar template dates must be in format: YYYYMMDD/YYYYMMDD (for all day events)
        $checkin = date('Ymd', strtotime($booking->checkin_date));
        
        // Google Calendar expects the end date of an all-day event to be exclusive (check-out day + 1)
        $checkoutDate = date('Y-m-d', strtotime($booking->checkout_date . ' +1 day'));
        $checkout = date('Ymd', strtotime($checkoutDate));
        
        $dates = $checkin . '/' . $checkout;
        
        $location = $booking->room->location ?: $booking->room->address;
        
        $details = "Mã đặt phòng: #{$booking->id}\n"
                 . "Tên homestay: {$booking->room->name}\n"
                 . "Số khách: {$booking->guests} người\n"
                 . "Tổng giá tiền: " . number_format($booking->total_price) . " VNĐ\n"
                 . "Trạng thái: Chờ phê duyệt\n"
                 . "Cảm ơn bạn đã lựa chọn CloudStay!";
        
        return 'https://calendar.google.com/calendar/render?' . http_build_query([
            'action' => 'TEMPLATE',
            'text' => $title,
            'dates' => $dates,
            'details' => $details,
            'location' => $location,
            'sf' => 'true',
            'output' => 'xml'
        ]);
    }
}
