@extends('layouts.home')
@section('title', __('repair::lang.repair_status'))

@section('content')
@php
    $search_options = [
        'job_sheet_no' => __('repair::lang.job_sheet_no'),
        'invoice_no' => __('sale.invoice_no')
    ];
    $placeholder = __('repair::lang.job_sheet_or_invoice_no');
    if (config('repair.enable_repair_check_using_mobile_num')) {
        $search_options['mobile_num'] = __('lang_v1.mobile_number');
        $placeholder .= ' / '.__('lang_v1.mobile_number');
    }
@endphp
<style>
    .cd-repair { padding: 56px 0 80px; }
    .cd-repair-hero { text-align: center; margin-bottom: 28px; }
    .cd-repair-hero .cd-eyebrow {
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
    .cd-repair-hero h1 {
        margin: 16px 0 0;
        font-size: clamp(28px, 4.6vw, 46px);
        font-weight: 800;
        letter-spacing: -.03em;
        color: #fff;
        background: linear-gradient(180deg, #ffffff 34%, #a9c6f5 100%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .cd-repair-hero p {
        margin: 12px auto 0;
        max-width: 520px;
        color: var(--cd-muted);
        font-size: 16px;
        line-height: 1.6;
    }
    .cd-repair-lang {
        margin-top: 16px;
    }
    .cd-repair-lang select {
        background: rgba(255,255,255,.06);
        color: #fff;
        border: 1px solid var(--cd-line);
        border-radius: 10px;
        padding: 8px 12px;
        min-width: 180px;
    }
    .cd-repair-card {
        max-width: 720px;
        margin: 0 auto 28px;
        padding: 26px 26px 22px;
        border-radius: 20px;
        border: 1px solid var(--cd-line);
        background: linear-gradient(180deg, rgba(255,255,255,.07), rgba(255,255,255,.02));
        box-shadow: 0 24px 50px -32px rgba(0,0,0,.7);
    }
    .cd-repair-grid {
        display: grid;
        grid-template-columns: 200px 1fr;
        gap: 12px;
        margin-bottom: 12px;
    }
    .cd-repair-card label {
        display: block;
        margin-bottom: 6px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .04em;
        text-transform: uppercase;
        color: #9fb0cc;
    }
    .cd-repair-card .form-control,
    .cd-repair-card select {
        height: 48px;
        border-radius: 12px !important;
        background: rgba(255,255,255,.06) !important;
        border: 1px solid var(--cd-line) !important;
        color: #fff !important;
        box-shadow: none !important;
    }
    .cd-repair-card .form-control::placeholder { color: rgba(231,238,251,.45); }
    .cd-repair-card .input-group-addon {
        background: rgba(255,255,255,.06) !important;
        border: 1px solid var(--cd-line) !important;
        border-right: 0 !important;
        color: #9fb0cc !important;
        border-radius: 12px 0 0 12px !important;
    }
    .cd-repair-card .input-group .form-control {
        border-radius: 0 12px 12px 0 !important;
        border-left: 0 !important;
    }
    .cd-repair-card .cd-btn { width: 100%; margin-top: 8px; }
    .cd-repair-results { max-width: 860px; margin: 0 auto; display: grid; gap: 16px; }
    .cd-job {
        padding: 22px 22px 8px;
        border-radius: 18px;
        border: 1px solid var(--cd-line);
        background: linear-gradient(180deg, rgba(255,255,255,.06), rgba(255,255,255,.02));
    }
    .cd-job-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 1px solid var(--cd-line);
    }
    .cd-job-head h3 {
        margin: 0;
        font-size: 18px;
        color: #fff;
        font-weight: 700;
    }
    .cd-job-meta {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px 18px;
        margin-bottom: 16px;
    }
    .cd-job-meta span {
        display: block;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .05em;
        text-transform: uppercase;
        color: #7d8db0;
        margin-bottom: 4px;
    }
    .cd-job-meta strong { color: #e7eefb; font-weight: 600; }
    .cd-status {
        display: inline-flex;
        align-items: center;
        padding: 5px 10px;
        border-radius: 999px;
        color: #fff;
        font-size: 12px;
        font-weight: 700;
    }
    .cd-job-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13.5px;
        color: #d7e2f5;
    }
    .cd-job-table th {
        text-align: left;
        color: #9fb0cc;
        font-size: 11px;
        letter-spacing: .04em;
        text-transform: uppercase;
        padding: 8px 10px;
        border-bottom: 1px solid var(--cd-line);
    }
    .cd-job-table td {
        padding: 10px;
        border-bottom: 1px solid rgba(255,255,255,.06);
        vertical-align: top;
    }
    .cd-job-table tr:last-child td { border-bottom: 0; }
    .cd-footer {
        border-top: 1px solid var(--cd-line);
        padding: 26px 0;
        color: #7d8db0;
        font-size: 13.5px;
        text-align: center;
    }
    @media (max-width: 640px) {
        .cd-repair { padding-top: 32px; }
        .cd-repair-grid, .cd-job-meta { grid-template-columns: 1fr; }
        .cd-job-head { flex-direction: column; align-items: flex-start; }
    }
</style>

<main>
    <section class="cd-repair">
        <div class="cd-container">
            <div class="cd-repair-hero">
                <span class="cd-eyebrow">@lang('repair::lang.repair')</span>
                <h1>@lang('repair::lang.repair_status')</h1>
                <p>@lang('repair::lang.repair_status_subtitle')</p>
                <div class="cd-repair-lang">
                    <select id="change_lang">
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

            <div class="cd-repair-card">
                <form method="POST" action="{{action('\Modules\Repair\Http\Controllers\CustomerRepairStatusController@postRepairStatus')}}" id="check_repair_status">
                    {{ csrf_field() }}
                    <div class="cd-repair-grid">
                        <div>
                            {!! Form::label('search_type', __('lang_v1.search')) !!}
                            {!! Form::select('search_type', $search_options, null, ['class' => 'form-control', 'id' => 'search_type']); !!}
                        </div>
                        <div>
                            {!! Form::label('search_number', $placeholder) !!}
                            {!! Form::text('search_number', null, ['class' => 'form-control', 'required', 'placeholder' => $placeholder, 'id' => 'search_number']); !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('repair_serial_no', __('repair::lang.serial_no')) !!}
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fas fa-microchip"></i></div>
                            <input type="text" name="serial_no" class="form-control" id="repair_serial_no" placeholder="@lang('repair::lang.serial_no')">
                        </div>
                    </div>
                    <button type="submit" class="cd-btn cd-btn-primary ladda-button" data-style="expand-right">
                        <i class="fas fa-search"></i> @lang('lang_v1.search')
                    </button>
                </form>
            </div>

            <div class="cd-repair-results repair_status_details"></div>
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
        $('#change_lang').change(function(){
            window.location = "{{ route('repair-status') }}?lang=" + $(this).val();
        });

        $(document).on('submit', 'form#check_repair_status', function(e) {
            e.preventDefault();
            var data = $('form#check_repair_status').serialize();
            var url = $('form#check_repair_status').attr('action');
            var ladda = Ladda.create(document.querySelector('.ladda-button'));
            ladda.start();
            $.ajax({
                method: 'POST',
                url: url,
                dataType: 'json',
                data: data,
                success: function(result) {
                    ladda.stop();
                    if (result.success) {
                        $(".repair_status_details").html(result.repair_html);
                        toastr.success(result.msg);
                    } else {
                        toastr.error(result.msg);
                    }
                },
                error: function() {
                    ladda.stop();
                    toastr.error("{{ __('messages.something_went_wrong') }}");
                }
            });
        });
    });
</script>
@endsection
