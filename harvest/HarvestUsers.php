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
 * Class HarvestUsers
 * @package harvest
 */
class HarvestUsers extends HarvestAbstract
{
  /**
   * Get all Harvest users.
   *
   * @return array
   *   The users array if request was successful, empty array otherwise.
   */
  protected function getUsers()
  {
    $this->request->setUrl(HARVEST_BASE_URL . HARVEST_GET_USERS_PATH);
    $response = $this->request->sendRequest('GET');

    if ($response)
    {
      return $response;
    }

    return array();
  }

  /**
   * Get Harvest user ID by email.
   *
   * @param string $email
   *   The user email for which we need to return the user id.
   *
   * @return bool|string
   *   The user ID if user was found, FALSE otherwise.
   */
  public function getUserIdByEmail($email)
  {
    $users = $this->getUsers();

    // Logger::log('HarvestUsers::getUserIdByEmail', 'Users list', $users);

    $id = FALSE;

    foreach ($users as $user)
    {
      if ($email != $user['user']['email'])
      {
        continue;
      }

      $id = $user['user']['id'];
      break;
    }

    return $id;
  }
}
