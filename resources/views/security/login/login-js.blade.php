<script type="text/javascript">
  function validate(input)
  {
    if($(input).attr('type') == 'email' || $(input).attr('name') == 'email')
    {
      if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null)
      {
          return false;
      }
    }
    else
    {
      if($(input).val().trim() == '')
      {
          return false;
      }
    }
  }

  function showValidate(input)
  {
    var thisAlert = $(input).parent();

    $(thisAlert).addClass('alert-validate');
  }

  function hideValidate(input)
  {
    var thisAlert = $(input).parent();
    // console.log(thisAlert)
    $(thisAlert).removeClass('alert-validate');
  }

  /**
  * Handle server exceptions
  *
  * @param object jqXHR
  * @param string id
  *
  *  @returns void
  */
  function handleServerExceptions(jqXHR, id, alertAsFirstChild)
  {
  	// alertAsFirstChild = (alertAsFirstChild == undefined ? true : alertAsFirstChild);

  	try
  	{
  		response = JSON.parse(jqXHR.responseText);
  		response = response.error.type;
  	}
  	catch (e)
  	{
  		response = $.trim(jqXHR.responseText);
  	}

  	switch (response)
  	{
  		case 'TokenMismatchException':
  			alert(lang.tokenMismatchException);
  			window.location.reload();
  			return;
  			break;
  		case 'Unauthorized.':
  			alert(lang.authenticationException);
  			window.location.reload();
  			return;
  			break;
  		default:
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          // text: lang.defaultErrorMessage,
          text: 'Su petición no ha podido ser procesada, por favor intente de nuevo más tarde.',
          // width: "25rem",
          customClass:
          {
            // title: 'font-size-small',
            content: 'font-size-small-content',
            cancelButton: 'custom-btn-padding',
          },
          showConfirmButton: true,
          showCancelButton: false,
          // confirmButtonText: "{{ Lang::get('toolbar.close') }}",
        });
  	}

    $('.decima-loader').hide();
    $('.decima-next-label').show();

    $('#decima-next').removeAttr('disabled');
    $('#decima-send').removeAttr('disabled');
  	// enableAll();
  }

  $(document).ready(function()
  {
    $.ajaxSetup({
  	  headers: {
  	      'X-CSRF-TOKEN': '{{ csrf_token() }}'
  	  }
  	});

    $('#change-user').tooltip();

    $('#decima-password').onEnter(function()
		{
			$('#decima-next').click();
    });
    
    $('#decima-email').onEnter(function()
		{
			$('#decima-send').click();
		});

    // $('.validate-form .form-control').each(function()
    // {
    //   $(this).focus(function()
    //   {
    //     hideValidate(this);
    //   });
    // });

    $('#change-user').click(function(event)
    {
      // event.preventDefault();

      $("#user-container").addClass("d-none");

      $("#email-container").removeClass("d-none");

      $('#decima-user').val('');

      $('#decima-user').focus();
    });

    $('#decima-next').click(function()
    {
      if($(this).hasAttr('disabled'))
			{
				return;
			}

      $(this).attr('disabled', 'disabled')

      $.ajax(
			{
				type: 'POST',
				data: JSON.stringify({
          'email': $('#decima-user').val(),
          'password': $('#decima-password').val(),
          'kwaai_name': $('input[name="kwaai-name"]').val(),
          'kwaai_time': $('input[name="kwaai-time"]').val()
        }),
				dataType : 'json',
				url: $('#decima-form').attr('action'),
				error: function (jqXHR, textStatus, errorThrown)
				{
					handleServerExceptions(jqXHR, 'decima-form');
				},
				beforeSend:function()
				{
					$('.decima-loader').show();
					$('.decima-next-label').hide();
				},
				success:function(json)
				{
					if(json.message != 'success')
					{
            $('.decima-loader').hide();
  					$('.decima-next-label').show();

            $('#decima-next').removeAttr('disabled');
						// enableAll();

            Swal.fire({
              icon: 'info',
              title: json.messageTitle,
              text: json.messageText,
              // width: "25rem",
              customClass:
              {
                title: 'font-size-small',
                content: 'font-size-small-content',
                cancelButton: 'custom-btn-padding',
              },
              showConfirmButton: true,
              showCancelButton: false,
              // confirmButtonText: "{{ Lang::get('toolbar.close') }}",
            });
					}
					else
					{
						// window.localStorage.clear();
						clearDecimaStorage();
						window.location.replace(json.url);
					}
				}
			});
    });

    $('#decima-send').click(function(event)
    {
      if($(this).hasAttr('disabled'))
			{
				return;
			}

      $(this).attr('disabled', 'disabled');

      $.ajax(
			{
				type: 'POST',
				data: JSON.stringify({
          'email': $('#decima-email').val(),
          'kwaai_name': $('input[name="kwaai-name"]').val(),
          'kwaai_time': $('input[name="kwaai-time"]').val()
        }),
				dataType : 'json',
				url: $('#decima-form').attr('action'),
				error: function (jqXHR, textStatus, errorThrown)
				{
					handleServerExceptions(jqXHR, 'decima-form');
				},
				beforeSend:function()
				{
					$('.decima-loader').show();
					$('.decima-next-label').hide();
				},
				success:function(json)
				{
          $('.decima-loader').hide();
          $('.decima-next-label').show();

          $('#decima-send').removeAttr('disabled');
            // enableAll();
            
					if(!empty(json.status))
					{
            Swal.fire(
            {
              icon: 'success',
              title: 'Success',
              html: json.status,
              // text: json.status,
              // width: "25rem",
              customClass:
              {
                title: 'font-size-small',
                content: 'font-size-small-content',
                cancelButton: 'bg-primary custom-btn-padding',
              },
              showConfirmButton: true,
              showCancelButton: false,
              // cancelButtonText: "Aceptar",
            });
          }
          
          if(!empty(json.error))
					{
            Swal.fire(
            {
              icon: 'info',
              title: 'Oops...',
              text: json.error,
              // width: "25rem",
              customClass:
              {
                title: 'font-size-small',
                content: 'font-size-small-content',
                cancelButton: 'bg-primary custom-btn-padding',
              },
              showConfirmButton: true,
              showCancelButton: false,
              // cancelButtonText: "Aceptar",
            });
					}
				}
			});
    });

    @if(empty($lastLoggedUserEmail))
      $('#decima-user').focus();
    @else
      $('#decima-password').focus();
    @endif
  });
</script>
