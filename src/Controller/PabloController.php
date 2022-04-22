<?php

namespace Drupal\pablo\Controller;

/**
 * @file
 * Contains \Drupal\pablo\Controller\PabloController.
 *
 * @return
 */

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\OpenModalDialogCommand;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\node\Entity\Node;
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
    $view = \Drupal\views\Views::getView('feedbacks');
    $view->setDisplay('default');
    $view->execute();

    dpm($view->execute());

    // Return renderable array.
    return [
      // Template name for current controller.
      '#theme' => 'pablo_template',
      '#form' => $feedbackForm,
    ];
  }

  /**
   * Function for outputting the deletion form.
   *
   * @param int $id
   *   Id a entry from the database.
   *
   * @return \Drupal\Core\Ajax\AjaxResponse
   *   return ajax response
   */
  public function delete($id) {

    $confirmDeleteForm = \Drupal::formBuilder()->getForm('Drupal\guestbook\Form\ConfirmDeleteForm', $id);
    // Used AJAX.
    $response = new AjaxResponse();
    $response->addCommand(new OpenModalDialogCommand('Delete', $confirmDeleteForm, ['width' => '800']));

    return $response;
  }

  /**
   * Function for outputting the edition form.
   *
   * @param int $id
   *   Id a entry from the database.
   *
   * @return \Drupal\Core\Ajax\AjaxResponse
   *   Return ajax response.
   */
  public function edit($id) {
    // Getting data from the database using the route parameter.
    $conn = Database::getConnection();
    $query = $conn->select('guestbook', 'g');
    $query->condition('id', $id)->fields('g');
    $entry = $query->execute()->fetchAssoc();

    $editForm = \Drupal::formBuilder()->getForm('Drupal\guestbook\Form\EditForm', $entry);
    $response = new AjaxResponse();
    $response->addCommand(new OpenModalDialogCommand('Edit Form', $editForm, ['width' => '800']));

    return $response;
  }

}
