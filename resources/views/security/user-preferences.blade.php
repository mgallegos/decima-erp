@extends('layouts.base')

@section('container')
{!! Html::script('assets/kwaai/js/user-preferences.js') !!}
<div class="row">
	<fieldset id="form-fieldset">
		<div class="col-lg-6 col-md-6">
			<div id="form-container" class="form-container form-container-custom clearfix">
				{!! Form::open(array('id' => 'up-user-form', 'url' => URL::to('general-setup/security/user-management/update-user'), 'role' => 'form', 'onsubmit' => 'return false;')) !!}
					<legend>{{ Lang::get('user-preferences.formTitle') }}</legend>
					<div class="form-group mg-hm">
						{!! Form::label('up-email', Lang::get('security/user-management.email'), array('class' => 'control-label')) !!}
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-envelope-o"></i>
							</span>
							{!! Form::text('up-email', AuthManager::getLoggedUserEmail(), array('id' => 'up-email', 'class' => 'form-control', 'data-mg-required' => '')) !!}
						</div>
					</div>
					<div class="form-group mg-hm">
						{!! Form::label('up-firstname', Lang::get('security/user-management.firstname'), array('class' => 'control-label')) !!}
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-user"></i>
							</span>
							{!! Form::text('up-firstname', AuthManager::getLoggedUserFirstname(), array('id' => 'up-firstname', 'class' => 'form-control', 'data-mg-required' => '')) !!}
						</div>
					</div>
					<div class="form-group mg-hm">
						{!! Form::label('up-lastname', Lang::get('security/user-management.lastname'), array('class' => 'control-label')) !!}
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-user"></i>
							</span>
							{!! Form::text('up-lastname', AuthManager::getLoggedUserLastname(), array('id' => 'up-lastname', 'class' => 'form-control', 'data-mg-required' => '')) !!}
						</div>
					</div>
					<div class="form-group mg-hm">
						{!! Form::label('up-timezone', Lang::get('security/user-management.timezone'), array('class' => 'control-label')) !!}
						{!! Form::autocomplete('up-timezone', UserManager::getTimezones(), array('class' => 'form-control', 'data-mg-required' => ''), null, null, AuthManager::getLoggedUserTimeZone(), 'fa fa-clock-o') !!}
					</div>
					<div class="form-group mg-hm clearfix">
						{!! Form::label('up-organizacion-name', Lang::get('security/user-management.defaultOrganization'), array('class' => 'control-label')) !!}
						{!! Form::autocomplete('up-organizacion-name', UserManager::getUserOrganizationsAutocomplete(), array('class' => 'form-control', 'data-mg-required' => ''), 'up-organizacion-name', 'up-default-organization', $userDefaultOrganizationName, 'fa-building-o') !!}
						{!! Form::hidden('up-default-organization', AuthManager::getLoggedUserDefaultOrganization(), array('id'  =>  'up-default-organization')) !!}
						<p class="help-block">{{ Lang::get('security/user-management.defaultOrganizationHelpText') }}</p>
					</div>
					<div class="form-group mg-hm">
						{!! Form::label('up-password', Lang::get('security/user-management.password'), array('class' => 'control-label')) !!}
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-key"></i>
							</span>
							{!! Form::password('up-password', array('id' => 'up-password', 'class' => 'form-control')) !!}
						</div>
						<p class="help-block">{{ Lang::get('security/user-management.formEditpasswordHelperText') }}</p>
					</div>
					<div class="form-group">
						{!! Form::label('up-confirm-password', Lang::get('security/user-management.confirmPassword'), array('class' => 'control-label')) !!}
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-key"></i>
							</span>
							{!! Form::password('up-confirm-password', array('id' => 'up-confirm-password', 'class' => 'form-control')) !!}
						</div>
					</div>
					{!! Form::button('<i class="fa fa-save"></i> ' . Lang::get('initial-setup.update'), array('id' => 'up-btn-update', 'class' => 'btn btn-default btn-lg pull-right')) !!}
				{!! Form::close() !!}
			</div>
		</div>
		<div class="col-lg-6 col-md-6">
			<div class="row">
				{!! Form::journals('up-c-', 'user-preferences-changes', false, '', AuthManager::getLoggedUserId(), false, Lang::get('user-preferences.userChangesJournalLegend'), $changesJournal) !!}
			</div>
			<div class="row section-block">
				{!! Form::journals('up-a-', 'user-preferences-actions', false, AuthManager::getLoggedUserId(), '', true, Lang::get('user-preferences.userActionsJournalLegend'), $actionsJournal) !!}
			</div>
		</div>
	</fieldset>
</div>
@parent
@stop
