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
      '#title' => $this->t('Beginning of morning'),
      '#description' => $this->t('Set the start point of your custom morning time range; time interval (e.g.: 06-12)'),
      '#min' => 00,
      '#max' => 23,
      '#default value' => $config->get('morning_start'),
      '#element validate' => 'validateNumber',
      '#required' => TRUE,
    ];

    $form['morning_end'] = [
      '#type' => 'number',
      '#title' => $this->t('End of morning'),
      '#description' => $this->t('Set the end point of your custom morning time range (e.g.: 06-12)'),
      '#min' => 00,
      '#max' => 23,
      '#default value' => $config->get('morning_end'),
      '#element validate' => 'validateNumber',
      '#required' => TRUE,
    ];

    $form['afternoon_start'] = [
      '#type' => 'number',
      '#title' => $this->t('Beginning of afternoon'),
      '#description' => $this->t('Set the start point of your custom afternoon time range (e.g.: 12-18)'),
      '#min' => 00,
      '#max' => 23,
      '#default value' => $config->get('afternoon_start'),
      '#element validate' => 'validateNumber',
      '#required' => TRUE,
    ];

    $form['afternoon_end'] = [
      '#type' => 'number',
      '#title' => $this->t('End of afternoon'),
      '#description' => $this->t('Set the end point of your custom afternoon time range (e.g.: 12-18)'),
      '#min' => 00,
      '#max' => 23,
      '#default value' => $config->get('afternoon_end'),
      '#element validate' => 'validateNumber',
      '#required' => TRUE,
    ];

    $form['evening_start'] = [
      '#type' => 'number',
      '#title' => $this->t('Beginning of evening'),
      '#description' => $this->t('Set the start point of your custom evening time range (e.g.: 18-00)'),
      '#min' => 00,
      '#max' => 23,
      '#default value' => $config->get('evening_start'),
      '#element validate' => 'validateNumber',
      '#required' => TRUE,
    ];

    $form['evening_end'] = [
      '#type' => 'number',
      '#title' => $this->t('End of evening'),
      '#description' => $this->t('Set the end point of your custom evening time range (e.g.: 18-00)'),
      '#min' => 00,
      '#max' => 23,
      '#default value' => $config->get('evening_end'),
      '#element validate' => 'validateNumber',
      '#required' => TRUE,
    ];

    $form['night_start'] = [
      '#type' => 'number',
      '#title' => $this->t('Beginning of night'),
      '#description' => $this->t('Set the start point of your custom night time range (e.g.: 00-05)'),
      '#min' => 00,
      '#max' => 23,
      '#default value' => $config->get('night_beginning'),
      '#element validate' => 'validateNumber',
      '#required' => TRUE,
    ];

    $form['night_end'] = [
      '#type' => 'number',
      '#title' => $this->t('End of night'),
      '#description' => $this->t('Set the end point of your custom night time ranger (e.g.: 00-05)'),
      '#min' => 00,
      '#max' => 23,
      '#default value' => $config->get('night_end'),
      '#element validate' => 'validateNumber',
      '#required' => TRUE,
    ];

    return parent::buildForm($form, $form_state);
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    $morning_start = $form_state->getValue('morning_start');
    $morning_end = $form_state->getValue('morning_end');
    $afternoon_start = $form_state->getValue('afternoon_start');
    $afternoon_end = $form_state->getValue('afternoon_end');
    $evening_start = $form_state->getValue('evening_start');
    $evening_end = $form_state->getValue('evening_end');
    $night_start = $form_state->getValue('night_start');
    $night_end = $form_state->getValue('night_end');

    if ($night_end !== $morning_start) {
      $form_state->setErrorByName('night_end', $this->t('The value of the morning start time has to be the same as the value of the night end time.'));
    }
    if ($morning_end != $afternoon_start) {
      $form_state->setErrorByName('morning_end', $this->t('The value of the afternoon start time has to be the same as the value of the morning end time.'));
    }
    if ($afternoon_end != $evening_start) {
      $form_state->setErrorByName('afternoon_end', $this->t('The value of the evening start time has to be the same as the value of the afternoon end time.'));
    }
    if ($evening_end != $night_start) {
      $form_state->setErrorByName('evening_end', $this->t('The value of the night start time has to be the same as the value of the evening end time.'));
    }

  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('user_timezone.settings')
      ->set('morning', $form_state->getValue('morning'))
      ->set('afternoon', $form_state->getValue('afternoon'))
      ->set('evening', $form_state->getValue('evening'))
      ->set('night', $form_state->getValue('night'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
