/**
 * @file
 * Forms validation engine.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

$(document).ready(function()
{
	$('#email').focus();

	$('#password').onEnter( function()
	{
		$('#btn-login').click();
  });

	$('#btn-login').click(function()
	{
		$('#login-form-alert').remove();

		$.ajax(
		{
			type: 'POST',
			data: JSON.stringify($('#login-form').formToObject()),
			dataType : 'json',
			url: $('#login-form').attr('action'),
			error: function (jqXHR, textStatus, errorThrown)
			{
				handleServerExceptions(jqXHR, 'login-form');
			},
			beforeSend:function()
			{
				$('#app-loader').removeClass('hidden');
				disabledAll();
			},
			success:function(json)
			{
				if(json.message != 'success')
				{
					$('#login-form').showAlertAsFirstChild('alert-info',json.message, 7000);
					$('#app-loader').addClass('hidden');
					enableAll();
				}
				else
				{
					window.location.replace(json.url);
				}
			}
		});

	});
});
