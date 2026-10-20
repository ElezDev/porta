@extends('layouts.app')
@section('title', __('home.home'))

@section('css')
@php
    \Carbon::setLocale(app()->getLocale());
    $today = ucfirst(\Carbon::now()->translatedFormat('l, d \d\e F \d\e Y'));
    $user_name = trim(Session::get('user.first_name') . ' ' . Session::get('user.last_name'));
@endphp
<style type="text/css">
    .content-wrapper .content-header-custom.home-hero {
        position: relative;
        overflow: hidden;
        background:
            radial-gradient(1200px 280px at 88% -40%, rgba(255,255,255,.22), transparent 55%),
            linear-gradient(135deg, var(--ui-header) 0%, var(--ui-brand) 52%, var(--ui-primary) 100%) !important;
        padding: 28px 28px 132px !important;
        border-radius: 0 0 28px 28px;
        box-shadow: 0 22px 48px -24px rgba(16, 28, 58, 0.7);
    }
    .home-hero::after {
        content: "";
        position: absolute;
        inset: auto -40px -90px auto;
        width: 240px;
        height: 240px;
        border-radius: 50%;
        background: rgba(255,255,255,.06);
        pointer-events: none;
    }
    .content-wrapper .content-custom.home-dashboard {
        margin-top: -118px !important;
        padding-top: 0 !important;
    }
    .home-hero-inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        position: relative;
        z-index: 1;
    }
    .home-hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-transform: uppercase;
        letter-spacing: 2.2px;
        font-size: 11px;
        font-weight: 700;
        color: rgba(255,255,255,.78);
        margin-bottom: 8px;
    }
    .home-hero-eyebrow::before {
        content: "";
        width: 22px;
        height: 1px;
        background: rgba(255,255,255,.55);
    }
    .home-hero-title {
        margin: 0 0 10px !important;
        font-size: 28px;
        font-weight: 700;
        color: #fff !important;
        line-height: 1.2;
        letter-spacing: -.02em;
    }
    .home-hero-meta {
        margin: 0;
        font-size: 13.5px;
        color: rgba(255,255,255,.9);
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px;
    }
    .home-hero-meta > i { margin-right: 6px; }
    .home-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: 999px;
        background: rgba(255,255,255,.14);
        border: 1px solid rgba(255,255,255,.16);
        font-weight: 600;
        font-size: 12px;
        backdrop-filter: blur(8px);
    }
    .home-hero-illustration {
        width: 92px;
        height: 92px;
        border-radius: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255,255,255,.08);
        border: 1px solid rgba(255,255,255,.12);
        color: #fff;
        font-size: 38px;
        box-shadow: inset 0 1px 0 rgba(255,255,255,.18);
    }

    .dash-toolbar {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        background: rgba(255,255,255,.92);
        border: 1px solid #e8edf6;
        border-radius: 16px;
        padding: 12px 14px;
        margin-bottom: 18px;
        box-shadow: 0 18px 40px -24px rgba(16, 24, 40, .45);
        backdrop-filter: blur(10px);
    }
    .dash-toolbar .form-control,
    .dash-toolbar .select2-container--default .select2-selection--single {
        border-radius: 10px !important;
        min-height: 38px;
        border-color: #dbe3f0;
    }
    .dash-toolbar .select2-container { min-width: 220px; }
    .dash-toolbar #dashboard_date_filter {
        border-radius: 10px !important;
        padding: 8px 14px;
        font-weight: 600;
        box-shadow: 0 8px 18px -12px rgba(21, 114, 232, .8);
    }
    .dash-toolbar-hint {
        font-size: 12px;
        color: #64748b;
        font-weight: 600;
        letter-spacing: .04em;
        text-transform: uppercase;
        margin: 0 0 4px;
    }

    .dash-kpi {
        width: 100%;
        min-height: 108px;
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 16px 16px 16px 18px;
        background: #fff;
        border: 1px solid #e8edf6;
        border-radius: 16px;
        box-shadow: 0 10px 28px -20px rgba(16, 24, 40, .45);
        position: relative;
        overflow: hidden;
        transition: transform .18s ease, box-shadow .18s ease;
        margin-bottom: 18px;
    }
    .dash-kpi::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: var(--kpi);
    }
    .dash-kpi:hover {
        transform: translateY(-3px);
        box-shadow: 0 18px 36px -22px rgba(16, 24, 40, .5);
    }
    .dash-kpi-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--kpi-soft);
        color: var(--kpi);
        font-size: 22px;
        flex-shrink: 0;
    }
    .dash-kpi-body { min-width: 0; }
    .dash-kpi-label {
        display: block;
        color: #64748b;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .04em;
        text-transform: uppercase;
        margin-bottom: 4px;
    }
    .dash-kpi .info-box-number {
        display: block;
        font-size: 20px;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.25;
        word-break: break-word;
    }
    .dash-kpi--purchase { --kpi: #4f46e5; --kpi-soft: #eef2ff; }
    .dash-kpi--sell { --kpi: #059669; --kpi-soft: #ecfdf5; }
    .dash-kpi--purchase-due { --kpi: #d97706; --kpi-soft: #fffbeb; }
    .dash-kpi--invoice-due { --kpi: #ea580c; --kpi-soft: #fff7ed; }
    .dash-kpi--expense { --kpi: #e11d48; --kpi-soft: #fff1f2; }
    .home-dashboard .row-custom > .col-custom {
        float: none;
        width: auto;
        flex: 1 1 210px;
        max-width: 100%;
    }

    .home-dashboard .box {
        border-radius: 16px !important;
        border: 1px solid #e8edf6 !important;
        border-top-color: #e8edf6 !important;
        box-shadow: 0 10px 28px -20px rgba(16, 24, 40, .4) !important;
        overflow: hidden;
    }
    .home-dashboard .box.box-primary,
    .home-dashboard .box.box-warning,
    .home-dashboard .box.box-success,
    .home-dashboard .box.box-danger,
    .home-dashboard .box.box-info {
        border-top-width: 1px !important;
    }
    .home-dashboard .box-header {
        padding: 16px 20px 12px !important;
        background: linear-gradient(180deg, #fbfcfe 0%, #fff 100%);
    }
    .home-dashboard .box-title {
        font-size: 16px !important;
        font-weight: 700 !important;
        color: #0f172a !important;
        letter-spacing: -.01em;
    }
    .home-dashboard .box-body {
        padding-top: 8px !important;
    }
    .home-dashboard .table > thead > tr > th {
        background: #f8fafc;
    }

    @media (max-width: 767px) {
        .home-hero-illustration { display: none; }
        .home-hero-title { font-size: 22px; }
        .dash-toolbar { padding: 12px; }
        .dash-toolbar .select2-container { min-width: 100%; width: 100% !important; }
    }
</style>
@stop

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header content-header-custom home-hero">
    <div class="home-hero-inner">
        <div>
            <span class="home-hero-eyebrow">{{ __('home.home') }}</span>
            <h1 class="home-hero-title">{{ __('home.welcome_message', ['name' => $user_name]) }}</h1>
            <p class="home-hero-meta">
                <i class="far fa-calendar-alt"></i>{{ $today }}
                @if(Session::get('business.name'))
                    <span class="home-hero-badge"><i class="fas fa-store"></i>{{ Session::get('business.name') }}</span>
                @endif
            </p>
        </div>
        <div class="home-hero-illustration" aria-hidden="true"><i class="fas fa-chart-line"></i></div>
    </div>
</section>


<!-- Main content -->
<section class="content content-custom home-dashboard no-print">
    @if(auth()->user()->can('dashboard.data'))
        @if($is_admin)
        	<div class="dash-toolbar">
                <div>
                    @if(count($all_locations) > 1)
                        <p class="dash-toolbar-hint">{{ __('lang_v1.select_location') }}</p>
                        {!! Form::select('dashboard_location', $all_locations, null, ['class' => 'form-control select2', 'placeholder' => __('lang_v1.select_location'), 'id' => 'dashboard_location']); !!}
                    @endif
                </div>
                <div>
                    <button type="button" class="btn btn-primary" id="dashboard_date_filter">
                      <span>
                        <i class="fa fa-calendar"></i> {{ __('messages.filter_by_date') }}
                      </span>
                      <i class="fa fa-caret-down"></i>
                    </button>
                </div>
        	</div>
    	   <div class="row row-custom">
            	<div class="col-sm-6 col-xs-12 col-custom">
            	   <div class="dash-kpi dash-kpi--purchase">
            	        <div class="dash-kpi-icon"><i class="ion ion-cash"></i></div>
            	        <div class="dash-kpi-body">
            	          <span class="dash-kpi-label">{{ __('home.total_purchase') }}</span>
            	          <span class="info-box-number total_purchase"><i class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
            	        </div>
            	   </div>
        	    </div>
        	    <div class="col-sm-6 col-xs-12 col-custom">
        	       <div class="dash-kpi dash-kpi--sell">
            	        <div class="dash-kpi-icon"><i class="ion ion-ios-cart-outline"></i></div>
            	        <div class="dash-kpi-body">
            	          <span class="dash-kpi-label">{{ __('home.total_sell') }}</span>
            	          <span class="info-box-number total_sell"><i class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
            	        </div>
        	       </div>
        	    </div>
        	    <div class="col-sm-6 col-xs-12 col-custom">
        	       <div class="dash-kpi dash-kpi--purchase-due">
            	        <div class="dash-kpi-icon"><i class="fas fa-exclamation-circle"></i></div>
            	        <div class="dash-kpi-body">
            	          <span class="dash-kpi-label">{{ __('home.purchase_due') }}</span>
            	          <span class="info-box-number purchase_due"><i class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
            	        </div>
        	       </div>
        	    </div>
        	    <div class="col-sm-6 col-xs-12 col-custom">
        	        <div class="dash-kpi dash-kpi--invoice-due">
        	           <div class="dash-kpi-icon"><i class="ion ion-ios-paper-outline"></i></div>
            	        <div class="dash-kpi-body">
            	          <span class="dash-kpi-label">{{ __('home.invoice_due') }}</span>
            	          <span class="info-box-number invoice_due"><i class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
            	        </div>
        	        </div>
        	    </div>
                <div class="col-sm-6 col-xs-12 col-custom">
                    <div class="dash-kpi dash-kpi--expense">
                        <div class="dash-kpi-icon"><i class="fas fa-minus-circle"></i></div>
                        <div class="dash-kpi-body">
                          <span class="dash-kpi-label">{{ __('lang_v1.expense') }}</span>
                          <span class="info-box-number total_expense"><i class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            @if(!empty($widgets['after_sale_purchase_totals']))
                @foreach($widgets['after_sale_purchase_totals'] as $widget)
                    {!! $widget !!}
                @endforeach
            @endif
        @endif 
        <!-- end is_admin check -->
         @if(auth()->user()->can('sell.view') || auth()->user()->can('direct_sell.view'))
            @if(!empty($all_locations))
              	<!-- sales chart start -->
              	<div class="row">
              		<div class="col-sm-12">
                        @component('components.widget', ['class' => 'box-primary', 'title' => __('home.sells_last_30_days')])
                          {!! $sells_chart_1->container() !!}
                        @endcomponent
              		</div>
              	</div>
            @endif
            @if(!empty($widgets['after_sales_last_30_days']))
                @foreach($widgets['after_sales_last_30_days'] as $widget)
                    {!! $widget !!}
                @endforeach
            @endif
            @if(!empty($all_locations))
              	<div class="row">
              		<div class="col-sm-12">
                        @component('components.widget', ['class' => 'box-primary', 'title' => __('home.sells_current_fy')])
                          {!! $sells_chart_2->container() !!}
                        @endcomponent
              		</div>
              	</div>
            @endif
        @endif
      	<!-- sales chart end -->
        @if(!empty($widgets['after_sales_current_fy']))
            @foreach($widgets['after_sales_current_fy'] as $widget)
                {!! $widget !!}
            @endforeach
        @endif
      	<!-- products less than alert quntity -->
      	<div class="row">
            @if(auth()->user()->can('sell.view') || auth()->user()->can('direct_sell.view'))
                <div class="col-sm-6">
                    @component('components.widget', ['class' => 'box-warning'])
                      @slot('icon')
                        <i class="fa fa-exclamation-triangle text-yellow" aria-hidden="true"></i>
                      @endslot
                      @slot('title')
                        {{ __('lang_v1.sales_payment_dues') }} @show_tooltip(__('lang_v1.tooltip_sales_payment_dues'))
                      @endslot
                      <table class="table table-bordered table-striped" id="sales_payment_dues_table">
                        <thead>
                          <tr>
                            <th>@lang( 'contact.customer' )</th>
                            <th>@lang( 'sale.invoice_no' )</th>
                            <th>@lang( 'home.due_amount' )</th>
                            <th>@lang( 'messages.action' )</th>
                          </tr>
                        </thead>
                      </table>
                    @endcomponent
                </div>
            @endif
            @can('purchase.view')
                <div class="col-sm-6">
                    @component('components.widget', ['class' => 'box-warning'])
                    @slot('icon')
                    <i class="fa fa-exclamation-triangle text-yellow" aria-hidden="true"></i>
                    @endslot
                    @slot('title')
                    {{ __('lang_v1.purchase_payment_dues') }} @show_tooltip(__('tooltip.payment_dues'))
                    @endslot
                    <table class="table table-bordered table-striped" id="purchase_payment_dues_table">
                        <thead>
                          <tr>
                            <th>@lang( 'purchase.supplier' )</th>
                            <th>@lang( 'purchase.ref_no' )</th>
                            <th>@lang( 'home.due_amount' )</th>
                            <th>@lang( 'messages.action' )</th>
                          </tr>
                        </thead>
                    </table>
                    @endcomponent
                </div>
            @endcan
        </div>
        @can('stock_report.view')
            <div class="row">
                <div class="@if((session('business.enable_product_expiry') != 1) && auth()->user()->can('stock_report.view')) col-sm-12 @else col-sm-6 @endif">
                    @component('components.widget', ['class' => 'box-warning'])
                      @slot('icon')
                        <i class="fa fa-exclamation-triangle text-yellow" aria-hidden="true"></i>
                      @endslot
                      @slot('title')
                        {{ __('home.product_stock_alert') }} @show_tooltip(__('tooltip.product_stock_alert'))
                      @endslot
                      <table class="table table-bordered table-striped" id="stock_alert_table" style="width: 100%;">
                        <thead>
                          <tr>
                            <th>@lang( 'sale.product' )</th>
                            <th>@lang( 'business.location' )</th>
                            <th>@lang( 'report.current_stock' )</th>
                          </tr>
                        </thead>
                      </table>
                    @endcomponent
                </div>
                @if(session('business.enable_product_expiry') == 1)
                    <div class="col-sm-6">
                        @component('components.widget', ['class' => 'box-warning'])
                          @slot('icon')
                            <i class="fa fa-exclamation-triangle text-yellow" aria-hidden="true"></i>
                          @endslot
                          @slot('title')
                            {{ __('home.stock_expiry_alert') }} @show_tooltip( __('tooltip.stock_expiry_alert', [ 'days' =>session('business.stock_expiry_alert_days', 30) ]) )
                          @endslot
                          <input type="hidden" id="stock_expiry_alert_days" value="{{ \Carbon::now()->addDays(session('business.stock_expiry_alert_days', 30))->format('Y-m-d') }}">
                          <table class="table table-bordered table-striped" id="stock_expiry_alert_table">
                            <thead>
                              <tr>
                                  <th>@lang('business.product')</th>
                                  <th>@lang('business.location')</th>
                                  <th>@lang('report.stock_left')</th>
                                  <th>@lang('product.expires_in')</th>
                              </tr>
                            </thead>
                          </table>
                        @endcomponent
                    </div>
                @endif
      	    </div>
        @endcan
        @if(auth()->user()->can('so.view_all') || auth()->user()->can('so.view_own'))
            <div class="row" @if(!auth()->user()->can('dashboard.data'))style="margin-top: 190px !important;"@endif>
                <div class="col-sm-12">
                    @component('components.widget', ['class' => 'box-warning'])
                        @slot('icon')
                            <i class="fas fa-list-alt text-yellow fa-lg" aria-hidden="true"></i>
                        @endslot
                        @slot('title')
                            {{__('lang_v1.sales_order')}}
                        @endslot
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped ajax_view" id="sales_order_table">
                                <thead>
                                    <tr>
                                        <th>@lang('messages.action')</th>
                                        <th>@lang('messages.date')</th>
                                        <th>@lang('restaurant.order_no')</th>
                                        <th>@lang('sale.customer_name')</th>
                                        <th>@lang('lang_v1.contact_no')</th>
                                        <th>@lang('sale.location')</th>
                                        <th>@lang('sale.status')</th>
                                        <th>@lang('lang_v1.shipping_status')</th>
                                        <th>@lang('lang_v1.quantity_remaining')</th>
                                        <th>@lang('lang_v1.added_by')</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    @endcomponent
                </div>
            </div>
        @endif
        @if(!empty($common_settings['enable_purchase_order']) && (auth()->user()->can('purchase_order.view_all') || auth()->user()->can('purchase_order.view_own')) )
            <div class="row" @if(!auth()->user()->can('dashboard.data'))style="margin-top: 190px !important;"@endif>
                <div class="col-sm-12">
                    @component('components.widget', ['class' => 'box-warning'])
                      @slot('icon')
                          <i class="fas fa-list-alt text-yellow fa-lg" aria-hidden="true"></i>
                      @endslot
                      @slot('title')
                          @lang('lang_v1.purchase_order')
                      @endslot
                        <div class="table-responsive">
                                <table class="table table-bordered table-striped ajax_view" id="purchase_order_table" style="width: 100%;">
                                  <thead>
                                      <tr>
                                          <th>@lang('messages.action')</th>
                                          <th>@lang('messages.date')</th>
                                          <th>@lang('purchase.ref_no')</th>
                                          <th>@lang('purchase.location')</th>
                                          <th>@lang('purchase.supplier')</th>
                                          <th>@lang('sale.status')</th>
                                          <th>@lang('lang_v1.quantity_remaining')</th>
                                          <th>@lang('lang_v1.added_by')</th>
                                      </tr>
                                  </thead>
                                </table>
                        </div>
                    @endcomponent
                </div>
            </div>
        @endif

        @if(auth()->user()->can('access_pending_shipments_only') || auth()->user()->can('access_shipping') || auth()->user()->can('access_own_shipping') )
            @component('components.widget', ['class' => 'box-warning'])
              @slot('icon')
                  <i class="fas fa-list-alt text-yellow fa-lg" aria-hidden="true"></i>
              @endslot
              @slot('title')
                  @lang('lang_v1.pending_shipments')
              @endslot
                <div class="table-responsive">
                    <table class="table table-bordered table-striped ajax_view" id="shipments_table">
                        <thead>
                            <tr>
                                <th>@lang('messages.action')</th>
                                <th>@lang('messages.date')</th>
                                <th>@lang('sale.invoice_no')</th>
                                <th>@lang('sale.customer_name')</th>
                                <th>@lang('lang_v1.contact_no')</th>
                                <th>@lang('sale.location')</th>
                                <th>@lang('lang_v1.shipping_status')</th>
                                @if(!empty($custom_labels['shipping']['custom_field_1']))
                                    <th>
                                        {{$custom_labels['shipping']['custom_field_1']}}
                                    </th>
                                @endif
                                @if(!empty($custom_labels['shipping']['custom_field_2']))
                                    <th>
                                        {{$custom_labels['shipping']['custom_field_2']}}
                                    </th>
                                @endif
                                @if(!empty($custom_labels['shipping']['custom_field_3']))
                                    <th>
                                        {{$custom_labels['shipping']['custom_field_3']}}
                                    </th>
                                @endif
                                @if(!empty($custom_labels['shipping']['custom_field_4']))
                                    <th>
                                        {{$custom_labels['shipping']['custom_field_4']}}
                                    </th>
                                @endif
                                @if(!empty($custom_labels['shipping']['custom_field_5']))
                                    <th>
                                        {{$custom_labels['shipping']['custom_field_5']}}
                                    </th>
                                @endif
                                <th>@lang('sale.payment_status')</th>
                                <th>@lang('restaurant.service_staff')</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            @endcomponent
        @endif

        @if(!empty($widgets['after_dashboard_reports']))
          @foreach($widgets['after_dashboard_reports'] as $widget)
            {!! $widget !!}
          @endforeach
        @endif

    @endif
   <!-- can('dashboard.data') end -->
</section>
<!-- /.content -->
<div class="modal fade payment_modal" tabindex="-1" role="dialog" 
    aria-labelledby="gridSystemModalLabel">
</div>
<div class="modal fade edit_pso_status_modal" tabindex="-1" role="dialog"></div>
<div class="modal fade edit_payment_modal" tabindex="-1" role="dialog" 
    aria-labelledby="gridSystemModalLabel">
</div>
@stop
@section('javascript')
    <script src="{{ asset('js/home.js?v=' . $asset_v) }}"></script>
    <script src="{{ asset('js/payment.js?v=' . $asset_v) }}"></script>
    @includeIf('sales_order.common_js')
    @includeIf('purchase_order.common_js')
    @if(!empty($all_locations))
        {!! $sells_chart_1->script() !!}
        {!! $sells_chart_2->script() !!}
    @endif
    <script type="text/javascript">
        sales_order_table = $('#sales_order_table').DataTable({
          processing: true,
          serverSide: true,
          scrollY: "75vh",
          scrollX:        true,
          scrollCollapse: true,
          aaSorting: [[1, 'desc']],
          "ajax": {
              "url": '{{action("SellController@index")}}?sale_type=sales_order',
              "data": function ( d ) {
                  d.for_dashboard_sales_order = true;
              }
          },
          columnDefs: [ {
              "targets": 7,
              "orderable": false,
              "searchable": false
          } ],
          columns: [
              { data: 'action', name: 'action'},
              { data: 'transaction_date', name: 'transaction_date'  },
              { data: 'invoice_no', name: 'invoice_no'},
              { data: 'conatct_name', name: 'conatct_name'},
              { data: 'mobile', name: 'contacts.mobile'},
              { data: 'business_location', name: 'bl.name'},
              { data: 'status', name: 'status'},
              { data: 'shipping_status', name: 'shipping_status'},
              { data: 'so_qty_remaining', name: 'so_qty_remaining', "searchable": false},
              { data: 'added_by', name: 'u.first_name'},
          ]
      });
        @if(!empty($common_settings['enable_purchase_order']))
        $(document).ready( function(){
          //Purchase table
          purchase_order_table = $('#purchase_order_table').DataTable({
              processing: true,
              serverSide: true,
              aaSorting: [[1, 'desc']],
              scrollY: "75vh",
              scrollX:        true,
              scrollCollapse: true,
              ajax: {
                  url: '{{action("PurchaseOrderController@index")}}',
                  data: function(d) {
                      d.from_dashboard = true;
                  },
              },
              columns: [
                  { data: 'action', name: 'action', orderable: false, searchable: false },
                  { data: 'transaction_date', name: 'transaction_date' },
                  { data: 'ref_no', name: 'ref_no' },
                  { data: 'location_name', name: 'BS.name' },
                  { data: 'name', name: 'contacts.name' },
                  { data: 'status', name: 'transactions.status' },
                  { data: 'po_qty_remaining', name: 'po_qty_remaining', "searchable": false},
                  { data: 'added_by', name: 'u.first_name' }
              ]
          });
        })
        @endif

        sell_table = $('#shipments_table').DataTable({
            processing: true,
            serverSide: true,
            aaSorting: [[1, 'desc']],
            scrollY:        "75vh",
            scrollX:        true,
            scrollCollapse: true,
            "ajax": {
                "url": '{{action("SellController@index")}}',
                "data": function ( d ) {
                    d.only_pending_shipments = true;
                }
            },
            columns: [
                { data: 'action', name: 'action', searchable: false, orderable: false},
                { data: 'transaction_date', name: 'transaction_date'  },
                { data: 'invoice_no', name: 'invoice_no'},
                { data: 'conatct_name', name: 'conatct_name'},
                { data: 'mobile', name: 'contacts.mobile'},
                { data: 'business_location', name: 'bl.name'},
                { data: 'shipping_status', name: 'shipping_status'},
                @if(!empty($custom_labels['shipping']['custom_field_1']))
                    { data: 'shipping_custom_field_1', name: 'shipping_custom_field_1'},
                @endif
                @if(!empty($custom_labels['shipping']['custom_field_2']))
                    { data: 'shipping_custom_field_2', name: 'shipping_custom_field_2'},
                @endif
                @if(!empty($custom_labels['shipping']['custom_field_3']))
                    { data: 'shipping_custom_field_3', name: 'shipping_custom_field_3'},
                @endif
                @if(!empty($custom_labels['shipping']['custom_field_4']))
                    { data: 'shipping_custom_field_4', name: 'shipping_custom_field_4'},
                @endif
                @if(!empty($custom_labels['shipping']['custom_field_5']))
                    { data: 'shipping_custom_field_5', name: 'shipping_custom_field_5'},
                @endif
                { data: 'payment_status', name: 'payment_status'},
                { data: 'waiter', name: 'ss.first_name', @if(empty($is_service_staff_enabled)) visible: false @endif }
            ],
            "fnDrawCallback": function (oSettings) {
                __currency_convert_recursively($('#sell_table'));
            },
            createdRow: function( row, data, dataIndex ) {
                $( row ).find('td:eq(4)').attr('class', 'clickable_td');
            }
        });
    </script>
@endsection

