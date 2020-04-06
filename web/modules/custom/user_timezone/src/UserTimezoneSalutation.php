<?php

declare(strict_types = 1);

namespace Drupal\user_timezone;

use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Prepares user greeting.
 */
class UserTimezoneSalutation {
  use StringTranslationTrait;

  /**
   * The current user service.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $currentUser;

  /**
   * {@inheritdoc}
   */
  public function __construct(AccountProxyInterface $currentUser, TimeInterface $time) {
    $this->currentUser = $currentUser;
    $this->time = $time;
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
    $time = $this->time->getRequestTime();

    if ($time >= 06 && (int) $time < 12) {
      return $this->t('Good morning %username', [
        '%username' => $this->currentUser->getAccountName(),
      ]);
    }

    if ($time >= 12 && (int) $time < 18) {
      return $this->t('Good afternoon %username', [
        '%username' => $this->currentUser->getAccountName(),
      ]);
    }

    if ($time >= 18) {
      return $this->t('Good evening %username', [
        '%username' => $this->currentUser->getAccountName(),
      ]);
    }
  }

}
