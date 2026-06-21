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
                        data-path="{{ $img->image_url }}"
                        src=""
                        alt="{{ $room->name }}"
                        style="width: 100%; height: 180px; object-fit: cover; display:block;"
                        class="room-gallery-img"
                    />
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


