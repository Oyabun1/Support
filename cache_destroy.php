<?php
define('IN_PHPBB', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);
include_once($phpbb_root_path . 'includes/functions_admin.' . $phpEx);

// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup();

// Limit this to founders or admins
if ((int) $user->data['user_type'] !== USER_FOUNDER || !$auth->acl_get('a_'))
{
	trigger_error('You don\'t have permission to clear the cache. You need to be logged in as a founder or admin.');
}

// Clear PHP file status cache
clearstatcache();

// Lets do some cache purging
$cache->purge();
$cache->destroy('sql', STYLES_TABLE);
$cache->destroy('sql', STYLES_THEME_TABLE);
$cache->destroy('sql', STYLES_IMAGESET_DATA_TABLE);

// Now to clear cached permissions
$cache->destroy('_acl_options');
$auth->acl_clear_prefetch();
$cache->destroy('_role_cache');
cache_moderators();

// Add a log entry 
add_log('admin', 'LOG_PURGE_CACHE');

trigger_error('Mmmm.... cached purged.');