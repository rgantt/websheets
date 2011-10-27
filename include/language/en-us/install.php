<?php
$lang['step2']['message']['introduction'] 	= 'Welcome to the <span style="color:red;">Blargon installation utility</span>!<p/>This program will guide you through the steps required to get Blargon up and running on your server.<p/>When you are ready to begin, please press Next.';

$lang['step3']['message']['introduction'] 	= 'Before we can begin, you must make sure that you go into your <span style="color:red;">blargon</span> installation folder, and then the <span style="color:red;">configuration</span> folder, and open the file named <span style="color:red;">configure.php</span>.<p/>Be sure to edit the following fields, updating them to reflect the settings as they are for your own server: <span style="color:red;">user, host, pass, base</span>. These are the options that will tell blargon where to install, as well as provide a way for blargon to connect to your database in the future. Also be sure to edit <span style="color:red;">path</span> and <span style="color:red;">direct</span>, if your installation folder is not named "blargon".<p/>If you want to set up more than one instance of Blargon, be sure to change the <span style="color:red;">prefix</span> to something unique for each directory you install from.<p/>After you have edited <span style="color:red;">configure.php</span>, please press Next.';

$lang['step4']['message']['introduction'] 	= 'Blargon is now checking whether or not your server meets the requirements for installation.<p/>If there is an error, more information on how to fix it will be available upon request.';

$lang['step5']['message']['introduction'] 	= 'It\'s time to actually <span style="color:red;">create the tables</span> and insert our default data into them so that we can continue with more <span style="color:red;">advanced configuration</span>. Please press Next to install the tables and insert the default data.';

$lang['step6']['message']['introduction'] 	= 'Please <span style="color:red;">review the output</span> of this page, and if any errors are visible (they are most likely to occur on the <span style="color:red;">very first query</span>, and if that one is OK, then the rest should be, as well), please either report them to your administrator or review your <span style="color:red;">configure.php</span> file for errors.';

$lang['step7']['message']['introduction'] 	= 'Now we need to set up the <span style="color:red;">root user account</span> for Blargon.<p/>This is only the default username; others can be added after the program is installed. This user will have access to <span style="color:red;">every</span> feature in Blargon, and, since it is an administrator account, <span style="color:red;">cannot be deleted</span>.<br/>It is suggested that whoever installs this program become the main user of the program, otherwise change the password to a random string.<p/>Please enter your account information to continue:';

$lang['step8']['message']['introduction'] 	= 'Now that the <span style="color:red;">administrator account</span> is set up, we need to change the template that will be used to <span style="color:red;">display the entries</span> on your main page. This template can be written in all <span style="color:red;">HTML</span>, and Blargon provides several keys which you can insert to show <span style="color:red;">specific information</span> about the entry.';

$lang['step9']['message']['introduction'] 	= 'Please <span style="color:red;">modify the template</span> below. When you are ready, press Next to continue. Note that you will be able to change this template <span style="color:red;">at any time</span> through the <span style="color:red;">control panel</span> after installation.';

$lang['step10']['message']['introduction'] 	= 'Now that you\'ve edited your template, you are ready to <span style="color:red;">continue to the control panel</span> and begin using Blargon! Please review the message below, and <span style="color:red;">click Next</span> when you are ready to continue.';

$lang['step4']['success']['Configuration'] 	= 'You have successfully edited the <span style="color:red;">configure.php</span> file!';
$lang['step4']['failure']['Configuration'] 	= 'You have not changed the configuration settings in <span style="color:red;">configure.php</span>.';

$lang['step4']['failure']['MySQLExists'] 	= 'MySQL was not found, or you do not have php compiled with the correct version of MySQL';
$lang['step4']['success']['MySQLExists'] 	= 'MySQL was found, and is ready for a connection.';

$lang['step4']['failure']['MySQLVersion'] 	= 'Blargon requires MySQL 4 or later.';
$lang['step4']['success']['MySQLVersion'] 	= 'Your MySQL installation is up to date.';

$lang['step4']['message']['fix'] 		= 'Please correct any errors before continuing.';

$lang['step6']['message']['wasAdded'] 		= ' table was successfully added!';
$lang['step6']['message']['wasNot'] 		= ' table could not be added!';

$lang['step8']['success']['User'] 		= 'The administrator account was successfully created. Please press Next to continue to the template.';

$lang['step10']['success']['query'] 		= 'The template was successfully added to the database.';
$lang['step10']['failure']['query'] 		= 'The template could not be added! Please check your configuration and try to run this installation utility at a later time.';

$lang['general']['message']['next'] 		= 'Next';
$lang['general']['message']['previous'] 	= 'Previous';
$lang['general']['message']['continue'] 	= 'To continue, please press Next.';
$lang['general']['message']['userName'] 	= 'Username: ';
$lang['general']['message']['password'] 	= 'Password: ';
$lang['general']['message']['repeatPass'] 	= 'Repeat Password: ';