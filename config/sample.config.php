<?php

/**
 * This file is part of the config package.
 *
 * (c) Freshbyte Inc <http://freshbyteinc.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * The harvest url. Add the trailing slash (/).
 */
define('HARVEST_BASE_URL', 'https://example.harvestapp.com/');
/**
 * Basic authentication hash: base64 from string "email:password". The user
 * needs to have admin access.
 */
define('HARVEST_AUTH', 'c29yaW4uZXVnZW5AaG90bWFpbC5jb206cGFzczRoYXJ2ZXN0');
/**
 * The Harvest task ID under which all time will be tracked
 * eg: Development (id: 1234567)
 */
define('HARVEST_TASK_ID', 1234567);
/**
 * The jira url. Add the trailing slash (/).
 */
define('JIRA_BASE_URL', 'https://example.atlassian.net/');

/**
 * DO NOT EDIT THESE SETTINGS.
 */
define('HARVEST_ADD_TIME_PATH', 'daily/add');
define('HARVEST_GET_USERS_PATH', 'people');
define('HARVEST_GET_PROJECTS_PATH', 'projects');
