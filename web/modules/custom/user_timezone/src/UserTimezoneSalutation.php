<?php

declare(strict_types = 1);

namespace Drupal\user_timezone;

use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\StringTranslation\TranslationInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Prepares user greeting.
 */
class UserTimezoneSalutation {
  use StringTranslationTrait;

  /**
   * The config.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The current user service.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $currentUser;

  /**
   * The time.
   *
   * @var \Drupal\Component\Datetime\TimeInterface
   */
  protected $time;

  /**
   * The translation manager.
   *
   * @var \Drupal\Core\StringTranslation\TranslationInterface
   */
  protected $stringTranslation;

  /**
   * {@inheritdoc}
   */
  public function __construct(ConfigFactoryInterface $configFactory, AccountInterface $currentUser, TimeInterface $time, TranslationInterface $stringTranslation) {
    $this->configFactory = $configFactory;
    $this->currentUser = $currentUser;
    $this->time = $time;
    $this->stringTranslation = $stringTranslation;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('current_user')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getSalutation(): TranslatableMarkup {
    $time = (int) date('G', $this->time->getRequestTime());
    $configMorning = $this->configFactory->get('user_timezone.settings')->get('morning_start');
    $configAfternoon = $this->configFactory->get('user_timezone.settings')->get('afternoon_start');
    $configEvening = $this->configFactory->get('user_timezone.settings')->get('evening_start');

    if ($time >= $configMorning && $time < $configAfternoon) {
      $salutation = $this->t('Good morning %username', [
        '%username' => $this->currentUser->getAccountName(),
      ]);
    }

    elseif ($time >= $configAfternoon && $time < $configEvening) {
      $salutation = $this->t('Good afternoon %username', [
        '%username' => $this->currentUser->getAccountName(),
      ]);
    }

    elseif ($time >= $configEvening && $time < 23) {
      $salutation = $this->t('Good evening %username', [
        '%username' => $this->currentUser->getAccountName(),
      ]);
    }

    else {
      $salutation = $this->t('Good night %username', [
        '%username' => $this->currentUser->getAccountName(),
      ]);
    }

    return $salutation;
  }

}
