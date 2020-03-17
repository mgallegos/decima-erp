<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/free-jqgrid/4.13.5/js/jquery.jqgrid.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/history.js/1.8/bundled/html4+html5/jquery.history.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.2/jquery.scrollTo.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-localScroll/2.0.0/jquery.localScroll.min.js"></script>
<script src="https://storage.googleapis.com/decimaerp-cdn-bucket/jquery-calculator-v2.0.1/jquery.plugin.min.js"></script>
<script src="https://storage.googleapis.com/decimaerp-cdn-bucket/jquery-calculator-v2.0.1/jquery.calculator.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>
<script src="https://storage.googleapis.com/decimaerp-cdn-bucket/jquery-uix-multiselect-v2.0/js/jquery.uix.multiselect.min.js"></script>
<script src="https://storage.googleapis.com/decimaerp-cdn-bucket/jquery-highlight-v4.0/jquery.highlight.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js"></script>
<script src="https://storage.googleapis.com/decimaerp-cdn-bucket/bootstrap-tokenfield-dev-9c06df4/bootstrap-tokenfield.min.js"></script>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/slideReveal/1.1.2/jquery.slidereveal.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.23.0/moment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.0.3/tinymce.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.0.3/jquery.tinymce.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.0.3/plugins/table/plugin.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.0.3/plugins/code/plugin.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jSignature/2.1.2/jSignature.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar-scheduler/1.9.4/scheduler.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.10.0/dist/sweetalert2.all.min.js"></script>

@if (!empty(Config::get('system-security.additional_cdn_js')))
	@foreach (Config::get('system-security.additional_cdn_js') as $index => $js)
		@if (!empty($js))
			<script src="{{ trim(preg_replace('/\s+/', ' ', $js)) }}"></script>
    @endif
	@endforeach
@endif

@include('layouts.header-javascript-global')

<script src="https://storage.googleapis.com/decimaerp-cdn-bucket/kwaai/js/helpers-v1.1.1.js"></script>
<!-- <script src="{{ URL::asset('assets/kwaai/js/helpers-v1.1.1.js') }}"></script> -->
<script src="https://storage.googleapis.com/decimaerp-cdn-bucket/kwaai/js/apps-engine-v1.0.3.js"></script>
<!-- <script src="{{ URL::asset('assets/kwaai/js/apps-engine-v1.0.3.js') }}"></script> -->
<script src="https://storage.googleapis.com/decimaerp-cdn-bucket/jquery-mg-validation-v0.5/jquery.jqMgVal.src.js"></script>
<script src="https://storage.googleapis.com/decimaerp-cdn-bucket/kwaai/js/base-v1.4.3.js"></script>
{{-- <script src="{{ URL::asset('assets/kwaai/js/base-v1.4.3.js') }}"></script>  --}}

<script type='text/javascript'>
  $.fn.jqMgVal.defaults.successIconClass = 'fa fa-check-circle';
  $.fn.jqMgVal.defaults.failureIconClass = 'fa fa-times-circle';
</script>

@include('layouts.header-javascript-localization-cdn')
