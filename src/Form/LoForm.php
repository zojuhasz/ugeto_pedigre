<?php

namespace Drupal\pedigre\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\node\Entity\Node;
use Drupal\node\Entity;
use Symfony\Component\HttpFoundation\RedirectResponse; 
use Drupal\Core\Ajax\RedirectCommand;
/**
 * Our simple form class.
 */
class LoForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'lo_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
 
// kint($node);
 
   
    $form['massage'] = [
      '#type' => 'markup',
      '#markup' => '<div class="result_message"></div>',
    ];

        
    $form['name'] = array(
    '#type' => 'textfield',
    '#autocomplete_route_name' => 'jz_module.autocomplete',
    '#autocomplete_route_parameters' => array('field_name' => 'name', 'count' => 10),
     );
     
    $form['actions'] = [
      '#type' => 'button',
      '#value' => $this->t('keresés'),
      '#ajax' => [
        'callback' => '::setMessage',
      ]
    ];
    
    //kint($form);
    return $form;
  }

  public function pedigre_buildForm_alter(array &$form, FormStateInterface $form_state, $form_id) {
    echo "alter the form"; exit;
  if ($form['title'] == 'lokereses') {
    //if ($form['#id'] == "YOUR_FORM-ID") {
      $form['combine']['#autocomplete_route_name'] = 'jz_module.autocomplete';
      //$form['#attached']['library'][] = 'custom/custom';
      $form_state->setCached(FALSE);
    //}
  }
  }
  
  
  public function setMessage(array &$form, FormStateInterface $form_state) {
    $response = new AjaxResponse();
    
    $command = new RedirectCommand('/pedigre-loker/'.$form_state->getValue('name'));

    return $response->addCommand($command);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    
  }  
  
  
  
}
