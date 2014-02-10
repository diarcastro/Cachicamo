<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class DController extends CController{

  /**
   * @var string the default layout for the controller view. Defaults to '//layouts/column1',
   * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
   */
  public $layout='//layouts/column2';

  /**
   * @var array context menu items. This property will be assigned to {@link CMenu::items}.
   */
  public $menu=array();

  /**
   * @var array the breadcrumbs of the current page. The value of this property will
   * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
   * for more details on how to specify this property.
   */
  public $breadcrumbs=array();
  /**
   * Respuestas ajax
   * @var DResponse 
   */
  protected $_response;
  public function __construct($id,$module=null){
    $this->_response=DResponse::getInstance();
    parent::__construct($id,$module);
  }
  /**
   * Guarda un intento de fraude en una acción
   * @param string $lastMethod Nombre del método donde se trató de ejecutar el fraude
   * @return boolean True si todo sale bien, en caso contrario false
   */
  protected function fraudIntent($lastMethod=''){
    if(empty($lastMethod)) return false;
    $fraudIntent=new AuditsFraudIntents;
    $fraudIntent->method_name=$lastMethod;
    $data=array(
      'post'=>$_POST,
      'get'=>$_GET,
      'request'=>array(
        'isAjaxRequest'=>Yii::app()->request->isAjaxRequest,
        'isFlashRequest'=>Yii::app()->request->isFlashRequest,
      ),
      'browser'=>array(
        'name'=>Yii::app()->browser->getBrowser(),
        'version'=>Yii::app()->browser->getVersion(),
        'os'=>Yii::app()->browser->getPlatform(),
      )
    );
    $fraudIntent->data=CJavaScript::jsonEncode($data);
    return $fraudIntent->save();
  }

}
