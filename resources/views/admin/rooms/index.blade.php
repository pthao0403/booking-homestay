@extends('layouts.app')

@section('content')

<div class="container">
    <h2>Quản lý phòng</h2>

    <div class="mb-4">
        <a href="{{ route('admin.rooms.create') }}" class="btn btn-success">Thêm phòng mới</a>
    </div>

    {{-- PHẦN FORM TÌM KIẾM --}}
    {{-- Đảm bảo form này đứng độc lập, không nằm trong một thẻ <form> nào khác --}}
    <form action="{{ route('admin.rooms.index') }}" method="GET" class="mb-4 p-3 border rounded">
        <div class="row g-2 align-items-center">
            <div class="col-md-8">
                <input type="text" name="search" class="form-control" 
                       placeholder="Nhập tên hoặc địa điểm..." 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">Xóa lọc</a>
            </div>
        </div>
    </form>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        @forelse($rooms as $room)
            <div class="col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5>{{ $room->name }}</h5>
                        <p class="text-muted"><i class="bi bi-geo-alt"></i> {{ $room->address }}</p>
                        <p><strong>Giá:</strong> {{ number_format($room->price) }} VNĐ</p>
                        
                        <div class="d-flex justify-content-between mt-3">
                            <a href="{{ route('admin.rooms.edit', $room->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                            
                            <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST" onsubmit="return confirm('Xóa thật không?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p>Không tìm thấy phòng nào.</p>
        @endforelse
    </div>

    {{-- Phân trang --}}
    <div class="mt-4">
        {{ $rooms->appends(request()->query())->links() }}
    </div>
</div>

@endsection