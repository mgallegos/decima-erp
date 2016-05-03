/**
 * @file
 * Description of the script.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

$(document).ready(function(){

	if($('#da-logged-user-popover-shown').val() == '0')
	{
		setTimeout(function () {
			window.scrollTo(0, 0);
			$('#apps-tabs-content').children('.active').children('.breadcrumb-organization-name').popover('show');
		}, 500);
	}

	if($('#da-logged-user-popover-shown').val() == '1' && $('#da-logged-user-multiple-organization-popover-shown').val() == '0')
	{
		if($('#user-organizations-dropdown-menu').children().length > 0)
		{
			setTimeout(function () {
				window.scrollTo(0, 0);
				$('#user-organizations-dropdown-menu').popover('show');
			}, 500);
		}
	}


});
