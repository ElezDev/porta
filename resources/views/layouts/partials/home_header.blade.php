<style>
    .cd-nav {
        position: sticky;
        top: 0;
        z-index: 50;
        background: rgba(7, 15, 34, .74);
        -webkit-backdrop-filter: blur(14px);
        backdrop-filter: blur(14px);
        border-bottom: 1px solid var(--cd-line);
    }
    .cd-nav-inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        height: 70px;
    }
    .cd-brand {
        display: inline-flex;
        align-items: center;
        gap: 11px;
        color: #fff;
        font-family: 'Sora', sans-serif;
        font-weight: 700;
        font-size: 18px;
        letter-spacing: -.01em;
    }
    .cd-brand-mark {
        position: relative;
        width: 28px;
        height: 28px;
        border-radius: 9px;
        background: linear-gradient(135deg, #38bdf8, #1572E8 55%, #1e3f8f);
        box-shadow: 0 8px 18px -8px rgba(21, 114, 232, .95);
        flex: 0 0 auto;
    }
    .cd-brand-mark::after {
        content: '';
        position: absolute;
        inset: 8px;
        border-radius: 4px;
        background: rgba(255, 255, 255, .9);
    }

    .cd-nav-menu {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-left: auto;
    }
    .cd-nav-links {
        display: flex;
        align-items: center;
        gap: 4px;
        list-style: none;
        margin: 0;
        padding: 0;
    }
    .cd-nav-links a {
        display: block;
        padding: 9px 13px;
        border-radius: 9px;
        color: var(--cd-muted);
        font-weight: 500;
        font-size: 14.5px;
        transition: color .15s ease, background-color .15s ease;
    }
    .cd-nav-links a:hover,
    .cd-nav-links a:focus {
        color: #fff;
        background: rgba(255, 255, 255, .06);
    }
    .cd-nav-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-left: 8px;
    }
    .cd-nav-login {
        padding: 9px 13px;
        border-radius: 9px;
        color: var(--cd-text);
        font-weight: 600;
        font-size: 14.5px;
        transition: color .15s ease, background-color .15s ease;
    }
    .cd-nav-login:hover, .cd-nav-login:focus {
        color: #fff;
        background: rgba(255, 255, 255, .06);
    }

    .cd-toggle {
        display: none;
        flex-direction: column;
        justify-content: center;
        gap: 5px;
        width: 42px;
        height: 38px;
        padding: 0 10px;
        border: 1px solid var(--cd-line);
        border-radius: 10px;
        background: rgba(255, 255, 255, .04);
        cursor: pointer;
    }
    .cd-toggle span {
        display: block;
        height: 2px;
        border-radius: 2px;
        background: var(--cd-text);
        transition: transform .2s ease, opacity .2s ease;
    }

    @media (max-width: 880px) {
        .cd-toggle { display: flex; }
        .cd-nav-menu {
            display: none;
            position: absolute;
            left: 0;
            right: 0;
            top: 70px;
            flex-direction: column;
            align-items: stretch;
            gap: 14px;
            margin: 0;
            padding: 16px 24px 22px;
            background: rgba(9, 18, 40, .98);
            border-bottom: 1px solid var(--cd-line);
            box-shadow: 0 24px 40px -20px rgba(0, 0, 0, .8);
        }
        .cd-nav-menu.is-open { display: flex; }
        .cd-nav-links { flex-direction: column; align-items: stretch; gap: 2px; }
        .cd-nav-links a { padding: 12px 12px; }
        .cd-nav-actions { flex-direction: column; align-items: stretch; margin: 4px 0 0; }
        .cd-nav-actions .cd-btn { width: 100%; }
    }
</style>

<header class="cd-nav">
    <div class="cd-container cd-nav-inner">
        <a class="cd-brand" href="/">
            <span class="cd-brand-mark" aria-hidden="true"></span>
            <span>{{ config('app.name', 'ultimatePOS') }}</span>
        </a>

        <button type="button" class="cd-toggle" aria-label="Menú" aria-expanded="false" aria-controls="cd-nav-menu">
            <span></span><span></span><span></span>
        </button>

        <nav class="cd-nav-menu" id="cd-nav-menu" aria-label="Principal">
            <ul class="cd-nav-links">
                @if(Auth::check())
                    <li><a href="{{ action('HomeController@index') }}">@lang('home.home')</a></li>
                @endif
                @if(Route::has('frontend-pages') && config('app.env') != 'demo' && !empty($frontend_pages))
                    @foreach($frontend_pages as $page)
                        <li><a href="{{ action('\Modules\Superadmin\Http\Controllers\PageController@showPage', $page->slug) }}">{{ $page->title }}</a></li>
                    @endforeach
                @endif
                @if(Route::has('pricing') && config('app.env') != 'demo')
                    <li><a href="{{ action('\Modules\Superadmin\Http\Controllers\PricingController@index') }}">@lang('superadmin::lang.pricing')</a></li>
                @endif
                @if(Route::has('repair-status'))
                    <li><a href="{{ action('\Modules\Repair\Http\Controllers\CustomerRepairStatusController@index') }}">@lang('repair::lang.repair_status')</a></li>
                @endif
            </ul>

            <div class="cd-nav-actions">
                @if (Route::has('login'))
                    @if(!Auth::check())
                        <a class="cd-nav-login" href="{{ route('login') }}">@lang('lang_v1.login')</a>
                        @if(config('constants.allow_registration'))
                            <a class="cd-btn cd-btn-primary cd-btn-sm" href="{{ route('business.getRegister') }}">@lang('lang_v1.register')</a>
                        @endif
                    @else
                        <a class="cd-btn cd-btn-primary cd-btn-sm" href="{{ action('HomeController@index') }}">@lang('home.home')</a>
                    @endif
                @endif
            </div>
        </nav>
    </div>
</header>

<script>
    (function () {
        var toggle = document.querySelector('.cd-toggle');
        var menu = document.getElementById('cd-nav-menu');
        if (!toggle || !menu) return;
        toggle.addEventListener('click', function () {
            var open = menu.classList.toggle('is-open');
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
    })();
</script>
