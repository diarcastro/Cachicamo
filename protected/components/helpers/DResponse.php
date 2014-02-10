<?php

/*
 * Administra los retornos de las clases
 * 
 * @author Diego Castro <diego.castro@knowbi.com>
 * @copyright (c) 2012, Knowbi.com
 */

/**
 * Administración de retornos de las clases
 *
 * @author Diego Castro
 */
class DResponse extends CComponent{

  protected $_response;
  protected $_errorKey='error';
  private static $_instance=null;

  /**
   * Constructor de la clase
   * @param string $errorKey Nombre de la clave de error, por defecto es error 
   */
  public function __construct($errorKey='error'){
    $this->_response=new stdClass();
    if(!empty($errorKey)) $this->_errorKey=$errorKey;
  }

  /**
   * Retorna una instancia de la clase
   * @return DResponse
   */
  public static function getInstance(){
    if(self::$_instance === null) self::$_instance=new DResponse();
    return self::$_instance;
  }

  /**
   * Establece un valor para la clave Error
   * @param mixed $value Valor del error
   */
  public function error($value=true){
    if($value === false || $value === null) $this->removeError();
    else $this->set($this->_errorKey,$value);
  }

  /**
   * Elimina la clave Error
   */
  public function removeError(){
    unset($this->_response->{$this->_errorKey});
  }

  /**
   * Retorna el error
   * @return mixed
   */
  public function getError(){
    return $this->get($this->_errorKey);
  }

  /**
   * Establece un valor para una clave
   * @param string $key Nombre de la clave
   * @param mixed $value Valor de la clave
   * @param string $error Guarda una clave de error también
   * @return boolean si no se envia la clave retorna false, en caso contrario true
   */
  public function set($key='',$value='',$error=false){
    if(empty($key)) return false;
    $this->_response->$key=$value;
    if($error) $this->error($error);
    return $this;
  }

  /**
	 * Guarda un valor en la clase
	 * <pre>
	 * $this->propertyName=$value;
	 * $this->eventName=$callback;
	 * </pre>
	 * @param string $name Nombre de la propiedad
	 * @param mixed $value Valor de la propiedad
	 * @return Bool
	 */
  public function __set($name,$value){
    return $this->set($name,$value);
  }
  /**
   * Retorna el valor de una propiedad
   * @param mixed $key Clave a devolver
   * @return mixed Valor a devolver
   */
  public function __get($key){
    return $this->get($key);
  }

  /**
   * @see DRespose::set
   */
  public function _($key='',$value='',$error=false){
    return $this->set($key,$value,$error);
  }

  /**
   * Guarda toda la información de un objeto
   * @param mixed $object Objeto que se va a guardar
   * @return boolean Si todo sale bien true, en caso contrario false
   */
  public function setObject($object=null){
    if($object === null) return false;
    $object=(object)$object;
    foreach($object as $key=> $value){
      $this->set($key,$value);
    }
    return true;
  }

  /**
   * Retorna una clave o todas las claves
   * @param string $key Clave que desea retornar, si la clave no existe retorna false. Si la clave es vacia o null retorna todas las claves
   * @return boolean
   */
  public function get($key=null){
    if($key === null || empty($key)) return $this->_response;
    else if(isset($this->_response->$key)) return $this->_response->$key;
    return false;
  }

  /**
   * Devuelve las claves como un objeto
   * @param string $type Tipo de objeto (json,stdclass,array). <var>json</var> por defecto
   * @return mixed Claves y valores
   */
  public function output($type='json'){
    switch(strtolower($type)){
      case 'array':
        return (array)$this->_response;
        break;
      case 'stdclass':
        return $this->_response;
        break;
      case 'json':
      default:
        return CJavaScript::jsonEncode($this->_response);
    }
  }

}

?>
