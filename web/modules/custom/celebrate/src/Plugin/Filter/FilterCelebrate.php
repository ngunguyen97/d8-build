<?php

namespace Drupal\celebrate\Plugin\Filter;

use Drupal\Core\Form\FormStateInterface;
use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;

/**
 * Provides a 'Celebrate Filter' filter.
 *
 * @Filter(
 *   id = "filter_celebrate",
 *   title = @Translation("Celebrate Filter"),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_MARKUP_LANGUAGE,
 *   settings = {
 *     "celebrate_invitation" = 1,
 *   },
 *   weight = -10
 * )
 */
class FilterCelebrate extends FilterBase {

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $form['celebrate_invitation'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Show Invitation?'),
      '#default_value' => $this->settings['celebrate_invitation'],
      '#description' => $this->t('Display s short invitation the default text.'),
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function process($text, $langcode) {
    // @DCG Process text here.
    $invitation = $this->settings['celebrate_invitation'] ? 'Come on!' : '';
    $replace = '<span>' .$this->t('Good Times!'. $invitation) . '</span>';
    #$example = $this->settings['example'];
    $text = str_replace('[celebrate]', $replace, $text);
    return new FilterProcessResult($text);
  }

  /**
   * {@inheritdoc}
   */
  public function tips($long = FALSE) {
    return $this->t('Some filter tips here.');
  }

}
