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
    $form['vitesse'] = array(
      '#type' => 'select',
      '#title' => $this->t('Boîte de vitesse'),
      '#options' => [
        '-1' => $this->t('Selectionnez la boîte de vitesse'),
        'auto' => $this->t('Automatique'),
        'manu' => $this->t('Manuelle'),
      ],
      '#default_value' => '-1',
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
                      ->load($form_state->getValue('image')[0]);
  

    $db = \Drupal::service('database');
    $transaction = $db->startTransaction();

    try {

      // contruction des données de l'image
      $imageData = array(
        'name' => $file->get('filename')->value,
        'alt' => $file->get('filename')->value,
        'uuid' => $file->get('uuid')->value
      );

      // insertion d'une image et recuperation de l'ID de l'image
      $idfile = $this->insertImage($db , $imageData);

      // construction d'une voiture
      $carData = array(
        'marque' => $form_state->getValue('marque'),
        'price' => (float) $form_state->getValue('prix'),
        'energie' => $form_state->getValue('energie'),
        'vitesse' => $form_state->getValue('vitesse'),
        'id_image' => $idfile,
      );

      $this->insertCar($db, $carData);

    }
    catch (Exception $e) {

      $transaction->rollBack();
      //watchdog_exception('my_type', $e);
      \Drupal::logger('php')->error($e->getMessage());
    }

    return parent::submitForm($form, $form_state);
  }

  private function insertImage($db , array $data){
  return $db
          ->insert('auto_image')
          ->fields($data)
          ->execute();
  }

  private function insertCar($db , array $data){
    $db
      ->insert('auto_vehicule')
      ->fields($data)
      ->execute();
  }
}
