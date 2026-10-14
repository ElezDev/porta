<div class="pos-tab-content">
     <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('theme_color', __('lang_v1.theme_color')); !!}
                {!! Form::select('theme_color', $theme_colors,   $business->theme_color, 
                    ['class' => 'form-control select2', 'placeholder' => __('messages.please_select'), 'style' => 'width: 100%;']); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                @php
                    $page_entries = [25 => 25, 50 => 50, 100 => 100, 200 => 200, 500 => 500, 1000 => 1000, -1 => __('lang_v1.all')];
                @endphp
                {!! Form::label('default_datatable_page_entries', __('lang_v1.default_datatable_page_entries')); !!}
                {!! Form::select('common_settings[default_datatable_page_entries]', $page_entries, !empty($common_settings['default_datatable_page_entries']) ? $common_settings['default_datatable_page_entries'] : 25 , 
                    ['class' => 'form-control select2', 'style' => 'width: 100%;', 'id' => 'default_datatable_page_entries']); !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <div class="checkbox">
                  <label>
                    {!! Form::checkbox('enable_tooltip', 1, $business->enable_tooltip , 
                    [ 'class' => 'input-icheck']); !!} {{ __( 'business.show_help_text' ) }}
                  </label>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('theme_settings_header_color', __('lang_v1.theme_color') . ' - ' . __('business.header')); !!}
                <div class="input-group colorpicker-component">
                    <input type="text" name="theme_settings[header_color]" class="form-control"
                        value="{{ $business->theme_settings['header_color'] ?? '' }}" placeholder="#1e3f8f">
                    <span class="input-group-addon"><i></i></span>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('theme_settings_sidebar_color', __('lang_v1.theme_color') . ' - ' . __('business.sidebar')); !!}
                <div class="input-group colorpicker-component">
                    <input type="text" name="theme_settings[sidebar_color]" class="form-control"
                        value="{{ $business->theme_settings['sidebar_color'] ?? '' }}" placeholder="#0c1a38">
                    <span class="input-group-addon"><i></i></span>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('theme_settings_primary_color', __('lang_v1.theme_color') . ' - ' . __('business.primary')); !!}
                <div class="input-group colorpicker-component">
                    <input type="text" name="theme_settings[primary_color]" class="form-control"
                        value="{{ $business->theme_settings['primary_color'] ?? '' }}" placeholder="#1572E8">
                    <span class="input-group-addon"><i></i></span>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <button type="button" id="reset_theme" class="btn btn-default btn-sm">
                <i class="fa fa-undo"></i> {{ __('messages.reset') }}
            </button>
        </div>
    </div>
</div>