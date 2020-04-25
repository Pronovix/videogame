<?php

declare(strict_types = 1);

namespace Drupal\user_timezone\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\user_timezone\UserTimezoneRecommendation;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides UserTimezone Recommendation block.
 *
 * @Block(
 *   id = "user_timezone_recommendation_block",
 *   admin_label = @Translation("User timezone recommendation block"),
 * )
 */
class UserTimezoneRecommendationBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The recommendation.
   *
   * @var \Drupal\user_timezone\UserTimezoneRecommendation
   */
  protected $recommendation;

  /**
   * Constructs the UserTimezoneRecommendationBlock object.
   *
   * @param string $configuration
   *   A configuration string containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_ID for the plugin instance.
   * @param string $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\user_timezone\UserTimezoneRecommendation $recommendation
   *   The recommendation.
   */
  public function __construct(array $configuration, string $plugin_id, $plugin_definition, UserTimezoneRecommendation $recommendation) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->recommendation = $recommendation;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('user_timezone.recommendation')
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
      '#markup' => $this->recommendation->getRecommendation()->render(),
    ];
  }

}
