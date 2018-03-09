<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/free-jqgrid/4.13.5/js/jquery.jqgrid.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/history.js/1.8/bundled/html4+html5/jquery.history.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.2/jquery.scrollTo.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-localScroll/2.0.0/jquery.localScroll.min.js"></script>
<script src="{{ URL::asset('assets/jquery-calculator-v2.0.1/jquery.plugin.min.js') }}"></script>
<script src="{{ URL::asset('assets/jquery-calculator-v2.0.1/jquery.calculator.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>
<script src="{{ URL::asset('assets/jquery-uix-multiselect-v2.0/js/jquery.uix.multiselect.min.js') }}"></script>
<script src="{{ URL::asset('assets/jquery-highlight-v4.0/jquery.highlight.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js"></script>
<script src="{{ URL::asset('assets/bootstrap-tokenfield-dev-9c06df4/bootstrap-tokenfield.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intro.js/2.3.0/intro.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.3.5/js/plugins/canvas-to-blob.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.3.5/js/plugins/sortable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.3.5/js/plugins/purify.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.3.5/js/fileinput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.3.5/themes/fa/theme.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.3.5/js/locales/es.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.0/quill.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/2.1.4/js.cookie.min.js"></script>


<script type='text/javascript'>
	var userApps, lang, History, State;

	$(document).ready(function(){
		lang = $.parseJSON('{!! json_encode( Translator::getFileArray('form')) !!}');
		userApps = $.parseJSON('{!! UserManager::buildUserMenu() !!}');
	});
</script>

<script src="{{ URL::asset('assets/kwaai/js/helpers.js') }}"></script>
<script src="{{ URL::asset('assets/kwaai/js/apps-engine.js') }}"></script>
<script src="{{ URL::asset('assets/jquery-mg-validation-v0.2/jquery.jqMgVal.src.js') }}"></script>
<script src="{{ URL::asset('assets/kwaai/js/base.js') }}"></script>

<script type='text/javascript'>
  $.fn.jqMgVal.defaults.successIconClass = 'fa fa-check-circle';
  $.fn.jqMgVal.defaults.failureIconClass = 'fa fa-times-circle';
</script>

@include('layouts.header-javascript-localization-cdn')