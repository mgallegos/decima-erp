/**
 * @file
 * Javascript helper functions.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

/**
 * After a new row is inserted, the grid will be reloaded and the first row will be selected.
 *
 * @param string sortname
 * 	The column according to which the data is to be sorted, default: id.
 * @param string sortorder
 * 	The sorting order asc for ascending or desc for descending, default: desc.
 * @param string page
 * 	The page to ..., default: 1.
 *
 *  @returns void
 */
$.fn.reloadAfterRowInserted = function(sidx, sord, page)
{
	var jqGrid = this;

	sidx = sidx || 'id';

	sord = sord || 'desc';

	page = page || 1;

	jqGrid.setGridParam({'sortname':sidx, 'sortorder':sord, 'page':page}).trigger('reloadGrid');

	// setTimeout(function()
	// {
	// 	jqGrid.setSelection(1);
	// },500);
};

/**
 * Get cell id of all grid selected rows.
 *
 * @param string columnIdName
 * 	Grid Column Id name, default: id.
 *
 *  @returns array
 */
$.fn.getSelectedRowsIdCell = function(columnIdName)
{
	var idArray = [], row, grid;

	columnIdName = columnIdName || 'id';

	grid = this;

	$.each(this.jqGrid('getGridParam', 'selarrrow'), function( index, value )
	{
		row = grid.getRowData(value);

		idArray.push(row[columnIdName]);
	});

	return idArray;
};

/**
 * Get cell id of selected row.
 *
 * @param string columnIdName
 * 	Grid Column Id name, default: id.
 *
 *  @returns array
 */
$.fn.getSelectedRowId = function(columnIdName)
{
	var	row = this.getRowData(this.jqGrid('getGridParam', 'selrow'));

	columnIdName = columnIdName || 'id';

	return row[columnIdName];
};

/**
 * Check in a grid if a row is selected.
 *
 * @param string columnIdName
 * 	Grid Column Id name, default: id.
 *
 *  @returns true if at least one row is selected, false otherwise
 */
$.fn.isRowSelected = function(cssSelectedClass)
{
	cssSelectedClass = cssSelectedClass || 'success';

	var	count = this.find('.' + cssSelectedClass).length;

	if(count == 0)
	{
		return false;
	}

	return true;
};


/**
 * Populate multiselect
 *
 * @param array options
 * 	An array of objects as follows: [{"value":"value  0", "text":"text 0"}, {"value":"value 1", "text":"text 1"},…]
 * @param object selected
 * 	An object as follows: {"value 0":"text 0", "value 1":"text 1"}
 * @param boolean refresh
 *
 *  @returns array
 */
$.fn.populateMultiSelect = function(options, selected, refresh)
{
	options = options || {};
	selected = selected || [];
	refresh = (refresh == undefined ? true : false);
	select = this;
	select.find('option').remove();

	$.each(options, function( index, option )
	{
		select.append('<option ' + (selected[option.value]?'selected="selected"':'') + 'value="' + option.value + '">' + option.text + '</option>');
	});

	if(refresh)
	{
		select.multiselect('refresh');
	}
};

/**
* Get selected options from a multiselect
*
*  @returns array
*/
$.fn.getMultiselectSelectedOptionsId = function()
{
	var idArray = [];

	$.each(this.find(":selected"), function( index, element )
	{
		idArray.push(element.value);
	});

	return idArray;
};

/**
 * Select first item of an autocomplete element.
 *
 *  @returns void
 */
$.fn.selectFirstItem = function(trigger)
{
	var items = $(this.autocomplete( "option", "source" ));

	trigger = (trigger == undefined ? true : trigger);

	if($.isPlainObject(items[0]))
	{
		this.data('ui-autocomplete')._trigger('select', 'autocompleteselect', {trigger: trigger, item: {label:items[0].label, value:items[0].value}});
	}
	else
	{
		this.val(items[0]);
	}
};

/**
 * Verify is the value of an autocomplete element is valid.
 *
 *  @returns true if valid, false otherwise
 */
$.fn.isAutocompleteValid = function()
{
	if(this.isEmpty())
	{
		return false;
	}

	var value = $(this).val().toLowerCase(), valid = false, autocomplete = this, source, parseFromJsonString;

	if(this.attr('data-autocomplete-source-type') != undefined)
	{
    if(this.attr('data-autocomplete-source-type') == 'globalJs')
    {
      parseFromJsonString = false;
    }
    else
    {
      parseFromJsonString = true;
    }

		source = getDecimaDataSource(this.attr('data-autocomplete-source'), this.attr('data-autocomplete-source-type'), null, null, null, parseFromJsonString);
	}
	else
	{
		if(this.attr('data-autocomplete-source') != undefined)
		{
			source = window[this.attr('data-autocomplete-source')];
		}
		else
		{
			source = this.autocomplete('option', 'source');
		}
	}

	$.each(source, function(index, element)
	{
		if($.isPlainObject(element))
		{
			// console.log(element);
			if(element.label.toLowerCase() == value || element.value.toString().toLowerCase() == value)
			{
				valid = true;
				// autocomplete.data('ui-autocomplete')._trigger('select', 'autocompleteselect', {item: {label:element.label, value:element.value}});
				autocomplete.data('ui-autocomplete')._trigger('select', 'autocompleteselect', {item: element});
				return false;
			}
		}
		else
		{
    	if(element.toLowerCase() == value)
			{
				valid = true;
				autocomplete.val(element);
				return false;
      }
   	}
 	});

 	return valid;
};

/**
 * Set client datasource autocomplete from localstorage
 *
 * @returns void
 */
$.fn.setAutocompleteSource = function()
{
	this.autocomplete('option', 'source', function(request, response)
	{
		var data, results, parseFromJsonString;

    if(this.element.attr('data-autocomplete-source-type') == 'globalJs')
    {
      parseFromJsonString = false;
    }
    else
    {
      parseFromJsonString = true;
    }

		data = getDecimaDataSource(this.element.attr('data-autocomplete-source'), this.element.attr('data-autocomplete-source-type'), null, null, null, parseFromJsonString);

		if ($.type(data) == 'object')
		{
			data = Object.values(data);
		}

		results = $.ui.autocomplete.filter(data, request.term);

		response(results.slice(0, 10));
	});
};

/**
 * Set the label of an autocomplete based on a given value.
 *
 *  @returns true if valid, false otherwise
 */
$.fn.setAutocompleteLabel = function(value)
{
	var autocomplete = this, parseFromJsonString;

	if(empty(value))
	{
		return '';
	}

	value = String(value);
	value = value.toLowerCase();

	if(this.attr('data-autocomplete-source-type') != undefined)
	{
    if(this.attr('data-autocomplete-source-type') == 'globalJs')
    {
      parseFromJsonString = false;
    }
    else
    {
      parseFromJsonString = true;
    }

		source = getDecimaDataSource(this.attr('data-autocomplete-source'), this.attr('data-autocomplete-source-type'), null, null, null, parseFromJsonString);
	}
	else
	{
		if(this.attr('data-autocomplete-source') != undefined)
		{
			source = window[this.attr('data-autocomplete-source')];
		}
		else
		{
			source = this.autocomplete('option', 'source');
		}
	}

	$.each(source, function(index, element)
	{
		if($.isPlainObject(element))
		{
			if(element.label.toLowerCase() == value || element.value.toString().toLowerCase() == value)
			{
				autocomplete.data('ui-autocomplete')._trigger('select', 'autocompleteselect', {item: element});
				return false;
			}
		}
		else
		{
    	if(element.toLowerCase() == value)
			{
				autocomplete.val(element);
				return false;
      }
   	}
 	});
};

/**
 * Set the label of an autocomplete based on a given value.
 *
 *  @returns true if valid, false otherwise
 */
$.fn.getAutocompleteLabel = function(value)
{
	var value = value.toLowerCase(), autocomplete = this, label = '', parseFromJsonString;

	if(this.attr('data-autocomplete-source-type') != undefined)
	{
    if(this.attr('data-autocomplete-source-type') == 'globalJs')
    {
      parseFromJsonString = false;
    }
    else
    {
      parseFromJsonString = true;
    }

		source = getDecimaDataSource(this.attr('data-autocomplete-source'), this.attr('data-autocomplete-source-type'), null, null, null, parseFromJsonString);
	}
	else
	{
		if(this.attr('data-autocomplete-source') != undefined)
		{
			source = window[this.attr('data-autocomplete-source')];
		}
		else
		{
			source = this.autocomplete('option', 'source');
		}
	}

	$.each(source, function(index, element)
	{
		if($.isPlainObject(element))
		{
			if(element.value.toString().toLowerCase() == value)
			{
				label = element.label;
				return false;
			}
		}
		else
		{
    	if(element.toLowerCase() == value)
			{
				label = value;
				return false;
      }
   	}
 	});

	return label;
};

/**
 * Get the value of an autocomplete based on its label.
 *
 *  @returns object
 */
$.fn.getAutocompleteValue = function()
{
	var label = $(this).val().toLowerCase(), value = false, autocomplete = this, parseFromJsonString;

	if(this.attr('data-autocomplete-source-type') != undefined)
	{
    if(this.attr('data-autocomplete-source-type') == 'globalJs')
    {
      parseFromJsonString = false;
    }
    else
    {
      parseFromJsonString = true;
    }

		source = getDecimaDataSource(this.attr('data-autocomplete-source'), this.attr('data-autocomplete-source-type'), null, null, null, parseFromJsonString);
	}
	else
	{
		if(this.attr('data-autocomplete-source') != undefined)
		{
			source = window[this.attr('data-autocomplete-source')];
		}
		else
		{
			source = this.autocomplete('option', 'source');
		}
	}

	$.each(source, function(index, element)
	{
		if($.isPlainObject(element))
		{
			if(element.label.toLowerCase() == label)
			{
				value = element;
				return false;
			}
		}
		else
		{
    	if(element.toLowerCase() == label)
			{
				value = element;
				return false;
      }
   	}
 	});

	return value;
};

/**
 * Populate form fields.
 *
 * @param string object
 * 	 The index must correspond to the form element id and the value will be set as the form element value.
 * @param string prefix
 * 	Elements id prefix.
 *
 * @returns void
 */
function populateFormFields(object, prefix)
{
	prefix = prefix || '';

	$.each(object, function( index, value )
	{
		var element = prefix +  index.replace(/_/g,'-');

		if($('#' + element).is('input') || $('#' + element).is("textarea"))
		{
			switch ($('#' + element).attr('type'))
			{
				case 'checkbox': //missing radio, autocomplete, multiselect
					if((value == 1 && !$('#' + element).is(":checked")) || (value == 0 && $('#' + element).is(":checked")))
					{
						$('#' + element).click();
					}
					break;
				default:
					$('#' + element).val(value);
					break;
			}
		}

		if($('#' + element).is("select"))
		{
			$('#' + element).val(value);
		}
	});
};

/**
 * Create an object from form fields.
 * Use: $('#formId').formToObject();
 *
 * @returns object
 */
$.fn.formToObject = function(removePrefix)
{
	var object = {}, removePrefix = removePrefix || '', index;

	this.find('input,select,textarea').each(function()
	{
		if($(this).attr('id') == undefined && $(this).attr('name') == undefined)
		{
			console.log('The following element does not have an id nor have a name ' + $(this)[0].outerHTML);
			return true;
		}

		if($(this).attr('type') == 'radio')
		{
			index = $(this).attr('name');
		}
		else
		{
			index = $(this).attr('id') || $(this).attr('name');
		}

		index = index.replace(removePrefix, '');
		index =	index.replace(/-/g,'_');

		if($(this).is('input') && $(this).attr('type') == 'checkbox')
		{
			object[index] = $(this).is(':checked')?'1':'0';
		}
		else if($(this).is('input') && $(this).attr('type') == 'radio')
		{
			if($(this).is(':checked'))
			{
				object[index] = $(this).val();
			}
		}
		else
		{
			object[index] = $(this).val();
		}
	});

	return object;
};


/**
 * Clean all form fields.
 * Use: $('#formId').cleanForm();
 *
 * @returns void
 */
$.fn.cleanForm = function()
{
	this.find('input[type=text],input[type=password],input[type=hidden],textarea').each(function()
	{
		if($(this).attr('name') != '_token')
		{
			$(this).val('');
		}
	});

	this.find('select').each(function()
	{
		$(this).val($('#'+$(this).attr('id')+' option:first').val());
	});

	this.find('input[type=checkbox]').each(function()
	{
		 $(this).removeAttr('checked');
	});

	this.find('.has-error').each(function()
	{
		$(this).removeClass('has-error');
	});

	this.find('.has-success').each(function()
	{
		$(this).removeClass('has-success');
	});

	this.find('.help-message-text').remove();
};

/**
 * Display alert messages after an element.
 * Use: $('#id').showAlert();
 *
 * @param string cssClass
 * 	Expected values: alert-success, alert-info, alert-warning, alert-danger.
 * @param string textAlert
 * 	Text to be shown.
 * @param integer delay
 * 	An integer indicating the number of milliseconds to delay fadeOut, a null value is also accepted.
 *
 *
 */
$.fn.showAlertAfterElement = function (cssClass, textAlert, delay)
{
	var top;
	$("#" + this.attr("id") + "-alert").hide();
	$("#" + this.attr("id") + "-alert").alert('close');

	this.after('<div id="' + this.attr("id") + '-alert" class="alert alert-block ' + cssClass + ' fade in show"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>' + textAlert + '</div>');

	$("#" + this.attr("id") + "-alert").alert();
	// $.scrollTo($("#" + this.attr("id") + "-alert").offset());
	top = $("#" + this.attr("id") + "-alert").offset();

	if(top == undefined)
	{
		top = 0;
	}
	else
	{
		top = top.top - 200;
	}

	$.scrollTo({top: top, left:0});

	if(delay)
	{
		appAlert = this;
		// $("#" + this.attr("id") + "-alert").delay( delay ).fadeOut();
		setTimeout(function ()
		{
			$("#" + appAlert.attr("id") + "-alert").alert('close');
		}, delay);
	}
};

/**
 * Display alert messages as first child of an element.
 * Use: $('#id').showAlert();
 *
 * @param string cssClass
 * 	Expected values: alert-success, alert-info, alert-warning, alert-danger.
 * @param string textAlert
 * 	Text to be shown.
 * @param integer delay
 * 	An integer indicating the number of milliseconds to delay fadeOut, a null value is also accepted.
 *
 *
 */
$.fn.showAlertAsFirstChild = function (cssClass, textAlert, delay)
{
	$("#" + this.attr("id") + "-alert").hide();
	$("#" + this.attr("id") + "-alert").alert('close');

	this.prepend('<div id="' + this.attr("id") + '-alert" class="alert alert-block ' + cssClass + ' fade in show"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>' + textAlert + '</div>');

	$("#" + this.attr("id") + "-alert").alert();

	top = $("#" + this.attr("id") + "-alert").offset();

	if(top == undefined)
	{
		top = 0;
	}
	else
	{
		top = top.top - 200;
	}

	$.scrollTo({top: top, left:0});
	// $.scrollTo(0, $("#" + this.attr("id") + "-alert").offset().top);

	if(delay)
	{
		// $("#" + this.attr("id") + "-alert").delay( delay ).fadeOut();
		appAlert = this;
		// $("#" + this.attr("id") + "-alert").delay( delay ).fadeOut();
		setTimeout(function ()
		{
			$("#" + appAlert.attr("id") + "-alert").alert('close');
		}, delay);
	}
};

/**
 * Display a yes/no question as first child of an element.
 * Use: $('#id').showAlert();
 *
 * @param string question
 * 	Question to be shown
 * @param string functionToCallIfYes
 * 	Function to be called if user answer yes
 * @param string functionToCallIfNo
 * 	Function to be called if user answer no
 * @param string cssClass
 * 	Expected values: alert-success, alert-info, alert-warning, alert-danger. Default value: alert-info.
 *
 *
 */
$.fn.showYesNoQuestionAsFirstChild = function (question, functionToCallIfYes, functionToCallIfNo, cssClass)
{
	cssClass = cssClass || 'alert-info';

	$("#" + this.attr("id") + "-yes-no-question").hide();
	$("#" + this.attr("id") + "-yes-no-question").alert('close');

	html = '<div id="' + this.attr('id') + '-yes-no-question" class="alert alert-block ' + cssClass + ' fade in" style="text-align: center;">' + question;
	html += '<div class="btn-group" style="margin-top: 10px;"><button class="btn btn-success" type="button" onclick="' + functionToCallIfYes + '();"><i class="fa fa-check"></i> ' + lang.yes + '</button><button class="btn btn-danger" type="button" onclick="' + functionToCallIfNo + '();"><i class="fa fa-times"></i> ' + lang.no + '</button></div></div>';
	this.prepend(html);

	// $.scrollTo($("#" + this.attr("id") + "-yes-no-question").offset());
	$("#" + this.attr("id") + "-yes-no-question").alert();

	top = $("#" + this.attr("id") + "-yes-no-question").offset();

	if(top == undefined)
	{
		top = 0;
	}
	else
	{
		top = top.top - 200;
	}

	$.scrollTo({top: top, left:0});
};

/**
 * Show server errors by field in a form.
 *
 * @param array fieldValidationMessages
 * 	An array of objects as follows: {fieldId0:message0, fieldId1:message1,…}
 *
 * @returns void
 */
$.fn.showServerErrorsByField = function(fieldValidationMessages, prefix)
{

	prefix = prefix || '';

	count = 0;

	$.each(fieldValidationMessages, function( field, message )
	{
		$('#' + prefix + field).jqMgValDisplayMessage('has-error has-danger', message);

		if(count == 0)
		{
    	// $.scrollTo($('#' + prefix + field).offset());
        top = $("#" + prefix + field).offset();

    	if(top == undefined)
    	{
    		top = 0;
    	}
    	else
    	{
    		top = top.top - 200;
    	}

    	$.scrollTo({top: top, left:0});
		}

		count++;
	});

	this.find('.has-error').effect('shake',null,600);
};

/**
 * Serializes a form into an object.
 * Disabled input elements are ignored.
 * Use: $('#formId').serializeObject();
 *
 *  @returns object
 */
$.fn.serializeObject = function()
{
	var obj = {};

	$.each( this.serializeArray(), function(i,o)
	{
		var n = o.name,
		v = o.value;

    obj[n] = obj[n] === undefined ? v
      : $.isArray( obj[n] ) ? obj[n].concat( v )
      : [ obj[n], v ];
    });

    return obj;
};

/**
 * Check if the value of an element is empty.
 * Use: $('#inputId').isEmpty();
 *
 * @returns true if is empty, false otherwise.
 */
$.fn.isEmpty = function()
{
	if(this.is("select"))
	{
		return this.val() == "";
	}
	else
	{
		return $.trim(this.val()) == "";
	}
};

/**
 * Check if an element han a specific attribute.
 * Use: $('#id').hasAttr('attribute');
 *
 * @returns true if the element has the attribute, false otherwise.
 */
$.fn.hasAttr = function(name) {
   return this.attr(name) !== undefined;
};


/**
 * Enable a group of buttons within a container.
 *
 * @returns void
 */
$.fn.enableButtonGroup = function()
{
	if(this.attr('data-class') != undefined)
	{
		$('.' + this.attr('data-class')).each(function()
		{
			$(this).enableButtonGroup();
			$(this).removeAttr('disabled');
		});

		return;
	}

	this.find('button').each(function()
	{
		$(this).removeAttr('disabled');
	});
};

/**
 * Disabled a group of buttons within a container.
 *
 * @returns void
 */
$.fn.disabledButtonGroup = function()
{
	if(this.attr('data-class') != undefined)
	{
		$('.' + this.attr('data-class')).each(function()
		{
			$(this).disabledButtonGroup();
			$(this).attr('disabled','disabled');
		});

		return;
	}

	this.find('button').each(function()
	{
		$(this).attr('disabled','disabled');
	});
};

/**
 * Bind the custom "on enter" event to an element.
 *
 *  @returns void
 */
$.fn.onEnter = function(func)
{
  this.bind('keypress', function(e)
  {
    if (e.keyCode == 13) func.apply(this, [e]);
  });

  return this;
};

/**
 * Clear all tags.
 * Use: $('#elementId').clearTags();
 *
 * @returns void
 */
$.fn.clearTags = function()
{
	this.val('');
	this.parent().find('.token').remove();
};

/**
 * Create table
 *
 * @param string gridId
 * @param object headers
 * @param integer slice
 * @param object rows
 * @param string tableClasses
 * @param string dataType 'localStorage' or 'globalJs'
 *
 * Use: $('#elementId').clearTags();
 *
 * @returns void
 */
$.fn.createTable = function(gridId, rowsVariableName, slice, rows, headers, tableClasses, dataType, filterName, filterValue, filterOperator, url, page, filter, from, to, records)
{
  var element = this, pagination = '', colsCount = 0, count = 0;

	gridId = gridId || '';
	slice = slice || 0;
	rows = rows || '';
	headers = headers || {'name': {'label':'label', 'width':'100%'}};
	tableClasses = tableClasses || 'table table-bordered table-hover search-modal-table';
  dataType = dataType || 'localStorage';
  filterName = filterName || '';
	filterValue = filterValue || '';
	filterOperator = filterOperator || '=';
  url = url || '';
	page = page || 1;
	filter = filter || '';
	from = from || '';
	to = to || '';
	records = records || '';
	table = $('<table/>', {class:tableClasses});
	thead = $('<thead/>');
	tbody = $('<tbody/>');
	tr = $('<tr/>');

  slice = parseInt(slice);
  page = parseInt(page);

  if(!empty(gridId))
	{
		headers = {};

		$.each($('#' + gridId).getGridParam('colModel'), function( index, colModel)
		{
			if(empty(colModel.hidden))
			{
				headers[colModel.name] = {
					'label': colModel.label,
					'width':(!empty(colModel.modalwidth) ? colModel.modalwidth : ''),
					'formatter':(!empty(colModel.formatter) ? colModel.formatter : ''),
					'prefix':(!empty(colModel.prefix) ? colModel.prefix : ''),
					'align':(!empty(colModel.align) ? colModel.align : '')
				};
			}
		});
	}

	$.each(headers, function( name, header )
	{
    colsCount++;

		$('<th/>', {
				'scope': 'col',
				'style': 'text-align: center;' + (!empty(header.width) ? 'width: ' + header.width + ';' : ''),
				'html': header.label
		}).appendTo(tr);
	});

	thead.append(tr);
	table.append(thead);

	if(empty(rows))
	{
    if(dataType == 'post')
    {
      $.ajax(
			{
				type: 'POST',
				data: JSON.stringify({rows:slice, page:page, filter:filter}),
				dataType : 'json',
				url:  url,
				error: function (jqXHR, textStatus, errorThrown)
				{
					handleServerExceptions(jqXHR, element.attr('id'), false);
				},
				beforeSend:function()
				{
          $(this).find('.smt-body').html('');

					$('#app-loader').removeClass('hidden');

					disabledAll();
				},
				success:function(json)
				{
          if(!empty(json.rows) && json.records > 0)
          {
            $(element).createTable(gridId, rowsVariableName, slice, json.rows, headers, tableClasses, dataType, filterName, filterValue, filterOperator, url, page, filter, json.from, json.to, json.records);
          }
          else
          {
            showEmptyTable(element, table);
            // $(element).find('.smt-body').html('');
            //
      			// $(element).find('.smt-body').append(table);
      			// $(element).find('.smt-body').append('<div id="' + element.attr("id") + '-alert" class="alert alert-block alert-warning fade in show"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>' + lang.emptyRows + '</div>');
          }

					$('#app-loader').addClass('hidden');

					enableAll();

					$('.decima-erp-tooltip').tooltip('hide');
				}
			});

      return;
    }
    else
    {
      rows = getDecimaDataSource(rowsVariableName, dataType, filterName, filterValue, filterOperator, true);

      if(empty(rows))
      {

        showEmptyTable(element, table);

  			// $(this).find('.smt-body').html('');
        //
  			// $(this).find('.smt-body').append(table);
  			// $(this).find('.smt-body').append('<div id="' + this.attr("id") + '-alert" class="alert alert-block alert-warning fade in show"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>' + lang.emptyRows + '</div>');

        return;
      }
    }
	}

  count = 0;

	$.each(rows, function( index, row )
	{
    count++;

    if(!empty(slice) && count > slice)
    {
      return false;
    }

		tr = $('<tr/>');

		$.each(headers, function( name, header)
		{
			td = $('<td/>');
			value = row[name];

			if(!empty(value) && !empty(header.formatter))
			{
				switch (header.formatter)
				{
					case 'currency':
						value = $.fmatter.NumberFormat(row[name], $.fn.jqMgVal.defaults.validators.money.formatter);
						break;
					case 'date':
						// value = $.datepicker.formatDate(lang.dateFormat, new Date(row[name]));
						value = moment(row[name], 'YYYY-MM-DD').format(lang.jsDateFormat);
						break;
					case 'datetime':
						// value = $.datetimepicker.formatDate(lang.phpDateTimeFormat, new Date(row[name]));
						value = moment(row[name], 'YYYY-MM-DD HH:mm:ss').format(lang.jsDateTimeFormat);
						break;
				}
			}

			if(!empty(header.class))
			{
				td.attr('class', header.class);
			}

			if(!empty(header.align))
			{
				td.attr('style', 'text-align: ' + header.align);
			}

			if(!empty(header.prefix))
			{
				value = header.prefix + '' + value;
			}

			td.html(value);

			tr.append(td);
		});

		tr.attr('data-row', JSON.stringify(row));
		tr.attr('onclick', 'smtRowClick(this)');

		tbody.append(tr);
	});

  if(!empty(url))
  {
    tr = $('<tr/>');
    td = $('<td/>');

    td.attr('colspan', colsCount);
    td.attr('class', 'search-modal-table-footer-row');

    pagination = '<nav>';
    pagination += '<ul class="pagination search-modal-table-pagination">';
    pagination += '<li><a href="#" onclick="smtPager(\'' + element.attr("id") + '\', 1)"><span aria-hidden="true"><i class="fa fa-step-backward" aria-hidden="true"></i></span></a></li>';
    pagination += '<li><a href="#" onclick="smtPager(\'' + element.attr("id") + '\', ' + (page - 1) + ')"><span aria-hidden="true"><i class="fa fa-backward" aria-hidden="true"></i></span></a></li>';
    pagination += '<li class="search-modal-table-footer-page-number">' + lang.gridFooterPageNumber.replace(':page', page).replace(':totalPages', Math.ceil(records/slice)) + '</li>';
    pagination += '<li><a href="#" onclick="smtPager(\'' + element.attr("id") + '\', ' + (page + 1) + ')"><span aria-hidden="true"><i class="fa fa-forward" aria-hidden="true"></i></span></a></li>';
    pagination += '<li><a href="#" onclick="smtPager(\'' + element.attr("id") + '\', ' + Math.ceil(records/slice) + ')"><span aria-hidden="true"><i class="fa fa-step-forward" aria-hidden="true"></i></span></a></li>';
    pagination += '</ul>';
    pagination += '</nav>';

    footerTable = $('<table/>', {class:'search-modal-table-footer'});
  	footerTableTbody = $('<tbody/>');
    footerTr = $('<tr/>');

    $('<td/>', {
        'style': 'text-align: center;width: 20%;',
        'html': '&nbsp;'
    }).appendTo(footerTr);
    $('<td/>', {
        'style': 'text-align: center;width: 60%;',
        'html': pagination
    }).appendTo(footerTr);
    $('<td/>', {
        'style': 'text-align: right;width: 20%;',
        'class': 'search-modal-table-footer-paging-info',
        'html': lang.gridFooterPagingInfo.replace(':from', empty(from)?1:from).replace(':to', to).replace(':records', records)
    }).appendTo(footerTr);

    footerTableTbody.append(footerTr);
    footerTable.append(footerTableTbody);
    td.append(footerTable);
    tr.append(td);
    tbody.append(tr);
  }

	table.append(tbody);

	if(!empty(rowsVariableName))
	{
	   $(this).attr('data-rows-variable-name', rowsVariableName);
	}

  $(this).attr('data-rows-variable-type', dataType);
  $(this).attr('data-slice', slice);
  $(this).attr('data-filter-name', filterName);
  $(this).attr('data-filter-value', JSON.stringify(filterValue));
	$(this).attr('data-filter-operator', filterOperator);
	$(this).attr('data-url', url);
	$(this).attr('data-page', page);
	$(this).attr('data-filter', filter);
	$(this).attr('data-headers', JSON.stringify(headers));
	$(this).attr('data-table-classes', tableClasses);

	$(this).find('.smt-body').html('');

	$(this).find('.smt-body').append(table);

  $(this).find('.smt-body').append();
};
/**
 * Get selected row
 *
 * @returns object
 */
$.fn.getSelectedSmtRow = function()
{
	if($(this).find('.bg-success').length == 0)
	{
		return false;
	}

	return JSON.parse($(this).find('.bg-success').attr('data-row'));
};

/**
 * Get selected options id from a multiselect object.
 *
 * @param array options
 * 	An array of objects as follows: [{"value":"value  0", "text":"text 0"}, {"value":"value 1", "text":"text 1"},…]
 *
 * @returns array
 *  An array as follows: ["value 0", "value 1",…]
 */
function showEmptyTable(element, table)
{
  $(element).find('.smt-body').html('');

  $(element).find('.smt-body').append(table);
  $(element).find('.smt-body').append('<div id="' + element.attr("id") + '-alert" class="alert alert-block alert-warning fade in show"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>' + lang.emptyRows + '</div>');
}

/**
 * Get selected options id from a multiselect object.
 *
 * @param array options
 * 	An array of objects as follows: [{"value":"value  0", "text":"text 0"}, {"value":"value 1", "text":"text 1"},…]
 *
 * @returns array
 *  An array as follows: ["value 0", "value 1",…]
 */
function getSelectedOptionsId(optionElements)
{
	var idArray = [];

	$.each(optionElements, function( index, option )
	{
		idArray.push(option.value);
	});

	return idArray;
}

/**
 * Get data source
 *
 * @returns void
 */
function getDataSourceByNameAndType(name, type, filterName, filterValue, filterOperator)
{
  return getDecimaDataSource(name, type, filterName, filterValue, filterOperator, true);
}

/**
 * Get data source
 *
 * @param string name
 * @param string type
 * @param string filterName
 * @param mixed filterValue
 * @param string filterOperator
 *
 * @returns void
 */
function getDecimaDataSource(name, type, filterName, filterValue, filterOperator, parseFromJsonString)
{
	var dataSource = null, filteredDataSource = [], flag = false;

  type = type || 'localStorage';
  filterName = filterName || '';
	filterValue = filterValue || '';
	filterOperator = filterOperator || '=';
	parseFromJsonString = parseFromJsonString || false;

	switch (type)
	{
		case 'localStorage':
      dataSource = window.localStorage.getItem(name);
			break;
		case 'globalJs':
			dataSource = window[name];
			break;
		default:
			console.log('DataType invalid');
	}

  if(parseFromJsonString)
  {
    dataSource = JSON.parse(dataSource);
  }

  if(!empty(filterName) && !empty(filterValue))
  {
    $.each(dataSource, function(index, element)
    {
      flag = false;

      switch (filterOperator)
      {
        case '=':
          if(element[filterName] == filterValue)
          {
            flag = true;
          }

          break;
        case '<':
          if(element[filterName] < filterValue)
          {
            flag = true;
          }

          break;
        case '>':
          if(element[filterName] > filterValue)
          {
            flag = true;
          }

          break;
        case 'in':
          if($.inArray(element[filterName], filterValue) != -1)
          {
            flag = true;
          }

          break;
      }

      if(flag)
      {
        filteredDataSource.push(element);
      }
   	});

    return filteredDataSource;
  }

	return dataSource;
}

/**
 * Get data source by name and type
 *
 * @param string name
 * @param string type
 *
 * @returns void
 */
function getDataSourceArrayByNameAndType(name, type, filterName, filterValue, filterOperator)
{
	var dataSource = getDecimaDataSource(name, type, filterName, filterValue, filterOperator, true);

  if(empty(dataSource))
  {
    return [];
  }

	if ($.type(dataSource) == 'object')
	{
		return Object.values(dataSource);
	}

	return dataSource;
}

/**
 * Set data source by name and type
 *
 * @param mixed dataSource
 * @param string type
 * @param string name
 * @param boolean convertToJsonString
 *
 * @returns boolean
 */
function setDecimaDataSource(name, datasource, type, convertToJsonString)
{
  type = type || 'localStorage';
  convertToJsonString = convertToJsonString || false;

  if(convertToJsonString)
  {
    datasource = JSON.stringify(datasource);
  }

	switch (type)
	{
		case 'localStorage':
			window.localStorage.setItem(name, datasource);
			break;
		case 'globalJs':
			window[name] = datasource;
			break;
		default:
			console.log('DataType invalid');
			return false;
	}

	return true;
}

/**
 * Set data source by name and type
 *
 * @param mixed dataSource
 * @param string name
 * @param string type
 *
 * @returns boolean
 */
function setDataSourceByNameAndType(datasource, name, type)
{
  return setDataSourceTypeAndByName(datasource, type, name);
}

/**
 * Set data source by name and type
 *
 * @param mixed dataSource
 * @param string name
 * @param string type
 *
 * @returns boolean
 */
function filterAutocompleteSource(request, name, type, filterName, filterValue, filterOperator)
{
	var data, parseFromJsonString;

	filterName = filterName || '';
	filterValue = filterValue || '';
	filterOperator = filterOperator || '=';

  if(type == 'globalJs')
  {
    parseFromJsonString = false;
  }
  else
  {
    parseFromJsonString = true;
  }

	data = getDecimaDataSource(name, type, filterName, filterValue, filterOperator, parseFromJsonString);

	if ($.type(data) == 'object')
	{
		data = Object.values(data);
	}

	if(data == undefined)
	{
		data = [];
	}

	return $.ui.autocomplete.filter(data, request.term);
}

/**
 * Key press cross browser compatibility
 * Firefox...
 *
 * @returns boolean
 */
function keyPressCrossBrowserCompatibility(event)
{
	//Fix firefox
	switch (event.keyCode)
	{
		case 8://backspace
		case 9://tab
		case 33://Re pág.
		case 34://Av Pág.
		case 35://fin
		case 36://inicio
		case 45://insert
		case 46://Supr
			return true;
			break;
		default:
			return false;
	}
	//console.log("entre");
	//console.log("keycode: "+event.keyCode+" charcode: "+event.charCode);
};

/**
 * Change windows URL.
 *
 *  @returns void
 */
function changeWindowsUrl(url)
{
	State = History.getState();

	if(State.url != ($('#app-url').val() + url))
	{
		History.pushState({load:true}, $('a[appurl=\'' + url +'\']').html(), $('#app-url').val() + url);
	}
}

/**
 * Calculate percent
 *
 * @param string or boolean btnCloseId
 * @param string popoverId
 * @param string popoverContent
 *
 *  @returns object
 */
function showButtonHelper(btnCloseId, popoverId, popoverContent)
{
	if(btnCloseId && !$('#' + btnCloseId).hasAttr('disabled'))
	{
		$('#' + btnCloseId).click();
	}

	$('#' + popoverId).popover({content: popoverContent, placement: 'top', trigger: 'manual'});

	setTimeout(function () {
		$('#' + popoverId).popover('show');
	}, 500);

	setTimeout(function () {
		$('#' + popoverId).popover('destroy');
	}, 8000);
}

/**
 * Calculate percent
 *
 * @param array chartData
 * 	An array of objects as follows: [ { label: $label0, value: $value0 },… ]
 *
 *  @returns object
 */
function calculatePercent(chartData, changeValueForPercent)
{
	var sum = 0;

	changeValueForPercent = changeValueForPercent || false;

	for (var x in chartData)
	{
	    sum += chartData[x].value;
	}

	for (var x in chartData)
	{
		if(changeValueForPercent)
		{
			chartData[x].value = (chartData[x].value / sum * 100).toFixed(2);
		}
		else
		{
			chartData[x].description = (chartData[x].value / sum * 100).toFixed(2) + '%';
		}
	}

	return chartData;
}

/**
 * Custom autocomplete validator for jQuery MG Validation Plugin
 *
 * @returns void
 */
var jqMgValAutocompleteValidator = function($element)
{
	$element.on( "autocompletechange", function( event, ui )
	{
    var parseFromJsonString;

		if ( ui.item )
		{
			$element.jqMgValDisplayMessage('has-success','');
		}

		if($element.isEmpty())
		{
			if($element.attr('data-mg-required') != undefined)
			{
				$element.jqMgValDisplayMessage('has-error has-danger', '');
			}
			else
			{
				$element.jqMgValDisplayMessage('has-success','');
			}

			if($element.attr('data-autocomplete-value-name') != undefined)
			{
				$('#' + $element.attr('data-autocomplete-value-name')).val('');
			}

			return;
		}

		var value = $element.val().toLowerCase(), valid = false, autocomplete = this, source;

    if($element.attr('data-autocomplete-source-type') != undefined)
    {
      if($element.attr('data-autocomplete-source-type') == 'globalJs')
      {
        parseFromJsonString = false;
      }
      else
      {
        parseFromJsonString = true;
      }

			source =  getDecimaDataSource($element.attr('data-autocomplete-source'), $element.attr('data-autocomplete-source-type'), null, null, null, parseFromJsonString);
    }
    else
    {
      if($element.attr('data-autocomplete-source') != undefined)
      {
        source = window[$element.attr('data-autocomplete-source')];
      }
      else
      {
        source = $element.autocomplete( "option", "source" );
      }
    }

		$.each(source, function(index, element)
		{
			if($.isPlainObject(element))
			{
				elementLabel = $.isNumeric(element.label)?element.label.toString().toLowerCase():element.label.toLowerCase();
				elementValue = $.isNumeric(element.value)?element.value.toString().toLowerCase():element.value.toLowerCase();

				if(elementLabel == value || elementValue == value)
				{
					// console.log(element);
					valid = true;
					// $(autocomplete).data('ui-autocomplete')._trigger('select', 'autocompleteselect', {item: {label:element.label, value:element.value}});
					$(autocomplete).data('ui-autocomplete')._trigger('select', 'autocompleteselect', {item: element});
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

		if (valid)
		{
			$element.jqMgValDisplayMessage('has-success', '');
			return true;
		}
		else
		{
			$element.jqMgValDisplayMessage('has-error has-danger', lang.autocompleteValidation);;
			$('#' + $element.attr('data-autocomplete-value-name')).val('');
			return false;
		}

	});

	$element.focusout(function()
	{
		$(this).trigger('autocompletechange', ['']);
	});
};


/**
 * Validate token
 *
 * @param array event
 * @param array availableTokens
 *
 * @returns void
 */
function validateToken(event, availableTokens)
{
	var exists = true;

	$.each(availableTokens, function(index, token)
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
}

/**
 * JavaScript equivalent to PHP's empty
 *
 * @param mixed mixed_var
 *
 * @returns boolean
 */
function empty(mixed_var)
{
  //   example 1: empty(null);
  //   returns 1: true
  //   example 2: empty(undefined);
  //   returns 2: true
  //   example 3: empty([]);
  //   returns 3: true
  //   example 4: empty({});
  //   returns 4: true
  //   example 5: empty({'aFunc' : function () { alert('humpty'); } });
  //   returns 5: false

  var undef, key, i, len;
  var emptyValues = [undef, null, false, 0, '', '0'];

  for (i = 0, len = emptyValues.length; i < len; i++)
	{
    if (mixed_var === emptyValues[i])
		{
      return true;
    }
  }

  if (typeof mixed_var === 'object')
	{
    for (key in mixed_var)
		{
      // TODO: should we check for own properties only?
      //if (mixed_var.hasOwnProperty(key)) {
      return false;
      //}
    }
    return true;
  }

  return false;
}

/**
 * Check if varianle is in storage
 *
 * @param string name
 * @param string type
 *
 * @returns boolean
 */
function isInDecimaStorage(name, type)
{
  type = type || 'localStorage';

	switch (type)
	{
		case 'localStorage':
      if(empty(window.localStorage.getItem(name)))
      {
        return false;
      }
			break;
		case 'globalJs':
      if(window[name] == undefined)
      {
        return false;
      }
			break;
		default:
			console.log('DataType invalid');
			return false;
	}

	return true;
}

/**
 * Get and parse json from localstorage
 *
 *  @returns object
 */
function getFromLocalStorage(variableName)
{
  return JSON.parse(window.localStorage.getItem(variableName));
}

/**
 * Check if varianle is in local storage
 *
 *  @returns boolean
 */
function isInLocalStorage(variableName)
{
  if(!empty(window.localStorage.getItem(variableName)))
	{
		return true;
	}
	else
	{
		return false;
	}
}

/**
 * Get, parse json and convert to array from localstorage
 *
 *  @returns object
 */
function getArrayFromLocalStorage(variableName)
{
  var data = JSON.parse(window.localStorage.getItem(variableName));

  if(empty(data))
  {
    return [];
  }

	if ($.type(data) == 'object')
	{
		data = Object.values(data);
	}

	return data;
}

/**
 * Round number
 *
 *  @returns object
 */
function customRound (value, decimals)
{
  return Number(Math.round(parseFloat(value) + 'e' + decimals) + 'e-' + decimals);
}
