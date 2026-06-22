@extends('layouts.app')

@section('title', 'Tìm kiếm phòng - CloudStay')

@section('content')
<div class="rooms-page">
    <!-- Header Section -->
    <section class="rooms-header" style="background: linear-gradient(135deg, #6366f1 0%, #10b981 100%); color: white; padding: 3rem 0; margin-bottom: 3rem;">
        <div class="container">
            <h1 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 0.5rem;">Khám Phá Những Phòng Xinh Đẹp</h1>
            <p style="font-size: 1.1rem; opacity: 0.9;">Tìm kiếm và đặt phòng homestay yêu thích của bạn</p>
        </div>
    </section>

    <div class="container">
        <!-- Filter Section -->
        <section class="filter-section" style="margin-bottom: 3rem;">
            <div class="filter-card" style="background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 12px; padding: 2rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);">
                <form method="GET" class="filter-form" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; align-items: end;">
                    <div class="form-group">
                        <label for="search" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #1f2937;">Tìm kiếm phòng</label>
                        <input type="text" id="search" name="search" class="form-control" placeholder="Tên phòng, địa chỉ..." value="{{ request('search') }}" style="border-radius: 8px; border: 1px solid #d1d5db; padding: 0.75rem;">
                    </div>
                    
                    <div class="form-group">
                        <label for="check_in" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #1f2937;">Ngày nhận phòng</label>
                        <input type="date" id="check_in" name="check_in" class="form-control" value="{{ request('check_in') }}" style="border-radius: 8px; border: 1px solid #d1d5db; padding: 0.75rem;">
                    </div>
                    
                    <div class="form-group">
                        <label for="check_out" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #1f2937;">Ngày trả phòng</label>
                        <input type="date" id="check_out" name="check_out" class="form-control" value="{{ request('check_out') }}" style="border-radius: 8px; border: 1px solid #d1d5db; padding: 0.75rem;">
                    </div>
                    
                    <div class="form-group" style="display: flex; flex-direction: column;">
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: transparent; height: 1.4rem;"></label>
                        <button type="submit" class="btn" style="background: #6366f1; color: white; border: none; border-radius: 8px; padding: 0.75rem 1.5rem; font-weight: 600; cursor: pointer; transition: background 0.3s; width: 100%;">
                            <i class="bi bi-search" style="margin-right: 0.5rem;"></i>Tìm kiếm
                        </button>
                    </div>
                    
                    @if(request('search') || request('check_in') || request('check_out'))
                        <a href="{{ route('rooms.index') }}" class="btn" style="background: #e5e7eb; color: #1f2937; border: none; border-radius: 8px; padding: 0.75rem 1.5rem; font-weight: 600; cursor: pointer; transition: background 0.3s; text-decoration: none; display: inline-block;">
                            <i class="bi bi-x-circle" style="margin-right: 0.5rem;"></i>Xóa lọc
                        </a>
                    @endif
                </form>
            </div>
        </section>

        <!-- Results Info -->
        @if($rooms->total() > 0)
            <div style="margin-bottom: 1.5rem; color: #6b7280;">
                <p>Tìm thấy <strong style="color: #1f2937;">{{ $rooms->total() }}</strong> phòng</p>
            </div>
        @endif

        <!-- Rooms Grid -->
        <div class="rooms-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 2rem; margin-bottom: 2rem;">
            @forelse($rooms as $room)
                @php
                    $thumb = $room->thumbnail_url;
                    $fallback = 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=500';

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

                    $roomTypes = [
                        'single' => 'Phòng đơn',
                        'double' => 'Phòng đôi',
                        'suite' => 'Suite',
                        'vip' => 'VIP',
                        'family_suite' => 'Gia đình'
                    ];
                @endphp
                
                <div class="room-card" style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); transition: transform 0.3s, box-shadow 0.3s; cursor: pointer;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 10px 25px rgba(0, 0, 0, 0.15)'" onmouseout="this.style.transform='none'; this.style.boxShadow='0 1px 3px rgba(0, 0, 0, 0.1)'">
                    <!-- Image Container -->
                    <div class="room-image-wrapper" style="position: relative; height: 240px; overflow: hidden; background: linear-gradient(135deg, #e5e7eb 0%, #d1d5db 100%);">
                        <img src="{{ $thumbUrl ?: $fallback }}" alt="{{ $room->name }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                        
                        <!-- Badge -->
                        <span class="badge" style="position: absolute; top: 12px; right: 12px; background: #10b981; color: white; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.875rem; font-weight: 600;">
                            {{ $roomTypes[$room->type] ?? ucfirst($room->type) }}
                        </span>
                    </div>
                    
                    <!-- Content -->
                    <div class="room-content" style="padding: 1.5rem;">
                        <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem; color: #1f2937;">{{ $room->name }}</h3>
                        
                        <!-- Location -->
                        <p class="location" style="color: #6b7280; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="bi bi-geo-alt" style="color: #ef4444;"></i>
                            {{ $room->location }}
                        </p>
                        
                        <!-- Features -->
                        <div style="display: flex; gap: 1rem; margin-bottom: 1rem; font-size: 0.875rem; color: #6b7280;">
                            <span style="display: flex; align-items: center; gap: 0.5rem;">
                                <i class="bi bi-people-fill" style="color: #6366f1;"></i>
                                {{ $room->capacity }} người
                            </span>
                        </div>
                        
                        <!-- Description -->
                        <p class="description" style="color: #6b7280; font-size: 0.9rem; margin-bottom: 1rem; line-height: 1.5;">{{ Str::limit($room->description, 80) }}</p>
                        
                        <!-- Footer -->
                        <div class="room-footer" style="display: flex; justify-content: space-between; align-items: center; padding-top: 1rem; border-top: 1px solid #e5e7eb;">
                            <span class="price" style="font-size: 1.5rem; font-weight: 700; color: #6366f1;">{{ number_format($room->price) }}<span style="font-size: 0.75rem; color: #6b7280; font-weight: 400;"> VNĐ/đêm</span></span>
                            <a href="{{ route('rooms.show', $room) }}" class="btn-detail" style="background: #6366f1; color: white; padding: 0.75rem 1.5rem; border-radius: 8px; border: none; text-decoration: none; font-weight: 600; transition: background 0.3s; display: inline-block;" onmouseover="this.style.background='#4f46e5'" onmouseout="this.style.background='#6366f1'">
                                Chi Tiết <i class="bi bi-arrow-right" style="margin-left: 0.5rem;"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
                    <i class="bi bi-inbox" style="font-size: 3rem; color: #d1d5db; margin-bottom: 1rem; display: block;"></i>
                    <p style="color: #6b7280; font-size: 1.1rem;">Không tìm thấy phòng nào phù hợp với tiêu chí của bạn.</p>
                    <a href="{{ route('rooms.index') }}" class="btn" style="background: #6366f1; color: white; padding: 0.75rem 1.5rem; border-radius: 8px; border: none; margin-top: 1rem; text-decoration: none; display: inline-block;">
                        Xem tất cả phòng
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($rooms->total() > 0)
            <div style="display: flex; justify-content: center; margin-top: 2rem;">
                {{ $rooms->links() }}
            </div>
        @endif
    </div>
</div>

<style>
    .rooms-page {
        min-height: 100vh;
        background: #f9fafb;
    }

    .room-card {
        overflow: hidden;
    }

    .room-card:hover {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
    }

    /* Pagination Styling */
    .pagination {
        justify-content: center;
        gap: 0.5rem;
    }

    .page-link {
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        color: #6366f1;
        transition: all 0.3s;
    }

    .page-link:hover {
        background: #6366f1;
        color: white;
    }

    .page-item.active .page-link {
        background: #6366f1;
        border-color: #6366f1;
    }
</style>
@endsection
