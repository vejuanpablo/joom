<?php
/**
 * ------------------------------------------------------------------------
 * JA Moviemax Template
 * ------------------------------------------------------------------------
 * Copyright (C) 2004-2011 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
 * @license - Copyrighted Commercial Software
 * Author: J.O.O.M Solutions Co., Ltd
 * Websites:  http://www.joomlart.com -  http://www.joomlancers.com
 * This file may not be redistributed in whole or significant part.
 * ------------------------------------------------------------------------
 */


defined('_JEXEC') or die;
$responsive  = $this->params->get('responsive');

if(!$responsive) {
  $doc = JFactory::getDocument();
  $non_responsive_width = $this->params->get('non_responsive_width');
  $header_width = $non_responsive_width - '400px';
  $header_css = ".t3-header { width:{$header_width}px; }\n";
  $doc->addStyleDeclaration ($header_css);
}
?>

<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>"
	  class='<jdoc:include type="pageclass" />' itemscope>

<head>
	<jdoc:include type="head" />
	<?php $this->loadBlock('head') ?>
  <?php $this->addCss('layouts/docs') ?>
</head>

<body>

<div class="t3-wrapper search-close"> <!-- Need this wrapper for off-canvas menu. Remove if you don't use of-canvas -->
  <div class="container"><div class="row">
    <div class="t3-main-content col-sm-12 col-hd-8" <?php if ($this->countModules('sidebar-2')) : ?>style="width: 75%"<?php endif; ?>>
      <?php $this->loadBlock('header') ?>

      <?php $this->loadBlock('slideshow') ?>

      <?php $this->loadBlock('content-mast-top') ?>

      <?php $this->loadBlock('mainbody') ?>

      <?php $this->loadBlock('content-mast-bottom') ?>

      <?php $this->loadBlock('navhelper') ?>

      <?php $this->loadBlock('footer') ?>
    </div>
    <?php if ($this->countModules('sidebar-2')) : ?>
    <div class="t3-big-sidebar col-xs-12 col-hd-4<?php $this->_c('sidebar-2') ?>" style="width: 25%">
      <button class="btn btn-sidebar hidden-hd" style="display: none;"><i class="fa fa-ellipsis-v"></i></button>
      <div class="inner">
        <jdoc:include type="modules" name="<?php $this->_p('sidebar-2') ?>" style="T3Xhtml" />
      </div>
    </div>
    <?php endif; ?>
    
  </div></div>
</div>

</body>

</html>