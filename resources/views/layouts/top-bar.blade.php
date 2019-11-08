<nav id="page-navbar" class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container-fluid">
 		<div class="navbar-header core-navbar-header">
			 <!-- <a id="core-mobile-top-bar-link" href="#core-menu" class="core-small-devices-menu"><i class="fa fa-bars fa-2x core-menu-top-bar-link-color"></i></a> -->
       <a class="navbar-brand" href="{{ AppManager::getBrandUrl() }}" target="_blank">
         <img src="{{URL::asset('assets/kwaai/images/logo.png')}}">
       </a>
		</div>
		<div class="core-small-devices-menu">
			<ul class="nav navbar-right">
				@if(!empty(Config::get('system-security.custom_menu')))
				<li data-position="bottom" data-step="2" data-intro="{{ Lang::get('base.userAppsPopoverContent') }}">
					<a href="#core-menu" class="btn btn-default core-top-bar-button core-top-bar-open-menu"><i class="fa fa-bars fa-2x core-menu-top-bar-link-color"></i></a>
				</li>
				<li>
					<a class="btn btn-default core-top-bar-button core-top-bar-close-menu" style="display:none;"><i class="fa fa-times fa-2x core-menu-top-bar-link-color"></i></a>
				</li>
				@endif
			</ul>
		</div>
		<div class="core-small-devices-menu">
			<ul class="nav navbar-nav navbar-right" style="margin: 15px 5px 0 0;">
				<li>
					<img id='user-gravatar' class='img-circle navbar-gravatar navbar-left base-popover' onerror="this.src='{{URL::asset('assets/kwaai/images/anonymous.png')}}'" src='{{{ Gravatar::buildGravatarURL( AuthManager::getLoggedUserEmail(), 40 ) }}}' data-position="bottom" data-step="4" data-intro="{{ Lang::get('base.gravatarPopoverContent') }}">
				</li>
			</ul>
		</div>
		<div class="core-large-devices-menu">
			<ul class="nav navbar-nav">
				<li class="divider-vertical"></li>
				<li><a id="dashboard-top-bar-menu" class="fake-link"><i class="fa fa-dashboard"></i> {{ Lang::get('dashboard.appName') }}</a></li>
				<li><a id="user-apps-top-bar-menu" href="#user-apps-container" style="display: none;"><i class="fa fa-tasks"></i> {{ Lang::get('base.userAppsTitle') }}</a></li>
				<li><a id="top-navbar-menu" href="#body" style="display: none;" class="sr-only">Scroll to navbar</a></li>
				<li id='user-organizations-dropdown-menu' class="dropdown base-popover" data-hint="{{ Lang::get('base.organizationsMenuPopoverContent', array('user' => AuthManager::getLoggedUserFirstname())) }}">
					@if (count($userOrganizations) > 1 && count($userOrganizations) < 15)
            <a id='user-organizations-dropdown-menu-link' href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-sitemap"></i> {{ Lang::get('base.userOrganizations') }} <b class="caret"></b></a>
            <ul class="dropdown-menu">
            	@foreach ($userOrganizations as $index => $organization)
            		@if ($organization['id'] == AuthManager::getCurrentUserOrganization('id'))
									<li class="active">
										<a class="fake-link"><i class="fa fa-building-o"></i> {{ $organization['name'] }}</a>
									</li>
                @else
									<li>
										<a class="fake-link" onclick="changeLoggedUserOrganization('{{ $organization['id'] }}')"><i class="fa fa-building-o"></i> {{ $organization['name'] }}</a>
									</li>
                @endif
              @endforeach
            </ul>
          @endif
        </li>
        @if (count($userOrganizations) >= 15)
          <li><a id='user-organizations-dropdown-menu-link' class="fake-link" data-toggle="modal" data-target="#user-organizations-modal"><i class="fa fa-sitemap"></i> {{ Lang::get('base.userOrganizations') }}</a></li>
        @endif
			</ul>
			<ul class="nav navbar-nav navbar-right" style="margin-right: 5px;">
				<li id="main-user-dropdown-menu" class="dropdown" data-position="bottom" data-step="5" data-intro="{{ Lang::get('base.dropdownMenuPopoverContent') }}">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<img id='user-gravatar' class='img-circle navbar-gravatar navbar-left base-popover' onerror="this.src='{{URL::asset('assets/kwaai/images/anonymous.png')}}'" src='{{{ Gravatar::buildGravatarURL( AuthManager::getLoggedUserEmail(), 40 ) }}}' data-position="bottom" data-step="4" data-intro="{{ Lang::get('base.gravatarPopoverContent') }}">
						<span class='core-user-name'>{{ substr(AuthManager::getLoggedUserFirstname(), 0, 10) }} </span><b class="caret"></b>
					</a>
					<ul id="user-dropdown-menu" class="dropdown-menu base-popover">
						<li><a id='user-preferences-top-bar-menu' class="fake-link" data-preferences-url="{{ AppManager::getUserPreferencesPageUrl() }}"><i class="fa fa-cog"></i> {{ Lang::get('base.preferences') }}</a></li>
						<li class="divider"></li>
						<li><a href="{{ URL::to('security/logout/logout-attempt') }}"><i class="fa fa-power-off"></i> {{ Lang::get('base.logout') }}</a></li>
					</ul>
				</li>
				@if(!empty(Config::get('system-security.custom_menu')))
				<li data-position="bottom" data-step="2" data-intro="{{ Lang::get('base.userAppsPopoverContent') }}">
					<a href="#core-menu" class="btn btn-default core-top-bar-button core-top-bar-open-menu" ><i class="fa fa-bars fa-2x core-menu-top-bar-link-color"></i></a>
				</li>
				<li>
					<a class="btn btn-default core-top-bar-button core-top-bar-close-menu" style="display:none;"><i class="fa fa-times fa-2x core-menu-top-bar-link-color"></i></a>
				</li>
				@endif
			</ul>
		</div>

		<!-- <div class="row visible-md visible-lg">
      @if (count($userOrganizations) > 1)
        <div id="search-action-container" class="col-lg-3 col-md-2 pull-right base-popover" data-position="bottom">
      @else
        <div id="search-action-container" class="col-lg-4 col-md-3 pull-right base-popover" data-position="bottom">
      @endif
			{!! Form::open(array('role' => 'search', 'class' => 'navbar-form navbar-right', 'onsubmit' => 'return false;')) !!}
  			<div class="form-group" data-step="3" data-intro="{{ Lang::get('base.searchActionPopoverContent') }}" style="margin-bottom:0 !important;">
  				{!! Form::autocomplete('search-action', $userActions, array('class' => 'form-control', 'placeholder' => Lang::get('base.search')), 'search-action', null, null, 'fa-pencil-square-o', 'input-group-sm') !!}
  			</div>
			{!! Form::close() !!}
		  </div>
		</div>
	</div> -->
</nav>
