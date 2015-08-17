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

/**
 * Class HarvestProjects
 * @package harvest
 */
class HarvestProjects extends HarvestAbstract
{
  /**
   * Get all Harvest projects.
   *
   * @return array
   *   The users array if request was successful, emty array otherwise/
   */
  protected function getProjects()
  {
    $this->request->setUrl(HARVEST_BASE_URL . HARVEST_GET_PROJECTS_PATH);
    $response = $this->request->sendRequest('GET');

    if ($response)
    {
      return $response;
    }

    return array();
  }

  /**
   * @param $projectCode
   *
   * @return bool
   */
  public function getHarvestProjectIdByCode($projectCode)
  {
    $projects = $this->getProjects();
    $id = FALSE;

    foreach ($projects as $project)
    {
      if ($projectCode != $project['project']['code'])
      {
        continue;
      }

      $id = $project['project']['id'];
      break;
    }

    return $id;
  }
}
