<?php

namespace Drupal\ajax_example\Ajax;

use Drupal\Core\Ajax\CommandInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Class AjaxExampleForm.
 */
class AjaxExampleCommand implements CommandInterface {
  protected $user;

  /**
   * AjaxExampleCommand constructor.
   *
   * @param $user
   */
  public function __construct(AccountInterface $user) {
    $this->user = $user;
  }


  /**
   * Render custom ajax command.
   *
   * @return array
   *   Command function.
   */
  public function render() {
    return [
      'command' => 'AjaxExampleCommand',
      'message' => 'My Awesome Message',
      'data' => [
        'id' => $this->user->id(),
        'name' => $this->user->getAccountName(),
        'created_at' => $this->user->getLastAccessedTime()
      ],
    ];
  }

}
