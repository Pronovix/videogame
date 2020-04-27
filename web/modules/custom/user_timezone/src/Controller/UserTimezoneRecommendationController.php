<?php

declare(strict_types = 1);

namespace Drupal\user_timezone\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class UserTimezoneRecommendationController.
 */
class UserTimezoneRecommendationController extends ControllerBase {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The recommendation.
   *
   * @var \Drupal\user_timezone\UserTimezoneRecommendation
   */
  protected $recommendation;

  /**
   * Constructs the UserTimezoneRecommendationController object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   The entity type manager.
   */
  public function __construct(EntityTypeManagerInterface $entityTypeManager) {
    $this->entityTypeManager = $entityTypeManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function index(): array {
    $json_array = [
      'data' => [],
    ];
    $query = $this->entityTypeManager->getStorage('node')->getQuery();
    $nids = $query
      ->condition('type', 'article')
      ->condition('status', '1')
      ->condition('field_session_time.entity.name', $this->getTaxonomyName())
      ->execute();

    if ($nids) {
      $node = $this->entityTypeManager->getStorage('node')->loadMultiple($nids);
      array_rand($node);
      $firstItem = reset($node);
      return [
        'Product name' => $firstItem->title->value,
        'url' => $firstItem->toUrl()->toString(),
      ];
    }

    return new JsonResponse($json_array);
  }

  /**
   * {@inheritdoc}
   */
  public function getTaxonomyName(): string {
    $recommendation = $this->recommendation->getRecommendation();
    $productRecommendation = (string) $recommendation;

    if ($productRecommendation == (string) $this->t('Play this game in the morning')) {
      $taxonomy = '0.5 h';
    }

    elseif ($productRecommendation == (string) $this->t('Play this game in the afternoon')) {
      $taxonomy = '1 h';
    }

    elseif ($productRecommendation == (string) $this->t('Play this game in the evening')) {
      $taxonomy = 'more than 1 h';
    }

    else {
      $taxonomy = 'more than 1 h';
    }

    return $taxonomy;
  }

}
