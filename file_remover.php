<?php
// Copyright © Oyabun1 2013
// version 1.0.5 (3.1.0-RC4)
// license http://opensource.org/licenses/GPL-2.0 GNU General Public License v2

define('IN_PHPBB', true);
define('IN_INSTALL',false);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);

// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup();

// Check if user running file is a founder
if ($user->data['user_type'] != USER_FOUNDER)
{
	trigger_error('You need to be logged in as a founder');
}

// Add a description and button
echo '<form action="' . basename(__FILE__) . '" method="post">';
echo '<p><strong>Make sure you have backed up your files!</strong><br />
There is no restore function with this file.<br />
If you are sure you want to continue click the <em>Delete files</em> button.</p>';
echo '<p style="margin-left: 9em;"><button type="submit" name="chkDelete" value="Yes";>Delete files</button></p>';
echo '</form>';

$chk_delete = (request_var('chkDelete', ''));

// Delete whichever of the listed files are present
if($chk_delete == 'Yes')
{
	$file_to_kill = array(
	"adm/images/bg_tabs1.gif",
	"adm/images/bg_tabs2.gif",
	"adm/images/corners_left.gif",
	"adm/images/corners_left2.gif",
	"adm/images/corners_right.gif",
	"adm/images/corners_right2.gif",
	"adm/images/toggle.gif",
	"adm/style/colour_swatch.html",
	"adm/style/custom_profile_fields.html",
	"adm/style/editor.js",
	"adm/style/viewsource.html",
	"adm/swatch.php",
	"assets/plupload/img/done.gif",
	"assets/plupload/img/throbber.gif",
	"assets/plupload/img/error.gif",
	"includes/acm/acm_file.php",
	"includes/acm/acm_apc.php",
	"includes/acm/acm_wincache.php",
	"includes/acm/acm_memory.php",
	"includes/acm/acm_redis.php",
	"includes/acm/acm_xcache.php",
	"includes/acm/acm_null.php",
	"includes/acm/acm_memcache.php",
	"includes/acm/acm_eaccelerator.php",
	"includes/auth/auth_apache.php",
	"includes/auth/auth_db.php",
	"includes/auth/auth_ldap.php",
	"includes/auth/index.htm",
	"includes/auth.php",
	"includes/cache.php",
	"includes/captcha/captcha_gd_wave.php",
	"includes/captcha/captcha_non_gd.php",
	"includes/captcha/plugins/phpbb_recaptcha_plugin.php",
	"includes/captcha/plugins/phpbb_captcha_nogd_plugin.php",
	"includes/captcha/plugins/phpbb_captcha_qa_plugin.php",
	"includes/captcha/plugins/captcha_abstract.php",
	"includes/captcha/plugins/phpbb_captcha_gd_plugin.php",
	"includes/captcha/plugins/phpbb_captcha_gd_wave_plugin.php",
	"includes/captcha/captcha_factory.php",
	"includes/captcha/captcha_gd.php",
	"includes/db/db_tools.php",
	"includes/db/mssql_odbc.php",
	"includes/db/postgres.php",
	"includes/db/oracle.php",
	"includes/db/dbal.php",
	"includes/db/mssqlnative.php",
	"includes/db/mysqli.php",
	"includes/db/index.htm",
	"includes/db/mssql.php",
	"includes/db/mysql.php",
	"includes/db/firebird.php",
	"includes/db/sqlite.php",
	"includes/error_collector.php",
	"includes/functions_profile_fields.php",
	"includes/functions_template.php",
	"includes/search/fulltext_mysql.php",
	"includes/search/search.php",
	"includes/search/index.htm",
	"includes/search/fulltext_native.php",
	"includes/session.php",
	"includes/template.php",
	"language/en/email/group_approved.txt",
	"language/en/mods/index.htm",
	"phpbb/event/extension_subscriber_loader.php",
	"style.php",
	"styles/prosilver/imageset/topic_unread_locked_mine.gif",
	"styles/prosilver/imageset/icon_contact_www.gif",
	"styles/prosilver/imageset/topic_read.gif",
	"styles/prosilver/imageset/topic_unread.gif",
	"styles/prosilver/imageset/icon_online.gif",
	"styles/prosilver/imageset/site_logo.gif",
	"styles/prosilver/imageset/sticky_read_mine.gif",
	"styles/prosilver/imageset/topic_unread_locked.gif",
	"styles/prosilver/imageset/icon_contact_msnm.gif",
	"styles/prosilver/imageset/forum_unread.gif",
	"styles/prosilver/imageset/subforum_read.gif",
	"styles/prosilver/imageset/sticky_unread_locked.gif",
	"styles/prosilver/imageset/icon_rate_good.gif",
	"styles/prosilver/imageset/topic_read_hot_mine.gif",
	"styles/prosilver/imageset/icon_post_delete.gif",
	"styles/prosilver/imageset/forum_read.gif",
	"styles/prosilver/imageset/topic_moved.gif",
	"styles/prosilver/imageset/icon_contact_aim.gif",
	"styles/prosilver/imageset/icon_topic_attach.gif",
	"styles/prosilver/imageset/forum_unread_locked.gif",
	"styles/prosilver/imageset/sticky_read_locked_mine.gif",
	"styles/prosilver/imageset/sticky_unread_locked_mine.gif",
	"styles/prosilver/imageset/sticky_unread.gif",
	"styles/prosilver/imageset/announce_read.gif",
	"styles/prosilver/imageset/sticky_read.gif",
	"styles/prosilver/imageset/icon_back_top.gif",
	"styles/prosilver/imageset/icon_post_info.gif",
	"styles/prosilver/imageset/announce_unread_locked.gif",
	"styles/prosilver/imageset/announce_read_locked.gif",
	"styles/prosilver/imageset/forum_read_locked.gif",
	"styles/prosilver/imageset/announce_read_locked_mine.gif",
	"styles/prosilver/imageset/announce_read_mine.gif",
	"styles/prosilver/imageset/topic_read_locked.gif",
	"styles/prosilver/imageset/icon_contact_yahoo.gif",
	"styles/prosilver/imageset/icon_post_target_unread.gif",
	"styles/prosilver/imageset/topic_unread_hot.gif",
	"styles/prosilver/imageset/icon_contact_email.gif",
	"styles/prosilver/imageset/icon_post_report.gif",
	"styles/prosilver/imageset/icon_topic_newest.gif",
	"styles/prosilver/imageset/topic_unread_hot_mine.gif",
	"styles/prosilver/imageset/forum_link.gif",
	"styles/prosilver/imageset/announce_unread_mine.gif",
	"styles/prosilver/imageset/sticky_unread_mine.gif",
	"styles/prosilver/imageset/icon_rate_bad.gif",
	"styles/prosilver/imageset/icon_topic_latest.gif",
	"styles/prosilver/imageset/sticky_read_locked.gif",
	"styles/prosilver/imageset/icon_offline.gif",
	"styles/prosilver/imageset/announce_unread_locked_mine.gif",
	"styles/prosilver/imageset/forum_unread_subforum.gif",
	"styles/prosilver/imageset/icon_contact_icq.gif",
	"styles/prosilver/imageset/icon_topic_unapproved.gif",
	"styles/prosilver/imageset/imageset.cfg",
	"styles/prosilver/imageset/topic_read_locked_mine.gif",
	"styles/prosilver/imageset/icon_contact_jabber.gif",
	"styles/prosilver/imageset/topic_read_hot.gif",
	"styles/prosilver/imageset/icon_topic_reported.gif",
	"styles/prosilver/imageset/index.htm",
	"styles/prosilver/imageset/topic_unread_mine.gif",
	"styles/prosilver/imageset/icon_user_warn.gif",
	"styles/prosilver/imageset/topic_read_mine.gif",
	"styles/prosilver/imageset/forum_read_subforum.gif",
	"styles/prosilver/imageset/subforum_unread.gif",
	"styles/prosilver/imageset/announce_unread.gif",
	"styles/prosilver/imageset/icon_post_target.gif",
	"styles/prosilver/imageset/en/icon_contact_pm.gif",
	"styles/prosilver/imageset/en/button_topic_new.gif",
	"styles/prosilver/imageset/en/button_pm_reply.gif",
	"styles/prosilver/imageset/en/button_topic_locked.gif",
	"styles/prosilver/imageset/en/icon_post_quote.gif",
	"styles/prosilver/imageset/en/icon_post_edit.gif",
	"styles/prosilver/imageset/en/button_pm_new.gif",
	"styles/prosilver/imageset/en/icon_user_online.gif",
	"styles/prosilver/imageset/en/button_pm_forward.gif",
	"styles/prosilver/imageset/en/imageset.cfg",
	"styles/prosilver/imageset/en/index.htm",
	"styles/prosilver/imageset/en/button_topic_reply.gif",
	"styles/prosilver/template/custom_profile_fields.html",
	"styles/prosilver/template/editor.js",
	"styles/prosilver/template/mcp_viewlogs.html",
	"styles/prosilver/template/memberlist_leaders.html",
	"styles/prosilver/template/styleswitcher.js",
	"styles/prosilver/template/template.cfg",
	"styles/prosilver/template/ucp_pm_popup.html",
	"styles/prosilver/theme/images/bg_menu.gif",
	"styles/prosilver/theme/images/bg_menu_rtl.gif",
	"styles/prosilver/theme/images/bg_tabs1.gif",
	"styles/prosilver/theme/images/bg_tabs2.gif",
	"styles/prosilver/theme/images/corners_left.gif",
	"styles/prosilver/theme/images/corners_left.png",
	"styles/prosilver/theme/images/corners_left2.gif",
	"styles/prosilver/theme/images/corners_right.gif",
	"styles/prosilver/theme/images/corners_right.png",
	"styles/prosilver/theme/images/corners_right2.gif",
	"styles/prosilver/theme/images/created_by.jpg",
	"styles/prosilver/theme/images/icon_fontsize.gif",
	"styles/prosilver/theme/large.css",
	"styles/prosilver/theme/medium.css",
	"styles/prosilver/theme/normal.css",
	"styles/prosilver/theme/theme.cfg",
	"styles/subsilver2/imageset/topic_unread_locked_mine.gif",
	"styles/subsilver2/imageset/topic_read.gif",
	"styles/subsilver2/imageset/topic_unread.gif",
	"styles/subsilver2/imageset/site_logo.gif",
	"styles/subsilver2/imageset/sticky_read_mine.gif",
	"styles/subsilver2/imageset/poll_left.gif",
	"styles/subsilver2/imageset/topic_unread_locked.gif",
	"styles/subsilver2/imageset/forum_unread.gif",
	"styles/subsilver2/imageset/sticky_unread_locked.gif",
	"styles/subsilver2/imageset/topic_read_hot_mine.gif",
	"styles/subsilver2/imageset/poll_right.gif",
	"styles/subsilver2/imageset/forum_read.gif",
	"styles/subsilver2/imageset/topic_moved.gif",
	"styles/subsilver2/imageset/icon_topic_attach.gif",
	"styles/subsilver2/imageset/forum_unread_locked.gif",
	"styles/subsilver2/imageset/sticky_read_locked_mine.gif",
	"styles/subsilver2/imageset/sticky_unread_locked_mine.gif",
	"styles/subsilver2/imageset/sticky_unread.gif",
	"styles/subsilver2/imageset/announce_read.gif",
	"styles/subsilver2/imageset/sticky_read.gif",
	"styles/subsilver2/imageset/announce_unread_locked.gif",
	"styles/subsilver2/imageset/announce_read_locked.gif",
	"styles/subsilver2/imageset/forum_read_locked.gif",
	"styles/subsilver2/imageset/announce_read_locked_mine.gif",
	"styles/subsilver2/imageset/announce_read_mine.gif",
	"styles/subsilver2/imageset/topic_read_locked.gif",
	"styles/subsilver2/imageset/icon_post_target_unread.gif",
	"styles/subsilver2/imageset/topic_unread_hot.gif",
	"styles/subsilver2/imageset/icon_topic_newest.gif",
	"styles/subsilver2/imageset/topic_unread_hot_mine.gif",
	"styles/subsilver2/imageset/forum_link.gif",
	"styles/subsilver2/imageset/announce_unread_mine.gif",
	"styles/subsilver2/imageset/sticky_unread_mine.gif",
	"styles/subsilver2/imageset/poll_center.gif",
	"styles/subsilver2/imageset/icon_topic_latest.gif",
	"styles/subsilver2/imageset/sticky_read_locked.gif",
	"styles/subsilver2/imageset/announce_unread_locked_mine.gif",
	"styles/subsilver2/imageset/forum_unread_subforum.gif",
	"styles/subsilver2/imageset/icon_topic_unapproved.gif",
	"styles/subsilver2/imageset/imageset.cfg",
	"styles/subsilver2/imageset/topic_read_locked_mine.gif",
	"styles/subsilver2/imageset/topic_read_hot.gif",
	"styles/subsilver2/imageset/icon_topic_reported.gif",
	"styles/subsilver2/imageset/topic_unread_mine.gif",
	"styles/subsilver2/imageset/upload_bar.gif",
	"styles/subsilver2/imageset/topic_read_mine.gif",
	"styles/subsilver2/imageset/forum_read_subforum.gif",
	"styles/subsilver2/imageset/announce_unread.gif",
	"styles/subsilver2/imageset/icon_post_target.gif",
	"styles/subsilver2/imageset/en/icon_contact_pm.gif",
	"styles/subsilver2/imageset/en/icon_contact_www.gif",
	"styles/subsilver2/imageset/en/button_topic_new.gif",
	"styles/subsilver2/imageset/en/button_pm_reply.gif",
	"styles/subsilver2/imageset/en/icon_contact_msnm.gif",
	"styles/subsilver2/imageset/en/icon_post_delete.gif",
	"styles/subsilver2/imageset/en/icon_contact_aim.gif",
	"styles/subsilver2/imageset/en/icon_post_info.gif",
	"styles/subsilver2/imageset/en/button_topic_locked.gif",
	"styles/subsilver2/imageset/en/icon_post_quote.gif",
	"styles/subsilver2/imageset/en/icon_contact_yahoo.gif",
	"styles/subsilver2/imageset/en/icon_user_search.gif",
	"styles/subsilver2/imageset/en/icon_contact_email.gif",
	"styles/subsilver2/imageset/en/icon_post_edit.gif",
	"styles/subsilver2/imageset/en/icon_post_report.gif",
	"styles/subsilver2/imageset/en/button_pm_new.gif",
	"styles/subsilver2/imageset/en/icon_user_online.gif",
	"styles/subsilver2/imageset/en/icon_user_offline.gif",
	"styles/subsilver2/imageset/en/icon_user_profile.gif",
	"styles/subsilver2/imageset/en/icon_contact_icq.gif",
	"styles/subsilver2/imageset/en/imageset.cfg",
	"styles/subsilver2/imageset/en/icon_contact_jabber.gif",
	"styles/subsilver2/imageset/en/button_topic_reply.gif",
	"styles/subsilver2/imageset/en/icon_user_warn.gif",
	"styles/subsilver2/template/custom_profile_fields.html",
	"styles/subsilver2/template/editor.js",
	"styles/subsilver2/template/mcp_jumpbox.html",
	"styles/subsilver2/template/mcp_viewlogs.html",
	"styles/subsilver2/template/memberlist_leaders.html",
	"styles/subsilver2/template/template.cfg",
	"styles/subsilver2/template/ucp_pm_popup.html",
	"styles/subsilver2/theme/theme.cfg");

	$file_count = 0;
	foreach ($file_to_kill as $dead)
	{
		
		if (file_exists($dead))
		{
			$file_count++;
			unlink($dead);
		}
	}
	unset($dead);
	// Show the count of deleted files
	echo '<p>Total files deleted: ' . $file_count . '</p>
		<p>You should now remove the <code>' . basename(__FILE__) . '</code> file from the server.</p>';
}
