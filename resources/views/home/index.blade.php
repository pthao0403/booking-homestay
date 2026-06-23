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
                        <p>Tỉnh thành</p>
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

    <div class="row">
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card room-card h-100">
                <img src="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85"
                     class="room-image"
                     alt="Homestay View Biển">

                <div class="card-body">
                    <span class="badge bg-primary mb-2">Bestseller</span>
                    <h5 class="fw-bold">Homestay View Biển Vũng Tàu</h5>
                    <p class="text-primary fw-bold fs-5">650.000 VNĐ / đêm</p>
                    <p class="mb-2">Vũng Tàu</p>
                    <p class="text-muted">Homestay sát biển, thích hợp nghỉ dưỡng cuối tuần.</p>
                    <div class="mb-3">
                        ★★★★★
                        <small class="text-muted">(145 đánh giá)</small>
                    </div>
                    <a href="#" class="btn btn-primary w-100">Xem chi tiết</a>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card room-card h-100">
                <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267"
                     class="room-image"
                     alt="Đà Lạt">

                <div class="card-body">
                    <span class="badge bg-success mb-2">Yêu thích</span>
                    <h5 class="fw-bold">CloudStay Đà Lạt Garden</h5>
                    <p class="text-primary fw-bold fs-5">800.000 VNĐ / đêm</p>
                    <p class="mb-2">Đà Lạt</p>
                    <p class="text-muted">Không gian sân vườn yên tĩnh, gần Hồ Xuân Hương.</p>
                    <div class="mb-3">
                        ★★★★★
                        <small class="text-muted">(210 đánh giá)</small>
                    </div>
                    <a href="#" class="btn btn-primary w-100">Xem chi tiết</a>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card room-card h-100">
                <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945"
                     class="room-image"
                     alt="Hội An">

                <div class="card-body">
                    <span class="badge bg-warning text-dark mb-2">Hot</span>
                    <h5 class="fw-bold">Homestay Phố Cổ Hội An</h5>
                    <p class="text-primary fw-bold fs-5">720.000 VNĐ / đêm</p>
                    <p class="mb-2">Hội An, Quảng Nam</p>
                    <p class="text-muted">Thiết kế cổ điển, gần Chùa Cầu và khu phố đi bộ.</p>
                    <div class="mb-3">
                        ★★★★★
                        <small class="text-muted">(180 đánh giá)</small>
                    </div>
                    <a href="#" class="btn btn-primary w-100">Xem chi tiết</a>
                </div>
            </div>
        </div>
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
                    <img src="https://statics.vinpearl.com/canh-dep-da-lat-2_1688379781.jpg" class="img-fluid rounded">
                    <h5 class="mt-3 text-center">Đà Lạt</h5>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="destination-card">
                    <img src="https://statics.vinpearl.com/hoi-an-o-dau-1_1697556970.jpg" class="img-fluid rounded">
                    <h5 class="mt-3 text-center">Hội An</h5>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="destination-card">
                    <img src="https://dongtayland.vn/wp-content/uploads/2019/03/du-hoc-singapore-jcus-minh-hoa-phu-quoc.jpg" class="img-fluid rounded">
                    <h5 class="mt-3 text-center">Phú Quốc</h5>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="destination-card">
                    <img src="https://ik.imagekit.io/tvlk/blog/2025/03/shutterstock_2477953603.jpg" class="img-fluid rounded">
                    <h5 class="mt-3 text-center">Vũng Tàu</h5>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">Tiện Ích Nổi Bật</h2>
    </div>

    <div class="row text-center">
        <div class="col-md-3 mb-4">
            <div class="service-box">
                📶
                <h5>Wifi Miễn Phí</h5>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="service-box">
                🏊
                <h5>Hồ Bơi</h5>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="service-box">
                🍽
                <h5>Nhà Hàng</h5>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="service-box">
                🚗
                <h5>Bãi Đỗ Xe</h5>
            </div>
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

<section class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">Khách Hàng Nói Gì</h2>
    </div>

    <div class="row">
        @for($i = 1; $i <= 3; $i++)
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="mb-3">★★★★★</div>
                        <p>Dịch vụ tuyệt vời, phòng sạch đẹp, nhân viên hỗ trợ nhiệt tình.</p>
                        <h6 class="fw-bold">Nguyễn Văn A</h6>
                    </div>
                </div>
            </div>
        @endfor
    </div>
</section>

<section class="newsletter-section">
    <div class="container">
        <div class="card border-0 shadow-lg p-5 text-center">
            <h2 class="fw-bold mb-3">Nhận ưu đãi mới nhất</h2>
            <p class="text-muted mb-4">Đăng ký email để nhận thông tin khuyến mãi từ CloudStay.</p>

            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="Nhập email của bạn">
                        <button class="btn btn-primary">Đăng ký</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
