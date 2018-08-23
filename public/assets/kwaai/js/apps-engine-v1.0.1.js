/**
 * @file
 * User apps engine.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */


/**
 * Build HTML code of user apps
 *
 * @param array userApps
 * 	An array of objects as follows: [ { name: $moduleName, icon: $icon, childsMenus: [ { name: $menuName, url: $url, aliasUrl: $aliasUrl, actionButtonId: $actionButtonId, icon: $icon, hidden: $hidden, childsMenus: [ { … },… ] },… ] },…]
 *
 *  @returns void
 */
$.fn.buildUserApps = function(userApps, prefix, doNothing)
{
	if(userApps.length == 0)
	{
		return;
	}

	prefix = prefix || '';

	var modules = subModules = '', id = prefix + 'app';

	$.each(userApps, function( index, value )
	{
		modules += '<button id="' + id + '' + index +  '" class="btn btn-module btm" onclick="clickOnModule(\'' + id + '' + index +  '\')" data-app-name="' + value.name + '"><i class="' + value.icon + '"></i> ' + value.name + '</button>';

		if(!value['childsMenus'][0]['url'])
		{
			subModules += buildSubModules(id + '' + index, value.childsMenus, doNothing);
		}
		else
		{
			subModules += buildApps(id + '' + index, value.childsMenus, doNothing);
		}
	});

	modules = '<div class="col-lg-2 col-md-2"><div class="btn-group-vertical-custom sidebar-nav apps-section">' + modules + '</div></div>';

	this.html(modules + subModules);
};

/**
 * Build HTML code of user submodules
 *
 * @param int parentId
 * @param array subModules
 * 	An array of objects as follows: [ { name: $menuName, url: $url, aliasUrl: $aliasUrl, actionButtonId: $actionButtonId, icon: $icon, hidden: $hidden, childsMenus: [ { … },… ] },… ]
 *
 *  @returns string
 */
function buildSubModules(parentId, childs, doNothing)
{
	var subModules = subSubModules = '';

	$.each(childs, function( index, value )
	{
		subModules += '<button id="' + parentId + '' + index +  '" parentid="' + parentId +  '" class="btn btn-module btsm" onclick="clickOnModule(\'' + parentId + '' + index +  '\')" data-app-name="' + value.name + '"><i class="' + value.icon + '"></i> ' + value.name + '</button>';

		if(!value['childsMenus'][0]['url'])
		{
			subSubModules += buildSubModules(parentId + '' + index, value.childsMenus, doNothing);
		}
		else
		{
			subSubModules += buildApps(parentId + '' + index, value.childsMenus, doNothing);
		}
	});

	subModules = '<div class="col-lg-2 col-md-2 ' + parentId +'" style="display: none;"><div class="btn-group-vertical-custom sidebar-nav apps-section">' + subModules + '</div></div>';

	return subModules + subSubModules;
}

/**
 * Build HTML code of user apps
 *
 * @param int parentId
 * @param array apps
 * 	An array of objects as follows: [ { name: $menuName, url: $url, icon: $icon},… ]
 *
 *  @returns string
 */
function buildApps(parentId, apps, doNothing)
{
	var html = hiddenClass = '';

	$.each(apps, function( index, value )
	{
    if(value.hidden == '1')
    {
      hiddenClass = 'hidden';
    }
    else
    {
      hiddenClass = '';
    }

		if(doNothing)
		{
			html += '<button id="' + parentId + '' + index +  '" parentid="' + parentId +  '" class="btn btn-default btn-app bto ' + hiddenClass + '" data-app-name="' + value.name + '"><i class="' + value.icon + '"></i> ' + value.name + '</button>';
		}
		else
		{
			html += '<button id="' + parentId + '' + index +  '" parentid="' + parentId +  '" class="btn btn-default btn-app bto ' + hiddenClass + '" onclick="clickOnApp(\'' + parentId + '' + index +  '\', \'' + value.url + '\', \'' + value.aliasUrl + '\', \'' + value.actionButtonId + '\')" data-app-name="' + value.name + '"><i class="' + value.icon + '"></i> ' + value.name + '</button>';
		}
	});

	html = '<div class="col-lg-4 col-md-4 ' + parentId + '" style="display: none;"><div class="btn-group-vertical-custom sidebar-nav apps-section">' + html + '</div></div>';

	return html;
}

/**
 * Click on module event
 *
 *  @returns void
 */
function clickOnModule(id)
{
	if($('#' + id).hasClass('btn-primary'))
	{
		return;
	}

	$('#' + id).parent().find('button').each(function()
	{
		if($(this).hasClass('btn-primary'))
		{
			hideApps($(this).attr('id'));
		}
		$(this).removeClass('btn-primary');
		$(this).addClass('btn-module');
	});

	$('#' + id).removeClass('btn-module');
	$('#' + id).addClass('btn-primary');
	$('.' + id).fadeIn();
}

/**
 * Click on app event
 *
 *  @returns void
 */
function clickOnApp(id, url, aliasUrl, actionButtonId)
{
	if($('#' + id).hasClass('btn-primary'))
	{
		return;
	}

	$('#' + id).parent().find('button').each(function()
	{
		$(this).removeClass('btn-primary');
		$(this).addClass('btn-default');
	});

	$('#' + id).removeClass('btn-default');
	$('#' + id).addClass('btn-primary');

	$('#top-navbar-menu').click();
	loadPage(url, aliasUrl, actionButtonId);
}

/**
 * Hide submodules and apps of a module.
 *
 *  @returns void
 */
function hideApps(id)
{
	$('.' + id).find('button').each(function() {
		if($(this).hasClass('btn-primary') && !$(this).hasClass('bto'))
		{
			hideApps($(this).attr('id'));
		}

		$(this).removeClass('btn-primary');

		if($(this).hasClass('bto'))
		{
			$(this).addClass('btn-default');
		}
		else
		{
			$(this).addClass('btn-module');
		}
	});

	$('.' + id).hide();
}

/**
 * Hide all modules, submodules and apps.
 *
 *  @returns void
 */
$.fn.hideModulesApps = function()
{
	this.children().first().find('button').each(function()
	{
		hideApps($(this).attr('id'));
		$(this).removeClass('btn-primary');
		$(this).addClass('btn-module');
	});
};

/**
 * Set current app in the apps section.
 *
 *  @returns void
 */
function setCurrentApp()
{
	var appButton;

	$('#apps-tabs-content').children('.active').children('.breadcrumb').find('a').each(function()
	{
		$('#user-apps-content').find("button[data-app-name='" + $.trim($(this).html()) + "']").click();
	});

	appButton = $('#user-apps-content').find("button[data-app-name='" + $.trim($('#apps-tabs-content').children('.active').children('.breadcrumb').find('.active').html()) + "']");
	appButton.removeClass('btn-default');
	appButton.addClass('btn-primary');
}

/**
 * Set a specific app in the apps section.
 *
 *  @returns void
 */
function setApp(name)
{
	clickOnParent($('#user-apps-content').find("button:contains('" + name + "')").attr('parentid'));
	$('#user-apps-content').find("button:contains('" + name + "')").first().click();
}

function clickOnParent(id)
{
	if($('#' + id).hasAttr('parentid'))
	{
		clickOnParent($('#'+id).attr('parentid'));
	}

	$('#' + id).click();
}

/**
 * Load a new page within a new tab.
 *
 * @param string url
 * 	Page URL
 *
 *  @returns void
 */
function loadPage(url, aliasUrl, actionButtonId)
{
	loadedApp = false;

	if(aliasUrl == '' || aliasUrl == undefined)
	{
		aliasUrl = url;
	}

	$.each($('#apps-tabs').find('a'), function( index, a )
	{
		if($(a).attr('appurl') == url || $(a).attr('appurl') == aliasUrl)
		{
			$(a).tab('show');
			loadedApp = true;
			return false;
		}
	});

	if(loadedApp && actionButtonId != '' && actionButtonId != undefined)
	{
		$('#' + actionButtonId).click();
	}

	if(loadedApp)
	{
		changeWindowsUrl(aliasUrl);
		return;
	}

	$.ajax(
	{
		type: 'GET',
		url: $('#app-url').val() + url,
		error: function (jqXHR, textStatus, errorThrown)
		{
			// $('#apps-tabs-content').children('.active').children('.breadcrumb').showAlertAfterElement('alert-danger alert-custom', textStatus, 7000);
			handleServerExceptions(jqXHR, 'um-btn-toolbar', false);
    },
		beforeSend:function(msg)
		{
			$('.decima-erp-tooltip').tooltip('hide');
			disabledAll();
			$('#app-loader').removeClass('hidden');
		},
		success:function(html)
		{
			duplicate = false;

			// console.log($(html).find('#apps-tabs').find('a').first().attr('appurl'));

			$.each($('#apps-tabs').find('a'), function( index, a )
			{
				if($(a).attr('appurl') == $(html).find('#apps-tabs').find('a').first().attr('appurl'))
				{
					duplicate = true;
					return false;
				}
			});

			if(!duplicate)
			{
				$('#apps-tabs').append($(html).find('#apps-tabs').html());
				$('#apps-tabs-content').append($(html).find('#apps-tabs-content').html());
			}

			$('#apps-tabs a:last').tab('show');
			$('#app-loader').addClass('hidden');
			changeWindowsUrl(aliasUrl);
			enableAll();
			resizeApplicationGrid();
			$('.decima-erp-tooltip').tooltip('hide');
		}
	});
}
