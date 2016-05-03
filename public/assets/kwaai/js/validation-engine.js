/**
 * @file
 * Forms validation engine.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

$.fn.displayMessage = function(cssClass,textMsg)
{
	var helpClass='';
	var helpMessageDiv = this.closest('.help-message');
	var icon = 'icon-ok-sign';

	helpMessageDiv.children('.help-message-text').remove();

	if(helpMessageDiv.find("p").length>=1 || helpMessageDiv.find("textarea").length==1)
	{
		helpClass="help-block-custom";
		helpMessageDiv.find(".help-block").filter('p').addClass("help-block-custom-bottom");
	}

	if(cssClass=='has-error')
	{
		helpMessageDiv.append("<p class='help-message-text help-block " + helpClass + "'>" + textMsg + "</p>");
		icon = 'icon-remove-sign';
	}

	var formGroupDiv = this.closest('.form-group');
	formGroupDiv.children('.control-label').children('.icon-ok-sign,.icon-remove-sign,.label-icon-space').remove();
	formGroupDiv.removeClass('has-error');
	formGroupDiv.removeClass('has-success');
	formGroupDiv.addClass(cssClass);
	formGroupDiv.children('.control-label').append("<i class='label-icon-space'>&nbsp;</i><i class='" + icon + "'></i>");
};

$.fn.isValid = function()
{
	var regex;

	if(this.isEmpty() || (this.val()=="__/__/____" && $.type(this.attr('daterange')) != 'undefined'))
	{
		if($.type(this.attr('required')) != 'undefined')
		{
			if(this.attr('daterange')=='from')
			{
				return lang.dateRangeFromRequired;
			}
			else if(this.attr('daterange')=='to')
			{
				return lang.dateRangeToRequired;
			}
			else
			{
				return lang.fieldRequired;
			}
		}
		else
		{
			if(this.val()=="__/__/____")
			{
				this.val("");
			}
			return true;
		}
	}
	else
	{
		if($.type(this.attr('regex')) != 'undefined')
		{
			regex =	this.attr('regex').split('split');
			RegExpObject = new RegExp(regex[1]);

			if(RegExpObject.test($.trim(this.val())))
			{
				if($.type(this.attr('daterange')) != 'undefined')
				{
					try
					{
						$.datepicker.parseDate( lang['dateFormat'], this.val() );
					}
					catch(e)
					{
						switch (this.attr('daterange'))
						{
						case 'from':
							return lang.dateInvalidFrom;
							break;
						case 'to':
							return lang.dateInvalidTo;
							break;
						default:
							return lang.dateInvalid;
							break;
						}
					}
				}

				return true;
			}
			else
			{
				switch (this.attr('daterange'))
				{
					case 'from':
						return lang.dateFrom;
						break;
					case 'to':
						return lang.dateTo;
						break;
					default:
						return lang[regex[0]];
						break;
				}
			}
		}
		else
		{
			return true;
		}
	}
};

$.fn.validateDateRange = function()
{
	var validFrom = this.children("input[daterange='from']").isValid();
	var validTo = this.children("input[daterange='to']").isValid();

	if($.type(validFrom)=="string" && $.type(validTo)!="string")
	{
		this.displayMessage('has-error',validFrom);
	}
	else if ($.type(validFrom)!="string" && $.type(validTo)=="string")
	{
		this.displayMessage('has-error',validTo);
	}
	else if ($.type(validFrom)=="string" && $.type(validTo)=="string")
	{
		this.displayMessage('has-error',validFrom + '<br>' + validTo);
	}
	else
	{
		if(!this.children("input[daterange='from']").isEmpty() && !this.children("input[daterange='to']").isEmpty())
		{
			var dateFrom = $.datepicker.parseDate( lang['dateFormat'], this.children("input[daterange='from']").val() );
			var dateTo = $.datepicker.parseDate( lang['dateFormat'], this.children("input[daterange='to']").val() );

			if(dateFrom.getTime() > dateTo.getTime())
			{
				this.displayMessage('has-error', lang['dateRangeValidation']);
			}
			else
			{
				$(this).displayMessage('has-success','');
			}
		}
		else if(this.children("input[daterange='from']").isEmpty() && !this.children("input[daterange='to']").isEmpty())
		{
			this.displayMessage('has-error', lang['dateRangeValidationFrom']);
		}
		else if(!this.children("input[daterange='from']").isEmpty() && this.children("input[daterange='to']").isEmpty())
		{
			this.displayMessage('has-error', lang['dateRangeValidationTo']);
		}
		else
		{
			$(this).displayMessage('has-success','');
		}
	}

	return;
};

$.fn.addRequiredLabel = function()
{
	switch (this.closest("form").attr('class'))
	{
		case 'form-horizontal':
			if(this.is("textarea"))
			{
				$('#' + this.attr('id') + '-label-container').append("<p class='help-block pull-left'>" + lang.fieldRequiredHelpText + "</p>");
				$('#' + this.attr('id') + '-label').addClass('pull-right');
			}
			else
			{
				this.closest(".help-message").append("<p class='help-block'>" + lang.fieldRequiredHelpText + "</p>");
			}
			break;
		default:
			this.closest(".form-group").find('.sr-only').addClass('sr-only-custom');
			this.closest(".form-group").prepend("<spam class='help-block-custom help-block pull-right'>" + lang.fieldRequiredHelpText + "</spam>");
			break;
	}
};

$.fn.validateCheckboxsInline = function()
{
	var valid = false;

	this.find('input[type=checkbox]').each(function()
	{
		if($(this).is(':checked'))
		{
			valid = true;
			return false;
		}
	});

	if(valid)
	{
		$(this).displayMessage('has-success','');
	}
	else
	{
		$(this).displayMessage('has-error',lang.checkboxRequired);
	}
};

$.fn.addFormFieldsValidations = function()
{
	this.find('input[type=text],input[type=password],textarea,select').each(function()
	{
		if($.type($(this).attr('ignore')) != 'undefined')
		{
			return true;
		}

		if($(this).attr('daterange')=='from')
		{
			 return true;
		}

		if($.type($(this).attr('required')) != 'undefined')
		{
			$(this).addRequiredLabel();
		}

		if($(this).attr('daterange')=='to')
		{
			$(this).focusout(function()
			{
				$(this).parent().validateDateRange();
			});

			return true;
		}

		if($.type($(this).attr('autocompletemacro')) != 'undefined')
		{
			$(this).on( "autocompletechange", function( event, ui )
			{
		        if ( ui.item )
		        {
		        	$(this).displayMessage('has-success','');
		        }

		        if($(this).isEmpty())
		        {
		        	return;
		        }

		        var value = $(this).val().toLowerCase(), valid = false,autocomplete = this;

		        $.each($(this).autocomplete( "option", "source" ), function(index, element)
		        {
		            if($.isPlainObject(element))
		            {
                  elementLabel = $.isNumeric(element.label)?element.label.toString().toLowerCase():element.label.toLowerCase();
                  elementValue = $.isNumeric(element.value)?element.value.toString().toLowerCase():element.value.toLowerCase();

		            	if (elementLabel == value || elementValue == value)
		            	{
		                    valid = true;
		                    $(autocomplete).data('ui-autocomplete')._trigger('select', 'autocompleteselect', {item: {label:element.label, value:element.value}});
		                    return false;
		                 }
		            }
		            else
		            {
		            	if (element.toLowerCase() == value)
		            	{
		                    valid = true;
		                    $(autocomplete).val(element);
		                    return false;
		                 }
		            }
		        });

		        if ( valid )
		        {
		        	$(this).displayMessage('has-success','');
		        }
		        else
		        {
		        	$(this).displayMessage('has-error',lang.autocompleteValidation);;
		        }

			});
		}

		$(this).focusout(function()
		{
			var valid = $(this).isValid();

			if($.type(valid)=="string")
			{
				$(this).displayMessage('has-error',valid);
			}
			else
			{
				if($.type($(this).attr('regex')) != 'undefined')
				{
					regex =	$(this).attr('regex').split('split');
					switch (regex[0])
					{
						case 'positiveInteger':
						case 'positiveIntegerNoZero':
						case 'signedInteger':
							$(this).val($.fmatter.util.NumberFormat($(this).val().replace(/,/g,''),$.jgrid.formatter.integer));
							break;
						case 'money':
							$(this).val($.fmatter.util.NumberFormat($(this).val().replace(/,/g,''),$.jgrid.formatter.number));
							break;
						default:
							break;
					}
				}

				$(this).displayMessage('has-success','');

				if($.type($(this).attr('autocompletemacro')) != 'undefined')
				{
					$(this).trigger('autocompletechange',['']);
				}
			}
		});

		if($.type($(this).attr('regex')) != 'undefined')
		{
			regex =	$(this).attr('regex').split('split');

			if(regex[2])
			{
				$(this).keypress(function(event)
				{
					if(keyPressCrossBrowserCompatibility(event))
					{
						return true;
					}

					regex =	$(this).attr('regex').split('split');
					chr = String.fromCharCode(event.charCode == null ? event.keyCode : event.charCode);
					RegExpObject = new RegExp(regex[2]);

					if(!RegExpObject.test(chr))
					{
						return false;
					}

					return true;
				 });
			}
		}

		if($(this).is("select"))
		{
			$(this).change(function()
			{
				$(this).focusout();
			});
		}
	});

	this.find('input[type=radio]').each(function()
	{
		if($.type($(this).attr('ignore')) != 'undefined')
		{
			return true;
		}

		$(this).click(function()
		{
			$(this).displayMessage('has-success','');
		});

		if($(this).parent().next().length==0)
		{
			$(this).focusout(function()
			{
				if(!$('input[name=' + $(this).attr('name') + ']:checked').val() && $(this).parent().parent().attr('required'))
				{
					$(this).displayMessage('has-error',lang.radioRequired);
				}
				else
				{
					$(this).displayMessage('has-success','');
				}
			});

			if($(this).parent().parent().attr('required'))
			{
				$(this).addRequiredLabel();
			}
		}
	});

	this.find('input[type=checkbox]').each(function()
	{
		if($.type($(this).attr('ignore')) != 'undefined')
		{
			return true;
		}

		if($(this).is(':checked'))
		{
			$(this).displayMessage('has-success','');
		}

		if($(this).parent().next().length==0)
		{
			$(this).focusout(function()
			{
				if($.type($(this).parent().parent().attr('required')) != 'undefined')
				{
					$(this).parent().parent().validateCheckboxsInline();
				}
				else
				{
					$(this).displayMessage('has-success','');
				}
			});

			if($.type($(this).parent().parent().attr('required')) != 'undefined')
			{
				$(this).addRequiredLabel();
			}
		}

		$(this).click(function()
		{
			if(!$(this).is(':checked'))
			{
				if($.type($(this).parent().parent().attr('required')) != 'undefined')
				{
					$(this).parent().parent().validateCheckboxsInline();
				}
			}
			else
			{
				$(this).displayMessage('has-success','');
			}
		});
	});
};

$.fn.isFormValid = function()
{
	this.find('input,textarea,select').each(function()
	{
		$(this).focusout();
	});

	if(this.find(".has-error").length>0)
	{
		this.find(".has-error").first().find(".form-control").focus();
		$.scrollTo(this.children(".has-error").first().position());
		this.find('.has-error').effect('shake',null,600);

		return false;
	}
	else
	{
		return true;
	}
};
