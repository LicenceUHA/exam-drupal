<?php

namespace Drupal\file_upload\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * File_uploadForm controller.
 */
class File_uploadForm extends FormBase {

  /**
   * Returns a unique string identifying the form.
   *
   * The returned ID should be a unique string that can be a valid PHP function
   * name, since it's used in hook implementation names such as
   * hook_form_FORM_ID_alter().
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'file_upload_form';
  }

  /**
   * Form constructor.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @return array
   *   The form structure.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['file'] = array (
      '#type' => 'file',
      '#title' => 'fichier PDF'
    );
    $form['action'] = array('#type' => 'action');
    $form['action']['submit'] = array('#type' => 'submit', '#value' => $this->t('submit'));

    return $form;

    
  }

  /**
   * Validate the title and the checkbox of the form.
   *
   * @param array $form
   *   The form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The form state.
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    
    $file = file_save_upload(
        'file', array('file_validate_extentions' => array('pdf')), FALSE, 0, FILE_EXISTS_REPLACE
    );

    if ($file) {
      if($file = file_move($file, 'public://')){
          $form_state->setStorage(array($file));
      } else{
          $form_state->setError('file', $this->t('Writing permission problem'));
      }
    }

   
  }

  /**
   * Form submission handler.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $pdfFile = $form_state->getStorage();
    $fileHandler = fopen(\Drupal::service('file_system')->realpath($pdfFile[0]->getFileUri()), 'r');
    $file_uploadArray = Array();

    if($fileHandler) {
        while(($data = fgetpdf ($fileHandler, 0 ";")) !== FALSE){
            $file_upload = array(
                reset ($data), end($data)
            );

        }
    }

    $result = $this->update ($file_upload, 'file_upload');

    // Display the results
    // Call the Static Service Container wrapper
    // We should inject the messenger service, but its beyond the scope
    // of this example.
    $messenger = \Drupal::messenger();
    $messenger->addMessage('Title: ' . $form_state->getValue('title'));
    $messenger->addMessage('Accept: ' . $form_state->getValue('accept'));

    // Redirect to home.
    $form_state->setRedirect('<front>');
  }

}