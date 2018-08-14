<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" integrity="sha384-3ceskX3iaEnIogmQchP8opvBy3Mi7Ce34nWjpBIwVTHfGYWQS9jwHDVRnpKKHJg7" crossorigin="anonymous"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/free-jqgrid/4.13.5/js/jquery.jqgrid.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/history.js/1.8/bundled/html4+html5/jquery.history.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/1.4.11/jquery.scrollTo.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.2/jquery.scrollTo.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-localScroll/1.3.5/jquery.localScroll.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-localScroll/2.0.0/jquery.localScroll.min.js"></script>
<script src="{{ URL::asset('assets/jquery-calculator-v2.0.1/jquery.plugin.min.js') }}"></script>
<script src="{{ URL::asset('assets/jquery-calculator-v2.0.1/jquery.calculator.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>
<script src="{{ URL::asset('assets/jquery-uix-multiselect-v2.0/js/jquery.uix.multiselect.min.js') }}"></script>
<script src="{{ URL::asset('assets/jquery-highlight-v4.0/jquery.highlight.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js"></script>
<script src="{{ URL::asset('assets/bootstrap-tokenfield-dev-9c06df4/bootstrap-tokenfield.min.js') }}"></script>
<!-- <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
<script src="https://www.amcharts.com/lib/3/pie.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/responsive/responsive.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/intro.js/2.3.0/intro.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.3.5/js/plugins/canvas-to-blob.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.3.5/js/plugins/sortable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.3.5/js/plugins/purify.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.3.5/js/fileinput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.3.5/themes/fa/theme.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.3.5/js/locales/es.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.0/quill.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/2.1.4/js.cookie.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/keymaster/1.6.1/keymaster.min.js"></script>
@if (!empty(Config::get('system-security.additional_cdn_js')))
	@foreach (Config::get('system-security.additional_cdn_js') as $index => $js)
		<script src="{{ trim(preg_replace('/\s+/', ' ', $js)) }}"></script>
	@endforeach
@endif

<script type='text/javascript'>
	var userApps, lang, History, State;
	$(document).ready(function(){
		lang = $.parseJSON('{!! json_encode( Translator::getFileArray('form')) !!}');
		userApps = $.parseJSON('{!! UserManager::buildUserMenu() !!}');
	});
</script>

<script src="{{ URL::asset('assets/kwaai/js/helpers.js') }}"></script>
<script src="{{ URL::asset('assets/kwaai/js/apps-engine.js') }}"></script>
<script src="{{ URL::asset('assets/jquery-mg-validation-v0.3/jquery.jqMgVal.src.js') }}"></script>
<script src="{{ URL::asset('assets/kwaai/js/base-v1.0.2.js') }}"></script>

<script type='text/javascript'>
  $.fn.jqMgVal.defaults.successIconClass = 'fa fa-check-circle';
  $.fn.jqMgVal.defaults.failureIconClass = 'fa fa-times-circle';
</script>

@include('layouts.header-javascript-localization-cdn')
