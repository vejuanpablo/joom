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
$params  = $displayData['params'];
$item  = $displayData['item'];

$images = json_decode($item->images);
if (empty($images->image_fulltext)) return ;

$imgfloat = (empty($images->float_fulltext)) ? $params->get('float_fulltext') : $images->float_fulltext;
?>

<div class="pull-<?php echo htmlspecialchars($imgfloat); ?> item-image article-image article-image-full">
	<span itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
	<img
		<?php if ($images->image_fulltext_caption): ?>
			<?php echo 'class="caption"' . ' title="' . htmlspecialchars($images->image_fulltext_caption) . '"'; ?>
		<?php endif; ?>
		src="<?php echo htmlspecialchars($images->image_fulltext); ?>"
		alt="<?php echo htmlspecialchars($images->image_fulltext_alt); ?>" itemprop="url"/>
	<meta itemprop="height" content="auto" />
	<meta itemprop="width" content="auto" />
	</span>
</div>