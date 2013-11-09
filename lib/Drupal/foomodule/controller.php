<?php
/**
 * We could have put our controller in a "Controller" folder using
 * Drupal\foomodule\Controller namespace instead of simplu Drupal\foomodule
 *
 * PSR-0 autoloader is used *inside* lib directory of each module, that's
 * why we need for now to create this verbose directory structure in our module,
 * or our class won't be autoloaded.
 */
namespace Drupal\foomodule;

// use drupal ControllerBase, it provides us some shortcuts methods to
// get our config, translate strings etc...
// This is a class we may extends to our own class to provides us
// usefull methods available in all our controllers for a specific project
use Drupal\Core\Controller\ControllerBase;

/**
 * Extends Drupal ControllerBase, this is not required, we can also
 * access config with \Drupal::config('foomodule.settings')
 */
class controller extends ControllerBase {

  function hello() {
    // config property is provided by ControllerBase class
    // Get our module settings
    $name = $this->config('foomodule.settings')->get('name');
    return "Hello $name";
  }

}

