@extends('layouts.base')

@section('container')
{!! Html::style('assets/kwaai/css/organization/organization-management.css') !!}
{!! Html::script('assets/kwaai/js/organization/organization-management.js') !!}
{!! Form::hidden('om-new-organization-action', $newOrganizationAction, array('id' => 'om-new-organization-action')) !!}
{!! Form::hidden('om-edit-organization-action', $editOrganizationAction, array('id' => 'om-edit-organization-action')) !!}
{!! Form::hidden('om-remove-organization-action', $removeOrganizationAction, array('id' => 'om-remove-organization-action')) !!}
{!! Form::hidden('om-show-welcome-message', $showWelcomeMessage, array('id' => 'om-show-welcome-message')) !!}
{!! Form::button('', array('id' => 'om-btn-edit-helper', 'class' => 'hidden', 'data-content' => Lang::get('organization/organization-management.editHelpText'))) !!}
{!! Form::button('', array('id' => 'om-btn-remove-helper', 'class' => 'hidden', 'data-content' => Lang::get('organization/organization-management.deleteHelpText'))) !!}
<div class="row">
	<div class="col-lg-12 col-md-12">
		<div id="om-btn-toolbar" class="section-header btn-toolbar" role="toolbar">
			<div id="om-btn-group-1" class="btn-group btn-group-app-toolbar">
				{!! Form::button('<i class="fa fa-plus"></i> ' . Lang::get('toolbar.new'), array('id' => 'om-btn-new', 'class' => 'btn btn-default om-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'data-original-title' => Lang::get('organization/organization-management.new'))) !!}
				{!! Form::button('<i class="fa fa-refresh"></i> ' . Lang::get('toolbar.refresh'), array('id' => 'om-btn-refresh', 'class' => 'btn btn-default om-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'data-original-title' => Lang::get('toolbar.refreshLongText'))) !!}
				<div class="btn-group">
					{!! Form::button('<i class="fa fa-share-square-o"></i> ' . Lang::get('toolbar.export') . ' <span class="caret"></span>', array('class' => 'btn btn-default dropdown-toggle', 'data-container' => 'body', 'data-toggle' => 'dropdown')) !!}
					<ul class="dropdown-menu">
         		<li><a id='om-btn-export-xls' class="fake-link"><i class="fa fa-file-excel-o"></i> xls</a></li>
         		<li><a id='om-btn-export-csv' class="fake-link"><i class="fa fa-file-text-o"></i> csv</a></li>
       		</ul>
				</div>
			</div>
			<div id="om-btn-group-2" class="btn-group btn-group-app-toolbar">
				{!! Form::button('<i class="fa fa-edit"></i> ' . Lang::get('toolbar.edit'), array('id' => 'om-btn-edit', 'class' => 'btn btn-default om-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'disabled' => '', 'data-original-title' => Lang::get('organization/organization-management.edit'))) !!}
				{!! Form::button('<i class="fa fa-minus"></i> ' . Lang::get('toolbar.remove'), array('id' => 'om-btn-delete', 'class' => 'btn btn-default om-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'disabled' => '', 'data-original-title' => Lang::get('organization/organization-management.delete'))) !!}
			</div>
			<div id="om-btn-group-3" class="btn-group btn-group-app-toolbar">
				{!! Form::button('<i class="fa fa-save"></i> ' . Lang::get('toolbar.save'), array('id' => 'om-btn-save', 'class' => 'btn btn-default om-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'disabled' => '', 'data-original-title' => Lang::get('organization/organization-management.save'))) !!}
				{!! Form::button('<i class="fa fa-undo"></i> ' . Lang::get('toolbar.close'), array('id' => 'om-btn-close', 'class' => 'btn btn-default om-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'disabled' => '', 'data-original-title' => Lang::get('toolbar.closeLongText'))) !!}
			</div>
		</div>
		@if ($showWelcomeMessage)
			<div id="om-organization-welcome-alert" class="alert alert-block alert-info alert-custom fade in">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				{{ Lang::get('organization/organization-management.welcomeMessage', array('user' => AuthManager::getLoggedUserFirstname(), 'systemName' => AppManager::getSystemName())) }}
			</div>
		@endif
		<div id='om-grid-section' class='app-grid collapse in' data-app-grid-id='organizations-grid'>
			{!!
			GridRender::setGridId("organizations-grid")
				->enablefilterToolbar(false, false)
				->hideXlsExporter()
  			->hideCsvExporter()
	    	->setGridOption('url',URL::to('general-setup/organization/organization-management/organization-grid-data'))
	    	->setGridOption('caption', Lang::get('organization/organization-management.gridTitle', array('user' => AuthManager::getLoggedUserFirstname())))
	    	->setGridOption('postData',array('_token' => Session::token()))
	    	->setGridEvent('onSelectRow', 'omOnSelectRowEvent')
	    	->addColumn(array('index' => 'o.id', 'name' => 'id', 'hidden' => true))
	    	->addColumn(array('label' => Lang::get('organization/organization-management.name'), 'index' => 'o.name' ,'name' => 'name'))
	    	->addColumn(array('label' => Lang::get('organization/organization-management.taxId'), 'index' => 'o.tax_id', 'name' => 'tax_id'))
	    	->addColumn(array('label' => Lang::get('organization/organization-management.companyRegistration'), 'index' => 'o.company_registration', 'name' => 'company_registration'))
	    	->addColumn(array('label' => Lang::get('organization/organization-management.country'), 'index' => 's.name', 'name' => 'country'))
	    	->addColumn(array('label' => Lang::get('organization/organization-management.databaseConnectionNameGridColumn'), 'index' => 'o.database_connection_name', 'name' => 'database_connection_name'))
	    	->addColumn(array('index' => 'o.street1', 'name' => 'street1', 'hidden' => true))
	    	->addColumn(array('index' => 'o.street2', 'name' => 'street2', 'hidden' => true))
	    	->addColumn(array('index' => 'o.zip_code', 'name' => 'zip_code', 'hidden' => true))
	    	->addColumn(array('index' => 'o.web_site', 'name' => 'web_site', 'hidden' => true))
	    	->addColumn(array('index' => 'o.phone_number', 'name' => 'phone_number', 'hidden' => true))
	    	->addColumn(array('index' => 'o.fax', 'name' => 'fax', 'hidden' => true))
	    	->addColumn(array('index' => 'o.email', 'name' => 'email', 'hidden' => true))
	    	->addColumn(array('index' => 'o.country_id', 'name' => 'country_id', 'hidden' => true))
	    	->addColumn(array('index' => 'o.city_name', 'name' => 'city_name', 'hidden' => true))
	    	->addColumn(array('index' => 'o.state_name', 'name' => 'state_name', 'hidden' => true))
				->addColumn(array('index' => 'o.currency_id', 'name' => 'currency_id', 'hidden' => true))
				->addColumn(array('index' => 'c.symbol', 'name' => 'symbol', 'hidden' => true))
				->addColumn(array('index' => 'c.name', 'name' => 'currency', 'hidden' => true))
	    	->addColumn(array('label' => Lang::get('organization/organization-management.emailCreatedBy'), 'index' => 'u.email', 'name' => 'user_email', 'hidden' => $hideCreatedByColumn))
	    	->renderGrid();
			!!}
		</div>
	</div>
</div>
<div id='om-admin-section' class="row collapse in section-block">
	{!! Form::journals('om-', $appInfo['id'], true, '', '', '', null, null, false) !!}
</div>
<div id='om-form-section' class="row collapse">
	<div class="col-lg-12 col-md-12">
		<div class="form-container">
			{!! Form::open(array('id' => 'om-organization-form', 'url' => URL::to('general-setup/organization/organization-management'), 'role'  =>  'form', 'onsubmit' => 'return false;')) !!}
				<legend id="om-form-new-title" class="hidden">{{ Lang::get('organization/organization-management.formNewTitle') }}</legend>
				<legend id="om-form-edit-title" class="hidden">{{ Lang::get('organization/organization-management.formEditTitle') }}</legend>
				<div class="row">
					<div class="col-lg-6 col-md-6">
						<div class="form-group mg-hm">
							{!! Form::label('om-name', Lang::get('organization/organization-management.name'), array('class' => 'control-label')) !!}
					    {!! Form::text('om-name', null , array('id' => 'om-name', 'class' => 'form-control', 'data-mg-required' => '')) !!}
					    {!! Form::hidden('om-id', null, array('id' => 'om-id')) !!}
			  		</div>
			  		<div class="form-group mg-hm clearfix">
							{!! Form::label('om-country', Lang::get('organization/organization-management.country'), array('class' => 'control-label')) !!}
							{!! Form::autocomplete('om-country', $countries, array('class' => 'form-control', 'data-mg-required' => ''), 'om-country', 'om-country-id', null, 'fa-globe') !!}
							{!! Form::hidden('om-country-id', null, array('id'  =>  'om-country-id')) !!}
			  		</div>
						<div class="form-group mg-hm clearfix">
							{!! Form::label('om-currency', Lang::get('organization/organization-management.currency'), array('class' => 'control-label')) !!}
							{!! Form::autocomplete('om-currency', $currencies, array('class' => 'form-control', 'data-mg-required' => ''), 'om-currency', 'om-currency-id', null, 'fa-money') !!}
							{!! Form::hidden('om-currency-id', null, array('id'  =>  'om-currency-id')) !!}
							<p class="help-block">{{ Lang::get('organization/organization-management.currencyHelperText') }}</p>
						</div>
			  		<div class="form-group mg-hm">
							{!! Form::label('om-email', Lang::get('security/user-management.email'), array('class' => 'control-label')) !!}
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-envelope-o"></i>
								</span>
					    	{!! Form::text('om-email', null , array('id' => 'om-email', 'class' => 'form-control', 'placeholder'  =>  Lang::get('organization/organization-management.emailPlaceHolder'))) !!}
					    </div>
			  		</div>
			  		<div class="form-group mg-hm">
						{!! Form::label('om-web-site', Lang::get('organization/organization-management.webSite'), array('class' => 'control-label')) !!}
					    {!! Form::text('om-web-site', null , array('id' => 'om-web-site', 'class' => 'form-control', 'placeholder'  =>  Lang::get('organization/organization-management.webSitePlaceHolder'))) !!}
			  		</div>
			  		<div class="form-group mg-hm">
							{!! Form::label('om-street1', Lang::get('organization/organization-management.address'), array('class' => 'control-label')) !!}
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-road"></i>
								</span>
					    	{!! Form::text('om-street1', null , array('id' => 'om-street1', 'class' => 'form-control', 'placeholder'  =>  Lang::get('organization/organization-management.street1PlaceHolder'))) !!}
					    </div>
					    <div class="input-group stacked-form-element">
							<span class="input-group-addon">
								<i class="fa fa-road"></i>
							</span>
					    	{!! Form::text('om-street2', null , array('id' => 'om-street2', 'class' => 'form-control', 'placeholder'  =>  Lang::get('organization/organization-management.street2PlaceHolder'))) !!}
					    </div>
					    <div class="input-group stacked-form-element">
					      <span class="input-group-addon"></span>
						  	{!! Form::text('om-city-name', null , array('id' => 'om-city-name', 'class' => 'form-control', 'placeholder'  =>  Lang::get('organization/organization-management.cityNamePlaceHolder'))) !!}
						  	<span class="input-group-addon"></span>
						  	{!! Form::text('om-state-name', null , array('id' => 'om-state-name', 'class' => 'form-control', 'placeholder'  =>  Lang::get('organization/organization-management.stateNamePlaceHolder'))) !!}
						  	<span class="input-group-addon"></span>
						  	{!! Form::text('om-zip-code', null , array('id' => 'om-zip-code', 'class' => 'form-control', 'placeholder'  =>  Lang::get('organization/organization-management.zipCodePlaceHolder'))) !!}
							</div>
			  		</div>
					</div>
					<div class="col-lg-6 col-md-6">
						<div class="form-group mg-hm">
							{!! Form::label('om-phone-number', Lang::get('organization/organization-management.phoneNumber'), array('class' => 'control-label')) !!}
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-phone"></i>
								</span>
						    	{!! Form::text('om-phone-number', null , array('id' => 'om-phone-number', 'class' => 'form-control')) !!}
						    </div>
				  		</div>
				  		<div class="form-group mg-hm">
								{!! Form::label('om-fax', Lang::get('organization/organization-management.fax'), array('class' => 'control-label')) !!}
						    {!! Form::text('om-fax', null , array('id' => 'om-fax', 'class' => 'form-control')) !!}
				  		</div>
				  		<div class="form-group mg-hm">
								{!! Form::label('om-tax-id', Lang::get('organization/organization-management.taxId'), array('class' => 'control-label')) !!}
						    {!! Form::text('om-tax-id', null , array('id' => 'om-tax-id', 'class' => 'form-control')) !!}
				  		</div>
				  		<div class="form-group mg-hm">
								{!! Form::label('om-company-registration', Lang::get('organization/organization-management.companyRegistration'), array('class' => 'control-label')) !!}
						    {!! Form::text('om-company-registration', null , array('id' => 'om-company-registration', 'class' => 'form-control')) !!}
				  		</div>
				  		<div id="om-database-form-group" class="form-group checkbox">
								<label class="control-label">
									{!! Form::checkbox('om-database', 'S', false, array('id' => 'om-database', 'disabled' => 'disabled')) !!}
							    {{ Lang::get('organization/organization-management.database') }}
						  	</label>
						  	<p id="om-form-add-database-help-block" class="help-block hidden">{{ Lang::get('organization/organization-management.databaseHelperText') }}</p>
							</div>
							<div id="om-database-connection-name-form-group" class="form-group mg-hm">
								{!! Form::label('om-database-connection-name', Lang::get('organization/organization-management.databaseConnectionName'), array('class' => 'control-label')) !!}
						    {!! Form::text('om-database-connection-name', 'default' , array('id' => 'om-database-connection-name', 'class' => 'form-control', 'disabled' => 'disabled', 'data-mg-required' => '')) !!}
						    <p id="om-form-add-database-connection-name-help-block" class="help-block hidden">{{ Lang::get('organization/organization-management.databaseConnectionNameHelperText') }}</p>
				  		</div>
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
<div id='om-modal-delete' class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm om-btn-delete">
    <div class="modal-content">
			<div class="modal-body" style="padding: 20px 20px 0px 20px;">
				<p id="om-delete-message" data-default-label="{{ Lang::get('organization/organization-management.confirmDeleteMessage') }}"></p>
      </div>
			<div class="modal-footer" style="text-align:center;">
				<button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('form.no') }}</button>
				<button id="om-btn-modal-delete" type="button" class="btn btn-primary">{{ Lang::get('form.yes') }}</button>
			</div>
    </div>
  </div>
</div>
@parent
@stop
