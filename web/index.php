<?php

/**
 * This file is part of the index.php package.
 *
 * (c) Freshbyte Inc <http://freshbyteinc.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once '../jira/JiraWebhookMapper.php';
require_once '../jira/JiraChangelog.php';
require_once '../jira/JiraWorklog.php';
require_once '../harvest/HarvestAbstract.php';
require_once '../harvest/HarvestProjects.php';
require_once '../harvest/HarvestTimeTracker.php';
require_once '../harvest/HarvestUsers.php';
require_once '../harvest/HarvestRequest.php';
require_once '../logger/Logger.php';
require_once '../config/config.php';

$jiraWebhookBody = file_get_contents('php://input');

// If we have input (POST request body).
if ($jiraWebhookBody)
{
  $jiraMapper = new \jira\JiraWebhookMapper($jiraWebhookBody);
}

if (!empty($jiraMapper) && $jiraMapper->getWebhookEvent() == 'jira:worklog_updated')
{
  $changelog = $jiraMapper->getChangelog();
  $workLogID = $changelog->getWorklogId();

  $worklog = $jiraMapper->getWorklog();
  $worklogData = $worklog->getWorklogDataByID($workLogID);

  $issueData = array(
    'issueKey' => $jiraMapper->getIssueKey(),
    'issueId' => $jiraMapper->getIssueID(),
    'projectCode' => $jiraMapper->getIssueProjectKey(),
    'projectName' => $jiraMapper->getIssueProjectName(),
    'issueTitle' => $jiraMapper->getIssueTitle(),
    'issueType' => $jiraMapper->getIssueType(),
  );

  $requestData = array_merge($worklogData, $issueData);

  $harvestProjects = new \harvest\HarvestProjects();
  $requestData['harvestProjectId'] = $harvestProjects->getHarvestProjectIdByCode($requestData['projectCode']);

  $harvestUsers = new \harvest\HarvestUsers();
  $harvestUserId = $harvestUsers->getUserIdByEmail($requestData['authorEmail']);

  $harvestTimeTracker = new \harvest\HarvestTimeTracker($requestData);
  $response = $harvestTimeTracker->addTime($harvestUserId);
}
