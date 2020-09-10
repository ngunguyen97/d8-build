<?php

namespace Drupal\drupal_plugin_condition\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * Provides a Drupal plugin condition constraint.
 *
 * @Constraint(
 *   id = "UniqueInteger",
 *   label = @Translation("Drupal plugin condition", context = "Validation"),
 * )
 *
 * @DCG
 * To apply this constraint on third party field types. Implement
 * hook_field_info_alter().
 */
class UniqueInteger extends Constraint {

  // The message that will be shown if the value is not an integer.
  public $notInteger = '%value is not an integer';

  // The message that will be shown if the value is not unique.
  public $notUnique = '%value is not unique';

}
