<?php

/**
 * @file
 * Contains Drupal\menu_link_attributes\Form\ConfigForm.
 */

namespace Drupal\menu_link_attributes\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ConfigForm.
 *
 * @package Drupal\menu_link_attributes\Form
 */
class ConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'menu_link_attributes.config'
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'menu_link_attributes_config';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('menu_link_attributes.config');
    $attributes_text = $config->get('attributes') ?: [];
    $attributes = menu_link_attributes_split($attributes_text);

    $form['attributes'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Attributes'),
      '#description' => $this->t('Enter one attribute per line in <code>attribute|label|description</code> format. Label and description are optional.'),
      '#default_value' => $attributes,
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $attributes_text = $form_state->getValue('attributes');
    $attributes = menu_link_attributes_parse($attributes_text);

    $this->config('menu_link_attributes.config')
      ->set('attributes', $attributes)
      ->save();
  }

}
