@extends('layouts.base')

@section('container')
{!! Html::script('assets/kwaai/js/dashboard.js') !!}
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<div class="alert alert-info" role="alert"> <strong>Nuevo menú!</strong> Haz clic el icono <i class="fa fa-bars core-menu-top-bar-link-color"></i> ubicado en el esquina superior derecha de la pantalla para acceder al menú del sistema.</div>
	</div>
</div>
@parent
@stop
