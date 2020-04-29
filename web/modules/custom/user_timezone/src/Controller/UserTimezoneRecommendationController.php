<?php

declare(strict_types = 1);

namespace Drupal\user_timezone\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\user_timezone\UserTimezoneSalutation;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class UserTimezoneRecommendationController.
 */
final class UserTimezoneRecommendationController extends ControllerBase {

  /**
   * The recommendation.
   *
   * @var \Drupal\user_timezone\UserTimezoneSalutation
   */
  protected $salutation;

  /**
   * Constructs the UserTimezoneRecommendationController object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   The entity type manager.
   * @param \Drupal\user_timezone\UserTimezoneSalutation $salutation
   *   The salutation.
   */
  public function __construct(EntityTypeManagerInterface $entityTypeManager, UserTimezoneSalutation $salutation) {
    $this->entityTypeManager = $entityTypeManager;
    $this->salutation = $salutation;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager'),
      $container->get('user_timezone.salutation')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function content(): JsonResponse {
    $query = $this->entityTypeManager->getStorage('node')->getQuery();
    $nids = $query
      ->condition('type', 'product')
      ->condition('status', '1')
      ->condition('field_minimum_game_session_time.target_id', $this->getTaxonomyId())
      ->execute();

    if ($nids) {
      $node = $this->entityTypeManager->getStorage('node')->loadMultiple($nids);
      $firstItem = $node[array_rand($node, 1)];
      return new JsonResponse([
        'product_name' => $firstItem->label(),
        'url' => $firstItem->toUrl('canonical', ['absolute'=> TRUE])->toString(),
      ]);
    }

    return new JsonResponse(new \stdClass());
  }

  /**
   * {@inheritdoc}
   * @return int|null
   */
  public function getTaxonomyId(): ?int {
    $greeting = $this->salutation->getSalutation();
    $productRecommendation = (string) $greeting;

    if ($productRecommendation == (string) $this->t('Good morning')) {
      $taxonomy = '0.5 h';
    }

    elseif ($productRecommendation == (string) $this->t('Good afternoon')) {
      $taxonomy = '1 h';
    }

    elseif ($productRecommendation == (string) $this->t('Good evening')) {
      $taxonomy = 'more than 1 h';
    }

    else {
      $taxonomy = 'more than 1 h';
    }

    $terms = $this->entityTypeManager->getStorage('taxonomy_term')->loadByProperties([
      'name' => $taxonomy,
      'vid' => 'session_time',
    ]);

    return $terms?(int)reset($terms)->id():NULL;

  }

}
