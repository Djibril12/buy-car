<?php
namespace Drupal\intro\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class GreetingNumForm extends ConfigFormBase {


  public function getFormId() {
    return 'greeting_num_configuration_form';
  }

  // public function getFormId(){
  //   return ['greeting_num_form']; // suppr intro
  // }



   public function buildForm(array $form, FormStateInterface $form_state) {
     $config = $this->config('intro.custom_greeting');
     // champ number
     $form['greet_num'] = array(
       '#type' => 'number',
       '#title' => $this->t('Greeting Number'),
       '#description' => '',
       '#default_value' => $config->get('greet_num')
     );
     // champ checkbox
     // $form['greet_num_enabled'] = array(
     //   '#type' => 'checkbox',
     //   '#title' => 'Actif',
     //   '#description' => 'Enable Greeting Loop',
     //   '#default_value' => $config->get('greet_num_enabled')
     // );
     return parent::buildForm($form, $form_state);
   }
  //
  // public function buildForm(array $form, FormStateInterface $form_state){
  //   $form['greet_num'] = array(
  //     '#type' => 'number',
  //     '#title' => 'Nombre de souhait',
  //     '#description' => 'Veuillez saisir le nombre de souhait',
  //   );
  //   return parent::buildForm($form, $form_state);
  // }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('intro.custom_greeting')
      ->set('greet_num', $form_state->getValue('greet_num'))
      //->set('greet_num_enabled', $form_state->getValue('greet_num_enabled'))
      ->save();

     return parent::submitForm($form, $form_state);
  }

  // public function submitForm(array &$form, FormStateInterface $form_state){
  //   $this->config('intro.custom_greeting')
  //   ->set('num', $form_state->getValue('greet_num'))
  //   ->save();
  //
  //   return parent::submitForm($form, $form_state);
  // }


  public function getEditableConfigNames() {
    return ['intro.custom_greeting'];
  }

 //  public function getEditableConfigNames() {
 //   return ['intro.custom_greeting'];
 // }

}
