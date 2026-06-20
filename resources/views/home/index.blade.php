@extends('layouts.app')

@section('content')

<!-- HERO SECTION -->

<section class="bg-primary text-white rounded-4 overflow-hidden mb-5">
<div class="container py-5">

    <div class="row align-items-center">

        <div class="col-lg-6">

            <h1 class="display-4 fw-bold mb-3">
                Tìm Homestay Lý Tưởng
            </h1>

            <p class="lead mb-4">
                Khám phá hàng trăm homestay đẹp trên toàn quốc.
                Đặt phòng nhanh chóng, an toàn và tiện lợi.
            </p>

            <form class="row g-2">

                <div class="col-md-4">
                    <input type="text"
                           class="form-control"
                           placeholder="Bạn muốn đi đâu?">
                </div>

                <div class="col-md-3">
                    <input type="date"
                           class="form-control">
                </div>

                <div class="col-md-3">
                    <input type="date"
                           class="form-control">
                </div>

                <div class="col-md-2">
                    <button class="btn btn-warning w-100">
                        Tìm
                    </button>
                </div>

            </form>

            <div class="row mt-5">

                <div class="col-3">
                    <h3>1000+</h3>
                    <small>Homestay</small>
                </div>

                <div class="col-3">
                    <h3>5000+</h3>
                    <small>Khách hàng</small>
                </div>

                <div class="col-3">
                    <h3>4.9★</h3>
                    <small>Đánh giá</small>
                </div>

                <div class="col-3">
                    <h3>24/7</h3>
                    <small>Hỗ trợ</small>
                </div>

            </div>

        </div>

        <div class="col-lg-6 text-center">

            <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=1200"
                 class="img-fluid rounded-4 shadow">

        </div>

    </div>

</div>
</section>

<!-- GIỚI THIỆU -->

<section class="mb-5">
<div class="text-center">

    <h2 class="fw-bold">
        Vì Sao Chọn CloudStay?
    </h2>

    <p class="text-muted">
        Nền tảng đặt homestay hiện đại trên nền tảng Cloud.
    </p>

</div>

<div class="row mt-4">

    <div class="col-md-4 mb-3">

        <div class="card h-100 shadow-sm border-0">

            <div class="card-body text-center">

                <h1>🏡</h1>

                <h5>
                    Homestay Chất Lượng
                </h5>

                <p>
                    Hàng trăm homestay được kiểm duyệt.
                </p>

            </div>

        </div>

    </div>

    <div class="col-md-4 mb-3">

        <div class="card h-100 shadow-sm border-0">

            <div class="card-body text-center">

                <h1>💳</h1>

                <h5>
                    Đặt Phòng Nhanh
                </h5>

                <p>
                    Chỉ vài thao tác để hoàn tất booking.
                </p>

            </div>

        </div>

    </div>

    <div class="col-md-4 mb-3">

        <div class="card h-100 shadow-sm border-0">

            <div class="card-body text-center">

                <h1>📞</h1>

                <h5>
                    Hỗ Trợ 24/7
                </h5>

                <p>
                    Luôn sẵn sàng hỗ trợ khách hàng.
                </p>

            </div>

        </div>

    </div>

</div>

</section>

<!-- HOMESTAY NỔI BẬT -->

<section class="container section-spaced">
<div class="text-center mb-5">
    <h2 class="fw-bold">Homestay Nổi Bật</h2>
    <p class="text-muted">
        Những homestay được khách hàng yêu thích nhất
    </p>
</div>

<div class="row">

    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card room-card">

            <img src="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85"
                 class="room-image">

            <div class="card-body">

                <h5 class="fw-bold">
                    Homestay View Biển Vũng Tàu
                </h5>

                <p>
                    <strong>Giá:</strong>
                    650.000 VNĐ / đêm
                </p>

                <p>
                    <strong>Địa chỉ:</strong>
                    Thành phố Vũng Tàu
                </p>

                <p class="text-muted">
                    Homestay sát biển, ban công rộng,
                    thích hợp nghỉ dưỡng cuối tuần.
                </p>

                <a href="#"
                   class="btn btn-primary w-100">
                    Xem chi tiết
                </a>

            </div>

        </div>
    </div>

    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card room-card">

            <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267"
                 class="room-image">

            <div class="card-body">

                <h5 class="fw-bold">
                    CloudStay Đà Lạt Garden
                </h5>

                <p>
                    <strong>Giá:</strong>
                    800.000 VNĐ / đêm
                </p>

                <p>
                    <strong>Địa chỉ:</strong>
                    Thành phố Đà Lạt
                </p>

                <p class="text-muted">
                    Không gian sân vườn yên tĩnh,
                    gần Hồ Xuân Hương.
                </p>

                <a href="#"
                   class="btn btn-primary w-100">
                    Xem chi tiết
                </a>

            </div>

        </div>
    </div>

    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card room-card">

            <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945"
                 class="room-image">

            <div class="card-body">

                <h5 class="fw-bold">
                    Homestay Phố Cổ Hội An
                </h5>

                <p>
                    <strong>Giá:</strong>
                    720.000 VNĐ / đêm
                </p>

                <p>
                    <strong>Địa chỉ:</strong>
                    Hội An, Quảng Nam
                </p>

                <p class="text-muted">
                    Thiết kế cổ điển, gần Chùa Cầu
                    và khu phố đi bộ.
                </p>

                <a href="#"
                   class="btn btn-primary w-100">
                    Xem chi tiết
                </a>

            </div>

        </div>
    </div>

</div>
</section>

<!-- NEWSLETTER -->

<section class="bg-light rounded-4 p-5 text-center mt-5">
<h3 class="fw-bold">
    Nhận Thông Tin Khuyến Mãi
</h3>

<p class="text-muted">
    Đăng ký email để nhận ưu đãi mới nhất từ CloudStay.
</p>

<div class="row justify-content-center">

    <div class="col-md-6">

        <div class="input-group">

            <input type="email"
                   class="form-control"
                   placeholder="Email của bạn">

            <button class="btn btn-primary">
                Đăng ký
            </button>

        </div>

    </div>

</div>

</section>

@endsection
