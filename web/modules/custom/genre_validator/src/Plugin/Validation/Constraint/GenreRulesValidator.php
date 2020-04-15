<?php

declare(strict_types = 1);

namespace Drupal\genre_validator\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validates the genre_rules Constraint.
 */
class GenreRulesValidator extends ConstraintValidator {

  /**
   * {@inheritdoc}
   */
  public function validate($genres, Constraint $constraint) {

    foreach ($genres as $genre) {
      /** @var \Drupal\Core\Field\Plugin\Field\FieldType\StringItem $genre */

      if (preg_match('/[\d]/', $genre->value)) {
        $this->context->addViolation($constraint->noNumbers, ['%value' => $genre->value]);
      }

      if (preg_match('/[^-\s\w]/', $genre->value)) {
        $this->context->addViolation($constraint->noComma, ['%value' => $genre->value]);
      }

      if (preg_match('/(\b(?! |-)\b)+[a-z]/', $genre->value)) {
        $this->context->addViolation($constraint->notCapitalized, ['%value' => $genre->value]);
      }

      if (preg_match('/.*(?= |-)+(?<= |-).*/', $genre->value)) {
        $this->context->addViolation($constraint->dashBeforeAfter, ['%value' => $genre->value]);
      }

    }

  }

}
