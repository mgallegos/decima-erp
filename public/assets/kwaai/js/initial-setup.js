/**
 * @file
 * Description of the script.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

$(document).ready(function()
{
	$('.navbar-header').next().remove();
	$('#search-action-container').parent().remove();
	$('#user-apps-container').remove();
	$('#initial-setup-form').jqMgVal('addFormFieldsValidations');
	$('#email').focus();

	$('#btn-update').click(function()
	{
		if(!$('#initial-setup-form').jqMgVal('isFormValid'))
		{
			return;
		}

		$.ajax(
		{
			type: 'POST',
			data: JSON.stringify($('#initial-setup-form').formToObject()),
			dataType : 'json',
			url: $('#initial-setup-form').attr('action') + '/update-user',
			error: function (jqXHR, textStatus, errorThrown)
			{
				handleServerExceptions(jqXHR, 'initial-setup-form');
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
					window.location.replace($('#app-url').val());
				}

				if(json.info)
				{
					$('#initial-setup-form').showAlertAsFirstChild('alert-info', json.info, 7000);
					$('#app-loader').addClass('hidden');
					enableAll();
				}
			}
		});

	});

	$('#confirm-password').onEnter( function() {
		$('#btn-update').click();
    });
});
