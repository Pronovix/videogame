<?php

declare(strict_types = 1);

namespace Drupal\product_uploader;

/**
 * Class for the Product Uploder role.
 */
final class ProductUploader {
  /**
   * The fragment that the user's email address should contain.
   */
  public const PRODUCT_UPLOADER_FRAGMENT = '+productuploader';

  /**
   * The name of the role.
   */
  public const PRODUCT_UPLOADER_ROLE = 'product_uploader';

  /**
   * Empty private constructor for ProductUploader class.
   */
  private function __construct() {}

}
