@extends('layouts.base')

@section('container')
{!! Html::script('assets/kwaai/js/initial-setup.js') !!}
<div class="row">
	<div class="col-lg-12">
		<div id="info-message" class="alert alert-block alert-info">
			<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
			 {{ Lang::get('initial-setup.rootInfoMessage') }}
		</div>
		<div class="form-container form-container-custom">
			{!! Form::open(array('id' => 'initial-setup-form', 'url' => URL::to('general-setup/security/user-management'), 'role' => 'form', 'onsubmit' => 'return false;')) !!}
				<fieldset id="form-fieldset">
					<legend>{{ Lang::get('initial-setup.formTitle') }}</legend>
					<div class="row">
						<div class="col-lg-6 col-md-6">
							<div class="form-group">
								{!! Form::label('email', Lang::get('security/user-management.email'), array('class' => 'control-label')) !!}
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-envelope-o"></i>
									</span>
						    		{!! Form::text('email', null , array('id' => 'email', 'class' => 'form-control', 'data-mg-required' => '')) !!}
						    		{!! Form::hidden('id', AuthManager::getLoggedUserId(), array('id' => 'id')) !!}
						    	</div>
					  		</div>
							<div class="form-group">
								{!! Form::label('firstname', Lang::get('security/user-management.firstname'), array('class' => 'control-label')) !!}
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-user"></i>
									</span>
						    		{!! Form::text('firstname', null, array('id' => 'firstname', 'class' => 'form-control', 'data-mg-required' => '')) !!}
						    	</div>
						  	</div>
						  	<div class="form-group">
								{!! Form::label('lastname', Lang::get('security/user-management.lastname'), array('class' => 'control-label')) !!}
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-user"></i>
									</span>
						    		{!! Form::text('lastname', null, array('id' => 'lastname', 'class' => 'form-control', 'data-mg-required' => '')) !!}
						    	</div>
						  	</div>
						</div>
						<div class="col-lg-6 col-md-6">
							<div class="form-group">
								{!! Form::label('timezone', Lang::get('security/user-management.timezone'), array('class' => 'control-label')) !!}
								{!! Form::autocomplete('timezone', $timezones, array('class' => 'form-control', 'data-mg-required' => ''), null, null, null, 'fa fa-clock-o') !!}
						  	</div>
						  	<div class="form-group">
								{!! Form::label('password', Lang::get('security/user-management.password'), array('class' => 'control-label')) !!}
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-key"></i>
									</span>
						    		{!! Form::password('password', array('id' => 'password', 'class' => 'form-control', 'data-mg-required' => '')) !!}
						    	</div>
						  	</div>
						  	<div class="form-group">
								{!! Form::label('confirm-password', Lang::get('security/user-management.confirmPassword'), array('class' => 'control-label')) !!}
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-key"></i>
									</span>
						    		{!! Form::password('confirm-password', array('id' => 'confirm-password', 'class' => 'form-control', 'data-mg-required' => '')) !!}
						    	</div>
							    <p id="form-new-password-help-block" class="help-block hidden">{{ Lang::get('security/user-management.formNewpasswordHelperText') }}</p>
							    <p id="form-edit-password-help-block" class="help-block hidden">{{ Lang::get('security/user-management.formEditpasswordHelperText') }}</p>
						  	</div>
						</div>
					</div>
					{!! Form::button('<i class="fa fa-save"></i> ' . Lang::get('initial-setup.update'), array('id' => 'btn-update', 'class' => 'btn btn-default btn-lg pull-right')) !!}
				</fieldset>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@parent
@stop
