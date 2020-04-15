<?php

declare(strict_types = 1);

namespace Drupal\genre_validator\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * Checks that the submitted genre fits the set rules.
 *
 * @Constraint(
 *   id = "genre_rules",
 *   label = @Translation("Genre rules", context = "Validation"),
 *   type = "string"
 * )
 */
class GenreRules extends Constraint {

  /**
   * Error message for numbers in the string.
   *
   * @var string
   */
  public $noNumbers = 'No numbers allowed';

  /**
   * Error message for special characters except dash.
   *
   * @var string
   */
  public $noComma = 'No commas and special characters allowed.';

  /**
   * Error message for non capitalized first letters.
   *
   * @var string
   */
  public $notCapitalized = 'First letters of words should be capitalized.';

  /**
   * Error message for dashes and whitespaces not being followed and preceded by letters and/or being redundant.
   *
   * @var string
   */
  public $dashBeforeAfter = 'Whitespaces and dashes should not be redundant and they should be preceded and followed by letters.';

}
