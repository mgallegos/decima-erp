/**
 * @file
 * Organization Management JavaScript resources.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

function omOnSelectRowEvent(id)
{
	var selRowIds = $('#organizations-grid').jqGrid('getGridParam', 'selarrrow');

	if(selRowIds.length == 0)
	{
		$('#om-btn-group-2').disabledButtonGroup();
		cleanJournals('om-');
	}
	else if(selRowIds.length == 1)
	{
		$('#om-btn-group-2').enableButtonGroup();
		cleanJournals('om-');
		getAppJournals('om-','firstPage', $('#organizations-grid').getSelectedRowId());
	}
	else if(selRowIds.length > 1)
	{
		$('#om-btn-group-2').disabledButtonGroup();
		$('#om-btn-delete').removeAttr('disabled');
		cleanJournals('om-');
	}
}

function createOrganizationsMenu(currentUserOrganization, userOrganizations, organizationMenuLang)
{
	var html = organizations = '';

	$.each(userOrganizations, function(index, element)
	{
		if(element.id == currentUserOrganization)
		{
			organizations += '<li class="active"><a class="fake-link"><i class="fa fa-building-o"></i> ' + element.name + '</a></li>';
		}
		else
		{
			organizations += '<li><a class="fake-link" onclick="changeLoggedUserOrganization(\'' + element.id +'\')"><i class="fa fa-building-o"></i> ' + element.name + '</a></li>';
		}

	});

	html = '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-sitemap"></i> ' + organizationMenuLang + '<b class="caret"></b></a>';
	html += '<ul class="dropdown-menu">' + organizations +'</ul>';

	$('#user-organizations-dropdown-menu').html(html);
}

$(document).ready(function()
{
	$('#om-organization-form').jqMgVal('addFormFieldsValidations');
	$('.om-btn-tooltip').tooltip();

	$('#om-admin-section').on('hidden.bs.collapse', function ()
	{
		$('#om-form-section').collapse('show');
	});

	$('#om-form-section').on('hidden.bs.collapse', function ()
	{
		$('#om-grid-section').collapse('show');

		$('#om-admin-section').collapse('show');
	});

	$('#om-btn-new').click(function()
	{
		if($(this).hasAttr('disabled'))
		{
			return;
		}

		$('#om-btn-toolbar').disabledButtonGroup();
		$('#om-btn-group-3').enableButtonGroup();
		$('#om-database-connection-name').parent().addClass('has-success');
		$('#om-database-connection-name').val('default');
		$('#om-database').removeAttr('disabled');
		$('#om-form-new-title').removeClass('hidden');
		$('#om-form-add-database-help-block').removeClass('hidden');
		$('#om-form-add-database-connection-name-help-block').removeClass('hidden');
		$('#om-grid-section').collapse('hide');
		$('#om-admin-section').collapse('hide');
		$('#om-name').focus();
		$('.om-btn-tooltip').tooltip('hide');
	});

	$('#om-btn-refresh').click(function()
	{
		$('#organizations-grid')[0].clearToolbar();
		$('#om-btn-toolbar').disabledButtonGroup();
		$('#om-btn-group-1').enableButtonGroup();
		cleanJournals('om-');
	});

	$('#om-btn-export-xls').click(function()
	{
			$('#organizations-gridXlsButton').click();
	});

	$('#om-btn-export-csv').click(function()
	{
			$('#organizations-gridCsvButton').click();
	});

	$('#om-btn-edit').click(function()
	{
		var rowData, rowId;

		rowId = $('#organizations-grid').jqGrid('getGridParam', 'selrow');

		if(!$('#organizations-grid').isRowSelected())
		{
			$('#om-btn-toolbar').showAlertAfterElement('alert-info alert-custom', lang.invalidSelection, 5000);
			return;
		}

		$('#om-btn-toolbar').disabledButtonGroup();
		$('#om-btn-group-3').enableButtonGroup();
		$('#om-form-edit-title').removeClass('hidden');

		rowData = $('#organizations-grid').getRowData(rowId);

		populateFormFields(rowData, 'om-');

		$('#om-currency').val(rowData['currency'] + ' (' + rowData['symbol'] + ')');

		if($('#om-database-connection-name').val() != 'default')
		{
			$('#om-database').prop('checked', true);
		}

		$('#om-grid-section').collapse('hide');
		$('#om-admin-section').collapse('hide');
		$('#om-name').focus();
		$('.om-btn-tooltip').tooltip('hide');
	});

	$('#om-btn-close').click(function()
	{
		if($(this).hasAttr('disabled'))
		{
			return;
		}

		$('#om-btn-group-1').enableButtonGroup();
		$('#om-btn-group-3').disabledButtonGroup();
		$('#om-form-section').collapse('hide');
		$('#om-form-new-title').addClass('hidden');
		$('#om-form-edit-title').addClass('hidden');
		$('#om-form-add-database-help-block').addClass('hidden');
		$('#om-form-add-database-connection-name-help-block').addClass('hidden');
		$('#om-database').attr('disabled', 'disabled');
		$('#om-database-connection-name').attr('disabled', 'disabled');
		omOnSelectRowEvent($('#organizations-grid').jqGrid('getGridParam', 'selrow'));
		$('#om-organization-form').jqMgVal('clearForm');
		$('.om-btn-tooltip').tooltip('hide');
	});


	$('#om-btn-save').click(function()
	{
		var url = $('#om-organization-form').attr('action'), action = 'new';

		if(!$('#om-organization-form').jqMgVal('isFormValid'))
		{
			return;
		}

		if($('#om-id').isEmpty())
		{
			url = url + '/store-organization';
		}
		else
		{
			url = url + '/update-organization';
			action = 'edit';
		}

		$.ajax(
		{
			type: 'POST',
			data: JSON.stringify($('#om-organization-form').formToObject('om-')),
			dataType : 'json',
			url: url,
			error: function (jqXHR, textStatus, errorThrown)
			{
				handleServerExceptions(jqXHR, 'om-organization-form');
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
					if(action == 'new')
					{
						$('#om-btn-close').click();
						$('#organizations-grid').reloadAfterRowInserted();
					}
					else
					{
						$('#organizations-grid').setRowData($('#organizations-grid').jqGrid('getGridParam', 'selrow'), $('#om-organization-form').formToObject('om-'));
						//createOrganizationsMenu(json.currentUserOrganization, json.userOrganizationsUpdated, json.organizationMenuLang);
						$('.breadcrumb-organization-name').html(json.organizationName);
						$('#om-btn-close').click();
					}

					if(json.recommendation)
					{
						$('#om-organization-welcome-alert').remove();
						$('#om-btn-toolbar').showAlertAfterElement('alert-success alert-custom', json.success);
					}
					else
					{
						$('#om-btn-toolbar').showAlertAfterElement('alert-success alert-custom', json.success, 8000);
					}

					$('#om-organization-form-alert').remove();
				}
				else if(json.info)
				{
					$('#om-organization-form').showAlertAsFirstChild('alert-info', json.info);
				}
				else
				{
					$('#om-organization-form').showAlertAsFirstChild('alert-danger', json.failure, 7000);
				}

				if(json.userApps)
				{
					window.scrollTo(0, 0);
					$('#user-apps-content').buildUserApps(json.userApps);
					$('#search-action').autocomplete( "option", "source", json.userActions);
					setCurrentApp();
					$('.breadcrumb-organization-name').html(json.organizationName);
					$('#user-apps-content').collapse('show');
					$('#search-action').removeAttr('disabled');
					// $('#apps-tabs-content').children('.active').children('.breadcrumb-organization-name').popover('show');
					startIntro();
				}

				if(json.userOrganizations)
				{
					createOrganizationsMenu(json.currentUserOrganization, json.userOrganizations, json.organizationMenuLang);
				}

				if(json.organizationMenuTooltip)
				{
					window.scrollTo(0, 0);
					// $('#user-organizations-dropdown-menu').popover('show');
					showOrganizationHint();
					$('#search-action-container').removeClass('col-lg-4 col-md-3').addClass('col-lg-3 col-md-2');
				}

				if(json.organizationsAutocomplete)
				{
					$("#change-to-organization-name").autocomplete("option", "source", json.organizationsAutocomplete);
				}

				$('#app-loader').addClass('hidden');
				enableAll();
			}
		});
	});

	$('#om-btn-delete').click(function()
	{
		var rowData;

		if($(this).hasAttr('disabled'))
		{
			return;
		}

		if(!$('#organizations-grid').isRowSelected())
		{
			$('#om-btn-toolbar').showAlertAfterElement('alert-info alert-custom', lang.invalidSelection, 5000);
			return;
		}

		rowData = $('#organizations-grid').getRowData($('#organizations-grid').jqGrid('getGridParam', 'selrow'));

		$('#om-delete-message').html($('#om-delete-message').attr('data-default-label').replace(':organization', rowData.name));

		$('#om-modal-delete').modal('show');
	});

	$('#om-btn-modal-delete').click(function()
	{
		var idArray = $('#organizations-grid').getSelectedRowsIdCell();

		if(idArray.length == 0)
		{
			return;
		}

		token = $('#app-token').val();

		$.ajax(
		{
			type: 'POST',
			data: JSON.stringify({'_token':token, 'id':idArray}),
			dataType : 'json',
			url:  $('#om-organization-form').attr('action') + '/delete-organization',
			error: function (jqXHR, textStatus, errorThrown)
			{
				handleServerExceptions(jqXHR, 'om-btn-toolbar', false);
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
					$('#om-btn-refresh').click();
					$('#om-btn-toolbar').showAlertAfterElement('alert-success alert-custom',json.success, 5000);
				}

				if(json.reload)
				{
					window.location.reload();
				}

				if(json.userOrganizations)
				{
					createOrganizationsMenu(json.currentUserOrganization, json.userOrganizations, json.organizationMenuLang);
				}

				if(json.deleteOrganizationMenu)
				{
					$('#user-organizations-dropdown-menu').html('');
				}

				$('#om-modal-delete').modal('hide');
				$('#app-loader').addClass('hidden');
				enableAll();
			}
		});
	});

	$('#om-database-form-group,#om-database-connection-name-form-group').click(function()
	{
		if($('#om-database').hasAttr('disabled'))
		{
			$('#om-organization-form').showAlertAsFirstChild('alert-info', lang.databaseConnectionNameInfoMessage, 7000);
		}
	});

	$('#om-database').click(function()
	{
		if($(this).is(':checked'))
		{
			$('#om-database-connection-name').removeAttr('disabled');
			$('#om-database-connection-name').val('');
			$('#om-database-connection-name').focus();
			$('#om-database-connection-name').parent().effect('shake', null, 600);
			$('#om-database-connection-name').parent().removeClass('has-success');
		}
		else
		{
			$('#om-database-connection-name').val('default');
			$('#om-database-connection-name').attr('disabled', 'disabled');
			$('#om-database-connection-name').parent().removeClass('has-error');
			$('#om-database-connection-name').parent().addClass('has-success');
			$('#om-btn-save').focus();
		}
	});

	$('#om-company-registration').focusout(function()
	{
		if($('#om-database').hasAttr('disabled'))
		{
			$('#om-btn-save').focus();
		}

	});

	$('#om-database').focusout(function()
	{
		if(!$(this).is(':checked'))
		{
			$('#om-btn-save').focus();
		}

	});

	$('#om-database-connection-name').parent().click(function()
	{
		if($('#om-database-connection-name').hasAttr('disabled') && !$('#om-database').hasAttr('disabled'))
		{
			$('#om-database-form-group').effect('shake', null, 600);
		}
	});

	$('#om-database-connection-name').focusout(function()
	{
		$('#om-btn-save').focus();
	});

	$('#om-btn-edit-helper').click(function()
	{
		if(!$('#om-btn-close').hasAttr('disabled'))
		{
			$('#om-btn-close').click();
		}

		$('#om-btn-group-2').popover({content: $('#om-btn-edit-helper').attr('data-content'), placement: 'top', trigger: 'manual'});

		setTimeout(function ()
		{
			$('#om-btn-group-2').popover('show');
		}, 100);

		setTimeout(function ()
		{
			$('#om-btn-group-2').popover('destroy');
		}, 8000);
	});

	$('#om-btn-remove-helper').click(function()
	{
		if(!$('#om-btn-close').hasAttr('disabled'))
		{
			$('#om-btn-close').click();
		}

		$('#om-btn-group-2').popover({content: $('#om-btn-remove-helper').attr('data-content'), placement: 'top', trigger: 'manual'});

		setTimeout(function ()
		{
			$('#om-btn-group-2').popover('show');
		}, 100);

		setTimeout(function ()
		{
			$('#om-btn-group-2').popover('destroy');
		}, 8000);
	});

	if(!$('#om-new-organization-action').isEmpty())
	{
		$('#om-btn-new').click();
	}

	if(!$('#om-edit-organization-action').isEmpty())
	{
		$('#om-btn-edit-helper').click();
	}

	if(!$('#om-remove-organization-action').isEmpty())
	{
		$('#om-btn-remove-helper').click();
	}

	if(!$('#om-show-welcome-message').isEmpty())
	{
		$('#search-action').attr('disabled', 'disabled');
		$('#user-apps-content').collapse('hide');
	}
});
