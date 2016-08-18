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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.framework');

// Create a shortcut for params.
$params  = & $this->item->params;
$images  = json_decode($this->item->images);
$info    = $params->get('info_block_position', 2);
$aInfo1 = ($params->get('show_publish_date') || $params->get('show_category') || $params->get('show_parent_category') || $params->get('show_author'));
$aInfo2 = ($params->get('show_create_date') || $params->get('show_modify_date') || $params->get('show_hits'));
$topInfo = ($aInfo1 && $info != 1) || ($aInfo2 && $info == 0);
$botInfo = ($aInfo1 && $info == 1) || ($aInfo2 && $info != 0);
$icons = $params->get('access-edit') || $params->get('show_print_icon') || $params->get('show_email_icon');
$linkTitle = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid));


$ctm_attribs = new JRegistry ($this->item->attribs);
$ctm_article_style = $ctm_attribs->get('ctm_article_style', 'default');

// update catslug if not exists - compatible with 2.5
if (empty ($this->item->catslug)) {
  $this->item->catslug = $this->item->category_alias ? ($this->item->catid.':'.$this->item->category_alias) : $this->item->catid;
}
?>

<?php if ($this->item->state == 0 || strtotime($this->item->publish_up) > strtotime(JFactory::getDate())
|| ((strtotime($this->item->publish_down) < strtotime(JFactory::getDate())) && $this->item->publish_down != '0000-00-00 00:00:00' )) : ?>
<div class="system-unpublished">
<?php endif; ?>

	<!-- Article -->
	<article class="<?php echo $ctm_article_style; ?>">
		<div class="item-thumb">
			<div class="image-mask"></div>
			<?php echo JLayoutHelper::render('joomla.content.intro_image', $this->item); ?>

			<?php if ($params->get('show_category')) : ?>
				<?php echo JLayoutHelper::render('joomla.content.info_block.category',array('item' => $this->item, 'params' => $params)); ?>
			<?php endif; ?>
		</div>

		<a href="<?php echo $linkTitle; ?>" class="entry-link"></a>

  	<div class="item-content">
  		<!-- Override Rating Joomla -->
		<?php if ($params->get('show_vote')) : 
			$this->item->rating_percentage = 0;
	      if (isset($this->item->rating_sum) && $this->item->rating_count > 0) {
	        $this->item->rating = round($this->item->rating_sum / $this->item->rating_count, 1);
	        $this->item->rating_percentage = $this->item->rating_sum / $this->item->rating_count * 20;
	      } else {
	        if (!isset($this->item->rating)) $this->item->rating = 0;
	        if (!isset($this->item->rating_count)) $this->item->rating_count = 0;
	        $this->item->rating_percentage = $this->item->rating * 20;
	      }
	      $uri = JUri::getInstance();
	      
	      ?>
	      <div itemtype="http://schema.org/AggregateRating" itemscope itemprop="aggregateRating" class="rating-info pd-rating-info">
	        <form class="rating-form" method="POST" action="<?php echo htmlspecialchars($uri->toString()) ?>">
	          <ul class="rating-list">
	            <li class="rating-current" style="width:<?php echo $this->item->rating_percentage; ?>%;"></li>
	            <li><span title="<?php echo JText::_('JA_1_STAR_OUT_OF_5'); ?>" class="one-star"></span></li>
	            <li><span title="<?php echo JText::_('JA_2_STARS_OUT_OF_5'); ?>" class="two-stars"></span></li>
	            <li><span title="<?php echo JText::_('JA_3_STARS_OUT_OF_5'); ?>" class="three-stars"></span></li>
	            <li><span title="<?php echo JText::_('JA_4_STARS_OUT_OF_5'); ?>" class="four-stars"></span></li>
	            <li><span title="<?php echo JText::_('JA_5_STARS_OUT_OF_5'); ?>" class="five-stars"></span></li>
	          </ul>
	        </form>
	      </div>
	    <?php endif; ?>
	    <!-- //Override Rating Joomla -->

    <?php if ($params->get('show_title')) : ?>
			<?php echo JLayoutHelper::render('joomla.content.item_title', array('item' => $this->item, 'params' => $params, 'title-tag'=>'h2')); ?>
    <?php endif; ?>

    <!-- Aside -->
    <?php if ($topInfo) : ?>
    <aside class="article-aside clearfix">
      <?php if ($topInfo): ?>
      <?php echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $this->item, 'params' => $params, 'position' => 'above')); ?>
      <?php endif; ?>
    </aside>  
    <?php endif; ?>
    <!-- //Aside -->

		<section class="article-intro clearfix" itemprop="articleBody">
			<?php if (!$params->get('show_intro')) : ?>
				<?php echo $this->item->event->afterDisplayTitle; ?>
			<?php endif; ?>

			<?php echo $this->item->introtext; ?>
		</section>


		<?php if ($params->get('show_readmore') && $this->item->readmore) :
			if ($params->get('access-view')) :
				$link = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid));
			else :
				$menu      = JFactory::getApplication()->getMenu();
				$active    = $menu->getActive();
				$itemId    = $active->id;
				$link1     = JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId);
				$returnURL = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid));
				$link      = new JURI($link1);
				$link->setVar('return', base64_encode($returnURL));
			endif;
			?>
			<section class="readmore <?php if($params->get('show_readmore_title')) echo 'readmore-title'; ?>">
				<a class="btn btn-default" href="<?php echo $link; ?>">
					<span>
					<?php if (!$params->get('access-view')) :
						echo JText::_('COM_CONTENT_REGISTER_TO_READ_MORE');
					elseif ($readmore = $this->item->alternative_readmore) :
						echo $readmore;
						if ($params->get('show_readmore_title', 0) != 0) :
							echo JHtml::_('string.truncate', ($this->item->title), $params->get('readmore_limit'));
						endif;
					elseif ($params->get('show_readmore_title', 0) == 0) :
						echo JText::sprintf('COM_CONTENT_READ_MORE_TITLE');
					else :
						echo JText::_('COM_CONTENT_READ_MORE');
						echo JHtml::_('string.truncate', ($this->item->title), $params->get('readmore_limit'));
					endif; ?>
					</span>
				</a>
			</section>
		<?php endif; ?>

		<!-- footer -->
    <?php if ($botInfo || $icons) : ?>
    <footer class="article-footer clearfix">
      <?php echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $this->item, 'params' => $params, 'position' => 'below')); ?>

      <?php if ($icons): ?>
      <?php echo JLayoutHelper::render('joomla.content.icons', array('item' => $this->item, 'params' => $params)); ?>
      <?php endif; ?>
    </footer>
    <?php endif; ?>
    <!-- //footer -->
	</div>
	</article>
	<!-- //Article -->

<?php if ($this->item->state == 0 || strtotime($this->item->publish_up) > strtotime(JFactory::getDate())
|| ((strtotime($this->item->publish_down) < strtotime(JFactory::getDate())) && $this->item->publish_down != JFactory::getDbo()->getNullDate())) : ?>
</div>
<?php endif; ?>

<?php echo $this->item->event->afterDisplayContent; ?> 
