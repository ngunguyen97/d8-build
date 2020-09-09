<?php

namespace Drupal\ckeditor_smiley\Plugin\CKEditorPlugin;

use Drupal\ckeditor\CKEditorPluginBase;
use Drupal\editor\Entity\Editor;

/**
 * Defines the "Smiley CKeditor Button" plugin.
 *
 * @CKEditorPlugin(
 *   id = "smiley",
 *   label = @Translation("Smiley Ckeditor Button"),
 *   module = "ckeditor_smiley"
 * )
 */
class SmileyCKEditorButton extends CKEditorPluginBase {

  /**
   * {@inheritdoc}
   */
  public function getFile() {

    return 'libraries/smiley/plugin.js';
  }

  /**
   * {@inheritdoc}
   */
  public function getConfig(Editor $editor) {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function getButtons() {
    return [
      'Smiley' => [
        'label' => $this->t('Smiley CKeditor Button'),
        'image' => 'libraries/smiley/icons/smiley.png',
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  function isInternal() {
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  function getDependencies(Editor $editor) {
    return array();
  }

  /**
   * {@inheritdoc}
   */
  function getLibraries(Editor $editor) {
    return array();
  }


}
