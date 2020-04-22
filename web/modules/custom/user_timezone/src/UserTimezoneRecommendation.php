<?php

declare(strict_types = 1);

namespace Drupal\user_timezone;

use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\StringTranslation\TranslationInterface;

/**
 * Prepares the recommendation.
 */
class UserTimezoneRecommendation {
  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  public function __construct(TimeInterface $time, TranslationInterface $stringTranslation) {
    $this->time = $time;
    $this->stringTranslation = $stringTranslation;
  }

  /**
   * {@inheritdoc}
   */
  public function getRecommendation() {
    $time = (int) date('G', $this->time->getRequestTime());

    if ($time >= 06 && $time < 12) {
      $recommendation = $this->t('Play this game in the morning');
    }

    elseif ($time >= 12 && $time < 18) {
      $recommendation = $this->t('Play this game in the afternoon');
    }

    elseif ($time >= 18 && $time < 24) {
      $recommendation = $this->t('Play this game in the evening');
    }

    else {
      $recommendation = $this->t('Play this game at night');
    }

    return $recommendation;
  }

}
