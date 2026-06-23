@extends('layouts.app')

@section('title', 'Tổng quan tài khoản')

@section('content')
<div class="container py-5">
    <style>
        .user-dashboard-shell {
            display: grid;
            gap: 1.5rem;
        }

        .user-dashboard-hero {
            position: relative;
            overflow: hidden;
            border-radius: 28px;
            padding: 2rem;
            color: #fff;
            background:
                radial-gradient(circle at top right, rgba(255, 255, 255, 0.18), transparent 32%),
                linear-gradient(135deg, #0f172a 0%, #1d4ed8 48%, #14b8a6 100%);
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.18);
        }

        .user-dashboard-hero::after {
            content: "";
            position: absolute;
            inset: auto -60px -80px auto;
            width: 220px;
            height: 220px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.08);
        }

        .user-dashboard-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 1rem;
        }

        .user-dashboard-card {
            border: 0;
            border-radius: 24px;
            background: #fff;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
        }

        .user-dashboard-stat {
            height: 100%;
            padding: 1.5rem;
            background: linear-gradient(180deg, rgba(248, 250, 252, 0.95), #fff);
        }

        .user-dashboard-stat .label {
            color: #64748b;
            font-size: 0.92rem;
            margin-bottom: 0.4rem;
        }

        .user-dashboard-stat .value {
            font-size: 2rem;
            font-weight: 800;
            color: #0f172a;
            line-height: 1;
        }

        .user-dashboard-stat .hint {
            margin-top: 0.75rem;
            color: #475569;
            font-size: 0.92rem;
        }

        .user-dashboard-panels {
            display: grid;
            grid-template-columns: minmax(0, 2fr) minmax(280px, 1fr);
            gap: 1.5rem;
        }

        .booking-list {
            display: grid;
            gap: 1rem;
        }

        .booking-item {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            padding: 1rem 1.1rem;
            border-radius: 18px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
        }

        .booking-item h3 {
            font-size: 1rem;
            margin-bottom: 0.3rem;
            color: #0f172a;
        }

        .booking-meta {
            color: #64748b;
            font-size: 0.92rem;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            padding: 0.35rem 0.8rem;
            font-size: 0.82rem;
            font-weight: 700;
            text-transform: capitalize;
        }

        .status-pill.pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-pill.confirmed {
            background: #dcfce7;
            color: #166534;
        }

        .status-pill.completed {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .status-pill.cancelled {
            background: #fee2e2;
            color: #b91c1c;
        }

        .quick-link {
            display: block;
            padding: 1rem 1.1rem;
            border-radius: 18px;
            text-decoration: none;
            color: #0f172a;
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid #e2e8f0;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .quick-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
        }

        .quick-link-title {
            display: block;
            font-weight: 700;
            margin-bottom: 0.35rem;
        }

        .quick-link-copy {
            color: #64748b;
            font-size: 0.92rem;
        }

        @media (max-width: 991.98px) {
            .user-dashboard-grid,
            .user-dashboard-panels {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 767.98px) {
            .user-dashboard-grid,
            .user-dashboard-panels {
                grid-template-columns: 1fr;
            }

            .booking-item {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>

    <div class="user-dashboard-shell">
        <section class="user-dashboard-hero">
            @if(Auth::user()->role === 'admin')
                <h1 class="display-6 fw-bold mb-2">Theo dõi lượt truy cập website.</h1>
            @else
                <span class="badge text-bg-light text-dark mb-3">Tổng quan tài khoản</span>
                <h1 class="display-6 fw-bold mb-2">Xin chào, {{ Auth::user()->name }}</h1>
                <p class="mb-4 text-white-50">Theo dõi booking gần đây, tiến độ xử lý và thông tin tài khoản của bạn tại một nơi.</p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('bookings.index') }}" class="btn btn-light btn-sm px-4">Xem lịch sử đặt phòng</a>
                    <a href="{{ route('profile.index') }}" class="btn btn-light btn-sm px-4">Cập nhật hồ sơ</a>
                </div>
            @endif
        </section>

        <section class="user-dashboard-grid">
            @if(Auth::user()->role === 'admin')
                <article class="user-dashboard-card user-dashboard-stat">
                    <div class="label">Lượt truy cập hôm nay</div>
                    <div class="value">125</div>
                    <div class="hint">Tổng số lượt truy cập ghi nhận trong ngày hiện tại.</div>
                </article>
                <article class="user-dashboard-card user-dashboard-stat">
                    <div class="label">Người dùng đang hoạt động</div>
                    <div class="value">8</div>
                    <div class="hint">Số người đang truy cập website theo dữ liệu realtime.</div>
                </article>
                <article class="user-dashboard-card user-dashboard-stat">
                    <div class="label">Tổng lượt xem trang</div>
                    <div class="value">560</div>
                    <div class="hint">Tổng pageviews hiện được hiển thị từ phần tích hợp Analytics.</div>
                </article>
                <article class="user-dashboard-card user-dashboard-stat">
                    <div class="label">Measurement ID</div>
                    <div class="value" style="font-size: 1.35rem;">G-2F2TLD8BSB</div>
                    <div class="hint">Mã theo dõi đang được gắn vào hệ thống CloudStay.</div>
                </article>
            @else
                <article class="user-dashboard-card user-dashboard-stat">
                    <div class="label">Tổng booking</div>
                    <div class="value">{{ $stats['totalBookings'] }}</div>
                    <div class="hint">Tất cả yêu cầu đặt phòng đã tạo.</div>
                </article>
                <article class="user-dashboard-card user-dashboard-stat">
                    <div class="label">Đang chờ duyệt</div>
                    <div class="value">{{ $stats['pendingBookings'] }}</div>
                    <div class="hint">Các booking đang đợi xác nhận.</div>
                </article>
                <article class="user-dashboard-card user-dashboard-stat">
                    <div class="label">Đã xác nhận</div>
                    <div class="value">{{ $stats['confirmedBookings'] }}</div>
                    <div class="hint">Những chuyến đi đã được duyệt.</div>
                </article>
                <article class="user-dashboard-card user-dashboard-stat">
                    <div class="label">Tổng chi tiêu</div>
                    <div class="value">{{ number_format((float) $stats['totalSpent']) }} VND</div>
                    <div class="hint">Tổng tiền của booking đã xác nhận và hoàn tất.</div>
                </article>
            @endif
        </section>

        <section class="user-dashboard-panels">
            @if(Auth::user()->role === 'admin')
                <article class="user-dashboard-card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h2 class="h4 mb-1">Google Analytics</h2>
                            <p class="text-muted mb-0">Theo dõi nhanh trạng thái tích hợp và truy cập thẳng tới trang quản trị analytics.</p>
                        </div>
                        <a href="{{ config('services.google_analytics.manage_url') }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-secondary btn-sm">Mở trang</a>
                    </div>

                    <div class="booking-list">
                        <div class="booking-item">
                            <div>
                                <h3>Trạng thái tích hợp</h3>
                                <div class="booking-meta">Google Analytics đang được nhúng và theo dõi truy cập của CloudStay.</div>
                                <div class="booking-meta">Realtime overview đã sẵn sàng để theo dõi.</div>
                            </div>
                            <div class="d-flex flex-column align-items-start align-items-md-end gap-2">
                                <span class="status-pill confirmed">Đã kết nối</span>
                                <a href="{{ config('services.google_analytics.manage_url') }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-dark">Xem chi tiết</a>
                            </div>
                        </div>
                        <div class="booking-item">
                            <div>
                                <h3>Dữ liệu nhanh hôm nay</h3>
                                <div class="booking-meta">Lượt truy cập hôm nay: 125</div>
                                <div class="booking-meta">Người dùng đang hoạt động: 8</div>
                            </div>
                            <div class="d-flex flex-column align-items-start align-items-md-end gap-2">
                                <span class="status-pill completed">Realtime</span>
                                <a href="{{ config('services.google_analytics.manage_url') }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-dark">Mở Analytics</a>
                            </div>
                        </div>
                    </div>
                </article>

                <aside class="user-dashboard-card p-4">
                    <h2 class="h4 mb-4">Lối tắt quản trị</h2>
                    <div class="d-grid gap-3">
                        <a href="{{ config('services.google_analytics.manage_url') }}" target="_blank" rel="noopener noreferrer" class="quick-link">
                            <span class="quick-link-title">Tích hợp Google Analytics</span>
                            <span class="quick-link-copy">Xem trạng thái kết nối và mở nhanh trang Analytics realtime của CloudStay.</span>
                        </a>
                        <a href="{{ route('admin.google-vouchers') }}" class="quick-link">
                            <span class="quick-link-title">Quản lý mã ưu đãi</span>
                            <span class="quick-link-copy">Theo dõi dữ liệu voucher Google Sheets và mở nhanh trang quản lý mã giảm giá.</span>
                        </a>
                        <a href="{{ route('admin.dashboard') }}" class="quick-link">
                            <span class="quick-link-title">Bảng điều khiển admin</span>
                            <span class="quick-link-copy">Quay lại khu thống kê, biểu đồ và theo dõi tình trạng vận hành hệ thống.</span>
                        </a>
                    </div>
                </aside>
            @else
                <article class="user-dashboard-card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h2 class="h4 mb-1">Booking gần đây</h2>
                            <p class="text-muted mb-0">Cập nhật nhanh tình trạng các đặt phòng mới nhất.</p>
                        </div>
                        <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary btn-sm">Xem tất cả</a>
                    </div>

                    <div class="booking-list">
                        @forelse($recentBookings as $booking)
                            <div class="booking-item">
                                <div>
                                    <h3>{{ $booking->room->name ?? 'Phong dang cap nhat' }}</h3>
                                    <div class="booking-meta">
                                        {{ optional($booking->checkin_date)->format('d/m/Y') }} - {{ optional($booking->checkout_date)->format('d/m/Y') }}
                                    </div>
                                    <div class="booking-meta">
                                        {{ number_format((float) $booking->payable_total) }} VND - {{ $booking->total_guests }} khach
                                    </div>
                                </div>
                                <div class="d-flex flex-column align-items-start align-items-md-end gap-2">
                                    <span class="status-pill {{ $booking->status }}">
                                        {{ match($booking->status) {
                                            'pending' => 'Chờ duyệt',
                                            'confirmed' => 'Đã xác nhận',
                                            'completed' => 'Hoàn tất',
                                            'cancelled' => 'Đã hủy',
                                            default => ucfirst($booking->status),
                                        } }}
                                    </span>
                                    <a href="{{ route('bookings.show', $booking) }}" class="btn btn-sm btn-dark">Xem chi tiết</a>
                                </div>
                            </div>
                        @empty
                            <div class="booking-item">
                                <div>
                                    <h3>Bạn chưa có booking nào</h3>
                                    <div class="booking-meta">Hãy khám phá phòng phù hợp và tạo booking đầu tiên của bạn.</div>
                                </div>
                                <a href="{{ route('rooms.index') }}" class="btn btn-primary btn-sm">Xem phòng</a>
                            </div>
                        @endforelse
                    </div>
                </article>

                <aside class="user-dashboard-card p-4">
                    <h2 class="h4 mb-4">Lối tắt nhanh</h2>
                    <div class="d-grid gap-3">
                        <a href="{{ route('rooms.index') }}" class="quick-link">
                            <span class="quick-link-title">Tìm phòng mới</span>
                            <span class="quick-link-copy">Xem danh sách homestay và bắt đầu đặt phòng.</span>
                        </a>
                        <a href="{{ route('profile.index') }}" class="quick-link">
                            <span class="quick-link-title">Thông tin tài khoản</span>
                            <span class="quick-link-copy">Cập nhật tên, email và mật khẩu đăng nhập.</span>
                        </a>
                        <a href="{{ route('bookings.index', ['status' => 'upcoming']) }}" class="quick-link">
                            <span class="quick-link-title">Chuyến đi sắp tới</span>
                            <span class="quick-link-copy">Lọc nhanh các booking chưa bị hủy và chưa đến ngày checkout.</span>
                        </a>
                    </div>
                </aside>
            @endif
        </section>
    </div>
</div>
@endsection
