<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 6/11/2020
 * Time: 3:16 PM
 */

namespace Drupal\Tests\drupal_cypress_twitter\FunctionalJavascript;
use Drupal\node\Entity\Node;
#use weitzman\DrupalTestTraits\Entity\UserCreationTrait;
use Drupal\Tests\user\Traits\UserCreationTrait;
use weitzman\DrupalTestTraits\ExistingSiteSelenium2DriverTestBase;
use weitzman\DrupalTestTraits\ScreenShotTrait;


class HomePageViewDisplayTest extends ExistingSiteSelenium2DriverTestBase {
  /**
   * Function to test if the view exists.
   */
  use ScreenShotTrait;
  use UserCreationTrait;


  /**
   * Directory to test with.
   *
   * Randomized to allow repeated test runs if debugging.
   *
   * @var string
   */
  protected $directoryName;

  /**
   * {@inheritdoc}
   */
  protected function setUp()
  {
    parent::setUp();

    $this->directoryName = '/tmp/' . mb_strtolower($this->randomMachineName());
  }

  /**
   * @covers ::captureScreenShot
   */


  public function testViewExists() {
    $session = $this->assertSession();
    $page = $this->getSession()->getPage();

    /** the user is authenticated */
    $user = $this->createUser([]);
    $this->drupalLogin($user);

    /** the user is viewing the profile edit mask */
    $this->drupalGet('/user');
    $page->findLink('Edit')->press();

    /** When the user enters "@pmelab" into the field labeled "Twitter" */
    $page->findField('edit-twitter-0-value')->setValue('@pmelab');

    /** And the user save the profile */
    $page->findButton('Save')->press();

    /** Then a success message is displayed */
    $this->getSession()->evaluateScript("jQuery('.messages.messages--status').parents('div').find('.messages.messages--status').text('The changes have been saved :))')");
    $page->waitFor(0.2, function (){
      $this->captureScreenshot();
    });

//    $session->elementExists('css', 'div.messages')->setValue('admin');
//    $session->elementExists('css', '[name="pass"]')->setValue('admin');
//    $session->elementExists('css', '[name="op"]')->click();


  }

}
