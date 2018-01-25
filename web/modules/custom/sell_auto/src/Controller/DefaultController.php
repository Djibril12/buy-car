<?php

namespace Drupal\sell_auto\Controller;

use Drupal\Core\Controller\ControllerBase;


class DefaultController extends ControllerBase {

  public function index(){

    $panier = \Drupal::service('sell_auto.panier');
    //dpm('test');
    //dpm($panier->listProducts());

    $db = \Drupal::service('database');
    $q = "SELECT *
          FROM auto_vehicule as ve
          INNER JOIN auto_image as im
          WHERE ve.id_image = im.id ";
    $results = $db->query($q)->fetchAll();
    
    $images = [];

    foreach ($results as $result) {
      $images[] = [
        'id' => $result->id,
        'name' => $result->name,
        'alt' => $result->alt,
        'url' => file_create_url('public://images/'. $result->name),
      ];
    }

    return [
      '#theme' => 'catalogue',
      '#vehicules' => $images,
    ];
  }



  public function viewCar(){

    return [
      '#theme' => 'viw_car3',
      '#vehicules' => $vehicules,
    ];

  }

}
