<script type='text/javascript'>
	var userApps, lang, History, State, deviceIsMobile, deviceIsSafari, deviceIsChrome;
	var defaultDecimaDataSourceType = 'localStorage';

	var API = '';
  var breadcrumbLoader = [];
  var mainAppLoader = [];
  var windowWidth;
  var windowHeight;
  var ajaxHeight = 45;
  var ajaxWidth = 154;
  var minWidthExpandedMenu = 1366;
  var bsModalshowMenu = false;

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
