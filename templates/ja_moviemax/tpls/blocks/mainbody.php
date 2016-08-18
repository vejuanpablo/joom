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

<?php

// positions configuration
$sidebar1 = 'sidebar-1';

$sidebar1 = $this->countModules($sidebar1) ? $sidebar1 : false;

// detect layout
if ($sidebar1) {
	$this->loadBlock('mainbody/one-sidebar-right', array('sidebar' => $sidebar1));
} else {
	$this->loadBlock('mainbody/no-sidebar');
}
