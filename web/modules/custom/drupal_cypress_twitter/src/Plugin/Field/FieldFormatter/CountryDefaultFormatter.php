<?php

namespace Drupal\drupal_cypress_twitter\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'Country' formatter.
 *
 * @FieldFormatter(
 *   id = "country_default",
 *   label = @Translation("Country"),
 *   field_types = {
 *     "country"
 *   }
 * )
 */
class CountryDefaultFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];
    $countries = \Drupal::service('country_manager')->getList();

    foreach ($items as $delta => $item) {
      if(isset($countries[$item->value])) {
        $element[$delta] = [
          'type' => 'markup',
          '#markup' => '<h1>' . $countries[$item->value] .'</h1>',
        ];
      }

    }

    return $element;
  }

}
