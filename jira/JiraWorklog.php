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
 * Class JiraWorklog
 * @package jira
 */
class JiraWorklog {

  /**
   * @var \stdClass
   */
  protected $worklogData;

  /**
   * @var array
   */
  protected $worklogs;

  /**
   * Constructor.
   *
   * @param \stdClass $worklogData
   */
  public function __construct($worklogData)
  {
    $this->worklogData = $worklogData;
    $this->parseWorklogsData($this->worklogData->worklogs);
  }

  /**
   * Process the existing worklogs.
   *
   * @param array $worklogsData
   *   The worklogs data.
   */
  protected function parseWorklogsData($worklogsData)
  {
    foreach ($worklogsData as $worklogData)
    {
      $this->worklogs[$worklogData->id] = array(
        'timeSpentSeconds' => $worklogData->timeSpentSeconds,
        'comment' => $worklogData->comment,
        'authorEmail' => $worklogData->updateAuthor->emailAddress,
        'authorName' => $worklogData->updateAuthor->displayName,
      );
    }
  }

  /**
   * Return worklog data for received worklog ID if exists.
   *
   * @param string $worklogID
   *   The worklog ID.
   *
   * @return bool|array
   */
  public function getWorklogDataByID($worklogID)
  {
    if (!empty($this->worklogs[$worklogID]))
    {
      return $this->worklogs[$worklogID];
    }

    return array();
  }
}
