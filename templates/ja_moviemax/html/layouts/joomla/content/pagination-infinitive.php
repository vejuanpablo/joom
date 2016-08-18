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

$params = $displayData['params'];
$pagination = $displayData['pagination'];
$mode = $params->def('pagination_type', 2) == 1 ? 'manual' : 'auto';
?>

<?php if($pagination->get('pages.total') > 1) :?> 
  <div id="infinity-next" class="btn btn-primary  hide" data-mode="<?php echo $mode ?>" data-pages="<?php echo $pagination->get('pages.total') ?>" data-finishedmsg="<?php echo JText::_('TPL_INFINITY_NO_MORE_ARTICLE');?>"><?php echo JText::_('TPL_INFINITY_MORE_ARTICLE')?></div>
<?php else:?>
  <div id="infinity-next" class="btn btn-primary  disabled" data-pages="1"><?php echo JText::_('TPL_INFINITY_NO_MORE_ARTICLE');?></div>
<?php endif;?>	
