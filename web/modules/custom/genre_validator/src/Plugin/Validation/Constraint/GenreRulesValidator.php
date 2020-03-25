<?php

declare(strict_types = 1);

namespace Drupal\genre_validator\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validates the genre_rules Constraint.
 *
 */
class GenreRulesValidator extends ConstraintValidator {

  /**
   * {@inheritdoc}
   */
  public function validate($genres, Constraint $constraint) {

    foreach ($genres as $genre) {
      // Check if the string has any numbers
      if (preg_match('/[d]/', $genre)) {
        $this->context->addViolation($constraint->noNumbers, ['%value' => $genre->value]);
      }
      // Check if the string has any special characters
      if (preg_match('/[\W]+[^-]/', $genre)) {
        $this->context->addViolation($constraint->noComma, ['%value' => $genre->value]);
      }
      // Check if the first letter is capitalized
      if (preg_match('/^[A-Z]/', $genre)) {
        $this->context->addViolation($constraint->notCapitalized, ['%value' => $genre->value]);
      }
      // Check if every dash has a letter before and after it
      if (preg_match('/^[A-Za]+(?:-[A-Za]+)?$/D', $genre)) {
        $this->context->addViolation($constraint->dashBeforeAfter, ['%value' => $genre->value]);
      }
      //Check if there are more then one consecutive spaces or dashes anywhere
      if (preg_match('/^(\w+([\s-]\w+)?)+$/', $genre)) {
        $this->context->addViolation($constraint->oneDashOrSpace, ['%value' => $genre->value]);

      }
    }

  }

}
