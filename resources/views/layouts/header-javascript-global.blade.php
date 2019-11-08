<script type='text/javascript'>
	var userApps, lang, History, State, deviceIsMobile, deviceIsSafari, deviceIsChrome;

	$(document).ready(function()
	{
		lang = $.parseJSON('{!! json_encode( Translator::getFileArray('form')) !!}');
		userApps = $.parseJSON('{!! UserManager::buildUserMenu() !!}');

		@if(!Agent::isMobile())
			deviceIsMobile = false;
		@else
			deviceIsMobile = true;
		@endif

		@if(!Agent::isSafari())
			deviceIsSafari = false;
		@else
			deviceIsSafari = true;
		@endif

		@if(!Agent::isChrome())
			deviceIsChrome = false;
		@else
			deviceIsChrome = true;
			deviceIsSafari = false;
		@endif
	});

</script>
