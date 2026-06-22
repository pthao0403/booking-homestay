@extends('layouts.app')

@section('title', $room->name . ' - CloudStay')

@section('content')
<div class="room-detail-page">
    <!-- Header Section -->
    <section class="detail-hero">
        <div class="container">
            <a href="{{ route('rooms.index') }}" class="back-link">
                <i class="bi bi-chevron-left"></i> Quay lại danh sách
            </a>
            <div class="hero-content">
                <div>
                    <h1 class="detail-title">{{ $room->name }}</h1>
                    <p class="detail-location"><i class="bi bi-geo-alt"></i> {{ $room->location }}</p>
                </div>
                <div class="detail-price-banner">
                    <span class="price-value">{{ number_format($room->price) }}</span>
                    <span class="price-unit">VNĐ/đêm</span>
                </div>
            </div>
        </div>
    </section>

    <div class="container detail-container">
        <div class="detail-layout">
            <!-- Main Content -->
            <div class="detail-main">
                <!-- Main Image -->
                @php
                    $fallback = 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800';
                    $thumbUrl = $room->thumbnail_url ?: $fallback;
                @endphp
                
                <div class="main-image-container">
                    <img src="{{ $thumbUrl }}" alt="{{ $room->name }}" class="main-image">
                </div>

                <!-- Gallery -->
                @include('rooms.gallery')

                <!-- Description Section -->
                <section class="info-section">
                    <h2 class="section-title"><i class="bi bi-info-circle"></i> Thông Tin Chi Tiết</h2>
                    <p class="section-description">{{ $room->description }}</p>
                </section>

                <!-- Features Section -->
                <section class="features-section">
                    @php
                        $roomTypes = [
                            'single' => 'Phòng đơn',
                            'double' => 'Phòng đôi',
                            'suite' => 'Phòng cao cấp (Suite)',
                            'vip' => 'Phòng VIP',
                            'family_suite' => 'Phòng Gia đình (Family Suite)'
                        ];
                    @endphp

                    <div class="feature-card">
                        <div class="feature-icon capacity">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <h3>Sức chứa tối đa</h3>
                        <p class="feature-value">{{ $room->capacity }} người</p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon type">
                            <i class="bi bi-door-closed"></i>
                        </div>
                        <h3>Loại phòng</h3>
                        <p class="feature-value">{{ $roomTypes[$room->type] ?? ucfirst($room->type) }}</p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon status">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <h3>Trạng thái</h3>
                        <p class="feature-value">{{ $room->status === 'available' ? 'Còn trống' : 'Hết phòng' }}</p>
                    </div>
                </section>

                <!-- Amenities Section -->
                <section class="amenities-section">
                    <h2 class="section-title"><i class="bi bi-check-lg"></i> Tiện Nghi</h2>
                    <div class="amenities-grid">
                        <div class="amenity-item">
                            <i class="bi bi-wifi"></i>
                            <span>WiFi miễn phí</span>
                        </div>
                        <div class="amenity-item">
                            <i class="bi bi-lock"></i>
                            <span>An ninh 24/7</span>
                        </div>
                        <div class="amenity-item">
                            <i class="bi bi-cup-fill"></i>
                            <span>Bếp nấu ăn</span>
                        </div>
                        <div class="amenity-item">
                            <i class="bi bi-tv"></i>
                            <span>TV màn hình phẳng</span>
                        </div>
                        <div class="amenity-item">
                            <i class="bi bi-droplet"></i>
                            <span>Nước nóng</span>
                        </div>
                        <div class="amenity-item">
                            <i class="bi bi-wind"></i>
                            <span>Điều hòa không khí</span>
                        </div>
                    </div>
                </section>

                <!-- Map Placeholder -->
                <section class="map-section">
                    <h2 class="section-title"><i class="bi bi-map"></i> Vị Trí</h2>
                    <div class="map-placeholder">
                        <i class="bi bi-geo-alt"></i>
                        <p>Bản đồ vị trí sẽ hiển thị tại đây</p>
                        <small>Google Maps sẽ được tích hợp sớm</small>
                    </div>
                </section>
            </div>

            <!-- Sidebar -->
            <aside class="detail-sidebar">
                <!-- Booking Card -->
                <div class="booking-card">
                    <div class="card-price">
                        <p class="price-label">Giá một đêm</p>
                        <p class="price-amount">{{ number_format($room->price) }} VNĐ</p>
                    </div>

                    <!-- Status Alert -->
                    @if($room->status === 'available')
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle-fill"></i>
                            <strong>Phòng còn trống</strong>
                        </div>
                    @else
                        <div class="alert alert-danger">
                            <i class="bi bi-x-circle-fill"></i>
                            <strong>Phòng đã hết</strong>
                        </div>
                    @endif

                    <!-- Quick Info -->
                    <div class="quick-info">
                        <p><i class="bi bi-people-fill"></i> Tối đa {{ $room->capacity }} khách</p>
                        <p><i class="bi bi-door-closed"></i> {{ $roomTypes[$room->type] ?? ucfirst($room->type) }}</p>
                    </div>

                    <!-- Buttons -->
                    <div class="card-buttons">
                        @if($room->status === 'available')
                            <a href="{{ route('rooms.booking', $room) }}" class="btn btn-primary btn-lg">
                                <i class="bi bi-calendar-check"></i> Đặt Phòng Ngay
                            </a>
                        @else
                            <button class="btn btn-primary btn-lg" disabled>
                                <i class="bi bi-x-circle"></i> Phòng Đã Hết
                            </button>
                        @endif
                        
                        <button class="btn btn-outline">
                            <i class="bi bi-heart"></i> Yêu Thích
                        </button>
                    </div>

                    <!-- Policies -->
                    <div class="card-policies">
                        <p><i class="bi bi-info-circle"></i> Hủy đặt phòng miễn phí trước 24 giờ</p>
                        <p><i class="bi bi-shield-check"></i> Thanh toán khi nhận hoặc trực tuyến</p>
                    </div>
                </div>

                <!-- Contact Card -->
                <div class="contact-card">
                    <p class="contact-title"><i class="bi bi-question-circle"></i> Có câu hỏi?</p>
                    <p class="contact-desc">Liên hệ chủ nhà để biết thêm chi tiết</p>
                    <button class="btn btn-primary btn-block">
                        <i class="bi bi-chat-dots"></i> Chat với chủ nhà
                    </button>
                </div>
            </aside>
        </div>
    </div>
</div>

<style>
    .room-detail-page {
        background: #f9fafb;
        min-height: 100vh;
        padding-bottom: 3rem;
    }

    .detail-hero {
        background: linear-gradient(135deg, #6366f1 0%, #10b981 100%);
        color: white;
        padding: 2rem 0;
        margin-bottom: 2rem;
    }

    .back-link {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
        transition: color 0.3s;
        font-size: 0.95rem;
    }

    .back-link:hover {
        color: white;
    }

    .hero-content {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 2rem;
    }

    .detail-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .detail-location {
        font-size: 1.1rem;
        opacity: 0.9;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .detail-price-banner {
        text-align: right;
    }

    .price-value {
        display: block;
        font-size: 2rem;
        font-weight: 700;
    }

    .price-unit {
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .detail-container {
        margin-top: 2rem;
        margin-bottom: 3rem;
    }

    .detail-layout {
        display: grid;
        grid-template-columns: 1fr 350px;
        gap: 2rem;
    }

    .detail-main {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .main-image-container {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .main-image {
        width: 100%;
        height: auto;
        max-height: 600px;
        object-fit: cover;
        display: block;
    }

    .info-section,
    .amenities-section,
    .map-section {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: #1f2937;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-title i {
        color: #6366f1;
    }

    .section-description {
        color: #4b5563;
        line-height: 1.8;
        font-size: 1.05rem;
    }

    .features-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
    }

    .feature-card {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .feature-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        margin: 0 auto 1rem;
    }

    .feature-icon.capacity {
        background: linear-gradient(135deg, #6366f1 0%, #7c3aed 100%);
    }

    .feature-icon.type {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .feature-icon.status {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .feature-card h3 {
        font-size: 0.95rem;
        color: #6b7280;
        margin-bottom: 0.5rem;
    }

    .feature-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1f2937;
    }

    .amenities-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
    }

    .amenity-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: #4b5563;
        padding: 1rem;
        background: #f3f4f6;
        border-radius: 8px;
    }

    .amenity-item i {
        color: #6366f1;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .map-placeholder {
        background: linear-gradient(135deg, #e5e7eb 0%, #d1d5db 100%);
        border-radius: 12px;
        padding: 3rem;
        text-align: center;
        color: #6b7280;
    }

    .map-placeholder i {
        font-size: 3rem;
        color: #9ca3af;
        display: block;
        margin-bottom: 1rem;
    }

    .map-placeholder p {
        margin: 0.5rem 0;
    }

    .map-placeholder small {
        display: block;
        color: #9ca3af;
        margin-top: 0.5rem;
    }

    .detail-sidebar {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        height: fit-content;
        position: sticky;
        top: 100px;
    }

    .booking-card,
    .contact-card {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .booking-card {
        border: 2px solid #e5e7eb;
    }

    .card-price {
        text-align: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid #e5e7eb;
    }

    .price-label {
        color: #6b7280;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .price-amount {
        font-size: 2rem;
        font-weight: 700;
        color: #6366f1;
    }

    .alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 600;
    }

    .alert-success {
        background: #d1fae5;
        color: #047857;
    }

    .alert-danger {
        background: #fee2e2;
        color: #dc2626;
    }

    .quick-info {
        background: #f3f4f6;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }

    .quick-info p {
        color: #6b7280;
        font-size: 0.9rem;
        margin: 0.5rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .quick-info i {
        color: #6366f1;
    }

    .card-buttons {
        display: grid;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, #6366f1 0%, #7c3aed 100%);
        color: white;
    }

    .btn-primary:hover:not(:disabled) {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
    }

    .btn-primary:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .btn-outline {
        background: white;
        color: #6366f1;
        border: 2px solid #6366f1;
    }

    .btn-outline:hover {
        background: #f0f4ff;
    }

    .btn-lg {
        padding: 1rem;
        font-size: 1rem;
        width: 100%;
    }

    .btn-block {
        width: 100%;
    }

    .card-policies {
        padding-top: 1.5rem;
        border-top: 2px solid #e5e7eb;
    }

    .card-policies p {
        color: #6b7280;
        font-size: 0.85rem;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .card-policies i {
        color: #6366f1;
    }

    .contact-card {
        background: #f0f4ff;
        border-left: 4px solid #6366f1;
    }

    .contact-title {
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .contact-title i {
        color: #6366f1;
    }

    .contact-desc {
        color: #4b5563;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    @media (max-width: 1024px) {
        .detail-layout {
            grid-template-columns: 1fr;
        }

        .detail-sidebar {
            position: relative;
            top: auto;
        }
    }

    @media (max-width: 768px) {
        .detail-title {
            font-size: 1.75rem;
        }

        .hero-content {
            flex-direction: column;
        }

        .detail-price-banner {
            text-align: left;
        }

        .features-section {
            grid-template-columns: 1fr;
        }

        .amenities-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>
@endsection
