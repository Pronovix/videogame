<?php

declare(strict_types = 1);

namespace Drupal\user_timezone\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityStorageInterface;
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
   * The node storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  private $nodeStorage;

  /**
   * The term storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  private $termStorage;

  /**
   * Constructs the UserTimezoneRecommendationController object.
   *
   * @param \Drupal\Core\Entity\EntityStorageInterface $nodeStorage
   *   The node storage.
   * @param \Drupal\Core\Entity\EntityStorageInterface $termStorage
   *   The term storage.
   * @param \Drupal\user_timezone\UserTimezoneSalutation $salutation
   *   The salutation.
   */
  public function __construct(EntityStorageInterface $nodeStorage, EntityStorageInterface $termStorage, UserTimezoneSalutation $salutation) {
    $this->nodeStorage = $nodeStorage;
    $this->termStorage = $termStorage;
    $this->salutation = $salutation;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $entityTypeManager = $container->get('entity_type.manager');
    return new static(
      $entityTypeManager->getStorage('node'),
      $entityTypeManager->getStorage('taxonomy_term'),
      $container->get('user_timezone.salutation')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function content(): JsonResponse {
    $query = $this->nodeStorage->getQuery();
    $nids = $query
      ->condition('type', 'product')
      ->condition('status', '1')
      ->condition('field_minimum_game_session_time.target_id', $this->getTaxonomyId())
      ->execute();

    if ($nids) {
      $node = $this->nodeStorage->loadMultiple($nids);
      $firstItem = $node[array_rand($node, 1)];
      return new JsonResponse([
        'product_name' => $firstItem->label(),
        'url' => $firstItem->toUrl('canonical', ['absolute' => TRUE])->toString(),
      ]);
    }

    return new JsonResponse(new \stdClass());
  }

  /**
   * {@inheritdoc}
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

    $terms = $this->termStorage->loadByProperties([
      'name' => $taxonomy,
      'vid' => 'session_time',
    ]);

    return $terms ? (int) reset($terms)->id() : NULL;
  }

}
