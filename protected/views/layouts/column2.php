<?php /* @var $this Controller */?>
<?php
  $admin=Utils::isAdmin() || Utils::isCompanyAdmin();
?>
<?php $this->beginContent('//layouts/main');?>
<section id="container" class="clearfix">
  <div class="content-left col-md-2">
    <?php echo $this->renderPartial('//common/menu/'.($admin ? Utils::ROLE_ADMIN : Utils::ROLE_STUDENT));?>
  </div>
  <div class="content-center col-md-8">
    <?php echo $this->renderPartial('//common/greet/'.($admin ? Utils::ROLE_ADMIN : Utils::ROLE_STUDENT))?>
    <?php echo Flashes::getHtml()?>
    <div id="content" class="padding-10 row">
      <?php echo $content;?>
    </div>
  </div>
  <div class="content-right col-md-2 hidden-md hidden-sm hidden-xs">
    <?php echo $this->renderPartial('//common/right/'.($admin ? Utils::ROLE_ADMIN : Utils::ROLE_STUDENT));?>
  </div>
</section>
<?php $this->endContent();?>