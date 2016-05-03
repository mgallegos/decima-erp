<?php
/**
 * @file
 * User Management language lines.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

return array(

  'appName' => 'Gestión de usuarios',

	'gridMode' => 'Modo del grid',

	'gridUserMode' => 'Mostrar usuarios de la organización',

	'gridAdminUserMode' => 'Mostrar usuarios gestores de organizaciones',

	'new' => 'Agregar un nuevo usuario en la organización',

	'newAdmin' => 'Nuevo gestor',

	'newAdminLongText' => 'Agregar un nuevo usuario gestor de organizaciones',

	'preview' => 'Vista previa',

	'previewLongText' => 'Vista previa del menú del usuario',

	'edit' => 'Editar usuario',

	'save' => 'Guardar usuario',

	'deleteLongText' => 'Remover usuario de la organización',

  'deleteNonAdminLongText' => 'Remover privilegios de usuario gestor de organizaciones',

  'deleteHelpText' => 'Para remover un usuario de la organización, seleccione al usuario en la tabla y haga clic en el botón "Remover".',

  'assignHelpText' => 'Seleccione al usuario en la tabla y utilice los controles ubicados debajo de la tabla para asignarle roles y permisos.',

  'unassignHelpText' => 'Seleccione al usuario en la tabla y utilice los controles ubicados debajo de la tabla para desasignarle roles y permisos.',

	'reset' => 'Deshacer los cambios realizados',

	'gridUsersTitle' => 'Modo del grid: usuarios de la organización :organization',

	'gridAdminUsersTitle' => 'Modo del grid: usuarios gestores de organizaciones',

	'rolesTitle' => 'Roles del usuario',

	'permissionsTitles' => 'Permisos del usuario',

	'module' => 'Módulo',

	'menuOption' => 'Aplicación (opción de menú)',

	'menuOptionsTitles' => 'Aplicaciones del usuario',

	'firstname' => 'Nombre',

	'lastname' => 'Apellido',

	'timezone' => 'Zona horaria',

	'email' => 'Correo electrónico',

	'password' => 'Contraseña',

	'confirmPassword' => 'Confirmar contraseña',

	'isActive' => 'Activo',

  '1' => 'Sí',

  '0' => 'No',

	'isLocked' => 'Bloqueado',

	'sendEmail' => 'Activar usuario por correo electrónico',

	'createdBy' => 'Creado por',

  'defaultOrganization' => 'Organización predeterminada',

  'defaultOrganizationHelpText' => 'La organización predeterminada es la que se selecciona automáticamente al iniciar sesión.',

	'organizationOwnerInfoMessage' => 'El usuario :email es el dueño de la organización, por defecto el dueño de la organización tiene todos los permisos y no puede ser modificado o eliminado.',

	'userCreatedByInfoMessage' => 'No puede editar la información de un usuario que no haya sido creado por usted.',

	'invalidEmailInfoMessage' => 'El correo electrónico no es un correo válido.',

	'passwordsDoNotMatchInfoMessage' => 'Las contraseñas no coinciden.',

	'passwordsMinLengthInfoMessage' => 'La contraseña debe contener al menos 6 caracteres',

	'formNewAdminInfoMessage' => 'Los usuarios gestores de organizaciones son los únicos que pueden agregar nuevas organizaciones y además pueden crear otros nuevos usuarios gestores de organizaciones.',

	'formNewAdminTitle' => 'Creación de Usuario Gestor de Organizaciones',

	'formNewTitle' => 'Creación de Usuario en la Organización',

	'formEditTitle' => 'Edición de Usuario Existente',

	'formNewpasswordHelperText' => 'Si no se especifica una contraseña, el sistema la generará aleatoriamente.',

	'formEditpasswordHelperText' => 'Si se especifica una contraseña, se subtituira la contraseña actual.',

	'successSaveMessage' => 'El registro se ha guardado exitosamente, ya puede proceder ha asignarle al usuario las aplicaciones y permisos que estime convenientes.',

	'successAddedUserToOrganizationMessage' => 'El usuario se ha agregado a la organización exitosamente, ya puede proceder ha asignarle al usuario las aplicaciones y permisos que estime convenientes.',

	'successDeletedUserMessage' => 'El usuario ha sido removido de la organización exitosamente',

	'successDeletedUsersMessage' => 'Los usuarios han sido removidos de la organización exitosamente',

  'successNonAdminUserMessage' => 'Se le removieron los privilegios de usuario gestor de organizaciones al usuario exitosamente.',

	'successNonAdminUsersMessage' => 'Se le removieron los privilegios de usuario gestor de organizaciones a los usuarios exitosamente',

	'nonAdminException' => 'Usted no tiene los permisos necesarios para agregar a un usuario gestor de organizaciones.',

	'rootException' => 'No es posible eliminar a un usuario root.',

	'userAlreadyInOrganizationException' => 'El usuario :email ya forma parte de la organización :organization.',

	'UserExistsException' => 'Ya existe un usuario registrado en el sistema con este correo electrónico.',

	'userAlreadyAdminException' => 'El usuario :email ya es un usuario gestor de organizaciones.',

	'noAppsException' => 'El usuario no tiene asignada ninguna aplicación.',

	'questionToAssociateUser' => 'El usuario :email ya se encuentra registrado en el sistema.<br>¿Desea agregarlo en la organización :organization?<br>',

	'questionToSetUserAsAdmin' => 'El usuario :email ya se encuentra registrado en el sistema.<br>¿Desea que el usuario sea un usuario gestor de organizaciones?<br>',

	'userAddedSystemJournal' => 'Se agregó a :email como usuario en el sistema.',

  'userAddedJournal' => 'Se agregó a :email en la organización :organization.',

  'adminUserAddedJournal' => 'Se agregó a :email como usuario gestor de organizaciones.',

  'nonAdminUserAddedJournal' => 'Se le removieron los privilegios de usuario gestor de organizaciones a :email',

  'userDeletedJournal' => 'Se removió a :email de la organización ":organization".',

  'userDeactivatedJournal' => 'Se desactivó a :email del sistema',

  'rolAssignedJournal' => 'Se asignó el rol ":rol" a :email.',

  'rolUnassignedJournal' => 'Se desasignó el rol ":rol" a :email.',

  'appAssignedJournal' => 'Se asignó la aplicación ":app" a :email.',

  'appUnassignedJournal' => 'Se desasignó la aplicación ":app" a :email.',

  'permissionAssignedJournal' => 'Se asignó el permiso ":permission" a :email.',

  'permissionUnassignedJournal' => 'Se desasignó el permiso ":permission" a :email.',

  'appsResttedJournal' => 'Se han deshecho las asignaciones y desasignaciones de aplicaciones realizadas a :email.',

);
