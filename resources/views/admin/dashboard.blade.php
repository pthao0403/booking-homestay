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

        </div>

        <p class="text-muted small mb-0" data-dashboard-status hidden></p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', async () => {
    const dashboardRoot = document.querySelector('[data-dashboard-api]');

    if (!dashboardRoot) {
        return;
    }

    const apiUrl = dashboardRoot.dataset.dashboardApi;
    const statusNode = dashboardRoot.querySelector('[data-dashboard-status]');

    try {
        const response = await fetch(apiUrl, {
            headers: {
                'Accept': 'application/json',
            },
        });

        if (!response.ok) {
            throw new Error('dashboard_fetch_failed');
        }

        const payload = await response.json();

        if (!payload.success) {
            throw new Error('dashboard_payload_invalid');
        }

        const mappings = {
            total_rooms: payload.total_rooms,
            total_users: payload.total_users,
            total_bookings: payload.total_bookings,
            formatted_revenue: payload.formatted_revenue,
        };

        Object.entries(mappings).forEach(([key, value]) => {
            const node = dashboardRoot.querySelector(`[data-stat="${key}"]`);

            if (node) {
                node.textContent = value;
            }
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
