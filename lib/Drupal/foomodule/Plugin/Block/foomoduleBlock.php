<?php
namespace Drupal\foomodule\Plugin\Block;

use Drupal\block\BlockBase;
use Drupal\block\Annotation\Block;
use Drupal\Core\Annotation\Translation;
use Drupal\Core\Session\AccountInterface;

/**
 * @Block(
 *   id = "foomoduleBLock",
 *   admin_label = @translation("foomoduleBLock")
 * )
 *
 * Note : Above annotations are REQUIRED for Drupal to discover
 * our new block. A block is actually a *type* of "plugin" and
 * block discovery is handled by plugin API.
 *
 * You have to clear cache or this file will not be discovered.
 *
 * Annotations are the default way to discovery plugins, theorically it
 * is possible to provides other ways to discover plugins
 * (for example, search for yml files rather than annotations)
 */
class foomoduleBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function access(AccountInterface $account) {
    // By default, the block is visible unless user-configured rules indicate
    // that it should be hidden.
    //
    // We hide block visibility if hostname is 666 or current_path is "hello"
    // I guess this method is called before block is fully build, so it's a nice way
    // to set complex block visibility in code.
    if (current_path() == "hello" || $account->hostname == '666') {
      return FALSE;
    }
    return TRUE;
  }


  /**
   * Implements \Drupal\block\BlockBase::build().
   */
  public function build() {
    // seems than a renderable array is REQUIRED here, a string
    // throw a php error...
    return array(
      '#markup' => "Hello" . \Drupal::config('foomodule.settings')->get('name')
    );
  }

}

