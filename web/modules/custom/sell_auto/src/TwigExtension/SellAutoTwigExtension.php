<?php

namespace Drupal\sell_auto\TwigExtension;

use Drupal\sell_auto\Service\PanierServices;
use Drupal\Core\Render\Renderer;
use Symfony\Component\HttpFoundation\Session\Session;



/**
 * Class SellAutoTwigExtension.
 */
class SellAutoTwigExtension extends \Twig_Extension {

  private $session;
  private $renderer;

  public function __construct(Renderer $renderer, Session $session){
    $this->renderer = $renderer;
    $this->session = $session;
  }

  public function getNumberOfCarInCart(){
    $sumArticle = 0;
    foreach ($this->session->get('panier') as $article) {
      $sumArticle += $article['qte'];
    }
    //dpm($this->session->get('panier'));
    dpm($sumArticle);
    return $sumArticle;
  }

  /**
  * {@inheritdoc}
  */
  public function getFunctions() {
    return array(
      new \Twig_SimpleFunction('get_number_of_car_in_cart', array($this, 'getNumberOfCarInCart')),
    );

    // return array(
    // new \Twig_SimpleFunction('display_block',
    //   array($this, 'display_block'),
    //   array('is_safe' => array('html')
    // )),
  }
   /**
    * {@inheritdoc}
    */
    public function getTokenParsers() {
      return [];
    }

   /**
    * {@inheritdoc}
    */
    public function getNodeVisitors() {
      return [];
    }

   /**
    * {@inheritdoc}
    */
    public function getFilters() {
      return [];
    }

   /**
    * {@inheritdoc}
    */
    public function getTests() {
      return [];
    }


   /**
    * {@inheritdoc}
    */
    public function getOperators() {
      return [];
    }

   /**
    * {@inheritdoc}
    */
    public function getName() {
      return 'sell_auto.twig.extension';
    }

}
