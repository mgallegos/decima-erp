@extends('layouts.base')

@section('container')
{!! Form::hidden('acct-pm-open-action', $openPeriodAction, array('id' => 'acct-pm-open-action', 'data-content' => Lang::get('decima-accounting::period-management.openHelpText'))) !!}
{!! Form::hidden('acct-pm-close-action', $closePeriodAction, array('id' => 'acct-pm-close-action', 'data-content' => Lang::get('decima-accounting::period-management.closeHelpText'))) !!}
{!! Form::hidden('acct-pm-messages', null, array('id' => 'acct-pm-messages', 'data-is-closed-message' => Lang::get('decima-accounting::period-management.isClosedMessage'), 'data-is-opened-message' => Lang::get('decima-accounting::period-management.isOpenedMessage'))) !!}
{!! Form::button('', array('id' => 'acct-pm-btn-open-helper', 'class' => 'hidden')) !!}
{!! Form::button('', array('id' => 'acct-pm-btn-close-helper', 'class' => 'hidden')) !!}
<style></style>

<script type='text/javascript'>

	//For grids with multiselect disabled
	function acctPmOnSelectRowEvent()
	{
		var rowData = $('#acct-pm-grid').getRowData($('#acct-pm-grid').jqGrid('getGridParam', 'selrow'));

		getAppJournals('acct-pm-', 'firstPage', rowData['acct_pm_id']);

		$('#acct-pm-btn-group-2').enableButtonGroup();

		if(rowData['acct_pm_is_closed'] == '0')
		{
			$('#acct-pm-btn-open').attr('disabled','disabled');
		}
		else
		{
			$('#acct-pm-btn-close').attr('disabled','disabled');
		}
	}

	$(document).ready(function()
	{
		$('.acct-pm-btn-tooltip').tooltip();

		$('#acct-pm-btn-refresh').click(function()
		{
			$('.acct-pm-btn-tooltip').tooltip('hide');
			$('#acct-pm-grid').trigger('reloadGrid');
			cleanJournals('acct-pm-');
			$('#acct-pm-btn-toolbar').disabledButtonGroup();
			$('#acct-pm-btn-group-1').enableButtonGroup();
		});

		$('#acct-pm-btn-export-xls').click(function()
		{
				$('#acct-pm-gridXlsButton').click();
		});

		$('#acct-pm-btn-export-csv').click(function()
		{
				$('#acct-pm-gridCsvButton').click();
		});

		$('#acct-pm-btn-open').click(function()
		{
			var rowData, rowId;

			rowId = $('#acct-pm-grid').jqGrid('getGridParam', 'selrow');

			if(rowId == null)
			{
				$('#acct-pm-btn-toolbar').showAlertAfterElement('alert-info alert-custom', lang.invalidSelection, 5000);
				return;
			}

			rowData = $('#acct-pm-grid').getRowData(rowId);

			if(rowData['acct_pm_is_closed'] == '0')
			{
				$('#acct-pm-btn-toolbar').showAlertAfterElement('alert-info alert-custom', $('#acct-pm-messages').attr('data-is-opened-message'), 5000);
				return;
			}

			$('.acct-pm-btn-tooltip').tooltip('hide');

			$.ajax(
			{
				type: 'POST',
				data: JSON.stringify({'_token':$('#app-token').val(), 'id':rowData['acct_pm_id']}),
				dataType : 'json',
				url:  $('#acct-pm-form').attr('action') + '/open',
				error: function (jqXHR, textStatus, errorThrown)
				{
					handleServerExceptions(jqXHR, 'acct-pm-btn-toolbar', false);
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
						$('#acct-pm-btn-refresh').click();
						$('#acct-pm-btn-toolbar').showAlertAfterElement('alert-success alert-custom',json.success, 5000);
					}

					$('#app-loader').addClass('hidden');
					enableAll();
				}
			});
		});

		$('#acct-pm-btn-close').click(function()
		{
			var rowData, rowId;

			rowId = $('#acct-pm-grid').jqGrid('getGridParam', 'selrow');

			if(rowId == null)
			{
				$('#acct-pm-btn-toolbar').showAlertAfterElement('alert-info alert-custom', lang.invalidSelection, 5000);
				return;
			}

			rowData = $('#acct-pm-grid').getRowData(rowId);

			if(rowData['acct_pm_is_closed'] == '1')
			{
				$('#acct-pm-btn-toolbar').showAlertAfterElement('alert-info alert-custom', $('#acct-pm-messages').attr('data-is-closed-message'), 5000);
				return;
			}

			$('.acct-pm-btn-tooltip').tooltip('hide');

			$.ajax(
			{
				type: 'POST',
				data: JSON.stringify({'_token':$('#app-token').val(), 'id':rowData['acct_pm_id']}),
				dataType : 'json',
				url:  $('#acct-pm-form').attr('action') + '/close',
				error: function (jqXHR, textStatus, errorThrown)
				{
					handleServerExceptions(jqXHR, 'acct-pm-btn-toolbar', false);
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
						$('#acct-pm-btn-refresh').click();
						$('#acct-pm-btn-toolbar').showAlertAfterElement('alert-success alert-custom', json.success, 5000);
					}

					if(!json.success && json.info)
					{
						$('#acct-pm-btn-toolbar').showAlertAfterElement('alert-info alert-custom', json.info, 5000);
					}

					$('#app-loader').addClass('hidden');
					enableAll();
				}
			});
		});

		$('#acct-pm-btn-generate-period').click(function()
		{
			var rowData;

			if($(this).hasAttr('disabled'))
			{
				return;
			}

			$('.acct-pm-btn-tooltip').tooltip('hide');

			$.ajax(
			{
				type: 'POST',
				data: JSON.stringify({'_token':$('#app-token').val()}),
				dataType : 'json',
				url:  $('#acct-pm-modal-form').attr('action') + '/next-fiscal-year',
				error: function (jqXHR, textStatus, errorThrown)
				{
					handleServerExceptions(jqXHR, 'acct-pm-btn-toolbar', false);
				},
				beforeSend:function()
				{
					$('#app-loader').removeClass('hidden');
					disabledAll();
				},
				success:function(json)
				{
					$('#acct-pm-year').val(json.fiscalYear);
					$('#acct-pm-modal').modal('show');
					$('#app-loader').addClass('hidden');
					enableAll();
				}
			});

		});

		$('#acct-pm-btn-modal').click(function()
		{
			if(!$('#acct-pm-modal-form').jqMgVal('isFormValid'))
			{
				return;
			}

			$.ajax(
			{
				type: 'POST',
				data: JSON.stringify($('#acct-pm-modal-form').formToObject('acct-pm-')),
				dataType : 'json',
				url:  $('#acct-pm-form').attr('action') + '/generate',
				error: function (jqXHR, textStatus, errorThrown)
				{
					handleServerExceptions(jqXHR, 'acct-pm-btn-toolbar', false);
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
						$('#acct-pm-modal').modal('hide');
						$('#acct-pm-btn-toolbar').showAlertAfterElement('alert-success alert-custom',json.success, 5000);
						$('#acct-pm-btn-refresh').click();
					}

					$('#app-loader').addClass('hidden');
					enableAll();
				}
			});
		});

		$('#acct-pm-btn-open-helper').click(function()
	  {
			showButtonHelper(false, 'acct-pm-btn-group-2', $('#acct-pm-open-action').attr('data-content'));
	  });

		$('#acct-pm-btn-close-helper').click(function()
	  {
			showButtonHelper(false, 'acct-pm-btn-group-2', $('#acct-pm-close-action').attr('data-content'));
	  });

		if(!$('#acct-pm-open-action').isEmpty())
		{
			showButtonHelper(false, 'acct-pm-btn-group-2', $('#acct-pm-open-action').attr('data-content'));
		}

		if(!$('#acct-pm-close-action').isEmpty())
		{
			showButtonHelper(false, 'acct-pm-btn-group-2', $('#acct-pm-close-action').attr('data-content'));
		}
	});
</script>

<div class="row">
	<div class="col-lg-12 col-md-12">
		<div id="acct-pm-btn-toolbar" class="section-header btn-toolbar" role="toolbar">
			<div id="acct-pm-btn-group-1" class="btn-group btn-group-app-toolbar">
				{!! Form::button('<i class="fa fa-refresh"></i> ' . Lang::get('toolbar.refresh'), array('id' => 'acct-pm-btn-refresh', 'class' => 'btn btn-default acct-pm-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'data-original-title' => Lang::get('toolbar.refreshLongText'))) !!}
				<div class="btn-group">
					{!! Form::button('<i class="fa fa-share-square-o"></i> ' . Lang::get('toolbar.export') . ' <span class="caret"></span>', array('class' => 'btn btn-default dropdown-toggle', 'data-container' => 'body', 'data-toggle' => 'dropdown')) !!}
					<ul class="dropdown-menu">
         		<li><a id='acct-pm-btn-export-xls' class="fake-link"><i class="fa fa-file-excel-o"></i> xls</a></li>
         		<li><a id='acct-pm-btn-export-csv' class="fake-link"><i class="fa fa-file-text-o"></i> csv</a></li>
       		</ul>
				</div>
				{!! Form::button('<i class="fa fa-calendar"></i> ' . Lang::get('decima-accounting::period-management.generatePeriod'), array('id' => 'acct-pm-btn-generate-period', 'class' => 'btn btn-default acct-pm-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'data-original-title' => Lang::get('decima-accounting::period-management.generatePeriodLongText'))) !!}
			</div>
			<div id="acct-pm-btn-group-2" class="btn-group btn-group-app-toolbar">
				{!! Form::button('<i class="fa fa-folder-open-o"></i> ' . Lang::get('toolbar.open'), array('id' => 'acct-pm-btn-open', 'class' => 'btn btn-default acct-pm-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'disabled' => '', 'data-original-title' => Lang::get('decima-accounting::period-management.open'))) !!}
				{!! Form::button('<i class="fa fa-folder-o"></i> ' . Lang::get('toolbar.closeAlt'), array('id' => 'acct-pm-btn-close', 'class' => 'btn btn-default acct-pm-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'disabled' => '', 'data-original-title' => Lang::get('decima-accounting::period-management.close'))) !!}
			</div>
		</div>
		<div id='acct-pm-grid-section' class='app-grid collapse in' data-app-grid-id='acct-pm-grid'>
			{!!
			GridRender::setGridId("acct-pm-grid")
				->enablefilterToolbar(false, false)
				->hideXlsExporter()
  			->hideCsvExporter()
				->setGridOption('height', 'auto')
				->setGridOption('multiselect', false)
				->setGridOption('rowList', array(14, 25, 50, 75, 100))
				->setGridOption('rowNum', 14)
	    	->setGridOption('url',URL::to('accounting/setup/period-management/grid-data'))
	    	->setGridOption('caption', Lang::get('decima-accounting::period-management.gridTitle', array('user' => AuthManager::getLoggedUserFirstname())))
	    	->setGridOption('postData',array('_token' => Session::token()))
				->setGridEvent('onSelectRow', 'acctPmOnSelectRowEvent')
	    	->addColumn(array('index' => 'p.id', 'name' => 'acct_pm_id', 'hidden' => true))
	    	->addColumn(array('label' => Lang::get('decima-accounting::balance-sheet.fiscalYear'), 'index' => 'f.year' , 'name' => 'acct_pm_year', 'align'=>'center'))
	    	->addColumn(array('label' => Lang::get('decima-accounting::period-management.period'), 'index' => 'p.month' , 'name' => 'acct_pm_month', 'align'=>'center', 'formatter' => 'select', 'editoptions' => array('value' => Lang::get('decima-accounting::period-management.periodGridText'))))
	    	->addColumn(array('label' => Lang::get('decima-accounting::period-management.startDate'), 'index' => 'p.start_date' , 'name' => 'acct_pm_start_date', 'align'=>'center', 'formatter' => 'date'))
	    	->addColumn(array('label' => Lang::get('decima-accounting::period-management.endDate'), 'index' => 'p.end_date' , 'name' => 'acct_pm_end_date', 'align'=>'center', 'formatter' => 'date'))
	    	->addColumn(array('label' => Lang::get('decima-accounting::journal-management.status'), 'index' => 'p.is_closed' ,'name' => 'acct_pm_is_closed', 'align'=>'center', 'formatter' => 'select', 'editoptions' => array('value' => Lang::get('decima-accounting::period-management.isClosedGridText'))))
	    	->renderGrid();
			!!}
		</div>
	</div>
</div>
<div id='acct-pm-journals-section' class="row collapse in section-block">
	{!! Form::journals('acct-pm-', $appInfo['id']) !!}
</div>
<div id='acct-pm-form-section' class="row collapse">
	<div class="col-lg-12 col-md-12">
		<div class="form-container">
			{!! Form::open(array('id' => 'acct-pm-form', 'url' => URL::to('accounting/setup/period-management'), 'role'  =>  'form', 'onsubmit' => 'return false;')) !!}
			{!! Form::close() !!}
		</div>
	</div>
</div>
<div id='acct-pm-modal' class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
			<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{{ Lang::get('decima-accounting::period-management.modelTitle') }}</h4>
      </div>
			<div class="modal-body clearfix">
				<div class="row">
					<div class="col-md-12">
						{!! Form::open(array('id' => 'acct-pm-modal-form', 'url' => URL::to('accounting/transactions/close-fiscal-year'), 'role' => 'form', 'onsubmit' => 'return false;')) !!}
						<div class="form-group mg-hm">
							{!! Form::label('acct-pm-year', Lang::get('decima-accounting::balance-sheet.fiscalYear'), array('class' => 'control-label')) !!}
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								{!! Form::text('acct-pm-year', '' , array('id' => 'acct-pm-year', 'class' => 'form-control', 'disabled' => '')) !!}
							</div>
							<p class="help-block">{{ Lang::get('decima-accounting::period-management.fiscalYearHelperText') }}</p>
						</div>
					 	{!! Form::close() !!}
					 </div>
				 </div>
			</div>
			<div class="modal-footer" style="text-align:center;">
				<button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('toolbar.close') }}</button>
				<button id="acct-pm-btn-modal" type="button" class="btn btn-primary">{{ Lang::get('decima-accounting::period-management.generate') }}</button>
			</div>
    </div>
  </div>
</div>
@parent
@stop
