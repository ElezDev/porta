@foreach($sells as $sell)
	<article class="cd-job">
		<div class="cd-job-head">
			<h3><i class="fas fa-receipt"></i> {{ $sell->job_sheet_no }}</h3>
			@if(!empty($sell->repair_status))
				<span class="cd-status" style="background-color: {{ $sell->repair_status_color ?: '#1572E8' }};">
					{{ $sell->repair_status }}
				</span>
			@endif
		</div>
		<div class="cd-job-meta">
			<div>
				<span>@lang('product.brand')</span>
				<strong>{{ $sell->manufacturer }}</strong>
			</div>
			<div>
				<span>@lang('repair::lang.device')</span>
				<strong>{{ $sell->repair_device }}</strong>
			</div>
			<div>
				<span>@lang('repair::lang.model')</span>
				<strong>{{ $sell->repair_model }}</strong>
			</div>
			<div>
				<span>@lang('repair::lang.serial_no')</span>
				<strong>{{ $sell->serial_no }}</strong>
			</div>
			<div>
				<span>@lang('repair::lang.current_repair_status')</span>
				<strong>{{ $sell->repair_status }}</strong>
			</div>
			<div>
				<span>@lang('repair::lang.expected_delivery_date')</span>
				<strong>
					@if(!empty($sell->delivery_date))
						{{ \Carbon::parse($sell->delivery_date)->toDayDateTimeString() }}
					@endif
				</strong>
			</div>
		</div>
		<div>
			<span style="display:block;font-size:11px;font-weight:700;letter-spacing:.05em;text-transform:uppercase;color:#7d8db0;margin-bottom:8px;">
				{{ __('repair::lang.activities') }}
			</span>
			@includeIf('repair::customer_repair.repair_activities', ['activities' => $sell['activities']])
		</div>
	</article>
@endforeach
