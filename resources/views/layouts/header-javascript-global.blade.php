<script type='text/javascript'>
	var userApps, lang, History, State, deviceIsMobile;

	$(document).ready(function()
	{
		lang = $.parseJSON('{!! json_encode( Translator::getFileArray('form')) !!}');
		userApps = $.parseJSON('{!! UserManager::buildUserMenu() !!}');

		@if(!Agent::isMobile())
			deviceIsMobile = false;
		@else
			deviceIsMobile = true;
		@endif
	});

</script>
