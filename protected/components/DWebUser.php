<?php

/*
 *  Descripción del archivo
 */

/**
 * Descripción de la clase DWebUser
 *
 * @author Diego Castro <diego.castro@knowbi.com>
 * @copyright (c) 2013, Diego Castro
 * @version 1.0
 */
class DWebUser extends CWebUser{

  protected $defaultCompany;
//  public $firstname;

  /**
   * Guarda los datos en el log de acceso
   * @param type $fromCookie
   */
  protected function afterLogin($fromCookie){
    $this->defaultCompany=UsersCompanies::getRoleCompany($this->getId());
    if($this->defaultCompany){
      $this->setState('company',$this->defaultCompany);
      $this->setState('companies',UsersCompanies::getRoles($this->getId()));
      $accessLog=new UsersAccessLog;
      $accessLog->user_id=$this->getId();
      $data=array(
        'browser'=>Yii::app()->browser->getBrowser(),
        'version'=>Yii::app()->browser->getVersion(),
        'os'=>Yii::app()->browser->getPlatform(),
        'fromCookie'=>$fromCookie,
      );
      $accessLog->data=CJavaScript::jsonEncode($data);
      $accessLog->save();
    }else{
      $this->logout();
      Flashes::set('warning',Yii::t('errors','The user don\'t have an published asociated company, Please contact Company administrator.'));
//      Yii::app()->controller->redirect($this->loginUrl,false);
      return false;
    }
  }

  public function refreshRoles(){
    if($this->isGuest) return true;
    $this->setState('company',UsersCompanies::getRoleCompany($this->getId()));
    $this->setState('companies',UsersCompanies::getRoles($this->getId()));
  }

}
