# jira-harvest

This tool integrates Jira and Harvest time-tracking under one user action

## Install

* Under the **config** folder you need to create a new file named **config.php**
 For your convenience, we've created a sample file in this folder ( **sample.config.php** ).
 This file contains all the settings needed, so you can copy this file and edit it.
 Bellow you will have a sample config if you want to add it manually.

* Optional, in the root folder you can create a folder named **logs**. The user 
 under which the server runs needs to have write access in this folder. This is
 optional, if the folder is not created, the script will try to create it. 

### Sample config

```php
/**
 * The harvest url. Add the trailing slash (/).
 */
define('HARVEST_BASE_URL', 'https://example.harvestapp.com/');
/**
 * Basic authentication hash: base64 from string "email:password". The user
 * needs to have admin access.
 */
define('HARVEST_AUTH', 'Base64HashString');
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
```
