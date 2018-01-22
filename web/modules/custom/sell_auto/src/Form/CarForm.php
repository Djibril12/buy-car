<?php
namespace Drupal\sell_auto\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class CarForm extends ConfigFormBase {

  public function getEditableConfigNames() {

  }

  public function getFormId() {
    return 'sell_auto_car_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = array(
      '#attributes' => array('enctype' => 'multipart/form-data'),
    );

    $form['marque'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Marque du véhicule'),
      '#description' => '',
      '#default_value' => 'BMW'
    );
    $form['prix'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Prix du véhicule'),
      '#description' => '',
      '#default_value' => 250000
    );
    $form['energie'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Type d\'énergie du véhicule'),
      '#description' => '',
      '#default_value' => 'Essence'
    );


    $form['image'] = array(
    '#type' => 'managed_file',
    '#upload_location' => 'public://images/',
    '#multiple' => TRUE,
    '#upload_validators' => array(
      'file_validate_extensions' => array('png gif jpg jpeg JPG'),
      'file_validate_size' => array(25600000),
      //'file_validate_image_resolution' => array('800x600', '400x300'),
    ),
  );

    return parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {

    $file = \Drupal::entityTypeManager()->getStorage('file')
                    ->load($form_state->getValue('image')[0]); // Just FYI. The file id will be stored as an array
     // And you can access every field you need via standard method
    //dpm($file->get('filename')->value);
    //dpm($file);
    //dpm($form_state['values']);

    // $word = $form_state->getValue('banned_word');
    // // La Config n'est pas adaptée à notre situation
    // // Il faudrait calculer des indices de clés
    // // Ce n'est pas le but du service config.factory
    // // $this->config('proverb.banned_word')
    // //   ->set('word', $word)
    // //   ->save();
    // // Plus approprié : utilisation du service database
    // // Insertion dans la table personnalisée banned_word
    $db = \Drupal::service('database');
    $fields = array(
        'name' => $file->get('filename')->value,
        'alt' => $file->get('filename')->value,
        'uuid' => $file->get('uuid')->value
      );

    //dpm($fields);
    // // Utilisation de la méthode insert du query builder
    $db
      ->insert('auto_image')
      ->fields($fields)
      ->execute();
    return parent::submitForm($form, $form_state);
  }
}
