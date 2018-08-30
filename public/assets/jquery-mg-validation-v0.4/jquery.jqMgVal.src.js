/**
* @license jqMgVal  v0.1 - jQuery MG Validation Plugin
* Copyright (c) 2014, Mario Gallegos, freelance@mariogallegos.com
* jqMgVal's Home page can be found at http://www.
* Licensed under the MIT license
* http://www.opensource.org/licenses/mit-license.php
*/

(function ( $ )
{
	"use strict";

	var opts = {};

	$.fn.jqMgVal = function(action, options)
	{
		opts = $.extend(true, {}, $.fn.jqMgVal.defaults, options);

		switch (action)
		{
			case 'addFormFieldsValidations':
				this.jqMgValAddFormFieldsValidations();
				break;
			case 'clearForm':
				this.jqMgValclearForm();
				break;
			case 'clearContextualClasses':
				this.jqMgValclearContextualClasses();
				break;
			case 'isFormValid':
				return this.jqMgValIsFormValid();
				break;
		}

		return this;
	};

	$.fn.jqMgVal.defaults = {
		helpMessageLocation: 'append', //prepend
		helpMessageClass: 'mg-hm',
		invalidFieldJqueryUiEffect: 'shake', //none, ...
		invalidFieldJqueryUiEffectDuration: 600,
		successIconClass: 'glyphicon glyphicon-ok',
		failureIconClass: 'glyphicon glyphicon-remove',
		fieldDivContainer: 'form-group',
		scrollToFirstFieldWithError: true,
		validators:{
			positiveInteger:{
				formatter: {
						thousandsSeparator: ',',
						defaultValue: '0'
				},
				validationRegex: '^([1-9]{1}[0-9]{0,2}(\\,[0-9]{3})*|[1-9]{1}[0-9]{0,}|0)$',
				allowedCharactersRegex: '^(\\d|,)$',
				regexHelpMessageLangId:'positiveIntegerRegexHelpMessage'
			},
			positiveIntegerNoZero:{
				formatter: {
						thousandsSeparator: ',',
						defaultValue: '1'
				},
				validationRegex: '^([1-9]{1}[0-9]{0,2}(\\,[0-9]{3})*|[1-9]{1}[0-9]{0,})$',
				allowedCharactersRegex: '^(\\d|,)$',
				regexHelpMessageLangId:'positiveIntegerNoZeroRegexHelpMessage'
			},
			signedInteger:{
				formatter: {
						thousandsSeparator: ',',
						defaultValue: '0'
				},
				validationRegex: '^(\\+|-)?([1-9]{1}[0-9]{0,2}(\\,[0-9]{3})*|[1-9]{1}[0-9]{0,}|0)$',
				allowedCharactersRegex: '^(\\d|,|\\+|-)$',
				regexHelpMessageLangId:'signedIntegerRegexHelpMessage'
			},
			money:{
				formatter: {
						decimalSeparator: '.',
						thousandsSeparator: ',',
						decimalPlaces: 2,
						defaultValue: '0.00'
				},
				validationRegex: '^\\$?([1-9]{1}[0-9]{0,2}(\\,[0-9]{3})*(\\.[0-9]{0,2})?|[1-9]{1}[0-9]{0,}(\\.[0-9]{0,2})?|0(\\.[0-9]{0,2})?|(\\.[0-9]{1,2})?)$',
				allowedCharactersRegex: '^(\\d|,|\\.)$',
				regexHelpMessageLangId:'moneyRegexHelpMessage'
			},
			money2:{
				formatter: {
						decimalSeparator: '.',
						thousandsSeparator: ',',
						decimalPlaces: 2,
						defaultValue: '0.00'
				},
				validationRegex: '^\\$?([1-9]{1}[0-9]{0,2}(\\,[0-9]{3})*(\\.[0-9]{0,2})?|[1-9]{1}[0-9]{0,}(\\.[0-9]{0,2})?|0(\\.[0-9]{0,2})?|(\\.[0-9]{1,2})?)$',
				allowedCharactersRegex: '^(\\d|,|\\.)$',
				regexHelpMessageLangId:'moneyRegexHelpMessage'
			},
			money3:{
				formatter: {
						decimalSeparator: '.',
						thousandsSeparator: ',',
						decimalPlaces: 3,
						defaultValue: '0.00'
				},
				validationRegex: '^\\$?([1-9]{1}[0-9]{0,3}(\\,[0-9]{3})*(\\.[0-9]{0,3})?|[1-9]{1}[0-9]{0,}(\\.[0-9]{0,3})?|0(\\.[0-9]{0,3})?|(\\.[0-9]{1,3})?)$',
				allowedCharactersRegex: '^(\\d|,|\\.)$',
				regexHelpMessageLangId:'moneyRegexHelpMessage'
			},
			money4:{
				formatter: {
						decimalSeparator: '.',
						thousandsSeparator: ',',
						decimalPlaces: 4,
						defaultValue: '0.00'
				},
				validationRegex: '^\\$?([1-9]{1}[0-9]{0,4}(\\,[0-9]{3})*(\\.[0-9]{0,4})?|[1-9]{1}[0-9]{0,}(\\.[0-9]{0,4})?|0(\\.[0-9]{0,4})?|(\\.[0-9]{1,4})?)$',
				allowedCharactersRegex: '^(\\d|,|\\.)$',
				regexHelpMessageLangId:'moneyRegexHelpMessage'
			},
			money5:{
				formatter: {
						decimalSeparator: '.',
						thousandsSeparator: ',',
						decimalPlaces: 2,
						defaultValue: '0.00'
				},
				validationRegex: '^\\$?([1-9]{1}[0-9]{0,5}(\\,[0-9]{3})*(\\.[0-9]{0,5})?|[1-9]{1}[0-9]{0,}(\\.[0-9]{0,5})?|0(\\.[0-9]{0,5})?|(\\.[0-9]{1,5})?)$',
				allowedCharactersRegex: '^(\\d|,|\\.)$',
				regexHelpMessageLangId:'moneyRegexHelpMessage'
			},
			money6:{
				formatter: {
						decimalSeparator: '.',
						thousandsSeparator: ',',
						decimalPlaces: 2,
						defaultValue: '0.00'
				},
				validationRegex: '^\\$?([1-9]{1}[0-9]{0,6}(\\,[0-9]{3})*(\\.[0-9]{0,6})?|[1-9]{1}[0-9]{0,}(\\.[0-9]{0,6})?|0(\\.[0-9]{0,6})?|(\\.[0-9]{1,6})?)$',
				allowedCharactersRegex: '^(\\d|,|\\.)$',
				regexHelpMessageLangId:'moneyRegexHelpMessage'
			},
			signedMoney:{
				formatter: {
						decimalSeparator: '.',
						thousandsSeparator: ',',
						decimalPlaces: 2,
						defaultValue: '0.00'
				},
				validationRegex: '^(\\+|-)?([1-9]{1}[0-9]{0,2}(\\,[0-9]{3})*(\\.[0-9]{0,2})?|[1-9]{1}[0-9]{0,}(\\.[0-9]{0,2})?|0(\\.[0-9]{0,2})?|(\\.[0-9]{1,2})?)$',
				allowedCharactersRegex: '^(\\d|,|\\+|-,|\\.)$',
				regexHelpMessageLangId:'moneyRegexHelpMessage'
			},
			signedMoney2:{
				formatter: {
						decimalSeparator: '.',
						thousandsSeparator: ',',
						decimalPlaces: 2,
						defaultValue: '0.00'
				},
				validationRegex: '^(\\+|-)?([1-9]{1}[0-9]{0,2}(\\,[0-9]{3})*(\\.[0-9]{0,2})?|[1-9]{1}[0-9]{0,}(\\.[0-9]{0,2})?|0(\\.[0-9]{0,2})?|(\\.[0-9]{1,2})?)$',
				allowedCharactersRegex: '^(\\d|,|\\+|-,|\\.)$',
				regexHelpMessageLangId:'moneyRegexHelpMessage'
			},
			signedMoney3:{
				formatter: {
						decimalSeparator: '.',
						thousandsSeparator: ',',
						decimalPlaces: 3,
						defaultValue: '0.00'
				},
				validationRegex: '^(\\+|-)?([1-9]{1}[0-9]{0,3}(\\,[0-9]{3})*(\\.[0-9]{0,3})?|[1-9]{1}[0-9]{0,}(\\.[0-9]{0,3})?|0(\\.[0-9]{0,3})?|(\\.[0-9]{1,3})?)$',
				allowedCharactersRegex: '^(\\d|,|\\+|-,|\\.)$',
				regexHelpMessageLangId:'moneyRegexHelpMessage'
			},
			signedMoney4:{
				formatter: {
						decimalSeparator: '.',
						thousandsSeparator: ',',
						decimalPlaces: 4,
						defaultValue: '0.00'
				},
				validationRegex: '^(\\+|-)?([1-9]{1}[0-9]{0,4}(\\,[0-9]{3})*(\\.[0-9]{0,4})?|[1-9]{1}[0-9]{0,}(\\.[0-9]{0,4})?|0(\\.[0-9]{0,4})?|(\\.[0-9]{1,4})?)$',
				allowedCharactersRegex: '^(\\d|,|\\+|-,|\\.)$',
				regexHelpMessageLangId:'moneyRegexHelpMessage'
			},
			signedMoney5:{
				formatter: {
						decimalSeparator: '.',
						thousandsSeparator: ',',
						decimalPlaces: 2,
						defaultValue: '0.00'
				},
				validationRegex: '^(\\+|-)?([1-9]{1}[0-9]{0,5}(\\,[0-9]{3})*(\\.[0-9]{0,5})?|[1-9]{1}[0-9]{0,}(\\.[0-9]{0,5})?|0(\\.[0-9]{0,5})?|(\\.[0-9]{1,5})?)$',
				allowedCharactersRegex: '^(\\d|,|\\+|-,|\\.)$',
				regexHelpMessageLangId:'moneyRegexHelpMessage'
			},
			signedMoney6:{
				formatter: {
						decimalSeparator: '.',
						thousandsSeparator: ',',
						decimalPlaces: 2,
						defaultValue: '0.00'
				},
				validationRegex: '^(\\+|-)?([1-9]{1}[0-9]{0,6}(\\,[0-9]{3})*(\\.[0-9]{0,6})?|[1-9]{1}[0-9]{0,}(\\.[0-9]{0,6})?|0(\\.[0-9]{0,6})?|(\\.[0-9]{1,6})?)$',
				allowedCharactersRegex: '^(\\d|,|\\+|-,|\\.)$',
				regexHelpMessageLangId:'moneyRegexHelpMessage'
			}
		},
		lang: {
				requiredFieldText: '* Required field',
				dateRangeValidation: 'La fecha inicial no puede ser mayor a la fecha final.',
				invalidDateHelpMessage: 'La fecha ingresada no cumple con el formato: día/mes/año.',
				invalidDateTimeHelpMessage: 'La fecha y hora ingresada no cumple con el formato: día/mes/año hora:minutos a.m.',
				positiveIntegerRegexHelpMessage: 'The value entered must be a positive integer, example: 1,000 o 1000',
				positiveIntegerNoZeroRegexHelpMessage: 'The value entered must be a positive integer (zero is not allowed), example: 1,000 o 1000',
				signedIntegerRegexHelpMessage: 'The value entered must be an integer, example: -1 o 1 o 1,000 o 1000',
				moneyRegexHelpMessage: 'The value entered must be numeric, example: 1,000.00 o 1000.00 o 1000',
				defaultRegexHelpMessage: 'The value entered is not valid.'
		}
	};

	$.fn.jqMgValAddRequiredLabel = function()
	{
		var helpMessageLocation = opts.helpMessageLocation;

		if(this.attr('data-mg-daterange') == 'to')
		{
			return;
		}

		if(this.attr('data-mg-help-message-location') != undefined)
		{
			helpMessageLocation = this.attr('data-mg-help-message-location');
		}

		if(helpMessageLocation == 'append')
		{
			this.closest('.' + opts.helpMessageClass).append('<p class="help-block form-text text-muted">' + opts.lang.requiredFieldText + '</p>');
		}
		else if(helpMessageLocation == 'prepend')
		{
			this.closest('.' + opts.helpMessageClass).find('.sr-only').attr('style','position: inherit !important;');
			this.closest('.' + opts.helpMessageClass).prepend('<spam class="help-block form-text text-muted pull-right" style="margin: 0 !important;">' + opts.lang.requiredFieldText + '</spam>');
		}
		else
		{
			console.log('Invalid help message location: ' + helpMessageLocation + '. Use append or prepend.');
		}
	};

	$.fn.jqMgValIsEmpty = function()
	{
		if(this.is('select'))
		{
			return this.val() == "";
		}
		else
		{
			return $.trim(this.val()) == "";
		}
	};

	$.fn.jqMgValIsValid = function()
	{
		var regex;

		if(this.jqMgValIsEmpty() || (this.val() == '__/__/____' && this.attr('data-mg-validator') == 'date') || (this.val() == '__/__/____ __:__ _._.' && this.attr('data-mg-validator') == 'datetime'))
		{
			if(this.attr('data-mg-required') != undefined)
			{
				return '';
			}
			else
			{
				if(this.val() == '__/__/____' || this.val() == '__/__/____ __:__ _._.')
				{
					this.val('');
				}

				return true;
			}
		}
		else
		{
			if(this.attr('data-mg-regex') != undefined)
			{
				var RegExpObject = new RegExp(this.attr('data-mg-regex'));

				if(RegExpObject.test($.trim(this.val())))
				{
					return true;
				}
				else
				{
					if(this.attr('data-mg-regex-help-message') != undefined)
					{
						return this.attr('data-mg-regex-help-message');
					}
					else
					{
						return opts.lang.defaultRegexHelpMessage;
					}
				}
			}
			else if(this.attr('data-mg-validator')  == 'date')
			{
				try
				{
					$.datepicker.parseDate( $.datepicker._defaults.dateFormat, this.val() );

					return true;
				}
				catch(e)
				{
					return opts.lang.invalidDateHelpMessage;
				}
			}
			else if(this.attr('data-mg-validator')  == 'datetime')
			{
				// console.log('entre 1');
				// console.log($.datepicker._getInst(this[0]));
				// console.log($.datepicker.parseDateTime($.datepicker._defaults.dateFormat,  $.timepicker._defaults.timeFormat, this.val(), $.datepicker._getFormatConfig($.datepicker._getFormatConfig($.datepicker._getInst(this[0]))), $.timepicker._defaults));
				// $.datepicker.parseDateTime($.datepicker._defaults.dateFormat,  $.timepicker._defaults.timeFormat, this.val(), $.datepicker._getFormatConfig($.datepicker._getFormatConfig($.datepicker._getInst(this[0]))), $.timepicker._defaults)
				// $.datepicker.parseDateTime($.datepicker._defaults.dateFormat, $.timepicker._defaults.timeFormat, $('#inv-mm-date').val(), $.datepicker._getFormatConfig($.datepicker._getInst($('#inv-mm-date')[0])), $.timepicker._defaults);
				// console.log($.datepicker.parseDateTime($.datepicker._defaults.dateFormat, $.timepicker._defaults.timeFormat, this.val(), $.datepicker._getFormatConfig($.datepicker._getInst(this[0])), $.timepicker._defaults));
				// console.log($.datepicker.parseDateTime($.datepicker._defaults.dateFormat, $.timepicker._defaults.timeFormat, this.val(), $.datepicker._getFormatConfig($.datepicker._getInst(this[0])), $.timepicker._defaults));

				try
				{
					console.log('entre 1');

					$.datepicker.parseDateTime($.datepicker._defaults.dateFormat, $.timepicker._defaults.timeFormat, this.val(), $.datepicker._getFormatConfig($.datepicker._getInst(this[0])), $.timepicker._defaults);
					// parseRes = $.datepicker.parseDateTime($.datepicker._defaults.dateFormat, $.timepicker._defaults.timeFormat, $('#inv-mm-date').val(), $.datepicker._getFormatConfig($.datepicker._getInst($('#inv-mm-date')[0])), $.timepicker._defaults);

					console.log('entre 2');
					// console.log(parseRes);

					return true;

					// if(parseRes)
					// {
					// 	return true;
					// }

					// return opts.lang.invalidDateTimeHelpMessage;
				}
				catch(e)
				{
					console.log(e);
					console.log('entre 1.1');
					console.log(opts.lang.invalidDateTimeHelpMessage);
					return opts.lang.invalidDateTimeHelpMessage;
				}
			}
			else
			{
				return true;
			}
		}
	};

	$.fn.jqMgValDisplayMessage = function(cssClass, textMsg)
	{
		var helpMessageLocation = opts.helpMessageLocation;

		if(this.attr('data-mg-help-message-location') != undefined)
		{
			helpMessageLocation = this.attr('data-mg-help-message-location');
		}

		var helpMessageTextStyle='position: inherit;top: inherit;right: inherit;width: inherit;height: inherit;line-height: inherit;text-align: inherit;';
		var helpMessageDiv = this.closest('.' + opts.helpMessageClass);
		var icon = opts.successIconClass;

		helpMessageDiv.children('.mg-hmt').remove();

		if(helpMessageDiv.find("p").length >= 1 || helpMessageDiv.find("textarea").length == 1)
		{
			helpMessageTextStyle += 'margin: 0 !important;';
			helpMessageDiv.find(".help-block").filter('p').attr('style', 'margin-bottom: 0 !important;');
		}

		if(cssClass == 'has-error has-danger')
		{
			helpMessageDiv.append('<p class="mg-hmt help-block form-control-feedback" style="' + helpMessageTextStyle + '">' + textMsg + '</p>');
			icon = opts.failureIconClass;
		}

		var formGroupDiv = this.closest('.' + opts.fieldDivContainer);
		formGroupDiv.children('.control-label').children('.' + opts.successIconClass.split(' ')[0] + ',.' + opts.failureIconClass.split(' ')[0] + ',.mg-is').remove();
		//formGroupDiv.children('label').children('.' + opts.successIconClass.split(' ')[0] + ',.' + opts.failureIconClass.split(' ')[0] + ',.mg-is').remove();
		formGroupDiv.removeClass('has-error has-danger');
		formGroupDiv.removeClass('has-success');
		formGroupDiv.addClass(cssClass);
		formGroupDiv.children('.control-label').append("<i class='mg-is'>&nbsp;</i><i class='" + icon + "'></i>");
		//formGroupDiv.children('label').append("<i class='mg-is'>&nbsp;</i><i class='" + icon + "'></i>");
	};

	$.fn.jqMgValValidateDateRange = function()
	{
		var validFrom = this.children("input[data-mg-daterange='from']").jqMgValIsValid();
		var validTo = this.children("input[data-mg-daterange='to']").jqMgValIsValid();

		if($.type(validFrom) == "string" && $.type(validTo) != "string")
		{
			this.jqMgValDisplayMessage('has-error has-danger', validFrom);
		}
		else if ($.type(validFrom) != "string" && $.type(validTo) == "string")
		{
			this.jqMgValDisplayMessage('has-error has-danger', validTo);
		}
		else if ($.type(validFrom) == "string" && $.type(validTo) == "string")
		{
			this.jqMgValDisplayMessage('has-error has-danger', validFrom + '<br>' + validTo);
		}
		else
		{
			if(!this.children("input[data-mg-daterange='from']").isEmpty() && !this.children("input[data-mg-daterange='to']").isEmpty())
			{
				var dateFrom = $.datepicker.parseDate( $.datepicker._defaults.dateFormat, this.children("input[data-mg-daterange='from']").val() );
				var dateTo = $.datepicker.parseDate( $.datepicker._defaults.dateFormat, this.children("input[data-mg-daterange='to']").val() );

				if(dateFrom.getTime() > dateTo.getTime())
				{
					this.jqMgValDisplayMessage('has-error has-danger', lang.dateRangeValidation);
				}
				else
				{
					this.jqMgValDisplayMessage('has-success','');
				}
			}
			// else if(this.children("input[daterange='from']").isEmpty() && !this.children("input[daterange='to']").isEmpty())
			// {
			// 	this.jqMgValDisplayMessage('has-error', lang['dateRangeValidationFrom']);
			// }
			// else if(!this.children("input[daterange='from']").isEmpty() && this.children("input[daterange='to']").isEmpty())
			// {
			// 	this.jqMgValDisplayMessage('has-error', lang['dateRangeValidationTo']);
			// }
			else
			{
				this.jqMgValDisplayMessage('has-success','');
			}
		}

		return;
	};

	$.fn.jqMgValKeyPressCrossBrowserCompatibility = function(event)
	{
		// console.log("entre");
		// console.log("keycode: "+event.keyCode+" charcode: "+event.charCode);

		//Fix firefox
		switch (event.keyCode)
		{
			case 8://backspace
			case 9://tab
			case 33://Re pág.
			case 34://Av Pág.
			case 35://fin
			case 36://inicio
			case 37://left arrow
			case 39://right arrow
			case 45://insert
			case 46://Supr
				return true;
				break;
			default:
				return false;
		}
	};

	$.fn.jqMgValAddFormFieldsValidations = function()
	{
		this.find('input[type=text],input[type=time],input[type=password],input[type=file],textarea,select').each(function()
		{
			if($(this).attr('data-mg-validator') != undefined && $(this).attr('data-mg-validator') != 'date' && $(this).attr('data-mg-validator') != 'datetime')
			{
				if(opts['validators'][$(this).attr('data-mg-validator')]['validationRegex'] != undefined)
				{
					$(this).attr('data-mg-regex', opts['validators'][$(this).attr('data-mg-validator')]['validationRegex']);
				}

				if(opts['validators'][$(this).attr('data-mg-validator')]['allowedCharactersRegex'] != undefined)
				{
					$(this).attr('data-mg-allowed-characters-regex', opts['validators'][$(this).attr('data-mg-validator')]['allowedCharactersRegex']);
				}

				if(opts['validators'][$(this).attr('data-mg-validator')]['formatter'] != undefined)
				{
					$(this).attr('data-mg-formatter', JSON.stringify(opts['validators'][$(this).attr('data-mg-validator')]['formatter']));
				}

				if(opts['validators'][$(this).attr('data-mg-validator')]['regexHelpMessageLangId'] != undefined)
				{
					$(this).attr('data-mg-regex-help-message', opts.lang[opts['validators'][$(this).attr('data-mg-validator')]['regexHelpMessageLangId']]);
				}
			}

			if($(this).attr('data-mg-ignore') != undefined)
			{
				return true;
			}

			if($(this).attr('data-mg-required') != undefined)
			{
				$(this).jqMgValAddRequiredLabel();
			}

			if($(this).attr('data-mg-daterange') == 'from')
			{
				return true;
			}

			if($(this).attr('data-mg-daterange')=='to')
			{
				$(this).focusout(function()
				{
					$(this).parent().jqMgValValidateDateRange();
				});

				return true;
			}

			if($(this).attr('data-mg-custom-validator') != undefined)
			{
				// var customFunction = $(this).attr('data-mg-custom-validator');
				// console.log(customFunction);
				jqMgValAutocompleteValidator($(this));
			}
			else
			{
				$(this).focusout(function()
				{
					var valid = $(this).jqMgValIsValid();

					if($.type(valid) == 'string')
					{
						$(this).jqMgValDisplayMessage('has-error has-danger', valid);
					}
					else
					{
						if($(this).attr('data-mg-formatter') != undefined)
						{
							// $(this).val($.fmatter.util.NumberFormat($(this).val().replace(/,/g,''), JSON.parse($(this).attr('data-mg-formatter')) ));
							$(this).val($.fmatter.NumberFormat($(this).val().replace(/,/g,''), JSON.parse($(this).attr('data-mg-formatter')) ));
						}

						$(this).jqMgValDisplayMessage('has-success', '');
					}
				});
			}

			if($(this).attr('data-mg-allowed-characters-regex') != undefined)
			{
				$(this).keypress(function(event)
				{
					if($.fn.jqMgValKeyPressCrossBrowserCompatibility(event))
					{
						return true;
					}

					var chr = String.fromCharCode(event.charCode == null ? event.keyCode : event.charCode);
					var RegExpObject = new RegExp($(this).attr('data-mg-allowed-characters-regex'));

					if(!RegExpObject.test(chr))
					{
						return false;
					}

					return true;
				});
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
				$(this).jqMgValDisplayMessage('has-success','');
			});

			// console.log($(this).parent().next().length);
			if(!$(this).parent().parent().next().hasClass('radio'))
			{
				$(this).focusout(function()
				{
					if(!$('input[name=' + $(this).attr('name') + ']:checked').val() && $(this).parent().parent().parent().attr('data-mg-required') != undefined)
					{
						$(this).jqMgValDisplayMessage('has-error has-danger', '');
					}
					else
					{
						$(this).jqMgValDisplayMessage('has-success','');
					}
				});

				//Tratar de estandarizar esta parte
				if($(this).parent().parent().parent().attr('data-mg-required') != undefined)
				{
					$(this).jqMgValAddRequiredLabel();
				}
			}
		});

		/*this.find('input[type=checkbox]').each(function()
		{
			if($.type($(this).attr('ignore')) != 'undefined')
			{
				return true;
			}

			if($(this).is(':checked'))
			{
				$(this).jqMgValDisplayMessage('has-success','');
			}

			if($(this).parent().next().length==0)
			{
				$(this).focusout(function()
				{
					if($(this).parent().parent().parent().attr('data-mg-required') != undefined)
					{
						$(this).parent().parent().validateCheckboxsInline();
					}
					else
					{
						$(this).jqMgValDisplayMessage('has-success','');
					}
				});

				//Tratar de estandarizar esta parte
				if($(this).parent().parent().parent().attr('data-mg-required') != undefined)
				{
					$(this).jqMgValAddRequiredLabel();
				}
			}

			$(this).click(function()
			{
				if(!$(this).is(':checked'))
				{
					if($(this).parent().parent().parent().attr('data-mg-required') != undefined)
					{
						// $(this).parent().parent().validateCheckboxsInline();
						console.log('pendiente de implementar');
					}
				}
				else
				{
					$(this).jqMgValDisplayMessage('has-success','');
				}
			});
		});*/
	};

	$.fn.jqMgValclearForm = function()
	{
		this.find('input[type=text],input[type=time],input[type=password],input[type=hidden],input[type=file],textarea').each(function()
		{
			if($(this).attr('name') != '_token' && $(this).attr('name') != 'fc-kwaai-time' && $(this).attr('data-mg-clear-ignored') == undefined)
			{
				$(this).val('');
			}
		});

		this.find('select').each(function()
		{
			$(this).val($('#' + $(this).attr('id') + ' option:first').val());
		});

		this.find('input[type=checkbox]').each(function()
		{
			if($(this).attr('data-mg-clear-ignored') == undefined)
			{
				$(this).removeAttr('checked');
			}
		});

		this.find('.has-error').each(function()
		{
			$(this).removeClass('has-error');
		});

		this.find('.has-danger').each(function()
		{
			$(this).removeClass('has-danger');
		});

		this.find('.has-success').each(function()
		{
			$(this).removeClass('has-success');
		});

		this.find('.control-label').each(function()
		{
			$(this).find('.' + opts.successIconClass.split(' ')[0] + ',.' + opts.failureIconClass.split(' ')[0] + ',.mg-is').remove();
		});

		this.find('.mg-hmt').remove();
	};

	//V0.2
	$.fn.jqMgValclearContextualClasses = function()
	{
		this.find('.has-error').each(function()
		{
			$(this).removeClass('has-error');
		});

		this.find('.has-danger').each(function()
		{
			$(this).removeClass('has-danger');
		});

		this.find('.has-success').each(function()
		{
			$(this).removeClass('has-success');
		});

		this.find('.control-label').each(function()
		{
			$(this).find('.' + opts.successIconClass.split(' ')[0] + ',.' + opts.failureIconClass.split(' ')[0] + ',.mg-is').remove();
		});

		this.find('.mg-hmt').remove();
	};

	$.fn.jqMgValIsFormValid = function()
	{
		this.find('input,textarea,select').each(function()
		{
			$(this).focusout();
		});

		if(this.find('.has-error').length>0 || this.find('.has-danger').length>0)
		{
			this.find('.has-error').first().find('.form-control').focus();
			// this.find('.has-danger').first().find('.form-control').focus();

			// $.scrollTo(this.find('.has-error').first().offset());
			// $.scrollTo(this.find('.has-error').first().position());
			// $.scrollTo(this.find('.has-danger').first().position());

			//console.log(opts.scrollToFirstFieldWithError);

			if(opts.scrollToFirstFieldWithError)
			{
				if(this.children('.has-error').first().offset() != undefined)
				{
					$.scrollTo(this.children('.has-error').first().offset());
				}
				// $.scrollTo(this.children('.has-danger').first().position());
			}

			if(opts.invalidFieldJqueryUiEffect != 'none')
			{
					this.find('.has-error').effect(opts.invalidFieldJqueryUiEffect, null, opts.invalidFieldJqueryUiEffectDuration);
					// this.find('.has-danger').effect(opts.invalidFieldJqueryUiEffect, null, opts.invalidFieldJqueryUiEffectDuration);
			}

			return false;
		}
		else
		{
			return true;
		}
	};
}( jQuery ));

/*

var lang = [];
lang['fieldRequiredHelpText'] = '* Campo requerido';

$.fn.displayMessage = function(cssClass,textMsg)
{
	var helpClass='';
	var helpMessageDiv = this.closest('.help-message');
	var icon = 'icon-ok-sign';

	helpMessageDiv.children('.help-message-text').remove();

	if(helpMessageDiv.find("p").length >= 1 || helpMessageDiv.find("textarea").length == 1)
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
*/
