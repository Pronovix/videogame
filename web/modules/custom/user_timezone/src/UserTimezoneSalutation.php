<?php

namespace Drupal\user_timezone;

use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Prepares user greeting.
 */
class UserTimezoneSalutation {
  use StringTranslationTrait;

  /**
   * Returns the greeting.
   */
  public function getSalutation() {
    $time = date('G', \Drupal::time()->getRequestTime());

    if ((int) $time->format('G') >= 06 && (int) $time->format('G') < 12) {
      return $this->t('Good morning ', \Drupal::currentUser());
    }

    if ((int) $time->format('G') >= 12 && (int) $time->format('G') < 18) {
      return $this->t('Good afternoon ', \Drupal::currentUser());
    }

    if ((int) $time->format('G') >= 18) {
      return $this->t('Good evening ', \Drupal::currentUser());
    }
  }

}
