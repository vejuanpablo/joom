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
<ul class="mostread<?php echo $moduleclass_sfx; ?>">
<?php foreach ($list as $item) : ?>
	<li class="clearfix">
		<?php echo JLayoutHelper::render('joomla.content.intro_image', $item); ?>

		<div class="content-item">
			<span><?php echo $item->category_title; ?></span>
			<a class="title" href="<?php echo $item->link; ?>">
				<?php echo $item->title; ?>
			</a>
			<span><i class="fa fa-eye"></i> <?php echo $item->hits; ?></span>
		</div>
	</li>
<?php endforeach; ?>
</ul>
