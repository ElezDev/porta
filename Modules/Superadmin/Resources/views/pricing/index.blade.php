@extends('layouts.home')
@section('title', __('superadmin::lang.pricing'))

@section('content')
@php
    $featured_id = collect($packages)->sortByDesc('price')->pluck('id')->first();
@endphp
<style>
    .cd-price {
        padding: 64px 0 80px;
    }
    .cd-price-hero {
        text-align: center;
        margin-bottom: 42px;
    }
    .cd-price-hero .cd-eyebrow {
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
    .cd-price-hero h1 {
        margin: 18px 0 0;
        font-size: clamp(32px, 5vw, 52px);
        font-weight: 800;
        letter-spacing: -.03em;
        color: #fff;
        background: linear-gradient(180deg, #ffffff 34%, #a9c6f5 100%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .cd-price-hero p {
        margin: 14px auto 0;
        max-width: 560px;
        color: var(--cd-muted);
        font-size: 16.5px;
        line-height: 1.65;
    }
    .cd-price-lang {
        margin-top: 18px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--cd-muted);
        font-size: 13px;
    }
    .cd-price-lang select {
        background: rgba(255,255,255,.06);
        color: #fff;
        border: 1px solid var(--cd-line);
        border-radius: 10px;
        padding: 8px 12px;
        min-width: 180px;
    }
    .cd-price-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 22px;
        align-items: stretch;
    }
    .cd-price-card {
        position: relative;
        display: flex;
        flex-direction: column;
        padding: 28px 24px 24px;
        border-radius: 20px;
        border: 1px solid var(--cd-line);
        background: linear-gradient(180deg, rgba(255,255,255,.07), rgba(255,255,255,.02));
        box-shadow: 0 24px 50px -32px rgba(0,0,0,.7);
        min-height: 100%;
    }
    .cd-price-card.is-featured {
        border-color: rgba(56, 189, 248, .45);
        background: linear-gradient(180deg, rgba(21, 114, 232, .22), rgba(255,255,255,.03));
        transform: translateY(-6px);
        box-shadow: 0 30px 60px -28px rgba(21, 114, 232, .75);
    }
    .cd-price-badge {
        position: absolute;
        top: 14px;
        right: 14px;
        padding: 5px 10px;
        border-radius: 999px;
        background: linear-gradient(135deg, #1572E8, #1e3f8f);
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .04em;
        text-transform: uppercase;
    }
    .cd-price-card h3 {
        margin: 0 0 10px;
        font-size: 22px;
        font-weight: 700;
        color: #fff;
    }
    .cd-price-amount {
        margin: 0 0 8px;
        font-family: 'Sora', sans-serif;
        font-size: 36px;
        font-weight: 800;
        letter-spacing: -.03em;
        color: #fff;
        line-height: 1.1;
    }
    .cd-price-amount small {
        display: inline-block;
        margin-left: 4px;
        font-size: 14px;
        font-weight: 600;
        color: var(--cd-muted);
        vertical-align: middle;
    }
    .cd-price-desc {
        margin: 0 0 18px;
        color: var(--cd-muted);
        font-size: 14px;
        line-height: 1.55;
        min-height: 22px;
    }
    .cd-price-features {
        list-style: none;
        margin: 0 0 22px;
        padding: 0;
        display: grid;
        gap: 11px;
        flex: 1;
    }
    .cd-price-features li {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        color: rgba(231, 238, 251, .92);
        font-size: 14.5px;
        line-height: 1.4;
    }
    .cd-price-features i {
        margin-top: 2px;
        color: #38bdf8;
        width: 16px;
        text-align: center;
    }
    .cd-price-card .cd-btn {
        width: 100%;
    }
    .cd-price-card .cd-btn-ghost {
        width: 100%;
    }
    .cd-footer {
        border-top: 1px solid var(--cd-line);
        padding: 26px 0;
        color: #7d8db0;
        font-size: 13.5px;
        text-align: center;
    }
    @media (max-width: 720px) {
        .cd-price { padding-top: 36px; }
        .cd-price-card.is-featured { transform: none; }
    }
</style>

<main>
    @include('superadmin::layouts.partials.currency')

    <section class="cd-price">
        <div class="cd-container">
            <div class="cd-price-hero">
                <span class="cd-eyebrow">@lang('superadmin::lang.pricing')</span>
                <h1>@lang('superadmin::lang.packages')</h1>
                <p>@lang('superadmin::lang.pricing_subtitle')</p>
                <div class="cd-price-lang">
                    <select id="change_lang" aria-label="@lang('superadmin::lang.pricing')">
                        @foreach(config('constants.langs') as $key => $val)
                            <option value="{{$key}}"
                                @if( (empty(request()->lang) && config('app.locale') == $key) || request()->lang == $key)
                                    selected
                                @endif
                            >{{$val['full_name']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="cd-price-grid">
                @include('superadmin::subscription.partials.packages', [
                    'action_type' => 'register',
                    'skin' => 'marketing',
                    'featured_id' => $featured_id,
                ])
            </div>
        </div>
    </section>

    <footer class="cd-footer">
        <div class="cd-container">
            &copy; {{ date('Y') }} {{ config('app.name', 'ultimatePOS') }}
        </div>
    </footer>
</main>
@endsection

@section('javascript')
<script type="text/javascript">
    $(document).ready(function(){
        $('#change_lang').change( function(){
            window.location = "{{ route('pricing') }}?lang=" + $(this).val();
        });
    })
</script>
@endsection
