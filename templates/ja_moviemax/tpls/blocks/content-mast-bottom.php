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
?>

<?php if ($this->countModules('content-mast-bottom')) : ?>
	<!-- CONTENT MAST BOTTOM -->
	<div class="t3-content-mast-bottom <?php $this->_c('content-mast-bottom') ?>">
			<jdoc:include type="modules" name="<?php $this->_p('content-mast-bottom') ?>" />
	</div>
	<!-- //CONTENT MAST BOTTOM -->
<?php endif ?>