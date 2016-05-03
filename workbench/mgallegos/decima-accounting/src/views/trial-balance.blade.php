@extends('layouts.base')

@section('container')
{{-- Html::style('assets/kwaai/css/decima-accounting::journal-management.css') --}}
{{-- Html::script('assets/kwaai/js/decima-accounting::journal-management.js') --}}
{{-- var_dump($filterDates) --}}
<style>

</style>

<script type='text/javascript'>

	function acctTbOnGridComplete()
	{
		$('td[title="1"]', '#acct-tb-trial-balance-grid').each(function(i) {
        // $(this).parent().css('background', 'red');
        $(this).parent().children().css('font-weight','bold').css('font-style','italic');
    });

		$('td[title=""]', '#acct-tb-trial-balance-grid').each(function(i) {
			if($(this).attr('aria-describedby') == 'acct-tb-trial-balance-grid_acct_tb_parent_account_id')
			{
				$(this).parent().children().css('font-size','14px').css('font-style','normal');
			}
    });

		$('td[title="-1"]', '#acct-tb-trial-balance-grid').each(function(i) {
			if($(this).attr('aria-describedby') == 'acct-tb-trial-balance-grid_acct_tb_parent_account_id')
			{
				$(this).parent().children().css('font-size','13px').css('font-style','normal');
			}
    });

		$('td[title*="' + $('#organization-currency-symbol').val() + ' -"]', '#acct-tb-trial-balance-grid').each(function(i) {
        $(this).css('color','red');
    });

		$('.jqgroup', '#acct-tb-trial-balance-grid').each(function(i) {
			$(this).css('font-size','15px');
    });
	}

	$(document).ready(function()
	{
		$('#acct-tb-journal-voucher-filters-form').jqMgVal('addFormFieldsValidations');

		$('.acct-tb-btn-tooltip').tooltip();

		$('#acct-tb-btn-filter').click(function()
		{
			var filters = [];

			if(($("#acct-tb-date-from").val() == '__/__/____' && $("#acct-tb-date-to").val() == '__/__/____') || ($("#acct-tb-date-from").isEmpty() && $("#acct-tb-date-to").isEmpty()))
			{
				$('#acct-tb-date-from').val($('#acct-tb-date-from').attr('data-default-value-from'));
				$('#acct-tb-date-to').val($('#acct-tb-date-to').attr('data-default-value-to'));
			}

			if(!$('#acct-tb-journal-voucher-filters-form').jqMgVal('isFormValid'))
			{
				return;
			}

			$('#acct-tb-journal-voucher-filters-form').jqMgVal('clearContextualClasses');

			if($("#acct-tb-date-from").val() != '__/__/____' && !$("#acct-tb-date-from").isEmpty())
			{
				filters.push({'field':'jv.date', 'op':'ge', 'data': $.datepicker.formatDate( "yy-mm-dd", $("#acct-tb-date-from").datepicker("getDate") )});
			}

			if($("#acct-tb-date-to").val() != '__/__/____' && !$("#acct-tb-date-to").isEmpty())
			{
				filters.push({'field':'jv.date', 'op':'le', 'data': $.datepicker.formatDate( "yy-mm-dd", $("#acct-tb-date-to").datepicker("getDate") )});
			}

			if(filters.length > 0)
			{
				$('#acct-tb-trial-balance-grid').jqGrid('setGridParam', {'postData':{"filters":"{'groupOp':'AND','rules':" + JSON.stringify(filters) + "}"}}).trigger('reloadGrid');
			}

		});

		$('#acct-tb-btn-refresh').click(function()
		{
			$('#acct-tb-trial-balance-grid').trigger('reloadGrid');
		});

		$('#acct-tb-btn-export-xls').click(function()
		{
			  $('#acct-tb-trial-balance-gridXlsButton').click();
		});

		$('#acct-tb-btn-export-csv').click(function()
		{
			  $('#acct-tb-trial-balance-gridCsvButton').click();
		});
	});
</script>
<div class="row">
	<div class="col-lg-12 col-md-12">
		{!! Form::open(array('id' => 'acct-tb-journal-voucher-filters-form', 'url' => URL::to('/'), 'role' => 'form', 'onsubmit' => 'return false;', 'class' => 'form-horizontal')) !!}
			<div id="acct-tb-journal-voucher-filters" class="panel panel-default">
				<div class="panel-heading custom-panel-heading clearfix">
					<h3 class="panel-title custom-panel-title pull-left">
						{{ Lang::get('form.filtersTitle') }}
					</h3>
					{!! Form::button('<i class="fa fa-filter"></i> ' . Lang::get('form.filterButton'), array('id' => 'acct-tb-btn-filter', 'class' => 'btn btn-warning btn-sm pull-right')) !!}
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-7 col-md-12">
							<div class="form-group no-margin-bottom-min-1200">
								{!! Form::label('acct-tb-date-from', Lang::get('decima-accounting::journal-management.dateRange'), array('class' => 'col-sm-3 control-label')) !!}
								<div class="col-sm-9 mg-hm">
									{!! Form::daterange('acct-tb-date-from', 'acct-tb-date-to' , array('class' => 'form-control', 'data-mg-required' => '', 'data-default-value-from' => $filterDates['userFormattedFrom'], 'data-default-value-to' => $filterDates['userFormattedTo']), $filterDates['userFormattedFrom'], $filterDates['userFormattedTo']) !!}
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
		<div id="acct-tb-btn-toolbar" class="section-header btn-toolbar" role="toolbar">
			<div id="acct-tb-btn-group-1" class="btn-group btn-group-app-toolbar">
				{!! Form::button('<i class="fa fa-refresh"></i> ' . Lang::get('toolbar.refresh'), array('id' => 'acct-tb-btn-refresh', 'class' => 'btn btn-default acct-tb-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'data-original-title' => Lang::get('toolbar.refreshLongText'))) !!}
				<div class="btn-group">
					{!! Form::button('<i class="fa fa-share-square-o"></i> ' . Lang::get('toolbar.export') . ' <span class="caret"></span>', array('class' => 'btn btn-default dropdown-toggle', 'data-container' => 'body', 'data-toggle' => 'dropdown')) !!}
					<ul class="dropdown-menu">
         		<li><a id='acct-tb-btn-export-xls' class="fake-link"><i class="fa fa-file-excel-o"></i> xls</a></li>
         		<li><a id='acct-tb-btn-export-csv' class="fake-link"><i class="fa fa-file-text-o"></i> csv</a></li>
       		</ul>
				</div>
			</div>
		</div>
		<div id='acct-tb-grid-section' class='app-grid collapse in' data-app-grid-id='acct-tb-trial-balance-grid'>
			{!!
			GridRender::setGridId("acct-tb-trial-balance-grid")
				->hideXlsExporter()
  			->hideCsvExporter()
				->setGridOption('height', 'auto')
				->setGridOption('multiselect', false)
				->setGridOption('rowList', array(40, 50, 60, 70, 80, 90, 100, 250, 500, 750, 1000, 2000))
				->setGridOption('rowNum', 1000)
	    	->setGridOption('url',URL::to('accounting/reports/trial-balance/trial-balance-grid-data'))
	    	->setGridOption('caption', Lang::get('decima-accounting::menu.trialBalance'))
				->setGridOption('filename', Lang::get('decima-accounting::trial-balance.filename'))
	    	->setGridOption('postData', array('_token' => Session::token(), 'filters'=>"{'groupOp':'AND','rules':[{'field':'jv.date','op':'ge','data':'" . $filterDates['databaseFormattedFrom'] ."'}, {'field':'jv.date','op':'le','data':'" . $filterDates['databaseFormattedTo'] ."'}]}"))
				//->setGridOption('grouping', true)
				->setGridOption('sortname', 'acct_tb_account_key')
				//->setGridOption('sortorder', 'desc')
				//->setGridOption('groupingView', array('groupField' => array('acct_tb_pl_bs_category'), 'groupColumnShow' => array(false), 'groupSummary' => array(false), 'groupOrder' => array('asc')))
	    	->setGridEvent('gridComplete', 'acctTbOnGridComplete')
				//->setFilterToolbarEvent('beforeClear','acctJmJournalsBeforeClearEvent')
				->addColumn(array('index' => 'c.is_group', 'name' => 'acct_tb_is_group', 'hidden' => true))
				->addColumn(array('index' => 'c.balance_type', 'name' => 'acct_tb_balance_type', 'hidden' => true))
				->addColumn(array('index' => 'c.id', 'name' => 'acct_tb_account_id', 'hidden' => true))
				->addColumn(array('index' => 'c.parent_account_id', 'name' => 'acct_tb_parent_account_id', 'hidden' => true))
				->addColumn(array('label' => 'total_debit', 'name' => 'acct_tb_total_debit', 'hidden' => true, 'width' => 70))
				->addColumn(array('label' => 'total_credit','name' => 'acct_tb_total_credit', 'hidden' => true, 'width' => 70))
				->addColumn(array('label' => Lang::get('decima-accounting::journal-management.accountCod'), 'name' => 'acct_tb_account_key', 'width' => 80))
				->addColumn(array('label' => Lang::get('decima-accounting::journal-management.account'), 'name' => 'acct_tb_account_name'))
				->addColumn(array('label' => Lang::get('decima-accounting::general-ledger.openingBalance'), 'index' => 'acct_tb_opening_balance', 'name' => 'acct_tb_opening_balance', 'formatter' => 'currency', 'align'=>'right', 'width' => 90, 'formatoptions' => array('prefix' => OrganizationManager::getOrganizationCurrencySymbol() . ' ')))
				->addColumn(array('label' => Lang::get('decima-accounting::journal-management.debit'), 'name' => 'acct_tb_debit', 'formatter' => 'currency', 'align'=>'right', 'width' => 90, 'hidden' => false, 'formatoptions' => array('prefix' => OrganizationManager::getOrganizationCurrencySymbol() . ' ')))
				->addColumn(array('label' => Lang::get('decima-accounting::journal-management.credit'), 'name' => 'acct_tb_credit', 'formatter' => 'currency', 'align'=>'right', 'width' => 90, 'hidden' => false, 'formatoptions' => array('prefix' => OrganizationManager::getOrganizationCurrencySymbol() . ' ')))
				->addColumn(array('label' => Lang::get('decima-accounting::general-ledger.closingBalance'), 'index' => 'acct_tb_closing_balance', 'name' => 'acct_tb_closing_balance', 'formatter' => 'currency', 'align'=>'right', 'width' => 90, 'formatoptions' => array('prefix' => OrganizationManager::getOrganizationCurrencySymbol() . ' ')))
	    	->renderGrid();
			!!}
		</div>
	</div>
</div>
@parent
@stop
