<?php

/*
 *  Descripción del archivo
 */

/**
 * Administra la creación de los flash de Usuario
 *
 * @author Diego Castro <diego.castro@knowbi.com>
 * @copyright (c) 2013, Diego Castro
 * @version 1.0
 */
class Flashes extends CController{

  private static $_instance=null;
  public static $closeButton=true;

  public function __construct(){
    //escriba el código aquí
  }

  /**
   * Retorna una instancia de la clase
   * @return Flashes
   */
  public static function getInstance(){
    if(!self::$_instance) self::$_instance=new Flashes();
    return self::$_instance;
  }

  /**
   * Guarda una clave y un valor de flash
   * @param string $key Clave a guardar
   * @param string $value Valor a guardar
   * @param mixed $defaultValue Valor por defecto del valor a guardar.
   */
  public static function set($key,$value,$defaultValue=null){
    Yii::app()->user->setFlash($key,$value,$defaultValue);
  }
  /**
   * Retorna los flashes de una clave
   * @param clave $key Clave a retornar
   * @param mixed $defaultValue Valor por defecto
   * @param boolean $delete Indica si borra el flash o no
   * @return type
   */
  public static function get($key,$defaultValue,$delete){
    return Yii::app()->user->getFlash($key,$defaultValue,$delete);
  }

  /**
   * Retorna todos los flashes guardados
   * @param boolean $delete Indica si borra los flashes después de retornarlos
   * @return array Flashes guardados
   */
  public static function getAll($delete=true){
    return Yii::app()->user->getFlashes($delete);
  }

  /**
   * Retorna el html de los flashes guardados
   * @param boolean $delete Indica si se borran los flashes después del retorno
   * @return string Html
   */
  public static function getHtml($delete=true){
    $flashes=self::getAll($delete);
    if($flashes && count($flashes)){
//      if(self::$closeButton){
//        Yii::app()->clientScript->registerScript('alert-flashes','$(".alert").alert()',CClientScript::POS_READY);
//      }
      $html='<div id="flashes" class="row">';
      foreach($flashes as $key=> $value){
        if($key == 'error') $key='danger';
        $html.='<div class="alert alert-'.$key.'">';
        if(self::$closeButton)
            $html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
        $html.=$value;
        $html.='</div>';
      }
      $html.='</div>';
      return $html;
    }
    return false;
  }

}
