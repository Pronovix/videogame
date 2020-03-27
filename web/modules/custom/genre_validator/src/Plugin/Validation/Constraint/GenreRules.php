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
  public $noNumbers = 'Invalid genre entry. Example formats: Role Playing, Co-Op, Rpg or Turn-Based Combat';

  /**
   * Error message for special characters except dash.
   *
   * @var string
   */
  public $noComma = 'Invalid genre entry. Example formats: Role Playing, Co-Op, Rpg or Turn-Based Combat';

  /**
   * Error message for non capitalized first letters.
   *
   * @var string
   */
  public $notCapitalized = 'Invalid genre entry. Example formats: Role Playing, Co-Op, Rpg or Turn-Based Combat';

  /**
   * Error message for dashes not being followed and preceded by letters.
   *
   * @var string
   */
  public $dashBeforeAfter = 'Invalid genre entry. Example formats: Role Playing, Co-Op, Rpg or Turn-Based Combat';

  /**
   * Error message for using multiple spaces and/or dashes in succession.
   *
   * @var string
   */
  public $oneDashOrSpace = 'Invalid genre entry. Example formats: Role Playing, Co-Op, Rpg or Turn-Based Combat';

}
