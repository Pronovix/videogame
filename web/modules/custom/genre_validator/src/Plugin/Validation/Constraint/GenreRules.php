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
  public string $noNumbers = 'Genres should not contain numbers';

  /**
   * Error message for special characters except dash.
   *
   * @var string
   */
  public string $noComma = 'Only one genre is allowed per line';

  /**
   * Error message for non capitalized first letters.
   *
   * @var string
   */
  public string $notCapitalized = '%genre should be capitalized';

  /**
   * Error message for dashes not being followed and preceded by letters.
   *
   * @var string
   */
  public string $dashBeforeAfter = 'Dashes should be preceded and followed by a letter';

  /**
   * Error message for using multiple spaces and/or dashes in succession.
   *
   * @var string
   */
  public string $oneDashOrSpace = 'There should be one space or dash between words';

}
