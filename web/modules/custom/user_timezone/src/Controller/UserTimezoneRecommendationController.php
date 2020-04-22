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
   * @var EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * @var \Drupal\Core\Config\Entity\QueryFactory
   */
  protected $queryFactory;

  /**
   * Constructs the UserTimezoneRecommendationController object.
   *
   * @param EntityTypeManagerInterface $entityTypeManager
   * @param QueryFactory $queryFactory
   */
  public function __construct(EntityTypeManagerInterface $entityTypeManager, QueryFactory $queryFactory) {
    $this->entityTypeManager = $entityTypeManager;
    $this->queryFactory = $queryFactory;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  public function index() {
   return new JsonResponse(
     ['data' =>  $this->getData(),
       'method' => 'GET',
       'status' => 200]
   );
  }

  public function getData() {
    $result = [];
    $query = $this->entityTypeManager->getStorage('node')->getQuery();
    $nids = $query
      ->condition('type', 'article')
      ->condition('status', TRUE)
      ->condition('field_tags.entity.name', 'session time')
      ->execute();

    if ($nids) {
      foreach ($nids as $node_id) {
        $node = \Drupal\node\Entity\Node::load($node_id);
        $result[] = [
          "id" => $node->id(),
          "title" => $node->getTitle(),
        ];
      }
    }

    return $result;
  }

}
