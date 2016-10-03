{{--
 * @file
 * Top bar layout.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 --}}

<nav id="page-navbar" class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container">
 		<div class="navbar-header">
       <!-- <a class="navbar-brand" href="{{ AppManager::getBrandUrl() }}" target="_blank"><i class="{{ AppManager::getSystemIcon() }}"></i> {{ AppManager::getSystemName() }}</a> -->
       <a class="navbar-brand" href="{{ AppManager::getBrandUrl() }}" target="_blank">
         <img src="{{URL::asset('assets/kwaai/images/logo.png')}}">
       </a>
		</div>
		<div class="navbar-left visible-md visible-lg">
			<ul class="nav navbar-nav hidden-sm">
				<li class="divider-vertical"></li>
				<li><a id="dashboard-top-bar-menu" class="fake-link"><i class="fa fa-dashboard"></i> {{ Lang::get('dashboard.appName') }}</a></li>
				<li><a id="user-apps-top-bar-menu" href="#user-apps-container"><i class="fa fa-tasks"></i> {{ Lang::get('base.userAppsTitle') }}</a></li>
				<li><a id="top-navbar-menu" href="#body" style="display: none;" class="sr-only">Scroll to navbar</a></li>
				<li id='user-organizations-dropdown-menu' class="dropdown base-popover" data-hint="{{ Lang::get('base.organizationsMenuPopoverContent', array('user' => AuthManager::getLoggedUserFirstname())) }}">
					@if (count($userOrganizations) > 1 && count($userOrganizations) < 15)
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-sitemap"></i> {{ Lang::get('base.userOrganizations') }} <b class="caret"></b></a>
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
          <li><a class="fake-link" data-toggle="modal" data-target="#user-organizations-modal"><i class="fa fa-sitemap"></i> {{ Lang::get('base.userOrganizations') }}</a></li>
        @endif
			</ul>
		</div>
		<ul class="nav navbar-nav navbar-right visible-md visible-lg" data-position="bottom" data-step="5" data-intro="{{ Lang::get('base.dropdownMenuPopoverContent') }}">
			<li id="main-user-dropdown-menu" class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><img id='user-gravatar' class='img-circle navbar-gravatar navbar-left base-popover' onerror="this.src='{{URL::asset('assets/kwaai/images/anonymous.png')}}'" src='{{{ Gravatar::buildGravatarURL( AuthManager::getLoggedUserEmail(), 40 ) }}}' data-position="bottom" data-step="4" data-intro="{{ Lang::get('base.gravatarPopoverContent') }}">{{ substr(AuthManager::getLoggedUserFirstname(), 0, 10) }} <b class="caret"></b></a>
				<ul id="user-dropdown-menu" class="dropdown-menu base-popover">
					<li><a id='user-preferences-top-bar-menu' class="fake-link" data-preferences-url="{{ AppManager::getUserPreferencesPageUrl() }}"><i class="fa fa-cog"></i> {{ Lang::get('base.preferences') }}</a></li>
					<li class="divider"></li>
					<li><a href="{{ URL::to('security/logout/logout-attempt') }}"><i class="fa fa-power-off"></i> {{ Lang::get('base.logout') }}</a></li>
				</ul>
			</li>
		</ul>
		<div class="row visible-md visible-lg">
      @if (count($userOrganizations) > 1)
        <div id="search-action-container" class="col-lg-3 col-md-2 pull-right base-popover" data-position="bottom">
      @else
        <div id="search-action-container" class="col-lg-4 col-md-3 pull-right base-popover" data-position="bottom">
      @endif
			{!! Form::open(array('role' => 'search', 'class' => 'navbar-form navbar-right', 'onsubmit' => 'return false;')) !!}
  			<div class="form-group" data-step="3" data-intro="{{ Lang::get('base.searchActionPopoverContent') }}">
  				{!! Form::autocomplete('search-action', $userActions, array('class' => 'form-control', 'placeholder' => Lang::get('base.search')), 'search-action', null, null, 'fa-pencil-square-o', 'input-group-sm') !!}
  			</div>
			{!! Form::close() !!}
		  </div>
		</div>
	</div>
</nav>
