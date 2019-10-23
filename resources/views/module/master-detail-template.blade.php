@extends('layouts.base')

@section('container')
{!! Form::hidden('module-app-new-action', null, array('id' => 'module-app-new-action')) !!}
{!! Form::hidden('module-app-edit-action', null, array('id' => 'module-app-edit-action', 'data-content' => Lang::get('decima-inventory::requisition-management.editHelpText'))) !!}
{!! Form::hidden('module-app-remove-action', null, array('id' => 'module-app-remove-action', 'data-content' => Lang::get('decima-inventory::requisition-management.editHelpText'))) !!}
{!! Form::button('', array('id' => 'module-app-btn-edit-helper', 'class' => 'hidden')) !!}
{!! Form::button('', array('id' => 'module-app-btn-delete-helper', 'class' => 'hidden')) !!}
{!! Form::button('', array('id' => 'module-app-btn-void-helper', 'class' => 'hidden')) !!}
<style>
	#gbox_module-app-grid .ui-th-column-header {
		text-align: left;
		padding-left: 20px;
	}
</style>
<script type="text/javascript">

	function moduleAppDisabledDetailForm()
	{
		$('#module-app-detail-form-fieldset').attr('disabled', 'disabled');
	}

	function moduleAppOnSelectRowEvent()
	{
		var id = $('#module-app-grid').getSelectedRowId('module_app_id'), rowData = $('#module-app-grid').getRowData($('#module-app-grid').jqGrid('getGridParam', 'selrow'));

		if($('#module-app-grid-section').attr('data-id') != id)
		{
			$('#module-app-grid-section').attr('data-id', id);

			// getAppJournals('module-app-', 'firstPage', id);
			// getElementFiles('module-app-', id);

			// $('#module-app-front-detail-grid').jqGrid('setGridParam', {'datatype':'json', 'postData':{"filters":"{'groupOp':'AND','rules':[{'field':'master_id','op':'eq','data':'" + id + "'}]}"}}).trigger('reloadGrid');

			// cleanJournals('module-app-');
			// cleanFiles('module-app-');
		}

		$('#module-app-btn-group-2').enableButtonGroup();

		// if(rowData.module_app_status != 'P')
		// {
		// 	$('#module-app-btn-authorize, #module-app-btn-edit').attr('disabled', 'disabled');
		// }
		//
		// if(rowData.module_app_status == 'A')
		// {
		// 	$('#module-app-btn-void').attr('disabled', 'disabled');
		// }
	}

	function moduleAppDetailOnSelectRowEvent()
	{
		var selRowIds = $('#module-app-back-detail-grid').jqGrid('getGridParam', 'selarrrow');

		if(selRowIds.length == 0)
		{
			$('#module-app-detail-btn-group-2').disabledButtonGroup();
		}
		else if(selRowIds.length == 1)
		{
			$('#module-app-detail-btn-group-2').enableButtonGroup();
		}
		else if(selRowIds.length > 1)
		{
			$('#module-app-detail-btn-group-2').disabledButtonGroup();
			$('#module-app-detail-btn-delete').removeAttr('disabled');
		}
	}

	function moduleAppOnLoadCompleteEvent()
	{
		// $('#module-app-front-detail-grid').jqGrid('clearGridData');
		//
		// $('#module-app-front-detail-grid').jqGrid('footerData','set', {
		// 	'module_app_detail_': 0,
		// });
	}

	function moduleAppDetailOnLoadCompleteEvent()
	{
		// var amount = $(this).jqGrid('getCol', 'module_app_detail_', false, 'sum');
		//
		// $(this).jqGrid('footerData','set', {
		// 	'module_app_detail_name': '{{ Lang::get('form.total') }}',
		// 	'module_app_detail_': amount,
		// });
		//
		// $('#module-app-detail-').val($.fmatter.NumberFormat(amount, $.fn.jqMgVal.defaults.validators.money.formatter));
	}

	$(document).ready(function()
	{
		loadSmtRows('moduleAppSmtRows', $('#module-app-form').attr('action') + '/smt-rows');

		moduleAppDisabledDetailForm();

		$('.module-app-btn-tooltip').tooltip();

		$('#module-app-form, #module-app-detail-form').jqMgVal('addFormFieldsValidations');

		$('#module-app-grid-section').on('hidden.bs.collapse', function ()
		{
			$($('#module-app-journals-section').attr('data-target-id')).collapse('show');
		});

		$('#module-app-form-section').on('hidden.bs.collapse', function ()
		{
			$('#module-app-grid-section').collapse('show');

			$('#module-app-filters').show();
		});

		$('#module-app-form-section').on('shown.bs.collapse', function ()
		{
			// $('#module-app-').focus();
		});

		$('#module-app-').focusout(function()
		{
			$('#module-app-btn-save').focus();
		});

		$('#module-app-btn-new').click(function()
		{
			if($(this).hasAttr('disabled'))
			{
				return;
			}

			$('.decima-erp-tooltip').tooltip('hide');

      $('#module-app-form, #module-app-detail-form').jqMgVal('clearForm');

			$('#module-app-detail-btn-toolbar, #module-app-ot-btn-toolbar, #module-app-btn-toolbar').disabledButtonGroup();

			// $('#module-app-status-label').val($('#module-app-status-label').attr('data-default-value'));
			// $('#module-app-status').val($('#module-app-status').attr('data-default-value'));

			$('#module-app-btn-new, #module-app-btn-edit').removeAttr('disabled');

			$('#module-app-btn-group-3').enableButtonGroup();

			moduleAppDisabledDetailForm();

			if(!$('#module-app-form-section').is(":visible"))
			{
				$('#module-app-journals-section').attr('data-target-id', '#module-app-form-section');

				$('#module-app-grid-section').collapse('hide');
			}
			else
			{
				$('#module-app-detail-master-id').val(-1);

				$('#module-app-back-detail-grid').jqGrid('clearGridData');
			}

			$('#module-app-filters').hide();

			$(this).removeAttr('disabled');

			$('#module-app-form-new-title').removeClass('hidden');

			$('#module-app-form-edit-title').addClass('hidden');
		});

		$('#module-app-btn-refresh').click(function()
		{
			$('.decima-erp-tooltip').tooltip('hide');

			$('#module-app-btn-toolbar').disabledButtonGroup();

			$('#module-app-btn-group-1').enableButtonGroup();

			if($('#module-app-journals-section').attr('data-target-id') == '' || $('#module-app-journals-section').attr('data-target-id') == '#module-app-form-section')
			{
				$('#module-app-grid').trigger('reloadGrid');

				$('#module-app-grid-section').attr('data-id', '');

				cleanJournals('module-app-');
				cleanJournals('module-app-');
			}
			else
			{

			}
		});

		$('#module-app-detail-btn-refresh').click(function()
		{
			$('.decima-erp-tooltip').tooltip('hide');

			$('#module-app-back-detail-grid').jqGrid('setGridParam', {'datatype':'json', 'postData':{"filters":"{'groupOp':'AND','rules':[{'field':'master_id','op':'eq','data':'" + $('#module-app-detail-master-id').val() + "'}]}"}}).trigger('reloadGrid');
		});

		$('#module-app-detail-btn-export-xls').click(function()
		{
			$('#module-app-back-detail-gridXlsButton').click();
		});

		$('#module-app-detail-btn-export-csv').click(function()
		{
			$('#module-app-back-detail-gridCsvButton').click();
		});

		$('#module-app-btn-export-xls').click(function()
		{
			if($('#module-app-journals-section').attr('data-target-id') == '')
			{
				$('#module-app-gridXlsButton').click();
			}
		});

		$('#module-app-btn-export-csv').click(function()
		{
			if($('#module-app-journals-section').attr('data-target-id') == '')
			{
				$('#module-app-gridCsvButton').click();
			}
		});

		$('#module-app-btn-edit').click(function()
		{
			var rowData;

			$('.decima-erp-tooltip').tooltip('hide');

			if($('#module-app-journals-section').attr('data-target-id') == '')
			{
				if(!$('#module-app-grid').isRowSelected())
				{
					$('#module-app-btn-toolbar').showAlertAfterElement('alert-info alert-custom', lang.invalidSelection, 5000);

					return;
				}

				$('#module-app-btn-toolbar').disabledButtonGroup();

				$('#module-app-btn-group-3').enableButtonGroup();

				$('#module-app-btn-new, #module-app-btn-edit, #module-app-btn-upload, #module-app-btn-show-files, #module-app-btn-show-history').removeAttr('disabled');

				$('#module-app-form-edit-title').removeClass('hidden');

				rowData = $('#module-app-grid').getRowData($('#module-app-grid').jqGrid('getGridParam', 'selrow'));

				populateFormFields(rowData);

				$('#module-app-filters').hide();

				$('#module-app-journals-section').attr('data-target-id', '#module-app-form-section');

				$('#module-app-grid-section').collapse('hide');

				$('#module-app-detail-form-fieldset').removeAttr('disabled');

				$('#module-app-id').val(rowData.module_app_id);
				$('#module-app-detail-master-id').val(rowData.module_app_id);

				// $('.module-app-number').html(rowData.module_app_number);

				$('#module-app-detail-btn-refresh').click();

				$('#module-app-detail-btn-toolbar').disabledButtonGroup();

				$('#module-app-detail-btn-group-1').enableButtonGroup();
				$('#module-app-detail-btn-group-3').enableButtonGroup();
			}
			else if($('#module-app-journals-section').attr('data-target-id') == '#module-app-form-section')
			{
				$('#module-app-smt').createTable('module-app-grid', 'moduleAppSmtRows', 10);
				$('#module-app-smt').modal('show');
			}
			else
			{

			}
		});


		$('#module-app-detail-btn-edit').click(function()
		{
			var rowData;

			$('.decima-erp-tooltip').tooltip('hide');

			if(!$('#module-app-back-detail-grid').isRowSelected())
			{
				$('#module-app-detail-btn-toolbar').showAlertAfterElement('alert-info alert-custom', lang.invalidSelection, 5000);
				return;
			}

			$('#module-app-detail-btn-toolbar').disabledButtonGroup();

			$('#module-app-detail-btn-group-3').enableButtonGroup();

			rowData = $('#module-app-back-detail-grid').getRowData($('#module-app-back-detail-grid').jqGrid('getGridParam', 'selrow'));

			populateFormFields(rowData);

			// $('#module-app-detail-label').setAutocompleteLabel(rowData.module_app_detail_id);

			$('#module-app-detail-name').focus();
		});

		$('#module-app-btn-delete').click(function()
		{
			var rowData;

			if($(this).hasAttr('disabled'))
			{
				return;
			}

			$('.decima-erp-tooltip').tooltip('hide');

			if($('#module-app-journals-section').attr('data-target-id') == '')
			{
				if(!$('#module-app-grid').isRowSelected())
				{
					$('#module-app-btn-toolbar').showAlertAfterElement('alert-info alert-custom', lang.invalidSelection, 5000);
					return;
				}

				rowData = $('#module-app-grid').getRowData($('#module-app-grid').jqGrid('getGridParam', 'selrow'));

				// $('#module-app-delete-message').html($('#module-app-delete-message').attr('data-default-label').replace(':name', rowData.name));
			}
			else
			{

			}

			$('#module-app-modal-delete').modal('show');
		});

		$('#module-app-btn-view').click(function()
		{
			var id = $('#module-app-grid').getSelectedRowId('module_app_id');

			$('#module-app-front-detail-grid').jqGrid('setGridParam', {'datatype':'json', 'postData':{"filters":"{'groupOp':'AND','rules':[{'field':'master_id','op':'eq','data':'" + id + "'}]}"}}).trigger('reloadGrid');
		});

		$('#module-app-btn-show-files').click(function()
		{
			var rowData, id;

			if($(this).hasAttr('disabled'))
			{
				return;
			}

			$('.decima-erp-tooltip').tooltip('hide');

			if($('#module-app-grid').is(":visible"))
			{
				if(!$('#module-app-grid').isRowSelected())
				{
					$('#module-app-btn-toolbar').showAlertAfterElement('alert-info alert-custom', lang.invalidSelection, 20000);
					return;
				}

				rowData = $('#module-app-grid').getRowData($('#module-app-grid').jqGrid('getGridParam', 'selrow'));
				id = rowData.module_app_id;
			}
			else
			{
				id = $('#module-app-id').val();
			}

			if($('#module-app-btn-file-modal-delete').attr('data-system-reference-id') != id)
			{
				getElementFiles('module-app-', id);
			}

			$.scrollTo({top: $('#module-app-file-viewer').offset().top - 100, left:0});
		});

		$('#module-app-btn-show-history').click(function()
		{
			var rowData, id;

			if($(this).hasAttr('disabled'))
			{
				return;
			}

			$('.decima-erp-tooltip').tooltip('hide');

			if($('#module-app-grid').is(":visible"))
			{
				if(!$('#module-app-grid').isRowSelected())
				{
					$('#module-app-btn-toolbar').showAlertAfterElement('alert-info alert-custom', lang.invalidSelection, 20000);
					return;
				}

				rowData = $('#module-app-grid').getRowData($('#module-app-grid').jqGrid('getGridParam', 'selrow'));
				id = rowData.module_app_id;
			}
			else
			{
				id = $('#module-app-id').val();
			}

			if($('#module-app-journals').attr('data-journalized-id') != id)
			{
				getAppJournals('module-app-', 'firstPage', id);
			}

			$.scrollTo({top: $('#module-app-journals').offset().top - 100, left:0});
		});

		$('#module-app-btn-modal-delete').click(function()
		{
			var id, url;

			if($('#module-app-journals-section').attr('data-target-id') == '')
			{
			  url = $('#module-app-form').attr('action') + '/delete-master';
			  id = $('#module-app-grid').getSelectedRowId('module_app_id');
			}
			else
			{

			}

			$.ajax(
			{
				type: 'POST',
				data: JSON.stringify(
					{
						'_token':$('#app-token').val(),
						'id': id
					}
				),
				dataType : 'json',
				url:  url,
				error: function (jqXHR, textStatus, errorThrown)
				{
					handleServerExceptions(jqXHR, 'module-app-btn-toolbar', false);
					$('#module-app-modal-delete').modal('hide');
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
						$('#module-app-btn-refresh').click();
						$("#module-app-btn-group-2").disabledButtonGroup();
						$('#module-app-btn-toolbar').showAlertAfterElement('alert-success alert-custom',json.success, 5000);
					}

					if(json.info)
					{
						$('#module-app-btn-refresh').click();
						$("#module-app-btn-group-2").disabledButtonGroup();
						$('#module-app-btn-toolbar').showAlertAfterElement('alert-info alert-custom',json.info, 5000);
					}

					if(!empty(json.smtRowId))
					{
						deleteSmtRow('moduleAppSmtRows', json.smtRowId);
					}

					$('#module-app-modal-delete').modal('hide');

					$('#app-loader').addClass('hidden');
					enableAll();

					$('.decima-erp-tooltip').tooltip('hide');
				}
			});
		});

		$('#module-app-btn-authorize').click(function()
		{
			var rowData;

			if($(this).hasAttr('disabled'))
			{
				return;
			}

			$('.decima-erp-tooltip').tooltip('hide');

			if($('#module-app-journals-section').attr('data-target-id') == '')
			{
				if(!$('#module-app-grid').isRowSelected())
				{
					$('#module-app-btn-toolbar').showAlertAfterElement('alert-info alert-custom', lang.invalidSelection, 5000);

					return;
				}

				rowData = $('#module-app-grid').getRowData($('#module-app-grid').jqGrid('getGridParam', 'selrow'));

				$('#module-app-ma-authorize-message').html($('#module-app-ma-authorize-message').attr('data-default-label').replace(':name', rowData.name));
			}
			else
			{

			}

			$('#module-app-ma').modal('show');
		});

		$('#module-app-ma-btn-authorize').click(function()
		{
			var id, url;

			if($('#module-app-journals-section').attr('data-target-id') == '')
			{
			  url = $('#module-app-form').attr('action') + '/authorize-master';
			  id = $('#module-app-grid').getSelectedRowId('module_app_id');
			}
			else
			{

			}

			$.ajax(
			{
				type: 'POST',
				data: JSON.stringify(
					{
						'_token':$('#app-token').val(),
						'id': id
					}
				),
				dataType : 'json',
				url:  url,
				error: function (jqXHR, textStatus, errorThrown)
				{
					handleServerExceptions(jqXHR, 'module-app-btn-toolbar', false);
					$('#module-app-ma').modal('hide');
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
						$('#module-app-btn-refresh').click();
						$("#module-app-btn-group-2").disabledButtonGroup();
						$('#module-app-btn-toolbar').showAlertAfterElement('alert-success alert-custom',json.success, 5000);
					}

					if(json.info)
					{
						$('#module-app-btn-refresh').click();
						$("#module-app-btn-group-2").disabledButtonGroup();
						$('#module-app-btn-toolbar').showAlertAfterElement('alert-info alert-custom',json.info, 5000);
					}

					if(!empty(json.smtRow))
					{
						updateSmtRow('moduleAppSmtRows', Object.keys(json.smtRow)[0], Object.values(json.smtRow)[0]);
					}

					$('#module-app-ma').modal('hide');

					$('#app-loader').addClass('hidden');
					enableAll();

					$('.decima-erp-tooltip').tooltip('hide');
				}
			});
		});

		$('#module-app-btn-void').click(function()
		{
			var rowData;

			if($(this).hasAttr('disabled'))
			{
				return;
			}

			$('.decima-erp-tooltip').tooltip('hide');

			if($('#module-app-journals-section').attr('data-target-id') == '')
			{
				if(!$('#module-app-grid').isRowSelected())
				{
					$('#module-app-btn-toolbar').showAlertAfterElement('alert-info alert-custom', lang.invalidSelection, 5000);
					return;
				}

				rowData = $('#module-app-grid').getRowData($('#module-app-grid').jqGrid('getGridParam', 'selrow'));

				$('#module-app-mv-void-message').html($('#module-app-mv-void-message').attr('data-default-label').replace(':name', rowData.name));
			}
			else
			{

			}

			$('#module-app-mv').modal('show');
		});

		$('#module-app-mv-btn-void').click(function()
		{
			var id, url;

			if($('#module-app-journals-section').attr('data-target-id') == '')
			{
			  url = $('#module-app-form').attr('action') + '/void-master';
			  id = $('#module-app-grid').getSelectedRowId('module_app_id');
			}
			else
			{

			}

			$.ajax(
			{
				type: 'POST',
				data: JSON.stringify(
					{
						'_token':$('#app-token').val(),
						'id': id
					}
				),
				dataType : 'json',
				url:  url,
				error: function (jqXHR, textStatus, errorThrown)
				{
					handleServerExceptions(jqXHR, 'module-app-btn-toolbar', false);
					$('#module-app-mv').modal('hide');
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
						$('#module-app-btn-refresh').click();
						$("#module-app-btn-group-2").disabledButtonGroup();
						$('#module-app-btn-toolbar').showAlertAfterElement('alert-success alert-custom',json.success, 5000);
					}

					if(json.info)
					{
						$('#module-app-btn-refresh').click();
						$("#module-app-btn-group-2").disabledButtonGroup();
						$('#module-app-btn-toolbar').showAlertAfterElement('alert-info alert-custom',json.info, 5000);
					}

					if(!empty(json.smtRow))
					{
						updateSmtRow('moduleAppSmtRows', Object.keys(json.smtRow)[0], Object.values(json.smtRow)[0]);
					}

					$('#module-app-mv').modal('hide');

					$('#app-loader').addClass('hidden');
					enableAll();

					$('.decima-erp-tooltip').tooltip('hide');
				}
			});
		});

		$('#module-app-detail-btn-delete').click(function()
		{
			var id = $('#module-app-back-detail-grid').getSelectedRowsIdCell('module_app_detail_id');

			if(!$('#module-app-back-detail-grid').isRowSelected())
			{
				$('#module-app-detail-btn-toolbar').showAlertAfterElement('alert-info alert-custom', lang.invalidSelection, 5000);
				return;
			}

			$.ajax(
			{
				type: 'POST',
				data: JSON.stringify(
					{
						'_token':$('#app-token').val(),
						'id': id,
						'detail_id': $('#module-app-detail-id').val()
					}
				),
				dataType : 'json',
				url:  $('#module-app-detail-form').attr('action') + '/delete-details',
				error: function (jqXHR, textStatus, errorThrown)
				{
					handleServerExceptions(jqXHR, 'module-app-detail-btn-toolbar', false);
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
						$('#module-app-detail-btn-refresh').click();
						$("#module-app-detail-btn-group-2").disabledButtonGroup();
						$('#module-app-detail-btn-toolbar').showAlertAfterElement('alert-success alert-custom',json.success, 5000);
					}

					$('#app-loader').addClass('hidden');
					enableAll();
					$('.decima-erp-tooltip').tooltip('hide');
				}
			});
		});

		$('#module-app-btn-save').click(function()
		{
			var url = $('#module-app-form').attr('action'), action = 'new';

			$('.decima-erp-tooltip').tooltip('hide');

			if($('#module-app-journals-section').attr('data-target-id') == '#module-app-form-section')
			{
				if(!$('#module-app-form').jqMgVal('isFormValid'))
				{
					return;
				}

				if($('#module-app-id').isEmpty())
				{
					url = url + '/create-master';
				}
				else
				{
					url = url + '/update-master';
					action = 'edit';
				}

				data = $('#module-app-form').formToObject('module-app-');
			}

			$.ajax(
			{
				type: 'POST',
				data: JSON.stringify(data),
				dataType : 'json',
				url: url,
				error: function (jqXHR, textStatus, errorThrown)
				{
					handleServerExceptions(jqXHR, 'module-app-form');
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
						if($('#module-app-journals-section').attr('data-target-id') == '#module-app-form-section')
						{
							if(action == 'new')
							{
								$('#module-app-id').val(json.id);
								$('#module-app-detail-master-id').val(json.id);
								// $('.module-app-number').html('#' + json.number);
							}

							if(action == 'edit')
							{
								$('#module-app-btn-toolbar').showAlertAfterElement('alert-success alert-custom',json.success, 6000);
							}

							$('#module-app-form-new-title').addClass('hidden');

							$('#module-app-form-edit-title').removeClass('hidden');

							$('#module-app-form').jqMgVal('clearContextualClasses');

							$('#module-app-detail-btn-toolbar').disabledButtonGroup();

							$('#module-app-detail-btn-group-1').enableButtonGroup();
							$('#module-app-detail-btn-group-3').enableButtonGroup();

							$('#module-app-btn-new, #module-app-btn-upload, #module-app-btn-show-files, #module-app-btn-show-history').removeAttr('disabled');
							$('#module-app-detail-form-fieldset').removeAttr('disabled');
						}
						else
						{
							// $('#module-app-btn-toolbar').showAlertAfterElement('alert-success alert-custom',json.success, 6000);
							// $('#module-app-form').showAlertAsFirstChild('alert-success', json.success, 6000)
						}
					}
					else if(json.info)
					{
						if($('#module-app-journals-section').attr('data-target-id') == '#module-app-form-section')
						{
							$('#module-app-form').showAlertAsFirstChild('alert-info', json.info, 12000);
						}
						else
						{
							// $('#module-app-form').showAlertAsFirstChild('alert-info', json.info, 12000);
						}
					}

					if(action == 'new' && !empty(json.smtRow))
					{
						addSmtRow('moduleAppSmtRows', Object.keys(json.smtRow)[0], Object.values(json.smtRow)[0]);
					}

					if(action == 'edit' && !empty(json.smtRow))
					{
						updateSmtRow('moduleAppSmtRows', Object.keys(json.smtRow)[0], Object.values(json.smtRow)[0]);
					}

					$('#app-loader').addClass('hidden');

					enableAll();

					$('.decima-erp-tooltip').tooltip('hide');

					$('#module-app-detail-name').focus();
				}
			});
		});

		$('#module-app-detail-btn-save').click(function()
		{
			var url = $('#module-app-detail-form').attr('action'), action = 'new';

			if(!$('#module-app-detail-form').jqMgVal('isFormValid'))
			{
				return;
			}

			if($('#module-app-detail-id').isEmpty())
			{
				url = url + '/create-detail';
			}
			else
			{
				url = url + '/update-detail';
				action = 'edit';
			}

			$.ajax(
			{
				type: 'POST',
				data: JSON.stringify($('#module-app-detail-form').formToObject('module-app-detail-')),
				dataType : 'json',
				url: url,
				error: function (jqXHR, textStatus, errorThrown)
				{
					handleServerExceptions(jqXHR, 'module-app-detail-form');
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
						$('#module-app-detail-form').jqMgVal('clearForm');
						$('#module-app-detail-btn-toolbar').disabledButtonGroup();
						$('#module-app-detail-btn-group-1').enableButtonGroup();
						$('#module-app-detail-btn-group-3').enableButtonGroup();

						$('#module-app-detail-btn-refresh').click();
					}
					else if(json.info)
					{
							$('#module-app-detail-form').showAlertAsFirstChild('alert-info', json.info);
					}

					$('#app-loader').addClass('hidden');
					enableAll();

					$('.decima-erp-tooltip').tooltip('hide');
					$('#module-app-detail-article-label').focus();
				}
			});
		});

		$('#module-app-btn-close').click(function()
		{
			if($(this).hasAttr('disabled'))
			{
				return;
			}

			$('.decima-erp-tooltip').tooltip('hide');

			if($('#module-app-journals-section').attr('data-target-id') == '#module-app-form-section')
			{
				$('#module-app-form-new-title').addClass('hidden');
				$('#module-app-form-edit-title').addClass('hidden');
				$('#module-app-btn-refresh').click();
				$('#module-app-detail-master-id').val(-1);

				$('#module-app-back-detail-grid').jqGrid('clearGridData');

				$('#module-app-form, #module-app-detail-form').jqMgVal('clearForm');
				$('#module-app-form-section').collapse('hide');
			}
			else
			{

			}

			$('#module-app-finished-goods-warehouse-ids').clearTags();

			$('#module-app-btn-group-1').enableButtonGroup();

			$('#module-app-btn-group-3').disabledButtonGroup();

			$('#module-app-journals-section').attr('data-target-id', '');

			moduleAppDisabledDetailForm();
		});

		$('#module-app-btn-clear-filter').click(function()
		{
			$('#module-app-filters-form').find('.tokenfield').find('.close').click();

			$('#module-app-filters-form').jqMgVal('clearForm');

			$('#module-app-btn-filter').click();
		});

		$('#module-app-btn-filter').click(function()
		{
			var filters = [];

			$(this).removeClass('btn-default').addClass('btn-warning');

			if(!$('#module-app-filters-form').jqMgVal('isFormValid'))
			{
				return;
			}

			$('#module-app-filters-form').jqMgVal('clearContextualClasses');

			if(!$('#module-app-name-filter').isEmpty())
			{
				filters.push({'field':'b.name', 'op':'in', 'data': $('#module-app-name-filter').val()});
			}

			if(!$('#module-app-name-filter').isEmpty())
			{
				filters.push({'field':'m.name', 'op':'in', 'data': $('#module-app-name-filter').val()});
			}

			if(filters.length == 0)
			{
			  $('#module-app-btn-filter').removeClass('btn-warning').addClass('btn-default');
			}

			$('#module-app-grid').jqGrid('setGridParam', {'postData':{'datatype':'json', "filters":"{'groupOp':'AND','rules':" + JSON.stringify(filters) + "}"}}).trigger('reloadGrid');
		});

		$('#module-app-smt-btn-select').click(function()
		{
			var rowData = $('#module-app-smt').getSelectedSmtRow();

			if(empty(rowData))
			{
				return;
			}

			$('#module-app-btn-new').click();

			populateFormFields(rowData);

			$('#module-app-smt').modal('hide');

			$('#module-app-detail-form-fieldset').removeAttr('disabled');

			$('#module-app-id').val(rowData.module_app_id);
			$('#module-app-detail-master-id').val(rowData.module_app_id);

			// $('.module-app-number').html(rowData.module_app_number);

			$('#module-app-detail-btn-refresh').click();

			$('#module-app-detail-btn-toolbar').disabledButtonGroup();

			$('#module-app-detail-btn-group-1').enableButtonGroup();
			$('#module-app-detail-btn-group-3').enableButtonGroup();
		});

		$('#module-app-smt-btn-refresh').click(function()
		{
			loadSmtRows('moduleAppSmtRows', $('#module-app-form').attr('action') + '/smt-rows', '', true, true);
		});

		if(!$('#module-app-new-action').isEmpty())
		{
			$('#module-app-btn-new').click();
		}

		$('#module-app-btn-edit-helper').click(function()
		{
			showButtonHelper('module-app-btn-close', 'module-app-btn-group-2', $('#module-app-edit-action').attr('data-content'));
		});

		if(!$('#module-app-edit-action').isEmpty())
		{
			showButtonHelper('module-app-btn-close', 'module-app-btn-group-2', $('#module-app-edit-action').attr('data-content'));
		}

		$('#module-app-btn-delete-helper').click(function()
	  {
			showButtonHelper('module-app-btn-close', 'module-app-btn-group-2', $('#module-app-delete-action').attr('data-content'));
	  });

		if(!$('#module-app-delete-action').isEmpty())
		{
			showButtonHelper('module-app-btn-close', 'module-app-btn-group-2', $('#module-app-delete-action').attr('data-content'));
		}
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
					{!! Form::button('<i class="fa fa-filter"></i> ' . Lang::get('form.filterButton'), array('id' => 'module-app-btn-filter', 'class' => 'btn btn-default btn-sm pull-right btn-filter-left-margin')) !!}
					{!! Form::button('<i class="fa fa-eraser"></i> ' . Lang::get('form.clearFilterButton'), array('id' => 'module-app-btn-clear-filter', 'class' => 'btn btn-default btn-sm pull-right')) !!}
				</div>
				<div id="module-app-filters-body" class="panel-body">
					<div class="row">
						<div class="col-lg-6 col-md-12">
							<div class="form-group">
								{!! Form::label('module-app-name-filter', Lang::get('module::app.name'), array('class' => 'col-sm-2 control-label')) !!}
								<div class="col-sm-10 mg-hm">
									{!! Form::autocomplete('module-app-name-filter', array(), array('class' => 'form-control'), 'module-app-name-filter', 'module-app-name-id-filter', null, 'fa-files-o', '', 20) !!}
									{!! Form::hidden('module-app-name-id-filter', null, array('id' => 'module-app-name-id-filter')) !!}
									<p class="help-block">{{ Lang::get('module::app.nameHelperText') }}</p>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12">
							<div class="form-group">
								{!! Form::label('module-app-name-filter', Lang::get('module::app.model'), array('class' => 'col-sm-2 control-label')) !!}
								<div class="col-sm-10 mg-hm">
									{!! Form::autocomplete('module-app-name-filter', array(), array('class' => 'form-control'), 'module-app-name-filter', 'module-app-name-id-filter', null, 'fa-files-o', '', 20) !!}
									{!! Form::hidden('module-app-name-id-filter', null, array('id' => 'module-app-name-id-filter')) !!}
									<p class="help-block">{{ Lang::get('module::app.modelHelperText') }}</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		{!! Form::close() !!}
		<div id="module-app-btn-toolbar" class="section-header btn-toolbar" role="toolbar">
			<div id="module-app-btn-group-1" class="btn-group btn-group-app-toolbar">
				{!! Form::button('<i class="fa fa-plus"></i> ' . Lang::get('toolbar.new'), array('id' => 'module-app-btn-new', 'class' => 'btn btn-default module-app-btn-tooltip decima-erp-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'data-original-title' => Lang::get('module::app.newMaster'))) !!}
				{!! Form::button('<i class="fa fa-refresh"></i> ' . Lang::get('toolbar.refresh'), array('id' => 'module-app-btn-refresh', 'class' => 'btn btn-default module-app-btn-tooltip decima-erp-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'data-original-title' => Lang::get('toolbar.refreshLongText'))) !!}
				<div class="btn-group">
					{!! Form::button('<i class="fa fa-share-square-o"></i> ' . Lang::get('toolbar.export') . ' <span class="caret"></span>', array('class' => 'btn btn-default dropdown-toggle', 'data-container' => 'body', 'data-toggle' => 'dropdown')) !!}
					<ul class="dropdown-menu">
     				<li><a id='module-app-btn-export-xls' class="fake-link"><i class="fa fa-file-excel-o"></i> {{ Lang::get('decima-accounting::journal-management.standardSpreadsheet') . ' (' . Lang::get('form.spreadsheet') . ')' }}</a></li>
       		</ul>
				</div>
			</div>
			<div id="module-app-btn-group-2" class="btn-group btn-group-app-toolbar">
				{!! Form::button('<i class="fa fa-edit"></i> ' . Lang::get('toolbar.edit'), array('id' => 'module-app-btn-edit', 'class' => 'btn btn-default module-app-btn-tooltip decima-erp-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'disabled' => '', 'data-original-title' => Lang::get('module::app.editMaster'))) !!}
				{!! Form::button('<i class="fa fa-check"></i> ' . Lang::get('toolbar.authorize'), array('id' => 'module-app-btn-authorize', 'class' => 'btn btn-default module-app-btn-tooltip decima-erp-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'disabled' => '', 'data-original-title' => Lang::get('module::app.authorizeMaster'))) !!}
				{!! Form::button('<i class="fa fa-ban"></i> ' . Lang::get('toolbar.nulify'), array('id' => 'module-app-btn-void', 'class' => 'btn btn-default module-app-btn-tooltip decima-erp-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'disabled' => '', 'data-original-title' => Lang::get('module::app.voidMaster'))) !!}
				<!-- {!! Form::button('<i class="fa fa-minus"></i> ' . Lang::get('toolbar.delete'), array('id' => 'module-app-btn-delete', 'class' => 'btn btn-default module-app-btn-tooltip decima-erp-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'disabled' => '', 'data-original-title' => Lang::get('module::app.deleteMaster'))) !!} -->
			</div>
			<div id="module-app-btn-group-4" class="btn-group btn-group-app-toolbar">
				{!! Form::button('<i class="fa fa-eye"></i> ', array('id' => 'module-app-btn-view', 'class' => 'btn btn-default module-app-btn-tooltip decima-erp-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'disabled' => '', 'data-original-title' => Lang::get('toolbar.viewLongText'))) !!}
				<!-- {!! Form::button('<i class="fa fa-upload"></i> ', array('id' => 'module-app-btn-upload', 'class' => 'btn btn-default module-app-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'disabled' => '', 'data-folder' => Lang::get('module::app.folder'), 'data-original-title' => Lang::get('toolbar.uploadLongText'))) !!} -->
				<!-- {!! Form::button('<i class="fa fa-files-o"></i> ', array('id' => 'module-app-btn-show-files', 'class' => 'btn btn-default module-app-btn-tooltip decima-erp-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'disabled' => '', 'data-original-title' => Lang::get('toolbar.showFilesLongText'))) !!} -->
				{!! Form::button('<i class="fa fa-history"></i> ', array('id' => 'module-app-btn-show-history', 'class' => 'btn btn-default module-app-btn-tooltip decima-erp-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'disabled' => '', 'data-original-title' => Lang::get('toolbar.showHistoryLongText'))) !!}
			</div>
			<div id="module-app-btn-group-3" class="btn-group btn-group-app-toolbar">
				{!! Form::button('<i class="fa fa-save"></i> ' . Lang::get('toolbar.save'), array('id' => 'module-app-btn-save', 'class' => 'btn btn-default module-app-btn-tooltip decima-erp-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'disabled' => '', 'data-original-title' => Lang::get('module::app.saveMaster'))) !!}
				{!! Form::button('<i class="fa fa-undo"></i> ' . Lang::get('toolbar.close'), array('id' => 'module-app-btn-close', 'class' => 'btn btn-default module-app-btn-tooltip decima-erp-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'disabled' => '', 'data-original-title' => Lang::get('toolbar.closeLongText'))) !!}
			</div>
		</div>
		<div id='module-app-grid-section' class='collapse in' data-id=''>
			<div class='app-grid' data-app-grid-id='module-app-grid'>
				{!!
				GridRender::setGridId('module-app-grid')
					->hideXlsExporter()
	  			->hideCsvExporter()
					->setGridOption('height', 'auto')
					->setGridOption('multiselect', false)
					->setGridOption('rowNum', 5)
					->setGridOption('rowList', array(5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 100, 250, 500, 750, 1000, 2500, 5000))
		    	->setGridOption('url', URL::to('module/category/app/grid-data-master'))
		    	->setGridOption('caption', Lang::get('module::app.gridMasterTitle'))
					->setGridOption('filename', Lang::get('module::app.gridMasterTitle'))
		    	->setGridOption('postData', array('_token' => Session::token()))
					->setGridOption('grouping', true)
					->setGridOption('groupingView', array('groupField' => array('module_app_header'), 'groupColumnShow' => array(false), 'groupSummary' => array(true), 'showSummaryOnHide' => true, 'groupOrder' => array('asc')))
					->setGridEvent('loadComplete', 'moduleAppOnLoadCompleteEvent')
					->setGridEvent('onSelectRow', 'moduleAppOnSelectRowEvent')
					//->addGroupHeader(array('startColumnName' => 'module_app_name', 'numberOfColumns' => 1, 'titleText' => Lang::get('module::app.gridHeader')))
					->addColumn(array('index' => 'module_app_header'))
					->addColumn(array('index' => 'id', 'name' => 'module_app_id', 'hidden' => true))
		    	->addColumn(array('label' => Lang::get('form.name'), 'index' => 'name' ,'name' => 'module_app_name', 'modalwidth' => '10%'))
					//->addColumn(array('label' => Lang::get('form.status'), 'index' => 'status', 'name' => 'module_app_status', 'formatter' => 'select', 'editoptions' => array('value' => Lang::get('form.statusGridText')), 'align' => 'center', 'hidden' => false, 'stype' => 'select', 'width' => 80, 'modalwidth' => '15%'))
					->addColumn(array('label' => Lang::get('form.status'), 'index' => 'status', 'name' => 'module_app_status', 'formatter' => 'select', 'editoptions' => array('value' => Lang::get('module::app.statusGridText')), 'align' => 'center', 'hidden' => false, 'stype' => 'select', 'modalwidth' => '15%'))
					->addColumn(array('label' => Lang::get('form.active'), 'index' => 'is_active' ,'name' => 'module_app_is_active', 'formatter' => 'select', 'editoptions' => array('value' => Lang::get('form.booleanText')), 'align' => 'center' , 'stype' => 'select', 'width' => 70, 'modalwidth' => '15%'))
					->addColumn(array('label' => Lang::get('module::app.money'), 'index' => 'money', 'name' => 'money', 'formatter' => 'currency', 'formatoptions' => array('prefix' => OrganizationManager::getOrganizationCurrencySymbol() . ' '), 'align'=>'right', 'hidden' => false, 'width' => 100, 'modalwidth' => '15%'))
		    	->renderGrid();
				!!}
			</div>
			<div class='app-grid app-grid-without-toolbar section-block' data-app-grid-id='module-app-front-detail-grid'>
				{!!
				GridRender::setGridId('module-app-front-detail-grid')
					->hideXlsExporter()
					->hideCsvExporter()
					->setGridOption('url',URL::to('module/category/app/grid-data-detail'))
					->setGridOption('datatype', 'local')
					->setGridOption('filename', Lang::get('module::app.gridDetailTitle'))
					->setGridOption('rowList', array())
					->setGridOption('rowNum', 100000)
					->setGridOption('footerrow', true)
					->setGridOption('multiselect', false)
					//->setGridOption('postData',array('_token' => Session::token()))
					->setGridOption('postData', array('_token' => Session::token(), 'filters'=>"{'groupOp':'AND','rules':[{'field':'master_id','op':'eq','data':'-1'}]}"))
					//->setGridEvent('loadComplete', 'moduleAppDetailOnLoadCompleteEvent')
					->addColumn(array('index' => 'id', 'name' => 'module_app_detail_id', 'hidden' => true))
					->addColumn(array('label' => Lang::get('form.name'), 'index' => 'detail_name', 'name' => 'module_app_detail_name'))
					->renderGrid();
				!!}
			</div>
		</div>
	</div>
</div>
<div id='module-app-form-section' class="row collapse">
	<div class="col-lg-12 col-md-12">
		<div class="form-container form-container-followed-by-grid-section">
			{!! Form::open(array('id' => 'module-app-form', 'url' => URL::to('module/category/app'), 'role' => 'form', 'onsubmit' => 'return false;')) !!}
				<legend id="module-app-form-new-title" class="hidden">{{ Lang::get('module::app.formNewTitle') }}</legend>
				<legend id="module-app-form-edit-title" class="hidden">{{ Lang::get('module::app.formEditTitle') }}<label class="pull-right module-app-number"></label></legend>
				<div class="row">
					<div class="col-md-6 form-division-line">
						<div class="form-group mg-hm">
							{!! Form::label('module-app-name', Lang::get('form.name'), array('class' => 'control-label')) !!}
					    {!! Form::text('module-app-name', null , array('id' => 'module-app-name', 'class' => 'form-control', 'data-mg-required' => '')) !!}
					    {!! Form::hidden('module-app-id', null, array('id' => 'module-app-id')) !!}
			  		</div>
					</div>
					<div class="col-md-6">
						<div class="form-group mg-hm">
							{!! Form::label('module-app-phone-number', Lang::get('module::app.phoneNumber'), array('class' => 'control-label')) !!}
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-phone"></i>
								</span>
					    	{!! Form::text('module-app-phone-number', null , array('id' => 'module-app-phone-number', 'class' => 'form-control')) !!}
					    </div>
			  		</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group mg-hm" style="margin-bottom: 0 !important;">
									{!! Form::label('module-app-manual-reference', Lang::get('decima-inventory::movement-management.manualReference'), array('class' => 'control-label')) !!}
									{!! Form::text('module-app-manual-reference', null , array('id' => 'module-app-manual-reference', 'class' => 'form-control')) !!}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group mg-hm" style="margin-bottom: 0 !important;">
									{!! Form::label('module-app-status-label', Lang::get('form.status'), array('class' => 'control-label')) !!}
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-exclamation-triangle"></i></span>
										{!! Form::text('module-app-status-label', Lang::get('form.P') , array('id' => 'module-app-status-label', 'class' => 'form-control', 'disabled' => '', 'data-label-U' => Lang::get('form.U'), 'data-label-A' => Lang::get('form.A'), 'data-label-P' => Lang::get('form.P'), 'data-default-value' => Lang::get('form.P'))) !!}
									</div>
									{!! Form::hidden('module-app-status', 'P', array('id' => 'module-app-status', 'data-default-value' => 'P')) !!}
					  		</div>
							</div>
							<div class="col-md-12">
								<p class="help-block">{{ Lang::get('decima-inventory::movement-management.statusHelperText') }}</p>
							</div>
						</div>
					</div>
				</div>
			{!! Form::close() !!}
			{!! Form::open(array('id' => 'module-app-detail-form', 'url' => URL::to('module/category/app'), 'role' => 'form', 'onsubmit' => 'return false;')) !!}
			<fieldset id="module-app-detail-form-fieldset" disabled="disabled">
				<legend id="module-app-detail-model-form-new-title" class="">{{ Lang::get('module::app.formDetailTitle') }}</legend>
				<div class="row">
					<div class="col-md-6">
	          <div class="form-group mg-hm">
							{!! Form::label('module-app-detail-name', Lang::get('form.name'), array('class' => 'control-label')) !!}
							{!! Form::text('module-app-detail-name', null , array('id' => 'module-app-detail-name', 'class' => 'form-control', 'data-mg-required' => '')) !!}
							{!! Form::hidden('module-app-detail-master-id', null, array('id' => 'module-app-detail-master-id', 'data-mg-clear-ignored' => '')) !!}
							{!! Form::hidden('module-app-detail-id', null, array('id' => 'module-app-detail-id')) !!}
	          </div>
					</div>
					<div class="col-md-6">

					</div>
				</div>
			</fieldset>
		{!! Form::close() !!}
		</div>
		<div id="module-app-detail-btn-toolbar" class="section-header btn-toolbar toolbar-preceded-by-form-section" role="toolbar" disabled="disabled">
			<div id="module-app-detail-btn-group-3" class="btn-group btn-group-app-toolbar">
				{!! Form::button('<i class="fa fa-save"></i> ' . Lang::get('toolbar.save'), array('id' => 'module-app-detail-btn-save', 'class' => 'btn btn-default module-app-btn-tooltip decima-erp-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'disabled' => 'false', 'data-original-title' => Lang::get('module::app.saveDetail'))) !!}
			</div>
			<div id="module-app-detail-btn-group-1" class="btn-group btn-group-app-toolbar">
				{!! Form::button('<i class="fa fa-refresh"></i> ' . Lang::get('toolbar.refresh'), array('id' => 'module-app-detail-btn-refresh', 'class' => 'btn btn-default module-app-btn-tooltip decima-erp-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'data-original-title' => Lang::get('toolbar.refreshLongText'))) !!}
				<div class="btn-group">
					{!! Form::button('<i class="fa fa-share-square-o"></i> ' . Lang::get('toolbar.export') . ' <span class="caret"></span>', array('class' => 'btn btn-default dropdown-toggle', 'data-container' => 'body', 'data-toggle' => 'dropdown')) !!}
					<ul class="dropdown-menu">
						<li><a id='module-app-detail-btn-export-xls' class="fake-link"><i class="fa fa-file-excel-o"></i> xls</a></li>
						<li><a id='module-app-detail-btn-export-csv' class="fake-link"><i class="fa fa-file-text-o"></i> csv</a></li>
					</ul>
				</div>
			</div>
			<div id="module-app-detail-btn-group-2" class="btn-group btn-group-app-toolbar">
				{!! Form::button('<i class="fa fa-edit"></i> ' . Lang::get('toolbar.edit'), array('id' => 'module-app-detail-btn-edit', 'class' => 'btn btn-default module-app-detail-btn-tooltip decima-erp-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'disabled' => '', 'data-original-title' => Lang::get('module::app.editDetail'))) !!}
				{!! Form::button('<i class="fa fa-minus"></i> ' . Lang::get('toolbar.delete'), array('id' => 'module-app-detail-btn-delete', 'class' => 'btn btn-default module-app-btn-tooltip decima-erp-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'disabled' => '', 'data-original-title' => Lang::get('module::app.deleteDetail'))) !!}
			</div>
		</div>
		<div id='module-app-back-detail-grid-section' class='app-grid collapse in' data-app-grid-id='module-app-back-detail-grid'>
			{!!
			GridRender::setGridId('module-app-back-detail-grid')
				->hideXlsExporter()
				->hideCsvExporter()
				->setGridOption('url',URL::to('module/category/app/grid-data-detail'))
				->setGridOption('datatype', 'local')
				->setGridOption('filename', Lang::get('module::app.gridDetailTitle'))
				->setGridOption('rowList', array())
				->setGridOption('rowNum', 100000)
				->setGridOption('footerrow',true)
				->setGridOption('multiselect', true)
				//->setGridOption('postData',array('_token' => Session::token()))
				->setGridOption('postData', array('_token' => Session::token(), 'filters'=>"{'groupOp':'AND','rules':[{'field':'master_id','op':'eq','data':'-1'}]}"))
				->setGridEvent('onSelectRow', 'moduleAppDetailOnSelectRowEvent')
				//->setGridEvent('loadComplete', 'moduleAppDetailOnLoadCompleteEvent')
				->addColumn(array('index' => 'id', 'name' => 'module_app_detail_id', 'hidden' => true))
				->addColumn(array('label' => Lang::get('form.name'), 'index' => 'detail_name', 'name' => 'module_app_detail_name'))
				->renderGrid();
			!!}
		</div>
	</div>
</div>
@include('decima-file::file-viewer')
<div id='module-app-journals-section' class="row collapse in section-block" data-target-id="">
	{!! Form::journals($prefix, $appInfo['id']) !!}
</div>
@include('decima-file::file-uploader')
@include('layouts.search-modal-table')
<div id='module-app-modal-delete' class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm module-app-btn-delete">
    <div class="modal-content">
			<div class="modal-body" style="padding: 20px 20px 0px 20px;">
				<p id="module-app-delete-message" data-default-label="{{ Lang::get('form.deleteMessageConfirmation') }}"></p>
				 <!-- <p id="module-app-delete-message" data-default-label="{{ Lang::get('module::app.deleteMessageConfirmation') }}"></p> -->
      </div>
			<div class="modal-footer" style="text-align:center;">
				<button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('form.no') }}</button>
				<button id="module-app-btn-modal-delete" type="button" class="btn btn-primary">{{ Lang::get('form.yes') }}</button>
			</div>
    </div>
  </div>
</div>
<div id='module-app-ma' class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm module-app-btn-authorize">
    <div class="modal-content">
			<div class="modal-body" style="padding: 20px 20px 0px 20px;">
				<!-- <p id="module-app-ma-authorize-message" data-default-label="{{ Lang::get('form.voidMessageConfirmation') }}"></p> -->
				 <p id="module-app-ma-authorize-message" data-default-label="{{ Lang::get('module::app.authorizedMessageConfirmation') }}"></p>
      </div>
			<div class="modal-footer" style="text-align:center;">
				<button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('form.no') }}</button>
				<button id="module-app-ma-btn-authorize" type="button" class="btn btn-primary">{{ Lang::get('form.yes') }}</button>
			</div>
    </div>
  </div>
</div>
<div id='module-app-mv' class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm module-app-btn-void">
    <div class="modal-content">
			<div class="modal-body" style="padding: 20px 20px 0px 20px;">
				<!-- <p id="module-app-mv-void-message" data-default-label="{{ Lang::get('form.voidMessageConfirmation') }}"></p> -->
				 <p id="module-app-mv-void-message" data-default-label="{{ Lang::get('module::app.voidMessageConfirmation') }}"></p>
      </div>
			<div class="modal-footer" style="text-align:center;">
				<button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('form.no') }}</button>
				<button id="module-app-mv-btn-void" type="button" class="btn btn-primary">{{ Lang::get('form.yes') }}</button>
			</div>
    </div>
  </div>
</div>
@parent
@stop
