<?php

namespace Drupal\sell_auto\Controller;

use Drupal\Core\Controller\ControllerBase;


class DefaultController extends ControllerBase {

  public function index(){

    $panier = \Drupal::service('sell_auto.panier');
    dpm('test');
    dpm($panier->listProducts());

    



    return [
      '#markup' => "En construction",
    ];
  }

}
