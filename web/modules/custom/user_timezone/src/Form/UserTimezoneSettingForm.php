<?php

declare(strict_types = 1);

namespace Drupal\user_timezone\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class UserTimezoneSettingForm.
 */
class UserTimezoneSettingForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['user_timezone.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'user_timezone_setting_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('user_timezone.settings');

    $form['morning_start'] = [
      '#type' => 'number',
      '#title' => $this->t('Morning'),
      '#description' => $this->t('Set the start point of your custom morning time range; the start of morning time is also the end of night time.'),
      '#min' => 00,
      '#max' => 23,
      '#default_value' => $config->get('morning'),
      '#required' => TRUE,
    ];

    $form['afternoon_start'] = [
      '#type' => 'number',
      '#title' => $this->t('Afternoon'),
      '#description' => $this->t('Set the start point of your custom afternoon time range; the start of afternoon time is also the end of morning time.'),
      '#min' => 00,
      '#max' => 23,
      '#default_value' => $config->get('afternoon'),
      '#required' => TRUE,
    ];

    $form['evening_start'] = [
      '#type' => 'number',
      '#title' => $this->t('Evening'),
      '#description' => $this->t('Set the start point of your custom evening time range; the start of evening time is also the end of afternoon time.'),
      '#min' => 00,
      '#max' => 23,
      '#default_value' => $config->get('evening'),
      '#required' => TRUE,
    ];

    $form['night_start'] = [
      '#type' => 'number',
      '#title' => $this->t('Night'),
      '#description' => $this->t('Set the start point of your custom night time range; the start of night time is also the end of evening time.'),
      '#min' => 00,
      '#max' => 23,
      '#default_value' => $config->get('night'),
      '#required' => TRUE,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $morning_start = $form_state->getValue('morning_start');
    $afternoon_start = $form_state->getValue('afternoon_start');
    $evening_start = $form_state->getValue('evening_start');
    $night_start = $form_state->getValue('night_start');

    if ($morning_start == $afternoon_start) {
      $form_state->setErrorByName('morning_start', $this->t('The value of the morning start time cannot be the same as the value of the afternoon start time.'));
    }

    if ($morning_start == $evening_start) {
      $form_state->setErrorByName('morning_start', $this->t('The value of the morning start time cannot be the same as the value of the evening start time.'));
    }

    if ($morning_start == $night_start) {
      $form_state->setErrorByName('morning_start', $this->t('The value of the morning start time cannot be the same as the value of the night start time.'));
    }

    if ($afternoon_start == $evening_start) {
      $form_state->setErrorByName('afternoon_start', $this->t('The value of the afternoon start time cannot be the same as the value of the evening start time.'));
    }

    if ($afternoon_start == $night_start) {
      $form_state->setErrorByName('afternoon_start', $this->t('The value of the afternoon start cannot be the same as the value of the night start time.'));
    }

    if ($evening_start == $night_start) {
      $form_state->setErrorByName('evening_start', $this->t('The value of the evening start time cannot be the same as the value of the night start time.'));
    }

    if ($night_start > $morning_start || $night_start > $afternoon_start || $night_start > $evening_start) {
      $form_state->setErrorByName('night_start', $this->t('The value of the night start time has to be less than the value of morning, afternoon and evening start time.'));
    }
    if ($morning_start > $afternoon_start || $morning_start > $evening_start) {
      $form_state->setErrorByName('morning_start', $this->t('The value of the morning start time has to be less than the value of the afternoon and evening start time.'));
    }
    if ($afternoon_start > $evening_start) {
      $form_state->setErrorByName('afternoon_start', $this->t('The value of the afternoon start time has to be less than the value of the evening start time.'));
    }

  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $this->config('user_timezone.settings')
      ->set('morning', $form_state->getValue('morning_start'))
      ->set('afternoon', $form_state->getValue('afternoon_start'))
      ->set('evening', $form_state->getValue('evening_start'))
      ->set('night', $form_state->getValue('night_start'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
