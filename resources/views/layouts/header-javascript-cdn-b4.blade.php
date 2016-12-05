{{--
 * @file
 * Header Javascript layout.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/free-jqgrid/4.13.5/js/jquery.jqgrid.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.ui/1.10.3/jquery.ui.core.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.ui/1.10.3/jquery.ui.position.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.ui/1.10.3/jquery.ui.widget.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.ui/1.10.3/jquery.ui.mouse.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.ui/1.10.3/jquery.ui.draggable.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.ui/1.10.3/jquery.ui.droppable.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.ui/1.10.3/jquery.ui.resizable.min.js"></script>
<script src="{{ URL::asset('assets/jquery-ui-v1.10.3/dev/jquery.ui.autocomplete.js') }}"></script>
<script src="https://cdn.jsdelivr.net/jquery.ui/1.10.3/jquery.ui.datepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.ui/1.10.3/jquery.ui.menu.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.ui/1.10.3/jquery.ui.slider.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.ui/1.10.3/jquery.ui.effect.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.ui/1.10.3/jquery.ui.effect-shake.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.ui/1.10.3/jquery.ui.effect-highlight.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.min.js" integrity="sha384-XTs3FgkjiBgo8qjEjBk0tGmf3wPrWtA6coPfQDfFEY8AnYJwjalXCiosYRBIBZX8" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" integrity="sha384-BLiI7JTZm+JWlgKa0M0kGRpJbF2J8q+qreVrKBC47e3K6BW78kGLrCkeRX6I9RoK" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/history.js/1.8/bundled/html4+html5/jquery.history.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/1.4.11/jquery.scrollTo.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.2/jquery.scrollTo.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-localScroll/1.3.5/jquery.localScroll.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-localScroll/1.4.0/jquery.localScroll.min.js"></script> -->
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


<script type='text/javascript'>
	var userApps, lang, History, State;

	$(document).ready(function(){
		lang = $.parseJSON('{!! json_encode( Translator::getFileArray('form')) !!}');
		userApps = $.parseJSON('{!! UserManager::buildUserMenu() !!}');
	});
</script>

<script src="{{ URL::asset('assets/kwaai/js/helpers.js') }}"></script>
<script src="{{ URL::asset('assets/kwaai/js/apps-engine.js') }}"></script>
<script src="{{ URL::asset('assets/jquery-mg-validation-v0.1/jquery.jqMgVal.src.js') }}"></script>
<script src="{{ URL::asset('assets/kwaai/js/base.js') }}"></script>

<script type='text/javascript'>
  $.fn.jqMgVal.defaults.successIconClass = 'fa fa-check-circle';
  $.fn.jqMgVal.defaults.failureIconClass = 'fa fa-times-circle';
</script>

@include('layouts.header-javascript-localization-cdn')
