<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
{!! Html::style('assets/bootstrap-v3.3.6/css/bootstrap.min.css') !!}
@if(!isset($theme))
  {!! Html::style('assets/bootstrap-v3.3.6/css/bootstrap-theme.min.css') !!}
@else
  {!! Html::style('assets/bootstrap-v3.3.6/css/' . $theme . '.min.css') !!}
@endif

{{-- Falta incluir local --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css"/>
{{-- Falta incluir local --}}

{!! Html::style('assets/font-awesome-v4.7.0/css/font-awesome.min.css') !!}
{!! Html::style('assets/jquery-ui-v1.12.1/jquery-ui.min.css') !!}
{!! Html::style('assets/jquery-free-jqGrid-v4.13.5/css/ui.jqgrid.css') !!}
{!! Html::style('assets/jquery-calculator-v2.0.1/jquery.calculator.css') !!}
{!! Html::style('assets/jquery-uix-multiselect-v2.0/css/jquery.uix.multiselect.css') !!}
{!! Html::style('assets/jquery-ui-timepicker-addon-v1.6.3/dist/jquery-ui-timepicker-addon.min.css') !!}
{!! Html::style('assets/bootstrap-tokenfield-dev-9c06df4/css/bootstrap-tokenfield.min.css') !!}
{!! Html::style('assets/intro-js-v2.3.0/minified/introjs.min.css') !!}
{!! Html::style('assets/bootstrap-fileinput-v4.3.5/css/fileinput.min.css') !!}
{!! Html::style('assets/quill-v1.3.0/css/quill.snow.min.css') !!}
{!! Html::style('assets/select2-v4.0.5/select2.css') !!}
{!! Html::style('assets/fullcalendar-v3.9.0/fullcalendar.min.css') !!}
{!! Html::style('assets/fullcalendar-scheduler-v1.9.4/scheduler.css') !!}

@if (!empty(Config::get('system-security.additional_css')))
	@foreach (Config::get('system-security.additional_css') as $index => $css)
    @if (!empty($css))
		  <link rel="stylesheet" href="{{ URL::asset($css) }}"/>
    @endif
	@endforeach
@endif
{!! Html::style('assets/kwaai/css/main-v1.1.5.css') !!}
{!! Html::style('assets/kwaai/css/button-custom-classes.css') !!}
