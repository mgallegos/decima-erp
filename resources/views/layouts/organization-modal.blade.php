<div id="user-organizations-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
       <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       <h3 class="panel-title"><i class="fa fa-tasks"></i> {{ Lang::get('base.userOrganizations') }}</h3>
      </div>
      <div class="modal-body clearfix">
        <div class="row">
          <div class="col-md-8">
            {!! Form::open(array('id' => 'change-to-organization-form', 'role' => 'form', 'onsubmit' => 'return false;')) !!}
            <div class="form-group mg-hm clearfix">
              {!! Form::label('change-to-organization-name', Lang::get('base.changeOrganization'), array('class' => 'control-label')) !!}
              {!! Form::autocomplete('change-to-organization-name', UserManager::getUserOrganizationsAutocomplete(), array('class' => 'form-control', 'data-mg-required' => ''), 'change-to-organization-name', 'change-to-organization-id', '', 'fa-building-o') !!}
              {!! Form::hidden('change-to-organization-id', '', array('id'  => 'change-to-organization-id')) !!}
             </div>
             {!! Form::close() !!}
           </div>
         </div>
      </div>
      <div id="user-organizations-modal-footer" class="modal-footer">
        <button id="change-to-organization" type="button" class="btn btn-primary">{{ Lang::get('base.changeOrganizationButton') }}</button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-undo"></i> {{ Lang::get('toolbar.close') }}</button>
      </div>
    </div>
  </div>
</div>
