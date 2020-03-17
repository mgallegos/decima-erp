<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/free-jqgrid/4.13.5/js/jquery.jqgrid.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intro.js/2.3.0/intro.min.js"></script>
<!-- piexif.min.js is only needed for restoring exif data in resized images and when you
    wish to resize images before upload. This must be loaded before fileinput.min.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/plugins/piexif.min.js" type="text/javascript"></script>
<!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview.
    This must be loaded before fileinput.min.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/plugins/sortable.min.js" type="text/javascript"></script>
<!-- purify.min.js is only needed if you wish to purify HTML content in your preview for
    HTML files. This must be loaded before fileinput.min.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/plugins/purify.min.js" type="text/javascript"></script>
<!-- popper.min.js below is needed if you use bootstrap 4.x. You can also use the bootstrap js
   3.3.x versions without popper.min.js. -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
<!-- the main fileinput plugin file -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/fileinput.min.js"></script>
<!-- optionally if you need a theme like font awesome theme you can include it as mentioned below -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/themes/fa/theme.min.js"></script>
<!-- optionally if you need translation for your language then include  locale file as mentioned below -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/locales/es.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.0/quill.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/2.1.4/js.cookie.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/keymaster/1.6.1/keymaster.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slideReveal/1.1.2/jquery.slidereveal.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.js"></script>
@if (!empty(Config::get('system-security.additional_cdn_js')))
	@foreach (Config::get('system-security.additional_cdn_js') as $index => $js)
		@if (!empty($js))
			<script src="{{ trim(preg_replace('/\s+/', ' ', $js)) }}"></script>
    @endif
	@endforeach
@endif

@include('layouts.header-javascript-global')



<script src="https://storage.googleapis.com/decimaerp-cdn-bucket/kwaai/js/helpers-v1.1.1.js"></script>
<script src="https://storage.googleapis.com/decimaerp-cdn-bucket/kwaai/js/apps-engine-v1.0.3.js"></script>
<script src="https://storage.googleapis.com/decimaerp-cdn-bucket/jquery-mg-validation-v0.5/jquery.jqMgVal.src.js"></script>
<script src="https://storage.googleapis.com/decimaerp-cdn-bucket/kwaai/js/base-v1.4.3.js"></script>

<script type='text/javascript'>
  $.fn.jqMgVal.defaults.successIconClass = 'fa fa-check-circle';
  $.fn.jqMgVal.defaults.failureIconClass = 'fa fa-times-circle';
</script>

@include('layouts.header-javascript-localization-cdn')
