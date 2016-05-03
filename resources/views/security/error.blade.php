@extends('layouts.stand-alone')

@section('container')
	<div class="col-md-4 col-md-offset-4">
		<div class="stand-alone-box clearfix">
			<legend class="stand-alone-box-legend text-center">{{ AppManager::getSystemName() }}</legend>
			<div class="alert alert-block alert-warning">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				{{ $error }}
			</div>
		</div>
    </div>
@stop
