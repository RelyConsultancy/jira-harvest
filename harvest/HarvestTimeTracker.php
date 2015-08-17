<?php
/**
 * This file is part of the harvest package.
 *
 * (c) Freshbyte Inc <http://freshbyteinc.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace harvest;

use logger\Logger;

class HarvestTimeTracker extends HarvestAbstract
{
  /**
   * @var string
   */
  protected $requestData;

  /**
   * Constructor.
   *
   * @param array $data
   */
  public function __construct($data = array())
  {
    Logger::log('test', 'test', $data);
    parent::__construct();

    if ($data)
    {
      $this->requestData = $this->prepareRequestData($data);
    }

  }

  /**
   * Prepare the request data for adding a new time tracking entry.
   *
   * @param array $data
   *
   * @return string
   */
  protected function prepareRequestData($data)
  {
    $requestData = array(
      'notes' => $data['issueKey'] . ': ' . $data['issueTitle'] . "\n" . $data['comment'],
      'hours' => $data['timeSpentSeconds'] / 3600,
      'project_id' => $data['harvestProjectId'],
      'task_id' => HARVEST_TASK_ID,
      'spent_at' => date("Y-m-d"),
      'external_namespace' => JIRA_BASE_URL . 'browse/' . $data['issueKey'],
      'permalink' => JIRA_BASE_URL . 'browse/' . $data['issueKey'],
      'external_group_name' => $data['projectName'],
      'external_id' => $data['issueId'],
      'external_service' => 'JIRA',
    );

    return json_encode($requestData);
  }

  /**
   * Add time to Harvest.
   *
   * @param string $userId
   *   The Harvest user ID for which we add the time.
   *
   * @return mixed
   *   The response array or FALSE.
   */
  public function addTime($userId = NULL)
  {
    $url = HARVEST_BASE_URL . HARVEST_ADD_TIME_PATH;
    // @todo move this to POST body.
    if ($userId)
    {
      $url .= '?of_user=' . $userId;
    }

    $this->request->setUrl($url);
    $this->request->setRequestData($this->requestData);

    // Logger::log('HarvestRequest::addTime', 'Saving new time (' . $url . ')', $this->requestData);

    return $this->request->sendRequest();
  }
}
