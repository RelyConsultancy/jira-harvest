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
 * Class JiraChangelog
 * @package jira
 */
class JiraChangelog
{
  /**
   * @var \stdClass
   */
  protected $changelog;

  /**
   * Constructor.
   *
   * @param \stdClass $changelog
   */
  public function __construct($changelog)
  {
    $this->changelog = $changelog;
  }

  public function getChangelog()
  {
    return $this->changelog;
  }

  /**
   * Getter for the changelog ID.
   *
   * @return mixed
   */
  public function getChangelogID()
  {
    if (!empty($this->changelog->id))
    {
      return $this->changelog->id;
    }

    return FALSE;
  }

  /**
   * Get the worklog ID.
   *
   * @return string|bool
   */
  public function getWorklogId()
  {
    foreach ($this->changelog->items as $changelogItem)
    {
      if (!empty($changelogItem->field) && $changelogItem->field == 'WorklogId')
      {
        return $changelogItem->from;
      }
    }

    return FALSE;
  }
}
