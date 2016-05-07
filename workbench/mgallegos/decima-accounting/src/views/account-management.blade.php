@extends('layouts.base')

@section('container')
{!! Html::style('assets/jstree-v3.2.1/dist/themes/default/style.min.css') !!}
{!! Html::script('assets/jstree-v3.2.1/dist/jstree.min.js') !!}
{!! Form::hidden('acct-am-new-action', $newAccountAction, array('id' => 'acct-am-new-action')) !!}
{!! Form::hidden('acct-am-edit-action', $editAccountAction, array('id' => 'acct-am-edit-action', 'data-content' => Lang::get('decima-accounting::account-management.editHelpText'))) !!}
{!! Form::hidden('acct-am-delete-action', $deleteAccountAction, array('id' => 'acct-am-delete-action', 'data-content' => Lang::get('decima-accounting::account-management.deleteHelpText'))) !!}
{!! Form::button('', array('id' => 'acct-am-btn-edit-helper', 'class' => 'hidden')) !!}
{!! Form::button('', array('id' => 'acct-am-btn-delete-helper', 'class' => 'hidden')) !!}
<style></style>

<script type='text/javascript'>

acctAmDefaultTreeData = [{"text" : "{{ Lang::get('decima-accounting::account-management.parentAccount') }}"}];

function acctAcOnSelectRowEvent()
{
	var id = $('#acct-am-grid').getSelectedRowId('acct_am_id');

	getAppJournals('acct-am-', 'firstPage', id);

	$('#acct-am-btn-group-2').enableButtonGroup();
}

function acctAmShowParentTree(parentId, loadAccountTypes)
{
	if($.trim(parentId) == '')
	{
		return;
	}

	loadAccountTypes = loadAccountTypes || false;

	$('#acct-am-tree').attr('data-account-id', parentId);

	$.ajax(
	{
		type: 'POST',
		data: JSON.stringify({'_token': $('#app-token').val(), 'id': parentId}),
		dataType : 'json',
		url:  $('#acct-am-form').attr('action') + '/account-children',
		error: function (jqXHR, textStatus, errorThrown)
		{
			handleServerExceptions(jqXHR, 'acct-am-btn-toolbar', false);
		},
		beforeSend:function()
		{
			$('#app-loader').removeClass('hidden');
			disabledAll();
		},
		success:function(json)
		{
			$('#acct-am-tree').jstree(true).settings.core.data = json.accountTree;
			$('#acct-am-tree').jstree(true).refresh();

			if(loadAccountTypes)
			{
				$('#acct-am-balance-type-name').val(json.balanceTypeName);
				$('#acct-am-balance-type').val(json.balanceTypeValue);
				$('#acct-am-account-type').val(json.accountTypeName);
				$('#acct-am-account-type-id').val(json.accountTypeValue);
				// console.log('entre yes!');
			}

			$('#app-loader').addClass('hidden');
			enableAll();
			$('#acct-am-key').focus();
		}
	});
}

$(document).ready(function()
{
	$('.acct-am-btn-tooltip').tooltip();

	$('#acct-am-form').jqMgVal('addFormFieldsValidations');

	$('#acct-am-tree').jstree({
	 'core' : { 'data' : acctAmDefaultTreeData}
	});

	$('#acct-am-grid-section').on('shown.bs.collapse', function ()
	{
		$('#acct-am-btn-refresh').click();
	});

	$('#acct-am-journals-section').on('hidden.bs.collapse', function ()
	{
		$('#acct-am-form-section').collapse('show');
	});

	$('#acct-am-form-section').on('shown.bs.collapse', function ()
	{
		$('#acct-am-parent-account').focus();
	});

	$('#acct-am-form-section').on('hidden.bs.collapse', function ()
	{
		$('#acct-am-grid-section').collapse('show');

		$('#acct-am-journals-section').collapse('show');
	});

	$('#acct-am-parent-account').on( 'autocompleteselect', function( event, ui )
	{
		if($('#acct-am-tree').attr('data-account-id') == ui.item.value)
		{
			return;
		}

		acctAmShowParentTree(ui.item.value, true);
	});

	$('#acct-am-btn-new').click(function()
	{
		if($(this).hasAttr('disabled'))
		{
			return;
		}

		$('#acct-am-btn-toolbar').disabledButtonGroup();
		$('#acct-am-btn-group-3').enableButtonGroup();
		$('#acct-am-form-new-title').removeClass('hidden');
		$('#acct-am-grid-section').collapse('hide');
		$('#acct-am-journals-section').collapse('hide');
		$('.acct-am-btn-tooltip').tooltip('hide');
	});

	$('#acct-am-btn-refresh').click(function()
	{
		$('.acct-am-btn-tooltip').tooltip('hide');
		$('#acct-am-grid').trigger('reloadGrid');
		cleanJournals('acct-am-');
		$('#acct-am-btn-toolbar').disabledButtonGroup();
		$('#acct-am-btn-group-1').enableButtonGroup();
	});

	$('#acct-am-btn-export-xls').click(function()
	{
			$('#acct-am-gridXlsButton').click();
	});

	$('#acct-am-btn-export-csv').click(function()
	{
			$('#acct-am-gridCsvButton').click();
	});

	$('#acct-am-btn-edit').click(function()
	{
		var rowData, rowId;

		rowId = $('#acct-am-grid').jqGrid('getGridParam', 'selrow');

		if(rowId == null)
		{
			$('#acct-am-btn-toolbar').showAlertAfterElement('alert-info alert-custom', lang.invalidSelection, 5000);
			return;
		}

		$('#acct-am-btn-toolbar').disabledButtonGroup();
		$('#acct-am-btn-group-3').enableButtonGroup();
		$('#acct-am-form-edit-title').removeClass('hidden');
		$('.acct-am-btn-tooltip').tooltip('hide');

		rowData = $('#acct-am-grid').getRowData(rowId);

		populateFormFields(rowData);
		acctAmShowParentTree(rowData.acct_am_parent_account_id);

		$('#acct-am-parent-account').val(rowData.acct_am_parent_key + ' ' + rowData.acct_am_parent_account);
		$('#acct-am-grid-section').collapse('hide');
		$('#acct-am-journals-section').collapse('hide');
	});

	$('#acct-am-btn-delete').click(function()
	{
		var rowData, rowId;

		if($(this).hasAttr('disabled'))
		{
			return;
		}

		rowId = $('#acct-am-grid').jqGrid('getGridParam', 'selrow');

		if(rowId == null)
		{
			$('#acct-am-btn-toolbar').showAlertAfterElement('alert-info alert-custom', lang.invalidSelection, 5000);
			return;
		}

		rowData = $('#acct-am-grid').getRowData(rowId);

		$('#acct-am-delete-message').html($('#acct-am-delete-message').attr('data-default-label').replace(':account', rowData.acct_am_key + ' ' + rowData.acct_am_name));

		$('.acct-am-btn-tooltip').tooltip('hide');

		$('#acct-am-modal-delete').modal('show');
	});

	$('#acct-am-btn-modal-delete').click(function()
	{
		var id = $('#acct-am-grid').getSelectedRowId('acct_am_id');

		$.ajax(
		{
			type: 'POST',
			data: JSON.stringify({'_token':$('#app-token').val(), 'id':id}),
			dataType : 'json',
			url:  $('#acct-am-form').attr('action') + '/delete',
			error: function (jqXHR, textStatus, errorThrown)
			{
				handleServerExceptions(jqXHR, 'acct-am-btn-toolbar', false);
			},
			beforeSend:function()
			{
				$('#app-loader').removeClass('hidden');
				disabledAll();
			},
			success:function(json)
			{
				if(json.success)
				{
					$('#acct-am-btn-refresh').click();
					$('#acct-am-btn-toolbar').showAlertAfterElement('alert-success alert-custom',json.success, 5000);
				}
				else if(json.info)
				{
					$('#acct-am-btn-toolbar').showAlertAfterElement('alert-info alert-custom',json.info, 8000);
				}

				$('#acct-am-modal-delete').modal('hide');
				$('#app-loader').addClass('hidden');
				enableAll();
			}
		});
	});

	$('#acct-am-btn-save').click(function()
	{
		var url = $('#acct-am-form').attr('action'), action = 'new';

		$('.acct-am-btn-tooltip').tooltip('hide');

		if(!$('#acct-am-form').jqMgVal('isFormValid'))
		{
			return;
		}

		if($('#acct-am-parent-account').isEmpty())
		{
			$('#acct-am-parent-account-id').val('');
		}

		if($('#acct-am-parent-account-id').val() == $('#acct-am-id').val() && !$('#acct-am-id').isEmpty())
		{
			$('#acct-am-form').showServerErrorsByField({'parent-account':$('#acct-am-parent-account').attr('data-invalid-parent-validation')}, 'acct-am-');

			return;
		}

		if($('#acct-am-id').isEmpty())
		{
			url = url + '/create';
		}
		else
		{
			url = url + '/update';
			action = 'edit';
		}

		$.ajax(
		{
			type: 'POST',
			data: JSON.stringify($('#acct-am-form').formToObject('acct-am-')),
			dataType : 'json',
			url: url,
			error: function (jqXHR, textStatus, errorThrown)
			{
				handleServerExceptions(jqXHR, 'acct-am-form');
			},
			beforeSend:function()
			{
				$('#app-loader').removeClass('hidden');
				disabledAll();
			},
			success:function(json)
			{
				if(json.success)
				{
					$('#acct-am-btn-close').click();
				}
				else if(json.info)
				{
					$('#acct-am-form').showAlertAsFirstChild('alert-info', json.info, 8000);
				}
				else if(json.validationFailed)
				{
					$('#acct-am-form').showServerErrorsByField(json.fieldValidationMessages, 'acct-am-');
				}

				if(json.groupsAccounts)
				{
					$('#acct-am-parent-account').autocomplete( "option", "source", json.groupsAccounts);
				}

				$('#app-loader').addClass('hidden');
				enableAll();
			}
		});
	});

	$('#acct-am-btn-close').click(function()
	{
		if($(this).hasAttr('disabled'))
		{
			return;
		}

		$('#acct-am-btn-group-1').enableButtonGroup();
		$('#acct-am-btn-group-3').disabledButtonGroup();
		$('#acct-am-form-new-title').addClass('hidden');
		$('#acct-am-form-edit-title').addClass('hidden');
		$('#acct-am-grid').jqGrid('clearGridData');
		$('#acct-am-form').jqMgVal('clearForm');
		$('#acct-am-tree').jstree(true).settings.core.data = acctAmDefaultTreeData;
		$('#acct-am-tree').jstree(true).refresh();
		$('#acct-am-tree').attr('data-account-id', 0);
		$('.acct-am-btn-tooltip').tooltip('hide');
		$('#acct-am-form-section').collapse('hide');
	});

	$('#acct-am-btn-edit-helper').click(function()
  {
		showButtonHelper('acct-am-btn-close', 'acct-am-btn-group-2', $('#acct-am-edit-action').attr('data-content'));
  });

	$('#acct-am-btn-delete-helper').click(function()
  {
		showButtonHelper('acct-am-btn-close', 'acct-am-btn-group-2', $('#acct-am-delete-action').attr('data-content'));
  });

	if(!$('#acct-am-new-action').isEmpty())
	{
		$('#acct-am-btn-new').click();
	}

	if(!$('#acct-am-edit-action').isEmpty())
	{
		showButtonHelper('acct-am-btn-close', 'acct-am-btn-group-2', $('#acct-am-edit-action').attr('data-content'));
	}

	if(!$('#acct-am-delete-action').isEmpty())
	{
		showButtonHelper('acct-am-btn-close', 'acct-am-btn-group-2', $('#acct-am-delete-action').attr('data-content'));
	}
});

</script>

<div class="row">
	<div class="col-lg-12 col-md-12">
		<div id="acct-am-btn-toolbar" class="section-header btn-toolbar" role="toolbar">
			<div id="acct-am-btn-group-1" class="btn-group btn-group-app-toolbar">
				{!! Form::button('<i class="fa fa-plus"></i> ' . Lang::get('toolbar.new'), array('id' => 'acct-am-btn-new', 'class' => 'btn btn-default acct-am-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'data-original-title' => Lang::get('decima-accounting::account-management.new'))) !!}
				{!! Form::button('<i class="fa fa-refresh"></i> ' . Lang::get('toolbar.refresh'), array('id' => 'acct-am-btn-refresh', 'class' => 'btn btn-default acct-am-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'data-original-title' => Lang::get('toolbar.refreshLongText'))) !!}
				<div class="btn-group">
					{!! Form::button('<i class="fa fa-share-square-o"></i> ' . Lang::get('toolbar.export') . ' <span class="caret"></span>', array('class' => 'btn btn-default dropdown-toggle', 'data-container' => 'body', 'data-toggle' => 'dropdown')) !!}
					<ul class="dropdown-menu">
         		<li><a id='acct-am-btn-export-xls' class="fake-link"><i class="fa fa-file-excel-o"></i> xls</a></li>
         		<li><a id='acct-am-btn-export-csv' class="fake-link"><i class="fa fa-file-text-o"></i> csv</a></li>
       		</ul>
				</div>
			</div>
			<div id="acct-am-btn-group-2" class="btn-group btn-group-app-toolbar">
				{!! Form::button('<i class="fa fa-edit"></i> ' . Lang::get('toolbar.edit'), array('id' => 'acct-am-btn-edit', 'class' => 'btn btn-default acct-am-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'disabled' => '', 'data-original-title' => Lang::get('decima-accounting::account-management.edit'))) !!}
				{!! Form::button('<i class="fa fa-minus"></i> ' . Lang::get('toolbar.delete'), array('id' => 'acct-am-btn-delete', 'class' => 'btn btn-default acct-am-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'disabled' => '', 'data-original-title' => Lang::get('decima-accounting::account-management.delete'))) !!}
			</div>
			<div id="acct-am-btn-group-3" class="btn-group btn-group-app-toolbar">
				{!! Form::button('<i class="fa fa-save"></i> ' . Lang::get('toolbar.save'), array('id' => 'acct-am-btn-save', 'class' => 'btn btn-default acct-am-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'disabled' => '', 'data-original-title' => Lang::get('decima-accounting::account-management.save'))) !!}
				{!! Form::button('<i class="fa fa-undo"></i> ' . Lang::get('toolbar.close'), array('id' => 'acct-am-btn-close', 'class' => 'btn btn-default acct-am-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'disabled' => '', 'data-original-title' => Lang::get('toolbar.closeLongText'))) !!}
			</div>
		</div>
		<div id='acct-am-grid-section' class='app-grid collapse in' data-app-grid-id='acct-am-grid'>
			{!!
			GridRender::setGridId("acct-am-grid")
				//->enablefilterToolbar(false, false)
				->hideXlsExporter()
  			->hideCsvExporter()
				->setGridOption('height', 'auto')
				->setGridOption('multiselect', false)
				->setGridOption('rowList', array(100, 250, 500, 750, 1000, 2000))
				->setGridOption('rowNum', 1000)
	    	->setGridOption('url', URL::to('accounting/setup/accounts-management/account-grid-data'))
	    	->setGridOption('caption', Lang::get('decima-accounting::account-management.gridTitle'))
				->setGridOption('postData',array('_token' => Session::token()))
				->setGridOption('treeGrid', true)
				->setGridOption('ExpandColumn', 'acct_am_key')
				->setGridOption('treeReader', array('parent_id_field' => 'acct_am_parent_account_id', 'leaf_field' => 'acct_am_is_leaf'))
				->setGridEvent('onSelectRow', 'acctAcOnSelectRowEvent')
	    	->addColumn(array('index' => 'a.id', 'name' => 'acct_am_id', 'hidden' => true, 'key' => true))
	    	->addColumn(array('index' => 'at.id', 'name' => 'acct_am_account_type_id', 'hidden' => true))
	    	->addColumn(array('index' => 'ap.id', 'name' => 'acct_am_parent_account_id', 'hidden' => true))
				->addColumn(array('index' => 'ap.key', 'name' => 'acct_am_parent_key', 'hidden' => true))
				->addColumn(array('index' => 'ap.name', 'name' => 'acct_am_parent_account', 'hidden' => true))
				->addColumn(array('index' => 'acct_am_balance_type_name', 'hidden' => true))
				->addColumn(array('index' => 'acct_am_is_leaf', 'hidden' => true))
	    	->addColumn(array('label' => Lang::get('decima-accounting::account-management.key'), 'index' => 'a.key', 'name' => 'acct_am_key', 'width' => 125))
	    	->addColumn(array('label' => Lang::get('decima-accounting::account-management.name'), 'index' => 'a.name', 'name' => 'acct_am_name'))
				->addColumn(array('label' => Lang::get('decima-accounting::account-management.accountType'), 'index' => 'at.name', 'name' => 'acct_am_account_type', 'align' => 'center'))
	    	->addColumn(array('label' => Lang::get('decima-accounting::account-management.balanceType'), 'index' => 'a.balance_type', 'name' => 'acct_am_balance_type', 'formatter' => 'select', 'editoptions' => array('value' => Lang::get('decima-accounting::account-management.balanceTypeText')), 'align' => 'center'))
	    	->addColumn(array('label' => Lang::get('decima-accounting::account-management.isGroup'), 'index' => 'a.is_group', 'name' => 'acct_am_is_group', 'width' => 40, 'formatter' => 'select', 'editoptions' => array('value' => Lang::get('form.booleanText')), 'align' => 'center'))
	    	->renderGrid();
			!!}
		</div>
	</div>
</div>
<div id='acct-am-journals-section' class="row collapse in section-block">
	{!! Form::journals('acct-am-', $appInfo['id'], true, '', '', '', null, null, false) !!}
</div>
<div id='acct-am-form-section' class="row collapse">
	<div class="col-lg-12 col-md-12">
		<div class="form-container">
			{!! Form::open(array('id' => 'acct-am-form', 'url' => URL::to('accounting/setup/accounts-management'), 'role'  =>  'form', 'onsubmit' => 'return false;')) !!}
				<legend id="acct-am-form-new-title" class="hidden">{{ Lang::get('decima-accounting::account-management.formNewTitle') }}</legend>
				<legend id="acct-am-form-edit-title" class="hidden">{{ Lang::get('decima-accounting::account-management.formEditTitle') }}</legend>
				<div class="row">
					<div class="col-lg-6 col-md-6">
						<div class="form-group mg-hm">
							{!! Form::label('acct-am-parent-account', Lang::get('decima-accounting::account-management.parentAccount'), array('class' => 'control-label')) !!}
					    {!! Form::autocomplete('acct-am-parent-account', $accounts, array('class' => 'form-control', 'data-invalid-parent-validation' => Lang::get('decima-accounting::account-management.invalidParentValidation')), 'acct-am-parent-account', 'acct-am-parent-account-id', null, 'fa-sitemap') !!}
					    {!! Form::hidden('acct-am-id', null, array('id' => 'acct-am-id')) !!}
					    {!! Form::hidden('acct-am-parent-account-id', null, array('id' => 'acct-am-parent-account-id')) !!}
			  		</div>
						<div class="form-group mg-hm">
							{!! Form::label('acct-am-key', Lang::get('decima-accounting::account-management.key'), array('class' => 'control-label')) !!}
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-tag"></i>
								</span>
					    	{!! Form::text('acct-am-key', null , array('id' => 'acct-am-key', 'class' => 'form-control', 'data-mg-required' => '')) !!}
					    </div>
			  		</div>
						<div class="form-group mg-hm">
							{!! Form::label('acct-am-name', Lang::get('decima-accounting::account-management.name'), array('class' => 'control-label')) !!}
					    {!! Form::text('acct-am-name', null , array('id' => 'acct-am-name', 'class' => 'form-control', 'data-mg-required' => '')) !!}
			  		</div>
						<div class="form-group mg-hm">
							{!! Form::label('acct-am-balance-type-name', Lang::get('decima-accounting::account-management.balanceType'), array('class' => 'control-label')) !!}
					    {!! Form::autocomplete('acct-am-balance-type-name', $balanceTypes, array('class' => 'form-control', 'data-mg-required' => ''), 'acct-am-balance-type-name', 'acct-am-balance-type', null, 'fa-balance-scale') !!}
					    {!! Form::hidden('acct-am-balance-type', null, array('id' => 'acct-am-balance-type')) !!}
			  		</div>
						<div class="form-group mg-hm">
							{!! Form::label('acct-am-account-type', Lang::get('decima-accounting::account-management.accountType'), array('class' => 'control-label')) !!}
					    {!! Form::autocomplete('acct-am-account-type', $acountTypes, array('class' => 'form-control', 'data-mg-required' => ''), 'acct-am-account-type', 'acct-am-account-type-id', null, 'fa-money') !!}
					    {!! Form::hidden('acct-am-account-type-id', null, array('id' => 'acct-am-account-type-id')) !!}
			  		</div>
						<div class="form-group checkbox mg-hm">
							<label class="control-label">
								{!! Form::checkbox('acct-am-is-group', 'S', false, array('id' => 'acct-am-is-group')) !!}
								{{ Lang::get('decima-accounting::account-management.isGroupLong') }}
							</label>
							<p class="help-block">{{ Lang::get('decima-accounting::account-management.isGroupHelperText') }}</p>
						</div>
					</div>
					<div class="col-lg-6 col-md-6">
						  <div id="acct-am-tree" style="margin-top: 10px;"></div>
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
<div id='acct-am-modal-delete' class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm acct-am-btn-delete">
    <div class="modal-content">
			<div class="modal-body" style="padding: 20px 20px 0px 20px;">
				<p id="acct-am-delete-message" data-default-label="{{ Lang::get('decima-accounting::account-management.deleteMessageConfirmation') }}"></p>
      </div>
			<div class="modal-footer" style="text-align:center;">
				<button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('form.no') }}</button>
				<button id="acct-am-btn-modal-delete" type="button" class="btn btn-primary">{{ Lang::get('form.yes') }}</button>
			</div>
    </div>
  </div>
</div>
@parent
@stop
