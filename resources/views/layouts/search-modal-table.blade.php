<div id="{{ $prefix }}smt" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-lg search-modal">
    <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">{{ Lang::get('form.searchModalTitle')}}</h4>
			</div>
			<div class="modal-body" class="modal-body" style="padding: 0;">
        <div class="btn-modal-toolbar btn-toolbar" role="toolbar">
  				<div class="btn-group btn-group-app-toolbar">
  			    <button id="{{ $prefix }}smt-btn-select" type="button" class="btn btn-default"><i class="fa fa-edit"></i> {{ Lang::get('toolbar.select') }}</button>
  			    <button id="{{ $prefix }}smt-btn-refresh" type="button" class="btn btn-default"><i class="fa fa-refresh"></i> {{ Lang::get('toolbar.refresh') }}</button>
  			  </div>
  			  <div class="btn-group btn-group-app-toolbar pull-right" style="width: 50%;">
  			    <div class="input-group">
  						<input id="{{ $prefix }}smt-search-box" class="form-control" placeholder="{{ Lang::get('toolbar.search') }}" type="text" onkeyup="smtOnKeyup(event, '{{ $prefix }}')">
  						<div class="input-group-btn">
  						  <button id="{{ $prefix }}smt-btn-search" class="btn btn-default" onclick="smtSearch('{{ $prefix }}')"><i class="glyphicon glyphicon-search"></i></button>
  						</div>
  					</div>
  			  </div>
  			</div>
        <div id="{{ $prefix }}smt-body" class="smt-body">
        </div>
      </div>
    </div>
  </div>
</div>
