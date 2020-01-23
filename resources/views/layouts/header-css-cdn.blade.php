<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> -->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" /> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/css/bootstrap.min.css" />
@if(!isset($theme))
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous"> -->
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap-theme.min.css" /> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/css/bootstrap-theme.min.css" />
@else
  {!! Html::style('assets/bootstrap-v3.3.6/css/' . $theme . '.min.css') !!}
@endif
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous"> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/free-jqgrid/4.13.5/css/ui.jqgrid.min.css">
<link rel="stylesheet" href="https://storage.googleapis.com/decimaerp-cdn-bucket/jquery-calculator-v2.0.1/jquery.calculator.css"/>
<link rel="stylesheet" href="https://storage.googleapis.com/decimaerp-cdn-bucket/jquery-uix-multiselect-v2.0/css/jquery.uix.multiselect.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css" />
<link rel="stylesheet" href="https://storage.googleapis.com/decimaerp-cdn-bucket/bootstrap-tokenfield-dev-9c06df4/css/bootstrap-tokenfield.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/2.3.0/introjs.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.3.5/css/fileinput.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.0/quill.snow.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar-scheduler/1.9.4/scheduler.css"/>

<!-- <link rel="stylesheet" href="https://storage.googleapis.com/decimaerp-cdn-bucket/kwaai/css/main-v1.1.4.css"/> -->
{!! Html::style('assets/kwaai/css/main-v1.1.4.css') !!}
<link rel="stylesheet" href="https://storage.googleapis.com/decimaerp-cdn-bucket/kwaai/css/button-custom-classes.css"/>

@if (!empty(Config::get('system-security.additional_cdn_css')))
	@foreach (Config::get('system-security.additional_cdn_css') as $index => $css)
    @if (!empty($css))
    <link rel="stylesheet" href="{{ trim(preg_replace('/\s+/', ' ', $css)) }}" />
    @endif
	@endforeach
@endif
