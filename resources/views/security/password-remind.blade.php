@extends('layouts.stand-alone')

@section('container')
	{{-- http://laravel.com/docs/security http://code.tutsplus.com/tutorials/sending-emails-with-laravel-4-gmail--net-36105 --}}
	<div class="col-md-4 col-md-offset-4">
		<div class="stand-alone-box clearfix">
			<legend class="text-center">{{ Lang::get('security/reminders.formTitle') }}</legend>
			{!! Form::open(array('id'=>'reminder-form', 'role' => 'form', 'url' => URL::action('Security\Reminder@postRemind'))) !!}
				@if ($status)
					<div class="alert alert-block alert-success text-center">
						<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
						 {!! $status !!}
					</div>
				@endif
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
			    	</div>
				</div>
				{!! Form::button('<i class="fa fa-envelope"></i> ' . Lang::get('security/reminders.sendButton'), array('id'=>'btn-send', 'class'=>'btn btn-default center-block', 'onclick' => '$( "#reminder-form" ).submit();')) !!}
				{!! Honeypot::generate('kwaai_name', 'kwaai_time') !!}
			{!! Form::close() !!}
		</div>
    </div>
@stop
