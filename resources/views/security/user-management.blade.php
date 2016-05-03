@extends('layouts.base')

@section('container')
{!! Html::style('assets/kwaai/css/security/user-management.css') !!}
{!! Html::script('assets/kwaai/js/security/user-management.js') !!}
{!! Form::hidden('um-organization-owner', AuthManager::getCurrentUserOrganization('created_by'), array('id' => 'um-organization-owner')) !!}
{!! Form::hidden('um-grid-users-title', Lang::get('security/user-management.gridUsersTitle', array('organization' => AuthManager::getCurrentUserOrganization('name'))) , array('id' => 'um-grid-users-title')) !!}
{!! Form::hidden('um-grid-admin-users-title', Lang::get('security/user-management.gridAdminUsersTitle'), array('id' => 'um-grid-admin-users-title')) !!}
{!! Form::hidden('um-new-user-action', $newUserAction, array('id' => 'um-new-user-action')) !!}
{!! Form::hidden('um-new-admin-user-action', $newAdminUserAction, array('id' => 'um-new-admin-user-action')) !!}
{!! Form::hidden('um-remove-user-action', $removeUserAction, array('id' => 'um-remove-user-action')) !!}
{!! Form::hidden('um-assign-role-action', $assignRoleAction, array('id' => 'um-assign-role-action')) !!}
{!! Form::hidden('um-unassign-role-action', $unassignRoleAction, array('id' => 'um-unassign-role-action')) !!}
{!! Form::hidden('um-user-root', AuthManager::isUserRoot(), array('id' => 'um-user-root')) !!}
{!! Form::hidden('um-logged-user-email', AuthManager::getLoggedUserEmail(), array('id' => 'um-logged-user-email')) !!}
{!! Form::hidden('um-logged-user-timezone', AuthManager::getLoggedUserTimezone(), array('id' => 'um-logged-user-timezone')) !!}
{!! Form::button('', array('id' => 'um-btn-remove-helper', 'class' => 'hidden', 'data-content' => Lang::get('security/user-management.deleteHelpText'))) !!}
{!! Form::button('', array('id' => 'um-btn-assign-helper', 'class' => 'hidden', 'data-content' => Lang::get('security/user-management.assignHelpText'))) !!}
{!! Form::button('', array('id' => 'um-btn-unassign-helper', 'class' => 'hidden', 'data-content' => Lang::get('security/user-management.unassignHelpText'))) !!}

<div class="row">
	<div class="col-lg-12 col-md-12">
		<div id="um-btn-toolbar" class="section-header btn-toolbar" role="toolbar">
			<div id="um-btn-group-1" class="btn-group btn-group-app-toolbar">
				@if (isset($userAppPermissions['newAdminUser']))
					<div class="btn-group">
						{!! Form::button(Lang::get('security/user-management.gridMode') . ' <span class="caret"></span>', array('id' => 'um-btn-grid-mode', 'class' => 'btn btn-default dropdown-toggle', 'data-container' => 'body', 'data-toggle' => 'dropdown')) !!}
						<ul class="dropdown-menu">
							<li class="active"><a id='um-grid-users-mode' class="fake-link"><i class="fa fa-users"></i> {{ Lang::get('security/user-management.gridUserMode') }}</a></li>
							<li><a id='um-grid-admin-users-mode' class="fake-link"><i class="fa fa-users"></i> {{ Lang::get('security/user-management.gridAdminUserMode') }}</a></li>
						</ul>
					</div>
					{!! Form::button('<i class="fa fa-plus"></i> ' . Lang::get('security/user-management.newAdmin'), array('id' => 'um-btn-new-admin', 'class' => 'btn btn-default um-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'data-original-title' => Lang::get('security/user-management.newAdminLongText'))) !!}
				@endif
				{!! Form::button('<i class="fa fa-plus"></i> ' . Lang::get('toolbar.new'), array('id' => 'um-btn-new', 'class' => 'btn btn-default um-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'data-original-title' => Lang::get('security/user-management.new'))) !!}
				{!! Form::button('<i class="fa fa-refresh"></i> ' . Lang::get('toolbar.refresh'), array('id' => 'um-btn-refresh', 'class' => 'btn btn-default um-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'data-original-title' => Lang::get('toolbar.refreshLongText'))) !!}
				<div class="btn-group">
					{!! Form::button('<i class="fa fa-share-square-o"></i> ' . Lang::get('toolbar.export') . ' <span class="caret"></span>', array('class' => 'btn btn-default dropdown-toggle', 'data-container' => 'body', 'data-toggle' => 'dropdown')) !!}
					<ul class="dropdown-menu">
         		<li><a id='um-btn-export-xls' class="fake-link"><i class="fa fa-file-excel-o"></i> xls</a></li>
         		<li><a id='um-btn-export-csv' class="fake-link"><i class="fa fa-file-text-o"></i> csv</a></li>
       		</ul>
				</div>
			</div>
			<div id="um-btn-group-2" class="btn-group btn-group-app-toolbar">
				{!! Form::button('<i class="fa fa-edit"></i> ' . Lang::get('toolbar.edit'), array('id' => 'um-btn-edit', 'class' => 'btn btn-default um-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'disabled' => '', 'data-original-title' => Lang::get('security/user-management.edit'))) !!}
				{!! Form::button('<i class="fa fa-minus"></i> ' . Lang::get('toolbar.remove'), array('id' => 'um-btn-delete', 'class' => 'btn btn-default um-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'disabled' => '', 'data-original-title' => Lang::get('security/user-management.deleteLongText'), 'data-non-admin-title' => Lang::get('security/user-management.deleteLongText'), 'data-admin-title' => Lang::get('security/user-management.deleteNonAdminLongText'))) !!}
				{!! Form::button('<i class="fa fa-tasks"></i> ' . Lang::get('security/user-management.preview'), array('id' => 'um-btn-menu-preview', 'class' => 'btn btn-default um-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'disabled' => '', 'data-original-title' => Lang::get('security/user-management.previewLongText'))) !!}
			</div>
			<div id="um-btn-group-3" class="btn-group btn-group-app-toolbar toolbar-block">
				{!! Form::button('<i class="fa fa-save"></i> ' . Lang::get('toolbar.save'), array('id' => 'um-btn-save', 'class' => 'btn btn-default um-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'disabled' => '', 'data-original-title' => Lang::get('security/user-management.save'))) !!}
				{!! Form::button('<i class="fa fa-times"></i> ' . Lang::get('toolbar.close'), array('id' => 'um-btn-close', 'class' => 'btn btn-default um-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'disabled' => '', 'data-original-title' => Lang::get('toolbar.closeLongText'))) !!}
			</div>
		</div>
		<div id="um-organization-owner-info-message" class="alert alert-block alert-info alert-custom hidden">
			 {{ Lang::get('security/user-management.organizationOwnerInfoMessage') }}
		</div>
		<div id="um-user-created-by-info-message" class="alert alert-block alert-info alert-custom hidden">
			<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
			 {{ Lang::get('security/user-management.userCreatedByInfoMessage') }}
		</div>
		<div id="um-grid-section" class="app-grid collapse in" data-app-grid-id="users-grid">
			{!!
			GridRender::setGridId("users-grid")
				->enablefilterToolbar(false, false)
				->hideXlsExporter()
  			->hideCsvExporter()
	    	->setGridOption('url', URL::to('general-setup/security/user-management/user-grid-data'))
	    	->setGridOption('caption', Lang::get('security/user-management.gridUsersTitle', array('organization' => AuthManager::getCurrentUserOrganization('name'))))
				//->setGridOption('filename', 'Organization Users')
	    	->setGridOption('postData', array('_token' => Session::token()))
	    	->setGridEvent('onSelectRow', 'umOnSelectRowEvent')
	    	->addColumn(array('index' => 'u.id', 'name' => 'id', 'hidden' => true))
	    	->addColumn(array('label' => Lang::get('security/user-management.firstname'), 'index' => 'u.firstname', 'name' => 'firstname'))
	    	->addColumn(array('label' => Lang::get('security/user-management.lastname'), 'index' => 'u.lastname', 'name' => 'lastname'))
	    	->addColumn(array('label' => Lang::get('security/user-management.email'), 'index' => 'u.email', 'name' => 'email'))
				->addColumn(array('label' => Lang::get('security/user-management.timezone'), 'index' => 'u.timezone', 'name' => 'timezone'))
	    	->addColumn(array('label' => Lang::get('security/user-management.isActive'), 'index' => 'u.is_active', 'name' => 'is_active', 'width' => 40, 'formatter' => 'select', 'editoptions' => array('value' => Lang::get('form.booleanText')), 'align' => 'center'))
	    	->addColumn(array('label' => Lang::get('security/user-management.createdBy'), 'index' => 'uc.email', 'name' => 'created_by'))
	    	->renderGrid();
			!!}
		</div>
	</div>
	<div id="um-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	    	<div id="um-modal-header" class="modal-header">
	    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	    		<h3 class="panel-title"><i class="fa fa-tasks"></i> {{ Lang::get('base.userAppsTitle') }}</h3>
	    	</div>
	    	<div id="um-modal-body" class="modal-body clearfix" data-no-apps-exception="{{ Lang::get('security/user-management.noAppsException') }}">
	    		<div class="alert alert-block alert-info um-custom-alert-info">
					<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
					 {{ Lang::get('security/user-management.noAppsException') }}
				</div>
	    	</div>
			<div id="um-modal-footer" class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('toolbar.close') }}</button>
			</div>
	    </div>
	  </div>
	</div>
</div>
<div id='um-admin-section' class="row collapse in">
	<div class="col-lg-6 section-block">
		<div class="clearfix">
			{!! Form::open(array('id' => 'um-roles-form', 'role' => 'form', 'onsubmit' => 'return false;')) !!}
				<fieldset id="um-roles-form-fieldset" disabled="disabled">
					<div class="section-header">
						<legend id="um-roles-form-legend">{{ Lang::get('security/user-management.rolesTitle') }}</legend>
					</div>
					<div class="um-multiselect clearfix">
						{!! Form::select('um-user-roles', array(), null, array('id' => 'um-user-roles', 'multiple' => '', 'class' => 'um-multiselect app-multiselect')) !!}
					</div>
				</fieldset>
			{!! Form::close() !!}
		</div>
		<div class="clearfix section-block">
			{!! Form::open(array('id' => 'um-permissions-form', 'role' => 'form', 'onsubmit' => 'return false;')) !!}
				<fieldset id="um-permissions-form-fieldset" disabled="disabled">
					<div class="section-header">
						<legend>{{ Lang::get('security/user-management.permissionsTitles') }}</legend>
				  		<div class="form-group clearfix">
								{!! Form::label('um-permissions-module-label', Lang::get('security/user-management.module'), array('class' => 'control-label')) !!}
						    {!! Form::autocomplete('um-permissions-module-label', $modules, array('class' => 'form-control'), 'um-permissions-module-label', 'um-permissions-module') !!}
						    {!! Form::hidden('um-permissions-module', null, array('id' => 'um-permissions-module')) !!}
					  	</div>
					  	<div class="form-group clearfix">
								{!! Form::label('um-menu-option', Lang::get('security/user-management.menuOption'), array('class' => 'control-label')) !!}
						    {!! Form::autocomplete('um-menu-option-label', null, array('class' => 'form-control'), 'um-menu-option-label', 'um-menu-option') !!}
						    {!! Form::hidden('um-menu-option', null, array('id' => 'um-menu-option')) !!}
					  	</div>
					</div>
					<div class="um-multiselect clearfix">
						{!! Form::select('um-user-permissions', array(), null, array('id' => 'um-user-permissions', 'multiple' => '', 'class' => 'um-multiselect app-multiselect')) !!}
					</div>
				</fieldset>
		  	{!! Form::close() !!}
		</div>
	</div>
	<div class="col-lg-6 section-block">
		{!! Form::open(array('id' => 'um-menu-options-form','url' => '', 'role' => 'form', 'onsubmit' => 'return false;')) !!}
			<fieldset id="um-menu-options-form-fieldset" disabled="disabled">
				<div class="section-header">
					<legend>
						{{ Lang::get('security/user-management.menuOptionsTitles') }}
						{!! Form::button('<i class="fa fa-undo"></i>',array('id' => 'um-btn-reset', 'class' => 'btn btn-default um-btn-tooltip pull-right', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'data-original-title' => Lang::get('security/user-management.reset'))) !!}
					</legend>
			  		<div class="form-group clearfix">
						{!! Form::label('um-menu-options-module-label', Lang::get('security/user-management.module'), array('class' => 'control-label')) !!}
						{!! Form::autocomplete('um-menu-options-module-label', $modules, array('class' => 'form-control'), 'um-menu-options-module-label', 'um-menu-options-module') !!}
						{!! Form::hidden('um-menu-options-module', null, array('id' => 'um-menu-options-module')) !!}
				  	</div>
				</div>
				<div class="um-apps-multiselect clearfix">
					{!! Form::select('um-user-menus', array(), null, array('id' => 'um-user-menus', 'class' => 'multiselect', 'multiple' => '', 'class' => 'um-apps-multiselect app-multiselect')) !!}
				</div>
			</fieldset>
	  	{!! Form::close() !!}
	</div>
</div>
<div id='um-journal-section' class="row collapse in section-block">
	{!! Form::journals('um-', $appInfo['id']) !!}
</div>
<div id='um-form-section' class="row collapse">
	<div class="col-lg-12 col-md-12">
		<div id="um-new-admin-info-message" class="alert alert-block alert-info alert-custom hidden">
			<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
			 {{ Lang::get('security/user-management.formNewAdminInfoMessage') }}
		</div>
		<div class="form-container">
			{!! Form::open(array('id' => 'um-users-form', 'url' => URL::to('general-setup/security/user-management'), 'role' => 'form', 'onsubmit' => 'return false;')) !!}
				<fieldset id="um-users-form-fieldset">
					<legend id="um-form-new-admin-title" class="hidden">{{ Lang::get('security/user-management.formNewAdminTitle') }}</legend>
					<legend id="um-form-new-title" class="hidden">{{ Lang::get('security/user-management.formNewTitle') }}</legend>
					<legend id="um-form-edit-title" class="hidden">{{ Lang::get('security/user-management.formEditTitle') }}</legend>
					<div class="row">
						<div class="col-lg-6 col-md-6">
							<div class="form-group mg-hm">
								{!! Form::label('um-email', Lang::get('security/user-management.email'), array('class' => 'control-label')) !!}
									<div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-envelope-o"></i>
										</span>
						    		{!! Form::text('um-email', null , array('id' => 'um-email', 'class' => 'form-control', 'data-mg-required' => '')) !!}
						    		{!! Form::hidden('um-id', null, array('id' => 'um-id')) !!}
							    	{!! Form::hidden('um-is-admin', null, array('id' => 'um-is-admin')) !!}
						    	</div>
				  		</div>
							<div class="form-group mg-hm">
								{!! Form::label('um-firstname', Lang::get('security/user-management.firstname'), array('class' => 'control-label')) !!}
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-user"></i>
									</span>
						    		{!! Form::text('um-firstname', null, array('id' => 'um-firstname', 'class' => 'form-control', 'data-mg-required' => '')) !!}
						    	</div>
						  	</div>
						  	<div class="form-group mg-hm">
								{!! Form::label('um-lastname', Lang::get('security/user-management.lastname'), array('class' => 'control-label')) !!}
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-user"></i>
									</span>
						    		{!! Form::text('um-lastname', null, array('id' => 'um-lastname', 'class' => 'form-control', 'data-mg-required' => '')) !!}
						    	</div>
						  	</div>
						  	<div class="form-group mg-hm">
								{!! Form::label('um-timezone', Lang::get('security/user-management.timezone'), array('class' => 'control-label')) !!}
								{!! Form::autocomplete('um-timezone', $timezones, array('class' => 'form-control', 'data-mg-required' => ''), null, null, null, 'fa fa-clock-o') !!}
						  	</div>
						</div>
						<div class="col-lg-6 col-md-6">
							<div class="form-group">
							  	<div class="form-checkbox-inline">
								    <label id='um-is-active-label' class="control-label checkbox-inline hidden">
								      {!! Form::checkbox('um-is-active', 'S', true, array('id' => 'um-is-active')) !!} {{ Lang::get('security/user-management.isActive') }}
										</label>
										<label id='um-send-email-label' class="control-label checkbox-inline hidden">
									  	{!! Form::checkbox('um-send-email', 'S', true, array('id' => 'um-send-email')) !!} {{ Lang::get('security/user-management.sendEmail') }}
										</label>
								</div>
							</div>
						  	<div class="form-group mg-hm">
								{!! Form::label('um-password', Lang::get('security/user-management.password'), array('class' => 'control-label')) !!}
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-key"></i>
									</span>
						    		{!! Form::password('um-password', array('id' => 'um-password', 'class' => 'form-control', 'disabled' => '')) !!}
						    	</div>
							    <p id="um-form-edit-password-help-block" class="help-block hidden">{{ Lang::get('security/user-management.formEditpasswordHelperText') }}</p>
						  	</div>
						  	<div class="form-group">
								{!! Form::label('um-confirm-password', Lang::get('security/user-management.confirmPassword'), array('class' => 'control-label')) !!}
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-key"></i>
									</span>
						    		{!! Form::password('um-confirm-password', array('id' => 'um-confirm-password', 'class' => 'form-control', 'disabled' => '')) !!}
						    	</div>
						  	</div>
						</div>
					</div>
				</fieldset>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@parent
@stop
