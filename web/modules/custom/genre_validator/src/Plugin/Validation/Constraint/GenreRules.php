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

  public string $noNumbers = 'Genres should not contain numbers';

  public string $noComma = 'Only one genre is allowed per line';

  public string $notCapitalized = '%genre should be capitalized';

  public string $dashBeforeAfter = 'Dashes should be preceded and followed by a letter';

  public string $oneDashOrSpace = 'There should be one space or dash between words';

}
