<?php

namespace Drupal\pablo\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;

/**
 * Provides an interface for defining Feedback entities.
 *
 * @ingroup pablo
 */
interface FeedbackInterface extends ContentEntityInterface, EntityChangedInterface, EntityPublishedInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Feedback name.
   *
   * @return string
   *   Name of the Feedback.
   */
  public function getName();

  /**
   * Sets the Feedback name.
   *
   * @param string $name
   *   The Feedback name.
   *
   * @return \Drupal\pablo\Entity\FeedbackInterface
   *   The called Feedback entity.
   */
  public function setName($name);

  /**
   * Gets the Feedback creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Feedback.
   */
  public function getCreatedTime();

  /**
   * Sets the Feedback creation timestamp.
   *
   * @param int $timestamp
   *   The Feedback creation timestamp.
   *
   * @return \Drupal\pablo\Entity\FeedbackInterface
   *   The called Feedback entity.
   */
  public function setCreatedTime($timestamp);

}
