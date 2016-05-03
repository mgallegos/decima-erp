/**
 * @file
 * Description of the script.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

$(document).ready(function()
{
	$('#up-user-form').jqMgVal('addFormFieldsValidations');
	$('#email').focus();

	$('#up-btn-update').click(function()
	{
		if(!$('#up-user-form').jqMgVal('isFormValid'))
		{
			return;
		}

		$.ajax(
		{
			type: 'POST',
			data: JSON.stringify($('#up-user-form').formToObject('up-')),
			dataType : 'json',
			url: $('#up-user-form').attr('action'),
			error: function (jqXHR, textStatus, errorThrown)
			{
				handleServerExceptions(jqXHR, 'up-user-form');
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

				if(json.success)
				{
          $('#up-user-form').showAlertAsFirstChild('alert-success',json.success, 5000);
          $('#up-user-form').find('.has-success').each(function()
          {
            $(this).removeClass('has-success');
          });

					$('#up-user-form').find('.control-label').each(function()
					{
						$(this).find('.fa-check-circle' + ',.fa-times-circle' + ',.mg-is').remove();
					});

					$('#up-user-form').find('.mg-hmt').remove();

          $('#up-password').val('');
          $('#up-confirm-password').val('');
          cleanJournals('up-c-');
          getAppJournals('up-c-','firstPage');
				}

				if(json.info)
				{
					$('#up-user-form').showAlertAsFirstChild('alert-info', json.info, 7000);
				}

        if(json.validationFailed)
        {
          $('#up-user-form').showServerErrorsByField(json.fieldValidationMessages, 'up-');
        }
			}
		});

	});

	$('#up-confirm-password').onEnter( function() {
		$('#up-btn-update').click();
  });
});
