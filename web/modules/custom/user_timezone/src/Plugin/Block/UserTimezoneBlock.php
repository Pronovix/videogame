<?php

declare(strict_types = 1);

namespace Drupal\user_timezone\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a UserTimezone block.
 *
 * @Block(
 *   id = "user_timezone_block",
 *   admin_label = @Translation("User timezone block"),
 * )
 */
class UserTimezoneBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The form builder.
   *
   * @var \Drupal\user_timezone\UserTimezoneSalutation
   */
  protected $salutation;

  /**
   * {@inheritdoc}
   */
  public function __construct(UserTimezoneSalutation $salutation) {
    $this->salutation = $salutation;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $container->get('user_timezone.salutation')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#markup' => $this->salutation->getSalutation('\Drupal\user_timezone\UserTimezoneSalutation'),
    ];
  }

}
