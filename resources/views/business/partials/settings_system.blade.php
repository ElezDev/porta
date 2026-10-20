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
    <div class="theme-studio">
        <h4 class="theme-studio-title">{{ __('business.theme_studio') }}</h4>
        <p class="help-block">{{ __('business.theme_studio_help') }}</p>

        <p class="theme-studio-label">{{ __('business.theme_presets') }}</p>
        <div class="theme-presets">
            <button type="button" class="theme-preset" data-preset="navy" title="Navy Gold">
                <span style="background:#162A56"></span><span style="background:#1E3F8F"></span><span style="background:#C9A227"></span>
                <em>Navy Gold</em>
            </button>
            <button type="button" class="theme-preset" data-preset="midnight" title="Midnight">
                <span style="background:#111827"></span><span style="background:#4F46E5"></span><span style="background:#10B981"></span>
                <em>Midnight</em>
            </button>
            <button type="button" class="theme-preset" data-preset="emerald" title="Emerald">
                <span style="background:#064E3B"></span><span style="background:#059669"></span><span style="background:#F59E0B"></span>
                <em>Emerald</em>
            </button>
            <button type="button" class="theme-preset" data-preset="burgundy" title="Burgundy">
                <span style="background:#4A1528"></span><span style="background:#9F1239"></span><span style="background:#C9A227"></span>
                <em>Burgundy</em>
            </button>
            <button type="button" class="theme-preset" data-preset="ocean" title="Ocean">
                <span style="background:#0E4D6B"></span><span style="background:#0284C7"></span><span style="background:#0D9488"></span>
                <em>Ocean</em>
            </button>
            <button type="button" class="theme-preset" data-preset="graphite" title="Graphite">
                <span style="background:#1F2937"></span><span style="background:#4B5563"></span><span style="background:#D97706"></span>
                <em>Graphite</em>
            </button>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    {!! Form::label('theme_settings_header_color', __('business.header')); !!}
                    <div class="input-group colorpicker-component">
                        <input type="text" name="theme_settings[header_color]" class="form-control theme-color-input" data-theme-var="header"
                            value="{{ $business->theme_settings['header_color'] ?? '' }}" placeholder="#162A56">
                        <span class="input-group-addon"><i></i></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    {!! Form::label('theme_settings_sidebar_color', __('business.sidebar')); !!}
                    <div class="input-group colorpicker-component">
                        <input type="text" name="theme_settings[sidebar_color]" class="form-control theme-color-input" data-theme-var="sidebar"
                            value="{{ $business->theme_settings['sidebar_color'] ?? '' }}" placeholder="#0C1A38">
                        <span class="input-group-addon"><i></i></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    {!! Form::label('theme_settings_primary_color', __('business.primary') . ' / ' . __('business.theme_btn_primary')); !!}
                    <div class="input-group colorpicker-component">
                        <input type="text" name="theme_settings[primary_color]" class="form-control theme-color-input" data-theme-var="primary"
                            value="{{ $business->theme_settings['primary_color'] ?? '' }}" placeholder="#1E3F8F">
                        <span class="input-group-addon"><i></i></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    {!! Form::label('theme_settings_success_color', __('business.theme_btn_success')); !!}
                    <div class="input-group colorpicker-component">
                        <input type="text" name="theme_settings[success_color]" class="form-control theme-color-input" data-theme-var="success"
                            value="{{ $business->theme_settings['success_color'] ?? '' }}" placeholder="#2F855A">
                        <span class="input-group-addon"><i></i></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    {!! Form::label('theme_settings_warning_color', __('business.theme_btn_warning')); !!}
                    <div class="input-group colorpicker-component">
                        <input type="text" name="theme_settings[warning_color]" class="form-control theme-color-input" data-theme-var="warning"
                            value="{{ $business->theme_settings['warning_color'] ?? '' }}" placeholder="#B7791F">
                        <span class="input-group-addon"><i></i></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    {!! Form::label('theme_settings_danger_color', __('business.theme_btn_danger')); !!}
                    <div class="input-group colorpicker-component">
                        <input type="text" name="theme_settings[danger_color]" class="form-control theme-color-input" data-theme-var="danger"
                            value="{{ $business->theme_settings['danger_color'] ?? '' }}" placeholder="#C53030">
                        <span class="input-group-addon"><i></i></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    {!! Form::label('theme_settings_info_color', __('business.theme_btn_info')); !!}
                    <div class="input-group colorpicker-component">
                        <input type="text" name="theme_settings[info_color]" class="form-control theme-color-input" data-theme-var="info"
                            value="{{ $business->theme_settings['info_color'] ?? '' }}" placeholder="#3B6EA5">
                        <span class="input-group-addon"><i></i></span>
                    </div>
                </div>
            </div>
        </div>

        <p class="theme-studio-label">{{ __('business.theme_preview') }}</p>
        <div class="theme-preview-btns">
            <button type="button" class="btn btn-primary btn-sm">{{ __('business.theme_btn_primary') }}</button>
            <button type="button" class="btn btn-success btn-sm">{{ __('business.theme_btn_success') }}</button>
            <button type="button" class="btn btn-warning btn-sm">{{ __('business.theme_btn_warning') }}</button>
            <button type="button" class="btn btn-danger btn-sm">{{ __('business.theme_btn_danger') }}</button>
            <button type="button" class="btn btn-info btn-sm">{{ __('business.theme_btn_info') }}</button>
            <button type="button" id="reset_theme" class="btn btn-default btn-sm">
                <i class="fa fa-undo"></i> {{ __('messages.reset') }}
            </button>
        </div>
    </div>
</div>