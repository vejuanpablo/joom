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

/**
 * Mainbody 2 columns: sidebar - content
 */
?>
<div id="t3-mainbody" class="container-inner t3-mainbody one-sidebar-right">
	<div class="row equal-height">

		<!-- MAIN CONTENT -->
		<div id="t3-content" class="t3-content col col-xs-12 col-md-8">
			<?php if($this->hasMessage()) : ?>
			<jdoc:include type="message" />
			<?php endif ?>
			<jdoc:include type="component" />
		</div>
		<!-- //MAIN CONTENT -->

		<!-- SIDEBAR RIGHT -->
		<div class="t3-sidebar t3-sidebar-right col col-xs-12 col-sm-4 hidden-sm hidden-xs <?php $this->_c($vars['sidebar']) ?>">
			<jdoc:include type="modules" name="<?php $this->_p($vars['sidebar']) ?>" style="T3Xhtml" />
		</div>
		<!-- //SIDEBAR RIGHT -->

	</div>
</div> 