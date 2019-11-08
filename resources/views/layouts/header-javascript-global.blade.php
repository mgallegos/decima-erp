<script type='text/javascript'>
	var userApps, lang, History, State, deviceIsMobile, deviceIsSafari;

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
	});

</script>
