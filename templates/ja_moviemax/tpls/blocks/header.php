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

// get params
$sitename  = $this->params->get('sitename');
$slogan    = $this->params->get('slogan', '');
$logotype  = $this->params->get('logotype', 'text');
$logoimage = $logotype == 'image' ? $this->params->get('logoimage', T3Path::getUrl('images/logo.png', '', true)) : '';
$logoimgsm = ($logotype == 'image' && $this->params->get('enable_logoimage_sm', 0)) ? $this->params->get('logoimage_sm', T3Path::getUrl('images/logo-sm.png', '', true)) : false;

if (!$sitename) {
	$sitename = JFactory::getConfig()->get('sitename');
}

$logosize = 'col-md-12';
if ($headright = $this->countModules('head-search or languageswitcherload')) {
	$logosize = 'col-md-12';
}

?>

<!-- HEADER -->
<header id="t3-header" class="t3-header <?php if (!$this->countModules('sidebar-2')) echo 'no-sidebar'; ?>" data-spy="affix">
	<div class="container">
		<div class="row">	
			<!-- LOGO -->
			<div class="col-xs-12 <?php echo $logosize ?> logo">
				<div class="logo-<?php echo $logotype, ($logoimgsm ? ' logo-control' : '') ?>">
					<a href="<?php echo JURI::base(true) ?>" title="<?php echo strip_tags($sitename) ?>">
						<?php if($logotype == 'image'): ?>
							<img class="logo-img" src="<?php echo JURI::base(true) . '/' . $logoimage ?>" alt="<?php echo strip_tags($sitename) ?>" />
						<?php endif ?>
						<?php if($logoimgsm) : ?>
							<img class="logo-img-sm" src="<?php echo JURI::base(true) . '/' . $logoimgsm ?>" alt="<?php echo strip_tags($sitename) ?>" />
						<?php endif ?>
						<span><?php echo $sitename ?></span>
					</a>
					<small class="site-slogan"><?php echo $slogan ?></small>
				</div>
			</div>
			<!-- //LOGO -->
			<?php if ($this->getParam('addon_offcanvas_enable')) : ?>
				<?php $this->loadBlock ('off-canvas') ?>
			<?php endif ?>

			<?php if ($this->countModules('head-search')) : ?>
			<!-- HEAD SEARCH -->
			<div class="head-search-wrap <?php $this->_c('head-search') ?>">
				<jdoc:include type="modules" name="<?php $this->_p('head-search') ?>" style="raw" />
			</div>
			<!-- //HEAD SEARCH -->
			<?php endif ?>

			<?php if ($headright): ?>
				<div class="headright">

					<?php if ($this->countModules('sidebar-2')) : ?>
						<button class="btn-sidebar hidden-hd <?php $this->_c('sidebar-2') ?>" style="display: none;"><i class="fa fa-ellipsis-v"></i></button>
					<?php endif; ?>

					<?php if ($this->countModules('languageswitcherload')) : ?>
						<!-- LANGUAGE SWITCHER -->
						<div class="languageswitcherload">
							<jdoc:include type="modules" name="<?php $this->_p('languageswitcherload') ?>" style="raw" />
						</div>
						<!-- //LANGUAGE SWITCHER -->
					<?php endif ?>
						
					<?php if ($this->countModules('head-cart')) : ?>
						<!-- HEAD CART -->
						<div class="head-cart <?php $this->_c('head-cart') ?>">
							<jdoc:include type="modules" name="<?php $this->_p('head-cart') ?>" style="raw" />
						</div>
						<!-- //HEAD CART -->
					<?php endif ?>

					<?php if ($this->countModules('head-search')) : ?>
						<!-- HEAD SEARCH -->
						<div class="head-search <?php $this->_c('head-search') ?>">
							<button type="button" class="btn btn-search" style="display: none;">
							  <i class="fa fa-search"></i>
							  <i class="fa fa-close"></i>
							</button>
						</div>
						<!-- //HEAD SEARCH -->
					<?php endif ?>

				</div>
			<?php endif ?>

		</div>
	</div>
</header>
<!-- //HEADER -->
