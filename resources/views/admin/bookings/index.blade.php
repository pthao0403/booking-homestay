@extends('layouts.app')

@section('title', 'Quản lý Đặt phòng - CloudStay')

@section('content')
<div class="admin-container container-fluid py-4 text-start">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3 col-md-4 mb-4">
            @include('partials.sidebar-admin')
        </div>
        
        <!-- Main Content -->
        <div class="col-lg-9 col-md-8">
            <div class="card shadow-sm border-0 p-4 bg-white" style="border-radius: 16px;">
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                    <h2 class="fw-bold mb-0" style="color: #0f172a;">Quản Lý Đặt Phòng</h2>
                    
                    <div class="filter-section">
                        <form method="GET" class="filter-form">
                            <select name="status" class="form-select" onchange="this.form.submit()" style="border-radius: 8px;">
                                <option value="">Tất cả trạng thái</option>
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
                                <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Đã hoàn thành</option>
                                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                            </select>
                        </form>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover align-middle border-0">
                        <thead class="table-light">
                            <tr class="text-secondary" style="font-size: 0.9rem;">
                                <th class="border-0 py-3">Tên khách hàng</th>
                                <th class="border-0 py-3">Phòng</th>
                                <th class="border-0 py-3">Ngày nhận</th>
                                <th class="border-0 py-3">Ngày trả</th>
                                <th class="border-0 py-3">Tổng chi phí</th>
                                <th class="border-0 py-3 text-center">Trạng thái</th>
                                <th class="border-0 py-3 text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $booking)
                                <tr>
                                    <td class="py-3">
                                        <div class="fw-bold text-dark">{{ $booking->user->name }}</div>
                                        <small class="text-muted">{{ $booking->user->email }}</small>
                                    </td>
                                    <td class="py-3 fw-semibold" style="color: #334155;">{{ $booking->room->name }}</td>
                                    <td class="py-3">{{ $booking->check_in ? $booking->check_in->format('d/m/Y') : 'N/A' }}</td>
                                    <td class="py-3">{{ $booking->check_out ? $booking->check_out->format('d/m/Y') : 'N/A' }}</td>
                                    <td class="py-3 fw-bold text-primary">{{ number_format((float)$booking->total_price) }} VNĐ</td>
                                    <td class="py-3 text-center">
                                        @if($booking->status === 'pending')
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2.5 py-1.5" style="border-radius: 30px; font-size: 0.8rem;">Chờ duyệt</span>
                                        @elseif($booking->status === 'confirmed')
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1.5" style="border-radius: 30px; font-size: 0.8rem;">Đã xác nhận</span>
                                        @elseif($booking->status === 'completed')
                                            <span class="badge bg-info-subtle text-info border border-info-subtle px-2.5 py-1.5" style="border-radius: 30px; font-size: 0.8rem;">Đã hoàn thành</span>
                                        @elseif($booking->status === 'cancelled')
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2.5 py-1.5" style="border-radius: 30px; font-size: 0.8rem;">Đã hủy</span>
                                        @endif
                                    </td>
                                    <td class="py-3 text-center">
                                        <div class="d-flex align-items-center justify-content-center gap-1">
                                            <a href="{{ route('bookings.show', $booking) }}" class="btn btn-sm btn-outline-secondary" style="border-radius: 6px;">Xem</a>
                                            @if($booking->status === 'pending')
                                                <form action="{{ route('admin.bookings.update', $booking) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="confirmed">
                                                    <button type="submit" class="btn btn-sm btn-success px-2.5" style="border-radius: 6px;" onclick="return confirm('Bạn có chắc muốn phê duyệt đặt phòng này?')">Duyệt</button>
                                                </form>
                                                <form action="{{ route('admin.bookings.update', $booking) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="cancelled">
                                                    <button type="submit" class="btn btn-sm btn-danger px-2.5" style="border-radius: 6px;" onclick="return confirm('Bạn có chắc muốn từ chối/hủy đặt phòng này?')">Từ chối</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-5 text-center text-muted fw-semibold">
                                        <i class="bi bi-calendar-x d-block mb-2" style="font-size: 2.5rem; color: #cbd5e1;"></i>
                                        Không tìm thấy yêu cầu đặt phòng nào.
                                    </td>
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
