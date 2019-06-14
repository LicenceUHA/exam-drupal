<?php
/*
namespace Drupal\file_upload\Controller;

use Drupal\Core\Controller\ControllerBase;

class HelloController extends ControllerBase {

    /*public function content() {
        return ['#markup' => $this->t('Hello!')];
    }*/
    /*
    public function content($param) {
        return array ('#markup' => $param);
    }
    




}*/

namespace Drupal\file_upload\Controller;

use Drupal\Core\Controller\ControllerBase;

class File_uploadController extends ControllerBase {

 /**
  * @param string $param
  * @return array
  */
public function content($param = '') {
   $message = $this->t('You are on the file uplaod page. Your name is @username! @param', [
     '@username' => $this->currentUser()->getAccountName() ? $this->currentUser()->getAccountName() : $this->t('guest'),
     '@param' => $param,
   ]);

   return ['#markup' => $message];
 }

}