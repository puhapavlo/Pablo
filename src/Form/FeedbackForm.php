<?php

namespace Drupal\pablo\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\MessageCommand;
use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Form controller for Feedback edit forms.
 *
 * @ingroup pablo
 */
class FeedbackForm extends ContentEntityForm {

  /**
   * The current user account.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $account;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    // Instantiates this form class.
    $instance = parent::create($container);
    $instance->account = $container->get('current_user');
    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var \Drupal\pablo\Entity\Feedback $entity */
    $form = parent::buildForm($form, $form_state);
    $form['system_messages'] = [
      '#markup' => '<div id="form-system-messages"></div>',
      '#weight' => -100,
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  protected function actions(array $form, FormStateInterface $form_state) {
    $element = parent::actions($form, $form_state);
    $element['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#submit' => ['::submitForm', '::save'],
      '#ajax' => [
        'callback' => '::save',
        'event' => 'click',
        'progress' => [
          'type' => 'throbber',
        ],
      ],
    ];
    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {

    $response = new AjaxResponse();
    dpm($form_state->getValue('avatar')[0]['fids'][0]);
    // Validation name.
    if (strlen($form_state->getValue('name')[0]['value']) < 2 || strlen($form_state->getValue('name')[0]['value']) > 100) {
      $response->addCommand(new MessageCommand($this->t('The minimum length of the name is 2 characters, and the maximum is 100.'), '#form-system-messages', ['type' => 'error']));
    }

    // Validation email.
    elseif (!preg_match('/^.+@.+.\..+$/i', $form_state->getValue('email')[0]['value'])) {
      $response->addCommand(new MessageCommand($this->t('The email is not valid.'), '#form-system-messages', ['type' => 'error'], TRUE));
    }

    // Validation phone.
    elseif (!preg_match('/^\d+$/', $form_state->getValue('phone')[0]['value']) || strlen($form_state->getValue('phone')[0]['value']) > 16) {
      $response->addCommand(new MessageCommand($this->t('The phone number should include only numbers and be 16 characters long.'), '#form-system-messages', ['type' => 'error'], TRUE));
    }

    // Validation feedback.
    elseif ($form_state->getValue('feedback')[0]['value'] == NULL) {
      $response->addCommand(new MessageCommand($this->t('Feedback field is empty'), '#form-system-messages', ['type' => 'error'], TRUE));
    }

    else {
      $entity = $this->entity;

      $status = parent::save($form, $form_state);
      switch ($status) {
        case SAVED_NEW:
          $response->addCommand(new MessageCommand($this->t('Entry modified successfully.'), '#form-system-messages', ['type' => 'status']));
          break;

        default:
          $response->addCommand(new MessageCommand($this->t('Thank you very much for your message.'), '#form-system-messages', ['type' => 'status']));
      }
    }
    return $response;
  }

}
