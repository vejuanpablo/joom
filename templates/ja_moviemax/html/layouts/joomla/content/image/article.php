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
$item  = is_array($displayData) ? $displayData['item'] : $displayData;
$params  = $item->params;
$images = json_decode($item->images);
$imgfloat = (empty($images->float_intro)) ? $params->get('float_intro') : $images->float_intro;

$data = array();
$data['item'] = $item;
if (isset($images->image_intro) && !empty($images->image_intro)) {
	$data['image'] = $images->image_intro;
	$data['alt'] = $images->image_intro_alt;
	$data['caption'] = $images->image_intro_caption;	
}
if (is_array($displayData) && isset($displayData['img-size'])) $data['size'] = $displayData['img-size'];

?>
<?php if (isset($images->image_intro) && !empty($images->image_intro)) : ?>
<div class="pull-<?php echo htmlspecialchars($imgfloat); ?> item-image" itemprop="image">
<?php echo JLayoutHelper::render('joomla.content.image.image', $data); ?>
</div>
<?php endif ?>