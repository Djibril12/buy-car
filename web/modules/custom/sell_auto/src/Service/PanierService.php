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

      //dump($this->panier);

  }

  public function listProducts()
  {
      return $this->panier;
  }

  public function addProductInCart($produit)
  {
      $commande = [];
      $articleASupp = $this->getProductByIndex($produit->getId());
      //dump($articleASupp); exit();
      if($articleASupp === -1)
      {
          $commande['id'] = $produit->getId();
          $commande['qte'] = 1;
          $commande['prix'] = $produit->getPrix();
          $this->panier[] = $commande;

      }
      else
      {
          $this->panier[$articleASupp]['qte'] +=  1;
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


  private function getProduitByIndex($id)
  {
      $articleASupp = -1;
      if(!empty($this->panier)) {
          foreach ($this->panier as $key => $article) {
              if (in_array($id, $article)) {
                  $articleASupp = $key;
                  break;
              }
          }
      }
      return $articleASupp;

  }

}
