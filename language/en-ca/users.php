<?
// public function doUploadAvatar()
$lang['doUploadAvatar']['success']['default'] 	= 'Your avatar was successfully uploaded';
$lang['doUploadAvatar']['failure']['notMoved'] 	= 'Your avatar was successfully uploaded, however, it could not be moved to the correct destination. Please contact your system administrator as soon as possible.';
$lang['doUploadAvatar']['failure']['noUpload']	= 'There was an error and your avatar could not be processed.';

// public function doEditUser()
$lang['doEditUser']['success']['default']	= 'Your settings were successfully changed.';
$lang['doEditUser']['success']['passMatch']	= ', and your new password has been changed to ';
$lang['doEditUser']['failure']['wrongPass']	= ', but your password could not be changed since the password fields did not match';
$lang['doEditUser']['failure']['passNotFound']	= 'Your old password did not match any records in the databsae, so your information could not be changed.';

// public function addUser()
$lang['addUser']['message']['level3'] 		= 'Administrator';
$lang['addUser']['message']['level2'] 		= 'Moderator';
$lang['addUser']['message']['level1'] 		= 'Poster';

// public function saveUser()
$lang['saveUser']['success']['default'] 	= 'The user was successfully added to the user database.';
$lang['saveUser']['failure']['passBlank'] 	= 'You left the password field blank.';
$lang['saveUser']['failure']['repeatBlank'] 	= 'You left the password repeat field blank.';
$lang['saveUser']['failure']['userBlank'] 	= 'You left the username field blank.';
$lang['saveUser']['failure']['passMatch'] 	= 'The passwords did not match. Please try again.';

// public function removeSave()
$lang['removeSave']['success']['default'] 	= 'The user was successfully deleted from the user database.';
$lang['removeSave']['failure']['admin'] 	= 'You cannot delete administrator accounts. Please try again.';
$lang['removeSave']['failure']['reflect'] 	= 'You cannot delete your own account. Please select a different account, or have an administrator delete your account.';

// Template language keys //
// ---------------------- //
$lang['editUser']['message']['userLevel'] 	= 'User Level';
$lang['editUser']['message']['currentPassword'] = 'Current Password';
$lang['editUser']['message']['passMustEnter']	= 'Your current password must be entered to change any amount of your user profile.';
$lang['editUser']['message']['newPassword'] 	= 'New Password';
$lang['editUser']['message']['repeatNew'] 	= 'Repeat Password';
$lang['editUser']['message']['email'] 		= 'Email';
$lang['editUser']['message']['alias'] 		= 'Alias';
$lang['editUser']['message']['avatarImage'] 	= 'Avatar Image';
$lang['editUser']['message']['uploadAvatar'] 	= 'upload a new avatar';
$lang['editUser']['message']['changeUser'] 	= 'Change User';

$lang['addUser']['message']['createUser'] = 'Create a User';
$lang['addUser']['message']['userName'] = 'Username';
$lang['addUser']['message']['password'] = 'Password';
$lang['addUser']['message']['repeat'] = 'Repeat Password';
$lang['addUser']['message']['email'] = 'Email';
$lang['addUser']['message']['alias'] = 'Alias';
$lang['addUser']['message']['avatarImage'] = 'Avatar Image';
$lang['addUser']['message']['doCreate'] = 'Create User';

$lang['addUser']['message']['willBeMailed'] = 'Your username and password will be mailed to the address specified above.';
$lang['addUser']['message']['defaultIs'] = 'The default directory is';
$lang['addUser']['message']['canNotRecover'] 	= 'Note: It is currently impossible to recover your password if lost.<br/>Please keep the email that is sent to the email address that you have specified above so that the issue is less likely to arise.';

$lang['removeUser']['message']['pleaseSelect'] = 'Please select the user you would like to remove.';
$lang['removeUser']['message']['warning'] = 'WARNING: Once a user is removed from the system, they cannot be recovered.';
$lang['removeUser']['message']['selectUser'] = 'Select User';
$lang['removeUser']['message']['removeUser'] = 'Remove User';

$lang['uploadAvatar']['message']['uploadAvatar'] = 'Upload Avatar';
$lang['uploadAvatar']['message']['destination'] = 'Destination File Name';
$lang['uploadAvatar']['message']['fileToUpload'] = 'File to Upload';
$lang['uploadAvatar']['message']['uploadAvatar'] = 'Upload Avatar';
?>
