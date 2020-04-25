<?php

declare(strict_types = 1);

namespace Drupal\user_timezone;

use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Session\AccountInterface;
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
  public function getSalutation() {
    $time = (int) date('G', $this->time->getRequestTime());

    if ($time >= 06 && $time < 12) {
      $salutation = $this->t('Good morning %username', [
        '%username' => $this->currentUser->getAccountName(),
      ]);
    }

    elseif ($time >= 12 && $time < 18) {
      $salutation = $this->t('Good afternoon %username', [
        '%username' => $this->currentUser->getAccountName(),
      ]);
    }

    elseif ($time >= 18 && $time < 24) {
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
