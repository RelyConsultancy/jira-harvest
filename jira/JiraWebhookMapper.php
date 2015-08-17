<?php

/**
 * This file is part of the jira package.
 *
 * (c) Freshbyte Inc <http://freshbyteinc.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace jira;

/**
 * Class JiraWebhookMapper
 * @package jira
 */
class JiraWebhookMapper {

  /**
   * @var object
   */
  protected $data;

  /**
   * Constructor.
   *
   * @param string $data
   *   JSON representation of the received data.
   */
  public function __construct($data)
  {
    $decodedData = json_decode($data);

    if ($decodedData) {
      $this->data = $decodedData;

      return $this;
    }

    return FALSE;
  }

  /**
   * Get the request webhook event type.
   *
   * @return mixed
   */
  public function getWebhookEvent()
  {
    return $this->data->webhookEvent;
  }

  /**
   * Get the Issue from the request.
   */
  function getIssueObj()
  {
    return $this->data->issue;
  }

  /**
   * Get the Issue Key.
   *
   * @return string
   *   The Issue key (eg: ABC-1).
   */
  function getIssueKey()
  {
    return $this->data->issue->key;
  }

  /**
   * Get the Issue ID.
   *
   * @return string
   *   The Issue ID (eg: 10000).
   */
  function getIssueID()
  {
    return $this->data->issue->id;
  }

  /**
   * Get the Project the issue is associated with.
   *
   * @return string
   *   The Project key (eg: ABC).
   */
  function getIssueProjectKey()
  {
    return $this->data->issue->fields->project->key;
  }

  /**
   * Get the name of the Project the issue is associated with.
   *
   * @return string
   *   The Project key (eg: ABC Project).
   */
  function getIssueProjectName()
  {
    return $this->data->issue->fields->project->name;
  }

  /**
   * Get the Issue Summary (title).
   *
   * @return string
   *   The issue title.
   */
  function getIssueTitle()
  {
    return $this->data->issue->fields->summary;
  }

  /**
   * Get the Issue Type.
   *
   * @return string
   *   The issue type.
   */
  function getIssueType()
  {
    $type = $this->data->issue->fields->issuetype->name;

    if ($this->data->issue->fields->issuetype->subtask) {
      $type .= ' Subtask';
    }

    return $type;
  }

  /**
   * Get the Issue Description.
   *
   * @return string
   *   The issue description.
   */
  function getIssueDescription()
  {
    return $this->data->issue->fields->description;
  }

  /**
   * Get the User email.
   *
   * @return string
   *   The email of the user who triggered the webhook.
   */
  function getUserEmail()
  {
    return $this->data->user->emailAddress;
  }

  /**
   * Get the worklog object.
   *
   * @return bool|\jira\JiraWorklog
   *   A JiraWorklog object if the request data contains a worklog attribute,
   *   FALSE otherwise.
   */
  function getWorklog()
  {
    if (!empty($this->data->issue->fields->worklog))
    {
      return new JiraWorklog($this->data->issue->fields->worklog);
    }

    return FALSE;
  }

  /**
   * Get the changelog object.
   *
   * @return bool|\jira\JiraChangelog
   *   A JiraChangelog object if the request data contains a changelog attribute,
   *   FALSE otherwise.
   */
  function getChangelog()
  {
    if (!empty($this->data->changelog))
    {
      return new JiraChangelog($this->data->changelog);
    }

    return FALSE;
  }
}
