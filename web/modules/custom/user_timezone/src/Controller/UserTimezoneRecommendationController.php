<?php

declare(strict_types = 1);

namespace Drupal\user_timezone\Controller;

use Drupal\Core\Config\Entity\Query\QueryFactory;
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
   * The query factory.
   *
   * @var \Drupal\Core\Config\Entity\QueryFactory
   */
  protected $queryFactory;

  /**
   * Constructs the UserTimezoneRecommendationController object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   The entity type manager.
   * @param \Drupal\Core\Config\Entity\QueryFactory $queryFactory
   *   The query factory.
   */
  public function __construct(EntityTypeManagerInterface $entityTypeManager, QueryFactory $queryFactory) {
    $this->entityTypeManager = $entityTypeManager;
    $this->queryFactory = $queryFactory;
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
  public function index() {
    return new JsonResponse([
      'data' => $this->getData(),
      'method' => 'GET',
      'status' => 200,
    ]
    );
  }

  /**
   * A helper function returning results.
   *
   * @return array
   *   Returns the title and the url of the videogame product.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function getData(): array {
    $result = [];
    $query = $this->entityTypeManager->getStorage('node')->getQuery();
    $nids = $query
      ->condition('type', 'article')
      ->condition('status', TRUE)
      ->condition('field_tags.entity.name', 'session time')
      ->execute();

    if ($nids) {
      foreach ($nids as $node_id) {
        $node = $this->entityTypeManager->getStorage('node_id');
        $result[] = [
          'id' => $node->id(),
          'title' => $node->getTitle(),
        ];
      }
    }

    return $result;
  }

}
