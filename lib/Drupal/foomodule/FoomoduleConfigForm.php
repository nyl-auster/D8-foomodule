<?php
/**
 * @file
 * Contains \Drupal\hello\Form\HelloConfigForm.
 *
 * Config form to display text on /hello page.
 *
 * We use this form to update our Drupal config (config.factory service).
 * This means that our configuration is fully handled by CMI, the brand new
 * configuration management system of Drupal 8, and that makes automatically
 * our configuration fully exportable, as with features in D6 or D7. Yey !
 *
 * See config_xxxxxxxx in your site default/files to see your active configuration
 * files on the site (in "active" subfolder).
 *
 * going to admin/config/development/configuration, you can see configuration
 * changes you've made; export your current active configuration or
 * import a new configuration. Always do a sql backup before import a new
 * configuration to your site, as it may have unexpected results...
 */

// we could have put this in subfolder "Form" with
// Drupal\Foomodule\Form namespace if we wanted to.
namespace Drupal\foomodule;

// configFactory is the heart of drupal configuration management in D8
use Drupal\Core\Config\ConfigFactory;
// no fucking idea what it is...
use Drupal\Core\Config\Context\ContextInterface;
// helper class to create config forms. Does not do much things for now...
use Drupal\Core\Form\ConfigFormBase;
// to be dependency injector friendly, not required
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Configure text display settings for this the hello world page.
 */
class FoomoduleConfigForm extends ConfigFormBase {

  /**
   * Dependency injection stuff....
   *
   * Constructs a \Drupal\foomodule\foomoduleConfigForm object.
   *       
   * @param \Drupal\Core\Config\ConfigFactory $config_factory
   *   The factory for configuration objects.
   *  @param \Drupal\Core\Config\Context\ContextInterface $context
   *    The configuration context to use.
   */
  public function __construct(ConfigFactory $config_factory) {
    parent::__construct($config_factory);
  }

  /**
   * Dependency injection stuff too...
   *
   * {@inheritdoc}
   *
   * __construct() and create() method are here only for dependency injector.
   * So this is not required to create a config form in D8.
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory')
    );
  }

  /**
   * {@inheritdoc}
   *
   * Required.
   */
  public function getFormID() {
    return 'foomodule.config_form';
  }

  /**
   * {@inheritdoc}
   *
   * We build the meat of our form using form API here.
   */
  public function buildForm(array $form, array &$form_state) {
    $config = $this->configFactory->get('foomodule.settings');
    $name = $config->get('name');
    $form['name'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Configure Hello World Text'),
      '#default_value' => $name,
      '#description' => $this->t('Choose the name displayed by "Hello, world!" message on /hello page.'),
    );
    // this call parent add defaults submit buttons and system_config_form as theme to display
    // the form.
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   *
   * Save our new values in config factory
   */
  public function submitForm(array &$form, array &$form_state) {
    $this->configFactory->get('foomodule.settings')
      ->set('name', $form_state['values']['name'])
      ->save();
    // call to parent only to display a drupal_set_message automatically (WTF ?)
    parent::submitForm($form, $form_state);
  }

} 

