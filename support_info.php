<?php
// Copyright © Oyabun1 2013
// version 1.6.1
// license http://opensource.org/licenses/GPL-2.0 GNU General Public License v2

define('IN_PHPBB', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);

// Try to check if the file is in the right place - board root
if (file_exists($phpbb_root_path . 'common.' . $phpEx))
{
	include($phpbb_root_path . 'common.' . $phpEx);
	include($phpbb_root_path . 'config.' . $phpEx);

// Create a HTML5 page to add some form elements and display stuff
echo '<!DOCTYPE html>';
echo '<html>';
echo '<head>';
echo '<meta http-equiv="content-type" content="text/html; charset=UTF-8" />';
echo '<title>' . basename(__FILE__) . '</title>';

echo '<style type="text/css">
	body {
		font-size: 1em;
		background-color: #FFF8DC;
		width: 800px;
	}
	form {
	text-align: center;
	line-height: 230%;
	}

	#selectable {
	cursor: copy;
	line-height: 110%;
	}

	fieldset {   
	-moz-border-radius:7px;  
	border-radius: 7px;  
	-webkit-border-radius: 7px;
	}
	
	legend.legend_ie {
	display: inline-block; 
	position relative; 
	height: 30px; 
	top: -15px;
	}
	
	label {
		cursor: pointer;
		background-color: #b3ffb3;
		border-style: outset;
		border-width; 1px;
		border-radius: 7px;
		border-color: #808080;
		font-size: 1.1em;
		padding: 2px;
		margin: 2px;
	}

	label.disabled {
		cursor: not-allowed;
		-moz-opacity: .5;
		-webkit-opacity: .5;
		opacity: .5;
	}
	
	input[type="checkbox"]{
		cursor: pointer;
	}
	
	input[type="checkbox"]:disabled
	{
		cursor: not-allowed;
		-moz-opacity: .6;
		-webkit-opacity: .6;
		opacity: .6;
	}

	/* Buttons based on Pressable CSS Buttons by Joshua Hibbert */
	.button {
		background-image: -webkit-linear-gradient(hsla(0,0%,100%,.05), hsla(0,0%,0%,.1));
		background-image:    -moz-linear-gradient(hsla(0,0%,100%,.05), hsla(0,0%,0%,.1));
		background-image:     -ms-linear-gradient(hsla(0,0%,100%,.05), hsla(0,0%,0%,.1));
		background-image:      -o-linear-gradient(hsla(0,0%,100%,.05), hsla(0,0%,0%,.1));
		background-image:         linear-gradient(hsla(0,0%,100%,.05), hsla(0,0%,0%,.1));
		border: none;
		border-radius: 1.25em;
		box-shadow: inset 0 0 0 1px hsla(0,0%,0%,.25),
					inset 0 2px 0 hsla(0,0%,100%,.1),
					inset 0 1.2em 0 hsla(0,0%,100%,.05),
					inset 0 -.2em 0 hsla(0,0%,100%,.1),
					inset 0 -.25em 0 hsla(0,0%,0%,.5),
					0 .25em .25em hsla(0,0%,0%,.1);
		color: #fff;
		text-shadow: 0 -1px 1px hsla(0,0%,0%,.25);
		cursor: pointer;
		display: inline-block;
		font-family: sans-serif;
		font-size: 1.1em;
		font-weight: bold;
		line-height: 150%;
		margin: 0 .5em;
		padding: .25em .75em .5em;
		position: relative;
		text-decoration: none;
		vertical-align: middle;
	}
	.button:hover {
		outline: none;
	}
	.button:hover,
	.button:focus {
		box-shadow: inset 0 0 0 1px hsla(0,0%,0%,.25),
					inset 0 2px 0 hsla(0,0%,100%,.1),
					inset 0 1.2em 0 hsla(0,0%,100%,.05),
					inset 0 -.2em 0 hsla(0,0%,100%,.1),
					inset 0 -.25em 0 hsla(0,0%,0%,.5),
					inset 0 0 0 3em hsla(0,0%,100%,.2),
					0 .25em .25em hsla(0,0%,0%,.1);
	}
	.button:active {
		box-shadow: inset 0 0 0 1px hsla(0,0%,0%,.25),
					inset 0 2px 0 hsla(0,0%,100%,.1),
					inset 0 1.2em 0 hsla(0,0%,100%,.05),
					inset 0 0 0 3em hsla(0,0%,100%,.2),
					inset 0 .25em .5em hsla(0,0%,0%,.05),
					0 -1px 1px hsla(0,0%,0%,.1),
					0 1px 1px hsla(0,0%,100%,.25);
		margin-top: .25em;
		outline: none;
		padding-bottom: .5em;
	}
	.red {
		background-color: #8B0000;
	}
	.green {
		background-color: #228B22;
	}
</style>';

echo '</head>';
echo '<body>';
// Some JavaScript used to select all the text to be copied. JavaScript is a tool of demons, but ...
echo '<script type="text/javascript">
    function selectText(txt) {
        if (typeof window.getSelection != "undefined" && typeof document.createRange != "undefined") {
            var range = document.createRange();
            range.selectNodeContents(txt);
            var sel = window.getSelection();
            sel.removeAllRanges();
            sel.addRange(range);
        } else if (typeof document.selection != "undefined" && typeof document.body.createTextRange != "undefined") {
            var textRange = document.body.createTextRange();
            textRange.moveToElementText(txt);
            textRange.select();
        }
    }
</script>';

// Create some checkboxes to select info categories
echo '<!--[if IE]>';
echo '<fieldset><legend class="legend_ie"><strong>Select one or more relevant boxes then press the Show button</strong></legend>';
echo '<![endif]-->';
echo '<!--[if !IE]><!-->';
echo '<fieldset><legend style="display:inline-block"><strong>Select one or more relevant boxes then press the Show button</strong></legend>';
echo '<!--<![endif]-->';
echo '<form action="' . basename(__FILE__) . '" method="post">';
echo '<label title="Anonymous user details"><input type="checkbox" name="chkAnon" value="Yes" />
	Anonymous&nbsp;</label>&nbsp;';
echo '<label title="Activation, countermeasure, and ban info"><input type="checkbox" name="chkASpam"
	value="Yes" />Anti-Spam&nbsp;</label>&nbsp;';
echo '<label title="Attachment settings"><input type="checkbox" name="chkAttach" value="Yes" />
	Attachments&nbsp;</label>&nbsp;';
echo '<label title="AutoMOD settings"><input type="checkbox" name="chkAutomod" value="Yes" />
	AutoMOD&nbsp;</label>&nbsp;';
echo '<label title="Avatar settings"><input type="checkbox" name="chkAvatar" value="Yes" />
	Avatar&nbsp;</label>&nbsp;';
echo '<br />';
	echo '<label title="Cookie settings from database"><input type="checkbox" name="chkCookies" value="Yes" />
	Cookies&nbsp;</label>&nbsp;'; 

echo '<label title="Database (config.php) details"><input type="checkbox" name="chkDbase" value="Yes" />
	Database&nbsp;</label>&nbsp;';
echo '<label title="Email settings"><input type="checkbox" name="chkEmail" value="Yes" />
	Email&nbsp;</label>&nbsp;';
echo '<label title="File check"><input type="checkbox" name="chkFile" value="Yes" />
	Files&nbsp;</label>&nbsp;';
echo '<label title="Some basic stats: users, topics, posts, languages, &amp; stuff like that"><input 
		type="checkbox" name="chkOther" value="Yes" />Other&nbsp;</label>&nbsp;';
echo '<br />';
echo '<label title="Paths and permissions"><input type="checkbox" name="chkPaths" value="Yes" />
		Paths&nbsp;</label>&nbsp;';  

		echo '<label title="PHP settings mainly related to files and images"><input type="checkbox" name="chkPHP"
		value="Yes" />PHP Info&nbsp;</label>&nbsp;';

echo '<label title="ACP Search settings">
		<input type="checkbox" name="chkSearch" value="Yes" /> Search&nbsp;</label>&nbsp;';
	echo '<label title="ACP Server settings, languages & deactivated modules">
		<input type="checkbox" name="chkServer" value="Yes" /> Server&nbsp;</label>&nbsp;';
echo '<label title="Active and Deactivated styles"><input type="checkbox" name="chkStyles" value="Yes" />
		Styles&nbsp;</label>&nbsp;'; 
echo '<label title="Version info"><input type="checkbox" name="chkVersion"
    value="Yes" />Version&nbsp;</label>&nbsp;';
echo '<p><button type="submit" class="button green";>Show</button></p>';
echo '</form>';
echo '</fieldset><br />';
echo '<fieldset style="background-color:#F5FCFF; border-color:#00CC00; border-style: solid;"><legend>
		<strong>Copy and paste the lines below to the appropriate topic at phpbb.com (click to select text)
		</strong></legend>';
// Use the JavaScript from above
echo '<div id="selectable" onclick="selectText(this)">';

// Use request_var() to get the returned values 
// since using $_POST() is discouraged (& phpBB 3.1 will have a dummy spit)
$chk_anon = (request_var('chkAnon', ''));
$chk_aspam = (request_var('chkASpam', ''));
$chk_attach  = (request_var('chkAttach', ''));
$chk_avatar = (request_var('chkAvatar', ''));
$chk_automod = (request_var('chkAutomod', ''));
$chk_cookies = (request_var('chkCookies', ''));
$chk_dbase = (request_var('chkDbase', ''));
$chk_email = (request_var('chkEmail', ''));
$chk_file = (request_var('chkFile', ''));
$chk_other = (request_var('chkOther', ''));
$chk_paths = (request_var('chkPaths', ''));
$chk_php = (request_var('chkPHP', ''));
$chk_search = (request_var('chkSearch', ''));
$chk_server = (request_var('chkServer', ''));
$chk_styles = (request_var('chkStyles', ''));
$chk_version = (request_var('chkVersion', ''));
$chk_delete = (request_var('chkDelete', ''));

// Some variables to check if 3.1.x
$version = PHPBB_VERSION;
$vers_num = '3.1.';
$ascraeus = strpos($version, $vers_num);

// A function to get around PHP shortcuts in php.ini values
// borrowed from http://www.php.net/manual/de/faq.using.php#78405
function convertBytes($value) 
{
	if(is_numeric($value)) 
	{
		return $value;
	} 
	else 
	{
		$value_length = strlen($value);
		$qty = substr($value, 0, $value_length - 1);
		$unit = strtolower(substr( $value, $value_length - 1));
		switch ($unit) 
		{
			case 'k':
				$qty *= 1024;
				break;
			case 'm':
				$qty *= 1048576;
				break;
			case 'g':
				$qty *= 1073741824;
				break;
			}
		return $qty;
	}
}

// Create a few variables to shorten lines below
$u_m_f = convertBytes(ini_get('upload_max_filesize'));
$p_m_s = convertBytes(ini_get('post_max_size'));
$m_l = convertBytes(ini_get('memory_limit'));

// Grab the data and display it depending on which checkboxes are selected
	if ($chk_anon == 'Yes')
	{
		echo '<strong>[b]Anonymous User[/b]</strong><br />';

		$sql = 'SELECT username, username_clean
		FROM ' . USERS_TABLE . '
		WHERE user_id = "1"';
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result))
		{
			if ($row['username_clean'] != 'anonymous')
			{
				echo 'Database user_id 1 is: ' . $row['username'] .
					' || username_clean: ' . $row['username_clean'] . '<br />';
			}
		}
		$db->sql_freeresult($result);		
		
		if(defined('ANONYMOUS'))
		{
			echo 'Constant user_id: ' . ANONYMOUS . '<br />';
		}
		else
		{
			echo 'Anonymous constant not defined (constant not accessible)<br />';
		}

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
		
		$sql = 'SELECT s.style_id, s.style_name
		FROM ' . STYLES_TABLE . ' s
		LEFT JOIN ' . USERS_TABLE . ' u
		ON (s.style_id = u.user_style)
		WHERE u.username_clean = "anonymous"';
		$result = $db->sql_query($sql);
		while($row = $db->sql_fetchrow($result)) 
		{
			echo 'Style used: ' . $row['style_name'] . ' : style_id: ' . $row['style_id'] . '<br >';
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
		
		$sql = 'SELECT u.user_id, u.username, u.username_clean
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
		echo 'Authentication method: ' . $config['auth_method'] . '<br />';
		echo 'Spambot countermeasures for registrations: ' . ($config['enable_confirm'] ? 'Yes' : 'No') . '<br />';
		// Convert config numerical value to appropriate text
		switch($config['require_activation'])
		{
		case 0:
			$activation = 'No activation (immediate access)';
			break;
		case 1:
			$activation = 'By user (email verification)';
			break;
		case 2:
			$activation = 'By Admin';
			break;
		case 3:
			$activation = 'Disabled';
			break;
		}
		echo 'Account activation: ' . $activation . '<br />';
		echo 'New member post limit: '  . $config['new_member_post_limit'] . '<br />';
			$sql = 'SELECT config_name, config_value FROM ' . CONFIG_TABLE . ' 
			WHERE config_name = "captcha_plugin"';
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
		case 'phpbb_keycaptcha':
			$captcha_id = 'KeyCAPTCHA';
			break;
		case 'phpbb_solvemedia':
			$captcha_id = 'Solve Media Captcha Puzzle';
			break;
		case 'phpbb_captcha_math':
			$captcha_id = 'Crazy Maths CAPTCHA';
			break;
		// May have missed some so ...
		default:
			$captcha_id = '$captcha_id_value';
			break;
		}
		echo 'Spambot Countermeasure: ' . $captcha_id . '<br />';
		$db->sql_freeresult($result);
		// Check if GD library loaded and see if .png used by GD Image
		if (extension_loaded('gd') && function_exists('gd_info'))
		{
			$gdinfoarray = gd_info();
			$gdversion = $gdinfoarray['GD Version'];
			echo 'GD library version: ' . $gdinfoarray['GD Version'] . '<br />';
			echo 'GD Image (.png) support: ' . (($gdinfoarray['PNG Support'] == true) ? 'Yes' : 'No') . '<br />';
			echo 'PHP imagecreatetruecolor() exists: ' . (function_exists('imagecreatetruecolor')  ? 'Yes' : 'No') . '<br />';
		}
		else
		{
			echo 'GD library not found<br />';
		}
		echo ' Username length: ' . $config['min_name_chars'] . ' min ' . 
			$config['max_name_chars'] . ' max <br />';

		switch($config['allow_name_chars'])
		{
		case 'USERNAME_CHARS_ANY':
			$u_complex = 'Any character';
			break;
		case 'USERNAME_ALPHA_ONLY':
			$u_complex = 'Alphanumeric only';
			break;
		case 'USERNAME_ALPHA_SPACERS':
			$u_complex = 'Alphanumeric and spacers';
			break;
		case 'USERNAME_LETTER_NUM':
			$u_complex = 'Any letter and number';
			break;
		case 'USERNAME_LETTER_NUM_SPACERS':
			$u_complex = 'Any letter, number, and spacer';
			break;
		case 'USERNAME_ASCII':
			$u_complex = 'ASCII (no international unicode)';
			break;
		case '':
			$u_complex = 'Unset (incorrect setting)';
			break;
		default:
			$u_complex = 'custom = ' . $config['allow_name_chars'] . '';
			break;
		}
		echo 'Username characters: ' . $u_complex . '<br />';
		
		echo 'Password length: ' . $config['min_pass_chars'] . ' min ' . $config['max_pass_chars'] . ' max <br />';
			switch($config['pass_complex'])
		{
		case 'PASS_TYPE_ANY':
			$p_complex = 'No requirements';
			break;
		case 'PASS_TYPE_CASE':
			$p_complex = 'Must be mixed case';
			break;
		case 'PASS_TYPE_ALPHA':
			$p_complex = 'Must contain letters and numbers';
			break;
		case 'PASS_TYPE_SYMBOL':
			$p_complex = 'Must contain symbols';
			break;
		case '':
			$p_complex = 'Unset (incorrect setting)';
			break;
		default:
			$p_complex = ($config['pass_complex']);
			break;
		}
		echo 'Password complexity: ' . $p_complex . '<br />';
			
		if ($config['chg_passforce'] == '0')
		{
			echo 'Force password change: Disabled<br />';
		}
		else
		{
			echo 'Force password change: ' .  $config['chg_passforce'] . ' days<br />';
		}
		
		echo 'Allow email address re-use: ' . ($config['allow_emailreuse']  ? 'Yes' : 'No') . '<br />';
		
		$sql = 'SELECT COUNT(ban_ip) AS banned_ips FROM ' . BANLIST_TABLE . ' WHERE (ban_ip <> "")';
		$result = $db->sql_query($sql);
		$banned_ips = (int) $db->sql_fetchfield('banned_ips');
		echo 'Banned IPs: ' . $banned_ips . '<br />';
		$db->sql_freeresult($result);

		$sql = 'SELECT COUNT(ban_email) AS banned_emails FROM ' . BANLIST_TABLE . ' 
			WHERE (ban_email <> "")';
		$result = $db->sql_query($sql);
		$banned_emails = (int) $db->sql_fetchfield('banned_emails');
		echo 'Banned Email Addresses: ' . $banned_emails . '<br />';
		$db->sql_freeresult($result);

		$connection = @fsockopen("whois.arin.net", 43);
		if ($connection) 
		{
			echo 'Port 43 to whois.arin.net is open.<br />';
			fclose($connection);
		} 
		else 
		{
			echo 'Port 43 to whois.arin.net is not open.<br />';
		}
		echo '<br />';
	}
	if ($chk_attach  == 'Yes')
	{
		echo '<strong>[b]Attachments[/b]</strong><br />';
		echo 'Allow attachments: ' . ($config['allow_attachments']  ? 'Yes' : 'No') . '<br />';
		echo 'Allow attachments in PMs: ' . ($config['allow_pm_attach']  ? 'Yes' : 'No') . '<br />';
		echo 'Upload directory: /' . $config['upload_path'] . '/<br />';
		if ($config['upload_path'] != '')
			{
				echo 'Upload directory permissions: ' . substr(decoct(fileperms($phpbb_root_path . 
				($config['upload_path']))), 2) . ' <br />';
			}
		echo 'Attachment display order: ' . ($config['display_order']  ? 'Ascending' : 'Descending') . '<br />';
		// Sizes are stored as bytes to convert we use the phpBB get_formatted_filesize()
		echo 'Size of posted attachments:  ' . get_formatted_filesize($config['upload_dir_size']) . '<br />';
		if ($config['attachment_quota'] != '0')
			{
			$quota1 = get_formatted_filesize($config['attachment_quota']);
			}
			else
			{
			$quota1 = 'Host limit';
			}
		echo 'Total attachment quota: ' . $quota1 . '<br />';
		// Determining the actual maximum file size is too difficult and will vary between users so we'll make
		// a guesstimate based on the lowest of upload_max_filesize, post_max_size, and memory_limit
		$php_max_file =  min($u_m_f, $p_m_s, $m_l);
		$f_php_max_file = get_formatted_filesize($php_max_file);

		if ($config['max_filesize'] != '0')
		{
			if($config['max_filesize'] > $php_max_file)
			{
				echo 'Maximum file size of ' . get_formatted_filesize($config['max_filesize']) . ' 
				exceeds estimated server PHP limit of ' . $f_php_max_file .'<br />';
			}
			elseif ($config['max_filesize'] < $php_max_file)
			{
				echo 'Maximum file size of ' . get_formatted_filesize($config['max_filesize']) . ' 
				less than estimated server PHP limit of ' . $f_php_max_file .'<br />';
			}
			else //($config['max_filesize'] == $php_max_file)
			{
				echo 'Maximum file size of ' . get_formatted_filesize($config['max_filesize']) . ' 
				equals estimated server PHP limit of ' . $f_php_max_file .'<br />';
			}
		}
		else
		{
			echo 'Maximum file size is unset so will equal estimated server PHP limit of ' . $f_php_max_file .'<br />';
		}
		if ($config['max_filesize_pm'] != '0')
			{
			$quota3 = get_formatted_filesize($config['max_filesize_pm']);
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
			echo 'Maximum thumbnail file size: ' . get_formatted_filesize($config['img_min_thumb_filesize']) . '<br />';
		}
		echo 'Imagemagick path: ' . $config['img_imagick'] . '<br />';
		echo 'Maximum image dimensions: ' . $config['img_max_width'] . ' &times; ' . $config['img_max_height'] . ' 
		px (width &times; height)<br />';
		echo 'Image link dimensions: ' . $config['img_link_width'] . ' &times; ' . $config['img_link_height'] . ' 
		px (width &times; height)<br /><br />';
		
		$sql = 'SELECT group_name, max_filesize FROM ' . EXTENSION_GROUPS_TABLE . ' WHERE max_filesize > 0 ';
		$result = $db->sql_query($sql);
		while($row = $db->sql_fetchrow($result))
		{
			if ($config['max_filesize'] != '0')
			{
				if ($row['max_filesize'] > $config['max_filesize'])
				{
					echo 'Max filesize for extension group ' . (ucfirst(strtolower($row['group_name']))) . 
					': [color=#FF0000]' . get_formatted_filesize($row['max_filesize']) . '[/color]<br />';
				}
				elseif ($row['max_filesize'] < $config['max_filesize'])
				{
					echo 'Max filesize for extension group ' . (ucfirst(strtolower($row['group_name']))) . 
					': [color=#008000]' . get_formatted_filesize($row['max_filesize']) . '[/color]<br />';
				}
				else
				{
					echo 'Max filesize for extension group ' . (ucfirst(strtolower($row['group_name']))) . 
					': ' . get_formatted_filesize($row['max_filesize']) . '<br />';
				}
			}
			else 
			{
				if ($row['max_filesize'] > $php_max_file)
				{
					echo 'Max filesize for extension group ' . (ucfirst(strtolower($row['group_name']))) . 
					': [color=#FF0000]' . get_formatted_filesize($row['max_filesize']) . '[/color]<br />';
				}
				elseif ($row['max_filesize'] < $php_max_file)
				{
					echo 'Max filesize for extension group ' . (ucfirst(strtolower($row['group_name']))) . 
					': [color=#008000]' . get_formatted_filesize($row['max_filesize']) . '[/color]<br />';
				}
				else
				{
					echo 'Max filesize for extension group ' . (ucfirst(strtolower($row['group_name']))) . 
					': ' . get_formatted_filesize($row['max_filesize']) . '<br />';
				}			
			}
		}
		$db->sql_freeresult($result);

		$sql = 'SELECT extension FROM ' . EXTENSIONS_TABLE . '';
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result))
		{
			if (preg_match("/^[^[:alnum:]]/", $row['extension']))
			{
			echo 'Extension with non alphanumeric first character: ' . $row['extension'] . '<br />';
			}
		}
		$db->sql_freeresult($result);
		echo '<br />';
	}
	if ($chk_automod == 'Yes')
	{
		echo '<strong>[b]AutoMOD Settings[/b]</strong><br />';
		if (file_exists($phpbb_root_path . 'includes/functions_mods.' . $phpEx))
		{
			global $table_prefix;
			define('MODS_TABLE', $table_prefix . 'mods');
			echo 'AutoMOD version: ' . ($config['automod_version']  ? $config['automod_version'] : 'Not found') . '<br />';
			switch ($config['write_method'])
				{
				 case 1:
					echo 'Write method: Direct<br />';
					if (!is_writable("{$phpbb_root_path}common.$phpEx") || !is_writable("{$phpbb_root_path}adm/style/acp_groups.html"))
					{
						echo 'File system not writable<br />';
					}				
					break;
				 case 2:
					echo 'Write method: FTP<br />';
					switch (@$config['ftp_method'])
					{
					case "ftp":
						echo 'Upload method: FTP<br />';
						break;
					case "ftp_fsock":
						echo 'Upload method: Simple Socket<br />';
						break;						
					}
					echo 'FTP host: ' . @$config['ftp_host'] . '<br />'; 
					echo 'FTP username: ' . @$config['ftp_username'] . '<br />'; 
					echo 'Path to phpBB: ' . @$config['ftp_root_path'] . '<br />'; 
					echo 'FTP port: ' . @$config['ftp_port'] . '<br />'; 
					echo 'FTP timeout: ' . @$config['ftp_timeout'] . '<br />'; 
					break;
				 case 3:
					echo 'Write method: Compressed File Download<br />';
					echo 'Compressed file type: ' . $config['compress_method'] . '<br />';
					break;
				 default:
					echo 'Write method: Not known<br />';
					break;
				}
			echo 'File permissions: ' . @$config['am_file_perms'] . '<br />';
			echo 'Directory permissions: ' . @$config['am_dir_perms'] . '<br />';
			echo 'Preview changes: ' . (@$config['preview_changes'] ? 'Yes' : 'No') . '<br />';
			echo '[c]/store/mods/[/c] permissions: ' . substr(decoct(fileperms($phpbb_root_path . 'store/mods')), 2) .
					 ' <br />';			
			// Count the MODs
			$sql = 'SELECT COUNT(*) AS mod_cnt FROM ' . MODS_TABLE . '';
			$result = $db->sql_query($sql);
			$mod_cnt = (int) $db->sql_fetchfield('mod_cnt');
			echo 'MODs in mods table: ' . $mod_cnt . '<br /><br />';
			$db->sql_freeresult($result);
		}
		else
		{
			echo '[c]/includes/functions_mods.php[/c] not found<br />AutoMOD is not correctly installed<br /><br />';
		}
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
			echo 'Maximum avatar file size: ' . get_formatted_filesize($config['avatar_filesize']) . '<br />';
			}
			else
			{
			echo 'Maximum avatar file size: PHP limit<br />';
			}
		echo 'Minimum avatar dimensions: ' . $config['avatar_min_width'] . ' &times; ' . 
		$config['avatar_min_height'] . ' px (width &times; height)<br />';
		echo 'Maximum avatar dimensions: ' . $config['avatar_max_width'] . ' &times; ' . 
		$config['avatar_max_height'] . ' px (width &times; height)<br />';
		echo 'Avatar storage path: ' . $config['avatar_path'] . '<br />';
		if ($config['avatar_path'] != '')
			{
				echo 'Avatar storage folder permissions: ' . substr(decoct(fileperms($phpbb_root_path . 
				($config['avatar_path']))), 2) . ' <br />';
			}
		echo 'Avatar gallery path: ' . $config['avatar_gallery_path'] . '<br />';
		if ($config['avatar_gallery_path'] != '')
			{
				echo 'Avatar gallery folder permissions: ' . substr(decoct(fileperms($phpbb_root_path . 
				($config['avatar_gallery_path']))), 2) . ' <br />';
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
		include_once($phpbb_root_path . 'includes/functions_admin.' . $phpEx);
		echo '<strong>[b]Database Settings[/b]</strong><br />';
		echo 'Database system: ' . $db->sql_server_info() . '<br />';
		echo 'Database size: ' . get_database_size() . '<br />';
		echo 'Database host: ' . $dbhost . '<br />';
		echo 'Database port: ' . $dbport . '<br />';
		echo 'Database name: ' . $dbname . '<br />';
		echo 'Database user: ' . $dbuser . '<br />';
		// We don't want the password posted publicly so we'll check if it is blank
		if(mb_strlen($dbpasswd, 'UTF-8') > 0)
		{
			echo 'Database password: {removed}<br />';
		}
		else
		{
			echo 'Database password: is blank<br />';
		}
		echo 'Table prefix: ' . $table_prefix . '<br />';
		echo 'Cache ($acm_type): ' . $acm_type . '<br />';
		echo 'PHP extensions ($load_extensions): ' . $load_extensions . '<br />';
		$config_lc = count(file($phpbb_root_path . 'config.' . $phpEx));
		echo 'config.php line count: ' . $config_lc . ' ';
		$config_n = ($ascraeus !== false) ? 15 : 16;
		if ($config_lc == $config_n)
		{
			echo '(standard number of lines)<br />';
		}
		else if ($config_lc < $config_n)
		{
			echo '(' . ($config_n - $config_lc) . ' lines less than standard)<br />';
		}
		else
		{
			echo '(' . ($config_lc - $config_n)  . ' lines more than standard)<br />';
		}
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
		// Only include SMTP settings if it is enabled
		if ($config['smtp_delivery'] == 1)
		{
			echo 'SMTP server address: ' . $config['smtp_host'] . '<br />';
			echo 'SMTP server port: ' . $config['smtp_port'] . '<br />';
			echo 'Authentication method for SMTP: ' . (ucfirst(strtolower($config['smtp_auth_method']))) . '<br />';
			$smtp_user = ($config['smtp_username']);
			// We'll replace the local part of the email address with asterisks
			$smtp_split = strrpos($smtp_user, "@");
			$local = preg_replace('(.)', '*', (substr($smtp_user, 0, $smtp_split)));
			$domain = substr($smtp_user, $smtp_split);
			echo 'SMTP username: ' . $local . $domain . '<br />';		
			// We probably don't need the actual password either so we'll replace and count the characters in it
			$smtp_psd = preg_replace('[.]u', '*', $config['smtp_password']);
			echo 'SMTP password: ' . $smtp_psd . ' (' . strlen($smtp_psd) . ' characters) <br />'; 
		}
		echo '<br />';
	}

	if($chk_file == 'Yes')
	{
		echo '<strong>[b]File Check[/b]</strong><br />';
		echo 'Check first 5 characters of PHP files (should be: ' . htmlspecialchars('<?php') . ')<br />';
		/**
		* Check first line of PHP files to see if it is only "<?php"
		* (285 PHP files in installed 3.0.12)
		* Just doing a BOM check wouldn't find blank lines, spaces, code mistakenly added at start of file, ...
		* Only check the start of the file - that is the most common problem and checking the end is too hard
		* Based on some code from php.net
		*/
		// This iteration method probably won't always be available, so check if class exists
		$time_start = microtime(true); 
		if (class_exists('RecursiveDirectoryIterator'))
		{
			// SETTINGS
			$check_extensions = array('php');
			$compare = htmlspecialchars('<?php');
			$file = null;
			$root = dirname(__FILE__);
			 
			// MAIN
			$rit = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($phpbb_root_path), RecursiveIteratorIterator::CHILD_FIRST);
			try
			{
				foreach ($rit as $file)
				{
					if ($file->isFile())
					{
						$path_parts = pathinfo($file->getRealPath());
			 
						if (isset($path_parts['extension']) && in_array($path_parts['extension'],$check_extensions))
						{
							$object = new SplFileObject($file->getRealPath());
							$fchk = htmlspecialchars(file_get_contents($file, NULL, NULL, 0, 5));
							if (strncasecmp($fchk, $compare, 5) !== 0)
							{
								echo str_replace($root, '', $file) . ' first 5 characters: ' . $fchk . ' : [color=#FF0000]NOT correct[/color]<br />';
							}
						}
					}
				}
			}
			catch (Exception $e)
			{
				die ('Exception caught: '. $e->getMessage());
			}
		}
		elseif (file_get_contents(__FILE__))
		// If we can't easily iterate through all files, we'll try with glob, and check 5 nodes
		// N.B. 3.1 has files which are 8+ nodes deep, but this method probably won't ever be used for that
		{
			echo 'First 5 characters of PHP files (should be ' . htmlspecialchars('<?php') . ') of:<br />';
			echo '(Only checked first 5 directory nodes)<br />';
			// Check if the functions used is available
			
			$compare = htmlspecialchars('<?php');
		
			foreach(glob($phpbb_root_path . '{*.php,*/*.php,*/*/*.php,*/*/*/*.php,*/*/*/*/*.php}', GLOB_BRACE) as $filetochk)
			{
				$fchk = htmlspecialchars(file_get_contents($filetochk, NULL, NULL, 0, 5));
			
				if (strncasecmp($fchk, $compare, 5) !== 0)
				{
					 echo $filetochk . ' are: ' . $fchk . ' <span style="color:red">NOT correct</span><br />';
				}
			}
		}
		else
		{
			echo 'Tried methods unsupported by server<br />';
		}
		unset($fchk);
		echo '<br />';
		$time_end = microtime(true);
		$totaltime = round($time_end - $time_start, 2);
		// Usually completes in < 10 secs. A check on a board with 100+ MODs and low resources took 124 secs
		echo 'File check finished in: ' . $totaltime . ' seconds (wall-clock time)<br /><br />';
	}
	
	if ($chk_other == 'Yes')
	{
		echo '<strong>[b]Other Stats[/b]</strong><br />';
				// Count all the files, including images, attachments, MODs, styles, etc.
		function getFileCount($path) 
		{
			$size = 0;
			$ignore = array('.', '..');
			$files = scandir($path);
			foreach($files as $t) 
			{
				if(in_array($t, $ignore)) continue;
				if (is_dir(rtrim($path, '/') . '/' . $t)) {
					$size += getFileCount(rtrim($path, '/') . '/' . $t);
				} else {
				$size++;
			}   
			}
			return $size;
		}
		echo 'Total files (not just .php files): ' . getFileCount($phpbb_root_path) . '<br />';
		$sql = 'SELECT COUNT(*) AS sessions_cnt FROM ' . SESSIONS_TABLE . '';
		$result = $db->sql_query($sql);
		$sessions_count = (int) $db->sql_fetchfield('sessions_cnt');
		echo 'Rows in sessions table: ' . $sessions_count . '<br />';
		$db->sql_freeresult($result);

		$sql = 'SELECT COUNT(*) AS sessions_k_cnt FROM ' . SESSIONS_KEYS_TABLE . '';
		$result = $db->sql_query($sql);
		$sessions_k_count = (int) $db->sql_fetchfield('sessions_k_cnt');
		echo 'Rows in sessions_keys table: ' . $sessions_k_count . '<br />';
		$db->sql_freeresult($result);

		// Get the values stored in config table and do a count on respective tables
		// May be differences if data has been incorrectly deleted from DB
		echo 'Number of users (config table): ' . $config['num_users'] . '<br />';
		$sql = 'SELECT COUNT(user_id) AS user_id_cnt FROM ' . USERS_TABLE . ' 
		WHERE user_type != 2 ';
		$result = $db->sql_query($sql);
		$users_count = (int) $db->sql_fetchfield('user_id_cnt');
		echo 'Number of users (users table): ' . $users_count . '<br />';
		$db->sql_freeresult($result);
		echo 'Number of topics (config table): ' . $config['num_topics'] . '<br />';
		$sql = 'SELECT COUNT(topic_id) AS topic_id_cnt FROM ' . TOPICS_TABLE . '';
		$result = $db->sql_query($sql);
		$topics_count = (int) $db->sql_fetchfield('topic_id_cnt');
		echo 'Number of topics (topics table): ' . $topics_count . '<br />';
		$db->sql_freeresult($result);
		echo 'Number of posts (config table): ' . $config['num_posts'] . '<br />';
		$sql = 'SELECT COUNT(post_id) AS post_id_cnt FROM ' . POSTS_TABLE . '';
		$result = $db->sql_query($sql);
		$posts_count = (int) $db->sql_fetchfield('post_id_cnt');
		echo 'Number of posts (posts table): ' . $posts_count . '<br />';
		$db->sql_freeresult($result);
		$sql = 'SELECT MAX(user_id) AS max_user FROM ' . USERS_TABLE . '';
		$result = $db->sql_query($sql);
		$max_user = (int) $db->sql_fetchfield('max_user');
		echo 'Maximum user_id: ' . $max_user . '<br />';
		$db->sql_freeresult($result);
		
		if (($db->sql_layer = 'mysql4') || ($db->sql_layer = 'mysqli'))
		{
			$result = $db->sql_query('SHOW TABLE STATUS LIKE \'' . USERS_TABLE . '\'');
			$next_increment = $db->sql_fetchrow($result);
		{
				$next_id = '';
					if (isset($next_increment['Auto_increment']))
					{
						$next_id = $next_increment['Auto_increment'];
					}
			}
			echo 'Next auto_increment user_id: ' . $next_id . '<br />';
			$db->sql_freeresult($result);
		}
			
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
		echo '<br />';
	}

	if($chk_paths == 'Yes')
	{
		echo '<strong>[b]Paths and Permissions[/b]</strong><br />';
		clearstatcache();  // Necessary for getting updated permissions
		echo '$phpbb_root_path: ' . $phpbb_root_path . '<br />';
		echo 'Path to this file: ' . __FILE__ . '<br />';
		if (file_exists($phpbb_root_path . 'install'))
		{
			echo '[color=#CC0000][c]/install/[/c] directory exists[/color]<br />'; 
		}
		if ($ascraeus !== false)
		{
			echo 'Enable URL Rewriting: ' . ($config['enable_mod_rewrite'] ? 'Yes' : 'No') . '<br />';
			if (!function_exists('apache_get_modules'))
			{
				echo 'Can\'t check if mod_rewite enabled<br />';
			}
			else
			{
				if(in_array('mod_rewrite',apache_get_modules()))
				echo 'mod_rewrite enabled<br />';
			}
		$res = 'Module Unavailable';
		if(in_array('mod_rewrite',apache_get_modules())) 
		$res = 'Module Available';
		}
		echo 'Post icons path: ' . $config['icons_path'] . '<br />';
		if ($config['icons_path'] != '')
		{
			echo 'Post icons folder permissions: ' . substr(decoct(
                    fileperms($phpbb_root_path . ($config['icons_path']))), 2) . ' <br />';
		}
		echo 'Ranks path: ' . $config['ranks_path'] . '<br />';
		if ($config['ranks_path'] != '')
		{
			echo 'Ranks folder permissions: ' . substr(decoct(fileperms($phpbb_root_path . 
			($config['ranks_path']))), 2) . ' <br />';	
		}
		echo 'Smilies path: ' . $config['smilies_path'] . '<br />';
		if ($config['smilies_path'] != '')
		{
			echo 'Smilies folder permissions: ' . substr(decoct(fileperms($phpbb_root_path . 
			($config['smilies_path']))), 2) . ' <br />';
		}
		echo 'config.php permissions: ' . substr(decoct(fileperms($phpbb_root_path . 'config.' . 
		$phpEx)), 3) . '<br />';
		if (file_exists($phpbb_root_path . 'adm/index.' . $phpEx))
		{
			echo '/adm/index.php permissions: ' . substr(decoct(fileperms($phpbb_root_path .
                'adm/index.' . $phpEx)), 3) . ' <br />';
		}
		else
		{
			echo '/adm/index.php not found<br />';
		}
		if (file_exists($phpbb_root_path . 'includes/captcha'))
		{
			echo '/includes/captcha/ permissions: ' . substr(decoct(fileperms($phpbb_root_path . 
				'includes/captcha')), 2) . ' <br />';
		}
		else
		{
			echo '/includes/captcha not found<br />';
		}
		if (file_exists($phpbb_root_path . 'cache'))
		{
			echo '/cache/ permissions: ' . substr(decoct(fileperms($phpbb_root_path . 'cache')), 2) .
                      ' <br />';
		}
		else
		{
			echo '/cache/ not found<br />';
		}
		if (file_exists($phpbb_root_path . 'files'))
		{
			echo '/files/ permissions: ' . substr(decoct(fileperms($phpbb_root_path . 'files')), 2) .
                      ' <br />';
		}
		else
		{
			echo 'files/ not found<br />';
		}
		if (file_exists($phpbb_root_path . 'store'))
		{
			echo 'store/ permissions: ' . substr(decoct(fileperms($phpbb_root_path . 'store')), 2) .
                      ' <br />';
		}
		else
		{
			echo 'store/ not found<br />';
		}
		if (file_exists($phpbb_root_path . 'store/mods'))
			{
			echo 'store/mods permissions: ' . substr(decoct(fileperms($phpbb_root_path . 
			'store/mods/')), 2) . ' <br /><br />';
		}
		else
		{
			echo 'store/mods/ not found<br /><br />';
		}
	}
	
	if ($chk_php == 'Yes')
	{
		echo '<strong>[b]PHP Values[/b]</strong><br />';
		echo 'PHP version: ' . PHP_VERSION . '<br />'; 
		echo 'PHP safe mode: ' . ((@ini_get('safe_mode') == '1' ||
			strtolower(@ini_get('safe_mode')) == 'on') ? 'On' : 'Off') . '<br />';
		echo 'zlib.output_compression: ' . (@ini_get('zlib.output_compression') ? 'On' : 'Off') . '<br />';	
		if (@ini_get('open_basedir'))
			{
				echo 'open_basedir restrictions: ' . (ini_get('open_basedir')) . '<br />';
			}
		echo 'upload_max_filesize: ' . get_formatted_filesize($u_m_f) . '<br />';
		echo 'post_max_size: ' . get_formatted_filesize($p_m_s) . '<br />';
		echo 'memory_limit: ' . get_formatted_filesize($m_l) . '<br />';
		echo '&#8756; Estimated maximum file upload size: &#8804; ' . 
			get_formatted_filesize(min($u_m_f, $p_m_s, $m_l)) . '<br />';
		echo 'max_file_uploads: ' . (ini_get('max_file_uploads')) . '<br />';
		echo 'Max execution time: ' . (int)(ini_get('max_execution_time')) . ' secs<br />';
		echo 'Max input time: ' . (int)(ini_get('max_input_time')) . ' secs<br />';
		echo 'max_input_vars: ' . (int)(ini_get('max_input_vars')) . '<br />';
		echo 'file_uploads: ' . ((@ini_get('file_uploads') == '1' || strtolower
			(@ini_get('file_uploads')) == 'on') ? 'Enabled' : 'Disabled') . '<br />';
		echo 'allow_url_fopen: ' . ((@ini_get('allow_url_fopen') == '1' || 
			strtolower(@ini_get('allow_url_fopen')) == 'on') ? 'Enabled' : 'Disabled') . '<br />';
		// Check if some PHP extensions are available
		$loaded_ext = get_loaded_extensions();
		$modules_maybe = array('curl', 'ftp', 'pcre', 'zlib', 'mbstring', 'libxml', 'gd', 'mysqli', 'imagick', 'json');
		$compared = array_diff($modules_maybe, $loaded_ext);
			foreach($compared as $not_loaded)
			{
				echo $not_loaded . ' PHP extension not available<br />';
			}
			unset($not_loaded);
		// Quick check if ImageMagick "convert" program exists.
		function exec_enabled() 
		{
		$disabled = explode(',', ini_get('disable_functions'));
		return !in_array('exec', $disabled);
		}
		if (exec_enabled() == true)
		{
			exec("convert -version", $out, $rvar); 
			if ($rvar == 0)
			{
				echo 'ImageMagick: exists<br />';
			}
			else
			{
				echo 'ImageMagick: not found<br />';
			}
		}
		else
		{
			echo 'Check if ImageMagick operating not made, exec() disabled on server<br />';
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
	if($chk_search == 'Yes')
	{
		echo '<strong>[b]Search Settings[/b]</strong><br />';
		echo 'Enable search: ' . ($config['load_search'] ? 'Yes' : 'No') . '<br />';
		echo 'User search flood interval: ' . $config['search_interval'] . ' seconds<br />';
		echo 'Guest search flood interval: ' . $config['search_anonymous_interval'] . ' seconds<br />';
		echo 'Search page system load: ' . $config['limit_search_load'] . '<br />';
		echo 'Min author name: ' . $config['min_search_author_chars'] . ' characters<br />';
		echo 'Max number of keywords: ' . $config['max_num_search_keywords'] . '<br />';
		echo 'Search result cache: ' . $config['search_store_results'] . ' seconds<br />';
		echo 'Search backend: ' . $config['search_type'] . '<br />';
		if ($config['search_type'] == 'fulltext_mysql')
		{
			if (version_compare(PHP_VERSION, '5.1.0', '>=') || 
			(version_compare(PHP_VERSION, '5.0.0-dev', '<=') && version_compare(PHP_VERSION, '4.4.0', '>=')))
			{
				// While this is the proper range of PHP versions, PHP may not be linked with the 
				// bundled PCRE lib and instead with an older version
				if (@preg_match('/\p{L}/u', 'a') !== false)
				{
					echo 'Support for UTF-8 characters using PCRE: Yes (PHP ' . phpversion() . ')<br />';
				}
				else
				{
					echo 'Support for UTF-8 characters using PCRE: No<br />';
				}
			}
			echo 'Support for UTF-8 characters using mbstring: ' . (function_exists('mb_ereg') ?
                    'Yes' : 'No') . '<br />';
			echo 'Min characters indexed: ' . $config['fulltext_mysql_min_word_len'] . '<br />';
			echo 'Max characters indexed: ' . $config['fulltext_mysql_max_word_len'] . '<br />';		
		}
		elseif ($config['search_type'] == 'fulltext_native')
		{
			echo 'Enable fulltext updating: ' . ($config['fulltext_native_load_upd'] ?
                    'Yes' : 'No') . '<br />';
			echo 'Min characters indexed: ' . $config['fulltext_native_min_chars'] . '<br />';
			echo 'Max characters indexed: ' . $config['fulltext_native_max_chars'] . '<br />';
			echo 'Common word threshold: ' . $config['fulltext_native_common_thres'] . '%<br />';
		}
		else
		{
			echo 'Search backend settings not available<br />';
		}
		echo '<br />';
	}
	if($chk_server == 'Yes')
	{
		echo '<strong>[b]Server Settings[/b]</strong><br />';
		echo 'Force server URL settings: ' . ($config['force_server_vars'] ? 'Yes' : 'No') . '<br />';
		// If server settings forced show server settings as red, else green
		if ($config['force_server_vars'] == 1)
		{
			echo '[color=#008000]ACP server URL settings[/color]<br />';
		}
		else
		{
			echo '[color=#BF0040]ACP server URL  settings[/color]<br />';
		}
		echo 'Server protocol: ' . $config['server_protocol'] . '<br />';
		echo 'Domain name: ' . $config['server_name'] . '<br />';
		echo 'Server port: ' . $config['server_port'] . '<br />';
		echo 'Script path: ' . $config['script_path'] . '<br />';
		// If server settings not forced show phpBB determined settings as green, else red
		if ($config['force_server_vars'] == 0)
		{
			echo '[color=#008000]phpBB determined server URL settings[/color]<br />';
		}
		else
		{
			echo '[color=#BF0040]phpBB determined server URL  settings[/color]<br />';
		}
		// Determined values code mostly from includes/session.php and functions.php
		$cookie_secure = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 1 : 0;
		$server_protocol = (($cookie_secure) ? 'https://' : 'http://');
		echo 'Server protocol: ' . $server_protocol . '<br />';		

if ($ascraeus === false)
{
		function extract_current_hostname()
		{
			global $config;
			// Get hostname
			$host = (!empty($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST'] : ((!empty($_SERVER['SERVER_NAME']))
				? $_SERVER['SERVER_NAME'] : getenv('SERVER_NAME'));

			// Should be a string and lowered
			$host = (string) strtolower($host);
			// If host is equal the cookie domain or the server name (if config is set), then we assume it is valid
			if ((isset($config['cookie_domain']) && $host === $config['cookie_domain']) || 
				(isset($config['server_name']) && $host === $config['server_name']))
			{
				return $host;
			}
				// Is the host actually a IP? If so, we use the IP... (IPv4)
			if (long2ip(ip2long($host)) === $host)
			{
				return $host;
			}
				// Now return the hostname (this also removes any port definition). The http:// is prepended
				//	yo construct a valid URL, hosts never have a scheme assigned
			$host = @parse_url('http://' . $host);
			$host = (!empty($host['host'])) ? $host['host'] : '';
				// Remove any portions not removed by parse_url (#)
			$host = str_replace('#', '', $host);
				// If, by any means, the host is now empty, we will use a "best approach" way to guess one
			if (empty($host))
			{
				if (!empty($config['server_name']))
				{
					$host = $config['server_name'];
				}
				else if (!empty($config['cookie_domain']))
				{
					$host = (strpos($config['cookie_domain'], '.') === 0) ? 
						substr($config['cookie_domain'], 1) : $config['cookie_domain'];
				}
				else
				{
					// Set to OS hostname or localhost
					$host = (function_exists('php_uname')) ? php_uname('n') : 'localhost';
					}
			}

			// It may be still no valid host, but for sure only a hostname (
            // we may further expand on the cookie domain... if set)
			return $host;
		}
		echo 'Domain name: ' . extract_current_hostname() . '<br />';
		$server_port = (!empty($_SERVER['SERVER_PORT'])) ?
            (int) $_SERVER['SERVER_PORT'] : (int) getenv('SERVER_PORT');
		echo 'Server port: ' . $server_port . '<br />';
		$root_path = phpbb_realpath(dirname(__FILE__) . '/../');
		$script_name = (!empty($_SERVER['PHP_SELF'])) ? $_SERVER['PHP_SELF'] : getenv('PHP_SELF');
		// If we are unable to get the script name we use REQUEST_URI as a failover 
		if (!$script_name)
		{
			$script_name = (!empty($_SERVER['REQUEST_URI'])) ?
                $_SERVER['REQUEST_URI'] : getenv('REQUEST_URI');
			$script_name = (($pos = strpos($script_name, '?')) !== false) ?
                substr($script_name, 0, $pos) : $script_name;
		}
		$root_dirs = explode('/', str_replace('\\', '/', phpbb_realpath($root_path)));
		$script_path = trim(str_replace('\\', '/', dirname($script_name)));
		echo 'Script path: ' . $script_path . '<br /><br />';
		echo 'Server type/version (OS): ' . ((isset($_SERVER['SERVER_SOFTWARE'])) ?
                $_SERVER['SERVER_SOFTWARE'] : '')
               . '<br />';
}
else
{
	function extract_current_hostname()
	{
		global $config, $request;

		// Get hostname
		$host = htmlspecialchars_decode($request->header('Host', $request->server('SERVER_NAME')));

		// Should be a string and lowered
		$host = (string) strtolower($host);

		// If host is equal the cookie domain or the server name (if config is set), then we assume it is valid
		if ((isset($config['cookie_domain']) && $host === $config['cookie_domain']) || (isset($config['server_name']) && $host === $config['server_name']))
		{
			return $host;
		}

		// Is the host actually a IP? If so, we use the IP... (IPv4)
		if (long2ip(ip2long($host)) === $host)
		{
			return $host;
		}

		// Now return the hostname (this also removes any port definition). The http:// is prepended to construct a valid URL, hosts never have a scheme assigned
		$host = @parse_url('http://' . $host);
		$host = (!empty($host['host'])) ? $host['host'] : '';

		// Remove any portions not removed by parse_url (#)
		$host = str_replace('#', '', $host);

		// If, by any means, the host is now empty, we will use a "best approach" way to guess one
		if (empty($host))
		{
			if (!empty($config['server_name']))
			{
				$host = $config['server_name'];
			}
			else if (!empty($config['cookie_domain']))
			{
				$host = (strpos($config['cookie_domain'], '.') === 0) ? substr($config['cookie_domain'], 1) : $config['cookie_domain'];
			}
			else
			{
				// Set to OS hostname or localhost
				$host = (function_exists('php_uname')) ? php_uname('n') : 'localhost';
			}
		}

		// It may be still no valid host, but for sure only a hostname (we may further expand on the cookie domain... if set)
		return $host;
	}
		echo 'Domain name: ' . extract_current_hostname() . '<br />';
		$server_port = $request->server('SERVER_PORT', 0);
		echo 'Server port: ' . $server_port . '<br />';
		// The script path from the webroot to the current directory (for example: /phpBB3/adm/) :
		//	always prefixed with / and ends in /
		$script_path = $symfony_request->getBasePath();

		// The script path from the webroot to the phpBB root (for example: /phpBB3/)
		$script_dirs = explode('/', $script_path);
		array_splice($script_dirs, -sizeof($page_dirs));
		$root_script_path = implode('/', $script_dirs) . (sizeof($root_dirs) ? '/' . implode('/', $root_dirs) : '');

		// We are on the base level (phpBB root == webroot), lets adjust the variables a bit...
		if (!$root_script_path)
		{
			$root_script_path = ($page_dir) ? str_replace($page_dir, '', $script_path) : $script_path;
		}

		$script_path .= (substr($script_path, -1, 1) == '/') ? '' : '/';
		$root_script_path .= (substr($root_script_path, -1, 1) == '/') ? '' : '/';
		echo 'Script path: ' . $script_path . '<br /><br />';
		echo 'Server type/version (OS): ' . ((getenv('SERVER_SOFTWARE')) ?
                getenv('SERVER_SOFTWARE') : '') . '<br />';	
}		
		echo 'GZip compression enabled: ' . ($config['gzip_compress'] ? 'Yes' : 'No') . '<br />';
		echo 'Compression available in PHP: ' . (function_exists('ob_gzhandler') ||
               ini_get('zlib.output_compression') ? 'Yes' : 'No') . '<br />';
		$sql = 'SELECT config_name, config_value FROM ' . CONFIG_TABLE . ' WHERE config_name = "ip_check"';
		$result = $db->sql_query($sql);
		while($row = $db->sql_fetchrow($result))
		{
		$ip_check_value = $row['config_value'];
		}
		switch($ip_check_value)
		{
		 case 0:
			$ip_check_type = 'None';
			break;
		 case 2:
			$ip_check_type = 'A.B';
			break;
		 case 3:
			$ip_check_type = 'A.B.C';
			break;
		 case 4:
			$ip_check_type = 'All';
			break;
		}
		echo 'Session IP validation: ' . $ip_check_type . '<br />';
		$db->sql_freeresult($result);
			echo 'Validate X_FORWARDED_FOR header: ' .
                ($config['forwarded_for_check'] ? 'Yes' : 'No') . '<br />';
			echo 'Check for valid MX record: ' . ($config['email_check_mx'] ? 'Yes' : 'No') . '<br />';
		echo 'Session length: ' . $config['session_length'] . ' secs (' .
            ($config['session_length']/60) . ' mins)<br />';
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
				echo 'Disabled module(s): ' . $row['module_class'] . ': ' . $row['module_basename'] . ': ' . 
				$row['module_langname'] . '<br />';
			}
		}
		$db->sql_freeresult($result);

		echo '[i]Custom profile field load settings[/i]<br />';
		echo 'Display custom profile fields in memberlist: ' . ($config['load_cpf_memberlist'] ? 'Yes' : 'No') .
               '<br />';
		echo 'Display custom profile fields in profile: ' . ($config['load_cpf_viewprofile'] ? 'Yes' : 'No') .
               '<br />';
		echo 'Display custom profile fields in topics: ' . ($config['load_cpf_viewtopic'] ? 'Yes' : 'No') .
               '<br /><br />';
	}
	if($chk_styles == 'Yes')
	{
		echo '<strong>[b]Styles Info[/b]</strong><br />';
		clearstatcache();
		$templatefile = "{$phpbb_root_path}styles/prosilver/template/overall_header.html";
		if (file_exists($templatefile))
		{
			if (is_writable($templatefile)) 
			{
				echo '[c]/styles/prosilver/template/overall_header.html[/c] is writable<br />';
			} 
			else 
			{
				echo '[c]/styles/prosilver/template/overall_header.html[/c] is not writable<br />';
			}
		}
		else
		{
			echo '[c]/styles/prosilver/template/overall_header.html[/c] cannot be found<br />';
		}
		if (file_exists($phpbb_root_path . 'images/spacer.gif'))
		{
			echo '/images/spacer.gif permissions: ' . substr(decoct(fileperms($phpbb_root_path . 
				'images/spacer.gif')), 2) . ' <br />';
		}
		else
		{
			echo '/images/spacer.gif could not be found<br />';
		}
		if (file_exists($phpbb_root_path . 'styles/prosilver/imageset/icon_online.gif'))
		{
			echo '/styles/prosilver/imageset/icon_online.gif permissions: ' . substr(decoct(
				fileperms($phpbb_root_path . 'styles/prosilver/imageset/icon_online.gif')), 2) . ' <br />';
		}
		else
			{
				echo '/styles/prosilver/imageset/icon_online.gif could not be found<br />';
			}
			if (file_exists($phpbb_root_path . 'styles/prosilver/theme/images/icon_faq.gif'))
			{
				echo '/styles/prosilver/theme/images/icon_faq.gif permissions: ' . substr(decoct(
					fileperms($phpbb_root_path . 'styles/prosilver/theme/images/icon_faq.gif')), 2) . ' <br />';
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
		echo '[u]Installed Styles[/u]<br />';

		$_styles = array();

		$sql = 'SELECT style_name, style_active
			FROM ' . STYLES_TABLE . '
			ORDER BY style_name ASC';
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result))
		{
			$_styles[] = $row['style_name'] . (($row['style_active'] == 0) ? ' [i](not active)[/i]' : '');
		}
		echo implode("<br />", $_styles);
		$db->sql_freeresult($result);
		echo '<br /><br />';
	}
	
	if($chk_version == 'Yes')
	{
		echo '<strong>[b]Version Settings[/b]</strong><br />';
		echo 'Board start date: ' . date('d M Y', $config['board_startdate']) . '<br />';
		if(defined('PHPBB_VERSION'))
		{
			echo 'constants.php version: ' . PHPBB_VERSION . '<br />';
		}
		else
		{
			echo 'constants.php version: Not defined (constant not accessible or version &#60; 3.0.3)<br />';
		}
		echo 'Cached version: ' . $config['version'] . '<br />';
		$sql = 'SELECT config_name, config_value FROM ' . CONFIG_TABLE . ' WHERE config_name = "version"
		OR config_name = "version_update_from"';
		$result = $db->sql_query($sql);
		while($row = $db->sql_fetchrow($result))
		{
			echo 'DB ' . $row['config_name'] . ': ' . $row['config_value'] . '<br />';
		}
		$db->sql_freeresult($result);
		echo '<br />';
	}
echo '</div>';
echo '</fieldset>';
echo '<br />';
}
// If the file isn't in the right place ...
else
{
	echo '<strong><p style="color:red">This ' . basename(__FILE__) . '
	    file seems to be in the wrong place. </p></strong>';
	echo '<strong><p>It must go in the root of your board installation.</p></strong>';
}

// Give an option to automatically delete the file
echo '<fieldset><legend><strong>If the checkbox is ticked and you press Delete the ' . basename(__FILE__) . ' 
file will be deleted</strong></legend>';
echo '<form action="' . basename(__FILE__) . '" method="post">';
echo '<label><input type="checkbox" name="chkDelete" value="Yes" checked="checked" required/>
    &nbsp;Delete this file&nbsp;</label>';
echo '<p><button type="submit" class="button red";>Delete</button></p>';
echo '</form>';
echo '</fieldset>';
if($chk_delete == 'Yes')
{
	// Have to give the message before deleting the file because if successful there is no file to return a message
	echo '<p style="color: #FFFFFF; width: 770px; margin-left: 10px; padding-left: 10px;
		background-color: #8B0000">		If no other message shows below this then file is DELETED</p>';
	// We'll try to change file permissions just to make sure they are sufficient, then unlink the file
	chmod(__FILE__, 0777);
	clearstatcache();
	@unlink(__FILE__);  // Eat any errors 
	// Windows IIS servers apparently have a problem with unlinking recently created files.
    // If file still exists give a message
	if (file_exists(__FILE__))
	{
		// Try to change permissions back to a safer 644
		chmod(__FILE__, 0644);
		clearstatcache();
		echo '<p style="color: #FFFFFF; width: 770px; margin-left: 10px; padding-left: 10px; 
		font-size: 1.3em; background-color: #8B0000;">File could not be deleted. You will 
		need to manually delete the file from the server.</p>';
	}
}
else 
{
	echo '<p style="width: 770px; margin-left: 10px; padding-left: 10px; background-color: #98FB98;">File NOT deleted</p>';
}
echo '<br />';
// Create a link to the board index. Really not necessary, but ...
$index_url = $phpbb_root_path . 'index.' . $phpEx;
// Show the link
echo '<a style="margin-left: 700px"; href="' . $index_url . '">Board Index</a>';
echo '</body>';
echo '</html>';