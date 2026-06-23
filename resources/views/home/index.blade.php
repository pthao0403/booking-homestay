@extends('layouts.app')

@section('title', 'CloudStay - Đặt Homestay')

@section('content')
<section class="hero-section text-white">
    <div class="container">
        <div class="row align-items-center min-vh-100">
            <div class="col-lg-6">
                <h1 class="display-3 fw-bold mb-4">
                    Khám phá những Homestay tuyệt vời cùng CloudStay
                </h1>

                <p class="lead mb-4">
                    Đặt phòng nhanh chóng, an toàn và tiện lợi.
                    Hàng trăm homestay chất lượng trên toàn quốc.
                </p>

                <div class="d-flex gap-3 flex-wrap">
                    <a href="/rooms" class="btn btn-primary btn-lg px-4">
                        Xem Homestay
                    </a>

                    <a href="{{ route('vouchers.index') }}" class="btn btn-warning btn-lg px-4">
                        Xem mã ưu đãi
                    </a>
                </div>
            </div>

            <div class="col-lg-6 text-center">
                <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945"
                     class="img-fluid rounded-4 shadow-lg"
                     alt="Homestay">
            </div>

            <div class="container">
                <div class="row text-center">
                    <div class="col-md-3">
                        <h2>500+</h2>
                        <p>Homestay</p>
                    </div>

                    <div class="col-md-3">
                        <h2>10K+</h2>
                        <p>Khách hàng</p>
                    </div>

                    <div class="col-md-3">
                        <h2>4.9</h2>
                        <p>Đánh giá</p>
                    </div>

                    <div class="col-md-3">
                        <h2>63</h2>
                        <p>Địa điểm</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container search-section">
    <div class="card border-0 shadow-lg p-4">
        <form action="{{ route('rooms.index') }}" method="GET">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text"
                           name="search"
                           class="form-control"
                           placeholder="Bạn muốn đi đâu?">
                </div>

                <div class="col-md-3">
                    <input type="date"
                           name="check_in"
                           class="form-control">
                </div>

                <div class="col-md-3">
                    <input type="date"
                           name="check_out"
                           class="form-control">
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        Tìm kiếm
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>

<section class="container section-spaced">
    <div class="text-center mb-5">
        <h2 class="fw-bold display-5">Homestay Nổi Bật</h2>
        <p class="text-muted fs-5">Những homestay được khách hàng yêu thích nhất</p>
    </div>

    @php
        $featuredRooms = $rooms->take(3);
        $badges = [
            ['label' => 'Bestseller', 'class' => 'bg-primary'],
            ['label' => 'Yêu thích', 'class' => 'bg-success'],
            ['label' => 'Hot', 'class' => 'bg-warning text-dark'],
        ];
        $fallbackImage = 'https://images.unsplash.com/photo-1566073771259-6a8506099945';
    @endphp

    <div class="row">
        @forelse($featuredRooms as $index => $room)
            @php
                $badge = $badges[$index] ?? ['label' => 'Nổi bật', 'class' => 'bg-primary'];
                $thumbUrl = $room->thumbnail_url ?: $fallbackImage;
            @endphp
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card room-card h-100">
                    <img src="{{ $thumbUrl }}"
                         class="room-image"
                         alt="{{ $room->name }}">

                    <div class="card-body">
                        <span class="badge {{ $badge['class'] }} mb-2">{{ $badge['label'] }}</span>
                        <h5 class="fw-bold">{{ $room->name }}</h5>
                        <p class="text-primary fw-bold fs-5">{{ number_format((float) $room->price) }} VNĐ / đêm</p>
                        <p class="mb-2">{{ $room->location }}</p>
                        <p class="text-muted">{{ \Illuminate\Support\Str::limit($room->description, 90) }}</p>
                        <div class="mb-3">
                            ★★★★★
                            <small class="text-muted">(Phòng nổi bật)</small>
                        </div>
                        <a href="{{ route('rooms.index') }}" class="btn btn-primary w-100">Xem chi tiết</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-light border text-center mb-0">
                    Hiện chưa có homestay nổi bật để hiển thị.
                </div>
            </div>
        @endforelse
    </div>
</section>

<section class="bg-light py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Điểm Đến Phổ Biến</h2>
        </div>

        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="destination-card">
                    <img src="https://statics.vinpearl.com/canh-dep-da-lat-2_1688379781.jpg" class="img-fluid rounded" alt="Đà Lạt">
                    <h5 class="mt-3 text-center">Đà Lạt</h5>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="destination-card">
                    <img src="https://statics.vinpearl.com/hoi-an-o-dau-1_1697556970.jpg" class="img-fluid rounded" alt="Hội An">
                    <h5 class="mt-3 text-center">Hội An</h5>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="destination-card">
                    <img src="https://dongtayland.vn/wp-content/uploads/2019/03/du-hoc-singapore-jcus-minh-hoa-phu-quoc.jpg" class="img-fluid rounded" alt="Phú Quốc">
                    <h5 class="mt-3 text-center">Phú Quốc</h5>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="destination-card">
                    <img src="https://ik.imagekit.io/tvlk/blog/2025/03/shutterstock_2477953603.jpg" class="img-fluid rounded" alt="Vũng Tàu">
                    <h5 class="mt-3 text-center">Vũng Tàu</h5>
                </div>
            </div>
        </div>
    </div>
</section>

@php
    $amenities = [
        [
            'icon' => 'bi-wifi',
            'title' => 'Wifi Miễn Phí',
            'desc' => 'Kết nối ổn định cho làm việc, giải trí và liên lạc mọi lúc.',
            'tone' => 'linear-gradient(135deg, #6366f1, #4338ca)',
        ],
        [
            'icon' => 'bi-water',
            'title' => 'Hồ Bơi',
            'desc' => 'Không gian thư giãn lý tưởng cho kỳ nghỉ cùng gia đình và bạn bè.',
            'tone' => 'linear-gradient(135deg, #06b6d4, #0ea5e9)',
        ],
        [
            'icon' => 'bi-cup-hot-fill',
            'title' => 'Nhà Hàng',
            'desc' => 'Thưởng thức bữa sáng và ẩm thực địa phương ngay trong khu nghỉ.',
            'tone' => 'linear-gradient(135deg, #f59e0b, #ef4444)',
        ],
        [
            'icon' => 'bi-car-front-fill',
            'title' => 'Bãi Đỗ Xe',
            'desc' => 'Chỗ đậu xe rộng rãi, an toàn và thuận tiện cho cả ô tô lẫn xe máy.',
            'tone' => 'linear-gradient(135deg, #10b981, #059669)',
        ],
    ];
@endphp

<section class="py-5" style="background: radial-gradient(circle at top center, rgba(99, 102, 241, 0.08), transparent 38%), #ffffff;">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge rounded-pill px-3 py-2 mb-3" style="background: rgba(16, 185, 129, 0.12); color: #0f766e;">Trải nghiệm lưu trú</span>
            <h2 class="fw-bold mb-2">Tiện Ích Nổi Bật</h2>
            <p class="text-muted mb-0">Những tiện nghi giúp chuyến đi của bạn thoải mái, tiện lợi và đáng nhớ hơn</p>
        </div>

        <div class="row g-4">
            @foreach($amenities as $amenity)
                <div class="col-lg-3 col-md-6">
                    <div class="h-100 p-4 text-center" style="border-radius: 26px; background: #fff; border: 1px solid #f1f5f9; box-shadow: 0 18px 35px rgba(15, 23, 42, 0.08); transition: transform 0.25s ease, box-shadow 0.25s ease;">
                        <div class="mx-auto mb-4 d-flex align-items-center justify-content-center text-white" style="width: 72px; height: 72px; border-radius: 22px; background: {{ $amenity['tone'] }}; box-shadow: 0 14px 28px rgba(79, 70, 229, 0.18);">
                            <i class="bi {{ $amenity['icon'] }}" style="font-size: 1.7rem;"></i>
                        </div>
                        <h5 class="fw-bold mb-3">{{ $amenity['title'] }}</h5>
                        <p class="text-muted mb-0" style="line-height: 1.7;">{{ $amenity['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-primary text-white py-5">
    <div class="container text-center">
        <h2 class="fw-bold mb-3">Ưu đãi mùa hè</h2>

        @if($featuredVoucher && $featuredVoucherLabel)
            <p class="lead mb-4">
                Nhập mã <strong>{{ $featuredVoucher['code'] }}</strong> để {{ strtolower($featuredVoucherLabel) }} khi đặt phòng
            </p>
        @else
            <p class="lead mb-4">
                Theo dõi các chương trình khuyến mãi mới nhất từ CloudStay.
            </p>
        @endif

        <a href="/rooms" class="btn btn-light btn-lg">
            Đặt ngay
        </a>
    </div>
</section>

@php
    $testimonials = [
        [
            'name' => 'Lan Hương',
            'role' => 'Khách du lịch cuối tuần',
            'content' => 'Phòng sạch, ảnh giống thực tế và quá trình đặt phòng rất nhanh. Mình đặc biệt thích cách hỗ trợ qua website rất rõ ràng.',
            'tone' => 'linear-gradient(135deg, #6366f1, #4338ca)',
        ],
        [
            'name' => 'Minh Quân',
            'role' => 'Gia đình 4 người',
            'content' => 'Check-in thuận tiện, homestay đẹp và yên tĩnh. Mã ưu đãi áp dụng mượt nên trải nghiệm đặt phòng thấy rất chuyên nghiệp.',
            'tone' => 'linear-gradient(135deg, #0ea5e9, #14b8a6)',
        ],
        [
            'name' => 'Thảo Vy',
            'role' => 'Cặp đôi nghỉ dưỡng',
            'content' => 'Giao diện dễ dùng, xem lịch sử đặt phòng và hóa đơn cũng rất rõ. Đây là một trong những website homestay dễ dùng nhất mình từng thử.',
            'tone' => 'linear-gradient(135deg, #f59e0b, #ef4444)',
        ],
    ];
@endphp

<section class="py-5" style="background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge rounded-pill px-3 py-2 mb-3" style="background: rgba(99, 102, 241, 0.12); color: #4f46e5;">Đánh giá nổi bật</span>
            <h2 class="fw-bold mb-2">Khách Hàng Nói Gì</h2>
            <p class="text-muted mb-0">Những cảm nhận chân thực sau khi trải nghiệm đặt phòng cùng CloudStay</p>
        </div>

        <div class="row g-4">
            @foreach($testimonials as $testimonial)
                <div class="col-lg-4 col-md-6">
                    <div class="h-100 p-4" style="border-radius: 24px; background: #fff; border: 1px solid #eef2ff; box-shadow: 0 20px 45px rgba(15, 23, 42, 0.08);">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="d-flex align-items-center justify-content-center fw-bold text-white" style="width: 52px; height: 52px; border-radius: 16px; background: {{ $testimonial['tone'] }};">
                                    {{ \Illuminate\Support\Str::substr($testimonial['name'], 0, 1) }}
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">{{ $testimonial['name'] }}</h6>
                                    <p class="text-muted mb-0" style="font-size: 0.92rem;">{{ $testimonial['role'] }}</p>
                                </div>
                            </div>

                            <div class="fw-bold" style="font-size: 2rem; line-height: 1; color: #c7d2fe;">“</div>
                        </div>

                        <div class="mb-3" style="letter-spacing: 2px; color: #f59e0b;">★★★★★</div>
                        <p class="mb-4" style="color: #334155; line-height: 1.8;">{{ $testimonial['content'] }}</p>

                        <div class="d-flex align-items-center justify-content-between pt-3" style="border-top: 1px solid #eef2ff;">
                            <span class="text-muted" style="font-size: 0.92rem;">Đã xác minh đặt phòng</span>
                            <span class="badge rounded-pill px-3 py-2" style="background: #eef2ff; color: #4338ca;">5.0 / 5</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="newsletter-section py-5" style="background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);">
    <div class="container">
        <div class="border-0 shadow-lg p-4 p-lg-5 text-center position-relative overflow-hidden" style="border-radius: 32px; background: radial-gradient(circle at top left, rgba(99, 102, 241, 0.12), transparent 30%), radial-gradient(circle at bottom right, rgba(16, 185, 129, 0.12), transparent 30%), #ffffff;">
            <div class="position-absolute top-0 start-0 translate-middle rounded-circle" style="width: 180px; height: 180px; background: rgba(99, 102, 241, 0.08);"></div>
            <div class="position-absolute bottom-0 end-0 translate-middle rounded-circle" style="width: 220px; height: 220px; background: rgba(16, 185, 129, 0.08);"></div>

            <div class="position-relative">
                <span class="badge rounded-pill px-3 py-2 mb-3" style="background: rgba(99, 102, 241, 0.12); color: #4f46e5;">CloudStay Updates</span>
                <h2 class="fw-bold mb-3">Nhận ưu đãi mới nhất</h2>
                <p class="text-muted mb-4 mx-auto" style="max-width: 620px;">
                    Đăng ký email để nhận thông tin khuyến mãi, mã giảm giá nổi bật và gợi ý homestay phù hợp từ CloudStay.
                </p>

                <div class="row justify-content-center">
                    <div class="col-lg-7">
                        <form action="{{ route('vouchers.index') }}" method="GET">
                            <div class="input-group input-group-lg shadow-sm" style="border-radius: 18px; overflow: hidden;">
                                <span class="input-group-text border-0 bg-white text-muted px-4">
                                    <i class="bi bi-envelope-paper-heart"></i>
                                </span>
                                <input type="email"
                                       class="form-control border-0 py-3"
                                       name="email"
                                       value="{{ auth()->check() ? auth()->user()->email : '' }}"
                                       placeholder="Nhập email của bạn">
                                <button class="btn btn-primary px-4 fw-semibold" style="background: linear-gradient(135deg, #6366f1, #4f46e5); border: none;">
                                    Đăng ký
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="d-flex justify-content-center flex-wrap gap-3 mt-4 text-muted" style="font-size: 0.95rem;">
                    <span><i class="bi bi-check-circle-fill text-success me-2"></i>Cập nhật voucher mới</span>
                    <span><i class="bi bi-check-circle-fill text-success me-2"></i>Không spam</span>
                    <span><i class="bi bi-check-circle-fill text-success me-2"></i>Ưu đãi chọn lọc mỗi tuần</span>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
