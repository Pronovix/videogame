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
   * @var UserTimezoneRecommendation
   */
  protected $recommendation;

  /**
   * Constructs the UserTimezoneRecommendationBlock object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param $plugin_id
   *   The plugin_ID for the plugin instance.
   * @param $plugin_definition
   *   The plugin implementation definition.
   * @param UserTimezoneRecommendation $recommendation
   *   The recommendation.
   */
  public function __construct(array $configuration, string $plugin_id, $plugin_definition, UserTimezoneRecommendation $recommendation) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->recommendation = $recommendation;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static($configuration, $plugin_id, $plugin_definition,
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
