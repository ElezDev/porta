@extends('layouts.auth2')
@section('title', __('lang_v1.register'))

@section('css_after')
<style type="text/css">
    /* Registro: usar todo el ancho disponible */
    .auth-aside { display: none; }
    .auth-main { padding: 22px 32px; }
    .auth-card { width: 100%; max-width: 1600px; margin: 10px auto 34px; padding: 54px 70px 50px; }
    .auth-form-wide { display: block; }
    .auth-form-wide .auth-title { margin-bottom: 34px; }

    /* Error summary */
    .reg-errors {
        display: flex;
        gap: 12px;
        margin: 0 0 26px;
        padding: 14px 16px;
        border-radius: 12px;
        border: 1px solid rgba(245, 54, 92, .45);
        background: rgba(245, 54, 92, .12);
        color: #ffd2db;
        font-size: 14px;
    }
    .reg-errors i { color: #ff8097; margin-top: 2px; }
    .reg-errors ul { margin: 0; padding-left: 18px; }

    /* ===== Wizard de fábrica (jQuery Steps) ===== */
    .auth-form-wide .wizard { overflow: visible; }

    /* Steps header */
    .auth-form-wide .wizard > .steps { margin: 4px 0 40px; }
    .auth-form-wide .wizard > .steps > ul { display: flex; gap: 16px; margin: 0; padding: 0; }
    .auth-form-wide .wizard > .steps > ul > li {
        flex: 1 1 0;
        width: auto;
        float: none;
        min-width: 0;
    }
    .auth-form-wide .wizard > .steps a {
        display: flex;
        align-items: center;
        gap: 14px;
        margin: 0;
        padding: 18px 22px;
        border-radius: 16px;
        border: 1px solid var(--cd-line);
        background: rgba(255, 255, 255, .04);
        color: #cad6ea;
        font-size: 15px;
        font-weight: 600;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        transition: background .2s ease, border-color .2s ease, box-shadow .2s ease, color .2s ease;
    }
    .auth-form-wide .wizard > .steps a .number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .08);
        border: 1px solid var(--cd-line);
        font-family: 'Sora', sans-serif;
        font-weight: 700;
        font-size: 14px;
        flex: 0 0 auto;
    }
    .auth-form-wide .wizard > .steps .current a {
        border-color: rgba(21, 114, 232, .75);
        background: linear-gradient(135deg, rgba(21, 114, 232, .24), rgba(30, 63, 143, .30));
        color: #fff;
        box-shadow: 0 18px 34px -24px rgba(21, 114, 232, .95);
    }
    .auth-form-wide .wizard > .steps .current a .number {
        background: linear-gradient(135deg, #1572E8, #1e3f8f);
        border-color: transparent;
        color: #fff;
    }
    .auth-form-wide .wizard > .steps .done a { color: var(--cd-text); border-color: rgba(56, 189, 248, .35); }
    .auth-form-wide .wizard > .steps .done a .number {
        background: rgba(56, 189, 248, .18);
        border-color: rgba(56, 189, 248, .5);
        color: #7fd4ff;
    }
    .auth-form-wide .wizard > .steps .disabled a { background: rgba(255, 255, 255, .04); color: #93a4c2; }
    .auth-form-wide .wizard > .steps .error a { background: rgba(245, 54, 92, .14); color: #ffd2db; }

    /* Content / body */
    .auth-form-wide .wizard > .content {
        background: transparent;
        margin: 0;
        min-height: 0;
        overflow: visible;
        border-radius: 0;
    }
    .auth-form-wide .wizard > .content > .title { display: none; }
    .auth-form-wide .wizard > .content > .body {
        float: none;
        width: auto;
        height: auto;
        padding: 0;
        display: grid;
        grid-template-columns: repeat(12, minmax(0, 1fr));
        gap: 14px 48px;
    }

    /* Section legend */
    .auth-form-wide fieldset > legend {
        grid-column: 1 / -1;
        width: auto;
        border: 0;
        border-bottom: 1px solid var(--cd-line);
        margin: 0 0 16px;
        padding: 0 0 12px;
        font-family: 'Sora', sans-serif;
        font-size: 15.5px;
        font-weight: 600;
        color: #fff;
    }
    .auth-form-wide fieldset > [class*="col-"] {
        width: auto;
        float: none;
        padding: 0;
        min-height: 0;
    }
    .auth-form-wide fieldset > .col-md-12,
    .auth-form-wide fieldset > .col-sm-12 { grid-column: span 12; }
    .auth-form-wide fieldset > .col-md-6,
    .auth-form-wide fieldset > .col-sm-6 { grid-column: span 6; }
    .auth-form-wide fieldset > .col-md-4 { grid-column: span 4; }
    .auth-form-wide fieldset > .clearfix { display: none; }

    .auth-form-wide .form-group { margin-bottom: 34px; }
    .auth-form-wide .form-group > label {
        display: inline-block;
        margin-bottom: 10px;
        font-size: 14px;
        font-weight: 500;
        letter-spacing: .01em;
    }

    /* Input groups joined into one pill */
    .auth-form-wide .form-control { height: 52px; padding: 12px 16px; font-size: 15px; }
    .auth-form-wide .input-group .form-control {
        border-radius: 0 11px 11px 0 !important;
        border-left: 0 !important;
        height: 52px;
    }
    .auth-form-wide .input-group-addon {
        width: 54px;
        font-size: 16px;
        text-align: center;
        vertical-align: middle;
        background: rgba(255, 255, 255, .06) !important;
        border: 1px solid var(--cd-line) !important;
        border-right: 0 !important;
        color: var(--cd-muted) !important;
        border-radius: 11px 0 0 11px !important;
    }

    /* File input */
    .auth-form-wide input[type="file"] {
        width: 100%;
        color: var(--cd-muted);
        font-size: 13px;
        padding: 9px 0;
    }
    .auth-form-wide input[type="file"]::file-selector-button,
    .auth-form-wide input[type="file"]::-webkit-file-upload-button {
        margin-right: 12px;
        padding: 8px 14px;
        border: 1px solid var(--cd-line);
        border-radius: 9px;
        background: rgba(255, 255, 255, .06);
        color: var(--cd-text);
        cursor: pointer;
        font-family: inherit;
        font-weight: 600;
    }

    /* Select2 (single) dark */
    .auth-form-wide .select2-container--default .select2-selection--single {
        height: 52px;
        background: rgba(255, 255, 255, .05) !important;
        border: 1px solid var(--cd-line) !important;
        border-radius: 11px !important;
    }
    .auth-form-wide .input-group .select2-container--default .select2-selection--single {
        border-radius: 0 11px 11px 0 !important;
        border-left: 0 !important;
    }
    .auth-form-wide .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 50px;
        padding-left: 16px;
        font-size: 15px;
        color: #fff !important;
    }
    .auth-form-wide .select2-container--default .select2-selection--single .select2-selection__placeholder {
        color: rgba(231, 238, 251, .45);
    }
    .auth-form-wide .select2-container--default .select2-selection--single .select2-selection__arrow { height: 50px; width: 34px; }
    .auth-form-wide .select2-container--default .select2-selection--single .select2-selection__arrow b {
        border-color: var(--cd-muted) transparent transparent transparent;
    }

    /* Actions (Anterior / Siguiente / Registro) */
    .auth-form-wide .wizard > .actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        text-align: right;
        margin-top: 20px;
        padding: 30px 0 0;
        border-top: 1px solid var(--cd-line);
    }
    .auth-form-wide .wizard > .actions > ul { display: flex; gap: 14px; margin: 0; padding: 0; }
    .auth-form-wide .wizard > .actions > ul > li { float: none; margin: 0; }
    .auth-form-wide .wizard > .actions > ul > li:first-child { margin-right: auto; }
    .auth-form-wide .wizard > .actions a {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 15px 30px;
        border-radius: 12px;
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 15px;
        line-height: 1;
        background: linear-gradient(135deg, #1572E8, #1e3f8f);
        color: #fff;
        box-shadow: 0 16px 32px -18px rgba(21, 114, 232, .95);
        text-decoration: none;
        transition: transform .15s ease, box-shadow .2s ease, background .2s ease;
    }
    .auth-form-wide .wizard > .actions a:hover { color: #fff; transform: translateY(-1px); }
    .auth-form-wide .wizard > .actions .disabled a,
    .auth-form-wide .wizard > .actions .disabled a:hover {
        background: rgba(255, 255, 255, .05);
        border: 1px solid var(--cd-line);
        color: var(--cd-text);
        box-shadow: none;
        transform: none;
    }

    @media (max-width: 1100px) {
        .auth-form-wide fieldset > .col-md-4 { grid-column: span 6; }
    }
    @media (max-width: 900px) {
        .auth-main { padding: 20px 18px; }
        .auth-card { padding: 34px 28px 30px; }
        .auth-form-wide .wizard > .steps a { justify-content: center; padding: 12px; }
        .auth-form-wide .wizard > .steps a .number { width: 30px; height: 30px; font-size: 13px; }
        .auth-form-wide .wizard > .actions { flex-direction: column; align-items: stretch; }
        .auth-form-wide .wizard > .actions > ul { flex-direction: column; }
        .auth-form-wide .wizard > .actions a { justify-content: center; }
    }
    @media (max-width: 680px) {
        .auth-card { margin: 8px auto 22px; padding: 26px 18px 24px; }
        .auth-form-wide .wizard > .content > .body { grid-template-columns: 1fr; }
        .auth-form-wide fieldset > [class*="col-"] { grid-column: 1 / -1; }
    }
</style>
@stop

@section('content')
<div class="auth-form auth-form-wide">
    <h1 class="auth-title">@lang('business.register_and_get_started_in_minutes')</h1>

    @if ($errors->any())
        <div class="reg-errors" id="reg_errors">
            <i class="fas fa-exclamation-triangle"></i>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {!! Form::open(['url' => route('business.postRegister'), 'method' => 'post',
                            'id' => 'business_register_form', 'files' => true ]) !!}
        @include('business.partials.register_form')
        {!! Form::hidden('package_id', $package_id); !!}
    {!! Form::close() !!}
</div>
@stop
@section('javascript')
<script type="text/javascript">
    $(document).ready(function(){
        $('#change_lang').change( function(){
            window.location = "{{ route('business.getRegister') }}?lang=" + $(this).val();
        });

        if($('#reg_errors').length){
            $('html, body').animate({ scrollTop: 0 }, 180);
        }
    })
</script>
@endsection
