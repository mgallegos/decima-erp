{{--
 * @file
 * User activation email.
 *
 * All DecimaERP code is copyright by the original authors and released under the GNU Aferro General Public License version 3 (AGPLv3) or later.
 * See COPYRIGHT and LICENSE.
 --}}
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<p>{{ Lang::get('security/reminders.emailLine1', ['addressee' => $addressee]) }}</p>
		<p></p>
		<p>{{ Lang::get('security/user-activation.emailLine2', ['sender' => $sender, 'url' => URL::to('/')]) }}</p>
		<p></p>
		<p>{{ Lang::get('security/user-activation.emailLine3') }}</p>
		<p></p>
		<p>{{ URL::to('user-activation', array($token)) }}</p>
		<p></p>
		<p>{{ Lang::get('security/reminders.emailLine4') }}</p>						
	</body>
</html>