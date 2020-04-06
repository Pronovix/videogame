<?php

declare(strict_types = 1);

namespace Drupal\user_timezone;

use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Prepares user greeting.
 */
class UserTimezoneSalutation{
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
  public function __construct(AccountProxyInterface $currentUser) {
    $this->currentUser = $currentUser;
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
    $time = (int) date('G', \Drupal::time()->getRequestTime());

    if ((int) $time >= 06 && (int) $time < 12) {
      return $this->t('Good morning %username', [
        '%username' => $this->currentUser->getAccountName(),
        ]);
    }

    if ((int) $time >= 12 && (int) $time < 18) {
      return $this->t('Good afternoon %username', [
        '%username' => $this->currentUser->getAccountName(),
        ]);
    }

    if ((int) $time >= 18) {
      return $this->t('Good evening %username', [
        '%username' => $this->currentUser->getAccountName(),
        ]);
    }
  }

}
