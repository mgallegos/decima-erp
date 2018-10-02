<script src="{{ URL::asset('assets/jquery-v2.2.4/jquery.js') }}"></script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" integrity="sha384-3ceskX3iaEnIogmQchP8opvBy3Mi7Ce34nWjpBIwVTHfGYWQS9jwHDVRnpKKHJg7" crossorigin="anonymous"></script> -->
<script src="{{ URL::asset('assets/jquery-free-jqGrid-v4.13.5/js/jquery.jqgrid.min.js') }}"></script>
<script src="{{ URL::asset('assets/jquery-ui-v1.12.1/jquery-ui.min.js') }}"></script>
<script src="{{ URL::asset('assets/bootstrap-v3.3.6/js/bootstrap.min.js') }}"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.min.js" integrity="sha384-XTs3FgkjiBgo8qjEjBk0tGmf3wPrWtA6coPfQDfFEY8AnYJwjalXCiosYRBIBZX8" crossorigin="anonymous"></script> -->
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" integrity="sha384-BLiI7JTZm+JWlgKa0M0kGRpJbF2J8q+qreVrKBC47e3K6BW78kGLrCkeRX6I9RoK" crossorigin="anonymous"></script> -->
<script src="{{ URL::asset('assets/jquery-history-v1.8/jquery.history.js') }}"></script>
<script src="{{ URL::asset('assets/jquery-scrollto-v2.1.2/jquery.scrollTo.min.js') }}"></script>
<script src="{{ URL::asset('assets/jquery-localscroll-v2.0.0/jquery.localScroll.min.js') }}"></script>
<script src="{{ URL::asset('assets/jquery-calculator-v2.0.1/jquery.plugin.min.js') }}"></script>
<script src="{{ URL::asset('assets/jquery-calculator-v2.0.1/jquery.calculator.min.js') }}"></script>
<script src="{{ URL::asset('assets/jquery-maskedinput-v1.4.1/jquery.maskedinput.min.js') }}"></script>
<script src="{{ URL::asset('assets/jquery-uix-multiselect-v2.0/js/jquery.uix.multiselect.min.js') }}"></script>
<script src="{{ URL::asset('assets/jquery-highlight-v4.0/jquery.highlight.min.js') }}"></script>
<script src="{{ URL::asset('assets/jquery-ui-timepicker-addon-v1.6.3/dist/jquery-ui-timepicker-addon.min.js') }}"></script>
<script src="{{ URL::asset('assets/bootstrap-tokenfield-dev-9c06df4/bootstrap-tokenfield.min.js') }}"></script>>
<!-- <script src="{{ URL::asset('assets/amcharts-v3.17.0/amcharts.js') }}"></script>
<script src="{{ URL::asset('assets/amcharts-v3.17.0/themes/light.js') }}"></script>
<script src="{{ URL::asset('assets/amcharts-v3.17.0/serial.js') }}"></script>
<script src="{{ URL::asset('assets/amcharts-v3.17.0/pie.js') }}"></script>
<script src="{{ URL::asset('assets/amcharts-v3.17.0/plugins/export/export.min.js') }}"></script>
<script src="{{ URL::asset('assets/amcharts-v3.17.0/plugins/responsive/responsive.min.js') }}"></script> -->
<script src="{{ URL::asset('assets/intro-js-v2.3.0/minified/intro.min.js') }}"></script>
{!! Html::script('assets/bootstrap-fileinput-v4.3.5/js/plugins/canvas-to-blob.min.js') !!}
{!! Html::script('assets/bootstrap-fileinput-v4.3.5/js/plugins/sortable.min.js') !!}
{!! Html::script('assets/bootstrap-fileinput-v4.3.5/js/plugins/purify.min.js') !!}
{!! Html::script('assets/bootstrap-fileinput-v4.3.5/js/fileinput.min.js') !!}
{!! Html::script('assets/bootstrap-fileinput-v4.3.5/themes/fa/theme.js') !!}
{!! Html::script('assets/bootstrap-fileinput-v4.3.5/js/locales/es.js') !!}
{!! Html::script('assets/quill-v1.3.0/js/quill.min.js') !!}
{!! Html::script('assets/keymaster-v1.6.1/keymaster.min.js') !!}
<script src="{{ URL::asset('assets/jquery-slidereveal-v1.1.2/jquery.slidereveal.min.js') }}"></script>
<script src="{{ URL::asset('assets/select2-v4.0.5/select2.js') }}"></script>

<script type='text/javascript'>
	var userApps, lang, History, State;
	$(document).ready(function(){
		lang = $.parseJSON('{!! json_encode( Translator::getFileArray('form')) !!}');
		userApps = $.parseJSON('{!! UserManager::buildUserMenu() !!}');
	});
</script>

<script src="{{ URL::asset('assets/kwaai/js/helpers-v1.0.0.js') }}"></script>
<script src="{{ URL::asset('assets/kwaai/js/apps-engine-v1.0.2.js') }}"></script>
{{-- <script src="{{ URL::asset('assets/kwaai/js/validation-engine.js') }}"></script> --}}
<script src="{{ URL::asset('assets/jquery-mg-validation-v0.4/jquery.jqMgVal.src.js') }}"></script>
<script src="{{ URL::asset('assets/kwaai/js/base-v1.0.8.js') }}"></script>

<script type='text/javascript'>
  $.fn.jqMgVal.defaults.successIconClass = 'fa fa-check-circle';
  $.fn.jqMgVal.defaults.failureIconClass = 'fa fa-times-circle';
</script>

@include('layouts.header-javascript-localization')
