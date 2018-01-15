<?php
namespace Drupal\proverb\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class UploadListProverbForm extends ConfigFormBase {


  public function getFormId() {
    return ['upload_list_proverb_form'];
  }
   public function buildForm(array $form, FormStateInterface $form_state) {

     $form['my_file'] = array(
      '#type' => 'file',
      '#title' => t('Upload Proverb'),
      '#description' => t('Upload the scanned document. Allowed only extension: txt')
    );
     return parent::buildForm($form, $form_state);
   }

  public function submitForm(array &$form, FormStateInterface $form_state) {

    $file = \Drupal::entityTypeManager()->getStorage('file')
                     ->load($form_state->getValue('my_file')[0]); // Just FYI. The file id will be stored as an array
      // And you can access every field you need via standard method
      dpm($file->get('filename')->value);


  }

  public function getEditableConfigNames() {

  }

}
