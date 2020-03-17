/**
 * @file
 * Base layout JavaScript resources.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

/**
 * Spin breadcrumb loader
 *
 *
 *  @returns void
 */
function centerAppLoader()
{
  windowWidth = document.documentElement.clientWidth;
	windowHeight = document.documentElement.clientHeight;

	$('#app-loader').css({
		"top": windowHeight/2-ajaxHeight/2,
		"left": windowWidth/2-ajaxWidth/2
	});
}

/**
 * Spin breadcrumb loader
 *
 *
 *  @returns void
 */
function spinBreadcrumbLoader()
{
  breadcrumbLoader.push(1);

  $('.fa-breadcrumb-loader').addClass('fa-spin');
}

/**
 * Stop breadcrumb loader
 *
 *
 *  @returns void
 */
function stopBreadcrumbLoader()
{
  breadcrumbLoader.pop();

  if(empty(breadcrumbLoader))
  {
    $('.fa-breadcrumb-loader').removeClass('fa-spin');
  }
}

/**
 * Enable all elements on screen.
 *
 * @returns void
 */
function enableAll()
{
  mainAppLoader.push(1);

  // $('#app-loader').addClass('hidden hidden-xs-up');

	$('#main-panel-fieldset').removeAttr('disabled');
	$('#user-apps-panel-fieldset').removeAttr('disabled');
}

/**
 * Disabled all elements on screen.
 *
 * @returns void
 */
function disabledAll()
{
  mainAppLoader.pop();

  if(empty(mainAppLoader))
  {
    // $('#app-loader').removeClass('hidden hidden-xs-up');
  }

	$('#main-panel-fieldset').attr('disabled','disabled');
	$('#user-apps-panel-fieldset').attr('disabled','disabled');
}

/**
 * Close tab and destroy its content.
 *
 * @param string id
 * 	App IDch
 *
 *  @returns void
 */
function closeTab(id)
{
	if($('a[href="#' + id +'"]').parent().hasClass('active'))
	{
		destroyApp(id);
		$('#apps-tabs a:last').click();
	}
	else
	{
		destroyApp(id);
	}

	if($('#apps-tabs').children().length == 0)
	{
		$('#user-apps-content').hideModulesApps();
	}
}

/**
 * Destoy app's html elements.
 *
 * @param string id
 * 	App ID
 *
 *  @returns void
 */
function destroyApp(id)
{
	$('a[href="#' + id +'"]').parent().remove();
	$('#' + id).remove();
}

/**
 * On click tab event.
 *
 * @param string url
 *
 *  @returns void
 */
function onClickTabEvent(url)
{
	changeWindowsUrl(url);
	$('#user-apps-content').hideModulesApps();
	setCurrentApp();
	$('.decima-erp-tooltip').tooltip('hide');
}


/**
* Send a request to change current user organization.
*
* @param integer id
*
*  @returns void
*/
function changePopoverStatus(popovers, organizationPopover)
{
	$.ajax(
	{
		type: 'POST',
		data: JSON.stringify({'popovers_shown':popovers, 'multiple_organization_popover_shown':organizationPopover, '_token':$('#app-token').val()}),
		url: $('#app-url').val() + '/general-setup/security/user-management/update-logged-user-popover-status'
	});
}

/**
 * Build HTML code of journals
 *
 * @param string appPrefix
 * @param array journals
 * 	An object as follows: { page: $page, totalPages: $total, records: $records, start: $start, end: $end, pageRecords: $pageRecords, pagerPagesInfo: $pagerPagesInfo, pagerRecordsInfo: $pagerRecordsInfo, journalHeaders: [{ userImageSource: $userImageSource, formattedHeader: $formattedHeader, journalDetails: [ $detail1, $detail2,… ] }
 *
 *  @returns void
 */
function buildJournals(appPrefix, journals, twoColumns)
{
  journalsHtml = '';

  journalCounter = 0;

  if(twoColumns)
  {
    journalsPerColumn = Math.round(journals.pageRecords/2);

    columnClass = 'col-lg-6 col-md-6';
  }
  else
  {
    journalsPerColumn = journals.pageRecords;

    columnClass = 'col-lg-12 col-md-12';
  }

  journalsHtml += "<div class='" + columnClass + "'>";

  $.each(journals.journalHeaders, function( index, journalHeader )
  {
	  journalCounter++;

	  journalsHtml += "<div class='journal-header clearfix'><img class='img-circle pull-left' src='" + journalHeader.userImageSource + "'></img><h5 class='journal-header-lengend pull-left'>" + journalHeader.formattedHeader + "</h5></div><ul> ";

	  $.each(journalHeader.journalDetails, function( index, journalDetail )
	  {
		  journalsHtml += '<li>' + journalDetail + '</li>';
	  });

	  journalsHtml += '</ul>';

	  if((journalCounter == journalsPerColumn) && twoColumns)
	  {
		  journalsHtml += '</div>';

		  journalsHtml += "<div class='" + columnClass + "'>";
	  }
  });

  journalsHtml += '</div>';

  $('#' + appPrefix + 'journals-body').html(journalsHtml);
}

/**
 *Clean journals
 *
 * @param string appPrefix
 *
 *  @returns void
 */
function cleanJournals(appPrefix)
{
  if($('#' + appPrefix + 'journals-body').length == 0)
  {
    return;
  }

	$('#' + appPrefix + 'journals').attr('data-journalized-id', '');
  $('#' + appPrefix + 'journals-body').html('');
  $('#' + appPrefix + 'step-backward').attr('disabled', 'disabled');
  $('#' + appPrefix + 'backward').attr('disabled', 'disabled');
  $('#' + appPrefix + 'forward').attr('disabled', 'disabled');
  $('#' + appPrefix + 'step-forward').attr('disabled', 'disabled');
  $('#' + appPrefix + 'step-backward').attr('disabled', 'disabled');
  $('#' + appPrefix + 'backward').attr('disabled', 'disabled');
  $('#' + appPrefix + 'forward').attr('disabled', 'disabled');
  $('#' + appPrefix + 'journal-search').val('');
  $('#' + appPrefix + 'journal-fieldset').attr('disabled', 'disabled');
  $('#' + appPrefix + 'pager-pages-info').html($('#' + appPrefix + 'journals').attr('data-pager-pages-info'));
  $('#' + appPrefix + 'pager-records-info').html($('#' + appPrefix + 'journals').attr('data-pager-records-info'));
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
	alertAsFirstChild = (alertAsFirstChild == undefined ? true : alertAsFirstChild);

	// console.log(jqXHR);

	try
	{
		response = JSON.parse(jqXHR.responseText);
		response = response.error.type;
		// console.log('1');
	}
	catch (e)
	{
		// console.log('2');
		response = $.trim(jqXHR.responseText);
	}

	switch (response)
	{
		case 'TokenMismatchException':
			alert(lang.tokenMismatchException);
			window.location.reload();
			return;
			break;
		// case 'Kwaai\\Security\\Exceptions\\AuthenticationException':
		case 'Unauthorized.':
			alert(lang.authenticationException);
			window.location.reload();
			return;
			break;
		default:
			if(alertAsFirstChild)
			{
				$('#' + id).showAlertAsFirstChild('alert-danger', lang.defaultErrorMessage, 7000);
			}
			else
			{
				$('#' + id).showAlertAfterElement('alert-danger alert-custom', lang.defaultErrorMessage, 7000);
			}

	}

	$('#app-loader').addClass('hidden hidden-xs-up');
	enableAll();
}

function startIntro()
{
	introJs().
		setOption("nextLabel", lang.next).
		setOption("prevLabel", lang.previous).
		setOption("skipLabel", lang.skip).
		setOption("doneLabel", lang.done).
		setOption("exitOnOverlayClick", false).
		setOption("exitOnEsc", false).
		onbeforechange(function(targetElement)
		{
  		if($(targetElement).attr('data-step') == 1)
			{
				window.scrollTo(0, 0);
			}

  		if($(targetElement).attr('data-step') == 3)
			{
				window.scrollTo(0, 0);
				$('#page-navbar').addClass('intro-js-custom-navbar');
			}

  		if($(targetElement).attr('data-step') == 4)
			{
				// console.log('entre 1');
				// $('#user-gravatar').parent().click();
				// $('#main-user-dropdown-menu').addClass('open');
			}
		}).
		onafterchange(function(targetElement)
		{
  		if($(targetElement).attr('data-step') == 4)
			{
				// console.log('entre 2');
				// $('#user-gravatar').parent().click();
				// $('#main-user-dropdown-menu').addClass('open');
				// $('#page-navbar').removeClass('intro-js-custom-navbar');
			}
		}).
		onexit(function()
		{
  		$('#page-navbar').removeClass('intro-js-custom-navbar');
		}).
		oncomplete(function()
		{
  		$('#page-navbar').removeClass('intro-js-custom-navbar');
			changePopoverStatus(true, false);
			if($('#user-organizations-dropdown-menu').find('ul').children().length > 0)
			{
				showOrganizationHint();
			}
		}).
		start();
}

function showOrganizationHint()
{
	introJs().
		setOption("hintButtonLabel", lang.done).
		onhintclick(function()
		{
			changePopoverStatus(true, true);
		}).
		addHints();
}

/**
* Show uploader modal
*
* @param string prefix
* @param boolean systemReferenceId
* @param string parentFolder
* @param array allowedFileTypes
* 	An array with any of the following values: ['text', 'spreadsheet', 'pdf', 'document', 'presentation', 'image', 'compression', 'sound'];
* @param integer minWidth
* @param boolean sameWidthAsHeight
* @param array sizes
*		An array of array as follows: [200, 300, 400]
* 	Sizes should not be greater than minimun width provider
* @param integer maxFileCount
* @param isPublic boolean
* 	true if is public, false if is not public
* @param integer parentFileId
*
*  @returns void
*/
function openUploader(prefix, systemReferenceId, parentFolder, allowedFileTypes, minWidth, sameWidthAsHeight, sizes, maxFileCount, isPublic, parentFileId)
{
	systemReferenceId = systemReferenceId || '';
	parentFolder = parentFolder || '';
	minWidth = minWidth || '';
	sameWidthAsHeight = sameWidthAsHeight || '';
	sizes = sizes || [];
	maxFileCount = maxFileCount || 0;
	isPublic = isPublic || '';
	allowedFileTypes = allowedFileTypes || [];
	parentFileId = parentFileId || '';

	if(sameWidthAsHeight)
	{
		sameWidthAsHeight = '1';
	}
	else
	{
		sameWidthAsHeight = '0';
	}

	if(isPublic)
	{
		isPublic = '1';
	}
	else
	{
		isPublic = '0';
	}

	if(allowedFileTypes.length == 0)
	{
		allowedFileExtensions = fileFmExtensions;
	}
	else
	{
		allowedFileExtensions = [];

		$.each(allowedFileTypes, function( index, type )
		{
			$.merge(allowedFileExtensions, fileFmExtensionsType[type]);
		});
	}

	// console.log(allowedFileExtensions);

	$('#' + prefix + 'file-uploader-file').fileinput('refresh', {allowedFileExtensions: allowedFileExtensions, maxFileCount: maxFileCount, uploadExtraData: {parent_file_id: parentFileId, system_reference_id: systemReferenceId, parent_folder: parentFolder, minWidth: minWidth, sameWidthAsHeight: sameWidthAsHeight, sizes: sizes, isPublic: isPublic}});
	$('#' + prefix + 'file-uploader-modal').attr('data-files', '[]');
	$('#' + prefix + 'file-uploader-modal').modal('show');
}

/**
 *Clean files
 *
 * @param string appPrefix
 *
 *  @returns void
 */
function cleanFiles(appPrefix)
{
	$('#' + appPrefix + 'file-body').html('');
  $('#' + appPrefix + 'btn-file-modal-delete').attr('data-system-reference-id', '');
}

/**
 * Get elements files
 *
 * @param string appPrefix
 * @param integer systemReferenceId
 * @param array systemReferences
 * @param string customUrl
 * 	An array of array as follows: array(array(appId => $appId, systemReferenceId = $systemReferenceId), array(appId => $appId, systemReferenceId = $systemReferenceId));
 *
 *  @returns void
 */
function getElementFiles(appPrefix, systemReferenceId, systemReferences, url)
{
	systemReferences = systemReferences || [];
	url = url || '/files/file-manager';

	$('#' + appPrefix + 'btn-file-modal-delete').attr('data-system-reference-id', systemReferenceId);
	$('#' + appPrefix + 'btn-file-modal-delete').attr('data-system-references', JSON.stringify(systemReferences));

	systemReferences.push({appId: $('#' + appPrefix + 'file-viewer-section').attr('data-app-id'), systemReferenceId: systemReferenceId});

	$.ajax(
	{
		type: 'POST',
		data: JSON.stringify({'_token':$('#app-token').val(), 'systemReferences': systemReferences}),
		dataType : 'json',
		url: $('#app-url').val() + url + '/element-files',
		error: function (jqXHR, textStatus, errorThrown)
		{
			handleServerExceptions(jqXHR, appPrefix + 'btn-toolbar', false);
			// enableAll();
    },
		beforeSend:function()
		{
			// $('#app-loader').removeClass('hidden hidden-xs-up');
			// disabledAll();
		},
		success:function(json)
		{
			// cleanFiles(appPrefix);

      $('#' + appPrefix + 'file-body').html('');

			row = $('<div/>', {class:'row'});

			$.each(json, function( index, file )
			{
				filePreviewFrame = $('<div/>', {class:'file-viewer-preview-frame clearfix'});
				filePreviewData = $('<div/>', {class:'kv-preview-data file-preview-other-frame'});

				$('<a/>', {
				    'class': 'file-other-icon',
				    'target': '_blank',
				    'href': file.url,
						'html': file.icon
				}).appendTo(filePreviewData);

				filePreviewFrame.append(filePreviewData);

				$('<div/>', {
				    'class': 'file-footer-caption file-viewer-footer-caption',
						'html': file.name + '<br><samp>(' + file.size + ')</samp>'
				}).appendTo(filePreviewFrame);

				$('<button/>', {
				    'class': 'kv-file-remove btn btn-xs btn-default pull-right',
				    'onclick': 'deleteFile(\'' + appPrefix + '\', ' + file.id + ', \'' + file.name + '\', \'' + url + '\' )',
						'html': '<i class="fa fa-trash text-danger"></i>'
				}).appendTo(filePreviewFrame);

				row.append($('<div/>', {class:'col-md-2'}).append(filePreviewFrame));

				if((index + 1) % 6 == 0)
				{
					$('#' + appPrefix + 'file-body').append(row);
					row = $('<div/>', {class:'row', style:'margin-top:15px'});
				}
			});

			$('#' + appPrefix + 'file-body').append(row);

			// $('#app-loader').addClass('hidden hidden-xs-up');
			// enableAll();
		}
	});
}

/**
 * Get elements files
 *
 * @param string appPrefix
 * @param integer fileId
 * @param strinf fileName
 *
 *  @returns void
 */
function deleteFile(appPrefix, fileId, fileName, url)
{
	// alert(fileId);
	$('#' + appPrefix + 'file-delete-message').html($('#' + appPrefix + 'file-delete-message').attr('data-default-label').replace(':name', fileName));
	$('#' + appPrefix + 'btn-file-modal-delete').attr('data-file-id', fileId);
	$('#' + appPrefix + 'btn-file-modal-delete').attr('data-prefix', appPrefix);
	$('#' + appPrefix + 'btn-file-modal-delete').attr('data-url', url);
	$('#' + appPrefix + 'file-modal-delete').modal('show');
}

function deleteFileAux(button)
{
	$.ajax(
	{
		type: 'POST',
		data: JSON.stringify({'_token':$('#app-token').val(), 'id': $(button).attr('data-file-id')}),
		dataType : 'json',
		url:  $('#app-url').val() + $(button).attr('data-url') + '/delete-file',
		error: function (jqXHR, textStatus, errorThrown)
		{
			handleServerExceptions(jqXHR, $(button).attr('data-prefix') + 'btn-toolbar', false);
			$('#' + $(button).attr('data-prefix') + 'file-modal-delete').modal('hide');
		},
		beforeSend:function()
		{
			$('#app-loader').removeClass('hidden hidden-xs-up');
			disabledAll();
		},
		success:function(json)
		{
			if(json.success)
			{
				getElementFiles($(button).attr('data-prefix'), $(button).attr('data-system-reference-id'), $.parseJSON($(button).attr('data-system-references')), $(button).attr('data-url'));
				$('#' + $(button).attr('data-prefix') + 'file-modal-delete').modal('hide');
			}

			$('#app-loader').addClass('hidden hidden-xs-up');
			enableAll();
		}
	});
}

/**
 * Get application journals
 *
 * @param string url
 *
 *  @returns void
 */
function getAppJournals(appPrefix, action, journalizedId)
{
  journal = $('#' + appPrefix + 'journals');

  if(journal.length == 0)
  {
    return;
  }

  if(journalizedId == undefined)
  {
    journalizedId = journal.attr('data-journalized-id');
  }
  else
  {
    journal.attr('data-journalized-id', journalizedId);
  }

	if($('#' + appPrefix + 'journals').attr('data-action-by') == '')
	{
		userId  = null;
	}
	else
	{
		userId  = $('#' + appPrefix + 'journals').attr('data-action-by');
	}

	if($('#' + appPrefix + 'journals').attr('data-only-actions') == '')
	{
		onlyActions = false;
	}
	else
	{
		onlyActions = true;
	}

	if($('#' + appPrefix + 'journals').attr('data-organization-not-null') == '')
	{
		organizationNotNull = false;
	}
	else
	{
		organizationNotNull = true;
	}

	if($('#' + appPrefix + 'journals').attr('data-two-columns') == '')
	{
		twoColumns = false;
	}
	else
	{
		twoColumns = true;
	}

	if($('#' + appPrefix + 'journal-search').isEmpty())
	{
		filter = null;
	}
	else
	{
		filter = $('#' + appPrefix + 'journal-search').val();
	}

	switch (action)
	{
		case 'firstPage':
			page = 1;
			break;
		case 'previousPage':
			page = parseInt(journal.attr('data-page')) - 1;
			break;
		case 'nextPage':
			page = parseInt(journal.attr('data-page')) + 1;
			break;
		case 'lastPage':
			page = parseInt(journal.attr('data-total-pages'));
			break;
		default:
			console.log('Something went wrong, value of action: ' + action);
			return;
	}

	$.ajax(
	{
		type: 'POST',
		data: JSON.stringify({'_token':$('#app-token').val(), 'appId': journal.attr('data-app-id'), 'page': page, 'journalizedId': journalizedId, 'filter': filter, 'userId': userId, 'onlyActions': onlyActions, 'organizationNotNull': organizationNotNull}),
		dataType : 'json',
		url: $('#app-url').val() + '/general-setup/security/journals-management/journals',
		error: function (jqXHR, textStatus, errorThrown)
		{
			handleServerExceptions(jqXHR, '', false);
			// $('#apps-tabs-content').children('.active').children('.breadcrumb').showAlertAfterElement('alert-danger alert-custom', textStatus, 7000);
			// $('#app-loader').addClass('hidden hidden-xs-up');
			// enableAll();
    },
		beforeSend:function()
		{
			// $('#app-loader').removeClass('hidden hidden-xs-up');
			// disabledAll();
		},
		success:function(journals)
		{
      if(journals.totalPages == 0 || journals.totalPages == 1)
      {
        $('#' + appPrefix + 'step-backward').attr('disabled', 'disabled');
        $('#' + appPrefix + 'backward').attr('disabled', 'disabled');
        $('#' + appPrefix + 'forward').attr('disabled', 'disabled');
        $('#' + appPrefix + 'step-forward').attr('disabled', 'disabled');
      }
      else if(page == 1)
			{
				$('#' + appPrefix + 'step-backward').attr('disabled', 'disabled');
				$('#' + appPrefix + 'backward').attr('disabled', 'disabled');
				$('#' + appPrefix + 'forward').removeAttr('disabled');
				$('#' + appPrefix + 'step-forward').removeAttr('disabled');
			}
			else if(page == journals.totalPages)
			{
				$('#' + appPrefix + 'step-backward').removeAttr('disabled');
				$('#' + appPrefix + 'backward').removeAttr('disabled');
				$('#' + appPrefix + 'forward').attr('disabled', 'disabled');
				$('#' + appPrefix + 'step-forward').attr('disabled', 'disabled');
			}
			else
			{
				$('#' + appPrefix + 'step-backward').removeAttr('disabled');
				$('#' + appPrefix + 'backward').removeAttr('disabled');
				$('#' + appPrefix + 'forward').removeAttr('disabled');
				$('#' + appPrefix + 'step-forward').removeAttr('disabled');
			}

			journal.attr('data-page', page);
			journal.attr('data-total-pages', journals.totalPages);

			$('#' + appPrefix + 'pager-pages-info').html(journals.pagerPagesInfo);
			$('#' + appPrefix + 'pager-records-info').html(journals.pagerRecordsInfo);
			$('#' + appPrefix + 'journal-fieldset').removeAttr('disabled');

			buildJournals(appPrefix, journals, twoColumns);

			if(filter)
			{
				$.each(filter.split(' '), function( index, value )
				{
					$('#' + appPrefix + 'journals-body').highlight(value);
				});
			}

			// $('#app-loader').addClass('hidden hidden-xs-up');
			// enableAll();
		}
	});
}

/**
 * Send a request to change current user organization.
 *
 * @param integer id
 *
 *  @returns void
 */
function changeLoggedUserOrganization(id)
{
	$.ajax(
	{
		type: 'POST',
		data: JSON.stringify({'id':id, '_token':$('#app-token').val()}),
		url: $('#app-url').val() + '/general-setup/security/user-management/change-logged-user-organization',
		error: function (jqXHR, textStatus, errorThrown)
		{
			handleServerExceptions(jqXHR, '', false);
			// enableAll();
    },
		beforeSend:function()
		{
			$('#app-loader').removeClass('hidden hidden-xs-up');
			disabledAll();
		},
		success:function()
		{
      // window.localStorage.clear();
      clearDecimaStorage();

			window.location.replace($('#app-url').val() + '/dashboard');
		}
	});
}

/**
 * Resize application grids
 *
 * @param integer id
 *
 *  @returns void
 */
function resizeApplicationGrids(timeout, gridClass)
{
  timeout = timeout || 500;
  gridClass = gridClass || 'app-grid';
  width = $('.core-app-container-width:visible').width();

  // if(width == 1108)
  // {
  //   return;
  // }

  setTimeout(function ()
  {
    $.each($('.' + gridClass), function( index, element )
    {
      $('#' + $(element).attr('data-app-grid-id')).setGridWidth(width);
    });

    // $('.tab-pane.fade.active.in').find('.' + gridClass).each(function(index, element)
    // {
    //   if($('#' + $(element).attr('data-app-grid-id')).is(':visible'))
    //   {
    //     $('#' + $(element).attr('data-app-grid-id')).setGridWidth(width);
    //   }
    // });
  }, timeout);
}

/**
 * Resize application grids
 *
 * @param integer id
 *
 *  @returns void
 */
function bindModalMenuEvent(selector, timeout)
{
  selector = selector || '.tab-pane.fade.active.in';
	timeout = timeout || 500;
	
	if (empty(API))
	{
		return;
	}

  setTimeout(function ()
  {
    $(selector).find('.modal').each(function(index, element)
    {
      if(windowWidth >= minWidthExpandedMenu)
      {
        $(element).on('show.bs.modal', function (e)
        {
          $('.core-top-bar-close-menu').click();
          bsModalshowMenu = true;
        });

        $(element).on('hide.bs.modal', function (e)
        {
          if(bsModalshowMenu)
          {
            $('.core-top-bar-open-menu').click();

            API.open();

            bsModalshowMenu = false;
          }
        });
      }
    });
  }, timeout);
}

/**
 * Resize grid on event
 *
 *  @returns void
 */
function resizeGridOnLoadCompleteEvent()
{
  width = $('.core-app-container-width:visible').width();

  // if(width == 1108)
  // {
  //   return;
  // }

  $(this).setGridWidth($('.core-app-container-width:visible').width());
}

/**
 * Update application client autocompletes
 *
 *  @returns object
 */
function updateApplicationClientAutocompletes()
{
  if(!empty(window.localStorage.getItem('applicationClientAutocompletes')))
  {
    organizationClients = JSON.parse(window.localStorage.getItem('organizationClients'));

    $.each(JSON.parse(window.localStorage.getItem('applicationClientAutocompletes')), function(index, autocompleteId)
    {
      window.localStorage.setItem('organizationClients', JSON.stringify(organizationClients));
      window[$('#' + autocompleteId).attr('data-autocomplete-source')] = organizationClients;

      $('#' + autocompleteId).autocomplete('option', 'source', function(request, response)
      {
        var results = $.ui.autocomplete.filter(window[$('#' + autocompleteId).attr('data-autocomplete-source')], request.term);
        response(results.slice(0, 10));
      });
    });
  }
}

/**
 * Load clients into localstorage
 *
 * @param objects clients
 *
 *  @returns object
 */
function loadClients(clients, forceAjaxRequest)
{
  clients = clients || '';
  forceAjaxRequest = forceAjaxRequest || false;

  if(!empty(clients))
  {
    window.localStorage.setItem('organizationClients', JSON.stringify(clients));

    updateApplicationClientAutocompletes();

    return;
  }

  if(forceAjaxRequest || empty(window.localStorage.getItem('organizationClients')))
  {
    $.ajax(
    {
      type: 'POST',
      data: JSON.stringify({'_token':$('#app-token').val()}),
      dataType : 'json',
      url: $('#app-url').val() + '/sales/setup/client-management/clients',
      error: function (jqXHR, textStatus, errorThrown)
      {
        handleServerExceptions(jqXHR, '', false);
      },
      success:function(organizationClients)
      {
        window.localStorage.setItem('organizationClients', JSON.stringify(organizationClients));

        updateApplicationClientAutocompletes();
      }
    });
  }
}

/**
 * Get clients from localstorage
 *
 *  @returns object
 */
function getClients()
{
  return JSON.parse(window.localStorage.getItem('organizationClients'));
}

/**
 * Set client datasource autocomplete from localstorage
 *
 * @returns void
 */
$.fn.setClientAutocomplete = function()
{
  clientAutocomplete = this;
  applicationClientAutocompletes = [];

  if(!empty(window.localStorage.getItem('applicationClientAutocompletes')))
  {
    applicationClientAutocompletes = JSON.parse(window.localStorage.getItem('applicationClientAutocompletes'));
  }

  if($.inArray(clientAutocomplete.attr('id'), applicationClientAutocompletes) == -1)
  {
    applicationClientAutocompletes.push(clientAutocomplete.attr('id'));
    window.localStorage.setItem('applicationClientAutocompletes', JSON.stringify(applicationClientAutocompletes));
  }

  if(empty(window.localStorage.getItem('organizationClients')))
  {
    $.ajax(
  	{
      type: 'POST',
  	  data: JSON.stringify({'_token':$('#app-token').val()}),
      dataType : 'json',
  		url: $('#app-url').val() + '/sales/setup/client-management/clients',
  		error: function (jqXHR, textStatus, errorThrown)
  		{
  			handleServerExceptions(jqXHR, '', false);
      },
  		success:function(organizationClients)
  		{
	      window.localStorage.setItem('organizationClients', JSON.stringify(organizationClients));
        window[clientAutocomplete.attr('data-autocomplete-source')] = organizationClients;

        clientAutocomplete.autocomplete('option', 'source', function(request, response)
        {
          var results = $.ui.autocomplete.filter(window[clientAutocomplete.attr('data-autocomplete-source')], request.term);
          response(results.slice(0, 10));
        });
  		}
  	});
  }
  else
  {
    organizationClients = JSON.parse(window.localStorage.getItem('organizationClients'));

    window[clientAutocomplete.attr('data-autocomplete-source')] = organizationClients;

    clientAutocomplete.autocomplete('option', 'source', function(request, response)
    {
      var results = $.ui.autocomplete.filter(window[clientAutocomplete.attr('data-autocomplete-source')], request.term);
      response(results.slice(0, 10));
    });
  }
};

/**
 * Update application suppplier autocompletes
 *
 *  @returns object
 */
function updateApplicationSupplierAutocompletes()
{
  if(!empty(window.localStorage.getItem('applicationSupplierAutocompletes')))
  {
    organizationSuppliers = JSON.parse(window.localStorage.getItem('organizationSuppliers'));

    $.each(JSON.parse(window.localStorage.getItem('applicationSupplierAutocompletes')), function(index, autocompleteId)
    {
      window.localStorage.setItem('organizationSuppliers', JSON.stringify(organizationSuppliers));
      window[$('#' + autocompleteId).attr('data-autocomplete-source')] = organizationSuppliers;

      $('#' + autocompleteId).autocomplete('option', 'source', function(request, response)
      {
        var results = $.ui.autocomplete.filter(window[$('#' + autocompleteId).attr('data-autocomplete-source')], request.term);
        response(results.slice(0, 10));
      });
    });
  }
}

/**
 * Load suppliers into localstorage
 *
 * @param objects suppliers
 *
 *  @returns object
 */
function loadSuppliers(suppliers, forceAjaxRequest)
{
  suppliers = suppliers || '';
  forceAjaxRequest = forceAjaxRequest || false;

  if(!empty(suppliers))
  {
    window.localStorage.setItem('organizationSuppliers', JSON.stringify(suppliers));

    updateApplicationSupplierAutocompletes();

    return;
  }

  if(forceAjaxRequest || empty(window.localStorage.getItem('organizationSuppliers')))
  {
    $.ajax(
  	{
  		type: 'POST',
  		data: JSON.stringify({'_token':$('#app-token').val()}),
      dataType : 'json',
  		url: $('#app-url').val() + '/purchases/setup/supplier-management/suppliers',
  		error: function (jqXHR, textStatus, errorThrown)
  		{
  			handleServerExceptions(jqXHR, '', false);
      },
  		success:function(organizationSuppliers)
  		{
  			window.localStorage.setItem('organizationSuppliers', JSON.stringify(organizationSuppliers));

        updateApplicationSupplierAutocompletes();
  		}
  	});
  }
}

/**
 * Set supplier datasource autocomplete from localstorage
 *
 * @returns void
 */
$.fn.setSupplierAutocomplete = function()
{
  supplierAutocomplete = this;
  applicationSupplierAutocompletes = [];

  if(!empty(window.localStorage.getItem('applicationSupplierAutocompletes')))
  {
    applicationSupplierAutocompletes = JSON.parse(window.localStorage.getItem('applicationSupplierAutocompletes'));
  }

  if($.inArray(supplierAutocomplete.attr('id'), applicationSupplierAutocompletes) == -1)
  {
    applicationSupplierAutocompletes.push(supplierAutocomplete.attr('id'));
    window.localStorage.setItem('applicationSupplierAutocompletes', JSON.stringify(applicationSupplierAutocompletes));
  }

  if(empty(window.localStorage.getItem('organizationSuppliers')))
  {
    $.ajax(
  	{
  		type: 'POST',
  		data: JSON.stringify({'_token':$('#app-token').val()}),
      dataType : 'json',
  		url: $('#app-url').val() + '/purchases/setup/supplier-management/suppliers',
  		error: function (jqXHR, textStatus, errorThrown)
  		{
  			handleServerExceptions(jqXHR, '', false);
      },
  		success:function(organizationSuppliers)
  		{
  			window.localStorage.setItem('organizationSuppliers', JSON.stringify(organizationSuppliers));
        window[supplierAutocomplete.attr('data-autocomplete-source')] = organizationSuppliers;

        supplierAutocomplete.autocomplete('option', 'source', function(request, response)
        {
          var results = $.ui.autocomplete.filter(window[supplierAutocomplete.attr('data-autocomplete-source')], request.term);
          response(results.slice(0, 10));
        });
  		}
  	});
  }
  else
  {
    organizationSuppliers = JSON.parse(window.localStorage.getItem('organizationSuppliers'));

    window[supplierAutocomplete.attr('data-autocomplete-source')] = organizationSuppliers;

    supplierAutocomplete.autocomplete('option', 'source', function(request, response)
    {
      var results = $.ui.autocomplete.filter(window[supplierAutocomplete.attr('data-autocomplete-source')], request.term);
      response(results.slice(0, 10));
    });
  }
};

/**
 * Get suppliers from localstorage
 *
 *  @returns object
 */
function getSuppliers()
{
  return JSON.parse(window.localStorage.getItem('organizationSuppliers'));
}

/**
 * Load search modal table rows
 *
 * @param jqueryObject tr
 *
 * @returns void
 */
function smtRowClick(tr)
{
	$(tr).parent().children().each(function()
	{
		$(this).removeClass('bg-success');
	});

	$(tr).addClass('bg-success');
}

/**
 * Load search modal table rows
 *
 * @param jqueryObject tr
 *
 * @returns void
 */
function smtOnKeyup(event, prefix)
{
  if (event.keyCode == 13)
  {
    smtSearch(prefix, true);
  }
}

/**
 * Load search modal table rows
 *
 * @param string smtrow id
 * @param integer page
 *
 * @returns void
 */
function smtPager(id, page, records)
{
  if(page < 1)
  {
    page = 0;
  }

  $('#' + id).attr('data-page', page);
  $('#' + id).attr('data-called-from-pager', '1');

  $('#' + id + '-btn-search').attr('data-flag', '1');
  $('#' + id + '-btn-search').click();
}

/**
 * Load search modal table rows
 *
 * @param string smtrow id
 * @param integer page
 *
 * @returns void
 */
function smtBtnSearch(element, prefix)
{
  var calledByUser;

  console.log($(element).attr('data-flag'));

  if($(element).attr('data-flag') == 1)
  {
    $(element).attr('data-flag', '0');

    smtSearch(prefix, false);
  }
  else
  {
    smtSearch(prefix, true);
  }
}

/**
 * Load search modal table rows
 *
 * @param string prefix
 *
 * @returns void
 */
function smtSearch(prefix, calledByUser)
{
  var found, filter, rows, parseFromJsonString;

  calledByUser = calledByUser || false;

  if(calledByUser)
  {
    page = 1;
  }
  else
  {
    page = $('#' + prefix + 'smt').attr('data-page');
  }

	if($('#' + prefix + 'smt-search-box').isEmpty())
	{
    $('#' + prefix + 'smt').createTable('', $('#' + prefix + 'smt').attr('data-rows-variable-name'), $('#' + prefix + 'smt').attr('data-slice'), '', JSON.parse($('#' + prefix + 'smt').attr('data-headers')), $('#' + prefix + 'smt').attr('data-table-classes'), $('#' + prefix + 'smt').attr('data-rows-variable-type'), $('#' + prefix + 'smt').attr('data-filter-name'), JSON.parse($('#' + prefix + 'smt').attr('data-filter-value')), $('#' + prefix + 'smt').attr('data-filter-operator'), $('#' + prefix + 'smt').attr('data-url'), page);

		return;
	}

  // console.log($('#' + prefix + 'smt').attr('data-filter-name'));
  // console.log(JSON.parse($('#' + prefix + 'smt').attr('data-filter-value')));
  // console.log($('#' + prefix + 'smt').attr('data-filter-operator'));

  filter = $('#' + prefix + 'smt-search-box').val().toLowerCase();
  slice = 0;

  if($('#' + prefix + 'smt').attr('data-rows-variable-type') != 'post')
  {
    if($('#' + prefix + 'smt').attr('data-rows-variable-type') == 'globalJs')
    {
      parseFromJsonString = false;
    }
    else
    {
      parseFromJsonString = true;
    }

    rows = getDecimaDataSource($('#' + prefix + 'smt').attr('data-rows-variable-name'), $('#' + prefix + 'smt').attr('data-rows-variable-type'), $('#' + prefix + 'smt').attr('data-filter-name'), JSON.parse($('#' + prefix + 'smt').attr('data-filter-value')), $('#' + prefix + 'smt').attr('data-filter-operator'), parseFromJsonString);

    if(empty(rows))
    {
      return;
    }

  	if ($.type(rows) == 'object')
  	{
  		rows = Object.values(rows);
  	}

    rows = $.grep(rows , function (row, index)
    {
      found = false;

      $.each(row, function( key, value )
    	{
        if(String(value).toLowerCase().indexOf(filter) > -1)
        {
          found = true;

          return false;
        }
      });

      return found;
    });
  }
  else
  {
    rows = '';
    slice = $('#' + prefix + 'smt').attr('data-slice');
  }

	$('#' + prefix + 'smt').createTable('', '', slice, rows, JSON.parse($('#' + prefix + 'smt').attr('data-headers')), $('#' + prefix + 'smt').attr('data-table-classes'), $('#' + prefix + 'smt').attr('data-rows-variable-type'), $('#' + prefix + 'smt').attr('data-filter-name'), JSON.parse($('#' + prefix + 'smt').attr('data-filter-value')), $('#' + prefix + 'smt').attr('data-filter-operator'), $('#' + prefix + 'smt').attr('data-url'), page, filter);
}

/**
 * Load search modal table rows
 *
 * @param string variableName
 * @param string url
 * @param object rows
 * @param boolean forceAjaxRequest
 * @param boolean convertToJsonString (true by default)
 *
 * @returns void
 */
function loadSmtRows(variableName, url, rows, forceAjaxRequest, showLoader, dataType, convertToJsonString)
{
	rows = rows || '';
	forceAjaxRequest = forceAjaxRequest || false;
	showLoader = showLoader || false;
  dataType = dataType || 'default';

  if(convertToJsonString == undefined)
  {
    convertToJsonString = true
  }

	if(!empty(rows))
  {
    setDecimaDataSource(variableName, rows, dataType, convertToJsonString);

    return;
  }

	if(forceAjaxRequest || empty(isInDecimaStorage(variableName, dataType)))
	{
		$.ajax(
		{
			type: 'POST',
			data: JSON.stringify({'_token': $('#app-token').val()}),
			dataType : 'json',
			url: url,
			error: function (jqXHR, textStatus, errorThrown)
			{
				handleServerExceptions(jqXHR, '', false);
			},
			beforeSend:function()
			{
        spinBreadcrumbLoader();

				if(showLoader)
				{
					$('#app-loader').removeClass('hidden hidden-xs-up');
					disabledAll();
				}
			},
			success:function(smtRows)
			{
        setDecimaDataSource(variableName, smtRows, dataType, convertToJsonString);
        stopBreadcrumbLoader();

				if(showLoader)
				{
					$('#app-loader').addClass('hidden hidden-xs-up');
					enableAll();
				}
			}
		});
	}
}

/**
 * Update row of search modal table rows
 *
 * @param string variableName
 * @param integer id
 * @param object row
 * @param string dataType
 * @param boolean parseFromAndConvertToJsonString (true by default)
 *
 * @returns void
 */
function addSmtRow(variableName, id, row, dataType, parseFromAndConvertToJsonString)
{
  rows = {};
  rows[id] = row;
  dataType = dataType || 'default';

  if(parseFromAndConvertToJsonString == undefined)
  {
    parseFromAndConvertToJsonString = true
  }

  smtRows = getDecimaDataSource(variableName, dataType, null, null, null, parseFromAndConvertToJsonString);

  if(empty(smtRows))
  {
    smtRows = {};
  }

  $.extend(rows, smtRows);

  setDecimaDataSource(variableName, rows, dataType, parseFromAndConvertToJsonString);
}

/**
 * Update row of search modal table rows
 *
 * @param string variableName
 * @param integer id
 * @param object row
 * @param string dataType
 * @param boolean parseFromAndConvertToJsonString (true by default)
 *
 * @returns void
 */
function updateSmtRow(variableName, id, row, dataType, parseFromAndConvertToJsonString)
{
  dataType = dataType || 'default';

  if(parseFromAndConvertToJsonString == undefined)
  {
    parseFromAndConvertToJsonString = true
  }

  smtRows = getDecimaDataSource(variableName, dataType, null, null, null, parseFromAndConvertToJsonString);

  if(empty(smtRows))
  {
    smtRows = {};
  }

  smtRows[id] = row;

  setDecimaDataSource(variableName, smtRows, dataType, parseFromAndConvertToJsonString);
}

/**
 * Delete row of modal table rows
 *
 * @param string variableName
 * @param string key
 * @param string dataType
 * @param boolean parseFromAndConvertToJsonString (true by default)
 *
 * @returns void
 */
function deleteSmtRow(variableName, key, dataType, parseFromAndConvertToJsonString)
{
  dataType = dataType || 'default';

  if(parseFromAndConvertToJsonString == undefined)
  {
    parseFromAndConvertToJsonString = true
  }

  smtRows = getDecimaDataSource(variableName, dataType, null, null, null, parseFromAndConvertToJsonString);

  if(empty(smtRows))
  {
    return;
  }

  delete smtRows[key];

  setDecimaDataSource(variableName, smtRows, dataType, parseFromAndConvertToJsonString);
}

/**
 * Delete row of modal table rows
 *
 * @param string variableName
 * @param array keys
 * @param string dataType
 * @param boolean parseFromAndConvertToJsonString (true by default)
 *
 * @returns void
 */
function deleteSmtRows(variableName, keys, dataType, parseFromAndConvertToJsonString)
{
  dataType = dataType || 'default';

  if(parseFromAndConvertToJsonString == undefined)
  {
    parseFromAndConvertToJsonString = true
  }

  smtRows = getDecimaDataSource(variableName, dataType, null, null, null, parseFromAndConvertToJsonString);

  if(empty(smtRows))
  {
    return;
  }

  $.each(keys, function( index, id)
  {
    delete smtRows[id];
  });

  setDecimaDataSource(variableName, smtRows, dataType, parseFromAndConvertToJsonString);
}

/**
 * Close user apps popover
 *
 * @returns void
 */
$.fn.closeUserAppsPopover = function()
{
	$('#user-apps-title').popover('hide');
};

/**
 * Close organizations menu popover
 *
 * @returns void
 */
$.fn.closeOrganizationsPopover = function()
{
	$('#user-organizations-dropdown-menu').popover('hide');
};

/**
 * Close current organization label popover
 *
 * @returns void
 */
$.fn.closeCurrentOrganizationPopover = function()
{
	$('#apps-tabs-content').children('.active').children('.breadcrumb-organization-name').popover('hide');
};

/**
 * Close search action input popover
 *
 * @returns void
 */
$.fn.closeSearchActionPopover = function()
{
	$('#search-action-container').popover('hide');
};

/**
 * Close gravatar popover
 *
 * @returns void
 */
$.fn.closeGravatarPopover = function()
{
	$('#user-gravatar').popover('hide');
};

/**
 * Close dropdown menu popover
 *
 * @returns void
 */
$.fn.closeDropdownMenuPopover = function()
{
	$('#user-dropdown-menu').popover('hide');
};

$(document).ready(function()
{
  centerAppLoader();
  resizeApplicationGrids();
  bindModalMenuEvent('body');

  if(windowWidth >= minWidthExpandedMenu)
  {
    $('.core-top-bar-open-menu').hide();

    $('.core-top-bar-close-menu').show();
  }

  if ($.isFunction($.fn.mmenu))
  {
    $("#core-menu").mmenu(
    {
      //options
      counters: true,
      keyboardNavigation:
      {
        enable: "default",
        enhance: true
      },
      navbars:
      [
        {
          position: "top",
          content: [
            "searchfield"
          ]
        }
      ],
      searchfield:
      {
        panel: true,
        showSubPanels: false
      },
      extensions:
      [
        "pagedim-black",
        "theme-white"
      ],
      setSelected:
      {
        hover: true,
        parent: true
      },
      navbar: {
        title: ""
      },
      sidebar:
      {
        // collapsed: "(min-width: 550px)",
        expanded: "(min-width: " + minWidthExpandedMenu + "px)"
      },
     //  iconbar:
     //  {
     //    add: true,
     //    top: [
     //       "<a onclick=\"$(\'#dashboard-top-bar-menu\').click();API.close();\" class=\"fake-link\"><i class='fa fa-dashboard'></i></a>",
     //    ]
     //    // ,
     //    // bottom: [
     //    //    "<a href='#/'><i class='fa fa-twitter'></i></a>",
     //    //    "<a href='#/'><i class='fa fa-facebook'></i></a>",
     //    //    "<a href='#/'><i class='fa fa-linkedin'></i></a>"
     //    // ]
     // }
    },
    {
      //configuration
      searchfield:
      {
        clear: true
      },
      // sidebar:
      // {
      //   --mm-sidebar-expanded-size: '300px'
      // },
      offCanvas:
      {
        pageSelector: "#core-wrapper"
        // pageSelector: "#page-container"
      }
    });

    API = $('#core-menu').data('mmenu');

    if (API != undefined)
    {
      API.bind('open:before', function()
      {
        $(".core-slider").addClass('hidden');
      });

      API.bind('open:finish', function()
      {
        $("input[placeholder='Search']").focus();

        resizeApplicationGrids(1);
      });

      API.bind('close:finish', function()
      {
        $('.core-top-bar-close-menu').hide();

        $('.core-top-bar-open-menu').show();

        resizeApplicationGrids(1);
      });

      if ($.isFunction(key))
      {
        key('shift+ctrl+m', function()
        {
          API.open();

          return false;
        });
      }
    }
  }

	$.ajaxSetup({
	  headers: {
	      'X-CSRF-TOKEN': $('#app-token').val()
	  }
	});

	if (navigator.userAgent.match(/IEMobile\/10\.0/))
	{
		var msViewportStyle = document.createElement("style");
		msViewportStyle.appendChild(
				document.createTextNode(
			    "@-ms-viewport{width:auto!important}"
	    )
	  );
	  document.getElementsByTagName("head")[0].appendChild(msViewportStyle);
	}

	History = window.History;

	History.Adapter.bind(window,'statechange',function(){
		var State = History.getState();
		if(State.data.load)
		{
			loadPage(State.url.replace($('#app-url').val(), ''));
		}
	});


	$.widget( "custom.categoryautocomplete", $.ui.autocomplete, {
		_renderMenu: function( ul, items ) {
			var that = this,
			currentCategory = "";
			$.each( items, function( index, item ) {
				if ( item.category != currentCategory ) {
					ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
					currentCategory = item.category;
				}
		        that._renderItemData( ul, item );
			});
		}
	});



	$('#user-organizations-modal').on('shown.bs.modal', function (e) {
		$('#change-to-organization-name').focus();
	});

	$('#change-to-organization-form').jqMgVal('addFormFieldsValidations');

  $('#page-container').attr('data-current-page-width', $('#page-container').width());

  $(window).bind('resize', function()
  {
    windowWidth = document.documentElement.clientWidth;
    windowHeight = document.documentElement.clientHeight;

    $('#page-container').attr('data-current-page-width', $('#page-container').width());
    $('.app-multiselect').multiselect('destroy');
    $('.app-multiselect').multiselect();

    if($('#page-container').width() <= 940)
    {
      width = 908;
      $('#up-c-journals,#up-a-journals').attr('data-two-columns', true);
    }
    else
    {
      width = 1106;
      $('#up-c-journals,#up-a-journals').attr('data-two-columns', '');
    }

    cleanJournals('up-c-');
    cleanJournals('up-a-');
    getAppJournals('up-c-','firstPage');
    getAppJournals('up-a-','firstPage');

    width = $('.core-app-container-width:visible').width();

    resizeApplicationGrids(1, 'app-grid');
    resizeApplicationGrids(1, 'custom-app-grid');

    // $.each($('.app-grid'), function( index, element )
    // {
    //   $('#' + $(element).attr('data-app-grid-id')).setGridWidth(width);
    // });

    // $.each($('.custom-app-grid'), function( index, element )
    // {
    //   $('#' + $(element).attr('data-app-grid-id')).setGridWidth($(this).width());
    // });
  });

  $(window).scroll(function ()
	{
	  if ($(this).scrollTop() != 0)
	  {
		  $('#back-to-top').fadeIn();
	  }
	  else
	  {
		  $('#back-to-top').fadeOut();
	  }
  });

	$('#apps-tabs a:last').tab('show');

	$('.breadcrumb').localScroll();

	$('.navbar-nav').localScroll();

	$('#user-apps-content').buildUserApps(userApps);

	setCurrentApp();

	$('#user-apps-content').on('hidden.bs.collapse', function ()
	{
		$(this).parent().children('.panel-heading').children('.btn-dashboard-toggle').children('i').attr('class','fa fa-chevron-down');
	});

	$('#user-apps-content').on('shown.bs.collapse', function ()
	{
		$(this).parent().children('.panel-heading').children('.btn-dashboard-toggle').children('i').attr('class','fa fa-chevron-up');
	});

	$('#dashboard-top-bar-menu').click(function()
	{
		loadPage('/dashboard');
		$('#user-apps-content').hideModulesApps();
	});

	$('#user-preferences-top-bar-menu').click(function()
	{
		loadPage('/' + $(this).attr('data-preferences-url'));
		$('#user-apps-content').hideModulesApps();
	});

	$('#user-apps-top-bar-menu').click(function()
	{
		$('#user-apps-container').effect('highlight', null, 1500);
	});

	$('#back-to-top').click(function()
	{
		$('#top-navbar-menu').click();
	});

  $('#change-to-organization').click(function()
	{
		if(!$('#change-to-organization-form').jqMgVal('isFormValid'))
		{
			return;
		}

		changeLoggedUserOrganization($('#change-to-organization-id').val());
	});

  $('#core-blocker').click(function()
	{
    $('#' + $(this).attr('data-slider-btn-close-id')).click();
	});

  $('.core-top-bar-open-menu').click(function()
	{
    if (!empty(API))
    {
      $('.core-top-bar-open-menu').hide();

      $('.core-top-bar-close-menu').show();
    }
	});

  $('.core-top-bar-close-menu').click(function()
	{
    if (!empty(API))
    {
      API.close();

      $('.core-top-bar-close-menu').hide();

      $('.core-top-bar-open-menu').show();
    }
	});

	$('#search-action').focusout(function()
	{
		$(this).val('');
	});

	$('#search-action').on('autocompleteselect', function( event, ui )
	{
		if(ui.item.actionButtonId != '')
		{
			$('#' + ui.item.actionButtonId).click();
		}
		else
		{
			setApp(ui.item.value);
		}
	});

	if($('#da-logged-user-popover-shown').val() == '0' || $('#da-logged-user-popover-shown').isEmpty())
	{
		if($('#user-apps-content-alert').length == 0)
		{
			setTimeout(function ()
			{
				window.scrollTo(0, 0);
				// $('#apps-tabs-content').children('.active').children('.breadcrumb-organization-name').popover('show');
				startIntro();
			}, 500);
		}
	}

	if($('#da-logged-user-popover-shown').val() == '1' && ($('#da-logged-user-multiple-organization-popover-shown').val() == '0' || $('#da-logged-user-multiple-organization-popover-shown').isEmpty()))
	{
		if($('#user-organizations-dropdown-menu').children().length > 0)
		{
			setTimeout(function () {
				// $('#user-organizations-dropdown-menu').popover('show');
				showOrganizationHint();
			}, 500);
		}
	}
});
