<?php

namespace Drupal\user_timezone\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class UserTimezoneController
 * @package Drupal\user_timezone\Controller
 */
class UserTimezoneController extends ControllerBase {

  public function content() {
    $build = [
      '#markup' => $this->t('hello')
    ];
  }

}
