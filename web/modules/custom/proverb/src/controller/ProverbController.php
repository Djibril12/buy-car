<?php

namespace Drupal\proverb\Controller;

use Drupal\Core\Controller\ControllerBase;
/**
 * GreetingController
 */
class ProverbController extends ControllerBase {


  public function list(){
  //
  // $num = intval($this->config('intro.custom_greeting')
  //             ->get('greet_num'));
  //
  // $wish = 'Good year';
  // $output = '<ul>' ;
  //
  // dpm($num);
  // for ($i=0; $i < $num; $i++) {
  //   $output .= '<li>' . $wish .'</li>';
  // }
  // $output .= '</ul>';

    return [
      '#markup' => "En construction
      ",
    ];
  }

}
