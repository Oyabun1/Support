<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="utf-8">
<title>phpBB 3.0.x Avatar Checking Tool</title>
<meta http-equiv="Content-Type" content="text/html;" />
<style type="text/css">

	body {
		font-family: Verdana, Helvetica, Arial, sans-serif;
		font-size: .95em;
		margin-left: 1em;
		background-color: #ECF3F7;
	 }
	input[type="checkbox"] {
		margin-left: 10px;
		vertical-align:middle;
		cursor:pointer;
	 }
	input[type="submit"]{
		margin-left: 100px;
		cursor: pointer;
	}

</style>
</head>
<body>
<h2>phpBB 3.0.x Avatar Checking Tool</h2>
<?php if(isset($_POST['submit'])) echo '<!--'; ?> 
<form method="post" action="<?php $_SERVER["PHP_SELF"]; ?>">
	User name to check:
	<input type="text" name="username" />
	<br />~or~
	<br />User id to check:
	<input type="text" name="user_id" size="5" />
	<input type="hidden" name="act" value="submit" /><br /><br />
	<label style="cursor:pointer" title="Check files" >Include File Check<input type="checkbox" name="chkFiles" value="Yes"/>
	</label><br /><br />
	<input type="submit" name="submit" value="Check" />
</form>
<?php if(isset($_POST['submit'])) echo '-->'; ?>

<?php
define('IN_PHPBB', true);
$phpbb_root_path = ((isset($phpbb_root_path)) ? $phpbb_root_path : './');
$phpEx = substr(strrchr(__FILE__, '.'), 1);
if (file_exists($phpbb_root_path . 'common.' . $phpEx))
{
	include($phpbb_root_path . 'common.' . $phpEx);
	require($phpbb_root_path . '/includes/functions_display.' . $phpEx);
	include_once($phpbb_root_path . '/includes/functions_user.' . $phpEx);

	// Start session management
	$user->session_begin();
	$auth->acl($user->data);
	$user->setup('posting');

	$submit = (isset($_POST['submit'])) ? true : false;

	$user_id = request_var('user_id',0);
	$username = request_var('username','');
	$chk_files = (request_var('chkFiles', ''));

	if ($submit)
	{		
		if ($chk_files == 'Yes')
		{
			echo '<strong>File Check</strong><br />';
			echo 'Check first 5 characters of PHP files (should be: ' . htmlspecialchars('<?php') . ')<br />';
			/**
			* Check first line of PHP files to see if it is only "<?php"
			* (≈285 PHP files in installed 3.0.12)
			* Just doing a BOM check wouldn't find blank lines, spaces, code mistakenly added at start of file, ...
			* Only check the start of the file - that is the most common problem and checking the end is too hard
			* Based on some code from php.net
			*/
			// This iteration method may not always be available, so first check if class exists
			$time_start = microtime(true); 
			if (class_exists('RecursiveDirectoryIterator'))
			{
				$check_extensions = array('php');
				$compare = htmlspecialchars('<?php');
				$file = null;
				$root = dirname(__FILE__);
				 
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
									echo str_replace($root, '', $file) . ' first 5 characters: <span style="color:#CC0000; font-weight:800;">' . $fchk . '</span> <span style="color:#FF9900;">(Possible error)</span><br />';
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
			// If we can't easily iterate through all files, we'll try with glob, and check 4 layers
			{
				echo 'First 5 characters of PHP files (should be ' . htmlspecialchars('<?php') . ') of:<br />';
				echo '(Only checked first 4 directory layers)<br />';
				// Check if the functions used is available
				
				$compare = htmlspecialchars('<?php');
			
				foreach(glob($phpbb_root_path . '{*.php,*/*.php,*/*/*.php,*/*/*/*.php}', GLOB_BRACE) as $filetochk)
				{
					$fchk = htmlspecialchars(file_get_contents($filetochk, NULL, NULL, 0, 5));
				
					if (strncasecmp($fchk, $compare, 5) !== 0)
					{
						 echo $filetochk . ' are: ' . $fchk . ' <span style="color:#CC0000; font-weight:800;">' . $fchk . '</span> <span style="color:#FF9900;">(Possible error)</span><br />';
					}
				}
			}
			else
			{
				echo 'Tried methods unsupported by server<br />';
			}
			unset($fchk);
			$time_end = microtime(true);
			$totaltime = round($time_end - $time_start, 2);
			// Usually completes in < 10 secs. A check on a board with 100+ MODs and low resources took 124 secs
			echo 'File check finished in: ' . $totaltime . ' seconds (wall-clock time)<br />';
		}
		// Use phpBB function to check if the username is valid and exists
		if (validate_username($username))
		{
			// The main game
			$sql = 'SELECT user_id, username, user_avatar, user_avatar_type, user_avatar_width, user_avatar_height FROM ' . USERS_TABLE;

			if (!empty($_POST['username']))
			{
				$sql .= " WHERE username_clean = '" . $db->sql_escape(utf8_clean_string($username)) . "'";
			}
			if (!empty($_POST['user_id']))
			{
				$sql .= ' WHERE user_id = ' . (int) $user_id;
			}

			$result = $db->sql_query($sql);
			$row = $db->sql_fetchrow($result);

			$user_check = $row['username'];
			$filename = $row['user_avatar'];
			$avatar_type = $row['user_avatar_type'];
			$db->sql_freeresult($result);

			$user_id = $row['user_id'];

				echo '<br />The user checked is: ' . $user_check . ', user_id is: ' . $user_id . '<br />
				The user_avatar is: ' . $row['user_avatar'] . '<br />';

			if (isset($filename[0]) && $filename[0] === 'g')
			{
				$avatar_group = true;
				$filename = substr($filename, 1);
			}

			switch ($avatar_type)
			{
				case AVATAR_UPLOAD:
					echo 'Avatar type = Upload<br />';
					echo 'row avatar width = ' . $row['user_avatar_width'] . '<br />';
					echo 'row avatar height = ' . $row['user_avatar_height'] . '<br />';
					$ext		= substr(strrchr($filename, '.'), 1);
					$stamp		= (int) substr(stristr($filename, '_'), 1);
					$filename	= (int) $filename;
					$prefix		= $config['avatar_salt'] . '_';
					$full_path	= $config['avatar_path'] . '/' . $prefix . $filename . '.' . $ext;
					$exists = file_exists($full_path);
					echo $full_path . (($exists) ? ' <span style="color:#33CC00"><strong>Exists</strong></span>' : ' <span style="color:#ff0000"><strong>Does not exist</strong></span>') . '<br />';
					if ($config['avatar_path'] != '')
					{
						echo 'Avatar storage folder permissions: ' . substr(decoct(fileperms($phpbb_root_path . 
						($config['avatar_path']))), 2) . ' <br /><br />';
					}
					if (!$exists)
					{
						echo 'Avatar Salt is: ' . $config['avatar_salt'] . '<br />';
						echo 'user_avatar is: ' . $row['user_avatar'] . '<br />';
					}
				break;

				case AVATAR_REMOTE:
					echo 'Avatar type = Remote<br />';
					echo 'Remote avatar full path = ' . $row['user_avatar'] . '<br />';
					echo '<img src=" . $full_path . " title=" . $full_path . " alt = " . $full_path . ">';
				break;

				case AVATAR_GALLERY:
					echo 'Avatar type = Gallery<br />';
					$full_path	= $config['avatar_gallery_path'] . '/' . $filename;
					$exists = file_exists($full_path);
					echo $full_path . (($exists) ? ' <span style="color:#33CC00"><strong>Exists</strong></span><br />' :
						' <span style="color:#ff0000"><strong>Does not exist</strong></span><br />');
					if ($config['avatar_gallery_path'] != '')
					{
						echo 'Avatar gallery folder permissions: ' . substr(decoct(fileperms($phpbb_root_path . 
						($config['avatar_gallery_path']))), 2) . ' <br />';
					}
				break;
			}

			$allow_avatar = (empty($config['allow_avatar'])) ? 'Avatars are NOT allowed' : 'Avatars ARE allowed';
			$allow_avatar_upload = (empty($config['allow_avatar_upload'])) ? 'Uploaded avatars are NOT allowed' : 'Uploaded avatars ARE allowed';
			$allow_avatar_remote = (empty($config['allow_avatar_remote'])) ? 'Remote avatars are NOT allowed' : 'Remote avatars ARE allowed';
			$allow_avatar_local = (empty($config['allow_avatar_local'])) ? 'Gallery avatars are NOT allowed' : 'Gallery avatars ARE allowed';
			$allow_avatar_remote_upload = (empty($config['allow_avatar_remote_upload'])) ? 'Remote uploaded avatars are NOT allowed' : 'Remote uploaded avatars ARE allowed';
				echo $allow_avatar . '<br />';
			echo $allow_avatar_upload . '<br />';
			echo $allow_avatar_remote . '<br />';
			echo $allow_avatar_local . '<br />';
			echo $allow_avatar_remote_upload . '<br />';
			echo 'Image below produced by file.php<br /><img src="http://' . $config['server_name'] . $config['script_path'] . '/download/file.php?avatar=' . $row['user_avatar'] . '"><br />';
			echo 'Image below produced by get_user_avatar()<br />';
			$view_avatar = ($user->optionget('viewavatars')) ? get_user_avatar($row['user_avatar'], $row['user_avatar_type'], $row['user_avatar_width'], $row['user_avatar_height']) : 'Member has set profile to disable viewing of avatars';
			echo $view_avatar . '<br />';
		}
		else 
		{
		 echo 'Username NOT valid<br />';
		}
	}
}

else
{
	echo '<strong><p style="color:red">This ' . basename(__FILE__) . '
	    file seems to be in the wrong place. </p></strong>';
	echo '<strong><p>It must go in the root of your board installation.</p></strong>';
}

?>

<!-- copyright
<div style="text-align:center; font-size:small;">&copy; <a href="http://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=163542">Dicky</a> 2010 and <a href="https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=987265">Oyabun1</a> 2014</div>
-->
</body>
</html>