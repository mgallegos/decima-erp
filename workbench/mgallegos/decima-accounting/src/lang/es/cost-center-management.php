<?php
/**
 * @file
 * Form Language Lines.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

return array(

	'main' => 'Principal',

	'new' => 'Nueva centro',

	'edit' => 'Editar centro',

	'delete' => 'Eliminar centro',

	'save' => 'Guardar centro',

	'gridTitle' => 'Catálogo de centros',

	'formNewTitle' => 'Creación de Centro de Costo',

	'formEditTitle' => 'Edición de Centro de Costo Existente',

	'parentCc' => 'Centro Padre',

	'isGroupLong' => 'Agrupa centros',

	'isGroupHelperText' => 'Otros centros pueden crearse debajo de los centros que sí agrupan, pero en las partidas contables solo pueden utilizarse las centros que no agrupan.',

	'deleteMessageConfirmation' => '¿Está seguro que desea eliminar el centro ":cc"? Si el centro agrupa otros centros, estos también serán eliminadas.',

	'ccDeletedJournal' => 'Se eliminó el centro ":cc"',

	'isGroupException' => 'El centro agrupa a otras centros, por lo que no puede pasar a ser un centro que no agrupa.',

	'invalidParentValidation' => 'Un centro no puede ser padre de sí mismo.',

	'costCenterValidationMessage' => 'Los centros no pueden eliminarse, el centro seleccionada o uno de los centros a los que agrupa, tienen partidas contables asociadas.',

	'keyValidationMessage' => 'Ya existe un centro de costo en el sistema con código ":key".',

	'editHelpText' => 'Para editar datos de un centro de costo, seleccione el centro en la tabla y haga clic en el botón "Editar".',

	'deleteHelpText' => 'Para eliminar un centro de costo, seleccione el centro en la tabla y haga clic en el botón "Eliminar".',
);
