<?php /* @var $this Controller */?>
<?php
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerPackage('chosen');
Yii::app()->clientScript->registerPackage('bootstrap');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/styles.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/responsive-styles.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/scripts.php');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/utils.css');

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/noty/jquery.noty.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/noty/layouts/bottomRight.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/noty/themes/default.js');

Yii::app()->clientScript->registerScript('paths','
  var path=path || {};
  path.images="'.Yii::app()->theme->baseUrl.'/images/";
  path.loaders=path.images;
  
',CClientScript::POS_HEAD);

if(!Yii::app()->user->isGuest){
  if(Yii::app()->user->checkAccess('company'))
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/admin/admin.js');
  else
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/student/student.js');
}
Utils::jsMessage('app','Ok');
Utils::jsMessage('app','Cancel');
Utils::jsMessage('app','Information');
Utils::jsMessage('app','Loading information...');
$browser=Yii::app()->browser;
/* @var $browser Browser */
?>
<!doctype html>
<html lang="<?php echo Yii::app()->language?>">
  <head>
    <meta name="viewport" content="width=device-width,initial-scale=1, user-scalable=no" />
    <?php if(!YII_DEBUG): //Para que Internet explore visualicce el sitio con el modo más alto posible ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php endif; ?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript">
      var site= site || {};
      site.iOS = (navigator.userAgent.match(/(iPad|iPhone|iPod)/i) ? true : false)
    </script>
    <title><?php echo CHtml::encode($this->pageTitle);?></title>
    <!--[if lt IE 9]>
      <script src="<?php echo Yii::app()->baseUrl?>/js/html5shiv.js"></script>
      <script src="<?php echo Yii::app()->baseUrl?>/js/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <?php echo $content;?>
  </body>
</html>
