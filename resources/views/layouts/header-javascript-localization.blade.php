<script src="{{ URL::asset('assets/jquery-mg-validation-v0.5/i18n/jquery.jqMgVal.locale-es.js') }}"></script>
<script src="{{ URL::asset('assets/kwaai/js/datepicker-es.js') }}"></script>
<script src="{{ URL::asset('assets/jquery-ui-timepicker-addon-v1.6.3/dist/i18n/jquery-ui-timepicker-es.js') }}"></script>
<script src="{{ URL::asset('assets/jquery-free-jqGrid-v4.13.5/js/i18n/grid.locale-es.min.js') }}"></script>
<!-- <script src="{{ URL::asset('assets/jquery-free-jqGrid-v4.13.5/js/i18n/grid.locale-en.min.js') }}"></script> -->
<script src="{{ URL::asset('assets/jquery-calculator-v2.0.1/jquery.calculator-es.js') }}"></script>
<script src="{{ URL::asset('assets/jquery-uix-multiselect-v2.0/js/locales/jquery.uix.multiselect_es.js') }}"></script>
<!-- <script src="{{ URL::asset('assets/amcharts-v3.17.0/lang/es.js') }}"></script> -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/locale/es-us.js"></script>

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
