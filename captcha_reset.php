<?php
// version 2.1 Oyabun1 2014
// license http://opensource.org/licenses/GPL-2.0 GNU General Public License v2

define('IN_PHPBB', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);
include_once($phpbb_root_path . 'includes/functions_admin.' . $phpEx);

// Start session management
$user->session_begin();
$auth->acl($user->data);

// Limit this to founders or admins
if ((int) $user->data['user_type'] !== USER_FOUNDER || !$auth->acl_get('a_'))
{
	trigger_error('You don\'t have permission to change the CAPTCHA. 
	You need to be logged in as a founder or administrator.');
}

// Some variables to check if 3.1.x
$version = PHPBB_VERSION;
$vers_num = '3.1.';
$ascraeus = strpos($version, $vers_num);

// We'll only change the CAPTCHA if it is not already a default type
// Grab the CAPTCHA type
$sql = 'SELECT config_name, config_value FROM ' . CONFIG_TABLE . ' 
	WHERE config_name = "captcha_plugin"';
$result = $db->sql_query($sql);
while($row = $db->sql_fetchrow($result))
{
	$captcha_id_value = $row['config_value'];
}
	// check if one of the defaults
	if ($ascraeus === false)
	{
		switch($captcha_id_value)
		{
			case 'phpbb_captcha_qa':
				echo '<p style="font-size: 1.2em;">CAPTCHA  is <em>Q&A CAPTCHA Plugin</em> therefore unchanged<p>';
				break;
			case 'phpbb_captcha_gd':
				echo '<p style="font-size: 1.2em;">CAPTCHA  is <em>GD Image</em> therefore unchanged<p>';
				break;
			case 'phpbb_captcha_gd_wave':
				echo '<p style="font-size: 1.2em;">CAPTCHA  is <em>GD 3D Image</em> therefore unchanged<p>';
				break;
			case 'phpbb_captcha_nogd':
				echo '<p style="font-size: 1.2em;">CAPTCHA  is <em>Simple Image</em> therefore unchanged<p>';
				break;
			case 'phpbb_recaptcha':
				echo '<p style="font-size: 1.2em;">CAPTCHA  is <em>ReCAPTCHA</em> therefore unchanged<p>';
				break;
			// else change it
			default:
				$sql = 'UPDATE ' . CONFIG_TABLE . '
				SET config_value = "phpbb_captcha_nogd"
				WHERE config_name = "captcha_plugin"';
				$db->sql_query($sql);
				echo '<p style="font-size: 1.2em;">CAPTCHA changed to <em>simple image</em><p>';
				break;
		}
	}
	else 
	{
		switch($captcha_id_value)
		{
			case 'core.captcha.plugins.qa':
				echo '<p style="font-size: 1.2em;">CAPTCHA  is <em>Q&A CAPTCHA Plugin</em> therefore unchanged<p>';
				break;
			case 'core.captcha.plugins.gd':
				echo '<p style="font-size: 1.2em;">CAPTCHA  is <em>GD Image</em> therefore unchanged<p>';
				break;
			case 'core.captcha.plugins.gd_wave':
				echo '<p style="font-size: 1.2em;">CAPTCHA  is <em>GD 3D Image</em> therefore unchanged<p>';
				break;
			case 'core.captcha.plugins.nogd':
				echo '<p style="font-size: 1.2em;">CAPTCHA  is <em>Simple Image</em> therefore unchanged<p>';
				break;
			case 'core.captcha.plugins.recaptcha':
				echo '<p style="font-size: 1.2em;">CAPTCHA  is <em>ReCAPTCHA</em> therefore unchanged<p>';
				break;
			// else change it
			default:
				$sql = 'UPDATE ' . CONFIG_TABLE . '
				SET config_value = "core.captcha.plugins.nogd"
				WHERE config_name = "captcha_plugin"';
				$db->sql_query($sql);
				echo '<p style="font-size: 1.2em;">CAPTCHA changed to <em>simple image</em><p>';
				break;
		}	
	}
$db->sql_freeresult($result);

/// Config value is cached so we'll clear that.
$cache->purge();

// Try to delete this file
@unlink(__FILE__);  // Eat any errors 

// Windows IIS servers apparently have a problem with unlinking recently created files.
// So check if file exists and give a message
if (file_exists(__FILE__))
{
	echo '<p style="color: #FFFFFF; width: 780px; margin-left: 5px; padding-left: 5px; 
	font-size: 1.1em; background-color: #8B0000;">File could not be deleted. You will 
	need to manually delete the ' . basename(__FILE__) . ' file from the server.</p>';
}
