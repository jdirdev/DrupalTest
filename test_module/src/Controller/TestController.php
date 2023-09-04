<?php

namespace Drupal\test_module\Controller;

use Drupal\Core\Controller\ControllerBase;


class TestController extends ControllerBase {

    public function students() {

        //Header
        $header_table = [
            'lastname' => t('Apellido'), 
            'name' => t('Nombre'),
            'documentType' => t('Tipo de Documento'),
            'document' => t('Numero de documento'),
            'email' => t('Correo'),
            'phone' => t('Teléfono'), 
            'country' => t('País'), 
        ];

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

        $data['table'] = [
            '#type' => 'table',
            '#header' => $header_table,
            '#rows' => $row,
            '#empty' => t('No hay información'),
        ];

        return $data;
     
    }
}