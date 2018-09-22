<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous"> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.min.css"/>
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.3/themes/smoothness/jquery-ui.min.css" /> -->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.3/themes/smoothness/jquery.ui.theme.min.css" /> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/free-jqgrid/4.13.5/css/ui.jqgrid.min.css">
{!! Html::style('assets/jquery-calculator-v2.0.1/jquery.calculator.css') !!}
{!! Html::style('assets/jquery-uix-multiselect-v2.0/css/jquery.uix.multiselect.css') !!}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css" />
<!-- <script src="https://www.amcharts.com/lib/3/plugins/export/export.css"></script> -->
{!! Html::style('assets/bootstrap-tokenfield-dev-9c06df4/css/bootstrap-tokenfield.min.css') !!}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/2.3.0/introjs.min.css" />
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/2.3.0/introjs-rtl.min.css" /> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.3.5/css/fileinput.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.0/quill.snow.min.css" />
@if (!empty(Config::get('system-security.additional_cdn_css')))
	@foreach (Config::get('system-security.additional_cdn_css') as $index => $css)
		<link rel="stylesheet" href="{{ trim(preg_replace('/\s+/', ' ', $css)) }}" />
	@endforeach
@endif
{!! Html::style('assets/kwaai/css/main-v1.0.7.css') !!}
{!! Html::style('assets/kwaai/css/button-custom-classes.css') !!}
