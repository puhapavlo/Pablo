<?php

namespace Drupal\pablo\Controller;

/**
 * @file
 * Contains \Drupal\pablo\Controller\PabloController.
 *
 * @return
 */

use Drupal\Core\Controller\ControllerBase;
use Drupal\pablo\Entity\Feedback;

/**
 * Provides route responses for the pablo module.
 */
class PabloController extends ControllerBase {

  /**
   * Returns a page.
   *
   * @return array
   *   A renderable array.
   */
  public function content() {

    // Get a renderable FeedbackForm array.
    $feedback = Feedback::Create();
    $feedbackForm = \Drupal::service('entity.form_builder')->getForm($feedback, 'default');
    // Get View for feedbacks.
    $view = views_embed_view('feedbacks');

    // Return renderable array.
    return [
      // Template name for current controller.
      '#theme' => 'pablo_template',
      '#form' => $feedbackForm,
      '#view' => $view,
    ];
  }

}
