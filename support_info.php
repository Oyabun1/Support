<?php
// copyright (c) Oyabun1 2013
// version 1.0.7
// license http://opensource.org/licenses/gpl-license.php GNU Public License

define('IN_PHPBB', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);

// Try to check if the file is in the right place
if (file_exists($phpbb_root_path . 'common.' . $phpEx))
{
	include($phpbb_root_path . 'common.' . $phpEx);

	// Create a HTML page to add some form elements
	echo '<!DOCTYPE html>';
	echo '<head>';
	echo '<meta http-equiv="content-type" content="text/html; charset=UTF-8" />';
	echo '<title>' . basename(__FILE__) . '</title>';
	echo '</head>';
	echo '<body style="background-color:#FFF8DC">';
	echo '<div style="width:800px">';

	// Create some checkboxes to select info categories
	echo '<fieldset><legend><strong>Select one or more relevant boxes then press the Show button</strong></legend>';
	echo '<form action="' . basename(__FILE__) . '" method="post">';
	echo '<label><input type="checkbox" name="chkASpam" value="Yes" />Anti-Spam&nbsp;</label>&nbsp;';
	echo '<label><input type="checkbox" name="chkCookies" value="Yes" />Cookies&nbsp;</label>&nbsp;'; 
	echo '<label><input type="checkbox" name="chkDbase" value="Yes" />Database&nbsp;</label>&nbsp;';
	echo '<label><input type="checkbox" name="chkPaths" value="Yes" />Paths&nbsp;</label>&nbsp;';  
	echo '<label><input type="checkbox" name="chkPHP" value="Yes" />PHP Info&nbsp;</label>&nbsp;'; 
 	echo '<label><input type="checkbox" name="chkServer" value="Yes" />Server&nbsp;</label>&nbsp;';
	echo '<label><input type="checkbox" name="chkStyles" value="Yes" />Styles&nbsp;</label>&nbsp;'; 
	echo '<label><input type="checkbox" name="chkVersion" value="Yes" />Version&nbsp;</label>&nbsp;'; 
	echo '<p><button type="submit">Show</button></p>';
	echo '</form>';
	echo '</fieldset><br />';
	echo '<fieldset style="background-color:#F5FCFF; border-color:#00CC00; border-style: solid;"><legend><strong>Copy and paste
	the lines below to the appropriate topic at phpbb.com</strong></legend>';

	// Use request_var() - using $_POST() is discouraged (& phpBB 3.1 will have a dummy spit)
	$chk_spam = (request_var('chkASpam', ''));
	$chk_cookies = (request_var('chkCookies', ''));
	$chk_dbase = (request_var('chkDbase', ''));
	$chk_paths = (request_var('chkPaths', ''));
	$chk_php = (request_var('chkPHP', ''));
	$chk_server = (request_var('chkServer', ''));
	$chk_styles = (request_var('chkStyles', ''));
	$chk_version = (request_var('chkVersion', ''));	
	
	// Grab the data and display it based on which checkboxes are selected
	if ($chk_spam == 'Yes')
		{
			echo '<strong>Anti-Spam Measures</strong><br />';
			switch($config['require_activation'])
			{
			case 0:
				$activation = 'No activation (immediate access)';
				break;
			case 1:
				$activation = 'By user (email activation)';
				break;
			case 2:
				$activation = 'By Admin';
				break;
			case 3:
				$activation = 'Disabled';
				break;
			}
			
			echo 'Account activation: ' . $activation . '<br />';
			$sql = 'SELECT COUNT(ban_ip) AS banned_ips FROM ' . BANLIST_TABLE . ' WHERE (ban_ip <> "")';
			$result = $db->sql_query($sql);
			$banned_ips = (int) $db->sql_fetchfield('banned_ips');
			echo 'Banned IPs: ' . $banned_ips . '<br />';
			$db->sql_freeresult($result);

			$sql = 'SELECT COUNT(ban_email) AS banned_emails FROM ' . BANLIST_TABLE . ' WHERE (ban_email <> "")';
			$result = $db->sql_query($sql);
			$banned_emails = (int) $db->sql_fetchfield('banned_emails');
			echo 'Banned Email Addresses: ' . $banned_emails . '<br />';
			$db->sql_freeresult($result);			
			
			$sql = 'SELECT config_name, config_value FROM ' . CONFIG_TABLE . ' WHERE config_name = "captcha_plugin"';
			$result = $db->sql_query($sql);
			while($row = $db->sql_fetchrow($result))
			{
			$captcha_id_value = $row['config_value'];
			}
			switch($captcha_id_value)
			{
			 case 'phpbb_captcha_sortables':
				$captcha_id = 'Sortables CAPTCHA Plugin';
				break;
			 case 'phpbb_captcha_qa':
				$captcha_id = 'Q&A CAPTCHA Plugin';
				break;			 
			 case 'phpbb_captcha_gd':
				$captcha_id = 'GD Image';
				break;
			 case 'phpbb_captcha_gd_wave':
				$captcha_id = 'GD 3D Image';
				break;			
			 case 'phpbb_captcha_nogd':
				$captcha_id = 'Simple Image';
				break;
			 case 'phpbb_captcha_simplemath':
				$captcha_id = 'NV Simplemath CAPTCHA';
				break;			 
			 case 'phpbb_recaptcha':
				$captcha_id = 'ReCAPTCHA';
				break;
			 case 'phpbb_nucaptcha':
				$captcha_id = 'NuCaptcha Plugin';
				break;				
			 case 'phpbb_imgrotate':
				$captcha_id = 'Rotate Image Captcha';
				break;
			 case 'phpbb_peoplesign':
				$captcha_id = 'Peoplesign CAPTCHA Plugin';
				break;			 
			 default:
				$captcha_id = '$captcha_id_value';
				break;
			}
			echo 'Spambot Countermeasure: ' . $captcha_id . '<br />';
			$db->sql_freeresult($result);
			echo '<br />';
		}
	
	if($chk_cookies == 'Yes')
		{
			echo '<strong>Cookie Settings</strong><br />';
			echo 'Cookie domain: ' . $config['cookie_domain'] . '<br />';
			echo 'Cookie name: ' . $config['cookie_name'] . '<br />';
			echo 'Cookie path: ' . $config['cookie_path'] . '<br />';
			echo 'Cookie secure: ' . ($config['cookie_secure']  ? 'Yes' : 'No') . '<br /><br />';
		}

	if($chk_dbase == 'Yes')
		{
			echo '<strong>Database</strong><br />';
			echo 'Database system: ' . $dbms . '<br />';
			echo 'Database host: ' . $dbhost . '<br />';
			echo 'Database port: ' . $dbport . '<br />';
			echo 'Database name: ' . $dbname . '<br />';
			echo 'Database user: ' . $dbuser . '<br />';	
			echo 'Table prefix: ' . $table_prefix . '<br />';
			echo 'Cache ($acm_type): ' . $acm_type . '<br />';
			echo 'PHP extensions ($load_extensions): ' . $load_extensions . '<br /><br />';
		}	

	if($chk_paths == 'Yes')
		{
			echo '<strong>Paths</strong><br />';
			clearstatcache();  // Necessary for getting updated permissions
			echo 'Path to this file: ' . __FILE__ . '<br />';
			echo 'Attachment upload directory: ' . $config['upload_path'] . '<br />';
			if ($config['upload_path'] != '')
				{
					echo 'Attachment upload directory permissions: ' . substr(sprintf('%o', fileperms($phpbb_root_path . ($config['upload_path']))), -4) . ' <br />';	
				}		
			echo 'Avatar storage path: ' . $config['avatar_path'] . '<br />';
			if ($config['avatar_path'] != '')
				{
					echo 'Avatar storage folder permissions: ' . substr(sprintf('%o', fileperms($phpbb_root_path . ($config['avatar_path']))), -4) . ' <br />';	
				}
			$can_upload = ($config['allow_avatar_upload'] && file_exists($phpbb_root_path . $config['avatar_path'])
				&& phpbb_is_writable($phpbb_root_path . $config['avatar_path']) && (@ini_get('file_uploads') || strtolower(@ini_get('file_uploads')) == 'on')) ? 'Yes' : 'No';
			echo 'Can upload avatar: ' . $can_upload . '<br />';
			echo 'Avatar gallery path: ' . $config['avatar_gallery_path'] . '<br />';
			if ($config['avatar_gallery_path'] != '')
				{
					echo 'Avatar gallery folder permissions: ' . substr(sprintf('%o', fileperms($phpbb_root_path . ($config['avatar_gallery_path']))), -4) . ' <br />';	
				}
			echo 'Post icons path: ' . $config['icons_path'] . '<br />';
			if ($config['icons_path'] != '')
				{
					echo 'Post icons folder permissions: ' . substr(sprintf('%o', fileperms($phpbb_root_path . ($config['icons_path']))), -4) . ' <br />';
				}
			echo 'Ranks path: ' . $config['ranks_path'] . '<br />';
			if ($config['ranks_path'] != '')
				{
					echo 'Ranks folder permissions: ' . substr(sprintf('%o', fileperms($phpbb_root_path . ($config['ranks_path']))), -4) . ' <br />';	
				}
			echo 'Smilies path: ' . $config['smilies_path'] . '<br />';
			if ($config['smilies_path'] != '')
				{
					echo 'Smilies folder permissions: ' . substr(sprintf('%o', fileperms($phpbb_root_path . ($config['smilies_path']))), -4) . ' <br /><br />';		
				}
			echo 'config.php permissions: ' . substr(sprintf('%o', fileperms($phpbb_root_path . 'config.' . $phpEx)), -4) . 
					' file size is: ' . filesize(($phpbb_root_path . 'config.' . $phpEx)) . ' bytes<br />';			
			if (file_exists($phpbb_root_path . 'files'))
				{
					echo '/files permissions: ' . substr(sprintf('%o', fileperms($phpbb_root_path . 'files')), -4) . ' <br />';			
				}
			else
				{
					echo '/files not found<br />';
				}
			if (file_exists($phpbb_root_path . 'store'))
				{
					echo '/store permissions: ' . substr(sprintf('%o', fileperms($phpbb_root_path . 'store')), -4) . ' <br />';
				}
				else
				{
					echo '/store not found<br />';
				}
			if (file_exists($phpbb_root_path . 'store/mods'))
				{			
					echo '/store/mods permissions: ' . substr(sprintf('%o', fileperms($phpbb_root_path . 'store/mods')), -4) . ' <br /><br />';
				}
				else
				{
					echo '/store/mods not found<br />';
				}
		}

	if ($chk_php == 'Yes')
		{
			echo '<strong>PHP Values</strong><br />';
			echo 'PHP version: ' . phpversion() . '<br />'; 
			echo 'Max upload: ' . (int)(ini_get('upload_max_filesize')) . ' MB<br />';
			echo 'Max post: ' . (int)(ini_get('post_max_size')) . ' MB<br />';
			echo 'Memory limit: ' . (int)(ini_get('memory_limit')) . ' MB<br />';
			echo 'Max execution time: ' . (int)(ini_get('max_execution_time')) . ' secs<br />';
			echo 'Max input time: ' . (int)(ini_get('max_input_time')) . ' secs<br />';
			echo 'allow_url_fopen: ' . (ini_get('allow_url_fopen') ? 'Yes' : 'No') . ' <br />';

			// A check to see if getimagesize is working on remote file
			$dimensions = '';
			$getimage = '';
			$image1 = "http://www.google.com/images/logo.gif";
			$getheaders = @get_headers($image1);
			if (preg_match("|200|", $getheaders[0])) 
				{
					$dimensions = getimagesize($image1);
					$dimensions = $dimensions['3'];
				}
			if (preg_match("/width/i", $dimensions))
				{
					$getimage = 'Working';
				}
			else
				{
					$getimage = 'Not working';
				}
			echo 'getimagesize remote: ' . $getimage . '<br />';

			// Check of getimagesize on local file (relies on images/spacer.gif being there)
			$spacer = generate_board_url() . '/images/spacer.gif';
			if(file_exists($phpbb_root_path . 'images/spacer.gif'))
			{
				$dimensions_loc = '';
				$getimage_loc = '';
				$image2 = $spacer;
				$getheaders = @get_headers($image2);
				if (preg_match("|200|", $getheaders[0])) 
					{
						$dimensions_loc = getimagesize($image2);
						$dimensions_loc = $dimensions_loc['3'];
					}
				if (preg_match("/width/i", $dimensions_loc))
					{
						$getimage_loc = 'Working';
					}
				else
					{
						$getimage_loc = 'Not working';
					}
				echo 'getimagesize local: ' . $getimage_loc . '<br /><br />';
			}
			else
			{
				echo 'getimagesize local: ' . $spacer . ' could not be found<br /><br />';
			}
		}

	if($chk_server == 'Yes')
		{
			echo '<strong>Server Settings</strong><br />';
			echo 'Force server URL settings: ' . ($config['force_server_vars'] ? 'Yes' : 'No') . '<br />';
			echo 'Script path: ' . $config['script_path'] . '<br />';
			echo 'Server name: ' . $config['server_name'] . '<br />';
			echo 'Server port: ' . $config['server_port'] . '<br />';
			echo 'Server protocol: ' . $config['server_protocol'] . '<br />';

			$sql = 'SELECT config_name, config_value FROM ' . CONFIG_TABLE . ' WHERE config_name = "ip_check"';
			$result = $db->sql_query($sql);
			while($row = $db->sql_fetchrow($result))
			{
			$ip_check_value = $row['config_value'];
			}
			switch($ip_check_value)
			{
			 case 1:
				$ip_check_type = 'All';
				break;
			 case 2:
				$ip_check_type = 'A.B.C';
				break;			 
			 case 3:
				$ip_check_type = 'A.B';
				break;
			 case 4:
				$ip_check_type = 'None';
				break;
			}
			echo 'Session IP validation: ' . $ip_check_type . '<br />';
			$db->sql_freeresult($result);

			echo 'Validate X_FORWARDED_FOR header: ' . ($config['forwarded_for_check'] ? 'Yes' : 'No') . '<br />';
			echo 'Check for valid MX record: ' . ($config['email_check_mx'] ? 'Yes' : 'No') . '<br />';		
			echo 'Session length: ' . $config['session_length'] . ' secs (' . ($config['session_length']/60) . ' mins)<br />';
			$form_submit = '';
			if ($config['form_token_lifetime'] > -1)
			{
				$form_submit = ('Maximum time to submit forms: ' . $config['form_token_lifetime'] . ' secs (' . ($config['form_token_lifetime']/60) . ' mins)<br />');
			}
			else
			{
				$form_submit = ('Maximum time to submit forms: ' . $config['form_token_lifetime'] . ' (disabled)<br />');
			}
			echo $form_submit;	
			echo 'Allow persistent logins (autologin): ' . ($config['allow_autologin'] ? 'Yes' : 'No') . '<br /><br />';
	
			echo '<strong>Deactivated Modules</strong><br />';
			$sql = 'SELECT module_basename, module_class, module_langname FROM ' . MODULES_TABLE . ' WHERE module_enabled = "0" ORDER BY module_class, module_basename ASC';
			$result = $db->sql_query($sql);
			while($row = $db->sql_fetchrow($result))
			{
				echo $row['module_class'] . ': ' . $row['module_basename'] . ': ' . $row['module_langname'] . '<br />';
			}
			$db->sql_freeresult($result);
			echo '<br />';
		}
	
	if($chk_styles == 'Yes')
		{
			clearstatcache();
			if (file_exists($phpbb_root_path . 'images/spacer.gif'))
				{
					echo '/images_spacer.gif permissions: ' . substr(sprintf('%o', fileperms($phpbb_root_path . 
						'images/spacer.gif')), -4) . ' <br />';
				}
			else
				{
					echo '/images/spacer.gif could not be found<br />';
				}			
			if (file_exists($phpbb_root_path . 'styles/prosilver/imageset/icon_online.gif'))
				{
					echo '/styles/prosilver/imageset/icon_online.gif permissions: ' . substr(sprintf('%o', fileperms($phpbb_root_path . 
						'styles/prosilver/imageset/icon_online.gif')), -4) . ' <br />';
				}
			else
				{
					echo '/styles/prosilver/imageset/icon_online.gif could not be found<br />';
				}
			if (file_exists($phpbb_root_path . 'styles/prosilver/theme/images/icon_faq.gif'))
				{
					echo '/styles/prosilver/theme/images/icon_faq.gif permissions: ' . substr(sprintf('%o', fileperms($phpbb_root_path . 
						'styles/prosilver/theme/images/icon_faq.gif')), -4) . ' <br /><br />';
				}
			else
				{
					echo '/styles/prosilver/theme/images/icon_faq.gif could not be found<br />';
				}
			echo '<strong>Active Styles</strong><br />';
			$sql = 'SELECT style_name FROM ' . STYLES_TABLE . ' WHERE style_active = "1" ORDER BY style_name ASC';
			$result = $db->sql_query($sql);
			while($row = $db->sql_fetchrow($result))
			{
				echo $row['style_name'] . '<br />';
			}
			$db->sql_freeresult($result);
			echo '<br />';
			echo '<strong>Deactivated Styles</strong><br />';
			$sql = 'SELECT style_name FROM ' . STYLES_TABLE . ' WHERE style_active = "0" ORDER BY style_name ASC';
			$result = $db->sql_query($sql);
			while($row = $db->sql_fetchrow($result))
			{
				echo $row['style_name'] . '<br />';
			}
			$db->sql_freeresult($result);			
			echo '<br />';
		}
		
	if($chk_version == 'Yes')
		{
			echo '<strong>Version Settings</strong><br />';
			echo 'Board start date: ' . date('d M Y', $config['board_startdate']) . '<br />';

			if(defined('PHPBB_VERSION'))
			{
				echo 'Constant version: ' . PHPBB_VERSION . '<br />';
			}
			else
			{
				echo 'Constant version: Not defined (constant not accessible or version &#60; 3.0.3)<br />';
			}
			echo 'Cached version: ' . $config['version'] . '<br />';

			$sql = 'SELECT config_name, config_value FROM ' . CONFIG_TABLE . ' WHERE config_name = "version" OR config_name = "version_update_from"';
			$result = $db->sql_query($sql);
			while($row = $db->sql_fetchrow($result))
			{
				echo 'DB ' . $row['config_name'] . ': ' . $row['config_value'] . '<br /><br />';
			}
			$db->sql_freeresult($result);
		}
		
	echo '</fieldset>';
	echo '<br />';
}
// If the file isn't in the right place ...
else
{
	echo '<strong><p style="color:red">This ' . basename(__FILE__) . ' file seems to be in the wrong place. </p></strong>';
	echo '<strong><p>It must go in the root of your board installation.</p></strong>';
}

// Give an option to automatically delete the file
echo '<fieldset><legend><strong>If the box is ticked and you press Delete the ' . basename(__FILE__) . ' file will be deleted</strong></legend>';
echo '<form action="' . basename(__FILE__) . '" method="post">';
echo '<label><input type="checkbox" name="chkDelete" value="Yes" checked="checked"/>Delete this file</label>'; 
echo '<p><button type="submit">Delete</button></p>';
echo '</form>';
echo '</fieldset>';

if(isset($_POST['chkDelete']) && $_POST['chkDelete'] == 'Yes')
	{
		echo '<p style="width: 770px; margin-left: 10px; padding-left: 10px; background-color: #F08080">File DELETED</p>';
		// We'll try to change file permissions just to make sure they are sufficient, then unlink the file
		chmod(__FILE__, 0775);
		unlink(__FILE__);
	}
else 
	{
		echo '<p style="width: 770px; margin-left: 10px; padding-left: 10px; background-color: #98FB98">File NOT deleted</p>';
	}
echo '</div>';
echo '</body>';
echo '</html>';
