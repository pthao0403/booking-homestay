@extends('layouts.app')

@section('title', 'CloudStay - Đặt Homestay Online')

@section('content')
<section class="hero-section hero-professional text-white">
    <div class="container position-relative">
        <div class="row align-items-center min-vh-100 py-5 gy-5">
            <div class="col-lg-6">
                <span class="hero-eyebrow">Nền tảng đặt homestay thông minh</span>
                <h1 class="display-3 fw-bold mb-4">
                    Chọn nơi lưu trú đẹp, đặt nhanh và theo dõi booking dễ dàng
                </h1>
                <p class="lead mb-4 hero-copy">
                    CloudStay giúp bạn tìm homestay phù hợp, xem chi tiết phòng, gửi yêu cầu đặt phòng
                    và theo dõi trạng thái trong một trải nghiệm mạch lạc, hiện đại.
                </p>

                <div class="d-flex gap-3 flex-wrap mb-4">
                    <a href="{{ route('rooms.index') }}" class="btn btn-primary btn-lg px-4">
                        Khám phá homestay
                    </a>
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-warning btn-lg px-4">
                            Tạo tài khoản
                        </a>
                    @else
                        <a href="{{ route('bookings.index') }}" class="btn btn-outline-light btn-lg px-4">
                            Lịch sử đặt phòng
                        </a>
                    @endguest
                </div>

                <div class="hero-metrics row g-3">
                    <div class="col-6 col-md-4">
                        <div class="hero-metric-card">
                            <strong>{{ max($rooms->count(), 10) }}+</strong>
                            <span>Homestay nổi bật</span>
                        </div>
                    </div>
                    <div class="col-6 col-md-4">
                        <div class="hero-metric-card">
                            <strong>10K+</strong>
                            <span>Khách hàng tin tưởng</span>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="hero-metric-card">
                            <strong>24/7</strong>
                            <span>Hỗ trợ liên tục</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="hero-visual-card shadow-lg">
                    <img
                        src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1400"
                        class="img-fluid hero-visual-image"
                        alt="CloudStay Homestay"
                    >

                    <div class="hero-floating-card">
                        <div class="small text-uppercase text-muted fw-semibold">Homestay được yêu thích</div>
                        <div class="fw-bold fs-5">Không gian đẹp, đặt phòng chỉ trong vài bước</div>
                        <div class="text-primary fw-semibold">Từ 650.000 VNĐ / đêm</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="search-section">
    <div class="container">
        <div class="card border-0 shadow-lg p-4 search-panel">
            <form action="{{ route('rooms.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-lg-5">
                    <label class="form-label fw-semibold">Điểm đến hoặc tên homestay</label>
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Bạn muốn đi đâu?"
                        value="{{ request('search') }}"
                    >
                </div>
                <div class="col-md-3 col-lg-2">
                    <label class="form-label fw-semibold">Nhận phòng</label>
                    <input type="date" name="check_in" class="form-control" value="{{ request('check_in') }}">
                </div>
                <div class="col-md-3 col-lg-2">
                    <label class="form-label fw-semibold">Trả phòng</label>
                    <input type="date" name="check_out" class="form-control" value="{{ request('check_out') }}">
                </div>
                <div class="col-md-6 col-lg-3">
                    <button type="submit" class="btn btn-primary w-100">
                        Tìm homestay phù hợp
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<section class="container py-5">
    <div class="section-heading text-center mb-5">
        <span class="section-kicker">Gợi ý dành cho bạn</span>
        <h2 class="fw-bold display-6">Homestay nổi bật đang mở đặt phòng</h2>
        <p class="text-muted fs-5 mb-0">
            Dữ liệu được lấy trực tiếp từ hệ thống quản lý phòng để đảm bảo đồng bộ và dễ cập nhật.
        </p>
    </div>

    <div class="row g-4">
        @forelse ($featuredRooms as $room)
            <div class="col-lg-4 col-md-6">
                <article class="card room-card room-card-modern h-100">
                    <div class="room-card-media">
                        <img
                            src="{{ $room->thumbnail_url ?: 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1200' }}"
                            class="room-image w-100"
                            alt="{{ $room->name }}"
                        >
                        <span class="badge bg-primary room-card-badge">Phòng nổi bật</span>
                    </div>

                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start gap-3 mb-2">
                            <h5 class="fw-bold mb-0">{{ $room->name }}</h5>
                            <span class="room-status-chip">{{ ucfirst($room->status) }}</span>
                        </div>

                        <p class="text-muted mb-2">
                            <i class="bi bi-geo-alt-fill text-primary"></i> {{ $room->address }}
                        </p>

                        <p class="text-muted flex-grow-1">
                            {{ \Illuminate\Support\Str::limit($room->description, 110) }}
                        </p>

                        <div class="d-flex justify-content-between align-items-center room-card-meta">
                            <span><i class="bi bi-people"></i> {{ $room->capacity }} khách</span>
                            <span><i class="bi bi-house-door"></i> {{ ucfirst(str_replace('_', ' ', $room->type)) }}</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div>
                                <div class="small text-muted">Giá mỗi đêm</div>
                                <div class="fw-bold text-primary fs-5">{{ number_format((float) $room->price) }} VNĐ</div>
                            </div>
                            @if (!empty($room->id))
                                <a href="{{ route('rooms.show', $room) }}" class="btn btn-primary">
                                    Xem chi tiết
                                </a>
                            @else
                                <a href="{{ route('rooms.index') }}" class="btn btn-primary">
                                    Xem danh sách
                                </a>
                            @endif
                        </div>
                    </div>
                </article>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-light border text-center empty-state-card">
                    <h5 class="fw-bold mb-2">Chưa có homestay nào để hiển thị</h5>
                    <p class="mb-0 text-muted">Bạn có thể thêm phòng từ khu vực quản trị để làm phong phú danh sách hiển thị.</p>
                </div>
            </div>
        @endforelse
    </div>
</section>

<section class="bg-light py-5">
    <div class="container">
        <div class="section-heading text-center mb-5">
            <span class="section-kicker">Điểm đến phổ biến</span>
            <h2 class="fw-bold">Lấy cảm hứng cho chuyến đi tiếp theo</h2>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="destination-card h-100">
                    <img src="https://statics.vinpearl.com/canh-dep-da-lat-2_1688379781.jpg" class="img-fluid rounded" alt="Đà Lạt">
                    <h5 class="mt-3 text-center">Đà Lạt</h5>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="destination-card h-100">
                    <img src="https://statics.vinpearl.com/hoi-an-o-dau-1_1697556970.jpg" class="img-fluid rounded" alt="Hội An">
                    <h5 class="mt-3 text-center">Hội An</h5>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="destination-card h-100">
                    <img src="https://dongtayland.vn/wp-content/uploads/2019/03/du-hoc-singapore-jcus-minh-hoa-phu-quoc.jpg" class="img-fluid rounded" alt="Phú Quốc">
                    <h5 class="mt-3 text-center">Phú Quốc</h5>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="destination-card h-100">
                    <img src="https://ik.imagekit.io/tvlk/blog/2025/03/shutterstock_2477953603.jpg" class="img-fluid rounded" alt="Vũng Tàu">
                    <h5 class="mt-3 text-center">Vũng Tàu</h5>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container py-5">
    <div class="section-heading text-center mb-5">
        <span class="section-kicker">Trải nghiệm đồng bộ</span>
        <h2 class="fw-bold">Đầy đủ chức năng cho cả khách hàng và quản trị viên</h2>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="service-box h-100">
                <i class="bi bi-search-heart fs-1 text-primary"></i>
                <h5>Tìm phòng nhanh</h5>
                <p class="text-muted mb-0">
                    Tìm kiếm theo tên, khu vực và xem chi tiết homestay trong một luồng đơn giản, dễ hiểu.
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="service-box h-100">
                <i class="bi bi-calendar2-check fs-1 text-primary"></i>
                <h5>Đặt phòng rõ ràng</h5>
                <p class="text-muted mb-0">
                    Kiểm tra ngày ở, số khách, tổng tiền dự kiến và quản lý lịch sử booking ngay trên tài khoản.
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="service-box h-100">
                <i class="bi bi-kanban fs-1 text-primary"></i>
                <h5>Quản trị chuyên nghiệp</h5>
                <p class="text-muted mb-0">
                    Dashboard, quản lý phòng, duyệt booking và cập nhật nội dung được gom lại thành một hệ thống thống nhất.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="cta-section py-5">
    <div class="container">
        <div class="cta-panel text-center">
            <span class="section-kicker">Sẵn sàng cho kỳ nghỉ tiếp theo?</span>
            <h2 class="fw-bold text-white mb-3">Bắt đầu tìm homestay phù hợp với bạn ngay hôm nay</h2>
            <p class="text-white-50 mb-4">
                Khám phá danh sách phòng đang hoạt động và gửi yêu cầu đặt phòng chỉ trong vài phút.
            </p>
            <a href="{{ route('rooms.index') }}" class="btn btn-light btn-lg px-4">
                Xem toàn bộ homestay
            </a>
        </div>
    </div>
</section>
@endsection
