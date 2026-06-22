@php
    /** @var \App\Models\Room $room */
    $images = $room->images()->get();
@endphp

@if($images->count() > 0)
    <section class="gallery-section">
        <h2 class="section-title"><i class="bi bi-images"></i> Thư Viện Ảnh</h2>

        <div class="gallery-grid">
            @foreach($images as $img)
                <div class="gallery-item">
                    <img
                        src="{{ $img->image_url }}"
                        alt="{{ $room->name }}"
                        class="gallery-image"
                    />
                </div>
            @endforeach
        </div>
    </section>

    <style>
        .gallery-section {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
        }

        .gallery-item {
            border-radius: 12px;
            overflow: hidden;
            background: #f3f4f6;
            transition: transform 0.3s, box-shadow 0.3s;
            aspect-ratio: 1;
            cursor: pointer;
        }

        .gallery-item:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .gallery-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
    </style>
@endif

