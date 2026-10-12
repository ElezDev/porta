@extends('layouts.home')
@section('title', config('app.name', 'ultimatePOS'))

@section('content')
    <style>
        /* ---------- Hero ---------- */
        .cd-hero {
            position: relative;
            padding: 92px 0 44px;
            text-align: center;
        }
        .cd-eyebrow {
            display: inline-block;
            padding: 7px 15px;
            border-radius: 999px;
            border: 1px solid var(--cd-line);
            background: rgba(255, 255, 255, .04);
            color: var(--cd-muted);
            font-size: 12.5px;
            font-weight: 600;
            letter-spacing: .6px;
            text-transform: uppercase;
        }
        .cd-hero-title {
            margin: 22px 0 0;
            font-size: clamp(40px, 6.4vw, 70px);
            font-weight: 800;
            letter-spacing: -.03em;
            line-height: 1.03;
            color: #fff;
            background: linear-gradient(180deg, #ffffff 34%, #a9c6f5 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .cd-hero-tagline {
            margin: 14px 0 0;
            font-family: 'Sora', sans-serif;
            font-size: clamp(18px, 2.6vw, 25px);
            font-weight: 600;
            color: #7fb0ff;
        }
        .cd-hero-sub {
            margin: 18px auto 0;
            max-width: 660px;
            color: var(--cd-muted);
            font-size: 17px;
            line-height: 1.68;
        }
        .cd-cta {
            margin-top: 36px;
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            justify-content: center;
        }

        /* ---------- Features ---------- */
        .cd-features { padding: 28px 0 72px; }
        .cd-features-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
        }
        .cd-card {
            position: relative;
            padding: 26px 22px;
            border-radius: var(--cd-radius);
            border: 1px solid var(--cd-line);
            background: linear-gradient(180deg, rgba(255, 255, 255, .055), rgba(255, 255, 255, .015));
            transition: transform .2s ease, border-color .2s ease, box-shadow .2s ease;
        }
        .cd-card:hover {
            transform: translateY(-6px);
            border-color: rgba(56, 189, 248, .38);
            box-shadow: 0 26px 52px -28px rgba(21, 114, 232, .8);
        }
        .cd-card-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: #fff;
            background: linear-gradient(135deg, #1572E8, #1e3f8f);
            box-shadow: 0 12px 26px -14px rgba(21, 114, 232, .95);
            margin-bottom: 16px;
        }
        .cd-card h3 {
            margin: 0;
            font-size: 17px;
            font-weight: 700;
            color: #fff;
        }
        .cd-card-tag {
            display: inline-block;
            margin: 7px 0 11px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: #7fb0ff;
        }
        .cd-card p {
            margin: 0;
            color: var(--cd-muted);
            font-size: 14.5px;
            line-height: 1.6;
        }

        /* ---------- Footer ---------- */
        .cd-footer {
            border-top: 1px solid var(--cd-line);
            padding: 26px 0;
            color: #7d8db0;
            font-size: 13.5px;
            text-align: center;
        }

        @media (max-width: 900px) {
            .cd-features-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 560px) {
            .cd-hero { padding-top: 64px; }
            .cd-features-grid { grid-template-columns: 1fr; }
            .cd-cta { flex-direction: column; }
            .cd-cta .cd-btn { width: 100%; }
        }
        @media (prefers-reduced-motion: reduce) {
            .cd-card, .cd-btn { transition: none; }
        }
    </style>

    <main class="cd-landing">
        <section class="cd-hero">
            <div class="cd-container">
                <span class="cd-eyebrow">Plataforma de gestión integral</span>

                <h1 class="cd-hero-title">{{ config('app.name', 'ultimatePOS') }}</h1>

                @if (env('APP_TITLE'))
                    <p class="cd-hero-tagline">{{ env('APP_TITLE') }}</p>
                @endif

                <p class="cd-hero-sub">
                    Ventas, inventario, compras y reportes en un solo lugar.
                    Simple, rápido y a la medida de tu negocio.
                </p>

                <div class="cd-cta">
                    @auth
                        <a class="cd-btn cd-btn-primary" href="{{ route('home') }}">Ir al panel</a>
                    @else
                        <a class="cd-btn cd-btn-primary" href="{{ route('login') }}">Iniciar sesión</a>
                        @if (Route::has('business.getRegister') && config('constants.allow_registration', true))
                            <a class="cd-btn cd-btn-ghost" href="{{ route('business.getRegister') }}">Registrar mi negocio</a>
                        @endif
                    @endauth
                </div>
            </div>
        </section>

        <section class="cd-features" aria-label="Qué puedes hacer">
            <div class="cd-container">
                <div class="cd-features-grid">
                    <article class="cd-card">
                        <div class="cd-card-icon"><i class="fas fa-cash-register"></i></div>
                        <h3>Ventas y caja</h3>
                        <span class="cd-card-tag">POS</span>
                        <p>Cobra rápido, administra tu caja y emite comprobantes al instante.</p>
                    </article>

                    <article class="cd-card">
                        <div class="cd-card-icon"><i class="fas fa-cubes"></i></div>
                        <h3>Inventario</h3>
                        <span class="cd-card-tag">Stock</span>
                        <p>Controla existencias, alertas de stock y movimientos por sucursal.</p>
                    </article>

                    <article class="cd-card">
                        <div class="cd-card-icon"><i class="fas fa-file-invoice-dollar"></i></div>
                        <h3>Compras y gastos</h3>
                        <span class="cd-card-tag">Control</span>
                        <p>Registra compras, gastos y proveedores con total trazabilidad.</p>
                    </article>

                    <article class="cd-card">
                        <div class="cd-card-icon"><i class="fas fa-chart-line"></i></div>
                        <h3>Reportes</h3>
                        <span class="cd-card-tag">Al día</span>
                        <p>Visualiza tus ventas, utilidades y desempeño en tiempo real.</p>
                    </article>
                </div>
            </div>
        </section>

        <footer class="cd-footer">
            <div class="cd-container">
                &copy; {{ date('Y') }} {{ config('app.name', 'ultimatePOS') }}. Todos los derechos reservados.
            </div>
        </footer>
    </main>
@endsection
