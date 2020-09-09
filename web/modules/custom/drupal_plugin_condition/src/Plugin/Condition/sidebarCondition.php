<?php

namespace Drupal\drupal_plugin_condition\Plugin\Condition;

use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Condition\ConditionPluginBase;
use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'Sidebar Block Condition' condition.
 *
 * @Condition(
 *   id = "sidebar_condition",
 *   label = @Translation("Sidebar Block Condition"),
 *   context_definitions = {
 *     "node" = @ContextDefinition(
 *       "entity:node",
 *        label = @Translation("Node")
 *      )
 *   }
 * )
 *
 * @DCG prior to Drupal 8.7 the 'context_definitions' key was called 'context'.
 */
class sidebarCondition extends ConditionPluginBase implements ContainerFactoryPluginInterface {

  /**
   * The date formatter.
   *
   * @var \Drupal\Core\Datetime\DateFormatterInterface
   */
  protected $dateFormatter;

  /**
   * The time service.
   *
   * @var \Drupal\Component\Datetime\TimeInterface
   */
  protected $time;

  /**
   * Creates a new sidebarCondition instance.
   *
   * @param array $configuration
   *   The plugin configuration, i.e. an array with configuration values keyed
   *   by configuration option name. The special key 'context' may be used to
   *   initialize the defined contexts by setting it to an array of context
   *   values keyed by context names.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Datetime\DateFormatterInterface $date_formatter
   *   The date formatter.
   * @param \Drupal\Component\Datetime\TimeInterface $time
   *   The time service.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, DateFormatterInterface $date_formatter, TimeInterface $time) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->dateFormatter = $date_formatter;
    $this->time = $time;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('date.formatter'),
      $container->get('datetime.time')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return ['sidebarActive' => NULL] + parent::defaultConfiguration();
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {

    $form['sidebarActive'] = [
      '#title' => $this->t('When Sidebar Field Active'),
      '#type' => 'checkbox',
      '#default_value' => $this->configuration['sidebarActive'],
      '#description'   => $this->t('Enable this block when the sidebar field on the node is active.'),
    ];

    return parent::buildConfigurationForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    $this->configuration['sidebarActive'] = $form_state->getValue('sidebarActive');
    parent::submitConfigurationForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function summary() {
    $status = $this->getContextValue('sidebarActive') ? t('enabled') : t('disabled');

    return t(
      'The node has sidebar block @status.',
      ['@status' => $status]);
  }

  /**
   * {@inheritdoc}
   */
  public function evaluate() {
    if (!$this->configuration['sidebarActive'] && !$this->isNegated()) {
      return TRUE;
    }

    $node = $this->getContextValue('node');
    if ($node->hasField('field_enable_sidebar') && $node->field_enable_sidebar->value) {
      return TRUE;
    }

    return FALSE;
  }


}
