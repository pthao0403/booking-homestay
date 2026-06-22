@extends('layouts.app')

@section('title', $room->name . ' - CloudStay')

@section('content')
<div class="room-detail-page">
    <!-- Header Section -->
    <section class="room-detail-header" style="background: linear-gradient(135deg, #6366f1 0%, #10b981 100%); color: white; padding: 2rem 0; margin-bottom: 0;">
        <div class="container">
            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap;">
                <div>
                    <a href="{{ route('rooms.index') }}" style="color: rgba(255, 255, 255, 0.8); text-decoration: none; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
                        <i class="bi bi-chevron-left"></i>Quay lại danh sách
                    </a>
                    <h1 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 0.5rem;">{{ $room->name }}</h1>
                    <p style="font-size: 1.1rem; opacity: 0.9; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="bi bi-geo-alt"></i>
                        {{ $room->location }}
                    </p>
                </div>
                <div style="text-align: right;">
                    <div style="font-size: 2rem; font-weight: 700; margin-top: 1rem;">{{ number_format($room->price) }} VNĐ<span style="font-size: 0.75rem; opacity: 0.8;">/đêm</span></div>
                </div>
            </div>
        </div>
    </section>

    <div class="container" style="margin-top: 2rem; margin-bottom: 3rem;">
        <div class="row" style="gap: 2rem; display: flex;">
            <!-- Main Content -->
            <div style="flex: 1; min-width: 0;">
                <!-- Main Image -->
                @php
                    $thumb = $room->thumbnail_url;
                    $fallback = 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800';

                    $thumbUrl = null;
                    if ($thumb) {
                        if (is_string($thumb) && str_contains($thumb, '/storage/')) {
                            $filenamePath = preg_replace('#^.*?/storage/#', '', $thumb);
                            $thumbUrl = "https://storage.googleapis.com/booking-homstay/{$filenamePath}";
                        } else {
                            try {
                                $thumbUrl = \Illuminate\Support\Facades\Storage::disk('gcs')->url($thumb);
                            } catch (\Throwable $e) {
                                $thumbUrl = $thumb;
                            }
                        }
                    }
                @endphp
                
                <div class="main-image-container" style="position: relative; width: 100%; border-radius: 12px; overflow: hidden; margin-bottom: 1.5rem; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);">
                    <img src="{{ $thumbUrl ?: $fallback }}" alt="{{ $room->name }}" style="width: 100%; height: auto; display: block; max-height: 600px; object-fit: cover;">
                </div>

                <!-- Gallery -->
                @include('rooms.gallery')

                <!-- Description Section -->
                <section style="background: white; border-radius: 12px; padding: 2rem; margin-bottom: 2rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);">
                    <h2 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 1rem; color: #1f2937;">
                        <i class="bi bi-info-circle" style="color: #6366f1; margin-right: 0.5rem;"></i>
                        Thông Tin Chi Tiết
                    </h2>
                    <p style="color: #4b5563; line-height: 1.8; font-size: 1.05rem;">{{ $room->description }}</p>
                </section>

                <!-- Room Features Section -->
                <section style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
                    @php
                        $roomTypes = [
                            'single' => 'Phòng đơn',
                            'double' => 'Phòng đôi',
                            'suite' => 'Phòng cao cấp (Suite)',
                            'vip' => 'Phòng VIP',
                            'family_suite' => 'Phòng Gia đình (Family Suite)'
                        ];
                    @endphp

                    <!-- Capacity Feature -->
                    <div class="feature-card" style="background: linear-gradient(135deg, #6366f1 0%, #7c3aed 100%); color: white; border-radius: 12px; padding: 2rem; text-align: center; box-shadow: 0 4px 15px rgba(99, 102, 241, 0.2);">
                        <i class="bi bi-people-fill" style="font-size: 2.5rem; margin-bottom: 0.5rem; display: block;"></i>
                        <p style="opacity: 0.9; margin-bottom: 0.5rem;">Sức chứa tối đa</p>
                        <p style="font-size: 1.75rem; font-weight: 700;">{{ $room->capacity }} người</p>
                    </div>

                    <!-- Room Type Feature -->
                    <div class="feature-card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border-radius: 12px; padding: 2rem; text-align: center; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.2);">
                        <i class="bi bi-door-closed" style="font-size: 2.5rem; margin-bottom: 0.5rem; display: block;"></i>
                        <p style="opacity: 0.9; margin-bottom: 0.5rem;">Loại phòng</p>
                        <p style="font-size: 1.75rem; font-weight: 700;">{{ $roomTypes[$room->type] ?? ucfirst($room->type) }}</p>
                    </div>

                    <!-- Status Feature -->
                    <div class="feature-card" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; border-radius: 12px; padding: 2rem; text-align: center; box-shadow: 0 4px 15px rgba(245, 158, 11, 0.2);">
                        <i class="bi bi-check-circle-fill" style="font-size: 2.5rem; margin-bottom: 0.5rem; display: block;"></i>
                        <p style="opacity: 0.9; margin-bottom: 0.5rem;">Trạng thái</p>
                        <p style="font-size: 1.75rem; font-weight: 700; text-transform: capitalize;">{{ $room->status === 'available' ? 'Còn trống' : 'Hết phòng' }}</p>
                    </div>
                </section>

                <!-- Amenities Section (if you add this data) -->
                <section style="background: white; border-radius: 12px; padding: 2rem; margin-bottom: 2rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);">
                    <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem; color: #1f2937;">
                        <i class="bi bi-check-lg" style="color: #10b981; margin-right: 0.5rem;"></i>
                        Tiện Nghi
                    </h3>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                        <div style="display: flex; align-items: center; gap: 0.75rem; color: #4b5563;">
                            <i class="bi bi-wifi" style="color: #6366f1; font-size: 1.25rem;"></i>
                            <span>WiFi miễn phí</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.75rem; color: #4b5563;">
                            <i class="bi bi-door-closed" style="color: #6366f1; font-size: 1.25rem;"></i>
                            <span>An ninh 24/7</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.75rem; color: #4b5563;">
                            <i class="bi bi-cup-fill" style="color: #6366f1; font-size: 1.25rem;"></i>
                            <span>Bếp nấu ăn</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.75rem; color: #4b5563;">
                            <i class="bi bi-reception-4" style="color: #6366f1; font-size: 1.25rem;"></i>
                            <span>TV màn hình phẳng</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.75rem; color: #4b5563;">
                            <i class="bi bi-water" style="color: #6366f1; font-size: 1.25rem;"></i>
                            <span>Nước nóng</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.75rem; color: #4b5563;">
                            <i class="bi bi-wind" style="color: #6366f1; font-size: 1.25rem;"></i>
                            <span>Điều hòa không khí</span>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Sidebar - Booking Card -->
            <aside style="width: 350px; height: fit-content; position: sticky; top: 100px;">
                <div style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); border: 2px solid #e5e7eb;">
                    <!-- Price Display -->
                    <div style="text-align: center; margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 2px solid #e5e7eb;">
                        <p style="color: #6b7280; font-size: 0.9rem; margin-bottom: 0.5rem;">Giá một đêm</p>
                        <p style="font-size: 2rem; font-weight: 700; color: #6366f1;">{{ number_format($room->price) }} VNĐ</p>
                    </div>

                    <!-- Room Status -->
                    <div style="margin-bottom: 1.5rem;">
                        @if($room->status === 'available')
                            <div style="background: #d1fae5; color: #047857; padding: 1rem; border-radius: 8px; text-align: center; margin-bottom: 1rem;">
                                <i class="bi bi-check-circle-fill" style="margin-right: 0.5rem;"></i>
                                <strong>Phòng còn trống</strong>
                            </div>
                        @else
                            <div style="background: #fee2e2; color: #dc2626; padding: 1rem; border-radius: 8px; text-align: center; margin-bottom: 1rem;">
                                <i class="bi bi-x-circle-fill" style="margin-right: 0.5rem;"></i>
                                <strong>Phòng đã hết</strong>
                            </div>
                        @endif
                    </div>

                    <!-- Quick Info -->
                    <div style="background: #f3f4f6; border-radius: 8px; padding: 1rem; margin-bottom: 1.5rem;">
                        <p style="color: #6b7280; font-size: 0.85rem; margin-bottom: 0.5rem;">
                            <i class="bi bi-people-fill" style="color: #6366f1; margin-right: 0.5rem;"></i>
                            Tối đa {{ $room->capacity }} khách
                        </p>
                        <p style="color: #6b7280; font-size: 0.85rem;">
                            <i class="bi bi-door-closed" style="color: #6366f1; margin-right: 0.5rem;"></i>
                            {{ $roomTypes[$room->type] ?? ucfirst($room->type) }}
                        </p>
                    </div>

                    <!-- Booking Button -->
                    <div style="display: grid; gap: 1rem;">
                        @if($room->status === 'available')
                            <a href="{{ route('rooms.booking', $room) }}" class="btn-booking" style="background: linear-gradient(135deg, #6366f1 0%, #7c3aed 100%); color: white; padding: 1rem; border-radius: 8px; text-decoration: none; font-weight: 700; text-align: center; transition: transform 0.3s, box-shadow 0.3s; display: block; box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 6px 20px rgba(99, 102, 241, 0.4)'" onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 15px rgba(99, 102, 241, 0.3)'">
                                <i class="bi bi-calendar-check" style="margin-right: 0.5rem;"></i>
                                Đặt Phòng Ngay
                            </a>
                        @else
                            <button class="btn" disabled style="background: #d1d5db; color: #6b7280; padding: 1rem; border-radius: 8px; border: none; font-weight: 700; text-align: center; cursor: not-allowed;">
                                <i class="bi bi-x-circle" style="margin-right: 0.5rem;"></i>
                                Phòng Đã Hết
                            </button>
                        @endif
                        
                        <button style="background: white; color: #6366f1; padding: 1rem; border-radius: 8px; border: 2px solid #6366f1; font-weight: 700; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.background='#f0f4ff'" onmouseout="this.style.background='white'">
                            <i class="bi bi-heart" style="margin-right: 0.5rem;"></i>
                            Yêu Thích
                        </button>
                    </div>

                    <!-- Additional Info -->
                    <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 2px solid #e5e7eb;">
                        <p style="color: #6b7280; font-size: 0.85rem; margin-bottom: 0.75rem;">
                            <i class="bi bi-info-circle" style="color: #f59e0b; margin-right: 0.5rem;"></i>
                            Hủy đặt phòng miễn phí trước 24 giờ
                        </p>
                        <p style="color: #6b7280; font-size: 0.85rem;">
                            <i class="bi bi-shield-check" style="color: #10b981; margin-right: 0.5rem;"></i>
                            Thanh toán khi nhận phòng hoặc trực tuyến
                        </p>
                    </div>
                </div>

                <!-- Contact Info Card -->
                <div style="background: #f0f4ff; border-radius: 12px; padding: 1.5rem; margin-top: 1.5rem; border-left: 4px solid #6366f1;">
                    <p style="color: #6b7280; font-size: 0.9rem; margin-bottom: 0.75rem;">
                        <i class="bi bi-question-circle" style="color: #6366f1; margin-right: 0.5rem;"></i>
                        <strong>Có câu hỏi?</strong>
                    </p>
                    <p style="color: #4b5563; font-size: 0.9rem;">Liên hệ với chủ nhà để biết thêm chi tiết về phòng</p>
                    <button style="background: #6366f1; color: white; padding: 0.75rem 1.5rem; border-radius: 8px; border: none; margin-top: 1rem; width: 100%; font-weight: 600; cursor: pointer; transition: background 0.3s;" onmouseover="this.style.background='#4f46e5'" onmouseout="this.style.background='#6366f1'">
                        <i class="bi bi-chat-dots" style="margin-right: 0.5rem;"></i>
                        Chat với chủ nhà
                    </button>
                </div>
            </aside>
        </div>
    </div>
</div>

<style>
    .room-detail-page {
        min-height: 100vh;
        background: #f9fafb;
        padding-bottom: 3rem;
    }

    .room-detail-header {
        margin-bottom: 2rem;
    }

    .feature-card {
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .feature-card:hover {
        transform: translateY(-5px);
    }

    @media (max-width: 1024px) {
        aside {
            width: 100% !important;
            position: relative !important;
            top: auto !important;
        }

        .row {
            flex-direction: column !important;
        }
    }

    @media (max-width: 768px) {
        .feature-card {
            padding: 1.5rem !important;
        }

        .room-detail-header h1 {
            font-size: 1.75rem !important;
        }
    }
</style>
@endsection
