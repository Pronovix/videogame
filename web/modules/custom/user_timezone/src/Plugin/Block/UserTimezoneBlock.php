<?php

declare(strict_types = 1);

namespace Drupal\user_timezone\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
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
   */
  public function __construct(array $configuration, string $plugin_id, $plugin_definition, UserTimezoneSalutation $salutation) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->salutation = $salutation;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('user_timezone.salutation')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#markup' => $this->salutation->getSalutation(),
    ];
  }

}
