@extends('layouts.base')

@section('container')
{!! Form::hidden('module-app-new-action', null, array('id' => 'module-app-new-action')) !!}
{!! Form::hidden('module-app-edit-action', null, array('id' => 'module-app-edit-action', 'data-content' => Lang::get('module::app.editHelpText'))) !!}
{!! Form::hidden('module-app-remove-action', null, array('id' => 'module-app-remove-action', 'data-content' => Lang::get('module::app.editHelpText'))) !!}
{!! Form::button('', array('id' => 'module-app-btn-edit-helper', 'class' => 'hidden')) !!}
{!! Form::button('', array('id' => 'module-app-btn-delete-helper', 'class' => 'hidden')) !!}
<style></style>

<script type='text/javascript'>
	//Falta agregar  codigo para quitar tooltip
	//For grids with multiselect enabled
	function moduleAppOnSelectRowEvent(id)
	{
		var selRowIds = $('#module-app-grid').jqGrid('getGridParam', 'selarrrow'), id;

		if(selRowIds.length == 0)
		{
			$('#module-app-btn-group-2').disabledButtonGroup();
			cleanJournals('module-app-');
			// cleanFiles('module-app-')
		}
		else if(selRowIds.length == 1)
		{
			$('#module-app-btn-group-2').enableButtonGroup();

			id = $('#module-app-grid').getSelectedRowId('module_app_id');

			if($('#module-app-journals').attr('data-journalized-id') != id)
			{
				cleanJournals('module-app-');
				// getElementFiles('module-app-', id);
				getAppJournals('module-app-','firstPage', id);
			}

		}
		else if(selRowIds.length > 1)
		{
			$('#module-app-btn-group-2').disabledButtonGroup();
			$('#module-app-btn-delete').removeAttr('disabled');
			cleanJournals('module-app-');
			// cleanFiles('module-app-')
		}
	}

	/*
	//For grids with multiselect disabled
	function moduleAppOnSelectRowEvent()
	{
		var id = $('#module-app-grid').getSelectedRowId('module_app_id');

		if($('#module-app-journals').attr('data-journalized-id') != id)
		{
			getAppJournals('module-app-', 'firstPage', id);
			// getElementFiles('module-app-', id);
		}

		$('#module-app-btn-group-2').enableButtonGroup();
	}
	*/

	$(document).ready(function()
	{
		$('.module-app-btn-tooltip').tooltip();

		$('#module-app-form').jqMgVal('addFormFieldsValidations');

		$('#module-app-journals-section').on('hidden.bs.collapse', function ()
		{
			$($(this).attr('data-target-id')).collapse('show');
		});

		$('#module-app-form-section').on('shown.bs.collapse', function ()
		{
			$('#module-app-name').focus();
		});

		$('#module-app-form-section').on('hidden.bs.collapse', function ()
		{
			$('#module-app-grid-section').collapse('show');

			$('#module-app-journals-section').collapse('show');
		});

		$('#module-app-btn-new').click(function()
		{
			if($(this).hasAttr('disabled'))
			{
				return;
			}

			$('#module-app-btn-toolbar').disabledButtonGroup();
			$('#module-app-btn-group-3').enableButtonGroup();
			$('#module-app-form-new-title').removeClass('hidden');
			$('#module-app-grid-section').collapse('hide');
			$('#module-app-journals-section').attr('data-target-id', '#module-app-form-section');
			$('#module-app-journals-section').collapse('hide');
			$('.module-app-btn-tooltip').tooltip('hide');
		});

		$('#module-app-btn-refresh').click(function()
		{
			$('.module-app-btn-tooltip').tooltip('hide');
			$('#module-app-btn-toolbar').disabledButtonGroup();
			$('#module-app-btn-group-1').enableButtonGroup();

			if($('#module-app-journals-section').attr('data-target-id') == '' || $('#module-app-journals-section').attr('data-target-id') == '#module-app-form-section')
			{
				$('#module-app-grid').trigger('reloadGrid');
				cleanJournals('module-app-');
				// cleanFiles('module-app-')
			}
			else
			{

			}
		});

		$('#module-app-btn-export-xls').click(function()
		{
			if($('#module-app-journals-section').attr('data-target-id') == '')
			{
				$('#module-app-gridXlsButton').click();
			}
			else
			{

			}
		});

		$('#module-app-btn-export-csv').click(function()
		{
			if($('#module-app-journals-section').attr('data-target-id') == '')
			{
				$('#module-app-gridCsvButton').click();
			}
			else
			{

			}
		});

		$('#module-app-btn-edit').click(function()
		{
			var rowData;

			$('.module-app-btn-tooltip').tooltip('hide');
			$('#module-app-btn-toolbar').disabledButtonGroup();
			$('#module-app-btn-group-3').enableButtonGroup();

			if($('#module-app-journals-section').attr('data-target-id') == '')
			{
				if(!$('#module-app-grid').isRowSelected())
				{
					$('#module-app-btn-toolbar').showAlertAfterElement('alert-info alert-custom', lang.invalidSelection, 5000);
					return;
				}

				$('#module-app-form-edit-title').removeClass('hidden');

				rowData = $('#module-app-grid').getRowData($('#module-app-grid').jqGrid('getGridParam', 'selrow'));

				populateFormFields(rowData);

				$('#module-app-form-edit-title').removeClass('hidden');
				$('#module-app-grid-section').collapse('hide');
				$('#module-app-journals-section').attr('data-target-id', '#module-app-form-section');
				$('#module-app-journals-section').collapse('hide');
			}
			else
			{

			}
		});

		$('#module-app-btn-delete').click(function()
		{
			var rowData;

			if($(this).hasAttr('disabled'))
			{
				return;
			}

			if($('#module-app-journals-section').attr('data-target-id') == '')
			{
				if(!$('#module-app-grid').isRowSelected())
				{
					$('#module-app-btn-toolbar').showAlertAfterElement('alert-info alert-custom', lang.invalidSelection, 5000);
					return;
				}

				rowData = $('#module-app-grid').getRowData($('#module-app-grid').jqGrid('getGridParam', 'selrow'));

				// $('#module-app-delete-message').html($('#module-app-delete-message').attr('data-default-label').replace(':name', rowData.module_app_name));
			}
			else
			{

			}

			$('.module-app-btn-tooltip').tooltip('hide');
			$('#module-app-modal-delete').modal('show');
		});

		$('#module-app-btn-modal-delete').click(function()
		{
			var id, url;

			if($('#module-app-journals-section').attr('data-target-id') == '')
			{
				url = $('#module-app-form').attr('action') + '/delete';
				//For grids with multiselect enabled
				id = $('#module-app-grid').getSelectedRowsIdCell('module_app_id');
				//For grids with multiselect disabled
				// id = $('#module-app-grid').getSelectedRowId('module_app_id');
			}
			else
			{

			}

			$.ajax(
			{
				type: 'POST',
				data: JSON.stringify({'_token':$('#app-token').val(), 'id':id}),
				dataType : 'json',
				url:  url,
				error: function (jqXHR, textStatus, errorThrown)
				{
					handleServerExceptions(jqXHR, 'module-app-btn-toolbar', false);
					$('#module-app-modal-delete').modal('hide');
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
						$('#module-app-btn-refresh').click();
						$('#module-app-btn-toolbar').showAlertAfterElement('alert-success alert-custom',json.success, 5000);
					}
					else if(json.info)
					{
						$('#module-app-btn-toolbar').showAlertAfterElement('alert-info alert-custom',json.info, 12000);
					}

					$('#module-app-modal-delete').modal('hide');
					$('#app-loader').addClass('hidden');
					enableAll();
				}
			});
		});

		$('#module-app-btn-save').click(function()
		{
			var url = $('#module-app-form').attr('action'), action = 'new';

			$('.module-app-btn-tooltip').tooltip('hide');

			if($('#module-app-journals-section').attr('data-target-id') == '#module-app-form-section')
			{
				if(!$('#module-app-form').jqMgVal('isFormValid'))
				{
					return;
				}

				if($('#module-app-id').isEmpty())
				{
					url = url + '/create';
				}
				else
				{
					url = url + '/update';
					action = 'edit';
				}

				data = $('#module-app-form').formToObject('module-app-');
			}
			else
			{

			}

			$.ajax(
			{
				type: 'POST',
				data: JSON.stringify(data),
				dataType : 'json',
				url: url,
				error: function (jqXHR, textStatus, errorThrown)
				{
					handleServerExceptions(jqXHR, 'module-app-form');
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
						if($('#module-app-journals-section').attr('data-target-id') == '#module-app-form-section')
						{
							$('#module-app-btn-close').click();
							$('#module-app-btn-toolbar').showAlertAfterElement('alert-success alert-custom',json.success, 6000);
						}
						else
						{
							// $('#module-app-btn-toolbar').showAlertAfterElement('alert-success alert-custom',json.success, 6000);
							// $('#module-app-form').showAlertAsFirstChild('alert-success', json.success, 6000)
						}
					}
					else if(json.info)
					{
						if($('#module-app-journals-section').attr('data-target-id') == '#module-app-form-section')
						{
							$('#module-app-form').showAlertAsFirstChild('alert-info', json.info, 12000);
						}
						else
						{
							// $('#module-app-form').showAlertAsFirstChild('alert-info', json.info, 12000);
						}
					}

					$('#app-loader').addClass('hidden');
					enableAll();
				}
			});
		});

		$('#module-app-btn-close').click(function()
		{
			if($(this).hasAttr('disabled'))
			{
				return;
			}

			// module-app-form-section
			if($('#module-app-journals-section').attr('data-target-id') == '#module-app-form-section')
			{
				$('#module-app-form-new-title').addClass('hidden');
				$('#module-app-form-edit-title').addClass('hidden');
				$('#module-app-btn-refresh').click();
				$('#module-app-form').jqMgVal('clearForm');
				$('#module-app-form-section').collapse('hide');
			}
			else
			{

			}

			$('#module-app-btn-group-1').enableButtonGroup();
			$('#module-app-btn-group-3').disabledButtonGroup();
			$('.module-app-btn-tooltip').tooltip('hide');
			$('#module-app-journals-section').attr('data-target-id', '')
		});

		$('#module-app-btn-edit-helper').click(function()
	  {
			showButtonHelper('module-app-btn-close', 'module-app-btn-group-2', $('#module-app-edit-action').attr('data-content'));
	  });

		$('#module-app-btn-delete-helper').click(function()
	  {
			showButtonHelper('module-app-btn-close', 'module-app-btn-group-2', $('#module-app-delete-action').attr('data-content'));
	  });

		if(!$('#module-app-new-action').isEmpty())
		{
			$('#module-app-btn-new').click();
		}

		if(!$('#module-app-edit-action').isEmpty())
		{
			showButtonHelper('module-app-btn-close', 'module-app-btn-group-2', $('#module-app-edit-action').attr('data-content'));
		}

		if(!$('#module-app-delete-action').isEmpty())
		{
			showButtonHelper('module-app-btn-close', 'module-app-btn-group-2', $('#module-app-delete-action').attr('data-content'));
		}
	});
</script>

<div class="row">
	<div class="col-lg-12 col-md-12">
		<div id="module-app-btn-toolbar" class="section-header btn-toolbar" role="toolbar">
			<div id="module-app-btn-group-1" class="btn-group btn-group-app-toolbar">
				{!! Form::button('<i class="fa fa-plus"></i> ' . Lang::get('toolbar.new'), array('id' => 'module-app-btn-new', 'class' => 'btn btn-default module-app-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'data-original-title' => Lang::get('module::app.new'))) !!}
				{!! Form::button('<i class="fa fa-refresh"></i> ' . Lang::get('toolbar.refresh'), array('id' => 'module-app-btn-refresh', 'class' => 'btn btn-default module-app-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'data-original-title' => Lang::get('toolbar.refreshLongText'))) !!}
				<div class="btn-group">
					{!! Form::button('<i class="fa fa-share-square-o"></i> ' . Lang::get('toolbar.export') . ' <span class="caret"></span>', array('class' => 'btn btn-default dropdown-toggle', 'data-container' => 'body', 'data-toggle' => 'dropdown')) !!}
					<ul class="dropdown-menu">
         		<li><a id='module-app-btn-export-xls' class="fake-link"><i class="fa fa-file-excel-o"></i> xls</a></li>
         		<li><a id='module-app-btn-export-csv' class="fake-link"><i class="fa fa-file-text-o"></i> csv</a></li>
       		</ul>
				</div>
			</div>
			<div id="module-app-btn-group-2" class="btn-group btn-group-app-toolbar">
				{!! Form::button('<i class="fa fa-edit"></i> ' . Lang::get('toolbar.edit'), array('id' => 'module-app-btn-edit', 'class' => 'btn btn-default module-app-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'disabled' => '', 'data-original-title' => Lang::get('module::app.edit'))) !!}
				{!! Form::button('<i class="fa fa-minus"></i> ' . Lang::get('toolbar.delete'), array('id' => 'module-app-btn-delete', 'class' => 'btn btn-default module-app-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'disabled' => '', 'data-original-title' => Lang::get('module::app.delete'))) !!}
			</div>
			<div id="module-app-btn-group-3" class="btn-group btn-group-app-toolbar">
				{!! Form::button('<i class="fa fa-save"></i> ' . Lang::get('toolbar.save'), array('id' => 'module-app-btn-save', 'class' => 'btn btn-default module-app-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'disabled' => '', 'data-original-title' => Lang::get('module::app.save'))) !!}
				{!! Form::button('<i class="fa fa-undo"></i> ' . Lang::get('toolbar.close'), array('id' => 'module-app-btn-close', 'class' => 'btn btn-default module-app-btn-tooltip', 'data-container' => 'body', 'data-toggle' => 'tooltip', 'disabled' => '', 'data-original-title' => Lang::get('toolbar.closeLongText'))) !!}
			</div>
		</div>
		<div id='module-app-grid-section' class='app-grid collapse in' data-app-grid-id='module-app-grid'>
			{!!
			GridRender::setGridId("module-app-grid")
				->enablefilterToolbar(false, false)
				->hideXlsExporter()
  			->hideCsvExporter()
	    	->setGridOption('url',URL::to('module/category/app/grid-data'))
	    	->setGridOption('caption', Lang::get('module::app.gridTitle', array('user' => AuthManager::getLoggedUserFirstname())))
	    	->setGridOption('postData',array('_token' => Session::token()))
				->setGridEvent('onSelectRow', 'moduleAppOnSelectRowEvent')
	    	->addColumn(array('index' => 'id', 'name' => 'module_app_id', 'hidden' => true))
	    	->addColumn(array('label' => Lang::get('form.name'), 'index' => 'name' ,'name' => 'module_app_name'))
				->addColumn(array('label' => Lang::get('form.status'), 'index' => 'status', 'name' => 'module_app_status', 'formatter' => 'select', 'editoptions' => array('value' => Lang::get('form.statusGridText')), 'align' => 'center', 'hidden' => false))
				//->addColumn(array('label' => Lang::get('form.status'), 'index' => 'status', 'name' => 'module_app_status', 'formatter' => 'select', 'editoptions' => array('value' => Lang::get('module::app.statusGridText')), 'align' => 'center', 'hidden' => false, 'stype' => 'select'))
				->addColumn(array('label' => Lang::get('module::app.money'), 'index' => 'money', 'name' => 'money', 'formatter' => 'currency', 'align'=>'right', 'width' => 100, 'hidden' => false, 'formatoptions' => array('prefix' => OrganizationManager::getOrganizationCurrencySymbol() . ' ')))
	    	->renderGrid();
			!!}
		</div>
	</div>
</div>
<div id='module-app-form-section' class="row collapse">
	<div class="col-lg-12 col-md-12">
		<div class="form-container">
			{!! Form::open(array('id' => 'module-app-form', 'url' => URL::to('module/category/app'), 'role'  =>  'form', 'onsubmit' => 'return false;')) !!}
				<legend id="module-app-form-new-title" class="hidden">{{ Lang::get('module::app.formNewTitle') }}</legend>
				<legend id="module-app-form-edit-title" class="hidden">{{ Lang::get('module::app.formEditTitle') }}</legend>
				<div class="row">
					<div class="col-lg-6 col-md-6">
						<div class="form-group mg-hm">
							{!! Form::label('module-app-name', Lang::get('form.name'), array('class' => 'control-label')) !!}
					    {!! Form::text('module-app-name', null , array('id' => 'module-app-name', 'class' => 'form-control', 'data-mg-required' => '')) !!}
					    {!! Form::hidden('module-app-id', null, array('id' => 'module-app-id')) !!}
			  		</div>
					</div>
					<div class="col-lg-6 col-md-6">
						<div class="form-group mg-hm">
							{!! Form::label('module-app-phone-number', Lang::get('module::app.phoneNumber'), array('class' => 'control-label')) !!}
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-phone"></i>
								</span>
					    	{!! Form::text('module-app-phone-number', null , array('id' => 'module-app-phone-number', 'class' => 'form-control')) !!}
					    </div>
			  		</div>
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
<div id='module-app-journals-section' class="row collapse in section-block" data-target-id="">
	{!! Form::journals('module-app-', $appInfo['id']) !!}
</div>
<div id='module-app-modal-delete' class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm module-app-btn-delete">
    <div class="modal-content">
			<div class="modal-body" style="padding: 20px 20px 0px 20px;">
				<p id="module-app-delete-message" data-default-label="{{ Lang::get('form.deleteMessageConfirmation') }}"></p>
				<!-- <p id="module-app-delete-message" data-default-label="{{ Lang::get('module::app.deleteMessageConfirmation') }}"></p> -->
      </div>
			<div class="modal-footer" style="text-align:center;">
				<button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('form.no') }}</button>
				<button id="module-app-btn-modal-delete" type="button" class="btn btn-primary">{{ Lang::get('form.yes') }}</button>
			</div>
    </div>
  </div>
</div>
@parent
@stop
