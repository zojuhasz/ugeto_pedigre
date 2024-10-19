<?php

namespace Drupal\pedigre\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
/**
 * Defines a route controller for entity autocomplete form elements.
 */
class AutocompleteController extends ControllerBase {

  public function autocomplete(Request $request)
    {
      $matches = [];
      $string = $request->query->get('q');

      $query = \Drupal::database()->select('node__field_loazon_long', 'la');
      $query->fields('la', ['field_loazon_long_value', 'entity_id']);
      //$query->condition('la.field_loazon_long_value', '%' . $string . '%', 'LIKE');
      $query->condition('la.field_loazon_long_value', $string . '%', 'LIKE');
      //$query->sort('field_loazon_long_value', 'ASC'); 
      $query->range(0, 10) ;
      $result = $query->execute();

      foreach ($result as $row) {
        //$matches[] = ['value' => $row->entity_id, 'label' => $row->field_loazon_long_value];
        $matches[] = ['value' => $row->field_loazon_long_value, 'label' => $row->field_loazon_long_value];
      }

      return new JsonResponse($matches);
    }
    
    
    //public function foo() {
    //...
    //return $this->redirect('hello.content');
    //}
    
}