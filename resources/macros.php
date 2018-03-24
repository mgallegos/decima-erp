<?php
/**
 * @file
 * Custom Laravel macros.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

Form::macro('autocomplete', function($inputTextAutocompleteName, $source = array(), $options = array(), $inputTextLabelName=null, $inputTextValueName=null, $value = null, $prefixIcon = null, $inputGroupSizeClass = '', $limitResourceTo = null, $btnClass = 'btn-default', $bootstrapVersion = '3')
{
	$autocompleteEvent = $autocompleteFocusEvent = $prefix = '';
	$autocompleteWidgetName = 'autocomplete';

	if (!isset($options['name']))
	{
		$options['name'] = $inputTextAutocompleteName;
	}

	if (isset($inputTextLabelName))
	{
		$autocompleteFocusEvent .= "$('#$inputTextLabelName').val( ui.item.label );";
		$autocompleteEvent .=" $('#$inputTextLabelName').val( ui.item.label );";
	}

	if (isset($inputTextValueName))
	{
		$autocompleteEvent .= "$('#$inputTextValueName').val( ui.item.value );";
		$options['data-autocomplete-value-name'] = $inputTextValueName;
	}

	if (isset($inputTextLabelName) || isset($inputTextValueName))
	{
		$autocompleteEvent=",focus: function( event, ui ) { $autocompleteFocusEvent return false;},select: function( event, ui ) { $autocompleteEvent return false;}";
	}

	if(!empty($source) && is_array($source[0]) && array_key_exists('category',$source[0]))
	{
		$autocompleteWidgetName='categoryautocomplete';
	}

	if (!empty($value))
	{
		$options['value'] = $value;
	}

	if(!is_null($prefixIcon))
	{
		$prefix = '<span class="input-group-addon">
				      <i class="fa '. $prefixIcon . '"></i>
				   </span>';
	}

	$options['id'] = $inputTextAutocompleteName;
	$options['type'] = 'text';
	$options['data-autocomplete-select-event'] = 0;
	$options['data-mg-custom-validator'] = 'jqMgValAutocompleteValidator';

	$inputTextAutocompleteName = camel_case($inputTextAutocompleteName);

	if(!empty($limitResourceTo))
	{
		$autocompleteSource = '
			function(request, response)
			{
  			var results = $.ui.autocomplete.filter(' . $inputTextAutocompleteName . 'ArrayData, request.term);
				response(results.slice(0, ' . $limitResourceTo . '));
    	}
		';

		$options['data-autocomplete-source'] = $inputTextAutocompleteName .'ArrayData';
	}
	else
	{
		$autocompleteSource = $inputTextAutocompleteName .'ArrayData';
	}

	$searchEvent = '
		function(e,ui)
		{
			$(this).data("ui-autocomplete").menu.bindings = $();
		}
	';

	if($bootstrapVersion == '3')
	{
		$inputGroupClass = 'input-group-btn';
	}
	else if($bootstrapVersion == '4')
	{
		$inputGroupClass = 'input-group-append';
	}

	FormJavascript::setCode('$("#'. $options['id'] .'").' . $autocompleteWidgetName . '({ minLength: 0, search: '. $searchEvent . ', source: '. $autocompleteSource . $autocompleteEvent . '}); $("#'.  $options['id'] . '-show-all-button").click(function(){ $("#' . $options['id'] .'").autocomplete( "search", "" ); $("#' . $options['id'] .'").focus(); });');
	FormJavascript::setGlobalCode('var '. $inputTextAutocompleteName . 'ArrayData = ' . json_encode($source) . ';');

	return '<div class="input-group ' . $inputGroupSizeClass . '">
				' . $prefix . '
				<input'.Html::attributes($options).'>
				<span class="' . $inputGroupClass . '">
					<button id="' . $options['id'] . '-show-all-button" class="btn ' . $btnClass . '" type="button">
						<i class="fa fa-caret-down"></i>
					</button>
				</span>
			</div>';

});

Form::macro('textareacustom', function($name, $rows, $maxLength, $options = array(), $value = '')
{
	if ( ! isset($options['name']))
  {
		$options['name'] = $name;
	}

	$options['id'] = $name;
	$options['rows'] = $rows;
	$options['maxlength'] = $maxLength;

	FormJavascript::setCode("$('#".$options['id']."').keyup(function(){ $('#".$options['id']."-label').html('".Lang::get('form.charactersAvailable')."'+' '+($maxLength-$('#".$options['id']."').val().length));});");

	return '<textarea'.Html::attributes($options).'>'. $value . '</textarea><div id="'.$options['id'].'-label-container" class="clearfix"><p id="'.$options['id'].'-label" class="help-block">'.Lang::get('form.charactersAvailable').' '.$maxLength.'</p></div>';
});

Form::macro('money', function($name, $options = array(), $value = null, $showCalculator = true, $precision = 2)
{
	if ( ! isset($options['name']))
  {
		$options['name'] = $name;
	}

	$options['id'] = $name;
	$options['type'] = 'text';
	//$options['regex'] = Regex::getMoney();
	$options['data-mg-validator'] = 'money' . $precision;
	$options['value'] = $value;
	$calcultorHtml = '';

	if($showCalculator)
	{
		FormJavascript::setCode("$('#".$options['id']."-calculator').click(function(){ $('#".$options['id']."').calculator({precision:$precision, useThemeRoller: true, onOpen: function(value, inst) { $(this).val($.isNumeric(value.replace(/,/g,''))?value.replace(/,/g,''):'0.00');},onClose: function(value, inst) { $( '#".$options['id']."' ).focusout(); $( '#".$options['id']."-calculator' ).focus(); $( '#".$options['id']."' ).calculator('destroy') }}); $('#".$options['id']."').calculator('show');});");
		$calcultorHtml = '
			<span class="input-group-btn">
			<button id="' . $options['id'] . '-calculator" class="btn btn-default" type="button">
				<i class="fa fa-keyboard-o"></i>
			</button>
			</span>
		';
	}

	return '<div class="input-group">
				<span class="input-group-addon">' . OrganizationManager::getOrganizationCurrencySymbol() . '</span>
				<input' . Html::attributes($options) . '>
				' . $calcultorHtml . '
			</div>';
});

Form::macro('date', function($name, $options = array(), $value = null, $btnClass = 'btn-default', $bootstrapVersion = '3')
{
	if ( ! isset($options['name']))
  {
		$options['name'] = $name;
	}
	if ( !isset($options['placeholder']))
  {
		$options['placeholder'] = Lang::get('form.dateFormat');
	}

	if(!empty($value))
	{
		$options['value'] = $value;
	}

	$options['id'] = $name;
	$options['type'] = 'text';
	$options['data-mg-validator'] = 'date';
	//$options['regex'] = Regex::getDate();
	$options['maxlength'] = 10;

	if($bootstrapVersion == '3')
	{
		$inputGroupClass = 'input-group-btn';
	}
	else if($bootstrapVersion == '4')
	{
		$inputGroupClass = 'input-group-append';
	}

	FormJavascript::setCode("$('#".$options['id']."').datepicker({changeMonth: true, changeYear: true,onClose: function(selectedDate) { $( '#".$options['id']."' ).focusout(); $( '#".$options['id']."-calendar-button' ).focus(); }});$('#".$options['id']."').unbind('focus');$('#".$options['id']."').unbind('keypress');$('#".$options['id']."').mask('99/99/9999');$('#".$options['id']."').unbind('blur');$('#".$options['id']."-calendar-button').click(function(){ $('#".$options['id']."').datepicker('show');});");

	return '<div class="input-group">
				<input'.Html::attributes($options).'>
				<span class="' . $inputGroupClass . '">
					<button id="'.$options['id'].'-calendar-button" class="btn ' . $btnClass . '" type="button">
						<i class="fa fa-calendar-o"></i>
					</button>
				</span>
			</div>';
});

Form::macro('datetime', function($name, $options = array(), $value = null, $btnClass = 'btn-default', $bootstrapVersion = '3')
{
	if ( ! isset($options['name']))
  {
		$options['name'] = $name;
	}
	if ( !isset($options['placeholder']))
  {
		$options['placeholder'] = Lang::get('form.dateTimePlaceHolder');
	}

	if(!empty($value))
	{
		$options['value'] = $value;
	}

	$options['id'] = $name;
	$options['type'] = 'text';
	$options['data-mg-validator'] = 'datetime';
	//$options['regex'] = Regex::getDate();
	$options['maxlength'] = 10;

	if($bootstrapVersion == '3')
	{
		$inputGroupClass = 'input-group-btn';
	}
	else if($bootstrapVersion == '4')
	{
		$inputGroupClass = 'input-group-append';
	}

	// FormJavascript::setCode("$('#".$options['id']."').datetimepicker({timeFormat: 'hh:mm tt', changeMonth: true, changeYear: true, onClose: function(selectedDate) { $( '#".$options['id']."' ).focusout(); $( '#".$options['id']."-calendar-button' ).focus(); }});$('#".$options['id']."').unbind('focus');$('#".$options['id']."').unbind('keypress');$('#".$options['id']."').mask('99/99/9999');$('#".$options['id']."').unbind('blur');$('#".$options['id']."-calendar-button').click(function(){ $('#".$options['id']."').datetimepicker('show');});");
	FormJavascript::setCode("$('#".$options['id']."').datetimepicker({timeFormat: $.timepicker._defaults.timeFormat, changeMonth: true, changeYear: true, onClose: function(selectedDate) { $( '#".$options['id']."' ).focusout(); $( '#".$options['id']."-calendar-button' ).focus(); }});  $('#".$options['id']."').unbind('focus'); $('#".$options['id']."').unbind('keypress');  $('#".$options['id']."').mask('99/99/9999 99:99 **');$('#".$options['id']."').unbind('blur');$('#".$options['id']."-calendar-button').click(function(){ $('#".$options['id']."').datetimepicker('show');});");

	return '<div class="input-group">
				<input'.Html::attributes($options).'>
				<span class="' . $inputGroupClass . '">
					<button id="'.$options['id'].'-calendar-button" class="btn ' . $btnClass . '" type="button">
						<i class="fa fa-calendar-o"></i>
					</button>
				</span>
			</div>';
});


Form::macro('daterange', function($nameFrom, $nameTo, $options = array(), $valueFrom = null, $valueTo = null)
{
	$options['type'] = 'text';
	//$options['regex'] = Regex::getDate();
	$options['data-mg-validator'] = 'date';
	$options['data-mg-daterange'] = 'from';
	$options['maxlength'] = 10;

	if (!isset($options['nameFrom']))
  {
		$options['name'] = $nameFrom;
	}

	$options['id'] = $nameFrom;

	if (isset($options['placeholderfrom']))
  {
		$options['placeholder'] = $options['placeholderfrom'];
	}
	else
  {
		$options['placeholder'] = Lang::get('form.dateFormat');
	}

	FormJavascript::setCode("$('#".$options['id']."').datepicker({changeMonth: true, changeYear: true,onClose: function(selectedDate) { $( '#$nameTo' ).focus(); }}); $('#".$options['id']."').unbind('focus');$('#".$options['id']."').unbind('keypress');$('#".$options['id']."').mask('99/99/9999');$('#".$options['id']."-calendar-button').click(function(){ $('#".$options['id']."').datepicker('show');});");

	if(!empty($valueFrom))
	{
		$options['value'] = $valueFrom;
	}

	$inputFrom = Html::attributes($options);

	$options['data-mg-daterange'] = "to";

	if (isset($options['placeholderfrom']))
  {
		unset($options['placeholder']);
	}

	if (isset($options['value']))
  {
		unset($options['value']);
	}

	if (isset($options['placeholderto']))
  {
		$options['placeholder'] = $options['placeholderto'];
	}

	else
  {
		$options['placeholder'] = Lang::get('form.dateFormat');
	}

	if (! isset($options['nameTo'])) {
		$options['name'] = $nameTo;
	}

	$options['id'] = $nameTo;

	FormJavascript::setCode("$('#".$options['id']."').datepicker({changeMonth: true, changeYear: true,onClose: function(selectedDate) { $( '#$nameTo' ).focusout(); $( '#".$options['id']."-calendar-button' ).focus(); }});$('#".$options['id']."').unbind('focus');$('#".$options['id']."').unbind('keypress');$('#".$options['id']."').mask('99/99/9999');$('#".$options['id']."-calendar-button').click(function(){ $('#".$options['id']."').datepicker('show');});");

	if(!empty($valueTo))
	{
		$options['value'] = $valueTo;
	}

	$inputTo = Html::attributes($options);

	return '<div class="input-group">
				<span class="input-group-addon">
					' . Lang::get('form.dateRangeFrom') . '
				</span>
				<input' . $inputFrom . '>
				<span class="input-group-btn">
					<button id="' . $nameFrom . '-calendar-button" class="btn btn-default" type="button">
						<i class="fa fa-calendar-o"></i>
					</button>
				</span>
				<span class="input-group-addon">
					' . Lang::get('form.dateRangeTo') . '
				</span>
				<input' . $inputTo . '>
				<span class="input-group-btn">
					<button id="' . $nameTo . '-calendar-button" class="btn btn-default" type="button">
						<i class="fa fa-calendar-o"></i>
					</button>
				</span>
			</div>';
});

Form::macro('journals', function($appPrefix, $appId, $twoColumns = true, $userId = '', $journalizedId = '', $onlyActions = '', $journalLengend = null, $journals = null, $organizationNotNull = true)
{
	$journalsHtml = '';

	$journalCounter = 0;

  $pagerRecordsInfo = Lang::get('journal.pagerRecordsInfo', array('start' => 0, 'end' => 0, 'records' => 0));

  $pagerPagesInfo = Lang::get('journal.pagerPagesInfo', array('start' => 0, 'end' => 0));

  if(empty($journalLengend))
  {
    $journalLengend = Lang::get('journal.lengend');
  }

	if(empty($journals))
  {
    $journals = array('totalPages' => 1, 'pageRecords' => 2, 'journalHeaders' => array());
  }

  if(!isset($journals['pagerRecordsInfo']))
  {
    $journals['pagerRecordsInfo'] = $pagerRecordsInfo;
  }

  if(!isset($journals['pagerPagesInfo']))
  {
    $journals['pagerPagesInfo'] = $pagerPagesInfo;
  }

	if($twoColumns)
	{
		$journalsPerColumn = round($journals['pageRecords']/2);

		$columnClass = 'col-lg-6 col-md-6';

		$pagerClass = 'col-lg-6 col-lg-offset-3';

		$pagerRecordsClass = 'col-lg-3';

		$journalSearchWidth = '25%';
	}
	else
	{
		$journalsPerColumn = $journals['pageRecords'];

		$columnClass = 'col-lg-12 col-md-12';

		$pagerClass = 'col-lg-7 journal-pager';

		$pagerRecordsClass = 'col-lg-4 col-lg-offset-1';

		$journalSearchWidth = '50%';
	}

	$journalsHtml .= "<div class='$columnClass'>";

	foreach ($journals['journalHeaders'] as $key => $journalHeader)
	{
		$journalCounter++;

		$journalsHtml .= "<div class='journal-header clearfix'>
								<img class='img-circle pull-left' onerror='this.src=\"" . asset('assets/kwaai/images/anonymous.png') ."\"' src='" . $journalHeader['userImageSource'] . "'></img>
								<h5 class='journal-header-lengend pull-left'>" . $journalHeader['formattedHeader']  . "</h5>
						  </div>
						  <ul>
					 	 ";

		foreach ($journalHeader['journalDetails'] as $key => $journalDetail)
		{
			$journalsHtml .= "<li>$journalDetail</li>";
		}

		$journalsHtml .= "</ul>";

		if(($journalCounter == $journalsPerColumn) && $twoColumns)
		{
			$journalsHtml .= '</div>';

			$journalsHtml .= "<div class='$columnClass'>";
		}
	}

	$journalsHtml .= '</div>';

	FormJavascript::setCode('$("#'.  $appPrefix . 'journal-search").onEnter(function(){ getAppJournals(\'' . $appPrefix . '\', "firstPage"); });$("#'.  $appPrefix . 'journal-search").focusout(function(){ if($(this).isEmpty()){ getAppJournals(\'' . $appPrefix . '\', "firstPage"); } });');

	return "<div id='" . $appPrefix . "journals' class='col-lg-12 col-md-12' data-app-id='" . $appId . "' data-page='1' data-total-pages='" . $journals['totalPages'] . "' data-journalized-id='" . $journalizedId . "' data-action-by='" . $userId . "' data-only-actions='" . $onlyActions . "' data-organization-not-null='" . $organizationNotNull . "' data-two-columns='" . $twoColumns . "' data-pager-records-info='" . $pagerRecordsInfo ."' data-pager-pages-info='" . $pagerPagesInfo ."'>
				<div class='panel panel-default journal-panel'>
					<div class='panel-heading panel-heading-journal clearfix'>
		    			<h3 class='panel-title pull-left' style='margin-top:6px'>
		    				<i class='fa fa-history'></i> " . $journalLengend . "
		    			</h3>
		    			<fieldset id='" . $appPrefix . "journal-fieldset' " . ($journalCounter == 0?"disabled='disabled'":"") .">
							<div class='input-group input-group-sm pull-right' style='width:" . $journalSearchWidth . "'>
								<input id='" . $appPrefix . "journal-search' type='text' class='form-control' placeholder='" . Lang::get('journal.searchWebSitePlaceHolder') . "'>
								<span class='input-group-btn'>
									<button class='btn btn-default' type='button' onclick=\"getAppJournals('" . $appPrefix . "', 'firstPage');\">
										<i class='fa fa-search'></i>
									</button>
								</span>
			              	</div>
						</fieldset>
		  			</div>
		  			<div class='panel-body'>
		  				<div id='" . $appPrefix . "journals-body' class='row'>
		  					" . $journalsHtml . "
		  				</div>
		  			</div>
		  			<div class='panel-footer journal-panel-footer'>
              <div class='row'>
  		  				<div class='" . $pagerClass . " journal-pager'>
                  <div class='btn-group'>
                    <button id='" . $appPrefix . "step-backward' class='btn btn-default' disabled='disabled' onclick=\"getAppJournals('" . $appPrefix . "', 'firstPage');\">
                      <i class='fa fa-step-backward'></i>
                    </button>
                    <button id='" . $appPrefix . "backward' class='btn btn-default' disabled='disabled' onclick=\"getAppJournals('" . $appPrefix . "', 'previousPage');\">
                      <i class='fa fa-backward'></i>
                    </button>
                    <button id='" . $appPrefix . "pager-pages-info' class='btn btn-default journal-pager-pages-info' disabled='disabled'>
                      " . $journals['pagerPagesInfo'] . "
                    </button>
                    <button id='" . $appPrefix . "forward' class='btn btn-default' ". ($journals['totalPages'] > 1?"":"disabled='disabled'") . "onclick=\"getAppJournals('" . $appPrefix . "', 'nextPage');\">
                      <i class='fa fa-forward'></i>
                    </button>
                    <button id='" . $appPrefix . "step-forward' class='btn btn-default' " . ($journals['totalPages'] > 1?"":"disabled='disabled'") . " onclick=\"getAppJournals('" . $appPrefix . "', 'lastPage');\">
                      <i class='fa fa-step-forward'></i>
                    </button>
                  </div>
  			        </div>
                <div class='" . $pagerRecordsClass . "'>
                      <h5 id='" . $appPrefix . "pager-records-info' class='pull-right'>" . $journals['pagerRecordsInfo'] . "</h5>
                </div>
              </div>
	  				</div>
  				</div>
  			</div>
			";
});

Form::macro('imageuploader', function($name, $options = array(), $appPrefix, $folder, $minWidth = '""', $sameWidthAsHeight = '""', $sizes = '[]', $isPublic = true, $flag = null, $value = null, $prefixIcon = 'fa-link', $inputGroupSizeClass = '')
{
	$prefix = '';

	if (!isset($options['name']))
	{
		$options['name'] = $name;
	}

	if (empty($flag))
	{
		$flag = $name;
	}

	if (!empty($value))
	{
		$options['value'] = $value;
	}

	if ($isPublic)
	{
		$isPublic = 'true';
	}
	else
	{
		$isPublic = 'false';
	}

	if(!empty($prefixIcon))
	{
		$prefix = '<span class="input-group-addon">
				      <i class="fa '. $prefixIcon . '"></i>
				   </span>';
	}

	$options['id'] = $name;
	$options['type'] = 'text';

	$name = camel_case($name);


	FormJavascript::setCode('$("#'.  $options['id'] . '-uploader").click(function(){ $("#' . $appPrefix .'file-uploader-modal").attr("data-flag", "' . $flag .'"); openUploader("' . $appPrefix .'", "", "' . $folder .'", ["image"], ' . $minWidth .', ' . $sameWidthAsHeight .', ' . $sizes .', 1, ' . $isPublic .'); });');
	// FormJavascript::setCode('$("#'. $options['id'] .'").' . $autocompleteWidgetName . '({ minLength: 0, source: '. $autocompleteSource . $autocompleteEvent . '}); $("#'.  $options['id'] . '-show-all-button").click(function(){ $("#' . $options['id'] .'").autocomplete( "search", "" ); $("#' . $options['id'] .'").focus(); });');
	// FormJavascript::setGlobalCode('var '. $name . 'ArrayData = ' . json_encode($source) . ';');

	return '<div class="input-group ' . $inputGroupSizeClass . '">
				' . $prefix . '
				<input'.Html::attributes($options).'>
				<span class="input-group-btn">
					<button id="' . $options['id'] . '-uploader" class="btn btn-default" type="button">
						<i class="fa fa-upload"></i>
					</button>
				</span>
			</div>';
});
