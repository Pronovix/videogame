<?php

declare(strict_types = 1);

namespace Drupal\user_timezone;

use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\StringTranslation\TranslationInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Prepares user greeting.
 */
class UserTimezoneSalutation {
  use StringTranslationTrait;

  /**
   * The value of time.
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
   * {@inheritdoc}
   */
  public function __construct(ConfigFactoryInterface $configFactory, AccountProxyInterface $currentUser, TimeInterface $time, TranslationInterface $stringTranslation) {
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
  public function getSalutation() {
    $time = (int) date('G', $this->time->getRequestTime());
    $config_morning_start = $this->configFactory->get('user_timezone.settings')->get('morning_start');
    $config_morning_end = $this->configFactory->get('user_timezone.settings')->get('morning_end');
    $config_afternoon_start = $this->configFactory->get('user_timezone.settings')->get('afternoon_start');
    $config_afternoon_end = $this->configFactory->get('user_timezone.settings')->get('afternoon_end');
    $config_evening_start = $this->configFactory->get('user_timezone.settings')->get('evening_start');
    $config_evening_end = $this->configFactory->get('user_timezone.settings')->get('evening_end');
    $config_night_start = $this->configFactory->get('user_timezone.settings')->get('night_start');
    $config_night_end = $this->configFactory->get('user_timezone.settings')->get('night_end');

    if ($time >= 06 && $time < 12) {
      $salutation = $this->t('Good morning, %username!', [
        '%username' => $this->currentUser->getAccountName(),
      ]);
    }

    elseif ($time >= 12 && $time < 18) {
      $salutation = $this->t('Good afternoon, %username!', [
        '%username' => $this->currentUser->getAccountName(),
      ]);
    }

    elseif ($time >= 18 && $time < 24) {
      $salutation = $this->t('Good evening, %username!', [
        '%username' => $this->currentUser->getAccountName(),
      ]);
    }

    else {
      $salutation = $this->t('Good night, %username!', [
        '%username' => $this->currentUser->getAccountName(),
      ]);
    }

    return $salutation;
  }

}
