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
<link href="{{URL::asset('assets/bootstrap-v3.3.6/css/bootstrap.min.css')}}" rel="stylesheet">
@if(!isset($theme))
  <link href="{{URL::asset('assets/bootstrap-v3.3.6/css/bootstrap-theme.min.css')}}" rel="stylesheet">
@else
  <link href="{{URL::asset('assets/bootstrap-v3.3.6/css/' . $theme . '.min.css')}}" rel="stylesheet">
@endif
<link href="{{URL::asset('assets/font-awesome-v4.4.0/css/font-awesome.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/jquery-ui-v1.10.3/css/smoothness/jquery-ui-1.10.3.custom.css')}}" rel="stylesheet">
<!-- <link href="{{URL::asset('assets/jquery-jqGrid-v4.8.2/css/ui.jqgrid.css')}}" rel="stylesheet"> -->
<!-- <link href="{{URL::asset('assets/jquery-jqGrid-v4.8.2/css/ui.jqgrid-bootstarp.css')}}" rel="stylesheet"> -->
<link href="{{URL::asset('assets/jquery-free-jqGrid-v4.13.1/css/ui.jqgrid.css')}}" rel="stylesheet">
<!-- <link href="{{URL::asset('assets/jquery-free-jqGrid-v4.13.1/css/ui.jqgrid-bootstarp.css')}}" rel="stylesheet"> -->
<link href="{{URL::asset('assets/jquery-calculator-v1.4.1/css/jquery.calculator.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/jquery-uix-multiselect-v2.0/css/jquery.uix.multiselect.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/amcharts-v3.17.0/plugins/export/export.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/bootstrap-tokenfield-dev-9c06df4/css/bootstrap-tokenfield.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/kwaai/css/main.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/kwaai/css/button-custom-classes.css')}}" rel="stylesheet">
