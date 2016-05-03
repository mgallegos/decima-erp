@extends('layouts.stand-alone')

@section('container')
	{!! Html::script('assets/kwaai/js/security/activate-user.js') !!}
	<div class="col-md-4 col-md-offset-4">
		<div class="stand-alone-box clearfix">
			<legend class="text-center">{{ Lang::get('security/user-activation.formTitle') }}</legend>
			{!! Form::open(array('id'=>'activate-user-form', 'role' => 'form', 'url' => URL::action('Security\Reminder@postActivate'))) !!}
				@if ($error)
					<div class="alert alert-block alert-info text-center">
						<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
						 {{ $error }}
					</div>
				@endif
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon">
							<i class="fa fa-envelope-o"></i>
						</span>
			    		{!! Form::text('email', null, array('id'=>'email', 'class'=>'form-control', 'data-mg-required'=>'', 'placeholder' => Lang::get('security/reminders.emailPlaceHolder'))) !!}
			    		{!! Form::hidden('token', $token) !!}
			    	</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon">
							<i class="fa fa-key"></i>
						</span>
			    		{!! Form::password('password', array('id'=>'password', 'class'=>'form-control', 'data-mg-required'=>'', 'placeholder' => Lang::get('security/reminders.passwordPlaceHolder'))) !!}
			    	</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon">
							<i class="fa fa-key"></i>
						</span>
			    		{!! Form::password('password_confirmation', array('id'=>'password-confirm', 'class'=>'form-control', 'data-mg-required'=>'', 'placeholder' => Lang::get('security/reminders.confirmPasswordPlaceHolder'))) !!}
			    	</div>
				</div>
				{!! Form::button('<i class="fa fa-check-circle-o"></i> ' . Lang::get('security/user-activation.activateButton'), array('id'=>'btn-activate', 'class'=>'btn btn-default center-block', 'onclick' => '$( "#activate-user-form" ).submit();')) !!}
				{!! Honeypot::generate('kwaai_name', 'kwaai_time') !!}
				{!! Form::close() !!}
		</div>
    </div>
@stop
