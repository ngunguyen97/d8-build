<?php

namespace Drupal\drupal_plugin_condition\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validates the Drupal plugin condition constraint.
 */
class UniqueIntegerValidator extends ConstraintValidator {

  /**
   * {@inheritdoc}
   */
  public function validate($items, Constraint $constraint) {

    foreach ($items as $item) {
      if(!is_numeric($item->value)) {
        $this->context->addViolation($constraint->notInteger, ['%value' => $item->value]);
      }
    }
  }

}
