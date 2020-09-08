<?php

namespace Drupal\drupal_cypress_twitter\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'Country Link' formatter.
 *
 * @FieldFormatter(
 *   id = "country_link",
 *   label = @Translation("Country Link"),
 *   field_types = {
 *     "country"
 *   }
 * )
 */
class CountryLinkFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];
    $countries = \Drupal::service('country_manager')->getList();

    foreach ($items as $delta => $item) {
      if(isset($countries[$item->value])) {
        $element[$delta] = [
          '#theme' => 'country_link_formatter',
          '#name' => $countries[$item->value],
        ];
      }

    }

    return $element;
  }

}
