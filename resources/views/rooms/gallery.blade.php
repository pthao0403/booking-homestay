@php
    /** @var \App\Models\Room $room */
    $images = $room->images()->get();
@endphp

@if($images->count() > 0)
    <div class="room-gallery" style="margin: 1.5rem 0;">
        <h3 style="margin-bottom: 1rem;">Ảnh phòng</h3>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 12px;">
            @foreach($images as $img)
                <div style="border-radius: 8px; overflow: hidden; background: #f2f2f2;">
                    <img
                        src="{{ $img->image_url }}"
                        alt="{{ $room->name }}"
                        style="width: 100%; height: 180px; object-fit: cover; display:block;"
                    />
                </div>
            @endforeach
        </div>
    </div>
@endif


