@extends('layouts.app')

@section('title', 'Quản lý booking - CloudStay')

@section('content')
<div class="container-fluid py-4">
    <div class="row g-4">
        <div class="col-xl-3">
            @include('partials.sidebar-admin')
        </div>

        <div class="col-xl-9">
            <div class="admin-section-card">
                <div class="admin-section-header">
                    <div>
                        <span class="section-kicker">Booking</span>
                        <h1 class="h3 fw-bold mb-1">Quản lý yêu cầu đặt phòng</h1>
                        <p class="text-muted mb-0">Lọc, xem chi tiết và cập nhật trạng thái booking của khách hàng.</p>
                    </div>

                    <form method="GET" class="admin-filter-form">
                        <label for="status" class="form-label mb-1">Trạng thái</label>
                        <select id="status" name="status" class="form-select" onchange="this.form.submit()">
                            <option value="">Tất cả trạng thái</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
                            <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table admin-table align-middle">
                        <thead>
                            <tr>
                                <th>Khách hàng</th>
                                <th>Phòng</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th class="text-end">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $booking)
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $booking->user->name }}</div>
                                        <small class="text-muted">{{ $booking->user->email }}</small>
                                    </td>
                                    <td>{{ $booking->room->name }}</td>
                                    <td>{{ optional($booking->checkin_date)->format('d/m/Y') }}</td>
                                    <td>{{ optional($booking->checkout_date)->format('d/m/Y') }}</td>
                                    <td class="fw-semibold text-primary">{{ number_format((float) $booking->total_price) }} VNĐ</td>
                                    <td>
                                        <span class="booking-status-pill booking-status-{{ $booking->status }}">
                                            @if($booking->status === 'pending') Chờ duyệt @elseif($booking->status === 'confirmed') Đã xác nhận @else Đã hủy @endif
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex justify-content-end gap-2 flex-wrap">
                                            <a href="{{ route('bookings.show', $booking) }}" class="btn btn-outline-secondary btn-sm">Xem</a>
                                            @if($booking->status === 'pending')
                                                <form action="{{ route('admin.bookings.update', $booking) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="confirmed">
                                                    <button type="submit" class="btn btn-success btn-sm">Duyệt</button>
                                                </form>
                                                <form action="{{ route('admin.bookings.update', $booking) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="cancelled">
                                                    <button type="submit" class="btn btn-danger btn-sm">Từ chối</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">Không có booking nào phù hợp với bộ lọc hiện tại.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $bookings->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
