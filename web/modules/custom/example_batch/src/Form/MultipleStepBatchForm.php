<?php

namespace Drupal\example_batch\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class KickOffBatchForm.
 */
class MultipleStepBatchForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'kick_off_multiple_step_batch_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['number_to_execute'] = [
      '#type' => 'number',
      '#title' => $this->t('Number of times to run'),
      '#weight' => '0',
    ];

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
    $number = $form_state->getValue('number_to_execute');
    $batch = [
      'init_message' => t('Executing a batch...'),
      'operations' => [
        ['\Drupal\example_batch\Batch\AnotherBatchOperation::generateSomeStrings', [$number]],
        ['\Drupal\example_batch\Batch\AnotherBatchOperation::reverseThoseStrings', [$number]],
      ],
      'finished' => '\Drupal\example_batch\Batch\AnotherBatchOperation::finishUpMyBatch',
    ];

    batch_set($batch);
  }

}
