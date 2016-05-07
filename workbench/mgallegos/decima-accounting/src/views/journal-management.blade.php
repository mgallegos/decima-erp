@extends('layouts.base')

@section('container')
{{-- Html::style('assets/kwaai/css/decima-accounting::journal-management.css') --}}
{{-- Html::script('assets/kwaai/js/decima-accounting::journal-management.js') --}}
{!! Form::hidden('acct-jm-new-action', $newAccountingEntryAction, array('id' => 'acct-jm-new-action')) !!}
{!! Form::hidden('acct-jm-edit-action', $editAccountingEntryAction, array('id' => 'acct-jm-edit-action', 'data-content' => Lang::get('decima-accounting::journal-management.editHelpText'))) !!}
{!! Form::hidden('acct-jm-nulify-action', $nulifyAccountingEntryAction, array('id' => 'acct-jm-nulify-action', 'data-content' => Lang::get('decima-accounting::journal-management.nulifyHelpText'))) !!}
{!! Form::button('', array('id' => 'acct-jm-btn-edit-helper', 'class' => 'hidden')) !!}
{!! Form::button('', array('id' => 'acct-jm-btn-nulify-helper', 'class' => 'hidden')) !!}
<style>
	#acct-jm-form-container {
		border-bottom: none !important;
		border-radius: 0 !important;
	}

	#acct-jm-btn-journal-entries-toolbar {
		border-radius: 0 !important;
	}

	#gbox_acct-jm-journals-grid .ui-th-column-header {
		text-align: left;
		padding-left: 20px;
	}
</style>

<script type='text/javascript'>

	var acctJmCreatedBy = {!! json_encode($users) !!};
	var acctJmVoucherTypes = {!! json_encode($voucherTypes) !!};
	var acctJmCostCenters = {!! json_encode($costCenters['organizationCostCenters']) !!};
	var acctJmAccounts = {!! json_encode($accounts) !!};
	var acctJmStatus = [{'value': 'A', 'label': '{{ Lang::get('decima-accounting::journal-management.A') }}'}, {'value': 'B', 'label': '{{ Lang::get('decima-accounting::journal-management.B') }}'}, {'value': 'C', 'label': '{{ Lang::get('decima-accounting::journal-management.C') }}'}];
	var acctJmPeriods = {!! json_encode($periods) !!};
	var acctJmPeriodsFilter = {!! json_encode($periodsFilter) !!};

	function acctJmJournalsOnSelectRowEvent()
	{
		voucherId = $('#acct-jm-journals-grid').getSelectedRowId('voucher_id');

		if($('#acct-jm-journals').attr('data-journalized-id') != voucherId)
		{
				getAppJournals('acct-jm-', 'firstPage', voucherId);
		}

		$('#acct-jm-btn-group-2').enableButtonGroup();
	}

	function acctJmJournalEntriesOnSelectRowEvent()
	{
		var selRowIds = $('#acct-jm-journal-entries-grid').jqGrid('getGridParam', 'selarrrow');

		if(selRowIds.length == 0)
		{
			$('#acct-jm-btn-journal-entries-group-2').disabledButtonGroup();
		}
		else if(selRowIds.length == 1)
		{
			$('#acct-jm-btn-journal-entries-group-2').enableButtonGroup();
		}
		else if(selRowIds.length > 1)
		{
			$('#acct-jm-btn-journal-entries-group-2').disabledButtonGroup();
			$('#acct-jm-btn-journal-entries-delete').removeAttr('disabled');
		}
	}

	function acctJmJournalsOnGridCompleteEvent()
	{
		$(this)[0].toggleToolbar();

		if($('#gbox_acct-jm-journals-grid').find("table[aria-labelledby='gbox_acct-jm-journals-grid']").find('.ui-search-toolbar').is(":visible"))
		{
			$(this)[0].toggleToolbar();
		}
	}

	function acctJmJournalEntriesOnLoadCompleteEvent()
	{
		$(this).jqGrid('footerData','set', {'account_name': 'Total:', 'debit': $(this).jqGrid('getCol', 'debit', false, 'sum'), 'credit': $(this).jqGrid('getCol', 'credit', false, 'sum')});
	}

	// function acctJmJournalEntriesBeforeClearEvent()
	// {
	//   $(this).jqGrid('setGridParam', {'postData':{"filters":"{'groupOp':'AND','rules':[{'field':'je.journal_voucher_id','op':'eq','data':'" + $('#acct-jm-id').val() + "'}]}"}});
	// }
	//
	// function acctJmJournalEntriesAfterClearEvent()
	// {
	//   // $('#gs_acct-jm-journals-gridjournal_voucher_id').val($('#acct-jm-id').val());
	//   $('#gs_journal_voucher_id').val($('#acct-jm-id').val());
	// }

	$(document).ready(function()
	{
		$('#acct-jm-journal-voucher-filters-form').jqMgVal('addFormFieldsValidations');
		$('#acct-jm-journal-voucher-form').jqMgVal('addFormFieldsValidations');
		$('#acct-jm-journal-entries-form').jqMgVal('addFormFieldsValidations');

		$('.acct-jm-btn-tooltip').tooltip();

		$('#acct-jm-grid-section').on('shown.bs.collapse', function ()
		{
			$('#acct-jm-btn-refresh').click();
		});

		$('#acct-jm-admin-section').on('hidden.bs.collapse', function ()
		{
			$('#acct-jm-form-section').collapse('show');
		});

		$('#acct-jm-form-section').on('shown.bs.collapse', function ()
		{
			$('#acct-jm-date').focus();
		});

		$('#acct-jm-form-section').on('hidden.bs.collapse', function ()
		{
			$('#acct-jm-grid-section').collapse('show');

			$('#acct-jm-admin-section').collapse('show');

			$('#acct-jm-journal-voucher-filters').show();
		});

		$('#acct-jm-manual-reference').focusout(function()
		{
			$('#acct-jm-btn-save').focus();
		});

		// $('#acct-jm-credit-calculator').focusout(function()
		// {
		// 	$('#acct-jm-btn-journal-entries-save').focus();
		// });

		$('#acct-jm-btn-clear-filter').click(function()
		{
			$('#acct-jm-journal-voucher-filters-form').find('.tokenfield').find('.close').click()

			$('#acct-jm-journal-voucher-filters-form').jqMgVal('clearForm');

			$('#acct-jm-btn-filter').click();
		});

		$('#acct-jm-btn-filter').click(function()
		{
			var filters = [];

			$(this).removeClass('btn-default').addClass('btn-warning');

			if($('#acct-jm-journal-voucher-filters-body').is(":visible"))
			{
				$('#acct-jm-btn-filter-toggle').click();
			}

			if(!$('#acct-jm-journal-voucher-filters-form').jqMgVal('isFormValid'))
			{
				return;
			}

			$('#acct-jm-journal-voucher-filters-form').jqMgVal('clearContextualClasses');

			if(!$("#acct-jm-periods").isEmpty())
			{
				filters.push({'field':'jv.period_id', 'op':'in', 'data': $("#acct-jm-periods").val()});
			}

			if($("#acct-jm-date-from").val() != '__/__/____' && !$("#acct-jm-date-from").isEmpty())
			{
				filters.push({'field':'jv.date', 'op':'ge', 'data': $.datepicker.formatDate("yy-mm-dd", $("#acct-jm-date-from").datepicker("getDate"))});
			}

			if($("#acct-jm-date-to").val() != '__/__/____' && !$("#acct-jm-date-to").isEmpty())
			{
				filters.push({'field':'jv.date', 'op':'le', 'data': $.datepicker.formatDate("yy-mm-dd", $("#acct-jm-date-to").datepicker("getDate"))});
			}

			if(!$("#acct-jm-references").isEmpty())
			{
				if($("#acct-jm-references").val().split(',').length > 1)
				{
					filters.push({'field':'jv.manual_reference', 'op':'in', 'data': $("#acct-jm-references").val()});
				}
				else
				{
					filters.push({'field':'jv.manual_reference', 'op':'cn', 'data': $("#acct-jm-references").val()});
				}
			}

			if(!$("#acct-jm-voucher-types").isEmpty())
			{
				filters.push({'field':'vt.id', 'op':'in', 'data': $("#acct-jm-voucher-types").val()});
			}

			if(!$("#acct-jm-status-filter").isEmpty())
			{
				filters.push({'field':'jv.status', 'op':'in', 'data': $("#acct-jm-status-filter").val()});
			}

			if(!$("#acct-jm-created-by-users").isEmpty())
			{
				filters.push({'field':'jv.created_by', 'op':'in', 'data': $("#acct-jm-created-by-users").val()});
			}

			if(!$("#acct-jm-numbers-from").isEmpty())
			{
				filters.push({'field':'jv.number', 'op':'ge', 'data': $("#acct-jm-numbers-from").val()});
			}

			if(!$("#acct-jm-numbers-to").isEmpty())
			{
				filters.push({'field':'jv.number', 'op':'le', 'data': $("#acct-jm-numbers-to").val()});
			}

			if(!$("#acct-jm-numbers").isEmpty())
			{
				filters.push({'field':'jv.number', 'op':'in', 'data': $("#acct-jm-numbers").val()});
			}

			if(!$("#acct-jm-remark-filter").isEmpty())
			{
				filters.push({'field':'jv.remark', 'op':'cn', 'data': $("#acct-jm-remark-filter").val()});
			}

			if(!$("#acct-jm-cost-centers").isEmpty())
			{
				filters.push({'field':'cc.id', 'op':'in', 'data': $("#acct-jm-cost-centers").val()});
			}

			if(!$("#acct-jm-accounts").isEmpty())
			{
				filters.push({'field':'c.id', 'op':'in', 'data': $("#acct-jm-accounts").val()});
			}

			if(!$("#acct-jm-debits").isEmpty())
			{
				filters.push({'field':'je.debit', 'op':'in', 'data': $("#acct-jm-debits").val()});
			}

			if(!$("#acct-jm-credits").isEmpty())
			{
				filters.push({'field':'je.credit', 'op':'in', 'data': $("#acct-jm-credits").val()});
			}

			if(filters.length == 0)
			{
				$('#acct-jm-btn-filter').removeClass('btn-warning').addClass('btn-default');
			}

			$('#acct-jm-journals-grid').jqGrid('setGridParam', {'postData':{"filters":"{'groupOp':'AND','rules':" + JSON.stringify(filters) + "}"}}).trigger('reloadGrid');

		});

		$('#acct-jm-btn-new').click(function()
		{
			if($(this).hasAttr('disabled'))
			{
				return;
			}

			$('.acct-jm-btn-tooltip').tooltip('hide');
			$('#acct-jm-btn-toolbar').disabledButtonGroup();
			// $('#acct-jm-btn-group-1').enableButtonGroup();
			$('#acct-jm-btn-new').removeAttr('disabled');
			$('#acct-jm-date').removeAttr('data-last-selected-date');
			$('#acct-jm-btn-group-3').enableButtonGroup();
			$('#acct-jm-btn-journal-entries-toolbar').disabledButtonGroup();
			$('#acct-jm-form-new-title').removeClass('hidden');

			if($('#acct-jm-form-section').is(":visible"))
			{
				$('#acct-jm-form-edit-title').addClass('hidden');
				$('#acct-jm-id').val(-1);
				// $('#acct-jm-journal-entries-grid').jqGrid('clearGridData');
				$('#acct-jm-btn-journal-entries-refresh').click();
				$('#acct-jm-journal-voucher-form').jqMgVal('clearForm');
				$('#acct-jm-journal-entries-form').jqMgVal('clearForm');
			}
			else
			{
				$('#acct-jm-journal-voucher-filters').hide();
				$('#acct-jm-grid-section').collapse('hide');
				$('#acct-jm-admin-section').collapse('hide');
			}

			$('#acct-jm-status-label').val($('#acct-jm-status-label').attr('defaultvalue'));
			$('#acct-jm-status').val($('#acct-jm-status').attr('defaultvalue'));
			$('#acct-jm-cost-center').val($('#acct-jm-cost-center').attr('defaultvalue'));
			$('#acct-jm-cost-center-id').val($('#acct-jm-cost-center-id').attr('defaultvalue'));
			$('#acct-jm-debit').val($('#acct-jm-debit').attr('defaultvalue'));
			$('#acct-jm-credit').val($('#acct-jm-credit').attr('defaultvalue'));
			$('#acct-jm-journal-entries-form-fieldset').attr('disabled','disabled');

			$('#acct-jm-date').focus();
		});

		$('#acct-jm-btn-refresh').click(function()
		{
			$('.acct-jm-btn-tooltip').tooltip('hide');
			$('#acct-jm-journals-grid').trigger('reloadGrid');
			$('#acct-jm-btn-toolbar').disabledButtonGroup();
			$('#acct-jm-btn-group-1').enableButtonGroup();

			cleanJournals('acct-jm-');

			groupingView = $('#acct-jm-journals-grid').jqGrid("getGridParam", "groupingView");

			if(groupingView.groupOrder[0] == 'asc')
			{
				$('#acct-jm-btn-desc').removeAttr('disabled');
			}
			else
			{
				$('#acct-jm-btn-asc').removeAttr('disabled');
			}
		});

		$('#acct-jm-btn-export-xls').click(function()
		{
	  	$('#acct-jm-journals-gridXlsButton').click();
		});

		$('#acct-jm-btn-export-csv').click(function()
		{
	  	$('#acct-jm-journals-gridCsvButton').click();
		});

		$('#acct-jm-btn-edit').click(function()
		{
			var rowData, rowId;

			rowId = $('#acct-jm-journals-grid').jqGrid('getGridParam', 'selrow');

			if(rowId == null)
			{
				$('#acct-jm-btn-toolbar').showAlertAfterElement('alert-info alert-custom', lang.invalidSelection, 5000);
				$('.acct-jm-btn-tooltip').tooltip('hide');
				return;
			}

			$('.acct-jm-btn-tooltip').tooltip('hide');
			$('#acct-jm-btn-toolbar').disabledButtonGroup();
			$('#acct-jm-form-edit-title').removeClass('hidden');
			// $('#acct-jm-date').removeAttr('data-last-selected-date');

			rowData = $('#acct-jm-journals-grid').getRowData(rowId);

			populateFormFields(rowData, 'acct-jm-');

			$.each(acctJmPeriods, function( index, period )
			{
				if($('#acct-jm-period-id').val() == period.id)
				{
					$('#acct-jm-period-label').val(period.month);
				}
			});

			$('#acct-jm-id').val(rowData.voucher_id);
			$('#acct-jm-btn-journal-entries-refresh').click();
		  $('#acct-jm-voucher-number-label').html($('#acct-jm-voucher-number-label').attr('data-default-label').replace(':number', rowData.number));
			$('#acct-jm-voucher-number-label').attr('number', rowData.number);
			// $('#acct-jm-date').focusout();
			$('#acct-jm-date').attr('data-last-selected-date', $('#acct-jm-date').val());
			$('#acct-jm-status-label').val($('#acct-jm-status-label').attr('data-label-' + rowData.status));
			$('#acct-jm-cost-center').val($('#acct-jm-cost-center').attr('defaultvalue'));
			$('#acct-jm-cost-center-id').val($('#acct-jm-cost-center-id').attr('defaultvalue'));
			$('#acct-jm-debit').val($('#acct-jm-debit').attr('defaultvalue'));
			$('#acct-jm-credit').val($('#acct-jm-credit').attr('defaultvalue'));
			$('#acct-jm-journal-entries-form-fieldset').removeAttr('disabled');
			$('#acct-jm-journal-voucher-filters').hide();
			$('#acct-jm-grid-section').collapse('hide');
			$('#acct-jm-admin-section').collapse('hide');
			$('#acct-jm-btn-group-3').enableButtonGroup();
		});

		$('#acct-jm-btn-delete').click(function()
		{
			var rowData, rowId;

			if($(this).hasAttr('disabled'))
			{
				return;
			}

			rowId = $('#acct-jm-journals-grid').jqGrid('getGridParam', 'selrow');

			if(rowId == null)
			{
				$('#acct-jm-btn-toolbar').showAlertAfterElement('alert-info alert-custom', lang.invalidSelection, 5000);
				$('.acct-jm-btn-tooltip').tooltip('hide');
				return;
			}

			$('.acct-jm-btn-tooltip').tooltip('hide');

			rowData = $('#acct-jm-journals-grid').getRowData(rowId);

			$('#acct-jm-voucher-delete-message').html($('#acct-jm-voucher-delete-message').attr('data-default-label').replace(':number', rowData.number));

			$('#acct-jm-modal-delete').modal('show');
		});

		$('#acct-jm-btn-modal-delete').click(function()
		{
			var rowData, token;

			rowData = $('#acct-jm-journals-grid').getRowData($('#acct-jm-journals-grid').jqGrid('getGridParam', 'selrow'));

			token = $('#app-token').val();

			$.ajax(
			{
				type: 'POST',
				data: JSON.stringify({'_token':token, 'id':rowData.voucher_id}),
				dataType : 'json',
				url:  $('#acct-jm-journal-voucher-form').attr('action') + '/delete-journal-voucher',
				error: function (jqXHR, textStatus, errorThrown)
				{
					handleServerExceptions(jqXHR, 'acct-jm-btn-toolbar', false);
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
						$('#acct-jm-btn-refresh').click();
						$('#acct-jm-modal-delete').modal('hide');
						$('.acct-jm-btn-tooltip').tooltip('hide');
						$('#acct-jm-btn-toolbar').showAlertAfterElement('alert-success alert-custom',json.success, 5000);
					}

					$('#app-loader').addClass('hidden');
					enableAll();
				}
			});
		});

		$('#acct-jm-btn-save').click(function()
		{
			var url = $('#acct-jm-journal-voucher-form').attr('action'), action = 'new';

			$('.acct-jm-btn-tooltip').tooltip('hide');
			$('#acct-jm-date').datepicker('hide');

			if(!$('#acct-jm-journal-voucher-form').jqMgVal('isFormValid'))
			{
				return;
			}

			if($('#acct-jm-period-id').isEmpty())
			{
				$('#acct-jm-journal-voucher-form').showServerErrorsByField({'date':$('#acct-jm-date').attr('data-period-validation-message')}, 'acct-jm-');
				return;
			}

			if($('#acct-jm-id').isEmpty())
			{
				url = url + '/store-journal-voucher';
			}
			else
			{
				url = url + '/update-journal-voucher';
				action = 'edit';
			}

			$.ajax(
			{
				type: 'POST',
				data: JSON.stringify($('#acct-jm-journal-voucher-form').formToObject('acct-jm-')),
				dataType : 'json',
				url: url,
				error: function (jqXHR, textStatus, errorThrown)
				{
					handleServerExceptions(jqXHR, 'acct-jm-journal-voucher-form');
				},
				beforeSend:function()
				{
					$('#app-loader').removeClass('hidden');
					disabledAll();
				},
				success:function(json)
				{
					if(json.success && action == 'new')
					{
						$('#acct-jm-id').val(json.id);
						$('#acct-jm-voucher-number-label').html(json.numberLabel);
						$('#acct-jm-voucher-number-label').attr('number', json.number);
						$('#acct-jm-form-new-title').addClass('hidden');
						$('#acct-jm-form-edit-title').removeClass('hidden');
						$('#acct-jm-journal-entries-form-fieldset').removeAttr('disabled');
						$('#acct-jm-btn-journal-entries-group-1').enableButtonGroup();
						$('#acct-jm-btn-journal-entries-group-3').enableButtonGroup();
						$('#acct-jm-journal-voucher-form').jqMgVal('clearContextualClasses');
					}

					if(json.success && action == 'edit')
					{
						$('#acct-jm-btn-toolbar').showAlertAfterElement('alert-success alert-custom',json.success, 5000);
						$('#acct-jm-journal-voucher-form').jqMgVal('clearContextualClasses');
					}

					if(!json.success && json.fieldValidationMessages)
					{
						$('#acct-jm-journal-voucher-form').showServerErrorsByField(json.fieldValidationMessages, 'acct-jm-');
					}

					if(!json.success && json.info)
					{
						$('#acct-jm-journal-voucher-form').showAlertAsFirstChild('alert-info', json.info, 10000);
					}

					$('#app-loader').addClass('hidden');
					enableAll();

					if(json.success && action == 'new')
					{
						if($('#acct-jm-cost-center-id').attr('defaultvalue') == '')
						{
							$('#acct-jm-cost-center').focus();
						}
						else
						{
							$('#acct-jm-account').focus();
						}
					}
				}
			});
		});

		$('#acct-jm-btn-close').click(function()
		{
			var groupingView;

			if($(this).hasAttr('disabled'))
			{
				return;
			}

			$('#acct-jm-date').datepicker('hide');
			$('.acct-jm-btn-tooltip').tooltip('hide');
			$('#acct-jm-btn-group-1').enableButtonGroup();
			$('#acct-jm-btn-group-3').disabledButtonGroup();
			$('#acct-jm-form-new-title').addClass('hidden');
			$('#acct-jm-form-edit-title').addClass('hidden');
			$('#acct-jm-id').val(-1);
			$('#acct-jm-btn-journal-entries-refresh').click();
			$('#acct-jm-journal-voucher-form').jqMgVal('clearForm');
			$('#acct-jm-journal-entries-form').jqMgVal('clearForm');
			$('#acct-jm-form-section').collapse('hide');
		});

		$('#acct-jm-btn-asc').click(function()
		{
			$('.acct-jm-btn-tooltip').tooltip('hide');
			$(this).attr('disabled','disabled');
			$('#acct-jm-btn-desc').removeAttr('disabled');
			$('#acct-jm-journals-grid').jqGrid('setGridParam', {'groupingView':{'groupOrder': ['asc']}}).trigger('reloadGrid');
		});

		$('#acct-jm-btn-desc').click(function()
		{
			$('.acct-jm-btn-tooltip').tooltip('hide');
			$(this).attr('disabled','disabled');
			$('#acct-jm-btn-asc').removeAttr('disabled');
			$('#acct-jm-journals-grid').jqGrid('setGridParam', {'groupingView':{'groupOrder': ['desc']}}).trigger('reloadGrid');
		});

		$('#acct-jm-btn-journal-entries-refresh').click(function()
		{
			$('.acct-jm-btn-tooltip').tooltip('hide');
			// $('#acct-jm-journal-entries-grid')[0].clearToolbar();
			$('#acct-jm-journal-entries-grid').jqGrid('setGridParam', {'postData':{"filters":"{'groupOp':'AND','rules':[{'field':'je.journal_voucher_id','op':'eq','data':'" + $('#acct-jm-id').val() + "'}]}"}}).trigger('reloadGrid');
			$('#acct-jm-btn-journal-entries-toolbar').disabledButtonGroup();
			$('#acct-jm-btn-journal-entries-group-1').enableButtonGroup();
			$('#acct-jm-btn-journal-entries-group-3').enableButtonGroup();
		});

		$('#acct-jm-btn-journal-entries-export-xls').click(function()
		{
			  $('#acct-jm-journal-entries-gridXlsButton').click();
		});

		$('#acct-jm-btn-journal-entries-export-csv').click(function()
		{
			  $('#acct-jm-journal-entries-gridCsvButton').click();
		});

		$('#acct-jm-btn-journal-entries-edit').click(function()
		{
			var rowData, rowId;

			rowId = $('#acct-jm-journal-entries-grid').jqGrid('getGridParam', 'selrow');

			if(rowId == null)
			{
				$('#acct-jm-btn-journal-entries-toolbar').showAlertAfterElement('alert-info alert-custom', lang.invalidSelection, 5000);
				$('.acct-jm-btn-tooltip').tooltip('hide');
				return;
			}

			$('.acct-jm-btn-tooltip').tooltip('hide');
			$('#acct-jm-btn-journal-entries-toolbar').disabledButtonGroup();
			$('#acct-jm-btn-journal-entries-group-3').enableButtonGroup();

			rowData = $('#acct-jm-journal-entries-grid').getRowData(rowId);
			populateFormFields(rowData, 'acct-jm-');

			$('#acct-jm-cost-center').val(rowData.cost_center_key + ' ' + rowData.cost_center_name);
			$('#acct-jm-account').val(rowData.account_key + ' ' + rowData.account_name);
			if($('#acct-jm-cost-center-id').attr('defaultvalue') == '')
			{
				$('#acct-jm-cost-center').focus();
			}
			else
			{
				$('#acct-jm-account').focus();
			}
		});

		$('#acct-jm-btn-journal-entries-delete').click(function()
		{
			$('.acct-jm-btn-tooltip').tooltip('hide');

			if($(this).hasAttr('disabled'))
			{
				return;
			}

			var idArray = $('#acct-jm-journal-entries-grid').getSelectedRowsIdCell('journal_entry_id');

			if(idArray.length == 0)
			{
				$('#acct-jm-btn-journal-entries-toolbar').showAlertAfterElement('alert-info alert-custom', lang.invalidSelection, 5000);
				return;
			}

			if($.inArray($('#acct-jm-journal-entry-id').val(), idArray) > -1)
			{
				$('#acct-jm-journal-entries-form').jqMgVal('clearForm');
				$('#acct-jm-cost-center').val($('#acct-jm-cost-center').attr('defaultvalue'));
				$('#acct-jm-cost-center-id').val($('#acct-jm-cost-center-id').attr('defaultvalue'));
				$('#acct-jm-debit').val($('#acct-jm-debit').attr('defaultvalue'));
				$('#acct-jm-credit').val($('#acct-jm-credit').attr('defaultvalue'));
			}

			token = $('#app-token').val();

			$.ajax(
			{
				type: 'POST',
				data: JSON.stringify({'_token':token, 'id':idArray}),
				dataType : 'json',
				url:  $('#acct-jm-journal-entries-form').attr('action') + '/delete-journal-entry',
				error: function (jqXHR, textStatus, errorThrown)
				{
					handleServerExceptions(jqXHR, 'acct-jm-btn-journal-entries-toolbar', false);
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
						$('#acct-jm-btn-journal-entries-refresh').click();
						$('#acct-jm-status-label').val(json.statusLabel);
						$('#acct-jm-status').val(json.status);
					}

					if(!json.success && json.info)
					{
						$('#acct-jm-journal-entries-form').showAlertAsFirstChild('alert-info', json.info, 7000);
					}

					$('#app-loader').addClass('hidden');
					enableAll();

					if($('#acct-jm-cost-center-id').attr('defaultvalue') == '')
					{
						$('#acct-jm-cost-center').focus();
					}
					else
					{
						$('#acct-jm-account').focus();
					}
				}
			});
		});

		$('#acct-jm-btn-journal-entries-save').click(function()
		{
			$('.acct-jm-btn-tooltip').tooltip('hide');

			var url = $('#acct-jm-journal-entries-form').attr('action'), action = 'new';

			if($('#acct-jm-debit').isEmpty() && !$('#acct-jm-credit').isEmpty())
			{
				$('#acct-jm-debit').val('0');
			}

			if(!$('#acct-jm-debit').isEmpty() && $('#acct-jm-credit').isEmpty())
			{
				$('#acct-jm-credit').val('0');
			}

			if(!$('#acct-jm-journal-entries-form').jqMgVal('isFormValid'))
			{
				return;
			}

			if($('#acct-jm-journal-entry-id').isEmpty())
			{
				url = url + '/store-journal-entry';
			}
			else
			{
				url = url + '/update-journal-entry';
				action = 'edit';
			}

			$.ajax(
			{
				type: 'POST',
				data: JSON.stringify($.extend({'number':$('#acct-jm-voucher-number-label').attr('number'), 'journal_voucher_id':$('#acct-jm-id').val()}, $('#acct-jm-journal-entries-form').formToObject('acct-jm-'))),
				dataType : 'json',
				url: url,
				error: function (jqXHR, textStatus, errorThrown)
				{
					handleServerExceptions(jqXHR, 'acct-jm-journal-entries-form');
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
						$('#acct-jm-btn-journal-entries-refresh').click();
						$('#acct-jm-journal-entries-form').jqMgVal('clearForm');
						$('#acct-jm-cost-center').val($('#acct-jm-cost-center').attr('defaultvalue'));
						$('#acct-jm-cost-center-id').val($('#acct-jm-cost-center-id').attr('defaultvalue'));
						$('#acct-jm-debit').val($('#acct-jm-debit').attr('defaultvalue'));
						$('#acct-jm-credit').val($('#acct-jm-credit').attr('defaultvalue'));
						$('#acct-jm-status-label').val(json.statusLabel);
						$('#acct-jm-status').val(json.status);
						$('#acct-jm-btn-journal-entries-toolbar').disabledButtonGroup();
						$('#acct-jm-btn-journal-entries-group-1').enableButtonGroup();
						$('#acct-jm-btn-journal-entries-group-3').enableButtonGroup();
					}

					if(!json.success && json.info)
					{
						$('#acct-jm-journal-entries-form').showAlertAsFirstChild('alert-info', json.info, 7000);
					}

					$('#app-loader').addClass('hidden');
					enableAll();

					if($('#acct-jm-cost-center-id').attr('defaultvalue') == '')
					{
						$('#acct-jm-cost-center').focus();
					}
					else
					{
						$('#acct-jm-account').focus();
					}
				}
			});
		});

		$('#acct-jm-btn-period0').click(function()
		{
			$('#acct-jm-period-id').val($(this).attr('data-period-id'));
			$('#acct-jm-period-label').val($(this).html());
		});

		$('#acct-jm-btn-period1').click(function()
		{
			$('#acct-jm-period-id').val($(this).attr('data-period-id'));
			$('#acct-jm-period-label').val($(this).html());
		});

		$('#acct-jm-debit').focus(function()
		{
			  if(parseFloat($(this).val()) == 0)
				{
					$(this).val('');
				}
		});

		$('#acct-jm-credit').focus(function()
		{
			  if(parseFloat($(this).val()) == 0)
				{
					$(this).val('');
				}
		});

		$('#acct-jm-date').focusout(function()
		{
			var date, dateFrom, dateTo, periods = [];

			if($(this).jqMgValIsValid() == true)
			{
				if($(this).val() != $(this).attr('data-last-selected-date'))
				{
					date = $.datepicker.parseDate( $.datepicker._defaults.dateFormat, $(this).val());

					$(this).attr('data-last-selected-date', $(this).val());

					$.each(acctJmPeriods, function( index, period )
					{
						dateFrom = $.datepicker.parseDate("yy-mm-dd", period.startDate);
						dateTo = $.datepicker.parseDate("yy-mm-dd", period.endDate);

						if(date.getTime() >= dateFrom.getTime() && date.getTime() <= dateTo.getTime())
						{
							periods.push({id: period.id, month: period.month});
						}
					});

					if(periods.length == 0)
					{
						$('#acct-jm-period-id').val('');
						$('#acct-jm-period-label').val('');
					}
					else if(periods.length == 1)
					{
						$('#acct-jm-period-id').val(periods[0].id);
						$('#acct-jm-period-label').val(periods[0].month);
					}
					else
					{
						// console.log(periods);
						$('#acct-jm-btn-period0').attr('data-period-id', periods[0].id);
						$('#acct-jm-btn-period1').attr('data-period-id', periods[1].id);
						$('#acct-jm-btn-period0').html(periods[0].month);
						$('#acct-jm-btn-period1').html(periods[1].month);
						$('#acct-jm-modal-periods').modal('show');
					}
				}
			}
			else
			{
				$('#acct-jm-period-id').val('');
				$('#acct-jm-period-label').val('');
			}
		});

		$('#acct-jm-journal-entries-form,#acct-jm-btn-journal-entries-toolbar').click(function()
		{
			if($('#acct-jm-journal-entries-form-fieldset').attr('disabled') == 'disabled' && $('#acct-jm-btn-save').attr('disabled') == undefined)
			{
				$('#top-navbar-menu').click();
				$('#acct-jm-btn-group-3').effect('shake', null, 600);
			}
		});

		$('#acct-jm-journal-voucher-filters-body').on('hidden.bs.collapse', function ()
		{
			$(this).parent().children('.panel-heading').children('.btn-filter-toggle').children('i').attr('class','fa fa-chevron-down');
		});

		$('#acct-jm-journal-voucher-filters-body').on('shown.bs.collapse', function ()
		{
			$(this).parent().children('.panel-heading').children('.btn-filter-toggle').children('i').attr('class','fa fa-chevron-up');
		});

		setTimeout(function () {
			$('#acct-jm-numbers').tokenfield({beautify:false});
			$('#acct-jm-references').tokenfield({beautify:false});
			$('#acct-jm-debits').tokenfield({beautify:false});
			$('#acct-jm-credits').tokenfield({beautify:false});

			$('#acct-jm-periods').tokenfield({
	  		autocomplete: {
			    source: acctJmPeriodsFilter,
			    delay: 100
			  },
			  showAutocompleteOnFocus: true,
				beautify:false
			});

			$('#acct-jm-periods').on('tokenfield:createtoken', function (event) {
		    var available_tokens = acctJmPeriodsFilter;
		    var exists = true;
		    $.each(available_tokens, function(index, token)
				{
		        if (token.value == event.attrs.value)
						{
							exists = false;
						}
		    });
		    if(exists === true)
				{
					event.preventDefault();
				}
			});

			$('#acct-jm-created-by-users').tokenfield({
	  		autocomplete: {
			    source: acctJmCreatedBy,
			    delay: 100
			  },
			  showAutocompleteOnFocus: true,
				beautify:false
			});

			$('#acct-jm-created-by-users').on('tokenfield:createtoken', function (event) {
		    var available_tokens = acctJmCreatedBy;
		    var exists = true;
		    $.each(available_tokens, function(index, token)
				{
		        if (token.value == event.attrs.value)
						{
							exists = false;
						}
		    });

		    if(exists === true)
				{
					event.preventDefault();
				}
			});

			$('#acct-jm-voucher-types').tokenfield({
	  		autocomplete: {
			    source: acctJmVoucherTypes,
			    delay: 100
			  },
			  showAutocompleteOnFocus: true,
				beautify:false
			});

			$('#acct-jm-voucher-types').on('tokenfield:createtoken', function (event) {
		    var available_tokens = acctJmVoucherTypes;
		    var exists = true;
		    $.each(available_tokens, function(index, token)
				{
		        if (token.value == event.attrs.value)
						{
							exists = false;
						}
		    });
		    if(exists === true)
				{
					event.preventDefault();
				}
			});

			$('#acct-jm-cost-centers').tokenfield({
	  		autocomplete: {
			    source: acctJmCostCenters,
			    delay: 100
			  },
			  showAutocompleteOnFocus: true,
				beautify:false
			});

			$('#acct-jm-cost-centers').on('tokenfield:createtoken', function (event) {
		    var available_tokens = acctJmCostCenters;
		    var exists = true;
		    $.each(available_tokens, function(index, token)
				{
		        if (token.value == event.attrs.value)
						{
							exists = false;
						}
		    });
		    if(exists === true)
				{
					event.preventDefault();
				}
			});

			$('#acct-jm-accounts').tokenfield({
	  		autocomplete: {
			    source: acctJmAccounts,
			    delay: 100
			  },
			  showAutocompleteOnFocus: true,
				beautify:false
			});

			$('#acct-jm-accounts').on('tokenfield:createtoken', function (event) {
		    var available_tokens = acctJmAccounts;
		    var exists = true;
		    $.each(available_tokens, function(index, token)
				{
		        if (token.value == event.attrs.value)
						{
							exists = false;
						}
		    });
		    if(exists === true)
				{
					event.preventDefault();
				}
			});

			$('#acct-jm-status-filter').tokenfield({
	  		autocomplete: {
			    source: acctJmStatus,
			    delay: 100
			  },
			  showAutocompleteOnFocus: true,
				beautify:false
			});

			$('#acct-jm-status-filter').on('tokenfield:createtoken', function (event) {
		    var available_tokens = acctJmStatus;
		    var exists = true;
		    $.each(available_tokens, function(index, token)
				{
		        if (token.value == event.attrs.value)
						{
							exists = false;
						}
		    });
		    if(exists === true)
				{
					event.preventDefault();
				}
			});

		}, 500);

		$('#acct-jm-btn-edit-helper').click(function()
	  {
			showButtonHelper(false, 'acct-jm-btn-group-2', $('#acct-jm-edit-action').attr('data-content'));
	  });

		$('#acct-jm-btn-nulify-helper').click(function()
	  {
			showButtonHelper(false, 'acct-jm-btn-group-2', $('#acct-jm-nulify-action').attr('data-content'));
	  });

		if(!$('#acct-jm-new-action').isEmpty())
		{
			$('#acct-jm-btn-new').click();
		}

		if(!$('#acct-jm-edit-action').isEmpty())
		{
			showButtonHelper(false, 'acct-jm-btn-group-2', $('#acct-jm-edit-action').attr('data-content'));
		}

		if(!$('#acct-jm-nulify-action').isEmpty())
		{
			showButtonHelper(false, 'acct-jm-btn-group-2', $('#acct-jm-nulify-action').attr('data-content'));
		}
	});

</script>
<div class="row">
	<div class="col-lg-12 col-md-12">
		{!! Form::open(array('id' => 'acct-jm-journal-voucher-filters-form', 'url' => URL::to('/'), 'role' => 'form', 'onsubmit' => 'return false;', 'class' => 'form-horizontal')) !!}
			<div id="acct-jm-journal-voucher-filters" class="panel panel-default">
				<div class="panel-heading custom-panel-heading clearfix">
					<button id="acct-jm-btn-filter-toggle" type="button" class="btn btn-default btn-sm btn-filter-toggle pull-right" data-toggle="collapse" data-target="#acct-jm-journal-voucher-filters-body"><i class="fa fa-chevron-down"></i></button>
					<h3 class="panel-title custom-panel-title pull-left">
						{{ Lang::get('form.filtersTitle') }}
					</h3>
					{!! Form::button('<i class="fa fa-filter"></i> ' . Lang::get('form.filterButton'), array('id' => 'acct-jm-btn-filter', 'class' => 'btn btn-default btn-sm pull-right btn-filter-left-margin')) !!}
					{!! Form::button('<i class="fa fa-eraser"></i> ' . Lang::get('form.clearFilterButton'), array('id' => 'acct-jm-btn-clear-filter', 'class' => 'btn btn-default btn-sm pull-right')) !!}
				</div>
				<div id="acct-jm-journal-voucher-filters-body" class="panel-body collapse">
					<div class="row">
						<div class="col-lg-6 col-md-12">
							<div class="form-group">
								{!! Form::label('acct-jm-periods', Lang::get('decima-accounting::journal-management.periods'), array('class' => 'col-sm-2 control-label')) !!}
								<div class="col-sm-10 mg-hm">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										{!! Form::text('acct-jm-periods', null , array('id' => 'acct-jm-periods', 'class' => 'form-control')) !!}
									</div>
								</div>
							</div>
							<div class="form-group">
								{!! Form::label('acct-jm-date-from', Lang::get('decima-accounting::journal-management.dateRangeShort'), array('class' => 'col-sm-2 control-label')) !!}
								<div class="col-sm-10 mg-hm">
									{!! Form::daterange('acct-jm-date-from', 'acct-jm-date-to' , array('class' => 'form-control')) !!}
									<p class="help-block">{{ Lang::get('decima-accounting::journal-management.dateRangeHelperText') }}</p>
								</div>
							</div>
							<div class="form-group">
								{!! Form::label('acct-jm-voucher-types', Lang::get('decima-accounting::journal-management.voucherTypes'), array('class' => 'col-sm-2 control-label')) !!}
								<div class="col-sm-10 mg-hm">
									{!! Form::text('acct-jm-voucher-types', null , array('id' => 'acct-jm-voucher-types', 'class' => 'form-control')) !!}
									<p class="help-block">{{ Lang::get('decima-accounting::journal-management.voucherTypesHelperText') }}</p>
								</div>
							</div>
							<div class="form-group">
								{!! Form::label('acct-jm-status-filter', Lang::get('decima-accounting::journal-management.statusPlural'), array('class' => 'col-sm-2 control-label')) !!}
								<div class="col-sm-10 mg-hm">
									{!! Form::text('acct-jm-status-filter', null , array('id' => 'acct-jm-status-filter', 'class' => 'form-control')) !!}
									<p class="help-block">{{ Lang::get('decima-accounting::journal-management.statusFilterHelperText') }}</p>
								</div>
							</div>
							<div class="form-group">
								{!! Form::label('acct-jm-created-by-users', Lang::get('decima-accounting::journal-management.createdByUser'), array('class' => 'col-sm-2 control-label')) !!}
								<div class="col-sm-10 mg-hm">
									{!! Form::text('acct-jm-created-by-users', null , array('id' => 'acct-jm-created-by-users', 'class' => 'form-control')) !!}
									<p class="help-block">{{ Lang::get('decima-accounting::journal-management.createdByUserHelperText') }}</p>
								</div>
							</div>
							<div class="form-group no-margin-bottom-min-1200">
								{!! Form::label('acct-jm-references', Lang::get('decima-accounting::journal-management.references'), array('class' => 'col-sm-2 control-label')) !!}
								<div class="col-sm-10 mg-hm">
									<div class="input-group">
										<span class="input-group-addon">#</span>
										{!! Form::text('acct-jm-references', null , array('id' => 'acct-jm-references', 'class' => 'form-control')) !!}
									</div>
									<p class="help-block">{{ Lang::get('decima-accounting::journal-management.referencesHelperText') }}</p>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12">
							{{--
							<div class="form-group">
								 {!! Form::label('acct-jm-dates', Lang::get('decima-accounting::journal-management.dates'), array('class' => 'col-sm-2 control-label')) !!}
								<div class="col-sm-10 mg-hm">
									{!! Form::date('acct-jm-dates', array('class' => 'form-control')) !!}
								</div>
							</div>
							--}}
							<div class="form-group">
								{!! Form::label('acct-jm-numbers', Lang::get('decima-accounting::journal-management.numbers'), array('class' => 'col-sm-2 control-label')) !!}
								<div class="col-sm-10 mg-hm">
									<div class="input-group">
										<span class="input-group-addon">#</span>
										{!! Form::text('acct-jm-numbers', null , array('id' => 'acct-jm-numbers', 'class' => 'form-control')) !!}
									</div>
								</div>
							</div>
							<div class="form-group">
								{!! Form::label('acct-jm-numbers-from', Lang::get('decima-accounting::journal-management.numbersRange'), array('class' => 'col-sm-2 control-label')) !!}
								<div class="col-sm-10 mg-hm">
									<div class="input-group">
										<span class="input-group-addon">{{ Lang::get('form.dateRangeFrom') }}</span>
										{!! Form::text('acct-jm-numbers-from', null , array('id' => 'acct-jm-numbers-from', 'class' => 'form-control')) !!}
										<span class="input-group-addon">{{ Lang::get('form.dateRangeTo') }}</span>
										{!! Form::text('acct-jm-numbers-to', null , array('id' => 'acct-jm-numbers-to', 'class' => 'form-control')) !!}
									</div>
									<p class="help-block">{{ Lang::get('decima-accounting::journal-management.numbersRangeHelperText') }}</p>
								</div>
							</div>
							<div class="form-group">
								{!! Form::label('acct-jm-remark-filter', Lang::get('decima-accounting::journal-management.remarkFilter'), array('class' => 'col-sm-2 control-label')) !!}
								<div class="col-sm-10 mg-hm">
									{!! Form::text('acct-jm-remark-filter', null , array('id' => 'acct-jm-remark-filter', 'class' => 'form-control')) !!}
								</div>
							</div>
							<div class="form-group">
								{!! Form::label('acct-jm-cost-centers', Lang::get('decima-accounting::journal-management.costCenterShortPlural'), array('class' => 'col-sm-2 control-label')) !!}
								<div class="col-sm-10 mg-hm">
									{!! Form::text('acct-jm-cost-centers', null , array('id' => 'acct-jm-cost-centers', 'class' => 'form-control')) !!}
									<p class="help-block">{{ Lang::get('decima-accounting::journal-management.costCenterFilterHelperText') }}</p>
								</div>
							</div>
							<div class="form-group">
								{!! Form::label('acct-jm-accounts', Lang::get('decima-accounting::journal-management.accountsShortPlural'), array('class' => 'col-sm-2 control-label')) !!}
								<div class="col-sm-10 mg-hm">
									{!! Form::text('acct-jm-accounts', null , array('id' => 'acct-jm-accounts', 'class' => 'form-control')) !!}
									<p class="help-block">{{ Lang::get('decima-accounting::journal-management.accountFilterHelperText') }}</p>
								</div>
							</div>
							<div class="form-group">
								{!! Form::label('acct-jm-debits', Lang::get('decima-accounting::journal-management.debit'), array('class' => 'col-sm-2 control-label')) !!}
								<div class="col-sm-10 mg-hm">
									{!! Form::text('acct-jm-debits', null , array('id' => 'acct-jm-debits', 'class' => 'form-control')) !!}
								</div>
							</div>
							<div class="form-group no-margin-bottom">
								{!! Form::label('acct-jm-credits', Lang::get('decima-accounting::journal-management.credit'), array('class' => 'col-sm-2 control-label')) !!}
								<div class="col-sm-10 mg-hm">
									{!! Form::text('acct-jm-credits', null , array('id' => 'acct-jm-credits', 'class' => 'form-control')) !!}
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		{!! Form::close() !!}
		<div id="acct-jm-btn-toolbar" class="section-header btn-toolbar" role="toolbar">
			<div id="acct-jm-btn-group-1" class="btn-group btn-group-app-toolbar">
				{!! Form::button('<i class="fa fa-plus"></i> ' . Lang::get('toolbar.new'), array('id' => 'acct-jm-btn-new', 'class' => 'btn btn-default acct-jm-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'data-original-title' => Lang::get('decima-accounting::journal-management.new'))) !!}
				{!! Form::button('<i class="fa fa-refresh"></i> ' . Lang::get('toolbar.refresh'), array('id' => 'acct-jm-btn-refresh', 'class' => 'btn btn-default acct-jm-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'data-original-title' => Lang::get('toolbar.refreshLongText'))) !!}
				<div class="btn-group">
					{!! Form::button('<i class="fa fa-share-square-o"></i> ' . Lang::get('toolbar.export') . ' <span class="caret"></span>', array('class' => 'btn btn-default dropdown-toggle', 'data-container' => 'body', 'data-toggle' => 'dropdown')) !!}
					<ul class="dropdown-menu">
         		<li><a id='acct-jm-btn-export-xls' class="fake-link"><i class="fa fa-file-excel-o"></i> xls</a></li>
         		<li><a id='acct-jm-btn-export-csv' class="fake-link"><i class="fa fa-file-text-o"></i> csv</a></li>
       		</ul>
				</div>
			</div>
			<div id="acct-jm-btn-group-2" class="btn-group btn-group-app-toolbar">
				{!! Form::button('<i class="fa fa-edit"></i> ' . Lang::get('toolbar.edit'), array('id' => 'acct-jm-btn-edit', 'class' => 'btn btn-default acct-jm-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'disabled' => '', 'data-original-title' => Lang::get('decima-accounting::journal-management.edit'))) !!}
				{!! Form::button('<i class="fa fa-minus"></i> ' . Lang::get('toolbar.nulify'), array('id' => 'acct-jm-btn-delete', 'class' => 'btn btn-default acct-jm-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'disabled' => '', 'data-original-title' => Lang::get('decima-accounting::journal-management.delete'))) !!}
			</div>
			<div id="acct-jm-btn-group-3" class="btn-group btn-group-app-toolbar">
				{!! Form::button('<i class="fa fa-save"></i> ' . Lang::get('toolbar.save'), array('id' => 'acct-jm-btn-save', 'class' => 'btn btn-default acct-jm-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'disabled' => '', 'data-original-title' => Lang::get('decima-accounting::journal-management.save'))) !!}
				{!! Form::button('<i class="fa fa-undo"></i> ' . Lang::get('toolbar.close'), array('id' => 'acct-jm-btn-close', 'class' => 'btn btn-default acct-jm-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'disabled' => '', 'data-original-title' => Lang::get('toolbar.closeLongText'))) !!}
			</div>
			<div id="acct-jm-btn-group-4" class="btn-group btn-group-app-toolbar pull-right">
				{!! Form::button('<i class="fa fa-sort-numeric-desc"></i> ', array('id' => 'acct-jm-btn-desc', 'class' => 'btn btn-default acct-jm-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'disabled' => '', 'data-original-title' => Lang::get('toolbar.desc'))) !!}
				{!! Form::button('<i class="fa fa-sort-numeric-asc"></i> ', array('id' => 'acct-jm-btn-asc', 'class' => 'btn btn-default acct-jm-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'data-original-title' => Lang::get('toolbar.asc'))) !!}
			</div>
		</div>
		<div id='acct-jm-grid-section' class='app-grid collapse in' data-app-grid-id='acct-jm-journals-grid'>
			{!!
			GridRender::setGridId("acct-jm-journals-grid")
				->hideXlsExporter()
  			->hideCsvExporter()
				->setGridOption('height', 'auto')
				->setGridOption('multiselect', false)
				->setGridOption('rowList', array(50, 100, 250, 500, 750, 1000, 1500, 2000, 3000, 5000, 10000))
				->setGridOption('rowNum', 50)
	    	->setGridOption('url',URL::to('accounting/transactions/journal-management/journal-voucher-grid-data'))
	    	->setGridOption('caption', Lang::get('decima-accounting::journal-management.gridTitle'))
	    	->setGridOption('filename', Lang::get('decima-accounting::journal-management.gridTitle'))
	    	->setGridOption('postData',array('_token' => Session::token()))
				->setGridOption('grouping', true)
				->setGridOption('groupingView', array('groupField' => array('voucher_header'), 'groupColumnShow' => array(false), 'groupSummary' => array(true), 'showSummaryOnHide' => true, 'groupOrder' => array('desc')))
				//->setGridOption('footerrow', true)
	    	->setGridEvent('onSelectRow', 'acctJmJournalsOnSelectRowEvent')
	    	//->setGridEvent('gridComplete', 'acctJmJournalsOnGridCompleteEvent')
				//->setFilterToolbarEvent('beforeClear','acctJmJournalsBeforeClearEvent')
				->addGroupHeader(array('startColumnName' => 'cost_center_key_0', 'numberOfColumns' => 7, 'titleText' => Lang::get('decima-accounting::journal-management.voucherNumberText') . ' - ' . Lang::get('decima-accounting::period-management.period') . ' - ' . Lang::get('decima-accounting::journal-management.date') . ' - ' . Lang::get('decima-accounting::journal-management.voucherType') . ' - ' . Lang::get('decima-accounting::journal-management.manualReference'). ' - ' . Lang::get('decima-accounting::journal-management.remark')))
	    	->addColumn(array('index' => 'jv.id', 'name' => 'voucher_id', 'hidden' => true))
	    	->addColumn(array('index' => 'p.id', 'name' => 'period_id', 'hidden' => true))
				//->addColumn(array('label' => 'header', 'index' => 'voucher_header' ,'name' => 'voucher_header'))
				->addColumn(array('index' => 'voucher_header'))
	    	->addColumn(array('label' => Lang::get('decima-accounting::journal-management.date'), 'index' => 'jv.date' ,'name' => 'date', 'hidden' => true, 'formatter' => 'date'))
	    	->addColumn(array('label' => Lang::get('decima-accounting::journal-management.number'), 'index' => 'jv.number', 'name' => 'number', 'hidden' => true))
	    	->addColumn(array('label' => Lang::get('decima-accounting::journal-management.type'), 'index' => 'vt.id', 'name' => 'voucher_type_id', 'hidden' => true))
				->addColumn(array('label' => Lang::get('decima-accounting::journal-management.type'), 'index' => 'vt.name', 'name' => 'voucher_type', 'hidden' => true))
				->addColumn(array('label' => Lang::get('decima-accounting::journal-management.remark'), 'index' => 'jv.remark', 'name' => 'remark', 'hidden' => true))
	    	->addColumn(array('label' => Lang::get('decima-accounting::journal-management.reference'), 'index' => 'jv.manual_reference', 'name' => 'manual_reference', 'hidden' => true))
				->addColumn(array('label' => Lang::get('decima-accounting::journal-management.isEditable'), 'index' => 'jv.is_editable', 'name' => 'is_editable', 'formatter' => 'select', 'editoptions' => array('value' => Lang::get('form.booleanText')), 'align' => 'center', 'hidden' => true))
				->addColumn(array('index' => 'cc.id', 'name' => 'cost_center_id_0', 'hidden' => true))
				->addColumn(array('index' => 'c.id', 'name' => 'account_id_0', 'hidden' => true))
				->addColumn(array('label' => Lang::get('decima-accounting::journal-management.costCenterCod'), 'index' => 'cc.key' ,'name' => 'cost_center_key_0', 'width' => 80, 'summaryType' => 'count', 'summaryTpl' => '({0}) total'))
				->addColumn(array('label' => Lang::get('decima-accounting::journal-management.costCenterShort'), 'index' => 'cc.name', 'name' => 'cost_center_name_0'))
				->addColumn(array('label' => Lang::get('decima-accounting::journal-management.accountCod'), 'index' => 'c.key', 'name' => 'account_key_0' , 'width' => 80))
				->addColumn(array('label' => Lang::get('decima-accounting::journal-management.account'), 'index' => 'c.name', 'name' => 'account_name_0'))
				->addColumn(array('label' => Lang::get('decima-accounting::journal-management.debit'), 'index' => 'je.debit', 'name' => 'debit_0', 'formatter' => 'currency', 'align'=>'right', 'width' => 115, 'summaryType' => 'sum', 'formatoptions' => array('prefix' => OrganizationManager::getOrganizationCurrencySymbol() . ' ')))
				->addColumn(array('label' => Lang::get('decima-accounting::journal-management.credit'), 'index' => 'je.credit', 'name' => 'credit_0', 'formatter' => 'currency', 'align'=>'right', 'width' => 115, 'summaryType' => 'sum', 'formatoptions' => array('prefix' => OrganizationManager::getOrganizationCurrencySymbol() . ' ')))
				->addColumn(array('label' => Lang::get('decima-accounting::journal-management.status'), 'index' => 'jv.status', 'name' => 'status', 'formatter' => 'select', 'editoptions' => array('value' => Lang::get('decima-accounting::journal-management.statusGridText')), 'align' => 'center'))
	    	->renderGrid();
			!!}
		</div>
	</div>
</div>
<div id='acct-jm-admin-section' class="row collapse in section-block">
	{!! Form::journals('acct-jm-', $appInfo['id']) !!}
</div>
<div id='acct-jm-form-section' class="row collapse">
	<div class="col-lg-12 col-md-12">
		<div id="acct-jm-form-container" class="form-container">
			{!! Form::open(array('id' => 'acct-jm-journal-voucher-form', 'url' => URL::to('accounting/transactions/journal-management'), 'role'  =>  'form', 'onsubmit' => 'return false;')) !!}
				<legend id="acct-jm-form-new-title" class="hidden">{{ Lang::get('decima-accounting::journal-management.formNewTitle') }}</legend>
				<legend id="acct-jm-form-edit-title" class="hidden">{{ Lang::get('decima-accounting::journal-management.formEditTitle') }}<label id="acct-jm-voucher-number-label" class="pull-right" data-default-label="{{ Lang::get('decima-accounting::journal-management.voucherNumber') }}"></label></legend>
				<div class="row">
					<div class="col-lg-6 col-md-6">
						{{--
						<div class="form-group mg-hm">
							{!! Form::label('psg-cd-file', 'Archivo', array('class' => 'control-label')) !!}
					    {!! Form::file('psg-cd-file', null, array('id' => 'psg-cd-file')) !!}
			  		</div>
						--}}
						<div class="form-group mg-hm">
							{!! Form::label('acct-jm-date', Lang::get('decima-accounting::journal-management.date'), array('class' => 'control-label')) !!}
							{!! Form::date('acct-jm-date', array('class' => 'form-control', 'data-mg-required' => '', 'data-period-validation-message' => Lang::get('decima-accounting::journal-management.periodValidationMessage'))) !!}
					    {!! Form::hidden('acct-jm-id', null, array('id' => 'acct-jm-id')) !!}
			  		</div>
						<div class="form-group mg-hm clearfix">
							{!! Form::label('acct-jm-voucher-type', Lang::get('decima-accounting::journal-management.voucherType'), array('class' => 'control-label')) !!}
							{!! Form::autocomplete('acct-jm-voucher-type', $voucherTypes, array('class' => 'form-control', 'data-mg-required' => ''), 'acct-jm-voucher-type', 'acct-jm-voucher-type-id', null, 'fa-files-o') !!}
							{!! Form::hidden('acct-jm-voucher-type-id', null, array('id'  =>  'acct-jm-voucher-type-id')) !!}
			  		</div>
						<div class="form-group mg-hm">
							{!! Form::label('acct-jm-remark', Lang::get('decima-accounting::journal-management.remark'), array('class' => 'control-label')) !!}
							{!! Form::textareacustom('acct-jm-remark', 2, 500, array('class' => 'form-control', 'data-mg-required' => '')) !!}
			  		</div>
					</div>
					<div class="col-lg-6 col-md-6">
						<div class="form-group mg-hm">
							{!! Form::label('acct-jm-manual-reference', Lang::get('decima-accounting::journal-management.manualReference'), array('class' => 'control-label')) !!}
							<div class="input-group">
								<span class="input-group-addon">#</span>
					    	{!! Form::text('acct-jm-manual-reference', null , array('id' => 'acct-jm-manual-reference', 'class' => 'form-control')) !!}
					    </div>
							<p class="help-block">&nbsp;</p>
			  		</div>
						<div class="form-group mg-hm">
							{!! Form::label('acct-jm-period-label', Lang::get('decima-accounting::period-management.period'), array('class' => 'control-label')) !!}
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								{!! Form::text('acct-jm-period-label', '' , array('id' => 'acct-jm-period-label', 'class' => 'form-control', 'disabled' => '')) !!}
							</div>
							{!! Form::hidden('acct-jm-period-id', '', array('id' => 'acct-jm-period-id')) !!}
							<p class="help-block">{{ Lang::get('decima-accounting::journal-management.periodsHelperText') }}</p>
						</div>
						<div class="form-group mg-hm">
							{!! Form::label('acct-jm-status-label', Lang::get('decima-accounting::journal-management.status'), array('class' => 'control-label')) !!}
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-exclamation-triangle"></i></span>
								{!! Form::text('acct-jm-status-label', Lang::get('decima-accounting::journal-management.B') , array('id' => 'acct-jm-status-label', 'class' => 'form-control', 'disabled' => '', 'data-label-A' => Lang::get('decima-accounting::journal-management.A'), 'data-label-B' => Lang::get('decima-accounting::journal-management.B'), 'data-label-C' => Lang::get('decima-accounting::journal-management.C'), 'defaultvalue' => Lang::get('decima-accounting::journal-management.B'))) !!}
							</div>
							{!! Form::hidden('acct-jm-status', 'B', array('id' => 'acct-jm-status', 'defaultvalue' => 'B')) !!}
							<p class="help-block">{{ Lang::get('decima-accounting::journal-management.statusHelperText') }}</p>
						</div>
					</div>
				</div>
			{!! Form::close() !!}
			{!! Form::open(array('id' => 'acct-jm-journal-entries-form', 'url' => URL::to('accounting/transactions/journal-management'), 'role'  =>  'form', 'onsubmit' => 'return false;')) !!}
				<fieldset id="acct-jm-journal-entries-form-fieldset" disabled="disabled">
					<legend id="acct-jm-journal-entries-form-new-title" class="">{{ Lang::get('decima-accounting::journal-management.formJournalEntries') }}</legend>
					<div class="row">
						<div class="col-lg-6 col-md-6">
							<div class="form-group mg-hm clearfix">
								{!! Form::label('acct-jm-cost-center', Lang::get('decima-accounting::journal-management.costCenter'), array('class' => 'control-label')) !!}
								{!! Form::autocomplete('acct-jm-cost-center', $costCenters['organizationCostCenters'], array('class' => 'form-control', 'data-mg-required' => '', 'defaultvalue' => $costCenters['defaultCostCenter']['label']), 'acct-jm-cost-center', 'acct-jm-cost-center-id', $costCenters['defaultCostCenter']['label'], 'fa-sitemap') !!}
								{!! Form::hidden('acct-jm-cost-center-id', $costCenters['defaultCostCenter']['id'], array('id' => 'acct-jm-cost-center-id', 'defaultvalue' => $costCenters['defaultCostCenter']['id'])) !!}
								{!! Form::hidden('acct-jm-journal-entry-id', null, array('id' => 'acct-jm-journal-entry-id')) !!}
				  		</div>
							<div class="form-group mg-hm clearfix">
								{!! Form::label('acct-jm-account', Lang::get('decima-accounting::journal-management.account'), array('class' => 'control-label')) !!}
								{!! Form::autocomplete('acct-jm-account', $accounts, array('class' => 'form-control', 'data-mg-required' => ''), 'acct-jm-account', 'acct-jm-account-id', null, 'fa-book') !!}
								{!! Form::hidden('acct-jm-account-id', null, array('id' => 'acct-jm-account-id')) !!}
				  		</div>
						</div>
						<div class="col-lg-6 col-md-6">
							<div class="form-group mg-hm">
								{!! Form::label('acct-jm-debit', Lang::get('decima-accounting::journal-management.debit0'), array('class' => 'control-label')) !!}
								{!! Form::money('acct-jm-debit', array('class' => 'form-control', 'data-mg-required' => '', 'defaultvalue' => Lang::get('form.defaultNumericValue')), Lang::get('form.defaultNumericValue')) !!}
				  		</div>
							<div class="form-group mg-hm">
								{!! Form::label('acct-jm-credit', Lang::get('decima-accounting::journal-management.credit0'), array('class' => 'control-label')) !!}
								{!! Form::money('acct-jm-credit', array('class' => 'form-control', 'data-mg-required' => '', 'defaultvalue' => Lang::get('form.defaultNumericValue')), Lang::get('form.defaultNumericValue')) !!}
				  		</div>
						</div>
					</div>
				</fieldset>
			{!! Form::close() !!}
		</div>
		<div id="acct-jm-btn-journal-entries-toolbar" class="section-header btn-toolbar" role="toolbar">
			<div id="acct-jm-btn-journal-entries-group-1" class="btn-group btn-group-app-toolbar">
				{{--Form::button('<i class="fa fa-plus"></i> ' . Lang::get('toolbar.add'), array('id' => 'acct-jm-btn-journal-entries-add', 'class' => 'btn btn-default acct-jm-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'data-original-title' => Lang::get('decima-accounting::journal-management.add'))) --}}
				{!! Form::button('<i class="fa fa-refresh"></i> ' . Lang::get('toolbar.refresh'), array('id' => 'acct-jm-btn-journal-entries-refresh', 'class' => 'btn btn-default acct-jm-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'data-original-title' => Lang::get('toolbar.refreshLongText'))) !!}
				<div class="btn-group">
					{!! Form::button('<i class="fa fa-share-square-o"></i> ' . Lang::get('toolbar.export') . ' <span class="caret"></span>', array('class' => 'btn btn-default dropdown-toggle', 'data-container' => 'body', 'data-toggle' => 'dropdown')) !!}
					<ul class="dropdown-menu">
         		<li><a id='acct-jm-btn-journal-entries-export-xls' class="fake-link"><i class="fa fa-file-excel-o"></i> xls</a></li>
         		<li><a id='acct-jm-btn-journal-entries-export-csv' class="fake-link"><i class="fa fa-file-text-o"></i> csv</a></li>
       		</ul>
				</div>
			</div>
			<div id="acct-jm-btn-journal-entries-group-2" class="btn-group btn-group-app-toolbar">
				{!! Form::button('<i class="fa fa-edit"></i> ' . Lang::get('toolbar.edit'), array('id' => 'acct-jm-btn-journal-entries-edit', 'class' => 'btn btn-default acct-jm-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'disabled' => '', 'data-original-title' => Lang::get('decima-accounting::journal-management.edit'))) !!}
				{!! Form::button('<i class="fa fa-minus"></i> ' . Lang::get('toolbar.delete'), array('id' => 'acct-jm-btn-journal-entries-delete', 'class' => 'btn btn-default acct-jm-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'disabled' => '', 'data-original-title' => Lang::get('decima-accounting::journal-management.delete'))) !!}
			</div>
			<div id="acct-jm-btn-journal-entries-group-3" class="btn-group btn-group-app-toolbar">
				{!! Form::button('<i class="fa fa-save"></i> ' . Lang::get('toolbar.save'), array('id' => 'acct-jm-btn-journal-entries-save', 'class' => 'btn btn-default acct-jm-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'disabled' => '', 'data-original-title' => Lang::get('decima-accounting::journal-management.save'))) !!}
			</div>
		</div>
		<div id='acct-jm-journal-entries-grid-section' class='app-grid collapse in' data-app-grid-id='acct-jm-journal-entries-grid'>
			{!!
			GridRender::setGridId("acct-jm-journal-entries-grid")
				//->enablefilterToolbar(false, false)
				->hideXlsExporter()
  			->hideCsvExporter()
				->setGridOption('height', 'auto')
				->setGridOption('url',URL::to('accounting/transactions/journal-management/journal-entry-grid-data'))
				//->setGridOption('caption', Lang::get('decima-accounting::journal-management.journalEntriesgridTitle'))
				->setGridOption('filename', Lang::get('decima-accounting::journal-management.journalEntriesgridTitle'))
				->setGridOption('rowNum', 1000)
				->setGridOption('rowList', array(200, 400, 600, 800, 1000))
				->setGridOption('footerrow',true)
				->setGridOption('postData', array('_token' => Session::token(), 'filters'=>"{'groupOp':'AND','rules':[{'field':'je.journal_voucher_id','op':'eq','data':'-1'}]}"))
				->setGridEvent('onSelectRow', 'acctJmJournalEntriesOnSelectRowEvent')
				//->setGridEvent('loadBeforeSend', 'acctJmJournalEntriesOnLoadBeforeSendEvent')
				->setGridEvent('loadComplete', 'acctJmJournalEntriesOnLoadCompleteEvent')
				//->setFilterToolbarEvent('beforeClear','acctJmJournalEntriesBeforeClearEvent')
  			//->setFilterToolbarEvent('afterClear','acctJmJournalEntriesAfterClearEvent')
				->addColumn(array('index' => 'je.id', 'name' => 'journal_entry_id', 'hidden' => true))
				->addColumn(array('index' => 'je.journal_voucher_id', 'name' => 'journal_voucher_id', 'hidden' => true))
				->addColumn(array('index' => 'cc.id', 'name' => 'cost_center_id', 'hidden' => true))
				->addColumn(array('index' => 'c.id', 'name' => 'account_id', 'hidden' => true))
				->addColumn(array('label' => Lang::get('decima-accounting::journal-management.costCenterCod'), 'index' => 'cc.key' ,'name' => 'cost_center_key', 'width' => 80))
				->addColumn(array('label' => Lang::get('decima-accounting::journal-management.costCenterShort'), 'index' => 'cc.name', 'name' => 'cost_center_name'))
				->addColumn(array('label' => Lang::get('decima-accounting::journal-management.accountCod'), 'index' => 'c.key', 'name' => 'account_key' , 'width' => 80))
				->addColumn(array('label' => Lang::get('decima-accounting::journal-management.account'), 'index' => 'c.name', 'name' => 'account_name'))
				->addColumn(array('label' => Lang::get('decima-accounting::journal-management.debit'), 'index' => 'je.debit', 'name' => 'debit', 'formatter' => 'currency', 'align'=>'right', 'width' => 115, 'formatoptions' => array('prefix' => OrganizationManager::getOrganizationCurrencySymbol() . ' ')))
				->addColumn(array('label' => Lang::get('decima-accounting::journal-management.credit'), 'index' => 'je.credit', 'name' => 'credit', 'formatter' => 'currency', 'align'=>'right', 'width' => 115, 'formatoptions' => array('prefix' => OrganizationManager::getOrganizationCurrencySymbol() . ' ')))
				->renderGrid();
			!!}
		</div>
	</div>
</div>
<div id='acct-jm-modal-delete' class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm acct-jm-btn-delete">
    <div class="modal-content">
			<div class="modal-body" style="padding: 20px 20px 0px 20px;">
				<p id="acct-jm-voucher-delete-message" data-default-label="{{ Lang::get('decima-accounting::journal-management.journalVoucherConfirmDeleteMessage') }}"></p>
      </div>
			<div class="modal-footer" style="text-align:center;">
				<button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('form.no') }}</button>
				<button id="acct-jm-btn-modal-delete" type="button" class="btn btn-primary">{{ Lang::get('form.yes') }}</button>
			</div>
    </div>
  </div>
</div>
<div id='acct-jm-modal-periods' class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-sm acct-jm-btn-delete">
    <div class="modal-content">
			<div class="modal-header">
				<h3 class="panel-title"><i class="fa fa-calendar"></i> {{ Lang::get('decima-accounting::journal-management.periodSelectionModalHeader') }}</h3>
			</div>
			<div class="modal-body text-center">
				<button id="acct-jm-btn-period0" type="button" class="btn btn-primary" data-dismiss="modal" data-period-id="">{{ Lang::get('form.no') }}</button>
				<button id="acct-jm-btn-period1" type="button" class="btn btn-primary" data-dismiss="modal" data-period-id="">{{ Lang::get('form.yes') }}</button>
      </div>
			<div class="modal-footer" style="text-align:center;">
			</div>
    </div>
  </div>
</div>
@parent
@stop
