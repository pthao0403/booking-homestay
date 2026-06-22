@php
    /** @var \App\Models\Room $room */
    $images = $room->images()->get();
@endphp

@if($images->count() > 0)
    <div class="room-gallery" style="margin: 2rem 0; background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);">
        <h3 style="margin-bottom: 1.5rem; font-size: 1.5rem; font-weight: 700; color: #1f2937;">
            <i class="bi bi-images" style="color: #6366f1; margin-right: 0.5rem;"></i>
            Thư Viện Ảnh
        </h3>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem;">
            @foreach($images as $img)
                <div style="border-radius: 12px; overflow: hidden; background: #f3f4f6; transition: transform 0.3s, box-shadow 0.3s; position: relative;" class="gallery-item" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 10px 25px rgba(0, 0, 0, 0.15)'" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 1px 3px rgba(0, 0, 0, 0.05)'">
                    <img
                        data-path="{{ $img->image_url }}"
                        src=""
                        alt="{{ $room->name }}"
                        style="width: 100%; height: 200px; object-fit: cover; display:block;"
                        class="room-gallery-img"
                    />
                    <div style="position: absolute; inset: 0; background: rgba(0, 0, 0, 0); transition: background 0.3s;" class="overlay"></div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        (function () {
            async function loadSignedUrl(img) {
                const path = img.dataset.path;
                if (!path) return;

                try {
                    const url = new URL(window.location.origin + '/admin/rooms/' + @json($room->id) + '/images/signed-url');
                    url.searchParams.set('path', path);

                    const res = await fetch(url.toString(), {
                        method: 'GET',
                        headers: { 'Accept': 'application/json' }
                    });

                    const data = await res.json();
                    if (data && data.success && data.url) {
                        img.src = data.url;
                    }
                } catch (e) {
                    // keep empty
                }
            }

            document.querySelectorAll('.room-gallery-img').forEach(function (img) {
                loadSignedUrl(img);
            });
        })();
    </script>
@endif


