/**
* @file
*/

(function ($, Drupal) {
Drupal.AjaxCommands.prototype.AjaxExampleCommand = function (ajax, response, status) {
  console.log(response.message);
  console.log(response);
}

})(jQuery, Drupal);
