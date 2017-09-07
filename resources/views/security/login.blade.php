@extends('layouts.stand-alone')

@section('container')
	{!! Html::script('assets/kwaai/js/security/login.js') !!}
	<div class="col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3">
		<div class="stand-alone-box clearfix">
			<legend class="stand-alone-box-legend text-center"><i class="fa fa-lock"></i></i> {{ Lang::get('security/login.loginFormLegend') }}</legend>
			{!! Form::open(array('id'=>'login-form', 'role' => 'form', 'onsubmit'=>'return false;', 'url'=>URL::to('login/authentication-attempt'))) !!}
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon">
							<i class="fa fa-envelope-o"></i>
						</span>
						{{-- Config::get('system-security.root_default_email') --}}
		    		{!! Form::text('email', null, array('id'=>'email', 'class'=>'form-control', 'data-mg-required'=>'', 'placeholder' => Lang::get('security/user-management.email'))) !!}
			    	</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon">
							<i class="fa fa-key"></i>
						</span>
						{!! Form::password('password', array('id'=>'password', 'class'=>'form-control', 'data-mg-required'=>'', 'placeholder' => Lang::get('security/user-management.password'))) !!}
			    	</div>
				</div>
				<div class="form-group checkbox">
					<label class="control-label">
						{!! Form::checkbox('rememberMe', '1', false) !!}
						{{ Lang::get('security/login.rememberMe') }}
					</label>
					{!! Html::link(URL::to('password-reminder'), Lang::get('security/login.forgottenPassword'), ['id'=>'forgotten-password', 'class' => 'pull-right']) !!}
				</div>
				{!! Form::button('<i class="fa fa-key"></i> ' . Lang::get('security/login.loginButton'), array('id'=>'btn-login', 'class'=>'btn btn-default center-block')) !!}
				{!! Honeypot::generate('kwaai-name', 'kwaai-time') !!}
				{!! Form::close() !!}
		</div>
    </div>
@stop
