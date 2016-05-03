<?php
/**
 * @file
 * Password reminder page and email language lines.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 */

return array(

	/*
	|--------------------------------------------------------------------------
	| Password Reminder Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines are the default lines which match reasons
	| that are given by the password broker for a password update attempt
	| has failed, such as for an invalid token or invalid new password.
	|
	*/

	'formTitle' => 'Restablecer contraseña',

	'emailPlaceHolder' => 'Digite aqui su correo electónico', //Enter your email here

	'passwordPlaceHolder' => 'Digite aqui su nueva contraseña',

	'confirmPasswordPlaceHolder' => 'Confirmar nueva contraseña',

	'sendButton' => 'Enviar',

	'resetButton' => 'Restablecer',

	'emailSubject' => '[:systemName] Restablecimiento de contraseña :datetime',

	'emailLine1' => 'Estimado :addressee,', //Dear :addressee

	'emailLine2' => 'Usted ha solicitado restablecer la contraseña para su cuenta en :url', //You have requested to have your password reset for your account at DecimaERP.com

	'emailLine3' => 'Por favor visite el siguiente enlace para restablecer su contraseña:', //Please visit this URL to reset your password:

	'emailLine4' => 'Si ha recibido este correo por error, haga caso omiso de este mensaje.', //If you received this email in error, you can safely ignore this message.	
);
