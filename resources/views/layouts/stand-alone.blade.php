{{--
 * @file
 * Login page.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 --}}
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
  @if (Config::get('system-security.cdnjs'))
    @include('layouts.header-css-cdn')
    @include('layouts.header-javascript-cdn')
  @else
    @include('layouts.header-css')
    @include('layouts.header-javascript')
  @endif
	<title>{{ AppManager::getSystemName() }}</title>
</head>
<body id='body'>
  <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  	<div class="container">
   		<div class="navbar-header">
         <!-- <a class="navbar-brand" href="{{ AppManager::getBrandUrl() }}" target="_blank"><i class="{{ AppManager::getSystemIcon() }}"></i> {{ AppManager::getSystemName() }}</a> -->
         <a class="navbar-brand" href="{{ AppManager::getBrandUrl() }}" target="_blank">
           <img src="{{URL::asset('assets/kwaai/images/logo.png')}}">
         </a>
  		</div>
  </nav>
	<div id='page-container' class="container" role="main">
	  <div class="row" style="margin-top:80px;">
	  	<fieldset id="main-panel-fieldset">
	  		@yield('container')
	    </fieldset>
	  </div>
	</div>
	{!! Form::button('<i class="fa fa-spinner fa-spin fa-lg"></i> ' . Lang::get('form.loadButton'), array('id' => 'app-loader', 'class' => 'btn btn-warning btn-disable btn-lg app-loader hidden', 'disabled' => 'disabled')) !!}
  {!! Form::hidden('app-token', csrf_token(), array('id' => 'app-token')) !!}
	<script type='text/javascript'>
		$(document).ready(function(){
			{!! FormJavascript::getCode() !!}
		});
	</script>
</body>
</html>
