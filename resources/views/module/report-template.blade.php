@extends('layouts.base')

@section('container')
{{-- Html::style('assets/kwaai/css/decima-accounting::journal-management.css') --}}
{{-- Html::script('assets/kwaai/js/decima-accounting::journal-management.js') --}}
{{-- var_dump($filterDates) --}}
<style>

</style>

<script type='text/javascript'>

	// var moduleAppTablenames = {!! json_encode(array()) !!};

	function moduleAppLoadCompleteEvent()
	{
		// $(this).jqGrid('footerData','set', {'document_type_name': 'Total:', 'account_name': 'Total:', 'document_amount': $(this).jqGrid('getCol', 'document_amount', false, 'sum'), 'debit': $(this).jqGrid('getCol', 'debit', false, 'sum'), 'credit': $(this).jqGrid('getCol', 'credit', false, 'sum')});
	}

	$(document).ready(function()
	{
		$('#module-app-filters-form').jqMgVal('addFormFieldsValidations');

		$('.module-app-btn-tooltip').tooltip();

		$('#module-app-btn-filter').click(function()
		{
			var filters = [];

			if($("#module-app-numbers-from").isEmpty() && $("#module-app-numbers-to").isEmpty() && ($('#module-app-document-date-from').val() == '__/__/____' || $('#module-app-document-date-from').isEmpty()) && ($('#module-app-document-date-from').val() == '__/__/____' || $('#module-app-document-date-from').isEmpty()))
			{
				if(($('#module-app-date-from').val() == '__/__/____' && $('#module-app-date-to').val() == '__/__/____') || ($('#module-app-date-from').isEmpty() && $('#module-app-date-to').isEmpty()))
				{
					$('#module-app-date-from').val($('#module-app-date-from').attr('data-default-value-from'));
					$('#module-app-date-to').val($('#module-app-date-to').attr('data-default-value-to'));
				}
			}

			if(!$('#module-app-filters-form').jqMgVal('isFormValid'))
			{
				return;
			}

			$('#module-app-filters-form').jqMgVal('clearContextualClasses');

			if($("#module-app-date-from").val() != '__/__/____' && !$("#module-app-date-from").isEmpty())
			{
				filters.push({'field':'jv.date', 'op':'ge', 'data': $.datepicker.formatDate("yy-mm-dd", $("#module-app-date-from").datepicker("getDate"))});
			}

			if($("#module-app-date-to").val() != '__/__/____' && !$("#module-app-date-to").isEmpty())
			{
				filters.push({'field':'jv.date', 'op':'le', 'data': $.datepicker.formatDate("yy-mm-dd", $("#module-app-date-to").datepicker("getDate"))});
			}

			if($("#module-app-document-date-from").val() != '__/__/____' && !$("#module-app-document-date-from").isEmpty())
			{
				filters.push({'field':'jv.document_date', 'op':'ge', 'data': $.datepicker.formatDate("yy-mm-dd", $("#module-app-document-date-from").datepicker("getDate"))});
			}

			if($("#module-app-document-date-to").val() != '__/__/____' && !$("#module-app-document-date-to").isEmpty())
			{
				filters.push({'field':'jv.document_date', 'op':'le', 'data': $.datepicker.formatDate("yy-mm-dd", $("#module-app-document-date-to").datepicker("getDate"))});
			}

			if(!$("#module-app-numbers-from").isEmpty())
			{
				filters.push({'field':'jv.document_number', 'op':'ge', 'data': $("#module-app-numbers-from").val()});
			}

			if(!$("#module-app-numbers-to").isEmpty())
			{
				filters.push({'field':'jv.document_number', 'op':'le', 'data': $("#module-app-numbers-to").val()});
			}

			if(!$('#module-app-tablenames').isEmpty())
			{
				filters.push({'field':'je.account_id', 'op':'in', 'data': $('#module-app-tablenames').val()});
			}

			if(!$('#module-app-employee-label').isEmpty())
			{
				filters.push({'field':'jv.employee_id', 'op':'eq', 'data': $('#module-app-employee-id').val()});
			}

			if(!$('#module-app-supplier-label').isEmpty())
			{
				filters.push({'field':'jv.supplier_id', 'op':'eq', 'data': $('#module-app-supplier-id').val()});
			}

			if(!$('#module-app-client-label').isEmpty())
			{
				filters.push({'field':'jv.client_id', 'op':'eq', 'data': $('#module-app-client-id').val()});
			}

			if(!$('#module-app-document-type-label').isEmpty())
			{
				filters.push({'field':'jv.document_type_id', 'op':'eq', 'data': $('#module-app-document-type-id').val()});
			}

			$('#module-app-grid').jqGrid('setGridParam', {'postData':{"filters":"{'groupOp':'AND','rules':" + JSON.stringify(filters) + "}"}}).trigger('reloadGrid');

		});

		$('#module-app-btn-refresh').click(function()
		{
			$('#module-app-grid').trigger('reloadGrid');
			$('.decima-erp-tooltip').tooltip('hide');
		});

		$('#module-app-btn-export-xls').click(function()
		{
		  $('#module-app-gridXlsButton').click();
		});

		$('#module-app-btn-export-csv').click(function()
		{
		  $('#module-app-gridCsvButton').click();
		});

		// $('#module-app-journal-info').click(function()
		// {
		// 	if($(this).is(':checked'))
		// 	{
		// 		$('#module-app-grid').jqGrid('showCol', ['date', 'number', 'remark']).setGridWidth($('#module-app-grid-section').width());
		// 	}
		// 	else
		// 	{
		// 		$('#module-app-grid').jqGrid('hideCol', ['date', 'number', 'remark']).setGridWidth($('#module-app-grid-section').width());
		// 	}
		// });

		setTimeout(function ()
		{
			$('#module-app-tablenames').tokenfield(
			{
				autocomplete:
				{
					source: moduleAppTablenames,
					delay: 100
				},
				showAutocompleteOnFocus: true,
				beautify:false
			});

			$('#module-app-tablenames').on('tokenfield:createtoken', function (event)
			{
				return validateToken(event, moduleAppTablenames);
			});
		}, 500);
	});
</script>
<div class="row">
	<div class="col-lg-12 col-md-12">
		{!! Form::open(array('id' => 'module-app-filters-form', 'url' => URL::to('/'), 'role' => 'form', 'onsubmit' => 'return false;', 'class' => 'form-horizontal')) !!}
			<div id="module-app-filters" class="panel panel-default">
				<div class="panel-heading custom-panel-heading clearfix">
					<h3 class="panel-title custom-panel-title pull-left">
						{{ Lang::get('form.filtersTitle') }}
					</h3>
					{!! Form::button('<i class="fa fa-filter"></i> ' . Lang::get('form.filterButton'), array('id' => 'module-app-btn-filter', 'class' => 'btn btn-warning btn-sm pull-right')) !!}
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-3 col-md-6">
						</div>
						<div class="col-lg-3 col-md-6">
						</div>
						<div class="col-lg-3 col-md-6">
						</div>
						<div class="col-lg-3 col-md-6">
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6 col-md-12">
							<div class="form-group">
								{!! Form::label('module-app-date-from', Lang::get('decima-accounting::tax-control.journalVoucherDateRange'), array('class' => 'col-sm-2 control-label')) !!}
								<div class="col-sm-10 mg-hm">
									{!! Form::daterange('module-app-date-from', 'module-app-date-to' , array('class' => 'form-control', 'data-default-value-from' => $filterDates['userFormattedFrom'], 'data-default-value-to' => $filterDates['userFormattedTo']), $filterDates['userFormattedFrom'], $filterDates['userFormattedTo']) !!}
									<p class="help-block">{{ Lang::get('decima-accounting::journal-management.dateRangeHelperText') }}</p>
								</div>
							</div>
							<div class="form-group">
								{!! Form::label('module-app-numbers-from', Lang::get('decima-accounting::tax-control.numbersRange'), array('class' => 'col-sm-2 control-label')) !!}
								<div class="col-sm-10 mg-hm">
									<div class="input-group">
										<span class="input-group-addon">{{ Lang::get('form.dateRangeFrom') }}</span>
										{!! Form::text('module-app-numbers-from', null , array('id' => 'module-app-numbers-from', 'class' => 'form-control')) !!}
										<span class="input-group-addon">{{ Lang::get('form.dateRangeTo') }}</span>
										{!! Form::text('module-app-numbers-to', null , array('id' => 'module-app-numbers-to', 'class' => 'form-control')) !!}
									</div>
									<p class="help-block">{{ Lang::get('decima-accounting::tax-control.numbersRangeHelperText') }}</p>
								</div>
							</div>
							<div class="form-group no-margin-bottom-min-1200">
								{!! Form::label('module-app-tablenames', Lang::get('decima-accounting::journal-management.tablenamesShortPlural'), array('class' => 'col-sm-3 control-label')) !!}
								<div class="col-sm-9 mg-hm">
									{!! Form::text('module-app-tablenames', null , array('id' => 'module-app-tablenames', 'class' => 'form-control')) !!}
									<p class="help-block">{{ Lang::get('decima-accounting::journal-management.accountFilterHelperText') }}</p>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12">
							<div class="form-group mg-hm">
								{!! Form::label('module-app-employee-label', Lang::get('decima-accounting::journal-management.employeeId'), array('class' => 'control-label col-sm-3')) !!}
								<div class="col-sm-9 mg-hm clearfix">
									{!! Form::autocomplete('module-app-employee-label', array(), array('class' => 'form-control'), 'module-app-employee-label', 'module-app-employee-id', null, 'fa-files-o') !!}
									{!! Form::hidden('module-app-employee-id', null, array('id'  =>  'module-app-employee-id')) !!}
									<p class="help-block">{{ Lang::get('decima-accounting::tax-control.employeeFilterHelperText') }}</p>
								</div>
				  		</div>
							<div class="form-group mg-hm clearfix">
								{!! Form::label('module-app-client-label', Lang::get('decima-accounting::journal-management.clientId'), array('class' => 'control-label col-sm-3')) !!}
								<div class="col-sm-9 mg-hm clearfix">
									{!! Form::autocomplete('module-app-client-label', array(), array('class' => 'form-control'), 'module-app-client-label', 'module-app-client-id', null, 'fa-files-o') !!}
									{!! Form::hidden('module-app-client-id', null, array('id'  =>  'module-app-client-id')) !!}
									<p class="help-block">{{ Lang::get('decima-accounting::tax-control.clientFilterHelperText') }}</p>
								</div>
				  		</div>
							<div class="form-group mg-hm clearfix">
								{!! Form::label('module-app-document-type-label', Lang::get('decima-accounting::tax-control.documentType'), array('class' => 'control-label col-sm-3')) !!}
								<div class="col-sm-9 mg-hm clearfix">
									{!! Form::autocomplete('module-app-document-type-label', array(), array('class' => 'form-control'), 'module-app-document-type-label', 'module-app-document-type-id', null, 'fa-files-o') !!}
									{!! Form::hidden('module-app-document-type-id', null, array('id'  =>  'module-app-document-type-id')) !!}
									<p class="help-block">{{ Lang::get('decima-accounting::tax-control.documentTypeFilterHelperText') }}</p>
								</div>
				  		</div>
						</div>
						<div class="col-lg-7 col-md-12">
							<div class="row">
					  		<div class="col-sm-offset-3 col-sm-9">
									<div class="checkbox">
								    <label>
								      {!! Form::checkbox('module-app-journals-info', 'S', true, array('id' => 'module-app-journal-info')) !!} {{ Lang::get('decima-accounting::tax-control.journalInfo') }}
										</label>
									</div>
								</div>
							</div>
							<div class="row">
					  		<div class="col-md-offset-2 col-md-5">
									<div class="checkbox">
								    <label>
								      {!! Form::checkbox('module-app-journals-info', 'S', true, array('id' => 'module-app-journal-info')) !!} {{ Lang::get('decima-accounting::tax-control.journalInfo') }}
										</label>
									</div>
								</div>
						  	<div class="col-md-5">
									<div class="checkbox">
								    <label>
								      {!! Form::checkbox('module-app-client-info', 'S', false, array('id' => 'module-app-client-info')) !!} {{ Lang::get('decima-accounting::tax-control.clientInfo') }}
										</label>
									</div>
								</div>
								<div class="col-md-offset-2 col-md-5">
									<div class="checkbox">
								    <label>
								      {!! Form::checkbox('module-app-supplier-info', 'S', false, array('id' => 'module-app-supplier-info')) !!} {{ Lang::get('decima-accounting::tax-control.supplierInfo') }}
										</label>
									</div>
								</div>
								<div class="col-md-5">
									<div class="checkbox">
								    <label>
											{!! Form::checkbox('module-app-employee-info', 'S', false, array('id' => 'module-app-employee-info')) !!} {{ Lang::get('decima-accounting::tax-control.employeeInfo') }}
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
		<div id="module-app-btn-toolbar" class="section-header btn-toolbar" role="toolbar">
			<div id="module-app-btn-group-1" class="btn-group btn-group-app-toolbar">
				{!! Form::button('<i class="fa fa-refresh"></i> ' . Lang::get('toolbar.refresh'), array('id' => 'module-app-btn-refresh', 'class' => 'btn btn-default module-app-btn-tooltip decima-erp-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'data-original-title' => Lang::get('toolbar.refreshLongText'))) !!}
				<div class="btn-group">
					{!! Form::button('<i class="fa fa-share-square-o"></i> ' . Lang::get('toolbar.export') . ' <span class="caret"></span>', array('class' => 'btn btn-default dropdown-toggle', 'data-container' => 'body', 'data-toggle' => 'dropdown')) !!}
					<ul class="dropdown-menu">
         		<li><a id='module-app-btn-export-xls' class="fake-link"><i class="fa fa-file-excel-o"></i> xls</a></li>
         		<li><a id='module-app-btn-export-csv' class="fake-link"><i class="fa fa-file-text-o"></i> csv</a></li>
       		</ul>
				</div>
			</div>
		</div>
		<div id='module-app-grid-section' class='app-grid collapse in' data-app-grid-id='module-app-grid'>
			{!!
			GridRender::setGridId('module-app-grid')
				->hideXlsExporter()
  			->hideCsvExporter()
				->setGridOption('height', 'auto')
				->setGridOption('multiselect', false)
				->setGridOption('rowList', array())
				->setGridOption('rowNum', 100000)
	    	->setGridOption('url',URL::to('accounting/reports/tax-control/grid-data'))
	    	->setGridOption('caption', Lang::get('module::app.gridTitle'))
				->setGridOption('filename', Lang::get('module::app.gridTitle'))
	    	->setGridOption('postData', array('_token' => Session::token(), 'filters'=>"{'groupOp':'AND','rules':[{'field':'jv.date','op':'ge','data':'" . $filterDates['databaseFormattedFrom'] ."'}, {'field':'jv.date','op':'le','data':'" . $filterDates['databaseFormattedTo'] ."'}]}"))
				->setGridOption('sortname', 'document_date')
				->setGridOption('sortorder', 'asc')
				->setGridOption('shrinkToFit', false)
				->setGridOption('forceFit', true)
				->setGridOption('footerrow',true)
				//->setGridOption('groupingView', array('groupField' => array('acct_tc_pl_bs_category'), 'groupColumnShow' => array(false), 'groupSummary' => array(false), 'groupOrder' => array('asc')))
				->setGridEvent('loadComplete', 'moduleAppLoadCompleteEvent')
				->addColumn(array('label' => Lang::get('form.name'), 'index' => 'name' ,'name' => 'module_app_name'))
				->addColumn(array('label' => Lang::get('form.status'), 'index' => 'status', 'name' => 'module_app_status', 'formatter' => 'select', 'editoptions' => array('value' => Lang::get('form.statusGridText')), 'align' => 'center', 'hidden' => false))
				->addColumn(array('label' => Lang::get('form.date'), 'index' => 'date', 'name' => 'date', 'width' => 90, 'formatter' => 'date', 'align' => 'center'))
				->addColumn(array('label' => Lang::get('module::app.money'), 'index' => 'money', 'name' => 'money', 'formatter' => 'currency', 'align'=>'right', 'width' => 100, 'hidden' => false, 'formatoptions' => array('prefix' => OrganizationManager::getOrganizationCurrencySymbol() . ' ')))
				->renderGrid();
			!!}
		</div>
	</div>
</div>
@parent
@stop
