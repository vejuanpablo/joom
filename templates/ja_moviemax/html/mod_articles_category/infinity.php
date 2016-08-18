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
$catids = $params->get('catid');
if(isset($catids) && $catids['0'] != '') {
  $catid = $catids[0];  
  $jacategoriesModel = JCategories::getInstance('content');
  $jacategory = $jacategoriesModel->get($catid);
}
$i=1;
?>
<div id="infinity-load<?php echo $module->id; ?>">Loading</div>
<ul id="mod-<?php echo $module->id; ?>" class="infinity-mod category-module category-module-default <?php echo $moduleclass_sfx; ?>">
	<?php if ($grouped) : ?>
		<?php foreach ($list as $group_name => $group) : ?>
		<li>
			<div class="mod-articles-category-group"><?php echo $group_name;?></div>
			<ul>
				<?php foreach ($group as $item) : ?>
					<li class="<?php echo $item->active; ?>">
						<?php if ($params->get('link_titles') == 1) : ?>
							<a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
								<?php echo $item->title; ?>
							</a>
						<?php else : ?>
							<?php echo $item->title; ?>
						<?php endif; ?>
	
						<?php if ($item->displayHits) : ?>
							<span class="mod-articles-category-hits">
								(<?php echo $item->displayHits; ?>)
							</span>
						<?php endif; ?>
	
						<?php if ($params->get('show_author')) : ?>
							<span class="mod-articles-category-writtenby">
								<?php echo $item->displayAuthorName; ?>
							</span>
						<?php endif;?>
	
						<?php if ($item->displayCategoryTitle) : ?>
							<span class="mod-articles-category-category">
								(<?php echo $item->displayCategoryTitle; ?>)
							</span>
						<?php endif; ?>
	
						<?php if ($item->displayDate) : ?>
							<span class="mod-articles-category-date"><?php echo $item->displayDate; ?></span>
						<?php endif; ?>
	
						<?php if ($params->get('show_introtext')) : ?>
							<p class="mod-articles-category-introtext">
								<?php echo $item->displayIntrotext; ?>
							</p>
						<?php endif; ?>
	
						<?php if ($params->get('show_readmore')) : ?>
							<p class="mod-articles-category-readmore">
								<a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
									<?php if ($item->params->get('access-view') == false) : ?>
										<?php echo JText::_('MOD_ARTICLES_CATEGORY_REGISTER_TO_READ_MORE'); ?>
									<?php elseif ($readmore = $item->alternative_readmore) : ?>
										<?php echo $readmore; ?>
										<?php echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
											<?php if ($params->get('show_readmore_title', 0) != 0) : ?>
												<?php echo JHtml::_('string.truncate', ($this->item->title), $params->get('readmore_limit')); ?>
											<?php endif; ?>
									<?php elseif ($params->get('show_readmore_title', 0) == 0) : ?>
										<?php echo JText::sprintf('MOD_ARTICLES_CATEGORY_READ_MORE_TITLE'); ?>
									<?php else : ?>
										<?php echo JText::_('MOD_ARTICLES_CATEGORY_READ_MORE'); ?>
										<?php echo JHtml::_('string.truncate', ($item->title), $params->get('readmore_limit')); ?>
									<?php endif; ?>
								</a>
							</p>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</li>
		<?php endforeach; ?>
	<?php else : ?>
		<?php foreach ($list as $item) : ?>
			<li class="page-<?php $max = ceil($i/5); echo $max; ?> <?php echo $item->active; ?>" style="<?php if ($i>5) echo 'display:none;'; ;$i++; ?>">
        <?php echo JLayoutHelper::render('joomla.content.intro_image', $item); ?>

        <div class="article-intro">
  				<?php if ($params->get('link_titles') == 1) : ?>
  					<a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
  						<?php echo $item->title; ?>
  					</a>
  				<?php else : ?>
  					<?php echo $item->title; ?>
  				<?php endif; ?>
  	
  				<?php if ($item->displayHits) : ?>
  					<span class="mod-articles-category-hits">
  						(<?php echo $item->displayHits; ?>)
  					</span>
  				<?php endif; ?>
  	
  				<?php if ($params->get('show_author')) : ?>
  					<span class="mod-articles-category-writtenby">
  						<?php echo $item->displayAuthorName; ?>
  					</span>
  				<?php endif;?>
  	
  				<?php if ($item->displayCategoryTitle) : ?>
  					<span class="mod-articles-category-category">
  						(<?php echo $item->displayCategoryTitle; ?>)
  					</span>
  				<?php endif; ?>
  	
  				<?php if ($item->displayDate) : ?>
  					<span class="mod-articles-category-date">
  						<?php echo $item->displayDate; ?>
  					</span>
  				<?php endif; ?>
  	
  				<?php if ($params->get('show_introtext')) : ?>
  					<p class="mod-articles-category-introtext">
  						<?php echo $item->displayIntrotext; ?>
  					</p>
  				<?php endif; ?>
  	
  				<?php if ($params->get('show_readmore')) : ?>
  					<p class="mod-articles-category-readmore">
  						<a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
  							<?php if ($item->params->get('access-view') == false) : ?>
  								<?php echo JText::_('MOD_ARTICLES_CATEGORY_REGISTER_TO_READ_MORE'); ?>
  							<?php elseif ($readmore = $item->alternative_readmore) : ?>
  								<?php echo $readmore; ?>
  								<?php echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
  							<?php elseif ($params->get('show_readmore_title', 0) == 0) : ?>
  								<?php echo JText::sprintf('MOD_ARTICLES_CATEGORY_READ_MORE_TITLE'); ?>
  							<?php else : ?>
  								<?php echo JText::_('MOD_ARTICLES_CATEGORY_READ_MORE'); ?>
  								<?php echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
  							<?php endif; ?>
  						</a>
  					</p>
  				<?php endif; ?>
        </div>
			</li>
		<?php endforeach; ?>
	<?php endif; ?>
  <li class="actions">
    <a class="btn btn-block btn-inverse lastest-button-paginate" data-current="1" data-module="mod-<?php echo $module->id; ?>" data-max="<?php echo $max; ?>"><?php echo JText::_('TPL_VIEW_MORE_INFO'); ?></a>
  </li>
</ul>

<script type="text/javascript">
// mod article category infinity view.
jQuery(window).load(function(){
	jQuery('#infinity-load<?php echo $module->id; ?>').hide();
});
jQuery(document).ready(function() {
	jQuery('.infinity-mod .lastest-button-paginate').click(function() {
		current = parseInt(jQuery(this).data('current'))+1;
		jQuery(this).data('current', current);
		jQuery('ul#'+jQuery(this).data('module')+' li.page-'+(current)).show();
		jQuery(this).parents('.ja-tab-panels-top').height(jQuery(this).parents('.ja-tab-content').height());
		if (current >= parseInt(jQuery(this).data('max'))) {jQuery(this).attr('disabled', '');return;}
	});
});
</script>