<?php

namespace Drupal\sell_auto\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;




class DefaultController extends ControllerBase {

  public function index(){

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
        'marque' => $result->marque,
        'energie' => $result->energie,
        'alt' => $result->alt,
        'url' => file_create_url('public://images/'. $result->name),
      ];
    }

    return [
      '#theme' => 'catalogue',
      '#vehicules' => $images,
    ];
  }

  public function cart(){

    // affichage du template
   return [
        '#theme' => 'cart',
        '#panier' => $panier,
      ];
  }

  public function addCarInCart(Request $request){
    $car_id = (int) $request->get('id');

    $panier = \Drupal::service('sell_auto.panier');
    $db = \Drupal::service('database');
    // construction de la requete preparee
    $q = "SELECT *  FROM auto_vehicule as ve WHERE ve.id = :id";

    $result = $db->query($q, [':id' => $car_id])
                  ->fetch();

    // ajout du produit dans le panier
    $panier->addProductInCart($result);


    // construction des données à renvoyer
    $product = array(
      'name' => $result->marque,
      'qty' => $panier->countProductInCart()
    );


     $dataJson = json_encode($product);
    //
     return new Response($dataJson);

    //return new Response($panier);
    // return [
    //   '#markup' => 'en construction',
    // ];

  }

  public function viewCar(Request $request){

    // recuperation de l' ID
    $car_id = (int) $request->get('id');

    $db = \Drupal::service('database');
    // construction de la requete preparee
    $q = "SELECT *  FROM auto_vehicule as ve, auto_image as im WHERE ve.id = :id";

    $result = $db->query($q, [':id' => $car_id])
                  ->fetch();

    // contruction des donnees du vehicule
    $dataVehicule = array(
      'id' => $result->id,
      'src_image' => file_create_url('public://images/'. $result->name),
      'marque' => $result->marque,
      'price' => $result->price,
      'energie' => $result->energie,
    );

    $panier = \Drupal::service('sell_auto.panier');

    //$request->getSession()->clear();

    // return [
    //   '#markup' => 'En construction',
    // ];

    // affichage du template
   return [
        '#theme' => 'viewcar',
        '#vehicule' => $dataVehicule,
      ];
  }

}
