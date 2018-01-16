<?php
namespace Drupal\proverb\Form;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;
class ImportVehiculesWithTextareaForm extends ConfigFormBase {
  public function getEditableConfigNames() {}
  public function getFormId() {
    return 'sell_auto.import_vehicule_form';
  }
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['ta'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Import'),
      '#description' => 'Coller vos proverbes ici',
      '#default_value' => ''
    );
    return parent::buildForm($form, $form_state);
  }
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $value = $form_state->getValue('ta');
    // conversion de la chaîne de caractères en tableau de proverbes
    $vehicules = explode(PHP_EOL, $value); // EOL = End Of Line
    foreach($vehicules as $vehicule) {
      // Enregistrer un node de type proverb dans le système
      $node = Node::create([
        'type' => 'vehicule',
        'title' => $vehicule
      ]);
      $node->save();
    }
    return parent::submitForm($form, $form_state);
  }
}
