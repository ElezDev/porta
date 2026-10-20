@extends('layouts.app')
@section('title', __('business.business_settings'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang('business.business_settings')</h1>
    <br>
    @include('layouts.partials.search_settings')
</section>

<!-- Main content -->
<section class="content">
{!! Form::open(['url' => action('BusinessController@postBusinessSettings'), 'method' => 'post', 'id' => 'bussiness_edit_form',
           'files' => true ]) !!}
    <div class="row">
        <div class="col-xs-12">
       <!--  <pos-tab-container> -->
        <div class="col-xs-12 pos-tab-container">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 pos-tab-menu">
                <div class="list-group">
                    <a href="#" class="list-group-item text-center active">@lang('business.business')</a>
                    <a href="#" class="list-group-item text-center">@lang('business.tax') @show_tooltip(__('tooltip.business_tax'))</a>
                    <a href="#" class="list-group-item text-center">@lang('business.product')</a>
                    <a href="#" class="list-group-item text-center">@lang('contact.contact')</a>
                    <a href="#" class="list-group-item text-center">@lang('business.sale')</a>
                    <a href="#" class="list-group-item text-center">@lang('sale.pos_sale')</a>
                    <a href="#" class="list-group-item text-center">@lang('purchase.purchases')</a>
                    <a href="#" class="list-group-item text-center">@lang('business.dashboard')</a>
                    <a href="#" class="list-group-item text-center">@lang('business.system')</a>
                    <a href="#" class="list-group-item text-center">@lang('lang_v1.prefixes')</a>
                    <a href="#" class="list-group-item text-center">@lang('lang_v1.email_settings')</a>
                    <a href="#" class="list-group-item text-center">@lang('lang_v1.sms_settings')</a>
                    <a href="#" class="list-group-item text-center">@lang('lang_v1.reward_point_settings')</a>
                    <a href="#" class="list-group-item text-center">@lang('lang_v1.modules')</a>
                    <a href="#" class="list-group-item text-center">@lang('lang_v1.custom_labels')</a>
                </div>
            </div>
            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 pos-tab">
                <!-- tab 1 start -->
                @include('business.partials.settings_business')
                <!-- tab 1 end -->
                <!-- tab 2 start -->
                @include('business.partials.settings_tax')
                <!-- tab 2 end -->
                <!-- tab 3 start -->
                @include('business.partials.settings_product')

                @include('business.partials.settings_contact')
                <!-- tab 3 end -->
                <!-- tab 4 start -->
                @include('business.partials.settings_sales')
                @include('business.partials.settings_pos')
                <!-- tab 4 end -->
                <!-- tab 5 start -->
                @include('business.partials.settings_purchase')
                <!-- tab 5 end -->
                <!-- tab 6 start -->
                @include('business.partials.settings_dashboard')
                <!-- tab 6 end -->
                <!-- tab 7 start -->
                @include('business.partials.settings_system')
                <!-- tab 7 end -->
                <!-- tab 8 start -->
                @include('business.partials.settings_prefixes')
                <!-- tab 8 end -->
                <!-- tab 9 start -->
                @include('business.partials.settings_email')
                <!-- tab 9 end -->
                <!-- tab 10 start -->
                @include('business.partials.settings_sms')
                <!-- tab 10 end -->
                <!-- tab 11 start -->
                @include('business.partials.settings_reward_point')
                <!-- tab 11 end -->
                <!-- tab 12 start -->
                @include('business.partials.settings_modules')
                <!-- tab 12 end -->
                @include('business.partials.settings_custom_labels')
            </div>
        </div>
        <!--  </pos-tab-container> -->
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <button class="btn btn-danger pull-right" type="submit">@lang('business.update_settings')</button>
        </div>
    </div>
{!! Form::close() !!}
</section>
<!-- /.content -->
@stop
@section('javascript')
<script type="text/javascript">
    __page_leave_confirmation('#bussiness_edit_form');
    $(document).on('ifToggled', '#use_superadmin_settings', function() {
        if ($('#use_superadmin_settings').is(':checked')) {
            $('#toggle_visibility').addClass('hide');
            $('.test_email_btn').addClass('hide');
        } else {
            $('#toggle_visibility').removeClass('hide');
            $('.test_email_btn').removeClass('hide');
        }
    });

    $('#test_email_btn').click( function() {
        var data = {
            mail_driver: $('#mail_driver').val(),
            mail_host: $('#mail_host').val(),
            mail_port: $('#mail_port').val(),
            mail_username: $('#mail_username').val(),
            mail_password: $('#mail_password').val(),
            mail_encryption: $('#mail_encryption').val(),
            mail_from_address: $('#mail_from_address').val(),
            mail_from_name: $('#mail_from_name').val(),
        };
        $.ajax({
            method: 'post',
            data: data,
            url: "{{ action('BusinessController@testEmailConfiguration') }}",
            dataType: 'json',
            success: function(result) {
                if (result.success == true) {
                    swal({
                        text: result.msg,
                        icon: 'success'
                    });
                } else {
                    swal({
                        text: result.msg,
                        icon: 'error'
                    });
                }
            },
        });
    });

    $('#test_sms_btn').click( function() {
        var test_number = $('#test_number').val();
        if (test_number.trim() == '') {
            toastr.error('{{__("lang_v1.test_number_is_required")}}');
            $('#test_number').focus();

            return false;
        }

        var data = {
            url: $('#sms_settings_url').val(),
            send_to_param_name: $('#send_to_param_name').val(),
            msg_param_name: $('#msg_param_name').val(),
            request_method: $('#request_method').val(),
            param_1: $('#sms_settings_param_key1').val(),
            param_2: $('#sms_settings_param_key2').val(),
            param_3: $('#sms_settings_param_key3').val(),
            param_4: $('#sms_settings_param_key4').val(),
            param_5: $('#sms_settings_param_key5').val(),
            param_6: $('#sms_settings_param_key6').val(),
            param_7: $('#sms_settings_param_key7').val(),
            param_8: $('#sms_settings_param_key8').val(),
            param_9: $('#sms_settings_param_key9').val(),
            param_10: $('#sms_settings_param_key10').val(),

            param_val_1: $('#sms_settings_param_val1').val(),
            param_val_2: $('#sms_settings_param_val2').val(),
            param_val_3: $('#sms_settings_param_val3').val(),
            param_val_4: $('#sms_settings_param_val4').val(),
            param_val_5: $('#sms_settings_param_val5').val(),
            param_val_6: $('#sms_settings_param_val6').val(),
            param_val_7: $('#sms_settings_param_val7').val(),
            param_val_8: $('#sms_settings_param_val8').val(),
            param_val_9: $('#sms_settings_param_val9').val(),
            param_val_10: $('#sms_settings_param_val10').val(),
            test_number: test_number
        };

        $.ajax({
            method: 'post',
            data: data,
            url: "{{ action('BusinessController@testSmsConfiguration') }}",
            dataType: 'json',
            success: function(result) {
                if (result.success == true) {
                    swal({
                        text: result.msg,
                        icon: 'success'
                    });
                } else {
                    swal({
                        text: result.msg,
                        icon: 'error'
                    });
                }
            },
        });
    });

    var themePresets = {
        navy: {
            header_color: '#162A56',
            sidebar_color: '#0C1A38',
            primary_color: '#1E3F8F',
            success_color: '#C9A227',
            warning_color: '#B7791F',
            danger_color: '#C53030',
            info_color: '#3B6EA5'
        },
        midnight: {
            header_color: '#111827',
            sidebar_color: '#030712',
            primary_color: '#4F46E5',
            success_color: '#10B981',
            warning_color: '#F59E0B',
            danger_color: '#F43F5E',
            info_color: '#38BDF8'
        },
        emerald: {
            header_color: '#064E3B',
            sidebar_color: '#022C22',
            primary_color: '#059669',
            success_color: '#10B981',
            warning_color: '#D97706',
            danger_color: '#E11D48',
            info_color: '#0EA5E9'
        },
        burgundy: {
            header_color: '#4A1528',
            sidebar_color: '#2A0D18',
            primary_color: '#9F1239',
            success_color: '#C9A227',
            warning_color: '#B45309',
            danger_color: '#BE123C',
            info_color: '#7C3AED'
        },
        ocean: {
            header_color: '#0E4D6B',
            sidebar_color: '#083344',
            primary_color: '#0284C7',
            success_color: '#0D9488',
            warning_color: '#D97706',
            danger_color: '#E11D48',
            info_color: '#38BDF8'
        },
        graphite: {
            header_color: '#1F2937',
            sidebar_color: '#111827',
            primary_color: '#4B5563',
            success_color: '#D97706',
            warning_color: '#CA8A04',
            danger_color: '#DC2626',
            info_color: '#64748B'
        }
    };

    function hexToRgb(hex) {
        hex = (hex || '').replace('#', '');
        if (hex.length === 3) {
            hex = hex[0]+hex[0]+hex[1]+hex[1]+hex[2]+hex[2];
        }
        var n = parseInt(hex, 16);
        if (isNaN(n)) {
            return '0, 0, 0';
        }
        return ((n >> 16) & 255) + ', ' + ((n >> 8) & 255) + ', ' + (n & 255);
    }

    function shadeHex(hex, percent) {
        hex = (hex || '').replace('#', '');
        if (hex.length === 3) {
            hex = hex[0]+hex[0]+hex[1]+hex[1]+hex[2]+hex[2];
        }
        var num = parseInt(hex, 16);
        if (isNaN(num)) {
            return hex;
        }
        var r = (num >> 16) & 255;
        var g = (num >> 8) & 255;
        var b = num & 255;
        var amt = percent / 100;
        if (amt < 0) {
            r = Math.round(r * (1 + amt));
            g = Math.round(g * (1 + amt));
            b = Math.round(b * (1 + amt));
        } else {
            r = Math.round(r + (255 - r) * amt);
            g = Math.round(g + (255 - g) * amt);
            b = Math.round(b + (255 - b) * amt);
        }
        return '#' + ((1 << 24) + (Math.max(0, Math.min(255, r)) << 16) + (Math.max(0, Math.min(255, g)) << 8) + Math.max(0, Math.min(255, b))).toString(16).slice(1).toUpperCase();
    }

    function onColor(hex) {
        hex = (hex || '').replace('#', '');
        if (hex.length === 3) {
            hex = hex[0]+hex[0]+hex[1]+hex[1]+hex[2]+hex[2];
        }
        var n = parseInt(hex, 16);
        if (isNaN(n)) {
            return '#FFFFFF';
        }
        var r = (n >> 16) & 255;
        var g = (n >> 8) & 255;
        var b = n & 255;
        return ((0.299 * r + 0.587 * g + 0.114 * b) / 255) > 0.62 ? '#111827' : '#FFFFFF';
    }

    function applyThemePreview() {
        var map = {
            header: 'header_color',
            sidebar: 'sidebar_color',
            primary: 'primary_color',
            success: 'success_color',
            warning: 'warning_color',
            danger: 'danger_color',
            info: 'info_color'
        };
        var root = document.documentElement;
        Object.keys(map).forEach(function (key) {
            var val = $('input[name="theme_settings[' + map[key] + ']"]').val();
            if (!val) {
                return;
            }
            root.style.setProperty('--ui-' + key, val);
            root.style.setProperty('--ui-' + key + '-hover', shadeHex(val, -14));
            root.style.setProperty('--ui-' + key + '-rgb', hexToRgb(val));
            root.style.setProperty('--ui-on-' + key, onColor(val));
            if (key === 'primary') {
                root.style.setProperty('--ui-brand', val);
                root.style.setProperty('--ui-brand-2', shadeHex(val, 12));
            }
            if (key === 'header') {
                root.style.setProperty('--ui-header-2', shadeHex(val, -12));
            }
            if (key === 'sidebar') {
                root.style.setProperty('--ui-sidebar-2', shadeHex(val, 10));
            }
        });
    }

    $('.colorpicker-component').colorpicker({ format: 'hex' }).on('changeColor', applyThemePreview);
    $('.theme-color-input').on('change blur', applyThemePreview);

    $('.theme-preset').on('click', function() {
        var preset = themePresets[$(this).data('preset')];
        if (!preset) {
            return;
        }
        $('.theme-preset').removeClass('is-active');
        $(this).addClass('is-active');
        Object.keys(preset).forEach(function (key) {
            var $input = $('input[name="theme_settings[' + key + ']"]');
            $input.val(preset[key]);
            $input.closest('.colorpicker-component').colorpicker('setValue', preset[key]);
        });
        applyThemePreview();
    });

    $('#reset_theme').on('click', function() {
        $('.theme-preset').removeClass('is-active');
        $('.colorpicker-component input').val('');
        $('.colorpicker-component .input-group-addon i').css('background-color', 'transparent');
    });
</script>
@endsection