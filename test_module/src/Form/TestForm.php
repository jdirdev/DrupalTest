<?php

namespace Drupal\test_module\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class TestForm extends FormBase {

    /**
     * {@inheritdoc }
     */
    public function getFormId() {
        return 'test_module_form';
    }

    /**
     * {@inheritdoc }
     */
    public function buildForm(array $form, FormStateInterface $form_state) {

        $form['lastname']=[
            '#type' => 'textfield',
            '#title' => $this->t('Apellido'),
            '#required' => TRUE,
        ];

        $form['name']=[
            '#type' => 'textfield',
            '#title' => $this->t('Nombre'),
            '#required' => TRUE,
        ];

        $form['documentType']=[
            '#type' => 'select',
            '#title' => $this->t('Tipo de Documento'),
            '#required' => TRUE,
            '#options' => $this->getTermsOfVocabulary('test_module_lstdocument_type'),
        ];
        
        $form['document']=[
            '#type' => 'number',
            '#title' => $this->t('Numero de documento'),
            '#required' => TRUE,
        ];

        $form['email']=[
            '#type' => 'email',
            '#title' => $this->t('Correo electrónico'),
            '#required' => TRUE,
        ];

        $form['phone']=[
            '#type' => 'tel',
            '#title' => $this->t('Teléfono'),
            '#required' => TRUE,
        ];


        $form['country']=[
            '#type' => 'select',
            '#title' => $this->t('País'),
            '#required' => TRUE,
            '#options' => $this->getTermsOfVocabulary('test_module_lstcountry'),
        ];
        
        $form['submit']=[
            '#type' => 'submit',
            '#value' => $this->t('Guardar'),
            '#button_type' => 'primary'
        ];
        
        return $form;
    }


    /**
     * {@inheritdoc }
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {

        \Drupal::database()->insert('test_student')
            ->fields(['lastname', 'name', 'documentType', 'document', 'email', 'phone', 'country'])
            ->values(array(
                $form_state->getValue('lastname'),
                $form_state->getValue('name'),
                $form_state->getValue('documentType'),
                $form_state->getValue('document'),
                $form_state->getValue('email'),
                $form_state->getValue('phone'),
                $form_state->getValue('country'),
                ))
            ->execute();

        $this->messenger()->addStatus($this->t('Created @fullname', ['@fullname' => $form_state->getValue('lastname')." ".$form_state->getValue('name')]));
    }


    private function getTermsOfVocabulary(string $vid) {
        $terms =\Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($vid);
        foreach ($terms as $term) {
            $term_data[$term->name] = $term->name;
        }
        return $term_data;
    }

}