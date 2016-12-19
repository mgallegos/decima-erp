{{--
 * @file
 * Header CSS layout.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 --}}
{{-- Bootstrap is not supported in the old Internet Explorer compatibility modes. To be sure you're using the latest rendering mode for IE, consider including folowing meta tag:--}}
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
{!! Html::style('assets/bootstrap-v3.3.6/css/bootstrap.min.css') !!}
@if(!isset($theme))
  {!! Html::style('assets/bootstrap-v3.3.6/css/bootstrap-theme.min.css') !!}
@else
  {!! Html::style('assets/bootstrap-v3.3.6/css/' . $theme . '.min.css') !!}
@endif
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous"> -->
{!! Html::style('assets/font-awesome-v4.7.0/css/font-awesome.min.css') !!}
{!! Html::style('assets/jquery-ui-v1.10.3/css/smoothness/jquery-ui-1.10.3.custom.css') !!}
{!! Html::style('assets/jquery-free-jqGrid-v4.13.5/css/ui.jqgrid.css') !!}
{!! Html::style('assets/jquery-calculator-v2.0.1/jquery.calculator.css') !!}
{!! Html::style('assets/jquery-uix-multiselect-v2.0/css/jquery.uix.multiselect.css') !!}
{!! Html::style('assets/jquery-ui-timepicker-addon-v1.6.3/dist/jquery-ui-timepicker-addon.min.css') !!}
<!-- {!! Html::style('assets/amcharts-v3.17.0/plugins/export/export.css') !!} -->
{!! Html::style('assets/bootstrap-tokenfield-dev-9c06df4/css/bootstrap-tokenfield.min.css') !!}
{!! Html::style('assets/intro-js-v2.3.0/minified/introjs.min.css') !!}
{!! Html::style('assets/bootstrap-fileinput-v4.3.5/css/fileinput.min.css') !!}
<!-- {!! Html::style('assets/intro-js-v2.3.0/minified/introjs-rtl.min.css') !!} -->
{!! Html::style('assets/quill-v1.0.4/css/quill.snow.css') !!}
{!! Html::style('assets/kwaai/css/main.css') !!}
{!! Html::style('assets/kwaai/css/button-custom-classes.css') !!}
