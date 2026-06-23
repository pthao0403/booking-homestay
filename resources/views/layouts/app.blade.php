
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'CloudStay - Đặt Homestay Online')</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    @if (config('services.google_analytics.measurement_id'))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.google_analytics.measurement_id') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());
            gtag('config', '{{ config('services.google_analytics.measurement_id') }}');
        </script>
    @endif
</head>

<body>

    @include('partials.navbar')

    <main>
        @unless(request()->routeIs('home'))
            <div class="container pt-3">
                <button
                    type="button"
                    class="page-back-button"
                    onclick="if (window.history.length > 1) { window.history.back(); } else { window.location.href='{{ route('home') }}'; }"
                >
                    <i class="bi bi-arrow-left"></i>
                    <span>Quay lại</span>
                </button>
            </div>
        @endunless
        @yield('content')
    </main>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

        <script type="text/javascript">
            function googleTranslateElementInit() {
                new google.translate.TranslateElement({
                    pageLanguage: 'vi', // Ngôn ngữ chính của website là Tiếng Việt
                    includedLanguages: 'en,vi', // Chỉ cho phép chuyển qua lại giữa Anh và Việt
                    layout: google.translate.TranslateElement.InlineLayout.SIMPLE
                }, 'google_translate_element');
            }
        </script>
        <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    </body>
<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({
    pageLanguage: 'vi', // Ngôn ngữ mặc định gốc của trang web (Tiếng Việt)
    includedLanguages: 'en,vi', // Các ngôn ngữ cho phép chuyển đổi (Anh, Việt)
    layout: google.translate.TranslateElement.InlineLayout.SIMPLE
  }, 'google_translate_element');
}
</script>

<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<style>
    .page-back-button {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: 1px solid #dbe3f0;
        background: #fff;
        color: #0f172a;
        border-radius: 999px;
        padding: 0.65rem 1rem;
        font-weight: 600;
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.08);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .page-back-button:hover {
        transform: translateY(-1px);
        box-shadow: 0 12px 24px rgba(15, 23, 42, 0.12);
    }
</style>
</body>
