<?php

namespace Drupal\sell_auto\Service;

use Symfony\Component\HttpFoundation\Session\Session;

class PanierService {

  private $session;
  private $panier;

  public function __construct(Session $session)
  {
      $this->session = $session;

      // initialisation de la session
      if(!$this->session->has('panier')) {

          $this->session->set('panier', []);
      }
      else
      {
          $this->panier = $this->session->get('panier');
      }

  }

  public function listProducts()
  {
      return $this->panier;
  }

  private function getProduitByIndex($id)
  {
      $idProduit = -1;
      if(!empty($this->panier)) {
          foreach ($this->panier as $key => $article) {
              if (in_array($id, $article)) {
                  $idProduit = $key;
                  break;
              }
          }
      }
      return $idProduit;

  }

  public function addProductInCart($produit)
  {
      $commande = [];
      // recherche id du produit dans le panier
      $idProduit = $this->getProduitByIndex($produit->id);

      if($idProduit === -1)
      {
          $commande['id'] = $produit->id;
          $commande['qte'] = 1;
          $commande['prix'] = $produit->price;
          $this->panier[] = $commande;

      }
      else
      {
          $this->panier[$idProduit]['qte'] +=  1;
      }

      $this->session->set('panier', $this->panier);

  }

  public function  deleteProductFromCart($produit)
  {

      $articleASupp = $this->getProductByIndex($produit->getId());
      array_splice($this->panier, $articleASupp, 1);
      $this->session->set('panier', $this->panier);

  }


  public function countProductInCart()
  {
      $totalPanier = 0;
      if(!empty($this->session->get('panier')))
      {
          foreach ($this->session->get('panier') as $article)
          {
              $totalPanier += $article['qte'];
          }
      }

      return $totalPanier;

  }


}
