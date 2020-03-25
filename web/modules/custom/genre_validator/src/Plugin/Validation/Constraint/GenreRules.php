<?php

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

  // The message that will be shown if the genre submitted is not a string.
  public $noNumbers = 'Genres should not contain numbers';

  // The message that will be shown if there are more then one genres on a single line.
  public $noComma = 'Only one genre is allowed per line';

  // The message that will be shown if the genre submitted is not capitalized.
  public $notCapitalized = '%genre should be capitalized';

  // The message that will be shown if dashes are not preceded and/or followed by a letter.
  public $dashBeforeAfter = 'Dashes should be preceded and followed by a letter';

  // The message that will be shown if there are more then one spaces or dashes between words.
  public $oneDashOrSpace = 'There should be one space or dash between words';

}
