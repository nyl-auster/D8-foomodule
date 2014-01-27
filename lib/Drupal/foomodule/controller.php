<?php
/**
 * We could have put our controller in a "Controller" folder using
 * Drupal\foomodule\Controller namespace instead of simply Drupal\foomodule
 *
 * PSR-0 autoloader is used *inside* lib directory of each module, that's
 * why we need for now to create this verbose directory structure in our module,
 * or our class won't be autoloaded.
 *
 * If PSR-4 is implemented finally in D8, this ugly nested directory structure won't be
 * required anymore, even if "lib" directory will still be required.
 */
namespace Drupal\foomodule;

// use drupal ControllerBase, it provides us some shortcuts methods to
// get our config, translate strings etc... without verbose calls to Depencency Injector Container.
// (Dependency injector Container is handled by a symfony component)
//
// This is a class we may extends with our own custom abstract class to provides us
// usefull re-usable methods available in all our controllers for a specific project. So
// create our own abstract customControllerBase extending ControllerBase sounds like
// a reasonnable idea.
//
// Note that using this controllerBase class make our controller more difficult to test with phpUnit,
// as ControllerBase make direct calls to Container class (so no automatic
// dependency injection is actually done anywhere, and we depends on the dependency injector,
// which is kind of stupid pattern...)
//
// If you *do* want to make your controller class testable, i suppose you have to
// declare it as a service in a mymodule.services.yml file
// (but that does not make much sense, as a controller is not some re-usable stuff) 
// or use containterInjectionInterface (with create() method) to get
// needed services injected automatically from the container. See book module Controller for an example of
// that particular implementation of injection dependency pattern.
//
// Usually, controller should only contain very minimal code : calling a service
// (e.g : \Drupal::getContainer()->get('language_manager) ) and return a string
// or a renderable array at the end of the method (or a http code error with
// a response symfony object i guess, there must be some drupal shortcut method
// somewhere for that )
use Drupal\Core\Controller\ControllerBase;

/**
 * Extends Drupal ControllerBase, this is not required, we can also
 * access config with \Drupal::config('foomodule.settings') if we want. It a simple
 * case like that, it would be enough to do the job.
 */
class controller extends ControllerBase {

  function hello() {
    // Get our module settings
    // config property is provided by ControllerBase class
    // this is actually a call to config.factory service, (@see drupal/core/core.services.yml)
    $name = $this->config('foomodule.settings')->get('name');
    $out = "<h2> Hello $name </h2>";
    $out .= '<p>';
    $out .= "This is an hello world test page from foomodule : ";
    $out .= "Change the name displayed visiting " . $this->l('This page', "foomodule.settings.form");
    $out .= '<p>';
    $out .= '<p>';
    return $out;
  }

}

