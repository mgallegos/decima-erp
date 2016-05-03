@extends('layouts.base')

@section('container')
{{-- Html::style('assets/kwaai/css/decima-accounting::journal-management.css') --}}
{{-- Html::script('assets/kwaai/js/decima-accounting::journal-management.js') --}}
<style>

</style>

<script type='text/javascript'>

	function acctPlOnGridComplete()
	{
		$('td[title="1"]', '#acct-pl-profit-loss-grid').each(function(i) {
        // $(this).parent().css('background', 'red');
        $(this).parent().children().css('font-weight','bold').css('font-style','italic');
    });

		$('td[title=""]', '#acct-pl-profit-loss-grid').each(function(i) {
			if($(this).attr('aria-describedby') == 'acct-pl-profit-loss-grid_acct_pl_parent_account_id')
			{
				$(this).parent().children().css('font-size','14px').css('font-style','normal');
			}
    });

		$('td[title="-1"]', '#acct-pl-profit-loss-grid').each(function(i) {
			if($(this).attr('aria-describedby') == 'acct-pl-profit-loss-grid_acct_pl_parent_account_id')
			{
				$(this).parent().children().css('font-size','13px').css('font-style','normal');
			}
    });

		$('td[title*="' + $('#organization-currency-symbol').val() + ' -"]', '#acct-pl-profit-loss-grid').each(function(i) {
        $(this).css('color','red');
    });

		$('.jqgroup', '#acct-pl-profit-loss-grid').each(function(i) {
			$(this).css('font-size','15px');
    });
	}

	$(document).ready(function()
	{
		$('#acct-pl-journal-voucher-filters-form').jqMgVal('addFormFieldsValidations');

		$('.acct-pl-btn-tooltip').tooltip();

		$('#acct-pl-btn-filter').click(function()
		{
			var filters = [];

			if(($("#acct-pl-date-from").val() == '__/__/____' && $("#acct-pl-date-to").val() == '__/__/____') || ($("#acct-pl-date-from").isEmpty() && $("#acct-pl-date-to").isEmpty()))
			{
				$('#acct-pl-date-from').val($('#acct-pl-date-from').attr('data-default-value-from'));
				$('#acct-pl-date-to').val($('#acct-pl-date-to').attr('data-default-value-to'));
			}

			if(!$('#acct-pl-journal-voucher-filters-form').jqMgVal('isFormValid'))
			{
				return;
			}

			$('#acct-pl-journal-voucher-filters-form').jqMgVal('clearContextualClasses');

			if($("#acct-pl-date-from").val() != '__/__/____' && !$("#acct-pl-date-from").isEmpty())
			{
				filters.push({'field':'jv.date', 'op':'ge', 'data': $.datepicker.formatDate( "yy-mm-dd", $("#acct-pl-date-from").datepicker("getDate") )});
			}

			if($("#acct-pl-date-to").val() != '__/__/____' && !$("#acct-pl-date-to").isEmpty())
			{
				filters.push({'field':'jv.date', 'op':'le', 'data': $.datepicker.formatDate( "yy-mm-dd", $("#acct-pl-date-to").datepicker("getDate") )});
			}

			if(filters.length > 0)
			{
				$('#acct-pl-profit-loss-grid').jqGrid('setGridParam', {'postData':{"filters":"{'groupOp':'AND','rules':" + JSON.stringify(filters) + "}"}}).trigger('reloadGrid');
			}
		});

		$('#acct-pl-btn-refresh').click(function()
		{
			$('#acct-pl-profit-loss-grid').trigger('reloadGrid');
		});

		$('#acct-pl-btn-export-xls').click(function()
		{
			  $('#acct-pl-profit-loss-gridXlsButton').click();
		});

		$('#acct-pl-btn-export-csv').click(function()
		{
			  $('#acct-pl-profit-loss-gridCsvButton').click();
		});
	});
</script>
<div class="row">
	<div class="col-lg-12 col-md-12">
		{!! Form::open(array('id' => 'acct-pl-journal-voucher-filters-form', 'url' => URL::to('/'), 'role' => 'form', 'onsubmit' => 'return false;', 'class' => 'form-horizontal')) !!}
			<div id="acct-pl-journal-voucher-filters" class="panel panel-default">
				<div class="panel-heading custom-panel-heading clearfix">
					<h3 class="panel-title custom-panel-title pull-left">
						{{ Lang::get('form.filtersTitle') }}
					</h3>
					{!! Form::button('<i class="fa fa-filter"></i> ' . Lang::get('form.filterButton'), array('id' => 'acct-pl-btn-filter', 'class' => 'btn btn-warning btn-sm pull-right')) !!}
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-7 col-md-12">
							<div class="form-group no-margin-bottom-min-1200">
								{!! Form::label('acct-pl-date-from', Lang::get('decima-accounting::journal-management.dateRange'), array('class' => 'col-sm-3 control-label')) !!}
								<div class="col-sm-9 mg-hm">
									{!! Form::daterange('acct-pl-date-from', 'acct-pl-date-to' , array('class' => 'form-control', 'data-mg-required' => '', 'data-default-value-from' => $filterDates['userFormattedFrom'], 'data-default-value-to' => $filterDates['userFormattedTo']), $filterDates['userFormattedFrom'], $filterDates['userFormattedTo']) !!}
									<p class="help-block">{{ Lang::get('decima-accounting::journal-management.dateRangeHelperText') }}</p>
								</div>
							</div>
						</div>
						<div class="col-lg-5 col-md-12">

						</div>
					</div>
				</div>
			</div>
		{!! Form::close() !!}
		<div id="acct-pl-btn-toolbar" class="section-header btn-toolbar" role="toolbar">
			<div id="acct-pl-btn-group-1" class="btn-group btn-group-app-toolbar">
				{!! Form::button('<i class="fa fa-refresh"></i> ' . Lang::get('toolbar.refresh'), array('id' => 'acct-pl-btn-refresh', 'class' => 'btn btn-default acct-pl-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'data-original-title' => Lang::get('toolbar.refreshLongText'))) !!}
				<div class="btn-group">
					{!! Form::button('<i class="fa fa-share-square-o"></i> ' . Lang::get('toolbar.export') . ' <span class="caret"></span>', array('class' => 'btn btn-default dropdown-toggle', 'data-container' => 'body', 'data-toggle' => 'dropdown')) !!}
					<ul class="dropdown-menu">
         		<li><a id='acct-pl-btn-export-xls' class="fake-link"><i class="fa fa-file-excel-o"></i> xls</a></li>
         		<li><a id='acct-pl-btn-export-csv' class="fake-link"><i class="fa fa-file-text-o"></i> csv</a></li>
       		</ul>
				</div>
			</div>
		</div>
		<div id='acct-pl-grid-section' class='app-grid collapse in' data-app-grid-id='acct-pl-profit-loss-grid'>
			{!!
			GridRender::setGridId("acct-pl-profit-loss-grid")
				->hideXlsExporter()
  			->hideCsvExporter()
				->setGridOption('height', 'auto')
				->setGridOption('multiselect', false)
				->setGridOption('rowList', array(40, 50, 60, 70, 80, 90, 100, 250, 500, 750, 1000, 2000))
				->setGridOption('rowNum', 1000)
	    	->setGridOption('url',URL::to('accounting/reports/profit-and-loss/profit-and-loss-grid-data'))
	    	->setGridOption('caption', Lang::get('decima-accounting::menu.profitAndLoss'))
	    	->setGridOption('filename', Lang::get('decima-accounting::menu.profitAndLoss'))
	    	->setGridOption('postData', array('_token' => Session::token(), 'filters'=>"{'groupOp':'AND','rules':[{'field':'jv.date','op':'ge','data':'" . $filterDates['databaseFormattedFrom'] ."'}, {'field':'jv.date','op':'le','data':'" . $filterDates['databaseFormattedTo'] ."'}]}"))
				->setGridOption('grouping', true)
				->setGridOption('sortname', 'acct_pl_account_key')
				//->setGridOption('sortorder', 'desc')
				->setGridOption('groupingView', array('groupField' => array('acct_pl_pl_bs_category'), 'groupColumnShow' => array(false), 'groupSummary' => array(false), 'groupOrder' => array('desc')))
				//->setGridOption('groupingView', array('groupField' => array('acct_pl_pl_bs_category', 'acct_pl_account_type_name'), 'groupColumnShow' => array(false, false), 'groupSummary' => array(true, true), 'groupOrder' => array('asc')))
	    	->setGridEvent('gridComplete', 'acctPlOnGridComplete')
				//->setFilterToolbarEvent('beforeClear','acctJmJournalsBeforeClearEvent')
				->addColumn(array('label' => Lang::get('decima-accounting::balance-sheet.bsCategory'), 'index' => 'acct_pl_pl_bs_category'))
				//->addColumn(array('label' => Lang::get('decima-accounting::balance-sheet.accountName'), 'index' => 'acct_pl_account_type_name'))
				->addColumn(array('index' => 'c.is_group', 'name' => 'acct_pl_is_group', 'hidden' => true))
				->addColumn(array('index' => 'c.balance_type', 'name' => 'acct_pl_balance_type', 'hidden' => true))
				->addColumn(array('index' => 'c.id', 'name' => 'acct_pl_account_id', 'hidden' => true))
				->addColumn(array('index' => 'c.parent_account_id', 'name' => 'acct_pl_parent_account_id', 'hidden' => true))
				->addColumn(array('label' => Lang::get('decima-accounting::journal-management.accountCod'), 'name' => 'acct_pl_account_key', 'width' => 80))
				->addColumn(array('label' => Lang::get('decima-accounting::journal-management.account'), 'name' => 'acct_pl_account_name'))
				//->addColumn(array('label' => Lang::get('decima-accounting::journal-management.debit'), 'index' => 'je.debit', 'name' => 'acct_pl_debit', 'formatter' => 'currency', 'align'=>'right', 'width' => 115, 'hidden' => true, 'formatoptions' => array('prefix' => OrganizationManager::getOrganizationCurrencySymbol() . ' ')))
				//->addColumn(array('label' => Lang::get('decima-accounting::journal-management.credit'), 'index' => 'je.credit', 'name' => 'acct_pl_credit', 'formatter' => 'currency', 'align'=>'right', 'width' => 115, 'hidden' => true, 'formatoptions' => array('prefix' => OrganizationManager::getOrganizationCurrencySymbol() . ' ')))
				->addColumn(array('label' => Lang::get('decima-accounting::balance-sheet.balance'), 'name' => 'acct_pl_balance', 'formatter' => 'currency', 'align'=>'right', 'width' => 115, 'formatoptions' => array('prefix' => OrganizationManager::getOrganizationCurrencySymbol() . ' ')))
	    	->renderGrid();
			!!}
		</div>
	</div>
</div>
@parent
@stop
