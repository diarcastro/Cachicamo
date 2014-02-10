<?php /* @var $this Controller */?>
<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/styles.css');
//Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/responsive-styles.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/utils.css');

Yii::app()->clientScript->registerPackage('bootstrap');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/scripts.php');

?>
<!doctype html>
<html lang="<?php echo Yii::app()->language?>">
  <head>
    <meta name="viewport" content="width=device-width,initial-scale=1, user-scalable=no" />
    <?php if(!YII_DEBUG): //Para que Internet explore visualicce el sitio con el modo más alto posible ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php endif; ?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
