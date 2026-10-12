<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="{{ asset('css/vendor.css') }}">

        <!-- Landing base -->
        <style>
            :root {
                --cd-navy-900: #070f22;
                --cd-navy-800: #0c1a38;
                --cd-navy-700: #162a56;
                --cd-brand: #1e3f8f;
                --cd-brand-2: #1572E8;
                --cd-accent: #38bdf8;
                --cd-text: #e7eefb;
                --cd-muted: #9fb0cc;
                --cd-line: rgba(255, 255, 255, .08);
                --cd-radius: 16px;
            }
            * { box-sizing: border-box; }
            html, body { margin: 0; padding: 0; }
            body.cd-body {
                min-height: 100vh;
                background:
                    radial-gradient(1100px 600px at 78% -8%, rgba(21, 114, 232, .32), transparent 60%),
                    radial-gradient(900px 520px at 10% 6%, rgba(56, 189, 248, .16), transparent 55%),
                    var(--cd-navy-900);
                color: var(--cd-text);
                font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
                -webkit-font-smoothing: antialiased;
                text-rendering: optimizeLegibility;
            }
            h1, h2, h3, h4 { font-family: 'Sora', 'Inter', sans-serif; }
            a { text-decoration: none; }
            .cd-container { width: 100%; max-width: 1140px; margin: 0 auto; padding: 0 24px; }

            /* Buttons */
            .cd-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                padding: 13px 24px;
                border-radius: 12px;
                font-weight: 600;
                font-size: 15px;
                line-height: 1;
                border: 1px solid transparent;
                cursor: pointer;
                transition: transform .15s ease, box-shadow .2s ease, background-color .2s ease, border-color .2s ease;
            }
            .cd-btn-primary {
                background: linear-gradient(135deg, #1572E8, #1e3f8f);
                color: #fff !important;
                box-shadow: 0 14px 30px -14px rgba(21, 114, 232, .85);
            }
            .cd-btn-primary:hover, .cd-btn-primary:focus {
                color: #fff !important;
                transform: translateY(-2px);
                box-shadow: 0 20px 40px -16px rgba(21, 114, 232, .95);
            }
            .cd-btn-ghost {
                background: rgba(255, 255, 255, .04);
                border-color: rgba(255, 255, 255, .16);
                color: var(--cd-text) !important;
            }
            .cd-btn-ghost:hover, .cd-btn-ghost:focus {
                background: rgba(255, 255, 255, .09);
                border-color: rgba(255, 255, 255, .28);
                color: #fff !important;
                transform: translateY(-2px);
            }
            .cd-btn-sm { padding: 9px 16px; font-size: 14px; border-radius: 10px; }
        </style>
    </head>

    <body class="cd-body">
        @include('layouts.partials.home_header')

        @yield('content')

        @include('layouts.partials.javascripts')

        <!-- Scripts -->
        <script src="{{ asset('js/login.js?v=' . $asset_v) }}"></script>
        @yield('javascript')
    </body>
</html>
