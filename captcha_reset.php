<?php
// version 1.1 Oyabun1 2014
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

$sql = 'UPDATE ' . CONFIG_TABLE . '
SET config_value = "phpbb_captcha_nogd"
WHERE config_name = "captcha_plugin"';
$db->sql_query($sql);

$cache->purge();

echo '<p style="font-size: 1.2em;">CAPTCHA changed to <em>simple image</em><p>';

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