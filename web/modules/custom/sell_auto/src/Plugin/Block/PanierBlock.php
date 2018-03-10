<?php

namespace Drupal\sell_auto\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'PanierBlock' block.
 *
 * @Block(
 *  id = "panier_block",
 *  admin_label = @Translation("Panier block"),
 * )
 */
class PanierBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    // $build = [];
    // $build['panier_block']['#markup'] = 'Implement PanierBlock.';
    //
    // return $build;
    $nb = 0;

    return [
     '#theme' => 'preheader',
     '#nb' => $nb
   ];
  }

}
