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

    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the Advertiser entity.'))
      ->setReadOnly(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'integer',
        'weight' => -4,
      ]);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The minimum length of the name is 2 characters, and the maximum is 100'))
      ->setSettings([
        'max_length' => 100,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
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

    $fields['email'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Email'))
      ->setDescription(t('Example: example@gmail.com'))
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'email',
        'weight' => -3,
      ])
      ->setDisplayOptions('form', [
        'type' => 'email',
        'weight' => -3,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['phone'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Phone'))
      ->setDescription(t('Example: 380960000000'))
      ->setSettings([
        'max_length' => 16,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string_textfield',
        'weight' => -2,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string',
        'weight' => -2,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['feedback'] = BaseFieldDefinition::create('string_long')
      ->setLabel(t('Feedback'))
      ->setSettings([
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'text_long',
        'weight' => -1,
      ])
      ->setDisplayOptions('form', [
        'type' => 'text_long',
        'weight' => -1,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['avatar'] = BaseFieldDefinition::create('image')
      ->setLabel(t('Avatar'))
      ->setDescription(t('The image format should be jpeg, jpg, png and the file size should not exceed 2 MB'))
      ->setSettings([
        'file_extensions' => 'png jpg jpeg',
        'max_filesize' => '2000000',
        'alt_field' => 0,
        'alt_field_required' => FALSE,
      ])
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'image',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'image',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['picture'] = BaseFieldDefinition::create('image')
      ->setLabel(t('Picture'))
      ->setDescription(t('The image format should be jpeg, jpg, png and the file size should not exceed 5 MB'))
      ->setSettings([
        'file_extensions' => 'png jpg jpeg',
        'max_filesize' => '5000000',
        'alt_field' => 0,
        'alt_field_required' => FALSE,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'image',
        'weight' => 1,
      ])
      ->setDisplayOptions('form', [
        'type' => 'image',
        'weight' => 1,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'))
      ->setSettings([
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'timestamp',
        'weight' => -4,
        'settings' => [
          'date_format' => 'custom',
          'custom_date_format' => 'M/d/Y H:i:s',
        ],
      ]);

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
