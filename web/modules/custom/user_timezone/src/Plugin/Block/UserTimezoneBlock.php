<?php

declare(strict_types = 1);

namespace Drupal\user_timezone\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\user_timezone\UserTimezoneSalutation;
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
   * The salutation.
   *
   * @var \Drupal\user_timezone\UserTimezoneSalutation
   */
  protected $salutation;

  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $currentUser;

  /**
   * Constructs the UserTimezoneBlock object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_ID for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\user_timezone\UserTimezoneSalutation $salutation
   *   The salutation.
   * @param \Drupal\Core\Session\AccountInterface $currentUser
   *   The current user.
   */
  public function __construct(array $configuration, string $plugin_id, $plugin_definition, UserTimezoneSalutation $salutation, AccountInterface $currentUser) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->salutation = $salutation;
    $this->currentUser = $currentUser;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('user_timezone.salutation'),
      $container->get('current_user')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['#cache']['contexts'][] = 'timezone';
    $build['#cache']['max-age'] = 0;
    $build['#cache']['tags'][] = 'user_timezone';

    return [
      '#markup' => $this->salutation->getSalutation()->render(),
    ];
  }

}
