@extends('layouts.base')

@section('container')
{!! Html::style('assets/jstree-v3.2.1/dist/themes/default/style.min.css') !!}
{!! Html::script('assets/jstree-v3.2.1/dist/jstree.min.js') !!}
{!! Form::hidden('acct-ccm-new-action', $newCostCenterAction, array('id' => 'acct-ccm-new-action')) !!}
{!! Form::hidden('acct-ccm-edit-action', $editCostCenterAction, array('id' => 'acct-ccm-edit-action', 'data-content' => Lang::get('decima-accounting::cost-center-management.editHelpText'))) !!}
{!! Form::hidden('acct-ccm-delete-action', $deleteCostCenterAction, array('id' => 'acct-ccm-delete-action', 'data-content' => Lang::get('decima-accounting::cost-center-management.deleteHelpText'))) !!}
{!! Form::button('', array('id' => 'acct-ccm-btn-edit-helper', 'class' => 'hidden')) !!}
{!! Form::button('', array('id' => 'acct-ccm-btn-delete-helper', 'class' => 'hidden')) !!}
<style></style>

<script type='text/javascript'>

acctCcmDefaultTreeData = [{"text" : "{{ Lang::get('decima-accounting::cost-center-management.parentCc') }}"}];

function acctCcmOnSelectRowEvent()
{
	var id = $('#acct-ccm-grid').getSelectedRowId('acct_ccm_id');

	getAppJournals('acct-ccm-', 'firstPage', id);

	$('#acct-ccm-btn-group-2').enableButtonGroup();
}

function acctAmShowParentTree(parentId)
{
	if($.trim(parentId) == '')
	{
		return;
	}

	$('#acct-ccm-tree').attr('data-account-id', parentId);

	$.ajax(
	{
		type: 'POST',
		data: JSON.stringify({'_token': $('#app-token').val(), 'id': parentId}),
		dataType : 'json',
		url:  $('#acct-ccm-form').attr('action') + '/cost-center-children',
		error: function (jqXHR, textStatus, errorThrown)
		{
			handleServerExceptions(jqXHR, 'acct-ccm-btn-toolbar', false);
		},
		beforeSend:function()
		{
			$('#app-loader').removeClass('hidden');
			disabledAll();
		},
		success:function(json)
		{
			$('#acct-ccm-tree').jstree(true).settings.core.data = json;
			$('#acct-ccm-tree').jstree(true).refresh();
			$('#app-loader').addClass('hidden');
			enableAll();
			$('#acct-ccm-key').focus();
		}
	});
}

$(document).ready(function()
{
	$('.acct-ccm-btn-tooltip').tooltip();

	$('#acct-ccm-form').jqMgVal('addFormFieldsValidations');

	$('#acct-ccm-tree').jstree({
	 'core' : { 'data' : acctCcmDefaultTreeData}
	});

	$('#acct-ccm-grid-section').on('shown.bs.collapse', function ()
	{
		$('#acct-ccm-btn-refresh').click();
	});

	$('#acct-ccm-journals-section').on('hidden.bs.collapse', function ()
	{
		$('#acct-ccm-form-section').collapse('show');
	});

	$('#acct-ccm-form-section').on('shown.bs.collapse', function ()
	{
		$('#acct-ccm-parent-cc').focus();
	});

	$('#acct-ccm-form-section').on('hidden.bs.collapse', function ()
	{
		$('#acct-ccm-grid-section').collapse('show');

		$('#acct-ccm-journals-section').collapse('show');
	});

	$('#acct-ccm-parent-cc').on( 'autocompleteselect', function( event, ui )
	{
		if($('#acct-ccm-tree').attr('data-account-id') == ui.item.value)
		{
			return;
		}

		acctAmShowParentTree(ui.item.value);
	});

	$('#acct-ccm-btn-new').click(function()
	{
		if($(this).hasAttr('disabled'))
		{
			return;
		}

		$('#acct-ccm-btn-toolbar').disabledButtonGroup();
		$('#acct-ccm-btn-group-3').enableButtonGroup();
		$('#acct-ccm-form-new-title').removeClass('hidden');
		$('#acct-ccm-grid-section').collapse('hide');
		$('#acct-ccm-journals-section').collapse('hide');
		$('.acct-ccm-btn-tooltip').tooltip('hide');
	});

	$('#acct-ccm-btn-refresh').click(function()
	{
		$('.acct-ccm-btn-tooltip').tooltip('hide');
		$('#acct-ccm-grid').trigger('reloadGrid');
		cleanJournals('acct-ccm-');
		$('#acct-ccm-btn-toolbar').disabledButtonGroup();
		$('#acct-ccm-btn-group-1').enableButtonGroup();
	});

	$('#acct-ccm-btn-export-xls').click(function()
	{
			$('#acct-ccm-gridXlsButton').click();
	});

	$('#acct-ccm-btn-export-csv').click(function()
	{
			$('#acct-ccm-gridCsvButton').click();
	});

	$('#acct-ccm-btn-edit').click(function()
	{
		var rowData;

		$('#acct-ccm-btn-toolbar').disabledButtonGroup();
		$('#acct-ccm-btn-group-3').enableButtonGroup();
		$('#acct-ccm-form-edit-title').removeClass('hidden');
		$('.acct-ccm-btn-tooltip').tooltip('hide');

		rowData = $('#acct-ccm-grid').getRowData($('#acct-ccm-grid').jqGrid('getGridParam', 'selrow'));

		populateFormFields(rowData);
		acctAmShowParentTree(rowData.acct_ccm_parent_cc_id);

		$('#acct-ccm-parent-cc').val(rowData.acct_ccm_parent_key + ' ' + rowData.acct_ccm_parent_cc);
		$('#acct-ccm-grid-section').collapse('hide');
		$('#acct-ccm-journals-section').collapse('hide');
	});

	$('#acct-ccm-btn-delete').click(function()
	{
		var rowData;

		if($(this).hasAttr('disabled'))
		{
			return;
		}

		rowData = $('#acct-ccm-grid').getRowData($('#acct-ccm-grid').jqGrid('getGridParam', 'selrow'));

		$('#acct-ccm-delete-message').html($('#acct-ccm-delete-message').attr('data-default-label').replace(':cc', rowData.acct_ccm_key + ' ' + rowData.acct_ccm_name));

		$('.acct-ccm-btn-tooltip').tooltip('hide');

		$('#acct-ccm-modal-delete').modal('show');
	});

	$('#acct-ccm-btn-modal-delete').click(function()
	{
		var id = $('#acct-ccm-grid').getSelectedRowId('acct_ccm_id');

		$.ajax(
		{
			type: 'POST',
			data: JSON.stringify({'_token':$('#app-token').val(), 'id':id}),
			dataType : 'json',
			url:  $('#acct-ccm-form').attr('action') + '/delete',
			error: function (jqXHR, textStatus, errorThrown)
			{
				handleServerExceptions(jqXHR, 'acct-ccm-btn-toolbar', false);
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
					$('#acct-ccm-btn-refresh').click();
					$('#acct-ccm-btn-toolbar').showAlertAfterElement('alert-success alert-custom',json.success, 5000);
				}
				else if(json.info)
				{
					$('#acct-ccm-btn-toolbar').showAlertAfterElement('alert-info alert-custom',json.info, 8000);
				}

				$('#acct-ccm-modal-delete').modal('hide');
				$('#app-loader').addClass('hidden');
				enableAll();
			}
		});
	});

	$('#acct-ccm-btn-save').click(function()
	{
		var url = $('#acct-ccm-form').attr('action'), action = 'new';

		$('.acct-ccm-btn-tooltip').tooltip('hide');

		if(!$('#acct-ccm-form').jqMgVal('isFormValid'))
		{
			return;
		}

		if($('#acct-ccm-parent-cc').isEmpty())
		{
			$('#acct-ccm-parent-cc-id').val('');
		}

		if($('#acct-ccm-parent-cc-id').val() == $('#acct-ccm-id').val() && !$('#acct-ccm-id').isEmpty())
		{
			$('#acct-ccm-form').showServerErrorsByField({'parent-cc':$('#acct-ccm-parent-cc').attr('data-invalid-parent-validation')}, 'acct-ccm-');

			return;
		}

		if($('#acct-ccm-id').isEmpty())
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
			data: JSON.stringify($('#acct-ccm-form').formToObject('acct-ccm-')),
			dataType : 'json',
			url: url,
			error: function (jqXHR, textStatus, errorThrown)
			{
				handleServerExceptions(jqXHR, 'acct-ccm-form');
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
					$('#acct-ccm-btn-close').click();
				}
				else if(json.info)
				{
					$('#acct-ccm-form').showAlertAsFirstChild('alert-info', json.info, 8000);
				}
				else if(json.validationFailed)
				{
					$('#acct-ccm-form').showServerErrorsByField(json.fieldValidationMessages, 'acct-ccm-');
				}

				if(json.groupsCostCenters)
				{
					$('#acct-ccm-parent-cc').autocomplete( "option", "source", json.groupsCostCenters);
				}

				$('#app-loader').addClass('hidden');
				enableAll();
			}
		});
	});

	$('#acct-ccm-btn-close').click(function()
	{
		if($(this).hasAttr('disabled'))
		{
			return;
		}

		$('#acct-ccm-btn-group-1').enableButtonGroup();
		$('#acct-ccm-btn-group-3').disabledButtonGroup();
		$('#acct-ccm-form-new-title').addClass('hidden');
		$('#acct-ccm-form-edit-title').addClass('hidden');
		$('#acct-ccm-grid').jqGrid('clearGridData');
		$('#acct-ccm-form').jqMgVal('clearForm');
		$('#acct-ccm-tree').jstree(true).settings.core.data = acctCcmDefaultTreeData;
		$('#acct-ccm-tree').jstree(true).refresh();
		$('#acct-ccm-tree').attr('data-account-id', 0);
		$('.acct-ccm-btn-tooltip').tooltip('hide');
		$('#acct-ccm-form-section').collapse('hide');
	});

	$('#acct-ccm-btn-edit-helper').click(function()
  {
		showButtonHelper('acct-ccm-btn-close', 'acct-ccm-btn-group-2', $('#acct-ccm-edit-action').attr('data-content'));
  });

	$('#acct-ccm-btn-delete-helper').click(function()
  {
		showButtonHelper('acct-ccm-btn-close', 'acct-ccm-btn-group-2', $('#acct-ccm-delete-action').attr('data-content'));
  });

	if(!$('#acct-ccm-new-action').isEmpty())
	{
		$('#acct-ccm-btn-new').click();
	}

	if(!$('#acct-ccm-edit-action').isEmpty())
	{
		showButtonHelper('acct-ccm-btn-close', 'acct-ccm-btn-group-2', $('#acct-ccm-edit-action').attr('data-content'));
	}

	if(!$('#acct-ccm-delete-action').isEmpty())
	{
		showButtonHelper('acct-ccm-btn-close', 'acct-ccm-btn-group-2', $('#acct-ccm-delete-action').attr('data-content'));
	}
});

</script>

<div class="row">
	<div class="col-lg-12 col-md-12">
		<div id="acct-ccm-btn-toolbar" class="section-header btn-toolbar" role="toolbar">
			<div id="acct-ccm-btn-group-1" class="btn-group btn-group-app-toolbar">
				{!! Form::button('<i class="fa fa-plus"></i> ' . Lang::get('toolbar.new'), array('id' => 'acct-ccm-btn-new', 'class' => 'btn btn-default acct-ccm-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'data-original-title' => Lang::get('decima-accounting::cost-center-management.new'))) !!}
				{!! Form::button('<i class="fa fa-refresh"></i> ' . Lang::get('toolbar.refresh'), array('id' => 'acct-ccm-btn-refresh', 'class' => 'btn btn-default acct-ccm-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'data-original-title' => Lang::get('toolbar.refreshLongText'))) !!}
				<div class="btn-group">
					{!! Form::button('<i class="fa fa-share-square-o"></i> ' . Lang::get('toolbar.export') . ' <span class="caret"></span>', array('class' => 'btn btn-default dropdown-toggle', 'data-container' => 'body', 'data-toggle' => 'dropdown')) !!}
					<ul class="dropdown-menu">
         		<li><a id='acct-ccm-btn-export-xls' class="fake-link"><i class="fa fa-file-excel-o"></i> xls</a></li>
         		<li><a id='acct-ccm-btn-export-csv' class="fake-link"><i class="fa fa-file-text-o"></i> csv</a></li>
       		</ul>
				</div>
			</div>
			<div id="acct-ccm-btn-group-2" class="btn-group btn-group-app-toolbar">
				{!! Form::button('<i class="fa fa-edit"></i> ' . Lang::get('toolbar.edit'), array('id' => 'acct-ccm-btn-edit', 'class' => 'btn btn-default acct-ccm-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'disabled' => '', 'data-original-title' => Lang::get('decima-accounting::cost-center-management.edit'))) !!}
				{!! Form::button('<i class="fa fa-minus"></i> ' . Lang::get('toolbar.delete'), array('id' => 'acct-ccm-btn-delete', 'class' => 'btn btn-default acct-ccm-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'disabled' => '', 'data-original-title' => Lang::get('decima-accounting::cost-center-management.delete'))) !!}
			</div>
			<div id="acct-ccm-btn-group-3" class="btn-group btn-group-app-toolbar">
				{!! Form::button('<i class="fa fa-save"></i> ' . Lang::get('toolbar.save'), array('id' => 'acct-ccm-btn-save', 'class' => 'btn btn-default acct-ccm-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'disabled' => '', 'data-original-title' => Lang::get('decima-accounting::cost-center-management.save'))) !!}
				{!! Form::button('<i class="fa fa-times"></i> ' . Lang::get('toolbar.close'), array('id' => 'acct-ccm-btn-close', 'class' => 'btn btn-default acct-ccm-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'disabled' => '', 'data-original-title' => Lang::get('toolbar.closeLongText'))) !!}
			</div>
		</div>
		<div id='acct-ccm-grid-section' class='app-grid collapse in' data-app-grid-id='acct-ccm-grid'>
			{!!
			GridRender::setGridId("acct-ccm-grid")
				//->enablefilterToolbar(false, false)
				->hideXlsExporter()
  			->hideCsvExporter()
				->setGridOption('height', 'auto')
				->setGridOption('multiselect', false)
				->setGridOption('rowList', array(100, 250, 500, 750, 1000, 2000))
				->setGridOption('rowNum', 1000)
	    	->setGridOption('url', URL::to('accounting/setup/cost-centers-management/cost-center-grid-data'))
	    	->setGridOption('caption', Lang::get('decima-accounting::cost-center-management.gridTitle'))
				->setGridOption('postData',array('_token' => Session::token()))
				->setGridOption('treeGrid', true)
				->setGridOption('ExpandColumn', 'acct_ccm_key')
				->setGridOption('treeReader', array('parent_id_field' => 'acct_ccm_parent_cc_id', 'leaf_field' => 'acct_ccm_is_leaf'))
				->setGridEvent('onSelectRow', 'acctCcmOnSelectRowEvent')
	    	->addColumn(array('index' => 'c.id', 'name' => 'acct_ccm_id', 'hidden' => true, 'key' => true))
				->addColumn(array('index' => 'ap.key', 'name' => 'acct_ccm_parent_key', 'hidden' => true))
				->addColumn(array('index' => 'ap.name', 'name' => 'acct_ccm_parent_cc', 'hidden' => true))
				->addColumn(array('index' => 'acct_ccm_is_leaf', 'hidden' => true))
	    	->addColumn(array('label' => Lang::get('decima-accounting::account-management.key'), 'index' => 'c.key', 'name' => 'acct_ccm_key', 'width' => 125))
	    	->addColumn(array('label' => Lang::get('decima-accounting::account-management.name'), 'index' => 'c.name', 'name' => 'acct_ccm_name'))
	    	->addColumn(array('label' => Lang::get('decima-accounting::account-management.isGroup'), 'index' => 'c.is_group', 'name' => 'acct_ccm_is_group', 'width' => 40, 'formatter' => 'select', 'editoptions' => array('value' => Lang::get('form.booleanText')), 'align' => 'center'))
	    	->renderGrid();
			!!}
		</div>
	</div>
</div>
<div id='acct-ccm-journals-section' class="row collapse in section-block">
	{!! Form::journals('acct-ccm-', $appInfo['id'], true, '', '', '', null, null, false) !!}
</div>
<div id='acct-ccm-form-section' class="row collapse">
	<div class="col-lg-12 col-md-12">
		<div class="form-container">
			{!! Form::open(array('id' => 'acct-ccm-form', 'url' => URL::to('accounting/setup/cost-centers-management'), 'role'  =>  'form', 'onsubmit' => 'return false;')) !!}
				<legend id="acct-ccm-form-new-title" class="hidden">{{ Lang::get('decima-accounting::cost-center-management.formNewTitle') }}</legend>
				<legend id="acct-ccm-form-edit-title" class="hidden">{{ Lang::get('decima-accounting::cost-center-management.formEditTitle') }}</legend>
				<div class="row">
					<div class="col-lg-6 col-md-6">
						<div class="form-group mg-hm">
							{!! Form::label('acct-ccm-parent-cc', Lang::get('decima-accounting::cost-center-management.parentCc'), array('class' => 'control-label')) !!}
					    {!! Form::autocomplete('acct-ccm-parent-cc', $costCenters, array('class' => 'form-control' , 'data-invalid-parent-validation' => Lang::get('decima-accounting::cost-center-management.invalidParentValidation')), 'acct-ccm-parent-cc', 'acct-ccm-parent-cc-id', null, 'fa-sitemap') !!}
					    {!! Form::hidden('acct-ccm-id', null, array('id' => 'acct-ccm-id')) !!}
					    {!! Form::hidden('acct-ccm-parent-cc-id', null, array('id' => 'acct-ccm-parent-cc-id')) !!}
			  		</div>
						<div class="form-group mg-hm">
							{!! Form::label('acct-ccm-key', Lang::get('decima-accounting::account-management.key'), array('class' => 'control-label')) !!}
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-tag"></i>
								</span>
					    	{!! Form::text('acct-ccm-key', null , array('id' => 'acct-ccm-key', 'class' => 'form-control', 'data-mg-required' => '')) !!}
					    </div>
			  		</div>
						<div class="form-group mg-hm">
							{!! Form::label('acct-ccm-name', Lang::get('decima-accounting::account-management.name'), array('class' => 'control-label')) !!}
					    {!! Form::text('acct-ccm-name', null , array('id' => 'acct-ccm-name', 'class' => 'form-control', 'data-mg-required' => '')) !!}
			  		</div>
						<div class="form-group checkbox mg-hm">
							<label class="control-label">
								{!! Form::checkbox('acct-ccm-is-group', 'S', false, array('id' => 'acct-ccm-is-group')) !!}
								{{ Lang::get('decima-accounting::cost-center-management.isGroupLong') }}
							</label>
							<p class="help-block">{{ Lang::get('decima-accounting::cost-center-management.isGroupHelperText') }}</p>
						</div>
					</div>
					<div class="col-lg-6 col-md-6">
						  <div id="acct-ccm-tree" style="margin-top: 10px;"></div>
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
<div id='acct-ccm-modal-delete' class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm acct-ccm-btn-delete">
    <div class="modal-content">
			<div class="modal-body" style="padding: 20px 20px 0px 20px;">
				<p id="acct-ccm-delete-message" data-default-label="{{ Lang::get('decima-accounting::cost-center-management.deleteMessageConfirmation') }}"></p>
      </div>
			<div class="modal-footer" style="text-align:center;">
				<button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('form.no') }}</button>
				<button id="acct-ccm-btn-modal-delete" type="button" class="btn btn-primary">{{ Lang::get('form.yes') }}</button>
			</div>
    </div>
  </div>
</div>
@parent
@stop
