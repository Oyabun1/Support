<?php
// copyright (c) Oyabun1 2013
// version 1.2.0
// license http://opensource.org/licenses/gpl-license.php GNU Public License

define('IN_PHPBB', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);

// Try to check if the file is in the right place
if (file_exists($phpbb_root_path . 'common.' . $phpEx))
{
	include($phpbb_root_path . 'common.' . $phpEx);
	include($phpbb_root_path . 'config.' . $phpEx);

	// Create a HTML5 page to add some form elements
	echo '<!DOCTYPE html>';
	echo '<head>';
	echo '<meta http-equiv="content-type" content="text/html; charset=UTF-8" />';
	echo '<title>' . basename(__FILE__) . '</title>';
	echo '<style>
		form {
		text-align: center;
		line-height: 2
		}
		label {
		background-color: #EEE9D7;
		border-style: double;
		border-width; 1px;
		border-radius: 3px;
		border-color: #CC99CC;
		padding: 2px;
		margin: 2px;
		}
	
	</style>';
	echo '</head>';
	echo '<body style="background-color:#FFF8DC">';
	echo '<div style="width:800px">';

	// Create some checkboxes to select info categories
	echo '<fieldset><legend><strong>Select one or more relevant boxes then press the Show button</strong></legend>';
	echo '<form action="' . basename(__FILE__) . '" method="post">';
	echo '<label title="Anonymous user details"><input type="checkbox" name="chkAnon" value="Yes" />
		Anonymous&nbsp;</label>&nbsp;';
	echo '<label title="Activation, countermeasure, and ban info"><input type="checkbox" name="chkASpam" value="Yes" />
		Anti-Spam&nbsp;</label>&nbsp;';
	echo '<label title="Attachment settings"><input type="checkbox" name="chkAttach" value="Yes" />
		Attachments&nbsp;</label>&nbsp;';
	echo '<label title="Avatar settings"><input type="checkbox" name="chkAvatar" value="Yes" />
		Avatar&nbsp;</label>&nbsp;';
	echo '<label title="Cookie settings from database"><input type="checkbox" name="chkCookies" value="Yes" />
		Cookies&nbsp;</label>&nbsp;'; 
	echo '<label title="Database (config.php) details"><input type="checkbox" name="chkDbase" value="Yes" />
		Database&nbsp;</label>&nbsp;';
	echo '<br />';
		echo '<label title="Email settings"><input type="checkbox" name="chkEmail" value="Yes" />Email&nbsp;</label>&nbsp;';  
	echo '<label title="Paths and permissions"><input type="checkbox" name="chkPaths" value="Yes" />
		Paths&nbsp;</label>&nbsp;';  
	echo '<label title="PHP settings mainly related to files and images"><input type="checkbox" name="chkPHP" value="Yes" />PHP Info&nbsp;</label>&nbsp;'; 
 	echo '<label title="ACP Server setings, languages & deactivated modules"><input type="checkbox" name="chkServer" value="Yes" />
		Server&nbsp;</label>&nbsp;';
	echo '<label title="Active and Deactivated styles"><input type="checkbox" name="chkStyles" value="Yes" />
		Styles&nbsp;</label>&nbsp;'; 
	echo '<label title="Version info and basic stats"><input type="checkbox" name="chkVersion" value="Yes" />Version&nbsp;</label>&nbsp;'; 
	echo '<p><button type="submit">Show</button></p>';
	echo '</form>';
	echo '</fieldset><br />';
	echo '<fieldset style="background-color:#F5FCFF; border-color:#00CC00; border-style: solid;"><legend><strong>Copy and paste
	the lines below to the appropriate topic at phpbb.com</strong></legend>';

	// Use request_var() - using $_POST() is discouraged (& phpBB 3.1 will have a dummy spit)
	$chk_anon = (request_var('chkAnon', ''));
	$chk_aspam = (request_var('chkASpam', ''));
	$chk_attach  = (request_var('chkAttach', ''));
	$chk_avatar = (request_var('chkAvatar', ''));
	$chk_cookies = (request_var('chkCookies', ''));
	$chk_dbase = (request_var('chkDbase', ''));
	$chk_email = (request_var('chkEmail', ''));
	$chk_paths = (request_var('chkPaths', ''));
	$chk_php = (request_var('chkPHP', ''));
	$chk_server = (request_var('chkServer', ''));
	$chk_styles = (request_var('chkStyles', ''));
	$chk_version = (request_var('chkVersion', ''));
	$chk_delete = (request_var('chkDelete', ''));

	// Grab the data and display it depending on which checkboxes are selected
	if ($chk_anon == 'Yes')
		{
			echo '<strong>[b]Anonymous User[/b]</strong><br />';
			if(defined('ANONYMOUS'))
			{
				echo 'Constant user_id: ' . ANONYMOUS . '<br />';
			}
			else
			{
				echo 'Anonymous constant not defined (constant not accessible)<br />';
			}
			
			$sql = 'SELECT username, username_clean
			FROM ' . USERS_TABLE . '
			WHERE user_id = "1"';
			$result = $db->sql_query($sql);
			while ($row = $db->sql_fetchrow($result))
			{
				if ($row['username_clean'] != 'anonymous')
				{
					echo 'Database user_id 1 is: ' . $row['username'] . ' || username_clean: ' . $row['username_clean'] . '<br />';
				}
			}
			$db->sql_freeresult($result);	
			
			$sql = 'SELECT user_id, username
			FROM ' . USERS_TABLE . '
			WHERE username_clean = "anonymous"';		
			$result = $db->sql_query($sql);
			while($row = $db->sql_fetchrow($result))
			{
				echo 'DB user_id: ' . $row['user_id'] . '<br />';
				echo 'Username: ' . $row['username'] . '<br />';
			}
			$db->sql_freeresult($result);
				
			echo '[i]Group(s):[/i]<br />';
			$sql = 'SELECT g.group_name
			FROM ' . GROUPS_TABLE . ' g
			LEFT JOIN ' . USER_GROUP_TABLE . ' ug USING (group_id)
			LEFT JOIN ' . USERS_TABLE . ' u USING (user_id)
			WHERE u.user_id IN (SELECT user_id FROM ' . USERS_TABLE . ' WHERE username_clean = "anonymous")';		
			$result = $db->sql_query($sql);
			while($row = $db->sql_fetchrow($result))
			{
			echo ucfirst(strtolower($row['group_name'])) . '<br />';
			}
			$db->sql_freeresult($result);

			$sql = 'SELECT u.user_id, username, username_clean
			FROM ' . USERS_TABLE . ' u
			LEFT JOIN ' . USER_GROUP_TABLE . ' g 
			ON (g.user_id = u.user_id)
			WHERE g.group_id
			IN (SELECT group_id
			FROM ' . GROUPS_TABLE . '
			WHERE group_name = "GUESTS")';
			$result = $db->sql_query($sql);
			while($row = $db->sql_fetchrow($result))
			{
				if ($row['username_clean'] != 'anonymous')
				{				
					echo 'Also in Guests group: ' . $row['username'] . ' || user_id: ' . $row['user_id'] . '<br >';
				}
			}
			echo '<br />';
		}

	if ($chk_aspam == 'Yes')
		{
			echo '<strong>[b]Anti-Spam Measures[/b]</strong><br />';
			// Convert config numerical value to appropriate text
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

	if ($chk_attach  == 'Yes')
		{
			echo 'Allow attachments: ' . ($config['allow_attachments']  ? 'Yes' : 'No') . '<br />';
			echo 'Allow attachments in PMs: ' . ($config['allow_pm_attach']  ? 'Yes' : 'No') . '<br />';
			echo 'Upload directory: ' . $config['upload_path'] . '<br />';
			if ($config['upload_path'] != '')
				{
					echo 'Upload directory permissions: ' . substr(sprintf('%o', fileperms($phpbb_root_path . 
					($config['upload_path']))), -3) . ' <br />';
				}
			echo 'Attachment display order: ' . ($config['display_order']  ? 'Ascending' : 'Descending') . '<br />';
			// Sizes are stored in config table as bytes, to convert to mebibytes we divide by 1024 x 1024 = 1048576 
			// and for neatness round value to 2 decimal places
			if ($config['attachment_quota'] != '0')
				{
				$quota1 = round(($config['attachment_quota']/1048576), 2) . ' MiB';
				}
				else
				{
				$quota1 = 'Host limit';
				}
			echo 'Total attachment quota: ' . $quota1 . '<br />';
			if ($config['max_filesize'] != '0')
				{
				$quota2 = round(($config['max_filesize']/1048576), 2) . ' MiB';
				}
				else
				{
				$quota2 = 'PHP limit';
				}
			echo 'Maximum file size: ' . $quota2 . '<br />';
			if ($config['max_filesize_pm'] != '0')
				{
				$quota3 = round(($config['max_filesize_pm']/1048576), 2) . ' MiB';
				}
				else
				{
				$quota3 = 'Unlimited';
				}
			echo 'Maximum file size PMs: ' . $quota3 . '<br />';
			echo 'Maximum attachments per post: ' . $config['max_attachments'] . '<br />';
			echo 'Maximum attachments per PM: ' . $config['max_attachments_pm'] . '<br />';
			echo 'Check file mimetype: ' . ($config['check_attachment_content']  ? 'Yes' : 'No') . '<br />';
			echo 'Secure downloads: ' . ($config['secure_downloads']  ? 'Yes' : 'No') . '<br />';
			if ($config['secure_downloads'])
			{
				echo 'Allow/Deny list: ' . ($config['secure_allow_deny']  ? 'Yes' : 'No') . '<br />';
				echo 'Allow empty referrer: ' . ($config['secure_allow_empty_referer']  ? 'Yes' : 'No') . '<br />';
			}
			echo '[b]Image attachments[/b]<br />';
			echo 'Display images inline: ' . ($config['img_display_inlined']  ? 'Yes' : 'No') . '<br />';
			echo 'Create thumbnail: ' . ($config['img_create_thumbnail']  ? 'Yes' : 'No') . '<br />';
			if ($config['img_create_thumbnail'])
			{
				echo 'Maximum thumbnail width: ' . $config['img_max_thumb_width'] . ' px<br />';
				// To covert byte value to kibibytes we divide by 1024
				echo 'Maximum thumbnail file size: ' . round(($config['img_min_thumb_filesize']/1024), 2) . ' KiB<br />';
			}
			echo 'Imagemagick path: ' . $config['img_imagick'] . '<br />';
			echo 'Maximum image dimensions: ' . $config['img_max_width'] . ' x ' . $config['img_max_height'] . ' 
			px (width x height)<br />';
			echo 'Image link dimensions: ' . $config['img_link_width'] . ' x ' . $config['img_link_height'] . ' 
			px (width x height)<br /><br />';
			}

	if ($chk_avatar == 'Yes')
		{
			echo '<strong>[b]Avatar Settings[/b]</strong><br />';
			echo 'Enable avatars: ' . ($config['allow_avatar']  ? 'Yes' : 'No') . '<br />';
			echo 'Gallery avatars: ' . ($config['allow_avatar_local']  ? 'Yes' : 'No') . '<br />';
			echo 'Remote avatars: ' . ($config['allow_avatar_remote']  ? 'Yes' : 'No') . '<br />';
			echo 'Avatar uploading: ' . ($config['allow_avatar_upload']  ? 'Yes' : 'No') . '<br />';
			echo 'Remote avatar uploading: ' . ($config['allow_avatar_remote_upload']  ? 'Yes' : 'No') . '<br />';
			if ($config['avatar_filesize'] != '0')
				{
				echo 'Maximum avatar file size: ' . round(($config['avatar_filesize']/1024), 2) . ' kB<br />';
				}
				else
				{
				echo 'Maximum avatar file size: PHP limit<br />';
				}
			echo 'Minimum avatar dimensions: ' . $config['avatar_min_width'] . ' x ' . $config['avatar_min_height'] . ' 
			px (width x height)<br />';
			echo 'Maximum avatar dimensions: ' . $config['avatar_max_width'] . ' x ' . $config['avatar_max_height'] . ' 
			px (width x height)<br />';
						echo 'Avatar storage path: ' . $config['avatar_path'] . '<br />';
			if ($config['avatar_path'] != '')
				{
					echo 'Avatar storage folder permissions: ' . substr(sprintf('%o', fileperms($phpbb_root_path . 
					($config['avatar_path']))), -3) . ' <br />';
				}
			echo 'Avatar gallery path: ' . $config['avatar_gallery_path'] . '<br />';
			if ($config['avatar_gallery_path'] != '')
				{
					echo 'Avatar gallery folder permissions: ' . substr(sprintf('%o', fileperms($phpbb_root_path . 
					($config['avatar_gallery_path']))), -3) . ' <br />';
				}
			$can_upload = ($config['allow_avatar_upload'] && file_exists($phpbb_root_path . $config['avatar_path'])
				&& phpbb_is_writable($phpbb_root_path . $config['avatar_path']) && (@ini_get('file_uploads') || 
				strtolower(@ini_get('file_uploads')) == 'on')) ? 'Yes' : 'No';
			echo 'Can upload avatar: ' . $can_upload . '<br /><br />';
		}

	if($chk_cookies == 'Yes')
		{
			echo '<strong>[b]Cookie Settings[/b]</strong><br />';
			echo 'Cookie domain: ' . $config['cookie_domain'] . '<br />';
			echo 'Cookie name: ' . $config['cookie_name'] . '<br />';
			echo 'Cookie path: ' . $config['cookie_path'] . '<br />';
			echo 'Cookie secure: ' . ($config['cookie_secure']  ? 'Yes' : 'No') . '<br /><br />';

			$sql = 'SELECT config_name, config_value FROM ' . CONFIG_TABLE . ' WHERE config_name = "cookie_domain"
			OR config_name = "cookie_name" OR config_name = "cookie_path" OR config_name = "cookie_secure"';
			$result = $db->sql_query($sql);
			while($row = $db->sql_fetchrow($result))
			{
				echo 'DB ' . $row['config_name'] . ': ' . $row['config_value'] . '<br />';
			}
			$db->sql_freeresult($result);
			echo '<br />';
		}
	if($chk_dbase == 'Yes')
		{
			echo '<strong>[b]Database Settings[/b]</strong><br />';
			echo 'Database system: ' . $dbms . '<br />';
			echo 'Database host: ' . $dbhost . '<br />';
			echo 'Database port: ' . $dbport . '<br />';
			echo 'Database name: ' . $dbname . '<br />';
			echo 'Database user: ' . $dbuser . '<br />';
			// We don't want the password posted publicly so we'll just count the characters
			echo 'Database password: (' . mb_strlen($dbpasswd, 'UTF-8') . ' characters) <br />';
			echo 'Table prefix: ' . $table_prefix . '<br />';
			echo 'Cache ($acm_type): ' . $acm_type . '<br />';
			echo 'PHP extensions ($load_extensions): ' . $load_extensions . '<br />';

			if (($db->sql_layer = 'mysql4') || ($db->sql_layer = 'mysqli'))
			{
				$result = $db->sql_query('SHOW TABLE STATUS LIKE \'' . POSTS_TABLE . '\'');
				$info = $db->sql_fetchrow($result);
				{
					$engine = '';
					if (isset($info['Engine']))
					{
						$engine = $info['Engine'];
					}
					else if (isset($info['Type']))
					{
						$engine = $info['Type'];
					}
				}
				echo 'Storage engine posts table: ' . $engine . '<br />';
				$db->sql_freeresult($result);
				
				$result = $db->sql_query('SHOW TABLE STATUS LIKE \'' . SESSIONS_TABLE . '\'');
				$info = $db->sql_fetchrow($result);
				{
					$engine = '';
					if (isset($info['Engine']))
					{
						$engine = $info['Engine'];
					}
					else if (isset($info['Type']))
					{
						$engine = $info['Type'];
					}
				}
				echo 'Storage engine sessions table: ' . $engine . '<br /><br />';
				$db->sql_freeresult($result);
			}
	}

	if($chk_email == 'Yes')
		{		
			echo '<strong>[b]Email Settings[/b]</strong><br />';
			echo 'Enable board-wide e-mails: ' . ($config['email_enable']  ? 'Enabled' : 'Disabled') . '<br />';
			echo 'Users send e-mails via board: ' . ($config['board_email_form']  ? 'Enabled' : 'Disabled') . '<br />';
			echo 'E-mail function name: ' . $config['email_function_name'] . '<br />';
			echo 'E-mail package size: ' . $config['email_package_size'] . '<br />';
			echo 'E-mail chunk size: ' . $config['email_max_chunk_size'] . '<br />';
			echo 'E-mail queue interval: ' . $config['queue_interval'] . ' secs<br />';
			echo 'Contact e-mail address: ' . $config['board_contact'] . '<br />';
			echo 'Return e-mail address: ' . $config['board_email'] . '<br />';
			echo 'Hide e-mail addresses: ' . ($config['board_hide_emails']  ? 'Yes' : 'No') . '<br />';
			echo 'Use SMTP server for e-mail: ' . ($config['smtp_delivery']  ? 'Yes' : 'No') . '<br />';
			// If SMTP not enabled then don't include the settings for it
			if ($config['smtp_delivery'] == '1')
			{
				echo 'SMTP server address: ' . $config['smtp_host'] . '<br />';
				echo 'SMTP server port: ' . $config['smtp_port'] . '<br />';
				echo 'Authentication method for SMTP: ' . $config['smtp_auth_method'] . '<br />';
				echo 'SMTP username: ' . $config['smtp_username'] . '<br />';
				// We probably don't need the actual password so we'll just count the characters
				echo 'SMTP password: (' . mb_strlen($config['smtp_password'], 'UTF-8') . ' characters) <br />'; 
			}
			echo '<br />';
		}

	if($chk_paths == 'Yes')
		{
			echo '<strong>[b]Paths and Permissions[/b]</strong><br />';
			clearstatcache();  // Necessary for getting updated permissions
			echo 'Path to this file: ' . __FILE__ . '<br />';
			echo 'Post icons path: ' . $config['icons_path'] . '<br />';
			if ($config['icons_path'] != '')
				{
					echo 'Post icons folder permissions: ' . substr(sprintf('%o', fileperms($phpbb_root_path . 
					($config['icons_path']))), -3) . ' <br />';
				}
			echo 'Ranks path: ' . $config['ranks_path'] . '<br />';
			if ($config['ranks_path'] != '')
				{
					echo 'Ranks folder permissions: ' . substr(sprintf('%o', fileperms($phpbb_root_path . 
					($config['ranks_path']))), -3) . ' <br />';	
				}
			echo 'Smilies path: ' . $config['smilies_path'] . '<br />';
			if ($config['smilies_path'] != '')
				{
					echo 'Smilies folder permissions: ' . substr(sprintf('%o', fileperms($phpbb_root_path . 
					($config['smilies_path']))), -3) . ' <br />';
				}
			echo 'config.php permissions: ' . substr(sprintf('%o', fileperms($phpbb_root_path . 'config.' . $phpEx)), -3) . 
					' file size is: ' . filesize(($phpbb_root_path . 'config.' . $phpEx)) . ' bytes<br />';
			if (file_exists($phpbb_root_path . 'cache'))
				{
					echo '/cache permissions: ' . substr(sprintf('%o', fileperms($phpbb_root_path . 'cache')), -3) . ' <br />';
				}
			else
				{
					echo '/cache not found<br />';
				}
					if (file_exists($phpbb_root_path . 'files'))
				{
					echo '/files permissions: ' . substr(sprintf('%o', fileperms($phpbb_root_path . 'files')), -3) . ' <br />';
				}
			else
				{
					echo '/files not found<br />';
				}
			if (file_exists($phpbb_root_path . 'store'))
				{
					echo '/store permissions: ' . substr(sprintf('%o', fileperms($phpbb_root_path . 'store')), -3) . ' <br />';
				}
				else
				{
					echo '/store not found<br />';
				}
			if (file_exists($phpbb_root_path . 'store/mods'))
				{
					echo '/store/mods permissions: ' . substr(sprintf('%o', fileperms($phpbb_root_path . 
					'store/mods')), -3) . ' <br /><br />';
				}
				else
				{
					echo '/store/mods not found<br /><br />';
				}
		}

	if ($chk_php == 'Yes')
		{
			echo '<strong>[b]PHP Values[/b]</strong><br />';
			echo 'PHP version: ' . phpversion() . '<br />'; 
			echo 'Max upload: ' . (int)(ini_get('upload_max_filesize')) . ' MB<br />';
			echo 'Max post: ' . (int)(ini_get('post_max_size')) . ' MB<br />';
			echo 'Memory limit: ' . (int)(ini_get('memory_limit')) . ' MB<br />';
			echo 'Max execution time: ' . (int)(ini_get('max_execution_time')) . ' secs<br />';
			echo 'Max input time: ' . (int)(ini_get('max_input_time')) . ' secs<br />';
			echo 'file_uploads enabled: ' . ((@ini_get('file_uploads') == '1' || 
			strtolower(@ini_get('file_uploads')) === 'on') ? 'Yes' : 'No') . '<br />';
			if(function_exists('fsockopen')) 
			{
				echo 'fsockopen(): Yes<br />';
			}
			else {
				echo 'fsockopen(): No<br />';
			}
			echo 'allow_url_fopen: ' . (ini_get('allow_url_fopen') ? 'Yes' : 'No') . '<br />';
			// Check if GD library loaded
			if (extension_loaded('gd') && function_exists('gd_info'))
				{
					echo 'GD library loaded<br />';
				}
			else
				{
					echo 'GD library not loaded<br />';
				}
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

			// Check getimagesize on local file (relies on images/spacer.gif being there)
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
			echo '<strong>[b]Server Settings[/b]</strong><br />';
			echo 'Server type/version (OS): ' . ((isset($_SERVER['SERVER_SOFTWARE'])) ? $_SERVER['SERVER_SOFTWARE'] : '') . '<br />';
			echo 'GZip compression enabled: ' . ($config['gzip_compress'] ? 'Yes' : 'No') . '<br />';
			echo 'Compression available in PHP: ' . (function_exists('ob_gzhandler') || ini_get('zlib.output_compression') ? 'Yes' : 'No') . '<br />';
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
				$form_submit = ('Maximum time to submit forms: ' . $config['form_token_lifetime'] . ' secs 
				(' . ($config['form_token_lifetime']/60) . ' mins)<br />');
			}
			else
			{
				$form_submit = ('Maximum time to submit forms: ' . $config['form_token_lifetime'] . ' (disabled)<br />');
			}
			echo $form_submit;	
			echo 'Allow persistent logins (autologin): ' . ($config['allow_autologin'] ? 'Yes' : 'No') . '<br />';
	
			$sql = 'SELECT module_basename, module_class, module_langname FROM ' . MODULES_TABLE . ' 
			WHERE module_enabled = "0" ORDER BY module_class, module_basename ASC';
			$result = $db->sql_query($sql);
			while($row = $db->sql_fetchrow($result))
			{
				if ($row['module_langname'])
				{
					echo 'Deactivated module: ' . $row['module_class'] . ': ' . $row['module_basename'] . ': ' . 
					$row['module_langname'] . '<br />';
				}
			}
			$db->sql_freeresult($result);
		
			echo '[i]Language(s) installed:[/i]<br />';
			$sql = 'SELECT lang_english_name
				FROM ' . LANG_TABLE . '
				ORDER BY lang_english_name';
			$result = $db->sql_query($sql);
			while ($row = $db->sql_fetchrow($result))
			{
				$languages = $row['lang_english_name'];
				echo $languages . '<br />';
			}

			$db->sql_freeresult($result);
			echo '[i]Custom profile field load settings[/i]<br />';
			echo 'Display custom profile fields in memberlist: ' . ($config['load_cpf_memberlist'] ? 'Yes' : 'No') . '<br />';
			echo 'Display custom profile fields in profile: ' . ($config['load_cpf_viewprofile'] ? 'Yes' : 'No') . '<br />';
			echo 'Display custom profile fields in topics: ' . ($config['load_cpf_viewtopic'] ? 'Yes' : 'No') . '<br /><br />';
		}

	if($chk_styles == 'Yes')
		{
			echo '<strong>[b]Styles Info[/b]</strong><br />';
			clearstatcache();
			if (file_exists($phpbb_root_path . 'images/spacer.gif'))
				{
					echo '/images_spacer.gif permissions: ' . substr(sprintf('%o', fileperms($phpbb_root_path . 
						'images/spacer.gif')), -3) . ' <br />';
				}
			else
				{
					echo '/images/spacer.gif could not be found<br />';
				}			
			if (file_exists($phpbb_root_path . 'styles/prosilver/imageset/icon_online.gif'))
				{
					echo '/styles/prosilver/imageset/icon_online.gif permissions: ' . substr(sprintf('%o', fileperms($phpbb_root_path . 
						'styles/prosilver/imageset/icon_online.gif')), -3) . ' <br />';
				}
			else
				{
					echo '/styles/prosilver/imageset/icon_online.gif could not be found<br />';
				}
			if (file_exists($phpbb_root_path . 'styles/prosilver/theme/images/icon_faq.gif'))
				{
					echo '/styles/prosilver/theme/images/icon_faq.gif permissions: ' . substr(sprintf('%o', fileperms($phpbb_root_path . 
						'styles/prosilver/theme/images/icon_faq.gif')), -3) . ' <br />';
				}
			else
				{
					echo '/styles/prosilver/theme/images/icon_faq.gif could not be found<br />';
				}

			$d_style = $config['default_style'];
			$sql = 'SELECT style_name
			FROM ' . STYLES_TABLE . ' 
			WHERE style_id = ' . $d_style;
			$result = $db->sql_query($sql);
			while($row = $db->sql_fetchrow($result))
			{
				echo 'Default style: ' . $row['style_name'] . '<br />';
			}
			$db->sql_freeresult($result);
			
			echo 'Override user style: ' . ($config['override_user_style'] ? 'Yes' : 'No') . '<br />';
			echo 'Recompile stale style components: ' . ($config['load_tplcompile'] ? 'Yes' : 'No') . '<br />';

			echo '[i]Active Styles[/i]<br />';
			$sql = 'SELECT style_name FROM ' . STYLES_TABLE . ' WHERE style_active = "1" ORDER BY style_name ASC';
			$result = $db->sql_query($sql);
			while($row = $db->sql_fetchrow($result))
			{
				echo $row['style_name'] . '<br />';
			}
			$db->sql_freeresult($result);

			$sql = 'SELECT style_name FROM ' . STYLES_TABLE . ' WHERE style_active = "0" ORDER BY style_name ASC';
			$result = $db->sql_query($sql);
			while($row = $db->sql_fetchrow($result))
			{
				if ($row['style_name'])
				{
					echo '[i]Deactivated Style[/i]: ' . $row['style_name'] . '<br />';
				}
			}
			$db->sql_freeresult($result);
			echo '<br />';
		}
		
	if($chk_version == 'Yes')
		{
			echo '<strong>[b]Version Settings[/b]</strong><br />';
			echo 'Number of users: ' . $config['num_users'] . '<br />';
			echo 'Number of topics: ' . $config['num_topics'] . '<br />';
			echo 'Number of posts: ' . $config['num_posts'] . '<br />';
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
echo '<fieldset><legend><strong>If the checkbox is ticked and you press Delete the ' . basename(__FILE__) . ' 
file will be deleted</strong></legend>';
echo '<form action="' . basename(__FILE__) . '" method="post">';
echo '<label><input type="checkbox" name="chkDelete" value="Yes" checked="checked"/>&nbsp;Delete this file&nbsp;</label>'; 
echo '<p><button type="submit">Delete</button></p>';
echo '</form>';
echo '</fieldset>';
if($chk_delete == 'Yes')
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

// Create a link to the board index
// Is the user using HTTPS?
$index_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://';
// Complete the URL
$index_url .= $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.' . $phpEx;

// echo the URL
echo '<br />';
echo '<a style="margin-left: 700px"; href="' . $index_url . '">Board Index</a>';

echo '</body>';
echo '</html>';