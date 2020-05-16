<script src="https://storage.googleapis.com/decimaerp-cdn-bucket/jquery-mg-validation-v0.7/i18n/jquery.jqMgVal.locale-es.js"></script>
<script src="https://storage.googleapis.com/decimaerp-cdn-bucket/kwaai/js/datepicker-es.js"></script>
<script src="https://storage.googleapis.com/decimaerp-cdn-bucket/jquery-ui-timepicker-addon-v1.6.3/dist/i18n/jquery-ui-timepicker-es.js"></script> <!-- No cambiar, tiene diferente el am y pm-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/free-jqgrid/4.13.5/js/i18n/grid.locale-es.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/free-jqgrid/4.13.5/js/i18n/grid.locale-en.min.js"></script> -->

<script src="https://storage.googleapis.com/decimaerp-cdn-bucket/jquery-calculator-v2.0.1/jquery.calculator-es.js"></script>
<script src="https://storage.googleapis.com/decimaerp-cdn-bucket/jquery-uix-multiselect-v2.0/js/locales/jquery.uix.multiselect_es.js"></script>
<!-- <script src="{{ URL::asset('assets/amcharts-v3.17.0/lang/es.js') }}"></script> -->

<script src="{{ URL::asset('assets/fullcalendar-v3.9.0/es-us.js') }}"></script>

<script type='text/javascript'>
	$.jgrid.locales["{{ Lang::locale() }}"].formatter.date.newformat = "{{ Lang::get('form.phpShortDateFormat')}}";
  $.jgrid.locales["{{ Lang::locale() }}"].formatter.integer.thousandsSeparator = "{{ Lang::get('form.thousandsSeparator')}}";
  $.jgrid.locales["{{ Lang::locale() }}"].formatter.number.thousandsSeparator = "{{ Lang::get('form.thousandsSeparator')}}";
  $.jgrid.locales["{{ Lang::locale() }}"].formatter.number.decimalSeparator = "{{ Lang::get('form.decimalSeparator')}}";
  $.jgrid.locales["{{ Lang::locale() }}"].formatter.number.defaultValue = "{{ Lang::get('form.defaultNumericValue')}}";
  $.jgrid.locales["{{ Lang::locale() }}"].formatter.currency.thousandsSeparator = "{{ Lang::get('form.thousandsSeparator')}}";
  $.jgrid.locales["{{ Lang::locale() }}"].formatter.currency.decimalSeparator = "{{ Lang::get('form.decimalSeparator')}}";
  $.jgrid.locales["{{ Lang::locale() }}"].formatter.currency.defaultValue = "{{ Lang::get('form.defaultNumericValue')}}";
</script>
