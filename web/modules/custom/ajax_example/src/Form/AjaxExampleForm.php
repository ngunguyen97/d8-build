<?php

namespace Drupal\ajax_example\Form;

use Drupal\ajax_example\Ajax\AjaxExampleCommand;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class DefaultForm.
 */
class AjaxExampleForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ajax_example_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['username'] = [
      '#type' => 'textfield',
      '#title' => $this->t('UserName'),
      '#description' => $this->t('Please enter in a username'),
      '#maxlength' => 64,
      '#size' => 64,
      '#ajax' => [
        'callback' => '::usernameValidateCallback',
        'effect' => 'fade',
        'event' => 'change',
        'progress' => [
          'type' => 'throbber',
          'message' => 'Please wait....',
        ]
      ]
    ];
    $form['random_username'] = [
      '#type' => 'button',
      '#value' => 'Random Username',
      '#title' => $this->t('Random Username'),
      '#ajax' => [
        'callback' => '::randomUsernameCallback',
        'event' => 'click',
        'progress' => [
          'type' => 'throbber',
          'message' => 'Getting Random Username'
        ]
      ]
    ];
    $form['#attached']['library'][] = 'ajax_example/ajax_example-library';
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    foreach ($form_state->getValues() as $key => $value) {
      // @TODO: Validate fields.
    }
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Display result.
//    foreach ($form_state->getValues() as $key => $value) {
//      \Drupal::messenger()->addMessage($key . ': ' . ($key === 'text_format'?$value['value']:$value));
//    }
    \Drupal::messenger()->addMessage('Nothing Submitted. Just an Example.', 'status');
  }

  public function usernameValidateCallback(array &$form, FormStateInterface $form_state) {
    // Instantiate an AjaxResponse Object to return.
    $ajax_response = new AjaxResponse();


    // Check if Username exists and is not Anonymous User ('').
    if (user_load_by_name($form_state->getValue('username')) && $form_state->getValue('username') != false) {
      $text = 'User Found';
      $color = 'green';
    } else {
      $text = 'No User Found';
      $color = 'red';
    }

    // Add a command to execute on form, jQuery .html() replaces content between tags.
    // In this case, we replace the description with whether the username was found or not.
    $ajax_response->addCommand(new HtmlCommand('#edit-username--description', $text));

    // CssCommand did not work.
    //$ajax_response->addCommand(new CssCommand('#edit-user-name--description', array('color', $color)));

    // Add a command, InvokeCommand, which allows for custom jQuery commands.
    // In this case, we alter the color of the description.
    $ajax_response->addCommand(new InvokeCommand('#edit-username--description', 'css', array('color', $color)));

    // Return the AjaxResponse Object.
    return $ajax_response;
  }

  public  function randomUsernameCallback(array &$form, FormStateInterface $form_state) {
    $response = new AjaxResponse();
    $user = user_load_by_name('admin');

    $response->addCommand(new AjaxExampleCommand($user));
    return $response;
  }

}
