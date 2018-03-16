@extends('layouts.base')

@section('container')
{!! Html::script('assets/kwaai/js/dashboard.js') !!}
<!-- <script type='text/javascript'>

json = '{"api_token":"LCPaQAitIf8yl2HaRYaq7SbkSAuQdbNXMriYIjfK4p23eZ0WgdkZ0vUwqF2y","sale_point_id":1,"sales":[{"id":1,"cloud_id":null,"document_number":3,"modify_document_number":null,"reference_number":null,"emission_date":"2018-03-09T06:00:00.000Z","registration_date":"2018-03-09T06:00:00.000Z","payment_date":"2018-03-09T06:00:00.000Z","collection_date":"2018-03-09T06:00:00.000Z","reversal_date":null,"status":"X","type":"O","remark":"Venta del día 2018-3-9","payment_remark":"Pago de: PARTS PLUS S.A. DE C.V. Crédito Fiscal #15 $ 347.67","not_subject_amount_sum":0,"exempt_amount_sum":0,"subject_amount_sum":294.64,"collected_tax_amount_sum":53.03,"withheld_tax_amount_sum":0,"sales_total":294.64,"advanced_paid_total":0,"syncronized":0,"client_id":43,"client_local_id":71,"payment_term_id":1,"payment_form_id":1,"document_type_id":1,"sale_point_id":1,"bank_account_id":1,"created_by":4,"organization_id":11,"created_at":null,"updated_at":null,"deleted_at":null,"taxes":[{"id":18,"own_not_subject_amount_total":0,"own_exempt_amount_total":0,"own_subject_amount_total":294.64,"own_subject_amount_tax_total":38.3,"third_party_not_subject_amount_total":0,"third_party_exempt_amount_total":0,"third_party_subject_amount_total":0,"third_party_subject_amount_tax_total":0,"order_id":1,"tax_id":1,"organization_id":11,"created_at":null,"updated_at":null,"deleted_at":null},{"id":19,"own_not_subject_amount_total":0,"own_exempt_amount_total":0,"own_subject_amount_total":294.64,"own_subject_amount_tax_total":14.73,"third_party_not_subject_amount_total":0,"third_party_exempt_amount_total":0,"third_party_subject_amount_total":0,"third_party_subject_amount_tax_total":0,"order_id":1,"tax_id":7,"organization_id":11,"created_at":null,"updated_at":null,"deleted_at":null}],"details":[{"id":18,"quantity":1,"price":54.7084,"not_subject_amount":0,"exempt_amount":0,"subject_amount":54.71,"alternative_name":null,"remark":null,"cost":null,"order_id":1,"article_id":17,"discount_id":null,"movement_entry_id":null,"warehouse_origin_id":null,"organization_id":11,"created_at":null,"updated_at":null,"deleted_at":null},{"id":19,"quantity":1,"price":57.7853,"not_subject_amount":0,"exempt_amount":0,"subject_amount":57.79,"alternative_name":null,"remark":null,"cost":null,"order_id":1,"article_id":18,"discount_id":null,"movement_entry_id":null,"warehouse_origin_id":null,"organization_id":11,"created_at":null,"updated_at":null,"deleted_at":null},{"id":20,"quantity":1,"price":60.4007,"not_subject_amount":0,"exempt_amount":0,"subject_amount":60.4,"alternative_name":null,"remark":null,"cost":null,"order_id":1,"article_id":15,"discount_id":null,"movement_entry_id":null,"warehouse_origin_id":null,"organization_id":11,"created_at":null,"updated_at":null,"deleted_at":null},{"id":21,"quantity":1,"price":51.5725,"not_subject_amount":0,"exempt_amount":0,"subject_amount":51.57,"alternative_name":null,"remark":null,"cost":null,"order_id":1,"article_id":10,"discount_id":null,"movement_entry_id":null,"warehouse_origin_id":null,"organization_id":11,"created_at":null,"updated_at":null,"deleted_at":null},{"id":22,"quantity":1,"price":53.9036,"not_subject_amount":0,"exempt_amount":0,"subject_amount":53.9,"alternative_name":null,"remark":null,"cost":null,"order_id":1,"article_id":8,"discount_id":null,"movement_entry_id":null,"warehouse_origin_id":null,"organization_id":11,"created_at":null,"updated_at":null,"deleted_at":null},{"id":23,"quantity":1,"price":16.2675,"not_subject_amount":0,"exempt_amount":0,"subject_amount":16.27,"alternative_name":null,"remark":null,"cost":null,"order_id":1,"article_id":6,"discount_id":null,"movement_entry_id":null,"warehouse_origin_id":null,"organization_id":11,"created_at":null,"updated_at":null,"deleted_at":null}]},{"id":2,"cloud_id":null,"document_number":4,"modify_document_number":null,"reference_number":null,"emission_date":"2018-03-09T06:00:00.000Z","registration_date":"2018-03-09T06:00:00.000Z","payment_date":"2018-03-09T06:00:00.000Z","collection_date":"2018-03-09T06:00:00.000Z","reversal_date":null,"status":"X","type":"O","remark":"Venta del día 2018-3-9","payment_remark":"Pago de: Alejandro Juárez Crédito Fiscal #15 $ 248.85","not_subject_amount_sum":0,"exempt_amount_sum":0,"subject_amount_sum":220.22,"collected_tax_amount_sum":28.63,"withheld_tax_amount_sum":0,"sales_total":220.22,"advanced_paid_total":0,"syncronized":0,"client_id":0,"client_local_id":73,"payment_term_id":1,"payment_form_id":1,"document_type_id":1,"sale_point_id":1,"bank_account_id":1,"created_by":4,"organization_id":11,"created_at":null,"updated_at":null,"deleted_at":null,"taxes":[{"id":20,"own_not_subject_amount_total":0,"own_exempt_amount_total":0,"own_subject_amount_total":220.22,"own_subject_amount_tax_total":28.63,"third_party_not_subject_amount_total":0,"third_party_exempt_amount_total":0,"third_party_subject_amount_total":0,"third_party_subject_amount_tax_total":0,"order_id":2,"tax_id":1,"organization_id":11,"created_at":null,"updated_at":null,"deleted_at":null}],"details":[{"id":24,"quantity":1,"price":73.4071,"not_subject_amount":0,"exempt_amount":0,"subject_amount":73.41,"alternative_name":null,"remark":null,"cost":null,"order_id":2,"article_id":17,"discount_id":null,"movement_entry_id":null,"warehouse_origin_id":null,"organization_id":11,"created_at":null,"updated_at":null,"deleted_at":null},{"id":25,"quantity":1,"price":73.4071,"not_subject_amount":0,"exempt_amount":0,"subject_amount":73.41,"alternative_name":null,"remark":null,"cost":null,"order_id":2,"article_id":18,"discount_id":null,"movement_entry_id":null,"warehouse_origin_id":null,"organization_id":11,"created_at":null,"updated_at":null,"deleted_at":null},{"id":26,"quantity":1,"price":73.4071,"not_subject_amount":0,"exempt_amount":0,"subject_amount":73.41,"alternative_name":null,"remark":null,"cost":null,"order_id":2,"article_id":15,"discount_id":null,"movement_entry_id":null,"warehouse_origin_id":null,"organization_id":11,"created_at":null,"updated_at":null,"deleted_at":null}]}],"clients":[{"id":73,"cloud_id":0,"name":"Alejandro Juárez","street1":null,"street2":null,"city_name":null,"state_name":null,"zip_code":null,"web_site":null,"contact_name":null,"phone_number":null,"fax":null,"email":null,"tax_id":null,"registration_number":null,"single_identity_document_number":null,"commercial_trade":null,"frequent_number":null,"date_birth":null,"syncronized":0,"country_id":202,"taxpayer_classification_id":null,"payment_term_id":null,"organization_id":11,"created_at":null,"updated_at":null,"deleted_at":null},{"id":74,"cloud_id":44,"name":"MI MOTO S.A. DE C.V.","street1":null,"street2":null,"city_name":null,"state_name":null,"zip_code":null,"web_site":null,"contact_name":null,"phone_number":null,"fax":null,"email":null,"tax_id":"0614-050914-104-3","registration_number":"235844-5","single_identity_document_number":null,"commercial_trade":null,"frequent_number":null,"date_birth":null,"syncronized":0,"country_id":202,"taxpayer_classification_id":null,"payment_term_id":1,"organization_id":11,"created_at":"2018-03-08T22:37:03.000Z","updated_at":"2018-03-08T22:37:03.000Z","deleted_at":null},{"id":75,"cloud_id":45,"name":"EXPORTADORA PACAS MARTINEZ S.A. DE C.V.","street1":null,"street2":null,"city_name":null,"state_name":null,"zip_code":null,"web_site":null,"contact_name":null,"phone_number":null,"fax":null,"email":null,"tax_id":"0515-070691-101-4","registration_number":"32575-9","single_identity_document_number":null,"commercial_trade":"SERVICIO DE BENEFICIO DE CAFÉ","frequent_number":null,"date_birth":null,"syncronized":0,"country_id":202,"taxpayer_classification_id":null,"payment_term_id":1,"organization_id":11,"created_at":"2018-03-08T22:41:58.000Z","updated_at":"2018-03-08T22:41:58.000Z","deleted_at":null}],"userId":1}';

console.log(JSON.parse(json));

function testSync()
{



	$.ajax(
	{
		type: 'POST',
		data: {},
		// data: JSON.stringify({'api_token': 'LCPaQAitIf8yl2HaRYaq7SbkSAuQdbNXMriYIjfK4p23eZ0WgdkZ0vUwqF2y', 'sale_point_id': '1'}),
		data: json,
		dataType : 'json',
		// url:  'http://app.decimaerp.com/sales/transactions/synchronize',
		url:  'http://localhost:8000/sales/transactions/synchronize',
		// url:  'http://localhost:8000/sales/transactions/sale-order-management/synchronize',
		error: function (jqXHR, textStatus, errorThrown)
		{
			$('#app-loader').addClass('hidden');
			enableAll();
			console.log('error');
			console.log(jqXHR);
			console.log(textStatus);
			console.log(errorThrown);
			// handleServerExceptions(jqXHR, 'acct-am-btn-toolbar', false);
		},
		beforeSend:function()
		{
			$('#app-loader').removeClass('hidden');
			disabledAll();
		},
		success:function(json)
		{
			console.log('hello');
			console.log(json);
			$('#app-loader').addClass('hidden');
			enableAll();
		}
	});
}
</script> -->
<!-- <div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-share"></i> {{ Lang::get('dashboard.shortcuts') }}</h3>
			</div>
			<div class="panel-body clearfix">
				<div class="row">
				  <div class="col-md-2">
						<button type="button" class="btn btn-default btn-block" style="white-space: normal;min-height:54px;" onclick="testSync();">
							<i class="fa fa-plus pull-left" style="font-size: 2.5em;width:20%;"></i>
							<span class="pull-left" style="width:70%;">Nueva partida contable</span>
						</button>
				  </div>
					<div class="col-md-2">
						<button type="button" class="btn btn-default btn-block" style="white-space: normal;min-height:54px;">
							<i class="fa fa-plus pull-left" style="font-size: 2.5em;width:20%;"></i>
							<span class="pull-left" style="width:70%;">Nueva partida contable</span>
						</button>
				  </div>
					<div class="col-md-2">
						<button type="button" class="btn btn-default btn-block" style="white-space: normal;min-height:54px;">
							<i class="fa fa-plus pull-left" style="font-size: 2.5em;width:20%;"></i>
							<span class="pull-left" style="width:70%;">Nueva partida contable</span>
						</button>
				  </div>
					<div class="col-md-2">
						<button type="button" class="btn btn-default btn-block" style="white-space: normal;min-height:54px;">
							<i class="fa fa-plus pull-left" style="font-size: 2.5em;width:20%;"></i>
							<span class="pull-left" style="width:70%;">Nueva partida contable</span>
						</button>
				  </div>
					<div class="col-md-2">
						<button type="button" class="btn btn-default btn-block" style="white-space: normal;min-height:54px;">
							<i class="fa fa-plus pull-left" style="font-size: 2.5em;width:20%;"></i>
							<span class="pull-left" style="width:70%;">Nueva partida contable</span>
						</button>
				  </div>
					<div class="col-md-2">
						<button type="button" class="btn btn-default btn-block" style="white-space: normal;min-height:54px;">
							<i class="fa fa-plus pull-left" style="font-size: 2.5em;width:20%;"></i>
							<span class="pull-left" style="width:70%;">Nueva partida contable</span>
						</button>
				  </div>
				</div>
				<div class="row" style="margin-top:10px;">
				  <div class="col-md-2">
						<button type="button" class="btn btn-default btn-block" style="white-space: normal;min-height:54px;">
							<i class="fa fa-plus pull-left" style="font-size: 2.5em;width:20%;"></i>
							<span class="pull-left" style="width:70%;">Nueva partida contable</span>
						</button>
				  </div>
					<div class="col-md-2">
						<button type="button" class="btn btn-default btn-block" style="white-space: normal;min-height:54px;">
							<i class="fa fa-plus pull-left" style="font-size: 2.5em;width:20%;"></i>
							<span class="pull-left" style="width:70%;">Nueva partida contable</span>
						</button>
				  </div>
					<div class="col-md-2">
						<button type="button" class="btn btn-default btn-block" style="white-space: normal;min-height:54px;">
							<i class="fa fa-plus pull-left" style="font-size: 2.5em;width:20%;"></i>
							<span class="pull-left" style="width:70%;">Nueva partida contable</span>
						</button>
				  </div>
					<div class="col-md-2">
						<button type="button" class="btn btn-default btn-block" style="white-space: normal;min-height:54px;">
							<i class="fa fa-plus pull-left" style="font-size: 2.5em;width:20%;"></i>
							<span class="pull-left" style="width:70%;">Nueva partida contable</span>
						</button>
				  </div>
					<div class="col-md-2">
						<button type="button" class="btn btn-default btn-block" style="white-space: normal;min-height:54px;">
							<i class="fa fa-plus pull-left" style="font-size: 2.5em;width:20%;"></i>
							<span class="pull-left" style="width:70%;">Nueva partida contable</span>
						</button>
				  </div>
					<div class="col-md-2">
						<button type="button" class="btn btn-default btn-block" style="white-space: normal;min-height:54px;">
							<i class="fa fa-plus pull-left" style="font-size: 2.5em;width:20%;"></i>
							<span class="pull-left" style="width:70%;">Nueva partida contable</span>
						</button>
				  </div>
				</div>
			</div>
		</div>
	</div>
</div> -->
<div class="row">
	{!! Form::journals('da-', $appInfo['id'], true, '', '', true, Lang::get('dashboard.journalLegend'), $organizationJournals) !!}
</div>
@parent
@stop
