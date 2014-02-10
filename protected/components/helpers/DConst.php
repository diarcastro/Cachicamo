<?php

abstract class DConst{
  /**
   * Ruta de los controladores
   * @return string
   */
  public static function angularCtrls(){
    return Yii::app()->request->baseUrl.'/js/controllers/';
  }

  /**
   * Ruta de las directivas angularjs
   * @return string
   */
  public static function angularDirectives(){
    return Yii::app()->request->baseUrl.'/js/directives/';
  }

}
