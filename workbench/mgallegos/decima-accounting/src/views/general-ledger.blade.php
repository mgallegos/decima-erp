@extends('layouts.base')

@section('container')
{{-- Html::style('assets/kwaai/css/decima-accounting::journal-management.css') --}}
{{-- Html::script('assets/kwaai/js/decima-accounting::journal-management.js') --}}
{{-- var_dump($filterDates) --}}
<style>

</style>

<script type='text/javascript'>

	function acctGlOnGridComplete()
	{
		$('td[title="1"]', '#acct-gl-general-ledger-grid').each(function(i) {
        // $(this).parent().css('background', 'red');
				if($(this).attr('aria-describedby') == 'acct-gl-general-ledger-grid_acct_gl_is_group')
				{
        	$(this).parent().children().css('font-weight','bold').css('font-style','italic');
				}
    });

		$('td[title=""]', '#acct-gl-general-ledger-grid').each(function(i) {
			if($(this).attr('aria-describedby') == 'acct-gl-general-ledger-grid_acct_gl_parent_account_id')
			{
				$(this).parent().children().css('font-size','14px').css('font-style','normal');
			}
    });

		$('td[title="-1"]', '#acct-gl-general-ledger-grid').each(function(i) {
			if($(this).attr('aria-describedby') == 'acct-gl-general-ledger-grid_acct_gl_parent_account_id')
			{
				$(this).parent().children().css('font-size','13px').css('font-style','normal');
			}
    });

		$('td[title*="' + $('#organization-currency-symbol').val() + ' -"]', '#acct-gl-general-ledger-grid').each(function(i) {
        $(this).css('color','red');
    });

		$('.jqgroup', '#acct-gl-general-ledger-grid').each(function(i) {
			$(this).css('font-size','15px');
    });

		// acctGlUpdateGridColumns();
	}

	function acctGlUpdateGridColumns()
	{
		if($('#acct-gl-ledger-auxiliary').is(':checked'))
		{
			$('#acct-gl-general-ledger-grid').jqGrid('showCol', ['acct_gl_voucher_date', 'acct_gl_voucher_type', 'acct_gl_voucher_number']).setGridWidth($('#acct-gl-grid-section').width());
		}
		else
		{
			$('#acct-gl-general-ledger-grid').jqGrid('hideCol', ['acct_gl_voucher_date', 'acct_gl_voucher_type', 'acct_gl_voucher_number']).setGridWidth($('#acct-gl-grid-section').width());
		}
	}

	$(document).ready(function()
	{
		$('#acct-gl-journal-voucher-filters-form').jqMgVal('addFormFieldsValidations');

		$('.acct-gl-btn-tooltip').tooltip();

		$('#acct-gl-btn-filter').click(function()
		{
			var filters = [];

			if(($("#acct-gl-date-from").val() == '__/__/____' && $("#acct-gl-date-to").val() == '__/__/____') || ($("#acct-gl-date-from").isEmpty() && $("#acct-gl-date-to").isEmpty()))
			{
				$('#acct-gl-date-from').val($('#acct-gl-date-from').attr('data-default-value-from'));
				$('#acct-gl-date-to').val($('#acct-gl-date-to').attr('data-default-value-to'));
			}

			if(!$('#acct-gl-journal-voucher-filters-form').jqMgVal('isFormValid'))
			{
				return;
			}

			$('#acct-gl-journal-voucher-filters-form').jqMgVal('clearContextualClasses');

			if(!$('#acct-gl-account').isEmpty())
			{
				filters.push({'field':'je.account_id', 'op':'in', 'data': $('#acct-gl-account-id').val()});
			}

			filters.push({'field':'jv.date', 'op':'ge', 'data': $.datepicker.formatDate( "yy-mm-dd", $("#acct-gl-date-from").datepicker("getDate") )});
			filters.push({'field':'jv.date', 'op':'le', 'data': $.datepicker.formatDate( "yy-mm-dd", $("#acct-gl-date-to").datepicker("getDate") )});
			filters.push({'field':'auxiliary', 'op':'eq', 'data': $('#acct-gl-ledger-auxiliary').is(':checked')?'1':'0'});

			acctGlUpdateGridColumns();

			$('#acct-gl-general-ledger-grid').jqGrid('setGridParam', {'postData':{"filters":"{'groupOp':'AND','rules':" + JSON.stringify(filters) + "}"}}).trigger('reloadGrid');

			acctGlUpdateGridColumns();
		});

		$('#acct-gl-btn-refresh').click(function()
		{
			$('#acct-gl-general-ledger-grid').trigger('reloadGrid');
		});

		$('#acct-gl-btn-export-xls').click(function()
		{
			  $('#acct-gl-general-ledger-gridXlsButton').click();
		});

		$('#acct-gl-btn-export-csv').click(function()
		{
			  $('#acct-gl-general-ledger-gridCsvButton').click();
		});
	});
</script>
<div class="row">
	<div class="col-lg-12 col-md-12">
		{!! Form::open(array('id' => 'acct-gl-journal-voucher-filters-form', 'url' => URL::to('/'), 'role' => 'form', 'onsubmit' => 'return false;', 'class' => 'form-horizontal')) !!}
			<div id="acct-gl-journal-voucher-filters" class="panel panel-default">
				<div class="panel-heading custom-panel-heading clearfix">
					<h3 class="panel-title custom-panel-title pull-left">
						{{ Lang::get('form.filtersTitle') }}
					</h3>
					{!! Form::button('<i class="fa fa-filter"></i> ' . Lang::get('form.filterButton'), array('id' => 'acct-gl-btn-filter', 'class' => 'btn btn-warning btn-sm pull-right')) !!}
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-7 col-md-12">
							<div class="form-group no-margin-bottom-min-1200">
								{!! Form::label('acct-gl-date-from', Lang::get('decima-accounting::journal-management.dateRange'), array('class' => 'col-sm-3 control-label')) !!}
								<div class="col-sm-9 mg-hm">
									{!! Form::daterange('acct-gl-date-from', 'acct-gl-date-to' , array('class' => 'form-control', 'data-mg-required' => '', 'data-default-value-from' => $filterDates['userFormattedFrom'], 'data-default-value-to' => $filterDates['userFormattedTo']), $filterDates['userFormattedFrom'], $filterDates['userFormattedTo']) !!}
									<p class="help-block">{{ Lang::get('decima-accounting::journal-management.dateRangeHelperText') }}</p>
								</div>
							</div>
						</div>
						<div class="col-lg-5 col-md-12">
							<div class="form-group no-margin-bottom-min-1200">
								{!! Form::label('acct-gl-account', Lang::get('decima-accounting::journal-management.accountsShortSingular'), array('class' => 'col-sm-3 control-label')) !!}
								<div class="col-sm-9 mg-hm">
									{!! Form::autocomplete('acct-gl-account', $accounts, array('class' => 'form-control'), 'acct-gl-account', 'acct-gl-account-id', null, 'fa-book') !!}
									{!! Form::hidden('acct-gl-account-id', null, array('id' => 'acct-gl-account-id')) !!}
									<p class="help-block">{{ Lang::get('decima-accounting::general-ledger.accountHelperText') }}</p>
								</div>
							</div>
						</div>
						<div class="col-lg-7 col-md-12">
							<div class="form-group no-margin-bottom">
							  	<div class="col-md-offset-3 col-md-9">
										<div class="checkbox">
									    <label>
									      {!! Form::checkbox('acct-gl-ledger-auxiliary', 'S', true, array('id' => 'acct-gl-ledger-auxiliary')) !!} {{ Lang::get('decima-accounting::general-ledger.ledgerAuxiliary') }}
											</label>
										</div>
								</div>
							</div>
						</div>
						<div class="col-lg-5 col-md-12">

						</div>
					</div>
				</div>
			</div>
		{!! Form::close() !!}
		<div id="acct-gl-btn-toolbar" class="section-header btn-toolbar" role="toolbar">
			<div id="acct-gl-btn-group-1" class="btn-group btn-group-app-toolbar">
				{!! Form::button('<i class="fa fa-refresh"></i> ' . Lang::get('toolbar.refresh'), array('id' => 'acct-gl-btn-refresh', 'class' => 'btn btn-default acct-gl-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'data-original-title' => Lang::get('toolbar.refreshLongText'))) !!}
				<div class="btn-group">
					{!! Form::button('<i class="fa fa-share-square-o"></i> ' . Lang::get('toolbar.export') . ' <span class="caret"></span>', array('class' => 'btn btn-default dropdown-toggle', 'data-container' => 'body', 'data-toggle' => 'dropdown')) !!}
					<ul class="dropdown-menu">
         		<li><a id='acct-gl-btn-export-xls' class="fake-link"><i class="fa fa-file-excel-o"></i> xls</a></li>
         		<li><a id='acct-gl-btn-export-csv' class="fake-link"><i class="fa fa-file-text-o"></i> csv</a></li>
       		</ul>
				</div>
			</div>
		</div>
		<div id='acct-gl-grid-section' class='app-grid collapse in' data-app-grid-id='acct-gl-general-ledger-grid'>
			{!!
			GridRender::setGridId("acct-gl-general-ledger-grid")
				->hideXlsExporter()
  			->hideCsvExporter()
				->setGridOption('height', 'auto')
				->setGridOption('multiselect', false)
				->setGridOption('rowList', array(40, 50, 60, 70, 80, 90, 100, 250, 500, 750, 1000, 2000))
				->setGridOption('rowNum', 1000)
	    	->setGridOption('url',URL::to('accounting/reports/general-ledger/general-ledger-grid-data'))
	    	->setGridOption('caption', Lang::get('decima-accounting::menu.generalLedger'))
				->setGridOption('filename', Lang::get('decima-accounting::menu.generalLedger'))
	    	->setGridOption('postData', array('_token' => Session::token(), 'filters'=>"{'groupOp':'AND','rules':[{'field':'jv.date','op':'ge','data':'" . $filterDates['databaseFormattedFrom'] ."'}, {'field':'jv.date','op':'le','data':'" . $filterDates['databaseFormattedTo'] ."'}, {'field':'auxiliary','op':'eq','data':'1'}]}"))
				//->setGridOption('grouping', true)
				->setGridOption('sortname', 'acct_gl_account_key')
				//->setGridOption('sortorder', 'desc')
				//->setGridOption('groupingView', array('groupField' => array('acct_gl_pl_bs_category'), 'groupColumnShow' => array(false), 'groupSummary' => array(false), 'groupOrder' => array('asc')))
	    	->setGridEvent('gridComplete', 'acctGlOnGridComplete')
				//->setFilterToolbarEvent('beforeClear','acctJmJournalsBeforeClearEvent')
				->addColumn(array('index' => 'c.is_group', 'name' => 'acct_gl_is_group', 'hidden' => true))
				->addColumn(array('index' => 'c.balance_type', 'name' => 'acct_gl_balance_type', 'hidden' => true))
				->addColumn(array('index' => 'c.id', 'name' => 'acct_gl_account_id', 'hidden' => true))
				->addColumn(array('index' => 'c.parent_account_id', 'name' => 'acct_gl_parent_account_id', 'hidden' => true))
				->addColumn(array('label' => 'total_debit', 'name' => 'acct_gl_total_debit', 'hidden' => true, 'width' => 70))
				->addColumn(array('label' => 'total_credit','name' => 'acct_gl_total_credit', 'hidden' => true, 'width' => 70))
				->addColumn(array('label' => Lang::get('decima-accounting::journal-management.date'), 'name' => 'acct_gl_voucher_date', 'width' => 40, 'align' => 'center'))
				->addColumn(array('label' => Lang::get('decima-accounting::journal-management.accountsShortSingular'), 'name' => 'acct_gl_account_key', 'width' => 60))
				->addColumn(array('label' => Lang::get('decima-accounting::journal-management.type'), 'name' => 'acct_gl_voucher_type', 'width' => 50))
				->addColumn(array('label' => Lang::get('decima-accounting::journal-management.number'), 'name' => 'acct_gl_voucher_number', 'width' => 45, 'align' => 'center'))
				->addColumn(array('label' => Lang::get('decima-accounting::journal-management.remark'), 'name' => 'acct_gl_account_name'))
				->addColumn(array('label' => Lang::get('decima-accounting::general-ledger.openingBalance'), 'name' => 'acct_gl_opening_balance', 'formatter' => 'currency', 'align'=>'right', 'width' => 75, 'formatoptions' => array('prefix' => OrganizationManager::getOrganizationCurrencySymbol() . ' ')))
				->addColumn(array('label' => Lang::get('decima-accounting::journal-management.debit'), 'name' => 'acct_gl_debit', 'formatter' => 'currency', 'align'=>'right', 'width' => 75, 'hidden' => false, 'formatoptions' => array('prefix' => OrganizationManager::getOrganizationCurrencySymbol() . ' ')))
				->addColumn(array('label' => Lang::get('decima-accounting::journal-management.credit'), 'name' => 'acct_gl_credit', 'formatter' => 'currency', 'align'=>'right', 'width' => 75, 'hidden' => false, 'formatoptions' => array('prefix' => OrganizationManager::getOrganizationCurrencySymbol() . ' ')))
				->addColumn(array('label' => Lang::get('decima-accounting::general-ledger.closingBalance'), 'name' => 'acct_gl_closing_balance', 'formatter' => 'currency', 'align'=>'right', 'width' => 75, 'formatoptions' => array('prefix' => OrganizationManager::getOrganizationCurrencySymbol() . ' ')))
	    	->renderGrid();
			!!}
		</div>
	</div>
</div>
@parent
@stop
