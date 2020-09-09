/**
 * @file
 * Smiley Ckeditor Button CKEditor plugin.
 *
 * Basic plugin inserting abbreviation elements into the CKEditor editing area.
 *
 * @DCG The code is based on an example from CKEditor Plugin SDK tutorial.
 *
 * @see http://docs.ckeditor.com/#!/guide/plugin_sdk_sample_1
 */

(function (Drupal) {

  'use strict';

  CKEDITOR.plugins.add('smiley', {

    // Register the icons.
    icons: 'smiley',

    // The plugin initialization logic goes inside this method.
    init: function (editor) {

      // Define an editor command that opens our dialog window.
      editor.addCommand('smiley', new CKEDITOR.dialogCommand('smileyDialog'));

      // Create a toolbar button that executes the above command.
      editor.ui.addButton('smiley', {

        // The text part of the button (if available) and the tooltip.
        label: Drupal.t('Insert abbreviation'),

        // The command to execute on click.
        command: 'smiley',

        // The button placement in the toolbar (toolbar group name).
        toolbar: 'insert'
      });

      // Register our dialog file, this.path is the plugin folder path.
      CKEDITOR.dialog.add('smileyDialog', this.path + 'dialogs/smiley.js');
    }
  });

} (Drupal));
