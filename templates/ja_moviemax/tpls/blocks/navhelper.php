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

<?php if ($this->countModules('navhelper')) : ?>
	<!-- NAV HELPER -->
	<nav class="t3-navhelper container-inner <?php $this->_c('navhelper') ?>">
			<jdoc:include type="modules" name="<?php $this->_p('navhelper') ?>" />
	</nav>
	<!-- //NAV HELPER -->
<?php endif ?>