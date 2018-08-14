<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
  @if (Config::get('system-security.cdnjs'))
    @include('layouts.header-css-cdn')
    @include('layouts.header-javascript-cdn')
  @else
    @include('layouts.header-css')
    @include('layouts.header-javascript')
  @endif
	@yield('javascript')
	<title>{{ AppManager::getSystemName() }}</title>
</head>
<body id='body'>
	<div id="core-wrapper">
		<a href="#page-container" class="sr-only">Skip to content</a>
		@include('layouts.top-bar')
	  <div id="user-organizations-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	    <div class="modal-dialog">
	      <div class="modal-content">
	        <div class="modal-header">
	         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	         <h3 class="panel-title"><i class="fa fa-tasks"></i> {{ Lang::get('base.userOrganizations') }}</h3>
	        </div>
	        <div class="modal-body clearfix">
	          <div class="row">
	            <div class="col-md-8">
	              {!! Form::open(array('id' => 'change-to-organization-form', 'role' => 'form', 'onsubmit' => 'return false;')) !!}
	              <div class="form-group mg-hm clearfix">
	                {!! Form::label('change-to-organization-name', Lang::get('base.changeOrganization'), array('class' => 'control-label')) !!}
	                {!! Form::autocomplete('change-to-organization-name', UserManager::getUserOrganizationsAutocomplete(), array('class' => 'form-control', 'data-mg-required' => ''), 'change-to-organization-name', 'change-to-organization-id', '', 'fa-building-o') !!}
	                {!! Form::hidden('change-to-organization-id', '', array('id'  => 'change-to-organization-id')) !!}
	               </div>
	               {!! Form::close() !!}
	             </div>
	           </div>
	        </div>
	        <div id="user-organizations-modal-footer" class="modal-footer">
	          <button id="change-to-organization" type="button" class="btn btn-primary">{{ Lang::get('base.changeOrganizationButton') }}</button>
	          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-undo"></i> {{ Lang::get('toolbar.close') }}</button>
	        </div>
	      </div>
	    </div>
	  </div>
		<div id='page-container' class="container" role="main" data-current-page-width="">
		  <!-- <div class="row visible-lg visible-md"> -->
		  <div class="row">
		    <div class="col-lg-12">
		    	<fieldset id="main-panel-fieldset">
	  				<ul id="apps-tabs" class="nav nav-tabs">
	  					<li class="clearfix"><a href="#{{ $appInfo['id'] }}" appurl="{{ $appInfo['url'] }}" onclick="onClickTabEvent('{{ $appInfo['url'] }}')" data-toggle="tab">{{ $appInfo['name'] }}</a><button type="button" class="close" aria-hidden="true" onclick="closeTab('{{ $appInfo['id'] }}')">&times;</button></li>
	  				</ul>
	  				<div id="apps-tabs-content" class="tab-content">
	  					<div class="tab-pane fade" id="{{ $appInfo['id'] }}">
	  						<ul class="breadcrumb breadcrumb-custom">
	  							@foreach ($appInfo['breadcrumb'] as $index => $element)
	  								@if ($index+1 == count($appInfo['breadcrumb']))
	  								   <li class="active">{{ $element }}</li>
	  								@else
	  									<li><a onclick ="$('#user-apps-top-bar-menu').click();" class="user-apps-breadcrumb fake-link"> {{ $element }}</a></li>
	  								@endif
	  							@endforeach
	  						</ul>
	  						<span class="label label-default breadcrumb-organization-name base-popover pull-right" data-position="left" data-step="1" data-intro="{{ Lang::get('base.currentOrganizationPopoverContent', array('user' => AuthManager::getLoggedUserFirstname())) }}">{{ AuthManager::getCurrentUserOrganizationName() }}</span>
	  						<div class="panel panel-default panel-custom">
	  							<div class="panel-body clearfix">
	  								@section('container')
	  									<script type='text/javascript'>
	                      {!! FormJavascript::getGlobalCode() !!}
	  										$(document).ready(function(){
	  											{!! FormJavascript::getCode() !!}
	  										});
	  									</script>
	  								@show
	  							</div>
	  						</div>
	  					</div>
	        	</div>
						{!! Form::button('<i class="fa fa-spinner fa-spin fa-lg"></i> ' . Lang::get('form.loadButton'), array('id' => 'app-loader', 'class' => 'btn btn-warning btn-disable btn-lg app-loader hidden', 'disabled' => 'disabled')) !!}
						{!! Form::hidden('app-url', URL::to('/'), array('id' => 'app-url')) !!}
						{!! Form::hidden('app-token', csrf_token(), array('id' => 'app-token')) !!}
		        {!! Form::hidden('organization-currency-symbol', OrganizationManager::getOrganizationCurrencySymbol(), array('id' => 'organization-currency-symbol')) !!}
		        {!! Form::hidden('da-logged-user-popover-shown', AuthManager::getLoggedUserPopoversShown(), array('id' => 'da-logged-user-popover-shown')) !!}
		        {!! Form::hidden('da-logged-user-multiple-organization-popover-shown', AuthManager::getLoggedUserMultipleOrganizacionPopoversShown(), array('id' => 'da-logged-user-multiple-organization-popover-shown')) !!}
					</fieldset>
				</div>
				<div class="col-lg-12">
		      <fieldset id="user-apps-panel-fieldset">
		  			<div id='user-apps-container' class="panel panel-default base-popover" data-position="top" data-step="2" data-intro="{{ Lang::get('base.userAppsPopoverContent') }}">
		  				<div class="panel-heading">
		  					<button type="button" class="btn btn-default btn-sm btn-dashboard-toggle pull-right" data-toggle="collapse" data-target="#user-apps-content"><i class="fa fa-chevron-up"></i></button>
		  		    	<h3 id="user-apps-title" class="panel-title"><i class="fa fa-tasks"></i> {{ Lang::get('base.userAppsTitle') }}</h3>
		  			  	</div>
		  				<div id="user-apps-content" class="panel-body collapse in clearfix">
		  					<div id="user-apps-content-alert" class="alert alert-block alert-info">
		  						<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
		  						 {{ Lang::get('base.noAppsException') }}
		  					</div>
		  				</div>
		  			</div>
		      </fieldset>
		    </div>
	  	</div>
	  	<!-- <div class="alert alert-warning hidden-lg hidden-md">
	 			{!! Lang::get('base.resolutionException') !!}
	   	</div> -->
	  	<a id="back-to-top" class="btn btn-primary" role="button"><i class="fa fa-chevron-circle-up fa-2x"></i></a>
		</div>
		<div style="display:none;">
			{!! buildUserApps(UserManager::buildUserMenu(null, null, true), true, true, $userOrganizations) !!}
		</div>
	</div>
</body>
</html>
