@extends('layouts.base')

@section('container')
{!! Form::hidden('acct-cfy-new-action', null, array('id' => 'acct-cfy-new-action')) !!}
{!! Form::hidden('acct-cfy-edit-action', null, array('id' => 'acct-cfy-edit-action', 'data-content' => Lang::get('module::app.editHelpText'))) !!}
{!! Form::hidden('acct-cfy-remove-action', null, array('id' => 'acct-cfy-remove-action', 'data-content' => Lang::get('module::app.editHelpText'))) !!}
{!! Form::button('', array('id' => 'acct-cfy-btn-edit-helper', 'class' => 'hidden')) !!}
{!! Form::button('', array('id' => 'acct-cfy-btn-delete-helper', 'class' => 'hidden')) !!}
<style></style>

<script type='text/javascript'>
	//Falta agregar  codigo para quitar tooltip

	//For grids with multiselect disabled
	function acctCfyOnSelectRowEvent()
	{
		var id = $('#acct-cfy-grid').getSelectedRowId('acct_cfy_id');

		getAppJournals('acct-cfy-', 'firstPage', id);

		$('#acct-cfy-btn-group-2').enableButtonGroup();
	}

	$(document).ready(function()
	{
		$('.acct-cfy-btn-tooltip').tooltip();

		$('#acct-cfy-modal-expenses-form').jqMgVal('addFormFieldsValidations');
		$('#acct-cfy-modal-income-form').jqMgVal('addFormFieldsValidations');
		$('#acct-cfy-modal-closing-balance-form').jqMgVal('addFormFieldsValidations');

		$('#acct-cfy-btn-refresh').click(function()
		{
			$('.acct-cfy-btn-tooltip').tooltip('hide');
			$('#acct-cfy-grid').trigger('reloadGrid');
			cleanJournals('acct-cfy-');
			$('#acct-cfy-btn-toolbar').disabledButtonGroup();
			$('#acct-cfy-btn-group-1').enableButtonGroup();
		});

		$('#acct-cfy-btn-export-xls').click(function()
		{
				$('#acct-cfy-gridXlsButton').click();
		});

		$('#acct-cfy-btn-export-csv').click(function()
		{
				$('#acct-cfy-gridCsvButton').click();
		});

		$('#acct-cfy-btn-expenses-voucher').click(function()
		{
			var rowData;

			if($(this).hasAttr('disabled'))
			{
				return;
			}

			rowData = $('#acct-cfy-grid').getRowData($('#acct-cfy-grid').jqGrid('getGridParam', 'selrow'));
			$('#acct-cfy-fiscal-year-id').val(rowData['acct_cfy_id']);
			$('.acct-cfy-btn-tooltip').tooltip('hide');

			$.ajax(
			{
				type: 'POST',
				data: JSON.stringify({'_token':$('#app-token').val(), 'id':rowData['acct_cfy_id']}),
				dataType : 'json',
				url:  $('#app-url').val() + '/accounting/setup/period-management/last-period-of-fiscal-year',
				error: function (jqXHR, textStatus, errorThrown)
				{
					handleServerExceptions(jqXHR, 'acct-cfy-btn-toolbar', false);
				},
				beforeSend:function()
				{
					$('#app-loader').removeClass('hidden');
					disabledAll();
				},
				success:function(json)
				{
					$('#acct-cfy-period-id').val(json.id);
					$('#acct-cfy-period-label').val(json.month);
					$('#acct-cfy-date').val(json.endDate);
					$('#acct-cfy-modal-expenses').modal('show');
					$('#app-loader').addClass('hidden');
					enableAll();
				}
			});

		});

		$('#acct-cfy-btn-modal-expenses').click(function()
		{
			if(!$('#acct-cfy-modal-expenses-form').jqMgVal('isFormValid'))
			{
				return;
			}

			$.ajax(
			{
				type: 'POST',
				data: JSON.stringify($('#acct-cfy-modal-expenses-form').formToObject('acct-cfy-')),
				dataType : 'json',
				url:  $('#acct-cfy-modal-expenses-form').attr('action') + '/expenses-voucher',
				error: function (jqXHR, textStatus, errorThrown)
				{
					handleServerExceptions(jqXHR, 'acct-cfy-btn-toolbar', false);
				},
				beforeSend:function()
				{
					$('#app-loader').removeClass('hidden');
					disabledAll();
				},
				success:function(json)
				{
					if(json.success)
					{
						$('#acct-cfy-modal-expenses').modal('hide');
						$('#acct-cfy-btn-toolbar').showAlertAfterElement('alert-success alert-custom',json.success, 15000);
						cleanJournals('acct-cfy-');
						getAppJournals('acct-cfy-', 'firstPage', $('#acct-cfy-fiscal-year-id').val());
					}

					$('#app-loader').addClass('hidden');
					enableAll();
				}
			});
		});

		$('#acct-cfy-btn-income-voucher').click(function()
		{
			var rowData;

			if($(this).hasAttr('disabled'))
			{
				return;
			}

			rowData = $('#acct-cfy-grid').getRowData($('#acct-cfy-grid').jqGrid('getGridParam', 'selrow'));
			$('#acct-cfy2-fiscal-year-id').val(rowData['acct_cfy_id']);
			$('.acct-cfy-btn-tooltip').tooltip('hide');

			$.ajax(
			{
				type: 'POST',
				data: JSON.stringify({'_token':$('#app-token').val(), 'id':rowData['acct_cfy_id']}),
				dataType : 'json',
				url:  $('#app-url').val() + '/accounting/setup/period-management/last-period-of-fiscal-year',
				error: function (jqXHR, textStatus, errorThrown)
				{
					handleServerExceptions(jqXHR, 'acct-cfy-btn-toolbar', false);
				},
				beforeSend:function()
				{
					$('#app-loader').removeClass('hidden');
					disabledAll();
				},
				success:function(json)
				{
					$('#acct-cfy2-period-id').val(json.id);
					$('#acct-cfy2-period-label').val(json.month);
					$('#acct-cfy2-date').val(json.endDate);
					$('#acct-cfy-modal-income').modal('show');
					$('#app-loader').addClass('hidden');
					enableAll();
				}
			});

		});

		$('#acct-cfy-btn-modal-income').click(function()
		{
			if(!$('#acct-cfy-modal-income-form').jqMgVal('isFormValid'))
			{
				return;
			}

			$.ajax(
			{
				type: 'POST',
				data: JSON.stringify($('#acct-cfy-modal-income-form').formToObject('acct-cfy2-')),
				dataType : 'json',
				url:  $('#acct-cfy-modal-income-form').attr('action') + '/income-voucher',
				error: function (jqXHR, textStatus, errorThrown)
				{
					handleServerExceptions(jqXHR, 'acct-cfy-btn-toolbar', false);
				},
				beforeSend:function()
				{
					$('#app-loader').removeClass('hidden');
					disabledAll();
				},
				success:function(json)
				{
					if(json.success)
					{
						$('#acct-cfy-modal-income').modal('hide');
						$('#acct-cfy-btn-toolbar').showAlertAfterElement('alert-success alert-custom',json.success, 15000);
						cleanJournals('acct-cfy-');
						getAppJournals('acct-cfy-', 'firstPage', $('#acct-cfy2-fiscal-year-id').val());
					}

					$('#app-loader').addClass('hidden');
					enableAll();
				}
			});
		});

		$('#acct-cfy-btn-closing-balance-voucher').click(function()
		{
			var rowData;

			if($(this).hasAttr('disabled'))
			{
				return;
			}

			rowData = $('#acct-cfy-grid').getRowData($('#acct-cfy-grid').jqGrid('getGridParam', 'selrow'));
			$('#acct-cfy3-fiscal-year-id').val(rowData['acct_cfy_id']);
			$('.acct-cfy-btn-tooltip').tooltip('hide');

			$.ajax(
			{
				type: 'POST',
				data: JSON.stringify({'_token':$('#app-token').val(), 'id':rowData['acct_cfy_id']}),
				dataType : 'json',
				url:  $('#app-url').val() + '/accounting/setup/period-management/balance-accounts-closing-periods',
				error: function (jqXHR, textStatus, errorThrown)
				{
					handleServerExceptions(jqXHR, 'acct-cfy-btn-toolbar', false);
				},
				beforeSend:function()
				{
					$('#app-loader').removeClass('hidden');
					disabledAll();
				},
				success:function(json)
				{
					if(json.info)
					{
						$('#acct-cfy-btn-toolbar').showAlertAfterElement('alert-info alert-custom', json.info, 15000);
					}
					else
					{
						$('#acct-cfy3-period-id-closing').val(json.id0);
						$('#acct-cfy3-period-label-closing').val(json.month0);
						$('#acct-cfy3-date-closing').val(json.endDate0);
						$('#acct-cfy3-period-id-opening').val(json.id1);
						$('#acct-cfy3-period-label-opening').val(json.month1);
						$('#acct-cfy3-date-opening').val(json.endDate1);
						$('#acct-cfy3-fiscal-year-id-opening').val(json.fiscalYearId);
						$('#acct-cfy-modal-closing-balance').modal('show');
					}

					$('#app-loader').addClass('hidden');
					enableAll();
				}
			});

		});

		$('#acct-cfy-btn-modal-closing-balance').click(function()
		{
			if(!$('#acct-cfy-modal-closing-balance-form').jqMgVal('isFormValid'))
			{
				return;
			}

			$.ajax(
			{
				type: 'POST',
				data: JSON.stringify($('#acct-cfy-modal-closing-balance-form').formToObject('acct-cfy3-')),
				dataType : 'json',
				url:  $('#acct-cfy-modal-closing-balance-form').attr('action') + '/closing-balance-voucher',
				error: function (jqXHR, textStatus, errorThrown)
				{
					handleServerExceptions(jqXHR, 'acct-cfy-btn-toolbar', false);
				},
				beforeSend:function()
				{
					$('#app-loader').removeClass('hidden');
					disabledAll();
				},
				success:function(json)
				{
					if(json.success)
					{
						$('#acct-cfy-modal-closing-balance').modal('hide');
						$('#acct-cfy-btn-toolbar').showAlertAfterElement('alert-success alert-custom',json.success, 15000);
						cleanJournals('acct-cfy-');
						getAppJournals('acct-cfy-', 'firstPage', $('#acct-cfy3-fiscal-year-id').val());
					}

					$('#app-loader').addClass('hidden');
					enableAll();
				}
			});
		});


	});
</script>

<div class="row">
	<div class="col-lg-12 col-md-12">
		<div id="acct-cfy-btn-toolbar" class="section-header btn-toolbar" role="toolbar">
			<div id="acct-cfy-btn-group-1" class="btn-group btn-group-app-toolbar">
				{!! Form::button('<i class="fa fa-refresh"></i> ' . Lang::get('toolbar.refresh'), array('id' => 'acct-cfy-btn-refresh', 'class' => 'btn btn-default acct-cfy-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'data-original-title' => Lang::get('toolbar.refreshLongText'))) !!}
				<div class="btn-group">
					{!! Form::button('<i class="fa fa-share-square-o"></i> ' . Lang::get('toolbar.export') . ' <span class="caret"></span>', array('class' => 'btn btn-default dropdown-toggle', 'data-container' => 'body', 'data-toggle' => 'dropdown')) !!}
					<ul class="dropdown-menu">
         		<li><a id='acct-cfy-btn-export-xls' class="fake-link"><i class="fa fa-file-excel-o"></i> xls</a></li>
         		<li><a id='acct-cfy-btn-export-csv' class="fake-link"><i class="fa fa-file-text-o"></i> csv</a></li>
       		</ul>
				</div>
			</div>
			<div id="acct-cfy-btn-group-2" class="btn-group btn-group-app-toolbar">
				<div class="btn-group">
					{!! Form::button('<i class="fa fa-calculator"></i> ' . Lang::get('decima-accounting::close-fiscal-year.close') . ' <span class="caret"></span>', array('class' => 'btn btn-default dropdown-toggle', 'data-container' => 'body', 'data-toggle' => 'dropdown', 'disabled' => '')) !!}
					<ul class="dropdown-menu">
         		<li><a id='acct-cfy-btn-expenses-voucher' class="fake-link"><i class="fa fa-money"></i> {{ Lang::get('decima-accounting::close-fiscal-year.expenses') }}</a></li>
         		<li><a id='acct-cfy-btn-income-voucher' class="fake-link"><i class="fa fa-money"></i> {{ Lang::get('decima-accounting::close-fiscal-year.income') }}</a></li>
         		<li><a id='acct-cfy-btn-closing-balance-voucher' class="fake-link"><i class="fa fa-balance-scale"></i> {{ Lang::get('decima-accounting::close-fiscal-year.closingBalance') }}</a></li>
       		</ul>
				</div>
			</div>
		</div>
		<div id='acct-cfy-grid-section' class='app-grid collapse in' data-app-grid-id='acct-cfy-grid'>
			{!!
			GridRender::setGridId("acct-cfy-grid")
				->enablefilterToolbar(false, false)
				->hideXlsExporter()
  			->hideCsvExporter()
				->setGridOption('multiselect', false)
	    	->setGridOption('url',URL::to('accounting/transactions/close-fiscal-year/grid-data'))
	    	->setGridOption('caption', Lang::get('decima-accounting::close-fiscal-year.gridTitle', array('user' => AuthManager::getLoggedUserFirstname())))
	    	->setGridOption('postData',array('_token' => Session::token()))
				->setGridEvent('onSelectRow', 'acctCfyOnSelectRowEvent')
	    	->addColumn(array('index' => 'id', 'name' => 'acct_cfy_id', 'hidden' => true))
	    	->addColumn(array('label' => Lang::get('decima-accounting::balance-sheet.fiscalYear'), 'index' => 'year' ,'name' => 'acct_cfy_year', 'align'=>'center'))
	    	->addColumn(array('label' => Lang::get('decima-accounting::period-management.startDate'), 'index' => 'start_date' ,'name' => 'acct_cfy_start_date', 'formatter' => 'date', 'align'=>'center'))
	    	->addColumn(array('label' => Lang::get('decima-accounting::period-management.endDate'), 'index' => 'end_date' ,'name' => 'acct_cfy_end_date', 'formatter' => 'date', 'align'=>'center'))
	    	->renderGrid();
			!!}
		</div>
	</div>
</div>
<div id='acct-cfy-journals-section' class="row collapse in section-block">
	{!! Form::journals('acct-cfy-', $appInfo['id']) !!}
</div>
<div id='acct-cfy-modal-expenses' class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
			<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{{ Lang::get('decima-accounting::close-fiscal-year.expensesTitle') }}</h4>
      </div>
			<div class="modal-body clearfix">
				<div class="row">
					<div class="col-md-12">
						{!! Form::open(array('id' => 'acct-cfy-modal-expenses-form', 'url' => URL::to('accounting/transactions/close-fiscal-year'), 'role' => 'form', 'onsubmit' => 'return false;')) !!}
						<div class="form-group mg-hm">
							{!! Form::label('acct-cfy-date', Lang::get('decima-accounting::journal-management.date'), array('class' => 'control-label')) !!}
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
								{!! Form::text('acct-cfy-date', '' , array('id' => 'acct-cfy-date', 'class' => 'form-control', 'disabled' => '')) !!}
							</div>
						</div>
						<div class="form-group mg-hm">
							{!! Form::label('acct-cfy-period-label', Lang::get('decima-accounting::period-management.period'), array('class' => 'control-label')) !!}
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								{!! Form::text('acct-cfy-period-label', '' , array('id' => 'acct-cfy-period-label', 'class' => 'form-control', 'disabled' => '')) !!}
							</div>
							{!! Form::hidden('acct-cfy-period-id', '', array('id' => 'acct-cfy-period-id')) !!}
							{!! Form::hidden('acct-cfy-fiscal-year-id', '', array('id' => 'acct-cfy-fiscal-year-id')) !!}
						</div>
						<div class="form-group mg-hm clearfix">
							{!! Form::label('acct-cfy-voucher-type', Lang::get('decima-accounting::journal-management.voucherType'), array('class' => 'control-label')) !!}
							{!! Form::autocomplete('acct-cfy-voucher-type', $voucherTypes, array('class' => 'form-control', 'data-mg-required' => ''), 'acct-cfy-voucher-type', 'acct-cfy-voucher-type-id', null, 'fa-files-o') !!}
							{!! Form::hidden('acct-cfy-voucher-type-id', null, array('id'  =>  'acct-cfy-voucher-type-id')) !!}
			  		</div>
						<div class="form-group mg-hm">
							{!! Form::label('acct-cfy-remark', Lang::get('decima-accounting::journal-management.remark'), array('class' => 'control-label')) !!}
							{!! Form::textareacustom('acct-cfy-remark', 2, 500, array('class' => 'form-control', 'data-mg-required' => ''), Lang::get('decima-accounting::close-fiscal-year.expensesTitle')) !!}
			  		</div>
						<div class="form-group mg-hm clearfix">
							{!! Form::label('acct-cfy-cost-center', Lang::get('decima-accounting::journal-management.costCenter'), array('class' => 'control-label')) !!}
							{!! Form::autocomplete('acct-cfy-cost-center', $costCenters['organizationCostCenters'], array('class' => 'form-control', 'data-mg-required' => '', 'defaultvalue' => $costCenters['defaultCostCenter']['label']), 'acct-cfy-cost-center', 'acct-cfy-cost-center-id', $costCenters['defaultCostCenter']['label'], 'fa-sitemap') !!}
							{!! Form::hidden('acct-cfy-cost-center-id', $costCenters['defaultCostCenter']['id'], array('id' => 'acct-cfy-cost-center-id', 'defaultvalue' => $costCenters['defaultCostCenter']['id'])) !!}
							<p class="help-block">{{ Lang::get('decima-accounting::close-fiscal-year.costCenterHelperText') }}</p>
						</div>
						<div class="form-group mg-hm clearfix">
							{!! Form::label('acct-cfy-account', Lang::get('decima-accounting::close-fiscal-year.account'), array('class' => 'control-label')) !!}
							{!! Form::autocomplete('acct-cfy-account', $accounts, array('class' => 'form-control', 'data-mg-required' => ''), 'acct-cfy-account', 'acct-cfy-account-id', null, 'fa-book') !!}
							{!! Form::hidden('acct-cfy-account-id', null, array('id' => 'acct-cfy-account-id')) !!}
							<p class="help-block">{{ Lang::get('decima-accounting::close-fiscal-year.accountHelperText') }}</p>
						</div>
						 {!! Form::close() !!}
					 </div>
				 </div>
			</div>
			<div class="modal-footer" style="text-align:center;">
				<button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('toolbar.close') }}</button>
				<button id="acct-cfy-btn-modal-expenses" type="button" class="btn btn-primary">{{ Lang::get('decima-accounting::close-fiscal-year.generate') }}</button>
			</div>
    </div>
  </div>
</div>
<div id='acct-cfy-modal-income' class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
			<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{{ Lang::get('decima-accounting::close-fiscal-year.incomeTitle') }}</h4>
      </div>
			<div class="modal-body clearfix">
				<div class="row">
					<div class="col-md-12">
						{!! Form::open(array('id' => 'acct-cfy-modal-income-form', 'url' => URL::to('accounting/transactions/close-fiscal-year'), 'role' => 'form', 'onsubmit' => 'return false;')) !!}
						<div class="form-group mg-hm">
							{!! Form::label('acct-cfy2-date', Lang::get('decima-accounting::journal-management.date'), array('class' => 'control-label')) !!}
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
								{!! Form::text('acct-cfy2-date', '' , array('id' => 'acct-cfy2-date', 'class' => 'form-control', 'disabled' => '')) !!}
							</div>
						</div>
						<div class="form-group mg-hm">
							{!! Form::label('acct-cfy2-period-label', Lang::get('decima-accounting::period-management.period'), array('class' => 'control-label')) !!}
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								{!! Form::text('acct-cfy2-period-label', '' , array('id' => 'acct-cfy2-period-label', 'class' => 'form-control', 'disabled' => '')) !!}
							</div>
							{!! Form::hidden('acct-cfy2-period-id', '', array('id' => 'acct-cfy2-period-id')) !!}
							{!! Form::hidden('acct-cfy2-fiscal-year-id', '', array('id' => 'acct-cfy2-fiscal-year-id')) !!}
						</div>
						<div class="form-group mg-hm clearfix">
							{!! Form::label('acct-cfy2-voucher-type', Lang::get('decima-accounting::journal-management.voucherType'), array('class' => 'control-label')) !!}
							{!! Form::autocomplete('acct-cfy2-voucher-type', $voucherTypes, array('class' => 'form-control', 'data-mg-required' => ''), 'acct-cfy2-voucher-type', 'acct-cfy2-voucher-type-id', null, 'fa-files-o') !!}
							{!! Form::hidden('acct-cfy2-voucher-type-id', null, array('id'  =>  'acct-cfy2-voucher-type-id')) !!}
			  		</div>
						<div class="form-group mg-hm">
							{!! Form::label('acct-cfy2-remark', Lang::get('decima-accounting::journal-management.remark'), array('class' => 'control-label')) !!}
							{!! Form::textareacustom('acct-cfy2-remark', 2, 500, array('class' => 'form-control', 'data-mg-required' => ''), Lang::get('decima-accounting::close-fiscal-year.incomeTitle')) !!}
			  		</div>
						<div class="form-group mg-hm clearfix">
							{!! Form::label('acct-cfy2-cost-center', Lang::get('decima-accounting::journal-management.costCenter'), array('class' => 'control-label')) !!}
							{!! Form::autocomplete('acct-cfy2-cost-center', $costCenters['organizationCostCenters'], array('class' => 'form-control', 'data-mg-required' => '', 'defaultvalue' => $costCenters['defaultCostCenter']['label']), 'acct-cfy2-cost-center', 'acct-cfy2-cost-center-id', $costCenters['defaultCostCenter']['label'], 'fa-sitemap') !!}
							{!! Form::hidden('acct-cfy2-cost-center-id', $costCenters['defaultCostCenter']['id'], array('id' => 'acct-cfy2-cost-center-id', 'defaultvalue' => $costCenters['defaultCostCenter']['id'])) !!}
							<p class="help-block">{{ Lang::get('decima-accounting::close-fiscal-year.costCenterHelperText') }}</p>
						</div>
						<div class="form-group mg-hm clearfix">
							{!! Form::label('acct-cfy2-account', Lang::get('decima-accounting::close-fiscal-year.account'), array('class' => 'control-label')) !!}
							{!! Form::autocomplete('acct-cfy2-account', $accounts, array('class' => 'form-control', 'data-mg-required' => ''), 'acct-cfy2-account', 'acct-cfy2-account-id', null, 'fa-book') !!}
							{!! Form::hidden('acct-cfy2-account-id', null, array('id' => 'acct-cfy2-account-id')) !!}
							<p class="help-block">{{ Lang::get('decima-accounting::close-fiscal-year.accountHelperText') }}</p>
						</div>
						 {!! Form::close() !!}
					 </div>
				 </div>
			</div>
			<div class="modal-footer" style="text-align:center;">
				<button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('toolbar.close') }}</button>
				<button id="acct-cfy-btn-modal-income" type="button" class="btn btn-primary">{{ Lang::get('decima-accounting::close-fiscal-year.generate') }}</button>
			</div>
    </div>
  </div>
</div>
<div id='acct-cfy-modal-closing-balance' class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
			<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{{ Lang::get('decima-accounting::close-fiscal-year.balanceTitle') }}</h4>
      </div>
			<div class="modal-body clearfix">
				<div class="row">
					{!! Form::open(array('id' => 'acct-cfy-modal-closing-balance-form', 'url' => URL::to('accounting/transactions/close-fiscal-year'), 'role' => 'form', 'onsubmit' => 'return false;')) !!}
						<div class="col-md-6">
							<legend id="acct-cfy-form-title">{{ Lang::get('decima-accounting::close-fiscal-year.closingBalanceTitle') }}</legend>
							<div class="form-group mg-hm">
								{!! Form::label('acct-cfy3-date-closing', Lang::get('decima-accounting::journal-management.date'), array('class' => 'control-label')) !!}
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
									{!! Form::text('acct-cfy3-date-closing', '' , array('id' => 'acct-cfy3-date-closing', 'class' => 'form-control', 'disabled' => '')) !!}
								</div>
							</div>
							<div class="form-group mg-hm">
								{!! Form::label('acct-cfy3-period-label-closing', Lang::get('decima-accounting::period-management.period'), array('class' => 'control-label')) !!}
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									{!! Form::text('acct-cfy3-period-label-closing', '' , array('id' => 'acct-cfy3-period-label-closing', 'class' => 'form-control', 'disabled' => '')) !!}
								</div>
								{!! Form::hidden('acct-cfy3-period-id-closing', '', array('id' => 'acct-cfy3-period-id-closing')) !!}
								{!! Form::hidden('acct-cfy3-fiscal-year-id', '', array('id' => 'acct-cfy3-fiscal-year-id')) !!}
							</div>
							<div class="form-group mg-hm clearfix">
								{!! Form::label('acct-cfy3-voucher-type-closing', Lang::get('decima-accounting::journal-management.voucherType'), array('class' => 'control-label')) !!}
								{!! Form::autocomplete('acct-cfy3-voucher-type-closing', $voucherTypes, array('class' => 'form-control', 'data-mg-required' => ''), 'acct-cfy3-voucher-type-closing', 'acct-cfy3-voucher-type-id-closing', null, 'fa-files-o') !!}
								{!! Form::hidden('acct-cfy3-voucher-type-id-closing', null, array('id'  =>  'acct-cfy3-voucher-type-id-closing')) !!}
				  		</div>
							<div class="form-group mg-hm">
								{!! Form::label('acct-cfy3-remark-closing', Lang::get('decima-accounting::journal-management.remark'), array('class' => 'control-label')) !!}
								{!! Form::textareacustom('acct-cfy3-remark-closing', 2, 500, array('class' => 'form-control', 'data-mg-required' => ''), Lang::get('decima-accounting::close-fiscal-year.closingBalanceTitle')) !!}
				  		</div>
						 </div>
						<div class="col-md-6">
							<legend id="acct-cfy-form-title">{{ Lang::get('decima-accounting::close-fiscal-year.openingBalanceTitle') }}</legend>
							<div class="form-group mg-hm">
								{!! Form::label('acct-cfy3-date-opening', Lang::get('decima-accounting::journal-management.date'), array('class' => 'control-label')) !!}
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
									{!! Form::text('acct-cfy3-date-opening', '' , array('id' => 'acct-cfy3-date-opening', 'class' => 'form-control', 'disabled' => '')) !!}
								</div>
							</div>
							<div class="form-group mg-hm">
								{!! Form::label('acct-cfy3-period-label-opening', Lang::get('decima-accounting::period-management.period'), array('class' => 'control-label')) !!}
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									{!! Form::text('acct-cfy3-period-label-opening', '' , array('id' => 'acct-cfy3-period-label-opening', 'class' => 'form-control', 'disabled' => '')) !!}
								</div>
								{!! Form::hidden('acct-cfy3-period-id-opening', '', array('id' => 'acct-cfy3-period-id-opening')) !!}
								{!! Form::hidden('acct-cfy3-fiscal-year-id-opening', '', array('id' => 'acct-cfy3-fiscal-year-id-opening')) !!}
							</div>
							<div class="form-group mg-hm clearfix">
								{!! Form::label('acct-cfy3-voucher-type-opening', Lang::get('decima-accounting::journal-management.voucherType'), array('class' => 'control-label')) !!}
								{!! Form::autocomplete('acct-cfy3-voucher-type-opening', $voucherTypes, array('class' => 'form-control', 'data-mg-required' => ''), 'acct-cfy3-voucher-type-opening', 'acct-cfy3-voucher-type-id-opening', null, 'fa-files-o') !!}
								{!! Form::hidden('acct-cfy3-voucher-type-id-opening', null, array('id'  =>  'acct-cfy3-voucher-type-id-opening')) !!}
				  		</div>
							<div class="form-group mg-hm">
								{!! Form::label('acct-cfy3-remark-opening', Lang::get('decima-accounting::journal-management.remark'), array('class' => 'control-label')) !!}
								{!! Form::textareacustom('acct-cfy3-remark-opening', 2, 500, array('class' => 'form-control', 'data-mg-required' => ''), Lang::get('decima-accounting::close-fiscal-year.openingBalanceTitle')) !!}
				  		</div>
						 </div>
					 {!! Form::close() !!}
				 </div>
			</div>
			<div class="modal-footer" style="text-align:center;">
				<button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('toolbar.close') }}</button>
				<button id="acct-cfy-btn-modal-closing-balance" type="button" class="btn btn-primary">{{ Lang::get('decima-accounting::close-fiscal-year.generate') }}</button>
			</div>
    </div>
  </div>
</div>
@parent
@stop
