<?php

namespace Drupal\pablo\Entity;

use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityPublishedTrait;
use Drupal\Core\Entity\EntityTypeInterface;

/**
 * Defines the Feedback entity.
 *
 * @ingroup pablo
 *
 * @ContentEntityType(
 *   id = "feedback",
 *   label = @Translation("Feedback"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\pablo\FeedbackListBuilder",
 *     "views_data" = "Drupal\pablo\Entity\FeedbackViewsData",
 *     "translation" = "Drupal\pablo\FeedbackTranslationHandler",
 *
 *     "form" = {
 *       "default" = "Drupal\pablo\Form\FeedbackForm",
 *       "add" = "Drupal\pablo\Form\FeedbackForm",
 *       "edit" = "Drupal\pablo\Form\FeedbackForm",
 *       "delete" = "Drupal\pablo\Form\FeedbackDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\pablo\FeedbackHtmlRouteProvider",
 *     },
 *     "access" = "Drupal\pablo\FeedbackAccessControlHandler",
 *   },
 *   base_table = "feedback",
 *   data_table = "feedback_field_data",
 *   translatable = TRUE,
 *   admin_permission = "administer feedback entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "langcode" = "langcode",
 *     "published" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/feedback/{feedback}",
 *     "add-form" = "/admin/structure/feedback/add",
 *     "edit-form" = "/admin/structure/feedback/{feedback}/edit",
 *     "delete-form" = "/admin/structure/feedback/{feedback}/delete",
 *     "collection" = "/admin/structure/feedback",
 *   },
 *   field_ui_base_route = "feedback.settings"
 * )
 */
class Feedback extends ContentEntityBase implements FeedbackInterface {

  use EntityChangedTrait;
  use EntityPublishedTrait;

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    // Add the published field.
    $fields += static::publishedBaseFieldDefinitions($entity_type);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the Feedback entity.'))
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['status']->setDescription(t('A boolean indicating whether the Feedback is published.'))
      ->setDisplayOptions('form', [
        'type' => 'boolean_checkbox',
        'weight' => -3,
      ]);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
