<?php

namespace Drupal\timeago\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class TimeagoConfigForm.
 */
class TimeagoConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'timeago.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'timeago_config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('timeago.settings');
    $form['timeago_node'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Use timeago for node creation dates'),
      '#default_value' => $config->get('timeago_node'),
    ];
    $form['timeago_comment'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Use timeago for comment creation/changed dates'),
      '#default_value' => $config->get('timeago_comment'),
    ];
    $form['timeago_elem'] = [
      '#type' => 'radios',
      '#title' => $this->t('Time element'),
      '#options' => array('span' => $this->t('span'), 'abbr' => $this->t('abbr'), 'time' => $this->t('time')),
      '#default_value' => $config->get('timeago_elem'),
    ];
    $form['settings'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Override Timeago script settings'),
    ];
    $form['settings']['timeago_js_refresh_millis'] = [
      '#type' => 'textfield',
      '#title' => $this->t('timeago_js_refresh_millis'),
      '#description' => $this->t('Timeago can update its dates without a page refresh at this interval. Leave blank or set to zero to never refresh Timeago dates.'),
      '#default_value' => $config->get('timeago_js_refresh_millis'),
    ];
    $form['settings']['timeago_js_allow_future'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Allow future dates'),
      '#default_value' => $config->get('timeago_js_allow_future'),
    ];
    $form['settings']['timeago_js_locale_title'] = [
      '#type' => 'checkbox',
      '#title' => $this->t("Set the 'title' attribute of Timeago dates to a locale-sensitive date"),
      '#description' => $this->t("If this is disabled (the default) then the 'title' attribute defaults to the original date that the Timeago script is replacing."),
      '#default_value' => $config->get('timeago_js_locale_title'),
    ];
    $form['settings']['timeago_js_cutoff'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Do not use Timeago dates after'),
      '#description' => $this->t('Leave blank or set to zero to always use Timeago dates.'),
      '#default_value' => $config->get('timeago_js_cutoff'),
    ];
    $form['strings'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Strings'),
    ];
    $form['strings']['timeago_js_strings_word_separator'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Word separator'),
      '#description' => $this->t("By default this is set to ' ' (a space)."),
      '#default_value' => $config->get('timeago_js_strings_word_separator'),
    ];
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

    $this->config('timeago.settings')
      ->set('timeago_node', $form_state->getValue('timeago_node'))
      ->set('timeago_comment', $form_state->getValue('timeago_comment'))
      ->set('timeago_elem', $form_state->getValue('timeago_elem'))
      ->set('settings', $form_state->getValue('settings'))
      ->set('timeago_js_refresh_millis', $form_state->getValue('timeago_js_refresh_millis'))
      ->set('timeago_js_allow_future', $form_state->getValue('timeago_js_allow_future'))
      ->set('timeago_js_locale_title', $form_state->getValue('timeago_js_locale_title'))
      ->set('timeago_js_cutoff', $form_state->getValue('timeago_js_cutoff'))
      ->set('strings', $form_state->getValue('strings'))
      ->set('timeago_js_strings_word_separator', $form_state->getValue('timeago_js_strings_word_separator'))
      ->save();
  }

}
