<?php /* @var $this Controller */?>
<?php
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerPackage('chosen');
Yii::app()->clientScript->registerPackage('bootstrap');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/themes/'.Yii::app()->theme->name.'/css/styles.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/script.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/utils.css');

//  Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/script.js');
//  Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/styles.css');
//  Yii::app()->clientScript->registerScriptFile('//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js');
?>
<!doctype html>
<html lang="<?php echo Yii::app()->language?>">
  <head>
    <meta name="viewport" content="width=device-width,initial-scale=1, user-scalable=no" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo CHtml::encode($this->pageTitle);?></title>
    <!--[if lt IE 9]>
      <script src="<?php echo Yii::app()->baseUrl?>/js/html5shiv.js"></script>
    <![endif]-->
  </head>
  <body>
    <header id="header">
      <div class="container clearfix">
        <div class="pull-left app-name txt2-5 txt-white uppercase top30">
          <?php echo Yii::t('app','Managment Risk College');?>
        </div>
        <div class="pull-right top30 align-right">
          <div class="logo inline-b"></div>
          <div class="searcher top20">
            <input type="text" class="search" />
          </div>
        </div>
      </div>
    </header>
    <div class="container" id="page">
      <div id="mainmenu">
        <?php
        $this->widget('zii.widgets.CMenu',array(
          'items'=>array(
            array('label'=>'Home','url'=>array('/site/index')),
            array('label'=>'About','url'=>array('/site/page','view'=>'about')),
            array('label'=>'Contact','url'=>array('/site/contact')),
            array('label'=>'Login','url'=>array('/site/login'),'visible'=>Yii::app()->user->isGuest),
            array('label'=>'Logout ('.Yii::app()->user->name.')','url'=>array('/site/logout'),'visible'=>!Yii::app()->user->isGuest)
          ),
        ));
        ?>
      </div><!-- mainmenu -->
      <?php if(isset($this->breadcrumbs)):?>
        <?php
        $this->widget('zii.widgets.CBreadcrumbs',array(
          'links'=>$this->breadcrumbs,
        ));
        ?><!-- breadcrumbs -->
      <?php endif?>
      <?php echo $content;?>
      <div class="clear"></div>
      <div id="footer">
        Copyright &copy; <?php echo date('Y');?> by My Company.<br/>
        All Rights Reserved.<br/>
        <?php echo Yii::powered();?>
      </div><!-- footer -->
    </div><!-- page -->
  </body>
</html>
