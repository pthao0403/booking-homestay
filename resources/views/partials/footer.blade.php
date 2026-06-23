<footer class="text-white mt-5" style="background: linear-gradient(180deg, #1f2937 0%, #111827 100%);">
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-lg-4">
                <h4 class="fw-bold mb-3" style="color: #3b82f6;">CloudStay</h4>
                <p class="text-light mb-0" style="line-height: 1.8;">
                    Nền tảng đặt homestay trực tuyến giúp khách hàng tìm kiếm,
                    đặt phòng và quản lý booking một cách nhanh chóng, tiện lợi và an toàn.
                </p>
            </div>

            <div class="col-lg-2 col-md-4">
                <h5 class="fw-bold mb-3">Liên kết</h5>
                <ul class="list-unstyled d-grid gap-2 mb-0">
                    <li><a href="{{ route('home') }}" class="text-decoration-none text-light">Trang chủ</a></li>
                    <li><a href="{{ route('rooms.index') }}" class="text-decoration-none text-light">Homestay</a></li>
                    <li><a href="{{ route('vouchers.index') }}" class="text-decoration-none text-light">Mã ưu đãi</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-4">
                <h5 class="fw-bold mb-3">Hỗ trợ</h5>
                <ul class="list-unstyled d-grid gap-2 mb-0">
                    <li><i class="bi bi-envelope-fill me-2 text-info"></i>support@cloudstay.com</li>
                    <li><i class="bi bi-telephone-fill me-2 text-info"></i>1900 1234</li>
                    <li><i class="bi bi-clock-fill me-2 text-info"></i>Hỗ trợ 24/7</li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-4">
                <h5 class="fw-bold mb-3">Theo dõi chúng tôi</h5>
                <div class="d-flex gap-3 fs-4">
                    <a href="#" class="text-white" aria-label="Facebook">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#" class="text-white" aria-label="Instagram">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="#" class="text-white" aria-label="YouTube">
                        <i class="bi bi-youtube"></i>
                    </a>
                    <a href="#" class="text-white" aria-label="TikTok">
                        <i class="bi bi-tiktok"></i>
                    </a>
                </div>
                <p class="text-light mt-3 mb-0" style="font-size: 0.95rem;">
                    Cập nhật ưu đãi, địa điểm nổi bật và kinh nghiệm du lịch mới nhất.
                </p>
            </div>
        </div>

        <hr class="border-secondary my-4">

        <div class="text-center">
            <small>© {{ date('Y') }} CloudStay. All Rights Reserved.</small>
        </div>
    </div>
</footer>
