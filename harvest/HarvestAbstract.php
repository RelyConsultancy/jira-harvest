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

/**
 * Class HarvestAbstract
 * @package harvest
 */
class HarvestAbstract
{
  /**
   * @var \harvest\HarvestRequest
   */
  protected $request;

  /**
   * Constructor.
   */
  public function __construct()
  {
    $this->request = new HarvestRequest();
  }
}
