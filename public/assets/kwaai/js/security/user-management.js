/**
 * @file
 * User Management JavaScript resources.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

function umGetAccessControlList()
{
	var	userId, menuOptionModuleId, permissionsModuleId;

	if(!$("#um-permissions-module-label").isAutocompleteValid())
	{
		$("#um-permissions-module-label").selectFirstItem();
	}

	if(!$("#um-menu-options-module-label").isAutocompleteValid())
	{
		$("#um-menu-options-module-label").selectFirstItem();
	}

	userId = $('#users-grid').getSelectedRowId();
	menuOptionModuleId = $('#um-menu-options-module').val(),
	permissionsModuleId = $('#um-permissions-module').val();
	token = $('#app-token').val();

	if(!$('#users-grid').isRowSelected())
	{
		$('#um-btn-toolbar').showAlertAfterElement('alert-info alert-custom', lang.invalidSelection, 5000);
		return;
	}

	$.ajax(
	{
		type: 'POST',
		data: JSON.stringify({'_token':token, 'userId':userId, 'menuOptionModuleId':menuOptionModuleId, 'permissionsModuleId':permissionsModuleId}),
		dataType : 'json',
		url:  $('#um-users-form').attr('action') + '/access-control-list',
		error: function (jqXHR, textStatus, errorThrown)
		{
			handleServerExceptions(jqXHR, 'um-btn-toolbar', false);
    },
		beforeSend:function()
		{
			$('#app-loader').removeClass('hidden');
			disabledAll();
		},
		success:function(json)
		{
			$('#um-menu-option-label').autocomplete( "option", "source", json.permissionModuleMenus);
			$("#um-menu-option-label").selectFirstItem();
			$('#um-user-roles').populateMultiSelect(json.organizationRoles, json.userRoles);
			$('#um-user-menus').populateMultiSelect(json.userModuleMenus, json.userMenus);
			$('#um-user-permissions').populateMultiSelect(json.menuPermissions, json.userPermissions);
			$('#app-loader').addClass('hidden');
			enableAll();
			cleanJournals('um-');
			getAppJournals('um-','firstPage', userId);
		}
	});
}

function umOnSelectRowEvent(id)
{
	var selRowIds, found = false;

	$.each($('#users-grid').jqGrid('getGridParam', 'selarrrow'), function( index, value )
	{
		row = $('#users-grid').getRowData(value);

		if(row['id'] == $('#um-organization-owner').val() && $('#um-user-root').isEmpty())
		{
			$('#um-organization-owner-info-message').html($('#um-organization-owner-info-message').html().replace(':email', row['email']));
			$('#um-organization-owner-info-message').removeClass('hidden');
			umCleanAdminArea();
			umDisabledAdminArea();
			found = true;
			return;
		}
	});

	if(found)
	{
		return;
	}
	else
	{
		$('#um-organization-owner-info-message').addClass('hidden');
	}

	$('#um-user-created-by-info-message').addClass('hidden');
	selRowIds =  $('#users-grid').jqGrid('getGridParam', 'selarrrow');

	if(selRowIds.length == 0)
	{
		umCleanAdminArea();
		umDisabledAdminArea();
	}
	else if(selRowIds.length == 1)
	{
		umEnableAdminArea();

		if($('#um-grid-users-mode').parent().hasClass('active'))
		{
			umGetAccessControlList();
		}
		else
		{
			$('#um-btn-menu-preview').attr('disabled','disabled');
			cleanJournals('um-');
			getAppJournals('um-','firstPage', $('#users-grid').getSelectedRowId());
		}
	}
	else if(selRowIds.length > 1)
	{
		umCleanAdminArea();
		umDisabledAdminArea();
		$('#um-btn-delete').removeAttr('disabled');
	}
}

function umCleanAdminArea(userRoles, userMenus, userPermissions)
{
	userRoles = (userRoles == undefined ? true : false);
	userMenus = (userMenus == undefined ? true : false);
	userPermissions = (userPermissions == undefined ? true : false);

	cleanJournals('um-');

	if(userRoles)
	{
		$('#um-user-roles').find('option').remove();
		$('#um-user-roles').multiselect('refresh');
	}

	if(userMenus)
	{
		$('#um-user-menus').find('option').remove();
		$('#um-user-menus').multiselect('refresh');
	}

	if(userPermissions)
	{
		$('#um-user-permissions').find('option').remove();
		$('#um-user-permissions').multiselect('refresh');
	}
}

function umEnableAdminArea()
{
	$('#um-btn-group-2').enableButtonGroup();
	$('#um-roles-form-fieldset').removeAttr('disabled');
	$('#um-permissions-form-fieldset').removeAttr('disabled');
	$('#um-menu-options-form-fieldset').removeAttr('disabled');
}

function umDisabledAdminArea()
{
	$('#um-btn-group-2').disabledButtonGroup();
	$('#um-roles-form-fieldset').attr('disabled','disabled');
	$('#um-permissions-form-fieldset').attr('disabled','disabled');
	$('#um-menu-options-form-fieldset').attr('disabled','disabled');
}

function umInitNewForm()
{
	$('#um-btn-toolbar').disabledButtonGroup();
	$('#um-btn-group-3').enableButtonGroup();
	$('#um-send-email-label').removeClass('hidden');
	$('#um-grid-section').collapse('hide');

	if($('#um-grid-users-mode').parent().hasClass('active') || $('#um-new-admin-user-action').isEmpty())
	{
		$('#um-admin-section').collapse('hide');
	}

	$('#um-journal-section').collapse('hide');

	if(!$('#um-is-active').is(":checked"))
	{
		$('#um-is-active').click();
	}

	if(!$('#um-send-email').is(":checked"))
	{
		$('#um-send-email').click();
	}

	$('.um-btn-tooltip').tooltip('hide');
  $('#um-timezone').val($('#um-logged-user-timezone').val());
	$('#um-email').focus();
}

function umSetGridUsersMode(reload)
{
	$('#um-grid-users-mode').parent().addClass('active');
	$('#um-grid-admin-users-mode').parent().removeClass('active');
	$('#users-grid').setCaption($('#um-grid-users-title').val());
	$("#users-grid").jqGrid('setGridParam', { url: $('#app-url').val() + '/general-setup/security/user-management/user-grid-data' });

	if(reload)
	{
		$('#um-admin-section').collapse('show');
		$('#um-btn-refresh').click();
	}
}

function umSetGridAdminUsersMode(reload)
{
	$('#um-grid-admin-users-mode').parent().addClass('active');
	$('#um-grid-users-mode').parent().removeClass('active');
	$('#users-grid').setCaption($('#um-grid-admin-users-title').val());
	$("#users-grid").jqGrid('setGridParam', { url: $('#app-url').val() + '/general-setup/security/user-management/admin-user-grid-data' });
	$('#um-admin-section').collapse('hide');

	if(reload)
	{
		$('#um-btn-refresh').click();
	}
}

function umAssociateUserToOrganization()
{
	$.ajax(
	{
		type: 'POST',
		data: JSON.stringify({'_token':$('#app-token').val(), 'id':$('#um-id').val()}),
		dataType : 'json',
		url:  $('#um-users-form').attr('action') + '/associate-user',
		error: function (jqXHR, textStatus, errorThrown)
		{
			handleServerExceptions(jqXHR, 'um-btn-toolbar', false);
		},
		beforeSend:function()
		{
			$('#app-loader').removeClass('hidden');
			disabledAll();
		},
		success:function(json)
		{
			if($('#um-grid-admin-users-mode').parent().hasClass('active'))
			{
				umSetGridUsersMode(false);
			}

			$('#um-btn-group-3').enableButtonGroup();
			$('#um-btn-close').click();
			$('#um-users-form').children().first().remove();
			$('#um-users-form-fieldset').removeAttr('disabled');
			$('#users-grid').reloadAfterRowInserted();
			$('#um-btn-toolbar').showAlertAfterElement('alert-success alert-custom', json.success, 7000);
			$('#app-loader').addClass('hidden');
			enableAll();
		}
	});
}

function umResetAddUserForm()
{
	$('#um-users-form').children().first().remove();
	$('#um-users-form').jqMgVal('clearForm');
	$('#um-users-form-fieldset').removeAttr('disabled');

	if(!$('#um-form-new-title').hasClass('hidden'))
	{
		$('#um-is-admin').val('0');
	}

	if(!$('#um-form-new-admin-title').hasClass('hidden'))
	{
		$('#um-is-admin').val('1');
	}

	$('#um-send-email').click();
	$('#um-is-active').click();
	$('#um-timezone').val($('#um-logged-user-timezone').val());
	$('#um-btn-group-3').enableButtonGroup();
	$('#um-email').focus();
}

function umSetUserAsAdmin()
{
	$.ajax(
	{
		type: 'POST',
		data: JSON.stringify({'_token':$('#app-token').val(), 'id':$('#um-id').val()}),
		dataType : 'json',
		url:  $('#um-users-form').attr('action') + '/set-admin-user',
		error: function (jqXHR, textStatus, errorThrown)
		{
			handleServerExceptions(jqXHR, 'um-btn-toolbar', false);
		},
		beforeSend:function()
		{
			$('#app-loader').removeClass('hidden');
			disabledAll();
		},
		success:function(json)
		{
			if($('#um-grid-users-mode').parent().hasClass('active'))
			{
				umSetGridAdminUsersMode(false);
			}

			$('#um-btn-group-3').enableButtonGroup();
			$('#um-btn-close').click();
			$('#um-users-form').children().first().remove();
			$('#um-users-form-fieldset').removeAttr('disabled');
			$('#users-grid').reloadAfterRowInserted();
			$('#um-btn-toolbar').showAlertAfterElement('alert-success alert-custom', json.success, 7000);
			$('#app-loader').addClass('hidden');
			enableAll();
		}
	});
}

$(document).ready(function()
{
	$('#um-users-form').jqMgVal('addFormFieldsValidations');
	$('.um-btn-tooltip').tooltip();

	setTimeout(function () {
		$('#um-user-roles').multiselect();
		$('#um-user-menus').multiselect();
		$('#um-user-permissions').multiselect();
	}, 500);

	$('#um-grid-section').on('hidden.bs.collapse', function ()
	{
		if(!$('#um-grid-users-mode').parent().hasClass('active'))
		{
			$('#um-form-section').collapse('show');
		}
	});

	$('#um-admin-section').on('hidden.bs.collapse', function ()
	{
		if(!$('#um-grid-section').hasClass('in'))
		{
			$('#um-form-section').collapse('show');
		}
	});


	$('#um-form-section').on('hidden.bs.collapse', function ()
	{
		$('#um-grid-section').collapse('show');

		if($('#um-grid-users-mode').parent().hasClass('active') || $('#um-new-admin-user-action').isEmpty())
		{
			$('#um-admin-section').collapse('show');
		}

		$('#um-journal-section').collapse('show');
	});

	$('#um-modal').on('hidden.bs.modal', function (e)
	{
		$('#um-modal-body').html('<div class="alert alert-block alert-info um-custom-alert-info"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>' + $('#um-modal-body').attr('data-no-apps-exception') + '</div>');
	});

	$('#um-user-roles').bind('multiselectChange', function(evt, ui)
	{
		var	rolesId, userId, menuOptionModuleId, permissionsModuleId;

		rolesId = getSelectedOptionsId(ui.optionElements);
		userId = $('#users-grid').getSelectedRowId();
		menuOptionModuleId = $('#um-menu-options-module').val(),
		permissionsModuleId = $('#um-permissions-module').val();
		token = $('#app-token').val();

		if(!$('#users-grid').isRowSelected())
		{
			$('#um-btn-toolbar').showAlertAfterElement('alert-info alert-custom', lang.invalidSelection, 5000);
			return;
		}

		if(rolesId.length == 0)
		{
			return;
		}

		$.ajax(
		{
			type: 'POST',
			data: JSON.stringify({'_token':token, 'userId':userId, 'rolesId':rolesId, 'selected':ui.selected, 'menuOptionModuleId':menuOptionModuleId, 'permissionsModuleId':permissionsModuleId}),
			dataType : 'json',
			url:  $('#um-users-form').attr('action') + '/store-user-roles',
			error: function (jqXHR, textStatus, errorThrown)
			{
				handleServerExceptions(jqXHR, 'um-btn-toolbar', false);
			},
			beforeSend:function()
			{
				$('#app-loader').removeClass('hidden');
				disabledAll();
			},
			success:function(json)
			{
				$('#um-menu-option-label').autocomplete( "option", "source", json.permissionModuleMenus);
				$("#um-menu-option-label").selectFirstItem();
				$('#um-user-menus').populateMultiSelect(json.userModuleMenus, json.userMenus);
				$('#um-user-permissions').populateMultiSelect(json.menuPermissions, json.userPermissions);
				$('#app-loader').addClass('hidden');
				enableAll();
        cleanJournals('um-');
        getAppJournals('um-','firstPage');
			}
		});
	});

	$('#um-user-menus').bind('multiselectChange', function(evt, ui)
	{
		var	menusId, userId, permissionsModuleId;

		menusId = getSelectedOptionsId(ui.optionElements);
		userId = $('#users-grid').getSelectedRowId();
		permissionsModuleId = $('#um-permissions-module').val();
		token = $('#app-token').val();

		if(!$('#users-grid').isRowSelected())
		{
			$('#um-btn-toolbar').showAlertAfterElement('alert-info alert-custom', lang.invalidSelection, 5000);
			return;
		}

		if(menusId.length == 0)
		{
			return;
		}

		$.ajax(
		{
			type: 'POST',
			data: JSON.stringify({'_token':token, 'userId':userId, 'menusId':menusId, 'selected':ui.selected, 'permissionsModuleId':permissionsModuleId}),
			dataType : 'json',
			url:  $('#um-users-form').attr('action') + '/store-user-menus',
			error: function (jqXHR, textStatus, errorThrown)
			{
				handleServerExceptions(jqXHR, 'um-btn-toolbar', false);
			},
			beforeSend:function()
			{
				$('#app-loader').removeClass('hidden');
				disabledAll();
			},
			success:function(json)
			{
				$('#um-menu-option-label').autocomplete( "option", "source", json.permissionModuleMenus);
				$("#um-menu-option-label").selectFirstItem();
				$('#um-user-permissions').populateMultiSelect(json.menuPermissions, json.userPermissions);
				$('#app-loader').addClass('hidden');
				enableAll();
        cleanJournals('um-');
        getAppJournals('um-','firstPage');
			}
		});
	});

	$('#um-user-permissions').bind('multiselectChange', function(evt, ui)
	{
		var	permissionsId, userId;

		permissionsId = getSelectedOptionsId(ui.optionElements);
		userId = $('#users-grid').getSelectedRowId();
		token = $('#app-token').val();

		if(!$('#users-grid').isRowSelected())
		{
			$('#um-btn-toolbar').showAlertAfterElement('alert-info alert-custom', lang.invalidSelection, 5000);
			return;
		}

		if(permissionsId.length == 0)
		{
			return;
		}

		$.ajax(
		{
			type: 'POST',
			data: JSON.stringify({'_token':token, 'userId':userId, 'permissionsId':permissionsId, 'selected':ui.selected}),
			dataType : 'json',
			url:  $('#um-users-form').attr('action') + '/store-user-permissions',
			error: function (jqXHR, textStatus, errorThrown)
			{
				handleServerExceptions(jqXHR, 'um-btn-toolbar', false);
			},
			beforeSend:function()
			{
				$('#app-loader').removeClass('hidden');
				disabledAll();
			},
			success:function(json)
			{
				$('#app-loader').addClass('hidden');
				enableAll();
        cleanJournals('um-');
        getAppJournals('um-','firstPage');
			}
		});
	});

	$('#um-menu-options-module-label').focusout(function()
	{
		if($(this).attr('autocompleteselectevent') == "1")
		{
			$(this).attr('autocompleteselectevent', 0);
			return;
		}

		if(!$(this).isAutocompleteValid())
		{
			$(this).selectFirstItem(false);
			$(this).attr('autocompleteselectevent', 0);
		}
	});

	$('#um-menu-options-module-label').on( 'autocompleteselect', function( event, ui )
	{
		var	userId, menuOptionModuleId;

		if(ui.trigger)
		{
			return;
		}

		$(this).attr('autocompleteselectevent', 1);

		userId = $('#users-grid').getSelectedRowId();
		menuOptionModuleId = ui.item.value;
		token = $('#app-token').val();

		if(!$('#users-grid').isRowSelected())
		{
			$('#um-btn-toolbar').showAlertAfterElement('alert-info alert-custom', lang.invalidSelection, 5000);
			return;
		}

		$.ajax(
		{
			type: 'POST',
			data: JSON.stringify({'_token':token, 'userId':userId, 'moduleId':menuOptionModuleId}),
			dataType : 'json',
			url:  $('#um-users-form').attr('action') + '/user-and-module-menus',
			error: function (jqXHR, textStatus, errorThrown)
			{
				handleServerExceptions(jqXHR, 'um-btn-toolbar', false);
			},
			beforeSend:function()
			{
				$('#app-loader').removeClass('hidden');
				disabledAll();
			},
			success:function(json)
			{
				$('#um-user-menus').populateMultiSelect(json.userModuleMenus, json.userMenus);
				$('#app-loader').addClass('hidden');
				enableAll();
			}
		});
	});

	$('#um-permissions-module-label').focusout(function()
	{
		if($(this).attr('autocompleteselectevent') == "1")
		{
			$(this).attr('autocompleteselectevent', 0);
			return;
		}

		if(!$(this).isAutocompleteValid())
		{
			$(this).selectFirstItem(false);
			$(this).attr('autocompleteselectevent', 0);
		}
	});

	$('#um-permissions-module-label').on( 'autocompleteselect', function( event, ui )
	{
		var	userId, permissionsModuleId;

		if(ui.trigger)
		{
			return;
		}

		$(this).attr('autocompleteselectevent', 1);

		userId = $('#users-grid').getSelectedRowId();
		permissionsModuleId = ui.item.value;
		token = $('#app-token').val();

		if(!$('#users-grid').isRowSelected())
		{
			$('#um-btn-toolbar').showAlertAfterElement('alert-info alert-custom', lang.invalidSelection, 5000);
			return;
		}

		$.ajax(
		{
			type: 'POST',
			data: JSON.stringify({'_token':token, 'userId':userId, 'moduleId':permissionsModuleId}),
			dataType : 'json',
			url:  $('#um-users-form').attr('action') + '/user-menus-and-permissions',
			error: function (jqXHR, textStatus, errorThrown)
			{
				handleServerExceptions(jqXHR, 'um-btn-toolbar', false);
			},
			beforeSend:function()
			{
				$('#app-loader').removeClass('hidden');
				disabledAll();
			},
			success:function(json)
			{
				$('#um-menu-option-label').autocomplete( "option", "source", json.permissionModuleMenus);
				$('#um-menu-option-label').selectFirstItem();
				$('#um-user-permissions').populateMultiSelect(json.menuPermissions, json.userPermissions);
				$('#app-loader').addClass('hidden');
				enableAll();
			}
		});
	});

	$('#um-menu-option-label').focusout(function()
	{
		if($(this).attr('autocompleteselectevent') == "1")
		{
			$(this).attr('autocompleteselectevent', 0);
			return;
		}

		if(!$(this).isAutocompleteValid())
		{
			$(this).selectFirstItem(false);
			$(this).attr('autocompleteselectevent', 0);
		}
	});

	$('#um-menu-option-label').on( 'autocompleteselect', function( event, ui )
	{
		var	userId, menuId;

		if(ui.trigger)
		{
			return;
		}

		$(this).attr('autocompleteselectevent', 1);

		userId = $('#users-grid').getSelectedRowId();
		menuId = ui.item.value;
		token = $('#app-token').val();

		if(!$('#users-grid').isRowSelected())
		{
			$('#um-btn-toolbar').showAlertAfterElement('alert-info alert-custom', lang.invalidSelection, 5000);
			return;
		}

		$.ajax(
		{
			type: 'POST',
			data: JSON.stringify({'_token':token, 'userId':userId, 'menuId':menuId}),
			dataType : 'json',
			url:  $('#um-users-form').attr('action') + '/user-permissions',
			error: function (jqXHR, textStatus, errorThrown)
			{
				handleServerExceptions(jqXHR, 'um-btn-toolbar', false);
			},
			beforeSend:function()
			{
				$('#app-loader').removeClass('hidden');
				disabledAll();
			},
			success:function(json)
			{
				$('#um-user-permissions').populateMultiSelect(json.menuPermissions, json.userPermissions);
				$('#app-loader').addClass('hidden');
				enableAll();
			}
		});
	});

	$('#um-email').focusout(function()
	{
		if(!$('#um-form-edit-title').hasClass('hidden'))
		{
			return;
		}

		if($(this).isEmpty())
		{
			return;
		}

		if(!$('#um-form-new-title').hasClass('hidden'))
		{
			$.ajax(
			{
				type: 'POST',
				data: JSON.stringify({'_token':$('#app-token').val(), 'email':$(this).val()}),
				dataType : 'json',
				url:  $('#um-users-form').attr('action') + '/find-user',
				error: function (jqXHR, textStatus, errorThrown)
				{
					//do nothing
				},
				beforeSend:function()
				{
					//do nothing
				},
				success:function(json)
				{
					if(json.question)
					{
						$('#um-users-form').showYesNoQuestionAsFirstChild(json.question, 'umAssociateUserToOrganization', 'umResetAddUserForm');
						populateFormFields(json.userData, 'um-');
						$('#um-users-form').find('.form-group').removeClass('has-error');
						$('#um-users-form').find('.form-group').addClass('has-success');
						$('#um-btn-group-3').disabledButtonGroup();
						$('#um-users-form-fieldset').attr('disabled','disabled');
					}

					if(json.userAlreadyInOrganizationException)
					{
						$('#um-users-form').showAlertAsFirstChild('alert-info', json.userAlreadyInOrganizationException, 7000);
						$('#um-users-form').jqMgVal('clearForm');
						$('#um-send-email').click();
						$('#um-is-active').click();
						$('#um-email').focus();
					}
				}
			});
		}

		if(!$('#um-form-new-admin-title').hasClass('hidden'))
		{
			$.ajax(
			{
				type: 'POST',
				data: JSON.stringify({'_token':$('#app-token').val(), 'email':$(this).val()}),
				dataType : 'json',
				url:  $('#um-users-form').attr('action') + '/find-non-admin-user',
				error: function (jqXHR, textStatus, errorThrown)
				{
					//do nothing
				},
				beforeSend:function()
				{
					//do nothing
				},
				success:function(json)
				{
					if(json.question)
					{
						$('#um-users-form').showYesNoQuestionAsFirstChild(json.question, 'umSetUserAsAdmin', 'umResetAddUserForm');
						populateFormFields(json.userData, 'um-');
						$('#um-users-form').find('.form-group').removeClass('has-error');
						$('#um-users-form').find('.form-group').addClass('has-success');
						$('#um-btn-group-3').disabledButtonGroup();
						$('#um-users-form-fieldset').attr('disabled','disabled');
					}

					if(json.userAlreadyAdminException)
					{
						$('#um-users-form').showAlertAsFirstChild('alert-info', json.userAlreadyAdminException, 7000);
						$('#um-users-form').jqMgVal('clearForm');
						$('#um-send-email').click();
						$('#um-is-active').click();
						$('#um-email').focus();
					}
				}
			});
		}
	});

	$('#um-grid-users-mode').click(function()
	{
		if($(this).parent().hasClass('active'))
		{
			return;
		}

		$('#um-btn-delete').attr('data-original-title', $('#um-btn-delete').attr('data-non-admin-title'));

		umSetGridUsersMode(true);
	});

	$('#um-grid-admin-users-mode').click(function()
	{
		if($(this).parent().hasClass('active'))
		{
			return;
		}

		$('#um-btn-delete').attr('data-original-title', $('#um-btn-delete').attr('data-admin-title'));

		umSetGridAdminUsersMode(true);
	});

	$('#um-btn-new-admin').click(function()
	{
		$('.um-btn-tooltip').tooltip('hide');

		if($(this).hasAttr('disabled') && !$('#um-form-new-admin-title').hasClass('hidden'))
		{
			return;
		}

		if($(this).hasAttr('disabled') && !$('#um-form-new-title').hasClass('hidden'))
		{
			$('#um-users-form').parent().effect('highlight', null, 1500);
			$('#um-form-new-title').addClass('hidden');
			$('#um-users-form').jqMgVal('clearForm');
			$('#um-new-admin-info-message').removeClass('hidden');
			$('#um-form-new-admin-title').removeClass('hidden');
			$('#um-is-admin').val('1');
			$('#um-is-active').click();
			$('#um-send-email').click();
			return;
		}

		if($(this).hasAttr('disabled') && !$('#um-form-edit-title').hasClass('hidden'))
		{
			$('#um-users-form').parent().effect('highlight', null, 1500);
			$('#um-form-edit-title').addClass('hidden');
			$('#um-form-edit-password-help-block').addClass('hidden');
			$('#um-users-form').jqMgVal('clearForm');
			$('#um-send-email-label').removeClass('hidden');
			$('#um-new-admin-info-message').removeClass('hidden');
			$('#um-form-new-admin-title').removeClass('hidden');
			$('#um-is-admin').val('1');
			$('#um-is-active').click();
			$('#um-send-email').click();
			return;
		}

		$('#um-new-admin-info-message').removeClass('hidden');
		$('#um-form-new-admin-title').removeClass('hidden');
		$('#um-is-admin').val('1');
		umInitNewForm();
	});

	$('#um-btn-new').click(function()
	{
		$('.um-btn-tooltip').tooltip('hide');

		if($(this).hasAttr('disabled') && !$('#um-form-new-title').hasClass('hidden'))
		{
			return;
		}

		if($(this).hasAttr('disabled') && !$('#um-form-new-admin-title').hasClass('hidden'))
		{
			$('#um-users-form').parent().effect('highlight', null, 1500);
			$('#um-form-new-admin-title').addClass('hidden');
			$('#um-new-admin-info-message').addClass('hidden');
			$('#um-users-form').jqMgVal('clearForm');
			$('#um-form-new-title').removeClass('hidden');
			$('#um-is-admin').val('0');
			$('#um-is-active').click();
			$('#um-send-email').click();
			return;
		}

		if($(this).hasAttr('disabled') && !$('#um-form-edit-title').hasClass('hidden'))
		{
			$('#um-users-form').parent().effect('highlight', null, 1500);
			$('#um-form-edit-title').addClass('hidden');
			$('#um-form-edit-password-help-block').addClass('hidden');
			$('#um-users-form').jqMgVal('clearForm');
			$('#um-form-new-title').removeClass('hidden');
			$('#um-send-email-label').removeClass('hidden');
			$('#um-is-admin').val('0');
			$('#um-is-active').click();
			$('#um-send-email').click();
			return;
		}

		$('#um-form-new-title').removeClass('hidden');
		$('#um-is-admin').val('0');
		umInitNewForm();
	});

	$('#um-btn-refresh').click(function()
	{
		$('.um-btn-tooltip').tooltip('hide');
		$('#users-grid')[0].clearToolbar();
		umCleanAdminArea();
		umDisabledAdminArea();
	});

	$('#um-btn-export-xls').click(function()
	{
			$('#users-gridXlsButton').click();
	});

	$('#um-btn-export-csv').click(function()
	{
			$('#users-gridCsvButton').click();
	});

	$('#um-btn-reset').click(function()
	{
		var	userId, menuOptionModuleId, permissionsModuleId;

		userId = $('#users-grid').getSelectedRowId();
		menuOptionModuleId = $('#um-menu-options-module').val(),
		permissionsModuleId = $('#um-permissions-module').val();
		token = $('#app-token').val();

		if(!$('#users-grid').isRowSelected())
		{
			$('#um-btn-toolbar').showAlertAfterElement('alert-info alert-custom', lang.invalidSelection, 5000);
			return;
		}

		$('.um-btn-tooltip').tooltip('hide');

		$.ajax(
		{
			type: 'POST',
			data: JSON.stringify({'_token':token, 'userId':userId, 'menuOptionModuleId':menuOptionModuleId, 'permissionsModuleId':permissionsModuleId}),
			dataType : 'json',
			url:  $('#um-users-form').attr('action') + '/reset-user-menus',
			error: function (jqXHR, textStatus, errorThrown)
			{
				handleServerExceptions(jqXHR, 'um-btn-toolbar', false);
			},
			beforeSend:function()
			{
				$('#app-loader').removeClass('hidden');
				disabledAll();
			},
			success:function(json)
			{
				$('#um-menu-option-label').autocomplete( "option", "source", json.permissionModuleMenus);
				$("#um-menu-option-label").selectFirstItem();
				$('#um-user-menus').populateMultiSelect(json.userModuleMenus, json.userMenus);
				$('#um-user-permissions').populateMultiSelect(json.menuPermissions, json.userPermissions);
				$('#app-loader').addClass('hidden');
				enableAll();
			}
		});
	});

	$('#um-btn-menu-preview').click(function()
	{
		var row = $('#users-grid').getRowData($('#users-grid').jqGrid('getGridParam', 'selrow'));

		token = $('#app-token').val();

		$('.um-btn-tooltip').tooltip('hide');

		$.ajax(
		{
			type: 'POST',
			data: JSON.stringify({'_token':token, 'id':row.id}),
			dataType : 'json',
			url:  $('#um-users-form').attr('action') + '/user-menu',
			error: function (jqXHR, textStatus, errorThrown)
			{
				handleServerExceptions(jqXHR, 'um-btn-toolbar', false);
			},
			beforeSend:function()
			{
				$('#app-loader').removeClass('hidden');
				disabledAll();
			},
			success:function(json)
			{
				if(json.length > 0)
				{
					$('#um-modal-body').children().remove();
				}

				$('#um-modal-body').buildUserApps(json, 'um-', true);
				$('#app-loader').addClass('hidden');
				enableAll();
				$('#um-modal').modal('show');
			}
		});

	});

	$('#um-btn-edit').click(function()
	{
		if($(this).hasAttr('disabled'))
		{
			return;
		}

		$('.um-btn-tooltip').tooltip('hide');

		if(!$('#users-grid').isRowSelected())
		{
			$('#um-btn-toolbar').showAlertAfterElement('alert-info alert-custom', lang.invalidSelection, 5000);
			return;
		}

		selectedRowData = $('#users-grid').getRowData($('#users-grid').jqGrid('getGridParam', 'selrow'));

		if($('#um-logged-user-email').val() != selectedRowData.created_by && $('#um-user-root').isEmpty())
		{
			$('#um-user-created-by-info-message').removeClass('hidden');
			return;
		}

		$('#um-btn-toolbar').disabledButtonGroup();
		$('#um-btn-group-3').enableButtonGroup();
		$('#um-form-edit-title').removeClass('hidden');
		$('#um-is-active-label').removeClass('hidden');
		$('#um-form-edit-password-help-block').removeClass('hidden');
		populateFormFields(selectedRowData, 'um-');
		$('#um-grid-section').collapse('hide');
    $('#um-journal-section').collapse('hide');

		if(!$('#um-user-root').isEmpty())
		{
			$('#um-password').removeAttr('disabled');
			$('#um-confirm-password').removeAttr('disabled');
		}

		if($('#um-grid-users-mode').parent().hasClass('active') || $('#um-new-admin-user-action').isEmpty())
		{
			$('#um-admin-section').collapse('hide');
		}

		$('#um-email').focus();
	});

	$('#um-btn-close').click(function(event)
	{
		if($(this).hasAttr('disabled'))
		{
			return;
		}

		$('#um-btn-group-1').enableButtonGroup();
		$('#um-btn-group-3').disabledButtonGroup();
		$('#um-form-section').collapse('hide');
		$('#um-form-new-admin-title').addClass('hidden');
		$('#um-new-admin-info-message').addClass('hidden');
		$('#um-form-new-title').addClass('hidden');
		$('#um-is-active-label').addClass('hidden');
		$('#um-send-email-label').addClass('hidden');
		$('#um-form-edit-title').addClass('hidden');
		$('#um-form-edit-password-help-block').addClass('hidden');
		$('#um-password').attr('disabled','disabled');
		$('#um-confirm-password').attr('disabled','disabled');
		umOnSelectRowEvent($('#users-grid').jqGrid('getGridParam', 'selrow'));
		$('#um-users-form').jqMgVal('clearForm');
		$('.um-btn-tooltip').tooltip('hide');
	});

	$('#um-confirm-password').focusout(function()
	{
		$('#um-btn-save').focus();
	});

	$('#um-btn-save').click(function()
	{
		var url = $('#um-users-form').attr('action'), action = 'new';

		$('.um-btn-tooltip').tooltip('hide');

		if(!$('#um-users-form').jqMgVal('isFormValid'))
		{
			return;
		}

		if(!$('#um-send-email').is(':checked') && $('#um-password').isEmpty() && $('#um-id').isEmpty())
		{
			$('#um-users-form').showAlertAsFirstChild('alert-info', lang.passwordRequired, 7000);
			$('#um-password,#um-confirm-password').parent().parent().effect('shake', null, 600);
			$('#um-password,#um-confirm-password').parent().parent().removeClass('has-success');
			$('#um-password,#um-confirm-password').parent().parent().addClass('has-error');

			return;
		}

		if($('#um-id').isEmpty())
		{
			url = url + '/store-user';
		}
		else
		{
			url = url + '/update-user';
			action = 'edit';
		}

		$.ajax(
		{
			type: 'POST',
			data: JSON.stringify($('#um-users-form').formToObject('um-')),
			dataType : 'json',
			url: url,
			error: function (jqXHR, textStatus, errorThrown)
			{
				handleServerExceptions(jqXHR, 'um-users-form');
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
						if($('#um-grid-users-mode').parent().hasClass('active') && $('#um-is-admin').val() == '1')
						{
							umSetGridAdminUsersMode(false);
						}

						if($('#um-grid-admin-users-mode').parent().hasClass('active') && $('#um-is-admin').val() == '0')
						{
							umSetGridUsersMode(false);
						}

						$('#um-btn-close').click();
						$('#users-grid').reloadAfterRowInserted();
						$('#um-btn-toolbar').showAlertAfterElement('alert-success alert-custom',json.success, 9000);
					}
					else
					{
						$('#users-grid').setRowData($('#users-grid').jqGrid('getGridParam', 'selrow'), $('#um-users-form').formToObject('um-'));
						$('#um-btn-close').click();
						$('#um-btn-toolbar').showAlertAfterElement('alert-success alert-custom',json.success, 5000);
					}
				}

				if(json.info)
				{
					$('#um-users-form').showAlertAsFirstChild('alert-info', json.info, 7000);
				}

				if(json.validationFailed)
				{
					$('#um-users-form').showServerErrorsByField(json.fieldValidationMessages, 'um-');
				}

				$('#app-loader').addClass('hidden');
				enableAll();
			}
		});
	});

	$('#um-btn-delete').click(function()
	{
		var url = $('#um-users-form').attr('action');

		$('.um-btn-tooltip').tooltip('hide');

		if($(this).hasAttr('disabled'))
		{
			return;
		}

		if(!$('#users-grid').isRowSelected())
		{
			$('#um-btn-toolbar').showAlertAfterElement('alert-info alert-custom', lang.invalidSelection, 5000);
			return;
		}

		if($('#um-grid-users-mode').parent().hasClass('active'))
		{
			url += '/delete-user';
		}
		else
		{
			url += '/set-non-admin-user';
		}

		var idArray = $('#users-grid').getSelectedRowsIdCell();

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
			url:  url,
			error: function (jqXHR, textStatus, errorThrown)
			{
				handleServerExceptions(jqXHR, 'um-btn-toolbar', false);
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
					$('#um-btn-refresh').click();
					$('#um-btn-toolbar').showAlertAfterElement('alert-success alert-custom',json.success, 5000);
				}
				else
				{
					$('#um-btn-toolbar').showAlertAfterElement('alert-danger alert-custom', json.failure, 7000);
				}

				$('#app-loader').addClass('hidden');
				enableAll();
			}
		});
	});

	$('#um-send-email').click(function()
	{
		if($(this).is(':checked'))
		{
			$('#um-password').attr('disabled', 'disabled');
			$('#um-password').val('');
			$('#um-confirm-password').attr('disabled', 'disabled');
			$('#um-confirm-password').val('');
			$('#um-btn-save').focus();
		}
		else
		{
			$('#um-password').removeAttr('disabled');
			$('#um-confirm-password').removeAttr('disabled');
			$('#um-password').focus();
		}
	});

  $('#um-btn-remove-helper').click(function()
  {
		if(!$('#um-btn-close').hasAttr('disabled'))
		{
			$('#um-btn-close').click();
		}

    $('#um-btn-group-2').popover({content: $('#um-btn-remove-helper').attr('data-content'), placement: 'top', trigger: 'manual'});

    setTimeout(function () {
    	$('#um-btn-group-2').popover('show');
    }, 500);

    setTimeout(function () {
      $('#um-btn-group-2').popover('destroy');
    }, 8000);
  });

  $('#um-btn-assign-helper').click(function()
  {
		if(!$('#um-btn-close').hasAttr('disabled'))
		{
			$('#um-btn-close').click();
		}

    $('#um-grid-section').popover({content: $('#um-btn-assign-helper').attr('data-content'), placement: 'top', trigger: 'manual'});

    setTimeout(function () {
    	$('#um-grid-section').popover('show');
    }, 500);

    setTimeout(function () {
      $('#um-grid-section').popover('destroy');
    }, 8000);
  });

  $('#um-btn-unassign-helper').click(function()
  {
		if(!$('#um-btn-close').hasAttr('disabled'))
		{
			$('#um-btn-close').click();
		}

    $('#um-grid-section').popover({content: $('#um-btn-unassign-helper').attr('data-content'), placement: 'top', trigger: 'manual'});

    setTimeout(function ()
    {
    	$('#um-grid-section').popover('show');
    }, 500);

    setTimeout(function ()
    {
      $('#um-grid-section').popover('destroy');
    }, 8000);
  });

	$('#um-confirm-password').onEnter( function() {
		$('#um-btn-save').click();
  });

	if(!$('#um-new-user-action').isEmpty())
	{
		$('#um-btn-new').click();
	}

	if(!$('#um-new-admin-user-action').isEmpty())
	{
		$('#um-btn-new-admin').click();
	}

  if(!$('#um-remove-user-action').isEmpty())
  {
    $('#um-btn-remove-helper').click();
  }

  if(!$('#um-assign-role-action').isEmpty())
  {
    $('#um-btn-assign-helper').click();
  }

  if(!$('#um-unassign-role-action').isEmpty())
  {
    $('#um-btn-unassign-helper').click();
  }

  //$('#um-user-roles').multiselect('refresh');
  //$('#um-user-menus').multiselect('refresh');
  //$('#um-user-permissions').multiselect('refresh');
});
