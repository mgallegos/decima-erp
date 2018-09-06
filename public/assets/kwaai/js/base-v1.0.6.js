/**
 * @file
 * Base layout JavaScript resources.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

 var API = '';

 var quillToolbarOptions = {
	 container: [
		 [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
		 [ 'bold', 'italic', 'underline', 'strike' ],
		 [{ 'color': [] }, { 'background': [] }],
		 [{ 'script': 'super' }, { 'script': 'sub' }],
		 ['blockquote', 'code-block' ],
		 [{ 'list': 'ordered' }, { 'list': 'bullet'}, { 'align': [] }, { 'indent': '-1' }, { 'indent': '+1' }],
		 [{ 'direction': 'rtl' }],
		 [ 'link', 'image', 'video'],
		 [ 'clean' ]
	 ],
	 handlers: {
		 image: function image() {
			 $('#' + this.quill.options.prefix + 'file-uploader-modal').attr('data-flag', 'Quill');
			 openUploader(this.quill.options.prefix, '', this.quill.options.folder, ['image'], '', '', [], 1, true);
		 }
	 }
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
			enableAll();
    },
		beforeSend:function()
		{
			$('#app-loader').removeClass('hidden hidden-xs-up');
			disabledAll();
		},
		success:function(json)
		{
			cleanFiles(appPrefix);

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

			$('#app-loader').addClass('hidden hidden-xs-up');
			enableAll();
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
			$('#app-loader').removeClass('hidden hidden-xs-up');
			disabledAll();
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

			$('#app-loader').addClass('hidden hidden-xs-up');
			enableAll();
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
			enableAll();
    },
		beforeSend:function()
		{
			$('#app-loader').removeClass('hidden hidden-xs-up');
			disabledAll();
		},
		success:function()
		{
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
function resizeApplicationGrid()
{
  width = $('.core-app-container-width:visible').width();

  if(width == 1108)
  {
    return;
  }

  setTimeout(function ()
  {
    $('.tab-pane.fade.active.in').find('.app-grid').each(function(index, element)
    {
      if($('#' + $(element).attr('data-app-grid-id')).is(':visible'))
      {
        $('#' + $(element).attr('data-app-grid-id')).setGridWidth(width);
      }
    });
  }, 500);
}

/**
 * Resize grid on event
 *
 * @param integer id
 *
 *  @returns void
 */
function resizeGridOnLoadCompleteEvent()
{
  width = $('.core-app-container-width:visible').width();

  if(width == 1108)
  {
    return;
  }

  $(this).setGridWidth($('.core-app-container-width:visible').width());
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
      // sidebar:
      // {
      //   collapsed:
      //   {
      //     use:true,
      //   },
      //   expanded:
      //   {
      //     use:false
      //   }
      // },
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
      offCanvas:
      {
        pageSelector: "#core-wrapper"
      }
    });

    API = $('#core-menu').data('mmenu');

    if (API != undefined)
    {
      API.bind('open:finish', function() {
        $("input[placeholder='Search']").focus();
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

	windowWidth = document.documentElement.clientWidth;
	windowHeight = document.documentElement.clientHeight;
	var ajaxHeight = 45;
	var ajaxWidth = 154;

	$("#app-loader").css({
		"top": windowHeight/2-ajaxHeight/2,
		"left": windowWidth/2-ajaxWidth/2
	});

	$('#user-organizations-modal').on('shown.bs.modal', function (e) {
		$('#change-to-organization-name').focus();
	});

	$('#change-to-organization-form').jqMgVal('addFormFieldsValidations');

  $('#page-container').attr('data-current-page-width', $('#page-container').width());

  $(window).bind('resize', function()
  {
	  // if(($('#page-container').attr('data-current-page-width') >= 1140 && $('#page-container').width() <= 940) || ($('#page-container').attr('data-current-page-width') < 1140 && $('#page-container').width() > 940))
	  // {
    //
	  // }

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

    $.each($('.app-grid'), function( index, element )
    {
      $('#' + $(element).attr('data-app-grid-id')).setGridWidth(width);
    });

    $.each($('.custom-app-grid'), function( index, element )
    {
      $('#' + $(element).attr('data-app-grid-id')).setGridWidth($(this).width());
    });
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

	$('#change-to-organization').click(function()
	{
		if(!$('#change-to-organization-form').jqMgVal('isFormValid'))
		{
			return;
		}

		changeLoggedUserOrganization($('#change-to-organization-id').val());
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
