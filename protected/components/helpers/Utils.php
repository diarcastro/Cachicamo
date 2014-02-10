<?php

/*
 * Descripción de Utils
 * 
 * @author Diego Castro <diego.castro@knowbi.com>
 * @copyright (c) 2012, Knowbi.com
 */

/**
 * Description of Utils
 *
 * @author Diego Castro
 */
abstract class Utils{
  public static $imagesFileTypes=array('jpg','jpeg','png','bmp','gif');
  /**
   * Para capturar los errores en en actionError del Controller
   */
  const ERROR_CODE_EXIT_APP=-1000;
  
  const ROLE_ADMIN='admin';
  const ROLE_COMPANY='company';
  const ROLE_STUDENT='student';
  /**
   * Escenario para hacer algunas cosas sin validaciones ni eventos
   */
  const GHOST_SCENARIO='ghost';
  const DATE_NULL='0000-00-00 00:00:00';
  const STATE_PUBLISHED=1;
  const STATE_UNPUBLISHED=0;
  const STATE_DEACTIVATED=-1;

  static $_role=null;

  /**
   * Muestra en debug una variable
   * @param Mixed $data Datos a mostrar
   * @param Bool $end Indica si termina la aplicación o no
   */
  public static function d($data,$end=false){
    CVarDumper::dump($data,5,true);
    echo "\n\n";
    if($end) self::end();
  }
  /**
   * Indica si <var>$fileExt</var> es una extensión válida de imagen
   * @param string $fileExt Extensión de archivo
   * @return boolean
   */
  public static function isValidImage($fileExt){
    return in_array(strtolower($fileExt),self::$imagesFileTypes);
  }
  /**
   * Retorna el role por defecto del usuario actual
   * @return string
   */
  public static function getRole(){
    if(!self::$_role)
        self::$_role=array_keys(Yii::app()->authManager->getRoles(Yii::app()->user->id));
    return self::$_role[0];
  }
  /**
   * Retorna el filtro del administrador Un campo de texto con placeholder
   * @param CActiveRecord $model Modelo donde estan los datos
   * @param string $attr Nombre del atributo a retornar
   * @param string $extraClass Clases adicionales
   */
  public static function getFilterAdmin($model,$attr, $extraClass=''){
    return CHtml::activeTextField($model,$attr,array(
        'class'=>'form-control input-sm search'.$extraClass,
        'placeholder'=>$model->getAttributeLabel($attr),
      ));
  }
  /**
   * Muestra información en el log del Yii
   * @param mixed $msg Mensaje a mostrar
   * @param integer $level Nivel del log
   * @param string $category Categoria del log, por defecto es application
   */
  public static function log($msg,$level=CLogger::LEVEL_PROFILE,$category='application'){
    try{
      if(!is_string($msg)) $msg=print_r($msg,1);
      Yii::log($msg,$level,$category);
    } catch(Exception $e){
      
    }
  }
  /**
   * Convierte un valor a boolean
   * @param mixed $value Valor a validar
   * @return integer Valor indicado boolean para el valor enviado
   */
  public static function toBool($value){
    if(is_numeric($value)){
      return $value>0?1:0;
    }else if(is_string($value)){
      return $value=='true'?1:0;
    }else{
      return (int)(bool)$value;
    }
  }
  /**
   * Crea un correo dummy
   * @return String
   */
  public static function dummyEmail(){
    return 'temp_'.uniqid().self::getRandomString(10).'@cgrtmp.com';
  }
  /**
   * Compara los valores de un array contra los atributos de un array
   * @param array $array Array clave valor
   * @param mixed|CActiveRecord $model Modelo
   * @return Bool Si no hay cambios retorna true, en caso contrario retorna false
   */
  public static function equalsArray2Model($array,$model){
    foreach($array as $k=>$v){
      if(isset($model->$k)){
        if($v!=$model->$k) return false;
      }else return false;
    }
    return false;
  }
  /**
   * Convierte un valor boolean a un entero
   * @param mixed $value Valor a evaluar
   * @return integer 0 o 1
   */
  public static function bool2Int($value){
    return self::toBool($value);
  }

  /**
   * Pone una traducción para ser usada en javascript
   * @param string $category
   * @param string $message
   * @return void
   */
  public static function jsMessage($category,$message){
    $md5=md5($message);

    if(!Yii::app()->clientScript->isScriptRegistered('translate_'.$category,CClientScript::POS_HEAD)){
      Yii::app()->clientScript->registerScript('translate_'.$category,'Utils.messages=Utils.messages || {}; Utils.messages.'.$category.'={};',CClientScript::POS_HEAD);
    }
    Yii::app()->clientScript->registerScript($md5,'Utils.messages.'.$category.'.t_'.$md5.'="'.Chtml::encode(Yii::t($category,$message)).'";',CClientScript::POS_HEAD);
//    Yii::app()->clientScript->registerScript($md5,'Utils.messages[\''.$category.'\'][\'t_'.$md5.'\']="'.Yii::t($category,$message).'";',CClientScript::POS_HEAD);
  }

  /**
   * Termina la ejecución de la petición
   * @param integer $status Código de error
   * @param boolean $exit Indica si se invoca el método exit, por defecto es true
   */
  public static function end($status=0,$exit=true){
    Yii::app()->end($status,$exit);
  }
  /**
   * Retorna una instancia CDateFormatter
   * @param String $locale Locale ID, por defecto es_co
   * @return \CDateFormatter
   */
  public static function CDate($locale=null){
    if(!$locale){
      switch(Yii::app()->language){
        case 'en':
          $locale='en_us';
          break;
        case 'es':
        default:
          $locale='es_co';
          break;
      }
    }
//    if(!$locale) $locale=Yii::app()->getLanguage();
    return new CDateFormatter($locale);
  }
  public static function disableWebLog(){
    foreach(Yii::app()->log->routes as $route){
      if($route instanceof CWebLogRoute){
        $route->enabled=false;
      }
    }
  }
  /**
   * Convierte una fecha a un formato más legible
   * @param string $date Fecha
   * @param string $dateWidth Formato de la fecha
   * @param string $timeWidth formato de la hora
   * @return string
   */
  public static function formatDateTime($date,$dateWidth='medium',$timeWidth='medium'){
    $format=self::CDate();
    return $format->formatDateTime($date,$dateWidth,$timeWidth);
      
  }
  /**
   * Quita el log, termina la ejecución de la aplicación y muestra el output de DResponse si <var>$echoResponse=true</var>
   * @param boolean $echoResponse Indica si imprime la salida de DResponse
   */
  public static function ajaxEnd($echoResponse=true){
    if($echoResponse) echo DResponse::getInstance()->output();
    self::disableWebLog();
    self::end();
  }

  /**
   * Convierte una cadena a formato Capitalize
   * @param string $string Cadena a convertir
   * @return string Cadena convertida
   */
  public static function capitalize($string){
    return trim(ucwords(mb_strtolower($string,'utf-8')));
  }

  /**
   * Convierte una cadena a minuscula
   * @param string $string Cadena a convertir
   * @return string Cadena convertida
   */
  public static function lowercase($string){
    return trim(mb_strtolower($string,'utf-8'));
  }

  /**
   * Convierte una cadena a mayuscula
   * @param string $string Cadena a convertir
   * @return string Cadena convertida
   */
  public static function uppercase($string){
    return trim(mb_strtoupper($string,'utf-8'));
  }

  /**
   * Retorna un icono bootstrap
   * 
   * @param string $icon el id del icono a mostrar
   * @param boolean $extraClass Clases adicionales
   * @return string Cadena del icono de bootstrap
   * @static
   */
  public static function icon($icon='',$extraClass=null){
    return self::hIcon($icon.($extraClass?' '.$extraClass:''));
  }
  /**
   * Retorna un icono creado con CHtml::tag
   * @param type $icon
   * @param array $htmlOptions
   * @return type
   */
  public static function hIcon($icon,$htmlOptions=array()){
    $htmlOptions['class']='glyphicon glyphicon-'.$icon.(isset($htmlOptions['class'])?' '.$htmlOptions['class']:'');
    return CHtml::tag('span',$htmlOptions,'',true);
  }
  /**
   * Retorna la IP del usuario
   * @param boolean $long Indica si devuelve un long o no
   * @return integer|string Ip del usuario en un formato long o string
   */
  public static function getIP($long=true){
    if($long) return ip2long(Yii::app()->request->userHostAddress);
    return Yii::app()->request->userHostAddress;
  }
  /**
   * Retorna la extensión de un archivo
   * @param string $file Ruta del archivo
   * @return string
   */
  public static function getExtension($file){
    $parts=explode('.',$file);
    return $parts[count($parts)-1];
  }
  /**
   * Retorna la fecha actual en el formato <var>$format</var>
   * @param string $format Formato de la fecha a devolver por defecto <var>Y-m-d H:i:s</var>
   * @return string
   */
  public static function getNow($format='Y-m-d H:i:s'){
    return date($format);
  }

  /**
   * Retorna el valor de una clave pasado por post o get
   * @see Yii::app()->request->getParam
   * @param string $name clave
   * @param mixed $defaultValue Valor por defecto si no encuentra la clave
   * @return mixed
   */
  public static function getParam($name,$defaultValue=''){
    return Yii::app()->request->getParam($name,$defaultValue);
  }
  /**
   * Retorna el alor de una clave pasada por post
   * @see Yii::app()->request->getPost
   * @param string $name clave
   * @param mixed $defaultValue Valor por defecto si no encuentra la clave
   * @return mixed
   */
  public static function getPost($name,$defaultValue=''){
    return Yii::app()->request->getPost($name,$defaultValue);
    
  }

  /**
   * Genera una cadena única
   *
   * @param integer $length cantidad de caracteres a devolver
   * @return string Cadena creada aleatoriamente
   */
  public static function getRandomString($length=20){
    $salt="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $len=strlen($salt);
    $makepass='';
    $stat=@stat(__FILE__);
    if(empty($stat) || !is_array($stat)) $stat=array(php_uname());
    mt_srand(crc32(microtime().implode('|',$stat)));
    for($i=0; $i < $length; $i++){
      $makepass.=$salt[mt_rand(0,$len - 1)];
    }
    return $makepass;
  }

  /**
   * Retorna una cadena compuesta por un time().$separator.uniquid().$separator.(caracteres aleatorios)
   * @param string $separator Cadena que separa los metodos, por defecto ''
   * @param int $randonExtraSize Cantidad de caracteres aleatorios al final de la cadena. Por defecto 10
   * @return string Cadena aleatoria
   */
  public static function getRandomFileName($separator='',$randonExtraSize=25){
    return uniqid().$separator.self::getRandomString($randonExtraSize);
  }

  /**
   * Retorna el número de segundos que hay en <var>$days</var>
   * @param integer $days Número de días a convertir en segundos, por defecto 30
   * @return integer
   */
  public static function getSecods($days=30){
    return $days * 24 * 3600;
  }

  /**
   * Convierte una cadena a asteriscos(*)
   * 
   * @param string $str Cadena a convertir en asteriscos
   * @return string Cadena compuesta con asteriscos(*)
   * @static
   */
  public static function passToStar($str='',$len=false){
    if(empty($str)) return '*';
    if(!$len) return str_repeat('*',strlen($str));
    return str_repeat('*',$len);
  }

  /**
   * Retorna un preloader
   * @param array $htmlOptions Opciones HTML
   * @param string $type Tipo de Preloader, por defecto es bar
   * @return string Cadena html con el preloader
   */
  public static function preloader($htmlOptions=array(),$type='bar'){
    return CHtml::image(Yii::app()->theme->baseUrl.'/images/preloader-'.$type.'.gif','preloader',$htmlOptions);
  }

  /**
   * Redirecciona hacia una ruta dependiendo el tipo de role del usuario actual
   * @param boolean $returnUrl Indica si retorna una url o redirecciona directamtene
   * @return void|string Redirecciona la aplicación o retorna una cadena con una url de redirección
   */
  public static function redirectHomeRole($returnUrl=false){
    if(self::isAdmin() || self::isCompanyAdmin()){
      if(!$returnUrl) Yii::app()->controller->redirect(array('admin/'));
      else return Yii::app()->createAbsoluteUrl('admin/');
//      else return Yii::app()->controller->createUrl('admin/');
    }
    else{
      if(!$returnUrl)
          Yii::app()->controller->redirect(array('/home'));
      else return Yii::app()->createAbsoluteUrl('/home');
//      else return Yii::app()->controller->createUrl('site/home-student');
    }
  }

  /**
   * Devuelve una cadena dentro de una etiqueta <b>strong</b>
   * @param strong $str Cadena en medio del strong
   * @return string Cadena dentro de una etiqueta <b>strong</b>
   */
  public static function stronger($str){
    return '<strong>'.$str.'</strong>';
  }

  public static function getStringPart($string='',$initLenght=20,$endLength=10,$separator='...'){
    if(empty($string)) return '';
    if(strlen($string) <= $initLenght) return $string;
    else if(strlen($string) > $initLenght && strlen($string) <= $initLenght + $endLength)
        return $string;
    else
        return substr($string,0,$initLenght).$separator.substr($string,-$endLength);
  }

  /**
   * Retorna el Role name dependiendo del id
   * @param integer $id Id del Role
   * @return boolean|string False en caso de no encontrar el role, El nombre del role en caso de encontrarlo
   */
  public static function getRoleById($id=1){
    switch($id){
      case 1:
        return Utils::ROLE_ADMIN;
      case 2:
        return Utils::ROLE_COMPANY;
      case 3:
        return Utils::ROLE_STUDENT;
    }
    return false;
  }
  /**
   * Retorna el id del un rol dependiendo de su nombre
   * @param string $roleName Nombre del role
   * @return int|boolean
   */
  public static function getRoleByName($roleName){
    switch($roleName){
      case Utils::ROLE_ADMIN:
        return 1;
      case Utils::ROLE_COMPANY:
        return 2;
      case Utils::ROLE_STUDENT:
        return 3;
    }
    return false;
  }

  /**
   * Verifica si un usuario es administrador
   * @return boolean True or False
   */
  public static function isAdmin(){
    return self::isRole(Utils::ROLE_ADMIN);
  }

  /**
   * Verifica si el usuario actual es administrador de la empresa con la que está logueado actualmente
   * @return boolean True or false
   */
  public static function isCompanyAdmin(){
    return self::isRole(Utils::ROLE_COMPANY);
  }

  /**
   * Verifica si el usuario actual es cualquier tipo de administrador. Puede ser admin o company
   * @return boolean True or false
   */
  public static function isAnyAdmin(){
    return self::isAdmin() || self::isCompanyAdmin();
  }

  /**
   * Verifica si el usuario actual es estudiante de la empresa con la que está logueado actualmente
   * @return boolean True or false
   */
  public static function isStudent(){
    return self::isRole(Utils::ROLE_STUDENT);
  }

  /**
   * Retorna información si el usuario actual tiene cierto Role activo
   * @param strign $roleName Role que se desea validar
   * @return boolean
   */
  public static function isRole($roleName=self::ROLE_STUDENT){
    if(Yii::app()->user->isGuest) return false;
    if(isset(Yii::app()->user->company)){
      if(Yii::app()->user->company['role'] == $roleName) return true;
    }
    return false;
  }

  /**
   * Retorna el usuario actual 
   * @return type
   */
  public static function getUser(){
    return Yii::app()->user;
  }
  /**
   * Retorna el Id del usuario actual. Si es local retorna 3(Usuario de pruebas)
   * @return int Id del usuario actual
   */
  public static function getUserId(){
    if(!self::isLocal()) return Yii::app()->user->id;
    else return 3; //Yeferson de pruebas
  }
  /**
   * Retorna true si es desde el servidor local
   * @return Boolean
   */
  public static function isLocal(){
    return Yii::app()->request->userHostAddress=='127.0.0.1';
  }
  /**
   * Retorna una cadena no escapada
   * @param string $str Cadena a la cual se le quitará el escape
   * @param boolean $explode Indica si se retorna una cadena separada por <var>$explodeSeparator</var>
   * @param string $explodeSeparator Cadena por la cual se va a separar <var>$str</var>
   * @return string|array Si<var>$explode</var> retorna array, en caso contrario retorna string
   */
  public static function unquoteString($str,$explode=false,$explodeSeparator=','){
    $string=str_replace('`','',$str);
    if($explode){
      return array_map('trim',explode($explodeSeparator,$string));
    }
    return $string;
  }
  /**
   * Registers a script package that is listed in packages. This method is the same as registerCoreScript.
   * @param string $package
   */
  public static function registerPackage($package){
    Yii::app()->clientScript->registerPackage($package);
  }
  /**
   * Retorna un dato del usuario y la empresa actual
   * @param string $data Dato solicitado ejm: id,nit
   * @return boolean|mixed false si no encuentra <var>$data</var> en caso contrario retorna Yii::app()->user->company[$data]
   */
  public static function uCompany($data='id'){
    if(isset(Yii::app()->user->company[$data])) return Yii::app()->user->company[$data];
    return false;
  }
  
  public static function getDefaultActionsColumn(){
    
    return array(
			 'class'=>'CButtonColumn',
			 'header'=>Yii::t('app', 'Actions'),
			 'template'=>'{update}{delete}',
      
			 'viewButtonOptions'=>array(
					 'class'=>'btn btn-primary btn-xs has-tip',
					 'title'=>Yii::t('app', 'View'),
			 ),
			 'viewButtonLabel'=>Utils::icon('search'),
			 'viewButtonImageUrl'=>false,
      
			 'updateButtonOptions'=>array(
					 'class'=>'btn btn-xs btn-info has-tip',
					 'title'=>Yii::t('app', 'Edit'),
			 ),
			 'updateButtonLabel'=>Utils::icon('pencil', true),
			 'updateButtonImageUrl'=>false,
      
			 'deleteButtonOptions'=>array(
					 'class'=>'btn btn-danger btn-xs left5 has-tip',
					 'title'=>Yii::t('app', 'Delete'),
			 ),
			 'deleteButtonLabel'=>Utils::icon('remove', true),
			 'deleteButtonImageUrl'=>false,
			 'htmlOptions'=>array(
					 'class'=>''
			 ),
	 );
  }
}
