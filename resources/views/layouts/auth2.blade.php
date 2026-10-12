<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name', 'POS') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">

    @include('layouts.partials.css')

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
            --cd-line: rgba(255, 255, 255, .10);
            --cd-radius: 16px;
        }
        html, body { margin: 0; padding: 0; }
        body.auth-body {
            min-height: 100vh;
            background:
                radial-gradient(1100px 600px at 82% -10%, rgba(21, 114, 232, .30), transparent 60%),
                radial-gradient(900px 520px at 8% 4%, rgba(56, 189, 248, .14), transparent 55%),
                var(--cd-navy-900);
            color: var(--cd-text);
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        h1, h2, h3, h4 { font-family: 'Sora', 'Inter', sans-serif; }
        a { text-decoration: none; }

        .auth-shell { display: flex; min-height: 100vh; }

        /* ---------- Aside (branding) ---------- */
        .auth-aside {
            position: relative;
            flex: 0 0 46%;
            max-width: 46%;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            padding: 42px 46px;
            overflow: hidden;
            background:
                linear-gradient(155deg, rgba(7, 15, 34, .92), rgba(30, 63, 143, .86)),
                url("{{ asset('img/home-bg.jpg') }}");
            background-size: cover;
            background-position: center;
            border-right: 1px solid var(--cd-line);
        }
        .auth-aside::after {
            content: '';
            position: absolute;
            right: -120px;
            bottom: -120px;
            width: 360px;
            height: 360px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(56, 189, 248, .28), transparent 70%);
            pointer-events: none;
        }
        .auth-brand {
            display: inline-flex;
            align-items: center;
            gap: 11px;
            color: #fff;
            font-family: 'Sora', sans-serif;
            font-weight: 700;
            font-size: 18px;
            position: relative;
            z-index: 1;
        }
        .auth-brand-mark {
            position: relative;
            width: 28px;
            height: 28px;
            border-radius: 9px;
            background: linear-gradient(135deg, #38bdf8, #1572E8 55%, #1e3f8f);
            box-shadow: 0 8px 18px -8px rgba(21, 114, 232, .95);
            flex: 0 0 auto;
        }
        .auth-brand-mark::after {
            content: '';
            position: absolute;
            inset: 8px;
            border-radius: 4px;
            background: rgba(255, 255, 255, .9);
        }
        .auth-aside-body { position: relative; z-index: 1; max-width: 420px; margin: 42px 0 40px; }
        .auth-aside-body h2 {
            margin: 0 0 14px;
            font-size: 34px;
            font-weight: 800;
            letter-spacing: -.02em;
            line-height: 1.12;
            color: #fff;
        }
        .auth-aside-body p {
            margin: 0 0 26px;
            color: rgba(231, 238, 251, .78);
            font-size: 15.5px;
            line-height: 1.65;
        }
        .auth-points { list-style: none; margin: 0; padding: 0; display: grid; gap: 13px; }
        .auth-points li {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14.5px;
            color: rgba(231, 238, 251, .92);
        }
        .auth-points i {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: rgba(255, 255, 255, .10);
            border: 1px solid var(--cd-line);
            color: #7fb0ff;
            font-size: 15px;
        }
        .auth-aside-foot {
            position: relative;
            z-index: 1;
            margin-top: auto;
            color: rgba(231, 238, 251, .5);
            font-size: 13px;
        }

        /* ---------- Main (form) ---------- */
        .auth-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 30px 26px 24px;
            min-width: 0;
        }
        .auth-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 8px;
        }
        .auth-lang {
            appearance: none;
            -webkit-appearance: none;
            padding: 9px 34px 9px 14px;
            border-radius: 10px;
            border: 1px solid var(--cd-line);
            background: rgba(255, 255, 255, .05)
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239fb0cc' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E")
                no-repeat right 12px center;
            color: var(--cd-text);
            font-size: 14px;
            cursor: pointer;
        }
        .auth-lang:focus { outline: none; border-color: var(--cd-brand-2); box-shadow: 0 0 0 3px rgba(21, 114, 232, .2); }
        .auth-toplinks { display: flex; align-items: center; gap: 14px; font-size: 14px; }
        .auth-toplinks a { color: #7fb0ff; font-weight: 600; }
        .auth-toplinks a:hover { color: #a9c6f5; }
        .auth-toplinks .muted { color: var(--cd-muted); }

        .auth-card {
            width: 100%;
            max-width: 440px;
            margin: auto;
            padding: 38px 40px 34px;
            border-radius: var(--cd-radius);
            border: 1px solid var(--cd-line);
            background: linear-gradient(180deg, rgba(255, 255, 255, .06), rgba(255, 255, 255, .02));
            box-shadow: 0 30px 70px -32px rgba(0, 0, 0, .85);
            -webkit-backdrop-filter: blur(14px);
            backdrop-filter: blur(14px);
        }
        .auth-title {
            margin: 0 0 24px;
            font-size: 25px;
            font-weight: 700;
            letter-spacing: -.01em;
            color: #fff;
            text-align: left;
        }

        /* Inputs inside the auth card */
        .auth-card .form-control {
            height: 46px;
            padding: 10px 14px;
            border-radius: 11px !important;
            background: rgba(255, 255, 255, .05) !important;
            border: 1px solid var(--cd-line) !important;
            color: #fff !important;
        }
        .auth-card .form-control::placeholder { color: rgba(231, 238, 251, .45); }
        .auth-card .form-control:focus {
            background: rgba(255, 255, 255, .07) !important;
            border-color: var(--cd-brand-2) !important;
            box-shadow: 0 0 0 3px rgba(21, 114, 232, .22) !important;
        }
        .auth-card .form-control-feedback { width: 46px; height: 46px; line-height: 46px; color: rgba(231, 238, 251, .55); }
        .auth-card .has-error .form-control { border-color: #f5365c !important; }
        .auth-card .help-block { color: #ff9db0; margin-top: 6px; }
        .auth-card label { color: var(--cd-text); font-weight: 500; }
        .auth-card .checkbox label { color: var(--cd-muted); font-weight: 500; }
        .auth-card .btn-primary {
            border: 0 !important;
            background: linear-gradient(135deg, #1572E8, #1e3f8f) !important;
            box-shadow: 0 14px 30px -14px rgba(21, 114, 232, .9) !important;
            border-radius: 12px !important;
            font-weight: 600 !important;
        }
        .auth-card .btn-primary:hover,
        .auth-card .btn-primary:focus {
            background: linear-gradient(135deg, #1a80ff, #23499f) !important;
            transform: translateY(-1px);
        }
        .auth-card a { color: #7fb0ff; font-weight: 600; }
        .auth-card a:hover { color: #a9c6f5; }

        .auth-foot {
            margin-top: 18px;
            text-align: center;
            color: rgba(231, 238, 251, .42);
            font-size: 12.5px;
        }

        @media (max-width: 900px) {
            .auth-aside { display: none; }
            .auth-main { padding: 22px 18px; }
        }
        @media (max-width: 560px) {
            .auth-card { padding: 28px 22px 24px; }
            .auth-topbar { flex-direction: column; align-items: stretch; gap: 10px; }
            .auth-toplinks { justify-content: center; }
        }
        @media (prefers-reduced-motion: reduce) {
            .auth-card .btn-primary { transition: none; }
        }
    </style>

    @yield('css_after')
</head>

<body class="auth-body">
    @inject('request', 'Illuminate\Http\Request')
    @if (session('status'))
        <input type="hidden" id="status_span" data-status="{{ session('status.success') }}" data-msg="{{ session('status.msg') }}">
    @endif

    <div class="auth-shell">
        <aside class="auth-aside">
            <a href="/" class="auth-brand">
                <span class="auth-brand-mark" aria-hidden="true"></span>
                <span>{{ config('app.name', 'ultimatePOS') }}</span>
            </a>

            <div class="auth-aside-body">
                <h2>{{ env('APP_TITLE') ?: 'All in One place' }}</h2>
                <p>Ventas, inventario, compras y reportes en una sola plataforma. Simple, rápido y a la medida de tu negocio.</p>
                <ul class="auth-points">
                    <li><i class="fas fa-cash-register"></i> Ventas y caja</li>
                    <li><i class="fas fa-cubes"></i> Inventario y stock</li>
                    <li><i class="fas fa-file-invoice-dollar"></i> Compras y gastos</li>
                    <li><i class="fas fa-chart-line"></i> Reportes al día</li>
                </ul>
            </div>

            <div class="auth-aside-foot">&copy; {{ date('Y') }} {{ config('app.name', 'ultimatePOS') }}</div>
        </aside>

        <main class="auth-main">
            <div class="auth-topbar">
                <select class="auth-lang" id="change_lang">
                    @foreach(config('constants.langs') as $key => $val)
                        <option value="{{ $key }}"
                            @if( (empty(request()->lang) && config('app.locale') == $key) || request()->lang == $key ) selected @endif >
                            {{ $val['full_name'] }}
                        </option>
                    @endforeach
                </select>

                <div class="auth-toplinks">
                    @if(!($request->segment(1) == 'business' && $request->segment(2) == 'register'))
                        @if(config('constants.allow_registration'))
                            <span class="muted">{{ __('business.not_yet_registered') }}</span>
                            <a href="{{ route('business.getRegister') }}@if(!empty(request()->lang)){{ '?lang=' . request()->lang }}@endif">{{ __('business.register_now') }}</a>
                        @endif
                    @else
                        <span class="muted">{{ __('business.already_registered') }}</span>
                        <a href="{{ action('Auth\LoginController@login') }}@if(!empty(request()->lang)){{ '?lang=' . request()->lang }}@endif">{{ __('business.sign_in') }}</a>
                    @endif
                </div>
            </div>

            <div class="auth-card">
                @yield('content')
            </div>

            <div class="auth-foot">&copy; {{ date('Y') }} {{ config('app.name', 'ultimatePOS') }}. Todos los derechos reservados.</div>
        </main>
    </div>

    @include('layouts.partials.javascripts')
    <script src="{{ asset('js/login.js?v=' . $asset_v) }}"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('.select2_register').select2();
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%'
            });
        });
    </script>
</body>
</html>
