<?php
/* @var $this SiteController */

$this->pageTitle=Yii::t('app',Yii::app()->name);
Yii::app()->clientScript->registerScriptFile(DConst::angularCtrls().'TestsCtrl.js');
?>
<div id="tets" ng-app="WCup" ng-controller="TestsCtrl">
  <form action="" if="testForm">
    <input type="text" ng-model="name" class="form-control input-sm" required />
    <input type="text" ng-model="lastname" class="form-control input-sm" required />
  </form>
</div>