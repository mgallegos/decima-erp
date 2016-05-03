@extends('layouts.base')

@section('container')
{!! Html::script('assets/kwaai/js/dashboard.js') !!}
{!! Form::hidden('da-logged-user-popover-shown', AuthManager::getLoggedUserPopoversShown(), array('id' => 'da-logged-user-popover-shown')) !!}
{!! Form::hidden('da-logged-user-multiple-organization-popover-shown', AuthManager::getLoggedUserMultipleOrganizacionPopoversShown(), array('id' => 'da-logged-user-multiple-organization-popover-shown')) !!}
<div class="row">
	{!! Form::journals('da-', $appInfo['id'], true, '', '', true, Lang::get('dashboard.journalLegend'), $organizationJournals) !!}
</div>
@parent
@stop
