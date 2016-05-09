@extends('layouts.base')

@section('container')
<script type='text/javascript'>
$(document).ready(function()
{
	$('#acct-ias-settings-form').jqMgVal('addFormFieldsValidations');

	if(!$('#acct-ias-voucher-numeration-type-0').is(':checked') && !$('#acct-ias-voucher-numeration-type-1').is(':checked'))
	{
		$('#acct-ias-voucher-numeration-type-0').attr('checked', 'checked');
	}

	$('#acct-ias-btn-update').click(function()
	{
		if(!$('#acct-ias-settings-form').jqMgVal('isFormValid'))
		{
			return;
		}

		$.ajax(
		{
			type: 'POST',
			data: JSON.stringify($('#acct-ias-settings-form').formToObject('acct-ias-')),
			dataType : 'json',
			url: $('#acct-ias-settings-form').attr('action'),
			error: function (jqXHR, textStatus, errorThrown)
			{
				handleServerExceptions(jqXHR, 'acct-ias-settings-form');
			},
			beforeSend:function()
			{
				$('#app-loader').removeClass('hidden');
				disabledAll();
			},
			success:function(json)
			{
				$('#acct-ias-settings-form').showAlertAsFirstChild('alert-success',json.success, 5000);
				$('#acct-ias-settings-form').find('.has-success').each(function()
				{
					$(this).removeClass('has-success');
				});
				$('#acct-ias-settings-form').find('.control-label').each(function()
				{
					$(this).find('.fa-check-circle' + ',.fa-times-circle' + ',.mg-is').remove();
				});
				$('#acct-ias-settings-form').find('.mg-hmt').remove();
				$('#acct-ias-settings-form').find('input[type=radio]').each(function()
				{
					$(this).attr('disabled','disabled');
				});

				$('#acct-ias-year').attr('disabled','disabled');
				$('#acct-ias-voucher-numeration-type-0').removeAttr('disabled');
				$('#acct-ias-voucher-numeration-type-1').removeAttr('disabled');
				$('#acct-ias-form-setting-message').show();
				$('#app-loader').addClass('hidden');
				enableAll();
				cleanJournals('acct-ias-');
				getAppJournals('acct-ias-','firstPage', $('#acct-ias-setting-id').val());
			}
		});
	});
});
</script>
{!! Form::hidden('acct-ias-setting-id', $currentSettingConfiguration['id'], array('id' => 'acct-ias-setting-id')) !!}
{{-- var_dump($journals) --}}
{{-- var_dump($currentSettingConfiguration) --}}
{{-- var_dump($currentSettingConfiguration['voucher_numeration_type']=='V') --}}
<div class="row">
	<fieldset id="acct-ias-form-fieldset">
		<div class="col-lg-6 col-md-6">
			<div id="acct-ias-form-container" class="form-container form-container-custom clearfix">
				{!! Form::open(array('id' => 'acct-ias-settings-form', 'url' => URL::to('accounting/setup/initial-accounting-setup/update-settings'), 'role' => 'form', 'onsubmit' => 'return false;')) !!}
					<legend>{{ Lang::get('decima-accounting::initial-accounting-setup.formTitle') }}</legend>
					<div id='acct-ias-form-setting-message' class="alert alert-info alert-form-custom" {{ !empty($currentSettingConfiguration['is_configured'])?'':'style="display:none;"' }}>
						<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
						{{ Lang::get('decima-accounting::initial-accounting-setup.initialSettingMessage') }}
					</div>
					<div class="form-group mg-hm">
						{!! Form::label('acct-ias-year', Lang::get('decima-accounting::initial-accounting-setup.initialYear'), array('class' => 'control-label')) !!}
						{!! Form::select('acct-ias-year', $years, !empty($currentSettingConfiguration['is_configured'])?$currentSettingConfiguration['initial_year']:date('Y'), array('id' => 'acct-ias-year', 'class' => 'form-control', 'data-mg-required' => '', (!empty($currentSettingConfiguration['is_configured'])?'disabled':'') => '')) !!}
						<p class="help-block">{{ Lang::get('decima-accounting::initial-accounting-setup.initialYearHelperText') }}</p>
					</div>
					<div class="form-group mg-hm" data-mg-required="">
						{!! Form::label('acct-ias-account-chart-type-id', Lang::get('decima-accounting::initial-accounting-setup.accountChartType'), array('class' => 'control-label')) !!}
						@foreach ($accountsChartsTypes as $index => $accountChartType)
							@if (@index == 0)
								<div class="radio" style="margin-top: 0px;">
							@else
								<div class="radio">
							@endif
							<label>
								{!! Form::radio('acct-ias-account-chart-type-id', $accountChartType['id'], ($currentSettingConfiguration['account_chart_type_id']==$accountChartType['id']?true:false), array('id' => 'acct-ias-account-chart-type-id' . $index, (!empty($currentSettingConfiguration['is_configured'])?'disabled':'') => '')) !!} {{ $accountChartType['name'] }}
							</label>
							@if ($accountChartType['url'] != '')
								<label>
									<a href="{{ $accountChartType['url'] }}" target="_blank">{{ Lang::get('decima-accounting::initial-accounting-setup.accountChartTypeLink') }}</a>
								</label>
							@endif
						</div>
						@endforeach
						<p class="help-block">{{ Lang::get('decima-accounting::initial-accounting-setup.accountChartTypeHelperText') }}</p>
					</div>
					<div class="form-group mg-hm" data-mg-required="">
						{!! Form::label('acct-ias-voucher-numeration-type', Lang::get('decima-accounting::initial-accounting-setup.voucherNumerationType'), array('class' => 'control-label')) !!}
						<div class="radio" style="margin-top: 0px;">
							<label>
								{!! Form::radio('acct-ias-voucher-numeration-type', 'P', ($currentSettingConfiguration['voucher_numeration_type']=='P'?true:false), array('id' => 'acct-ias-voucher-numeration-type-0')) !!} {{ Lang::get('decima-accounting::initial-accounting-setup.P') }}
							</label>
						</div>
						<div class="radio">
							<label>
								{!! Form::radio('acct-ias-voucher-numeration-type', 'V', ($currentSettingConfiguration['voucher_numeration_type']=='V'?true:false), array('id' => 'acct-ias-voucher-numeration-type-1')) !!} {{ Lang::get('decima-accounting::initial-accounting-setup.V') }}
							</label>
						</div>
					</div>
					<div class="form-group checkbox">
						<label class="control-label">
							{!! Form::checkbox('acct-ias-create-opening-period', 'S', !empty($currentSettingConfiguration['is_configured'])?$currentSettingConfiguration['create_opening_period']:false, array('id' => 'acct-ias-create-opening-period')) !!}
							{{ Lang::get('decima-accounting::initial-accounting-setup.createOpeningPeriod') }}
						</label>
						<p class="help-block">{{ Lang::get('decima-accounting::initial-accounting-setup.createOpeningPeriodHelperText') }}</p>
					</div>
					<div class="form-group checkbox">
						<label class="control-label">
							{!! Form::checkbox('acct-ias-create-closing-period', 'S', !empty($currentSettingConfiguration['is_configured'])?$currentSettingConfiguration['create_closing_period']:false, array('id' => 'acct-ias-create-closing-period')) !!}
							{{ Lang::get('decima-accounting::initial-accounting-setup.createClosingPeriod') }}
						</label>
						<p class="help-block">{{ Lang::get('decima-accounting::initial-accounting-setup.createClosingPeriodHelperText') }}</p>
					</div>

					{!! Form::button('<i class="fa fa-save"></i> ' . Lang::get('decima-accounting::initial-accounting-setup.update'), array('id' => 'acct-ias-btn-update', 'class' => 'btn btn-default btn-lg pull-right')) !!}
				{!! Form::close() !!}
			</div>
		</div>
		<div class="col-lg-6 col-md-6">
			<div class="row">
				{!! Form::journals('acct-ias-', 'acct-initial-acounting-setup', false, '', $currentSettingConfiguration['id'], false, '', $journals) !!}
			</div>
		</div>
	</fieldset>
</div>
@parent
@stop
