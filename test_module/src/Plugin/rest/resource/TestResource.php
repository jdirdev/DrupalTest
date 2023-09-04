<?php

namespace Drupal\test_module\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;

/**
 * Test Resource
 *
 * @RestResource(
 *   id = "test_resource",
 *   label = @Translation("Test Resource"),
 *   uri_paths = {
 *     "canonical" = "/API/formulario"
 *   }
 * )
 */
class TestResource extends ResourceBase {

    /**
     * Responds to entity GET requests.
     * @return \Drupal\rest\ResourceResponse
     */
    public function get() {

        //$response = ['message' => 'Hello, this is a rest service Test'];
        $row = [];

        $query = \Drupal::database()->select('test_student', 'student');
        $query->fields('student', ['lastname', 'name', 'documentType', 'document', 'email', 'phone', 'country']);                                
        $result = $query->execute()->fetchAll();

        foreach ($result as $value) {
            $row[] = [
                'lastname' => $value->lastname, 
                'name' => $value->name,
                'documentType' => $value->documentType,
                'document' => $value->document,
                'email' => $value->email,
                'phone' => $value->phone,
                'country' => $value->country,
            ];
        }

        return new ResourceResponse($row);
    }
}