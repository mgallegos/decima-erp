<?php
/**
 * @file
 * Form Language Lines.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

return array(

	'new' => 'Nueva cuenta',

	'edit' => 'Editar cuenta',

	'delete' => 'Eliminar cuenta',

	'save' => 'Guardar cuenta',

	'gridTitle' => 'Catálogo de cuentas',

	'formNewTitle' => 'Creación de Cuenta Contable',

	'formEditTitle' => 'Edición de Cuenta Contable Existente',

	'key' => 'Código',

	'name' => 'Nombre',

	'parentAccount' => 'Cuenta Padre',

	'balanceType' => 'Tipo de Balance',

	'balanceTypeText' => 'D:Deudor;A:Acreedor',

	'D' => 'Deudor',

	'A' => 'Acreedor',

	'0' => 'No agrupa',

	'1' => 'Si agrupa',

	'accountType' => 'Tipo de Cuenta',

	'isGroup' => 'Agrupa',

	'isGroupLong' => 'Agrupa cuentas',

	'isGroupHelperText' => 'Otras cuentas pueden crearse debajo de las cuentas que sí agrupan, pero en las partidas contables solo pueden utilizarse las cuentas que no agrupan.',

	'deleteMessageConfirmation' => '¿Está seguro que desea eliminar la cuenta ":account"? Si la cuenta agrupa otras cuentas, estas también serán eliminadas.',

	'accountDeletedAccount' => 'Se eliminó la cuenta contable ":account"',

	'isGroupException' => 'La cuenta agrupa a otras cuentas, por lo que no puede pasar a ser una cuenta que no agrupa.',

	'invalidParentValidation' => 'Una cuenta no puede ser padre de sí misma.',

	'accountValidationMessage' => 'Las cuentas no pueden eliminarse, la cuenta seleccionada o una de las cuenta a las que agrupa, tienen partidas contables asociadas.',

	'keyValidationMessage' => 'Ya existe una cuenta en el sistema con código ":key".',

	'editHelpText' => 'Para editar datos de una cuenta contable, seleccione la cuenta en la tabla y haga clic en el botón "Editar".',

	'deleteHelpText' => 'Para eliminar una cuenta contable, seleccione la cuenta en la tabla y haga clic en el botón "Eliminar".',
);
