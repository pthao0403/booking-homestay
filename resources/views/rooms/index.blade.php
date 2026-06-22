@extends('layouts.app')

@section('title', 'Tìm kiếm phòng - CloudStay')

@section('content')
<div class="rooms-page">
    <!-- Header Section -->
    <section class="rooms-hero">
        <div class="container">
            <h1 class="hero-title">Khám Phá Những Phòng Xinh Đẹp</h1>
            <p class="hero-subtitle">Tìm kiếm và đặt phòng homestay yêu thích của bạn</p>
        </div>
    </section>

    <div class="container">
        <!-- Filter Section -->
        <section class="filter-section">
            <div class="filter-card">
                <form method="GET" class="filter-form">
                    <div class="form-group">
                        <label for="search">Tìm kiếm phòng</label>
                        <input type="text" id="search" name="search" class="form-control" placeholder="Tên phòng, địa chỉ..." value="{{ request('search') }}">
                    </div>
                    
                    <div class="form-group">
                        <label for="check_in">Ngày nhận phòng</label>
                        <input type="date" id="check_in" name="check_in" class="form-control" value="{{ request('check_in') }}">
                    </div>
                    
                    <div class="form-group">
                        <label for="check_out">Ngày trả phòng</label>
                        <input type="date" id="check_out" name="check_out" class="form-control" value="{{ request('check_out') }}">
                    </div>
                    
                    <div class="form-group btn-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> Tìm kiếm
                        </button>
                        @if(request('search') || request('check_in') || request('check_out'))
                            <a href="{{ route('rooms.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Xóa lọc
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </section>

        <!-- Results Info -->
        @if($rooms->total() > 0)
            <div class="results-info">
                <p>Tìm thấy <strong>{{ $rooms->total() }}</strong> phòng</p>
            </div>
        @endif

        <!-- Rooms Grid -->
        <div class="rooms-grid">
            @forelse($rooms as $room)
                @php
                    $fallback = 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=500';
                    $thumbUrl = $room->thumbnail_url ?: $fallback;
                    $roomTypes = [
                        'single' => 'Phòng đơn',
                        'double' => 'Phòng đôi',
                        'suite' => 'Suite',
                        'vip' => 'VIP',
                        'family_suite' => 'Gia đình'
                    ];
                @endphp
                
                <div class="room-card">
                    <!-- Image Container -->
                    <div class="room-image-wrapper">
                        <img src="{{ $thumbUrl }}" alt="{{ $room->name }}" class="room-image">
                        <span class="room-badge">{{ $roomTypes[$room->type] ?? ucfirst($room->type) }}</span>
                    </div>
                    
                    <!-- Content -->
                    <div class="room-content">
                        <h3 class="room-title">{{ $room->name }}</h3>
                        
                        <!-- Location -->
                        <p class="room-location">
                            <i class="bi bi-geo-alt"></i>
                            {{ $room->location }}
                        </p>
                        
                        <!-- Features -->
                        <div class="room-features">
                            <span class="feature-item">
                                <i class="bi bi-people-fill"></i>
                                {{ $room->capacity }} người
                            </span>
                        </div>
                        
                        <!-- Description -->
                        <p class="room-description">{{ Str::limit($room->description, 80) }}</p>
                        
                        <!-- Footer -->
                        <div class="room-footer">
                            <span class="room-price">{{ number_format($room->price) }}<small> VNĐ/đêm</small></span>
                            <a href="{{ route('rooms.show', $room) }}" class="btn btn-outline-primary">Chi Tiết <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <p>Không tìm thấy phòng nào phù hợp.</p>
                    <a href="{{ route('rooms.index') }}" class="btn btn-primary">Xem tất cả phòng</a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($rooms->total() > 0)
            <div class="pagination-wrapper">
                {{ $rooms->links() }}
            </div>
        @endif
    </div>
</div>

<style>
    .rooms-page {
        background: #f9fafb;
        min-height: 100vh;
        padding-bottom: 3rem;
    }

    .rooms-hero {
        background: linear-gradient(135deg, #6366f1 0%, #10b981 100%);
        color: white;
        padding: 4rem 0;
        margin-bottom: 3rem;
    }

    .hero-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .hero-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    .filter-section {
        margin-bottom: 3rem;
    }

    .filter-card {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .filter-form {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1.5rem;
        align-items: flex-end;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #1f2937;
        font-size: 0.9rem;
    }

    .form-control {
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 1rem;
        transition: border-color 0.3s;
    }

    .form-control:focus {
        outline: none;
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    .btn-group {
        display: flex;
        gap: 0.5rem;
        flex-direction: row;
    }

    .results-info {
        margin-bottom: 2rem;
        color: #6b7280;
    }

    .rooms-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .room-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .room-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
    }

    .room-image-wrapper {
        position: relative;
        height: 240px;
        overflow: hidden;
        background: #e5e7eb;
    }

    .room-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s;
    }

    .room-card:hover .room-image {
        transform: scale(1.05);
    }

    .room-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        background: #10b981;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
    }

    .room-content {
        padding: 1.5rem;
    }

    .room-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: #1f2937;
    }

    .room-location {
        color: #6b7280;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
    }

    .room-location i {
        color: #ef4444;
    }

    .room-features {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
        font-size: 0.875rem;
        color: #6b7280;
        flex-wrap: wrap;
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .feature-item i {
        color: #6366f1;
    }

    .room-description {
        color: #6b7280;
        font-size: 0.9rem;
        margin-bottom: 1rem;
        line-height: 1.5;
    }

    .room-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        border-top: 1px solid #e5e7eb;
    }

    .room-price {
        font-size: 1.5rem;
        font-weight: 700;
        color: #6366f1;
    }

    .room-price small {
        font-size: 0.75rem;
        color: #6b7280;
        font-weight: 400;
    }

    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 3rem;
    }

    .empty-state i {
        font-size: 3rem;
        color: #d1d5db;
        margin-bottom: 1rem;
        display: block;
    }

    .empty-state p {
        color: #6b7280;
        font-size: 1.1rem;
        margin-bottom: 1rem;
    }

    .pagination-wrapper {
        display: flex;
        justify-content: center;
    }

    @media (max-width: 768px) {
        .rooms-grid {
            grid-template-columns: 1fr;
        }

        .filter-form {
            grid-template-columns: 1fr;
        }

        .hero-title {
            font-size: 1.75rem;
        }
    }
</style>
@endsection
