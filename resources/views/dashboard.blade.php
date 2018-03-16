@extends('layouts.base')

@section('container')
{!! Html::script('assets/kwaai/js/dashboard.js') !!}
<div class="row">
	{!! Form::journals('da-', $appInfo['id'], true, '', '', true, Lang::get('dashboard.journalLegend'), $organizationJournals) !!}
</div>
@parent
@stop
