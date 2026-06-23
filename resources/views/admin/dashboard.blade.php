@extends('layouts.app')

@section('content')
<div class="admin-container">
    @include('partials.sidebar-admin')

    <div class="admin-content" data-dashboard-api="{{ route('api.dashboard') }}">
        <h2>Bảng điều khiển Admin</h2>

        <div class="row mt-4">
            <div class="col-md-3 mb-4">
                <div class="card text-center h-100 shadow-sm" style="border-radius: 8px; border: 1px solid #dee2e6;">
                    <div class="card-body py-4">
                        <h3 class="fw-bold text-primary" data-stat="total_rooms">{{ $totalRooms }}</h3>
                        <p class="text-muted mb-0">Tổng số phòng</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card text-center h-100 shadow-sm" style="border-radius: 8px; border: 1px solid #dee2e6;">
                    <div class="card-body py-4">
                        <h3 class="fw-bold text-success" data-stat="total_users">{{ $totalUsers }}</h3>
                        <p class="text-muted mb-0">Khách hàng</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card text-center h-100 shadow-sm" style="border-radius: 8px; border: 1px solid #dee2e6;">
                    <div class="card-body py-4">
                        <h3 class="fw-bold text-warning" data-stat="total_bookings">{{ $totalBookings }}</h3>
                        <p class="text-muted mb-0">Lượt đặt (Booking)</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card text-center h-100 shadow-sm" style="border-radius: 8px; border: 1px solid #dee2e6;">
                    <div class="card-body py-4">
                        <h3 class="fw-bold text-danger" data-stat="formatted_revenue">{{ $revenue }}</h3>
                        <p class="text-muted mb-0">Doanh thu dự kiến</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card text-center h-100 shadow-sm" style="border-radius: 8px; border: 1px solid #dee2e6;">
                    <div class="card-body py-4">
                        <h5 class="fw-bold text-dark mb-2">Tổng số voucher</h5>
                        <p class="text-muted mb-0">{{ $totalVouchers }} mã voucher</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card text-center h-100 shadow-sm" style="border-radius: 8px; border: 1px solid #dee2e6;">
                    <div class="card-body py-4">
                        <h5 class="fw-bold text-info mb-2">Voucher đang hoạt động</h5>
                        <p class="text-muted mb-0">{{ $activeVouchers }} mã đang hoạt động</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card text-center h-100 shadow-sm" style="border-radius: 8px; border: 1px solid #dee2e6;">
                    <div class="card-body py-4">
                        <h5 class="fw-bold text-secondary mb-2">Voucher hết hạn</h5>
                        <p class="text-muted mb-0">{{ $expiredVouchers }} mã đã hết hạn</p>
                    </div>
                </div>
            </div>
        </div>

        <p class="text-muted small mb-0" data-dashboard-status hidden></p>
        <div class="row mt-5">
            <div class="col-md-7 mb-4">
                <div class="card shadow-sm p-4" style="border-radius: 8px; border: 1px solid #dee2e6;">
                    <h5 class="fw-bold mb-3 text-dark">Thống kê lượt đặt phòng</h5>
                    <canvas id="bookingsChart" style="max-height: 300px;"></canvas>
                </div>
            </div>
            <div class="col-md-5 mb-4">
                <div class="card shadow-sm p-4" style="border-radius: 8px; border: 1px solid #dee2e6;">
                    <h5 class="fw-bold mb-3 text-dark">Tỷ lệ </h5>
                    <canvas id="roomsPieChart" style="max-height: 300px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', async () => {
    const dashboardRoot = document.querySelector('[data-dashboard-api]');
    if (!dashboardRoot) return;

    const apiUrl = dashboardRoot.dataset.dashboardApi;
    const statusNode = dashboardRoot.querySelector('[data-dashboard-status]');

    try {
        const response = await fetch(apiUrl, {
            headers: { 'Accept': 'application/json' },
        });

        if (!response.ok) throw new Error('dashboard_fetch_failed');
        const payload = await response.json();
        if (!payload.success) throw new Error('dashboard_payload_invalid');

        // 1. Cập nhật các con số vào các ô Card dữ liệu
        const mappings = {
            total_rooms: payload.total_rooms,
            total_users: payload.total_users,
            total_bookings: payload.total_bookings,
            formatted_revenue: payload.formatted_revenue,
        };

        Object.entries(mappings).forEach(([key, value]) => {
            const node = dashboardRoot.querySelector(`[data-stat="${key}"]`);
            if (node) node.textContent = value;
        });

        // =======================================================
        // 2. ĐOẠN CODE TỰ ĐỘNG VẼ BIỂU ĐỒ (CHART.JS)
        // =======================================================
        
        // Biểu đồ Cột: Thống kê tổng quan số lượng đặt phòng & khách hàng
        const ctxBar = document.getElementById('bookingsChart').getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ['Tổng phòng', 'Khách hàng', 'Lượt đặt'],
                datasets: [{
                    label: 'Số lượng hệ thống',
                    data: [payload.total_rooms, payload.total_users, payload.total_bookings],
                    backgroundColor: ['#0d6efd', '#198754', '#ffc107'],
                    borderRadius: 6
                }]
            },
            options: { responsive: true, scales: { y: { beginAtZero: true } } }
        });

        // Biểu đồ Tròn: Tỷ lệ so sánh giữa Số phòng và Khách hàng
        const ctxPie = document.getElementById('roomsPieChart').getContext('2d');
        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: ['Tổng số phòng', 'Khách hàng đăng ký'],
                datasets: [{
                    data: [payload.total_rooms, payload.total_users],
                    backgroundColor: ['#0dcaf0', '#6c757d']
                }]
            },
            options: { responsive: true }
        });

    } catch (error) {
        if (statusNode) {
            statusNode.hidden = false;
            statusNode.textContent = 'Không thể đồng bộ số liệu dashboard từ API, đang hiển thị dữ liệu fallback.';
        }
    }
});
</script>
@endsection
