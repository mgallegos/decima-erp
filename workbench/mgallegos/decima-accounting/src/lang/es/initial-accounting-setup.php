<?php
/**
 * @file
 * Form Language Lines.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

return array(

	'formTitle' => 'Configuración inicial de la contabilidad',

	'action' => 'Realizar la configuración inicial de su contabilidad.',

	'initialSettingMessage' => 'Una vez realizada la configuración inicial ya no se podrá modificar el "Año fiscal inicial" y el "Catálogo de cuentas", si se podrán modificar los campos "Numerar partidas por", "Crear periodo de apertura" y "Crear periodo de cierre" sin embargo estos dos últimos sus cambios tendrán efecto hasta en el proceso de cierre del año ya que será hasta ese momento cuando se creen los nuevos periodos contables del año siguiente.',

	'update' => 'Actualizar configuración',

	'initialYear' => 'Año fiscal inicial',

	'initialYearHelperText' => 'Se crearán todos los periodos contables para el año fiscal seleccionado.',

	'accountChartType' => 'Catálogo de cuentas',

	'accountChartTypeHelperText' => 'Todas las opciones, excepto la opción "Personalizado" crearán para su organización el catálogo de cuentas seleccionado.',

	'accountChartTypeLink' => '(clic aquí para ver el catálogo)',

	'voucherNumerationType' => 'Numerar partidas por',

	'P' => 'Periodo',

	'V' => 'Periodo y Tipo de Partida',

	'createOpeningPeriod' => 'Crear periodo de apertura',

	'createOpeningPeriodHelperText' => 'Si selecciona esta opción se creará un periodo previo al periodo correspondiente al mes de enero.',

	'createClosingPeriod' => 'Crear periodo de cierre',

	'createClosingPeriodHelperText' => 'Si selecciona esta opción se creará un periodo posterior al periodo correspondiente al mes de diciembre.',

	'successUpdateMessage' => 'La configuración contable se ha actualizado exitosamente.',

	'accountTypeAddedJournal' => 'Se agregó el tipo de cuenta ":type" en el sistema.',

	'accountTypeSettingAddedJournal' => 'Se agregaron los tipos de cuenta por defecto en el sistema.',

	'voucherTypeAddedJournal' => 'Se agregó el tipo de partida ":type" en el sistema.',

	'voucherTypeSettingAddedJournal' => 'Se agregaron los tipos de partida en el sistema.',

	'fiscalYearAddedJournal' => 'Se agregó el año fiscal ":year" en el sistema.',

	'periodAddedJournal' => 'Se agregó el periodo contable ":period" en el sistema.',

	'periodAddedSettingJournal' => 'Se agregaron los periodo contables en el sistema.',

	'costCenterAddedJournal' => 'Se agregó el centro de costo ":costCenter" en el sistema.',

	'costCenterAddedSettingJournal' => 'Se agregaron los centros de costo por defecto en el sistema.',

	'accountAddedJournal' => 'Se agregó la cuenta contable ":account" en el sistema.',

	'accountAddedSettingJournal' => 'Se agregaron las cuentas contables del cátalogo :catalog en el sistema.',
);
