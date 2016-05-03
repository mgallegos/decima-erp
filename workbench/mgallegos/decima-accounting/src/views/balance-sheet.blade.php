@extends('layouts.base')

@section('container')
{{-- Html::style('assets/kwaai/css/decima-accounting::journal-management.css') --}}
{{-- Html::script('assets/kwaai/js/decima-accounting::journal-management.js') --}}
<style>

</style>

<script type='text/javascript'>

	function acctBsOnGridComplete()
	{
		$('td[title="1"]', '#acct-bs-balance-sheet-grid').each(function(i) {
        // $(this).parent().css('background', 'red');
        $(this).parent().children().css('font-weight','bold').css('font-style','italic');
    });

		$('td[title=""]', '#acct-bs-balance-sheet-grid').each(function(i) {
			if($(this).attr('aria-describedby') == 'acct-bs-balance-sheet-grid_acct_bs_parent_account_id')
			{
				$(this).parent().children().css('font-size','14px').css('font-style','normal');
			}
    });

		$('td[title="-1"]', '#acct-bs-balance-sheet-grid').each(function(i) {
			if($(this).attr('aria-describedby') == 'acct-bs-balance-sheet-grid_acct_bs_parent_account_id')
			{
				$(this).parent().children().css('font-size','13px').css('font-style','normal');
			}
    });

		$('td[title*="' + $('#organization-currency-symbol').val() + ' -"]', '#acct-bs-balance-sheet-grid').each(function(i) {
        $(this).css('color','red');
    });

		$('.jqgroup', '#acct-bs-balance-sheet-grid').each(function(i) {
			$(this).css('font-size','15px');
    });
	}

	$(document).ready(function()
	{
		$('#acct-bs-journal-voucher-filters-form').jqMgVal('addFormFieldsValidations');

		$('.acct-bs-btn-tooltip').tooltip();

		$('#acct-bs-btn-filter').click(function()
		{
			var filters = [];

			if(!$('#acct-bs-journal-voucher-filters-form').jqMgVal('isFormValid'))
			{
				return;
			}

			$('#acct-bs-journal-voucher-filters-form').jqMgVal('clearContextualClasses');

			if($("#acct-bs-date").isEmpty())
			{
				$("#acct-bs-date").val($("#acct-bs-date").attr('data-default-value'));
			}

			filters.push({'field':'jv.date', 'op':'ge', 'data': $("#acct-bs-date").datepicker("getDate").getFullYear() + '-01-01'});
			filters.push({'field':'jv.date', 'op':'le', 'data': $.datepicker.formatDate("yy-mm-dd", $("#acct-bs-date").datepicker("getDate"))});

			$('#acct-bs-balance-sheet-grid').jqGrid('setGridParam', {'postData':{"filters":"{'groupOp':'AND','rules':" + JSON.stringify(filters) + "}"}}).trigger('reloadGrid');
		});

		$('#acct-bs-btn-refresh').click(function()
		{
			$('#acct-bs-balance-sheet-grid').trigger('reloadGrid');
		});

		$('#acct-bs-btn-export-xls').click(function()
		{
			  $('#acct-bs-balance-sheet-gridXlsButton').click();
		});

		$('#acct-bs-btn-export-csv').click(function()
		{
			  $('#acct-bs-balance-sheet-gridCsvButton').click();
		});
	});
</script>
<div class="row">
	<div class="col-lg-12 col-md-12">
		{!! Form::open(array('id' => 'acct-bs-journal-voucher-filters-form', 'url' => URL::to('/'), 'role' => 'form', 'onsubmit' => 'return false;', 'class' => 'form-horizontal')) !!}
			<div id="acct-bs-journal-voucher-filters" class="panel panel-default">
				<div class="panel-heading custom-panel-heading clearfix">
					<h3 class="panel-title custom-panel-title pull-left">
						{{ Lang::get('form.filtersTitle') }}
					</h3>
					{!! Form::button('<i class="fa fa-filter"></i> ' . Lang::get('form.filterButton'), array('id' => 'acct-bs-btn-filter', 'class' => 'btn btn-warning btn-sm pull-right')) !!}
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-6 col-md-6">
							<div class="form-group no-margin-bottom-min-1200">
								{!! Form::label('acct-bs-date', Lang::get('decima-accounting::balance-sheet.date'), array('class' => 'col-sm-4 control-label')) !!}
								<div class="col-sm-8 mg-hm">
									{!! Form::date('acct-bs-date', array('class' => 'form-control', 'data-default-value' => $currentDate), $currentDate) !!}
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-6">

						</div>
					</div>
				</div>
			</div>
		{!! Form::close() !!}
		<div id="acct-bs-btn-toolbar" class="section-header btn-toolbar" role="toolbar">
			<div id="acct-bs-btn-group-1" class="btn-group btn-group-app-toolbar">
				{!! Form::button('<i class="fa fa-refresh"></i> ' . Lang::get('toolbar.refresh'), array('id' => 'acct-bs-btn-refresh', 'class' => 'btn btn-default acct-bs-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'data-original-title' => Lang::get('toolbar.refreshLongText'))) !!}
				<div class="btn-group">
					{!! Form::button('<i class="fa fa-share-square-o"></i> ' . Lang::get('toolbar.export') . ' <span class="caret"></span>', array('class' => 'btn btn-default dropdown-toggle', 'data-container' => 'body', 'data-toggle' => 'dropdown')) !!}
					<ul class="dropdown-menu">
         		<li><a id='acct-bs-btn-export-xls' class="fake-link"><i class="fa fa-file-excel-o"></i> xls</a></li>
         		<li><a id='acct-bs-btn-export-csv' class="fake-link"><i class="fa fa-file-text-o"></i> csv</a></li>
       		</ul>
				</div>
			</div>
		</div>
		<div id='acct-bs-grid-section' class='app-grid collapse in' data-app-grid-id='acct-bs-balance-sheet-grid'>
			{!!
			GridRender::setGridId("acct-bs-balance-sheet-grid")
				->hideXlsExporter()
  			->hideCsvExporter()
				->setGridOption('height', 'auto')
				->setGridOption('multiselect', false)
				->setGridOption('rowList', array(40, 50, 60, 70, 80, 90, 100, 250, 500, 750, 1000, 2000))
				->setGridOption('rowNum', 1000)
	    	->setGridOption('url',URL::to('accounting/reports/balance-sheet/balance-sheet-grid-data'))
	    	->setGridOption('caption', Lang::get('decima-accounting::menu.balanceSheet'))
	    	->setGridOption('filename', Lang::get('decima-accounting::balance-sheet.filename'))
				->setGridOption('postData', array('_token' => Session::token(), 'filters'=>"{'groupOp':'AND','rules':[{'field':'jv.date','op':'ge','data':'" . $currentYear ."-01-01'}, {'field':'jv.date','op':'le','data':'" . $currentDateBd ."'}]}"))
				->setGridOption('grouping', true)
				->setGridOption('sortname', 'acct_bs_account_key')
				//->setGridOption('sortorder', 'desc')
				->setGridOption('groupingView', array('groupField' => array('acct_bs_pl_bs_category'), 'groupColumnShow' => array(false), 'groupSummary' => array(false), 'groupOrder' => array('asc')))
				//->setGridOption('groupingView', array('groupField' => array('acct_bs_pl_bs_category', 'acct_bs_account_type_name'), 'groupColumnShow' => array(false, false), 'groupSummary' => array(true, true), 'groupOrder' => array('asc')))
	    	->setGridEvent('gridComplete', 'acctBsOnGridComplete')
				//->setFilterToolbarEvent('beforeClear','acctJmJournalsBeforeClearEvent')
				->addColumn(array('label' => Lang::get('decima-accounting::balance-sheet.bsCategory'), 'index' => 'acct_bs_pl_bs_category'))
				->addColumn(array('index' => 'c.is_group', 'name' => 'acct_bs_is_group', 'hidden' => true))
				->addColumn(array('index' => 'c.balance_type', 'name' => 'acct_bs_balance_type', 'hidden' => true))
				->addColumn(array('index' => 'c.id', 'name' => 'acct_bs_account_id', 'hidden' => true))
				->addColumn(array('index' => 'c.parent_account_id', 'name' => 'acct_bs_parent_account_id', 'hidden' => true))
				->addColumn(array('label' => Lang::get('decima-accounting::journal-management.accountCod'), 'name' => 'acct_bs_account_key', 'width' => 80))
				->addColumn(array('label' => Lang::get('decima-accounting::journal-management.account'), 'name' => 'acct_bs_account_name'))
				//->addColumn(array('label' => Lang::get('decima-accounting::journal-management.debit'), 'index' => 'je.debit', 'name' => 'acct_bs_debit', 'formatter' => 'currency', 'align'=>'right', 'width' => 115, 'hidden' => true, 'formatoptions' => array('prefix' => OrganizationManager::getOrganizationCurrencySymbol() . ' ')))
				//->addColumn(array('label' => Lang::get('decima-accounting::journal-management.credit'), 'index' => 'je.credit', 'name' => 'acct_bs_credit', 'formatter' => 'currency', 'align'=>'right', 'width' => 115, 'hidden' => true, 'formatoptions' => array('prefix' => OrganizationManager::getOrganizationCurrencySymbol() . ' ')))
				->addColumn(array('label' => Lang::get('decima-accounting::balance-sheet.balance'), 'name' => 'acct_bs_balance', 'formatter' => 'currency', 'align'=>'right', 'width' => 115, 'formatoptions' => array('prefix' => OrganizationManager::getOrganizationCurrencySymbol() . ' ')))
	    	->renderGrid();
			!!}
		</div>
	</div>
</div>
@parent
@stop
