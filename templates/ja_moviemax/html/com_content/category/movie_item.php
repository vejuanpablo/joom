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

$ctm_attribs = new JRegistry ($this->item->attribs);
$ctm_article_style = $ctm_attribs->get('ctm_article_style', 'image');

// update catslug if not exists - compatible with 2.5
if (empty ($this->item->catslug)) {
  $this->item->catslug = $this->item->category_alias ? ($this->item->catid.':'.$this->item->category_alias) : $this->item->catid;
}

$url = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catslug));
?>

<?php if ($this->item->state == 0 || strtotime($this->item->publish_up) > strtotime(JFactory::getDate())
|| ((strtotime($this->item->publish_down) < strtotime(JFactory::getDate())) && $this->item->publish_down != '0000-00-00 00:00:00' )) : ?>
<div class="system-unpublished">
<?php endif; ?>

	<!-- Article -->
	<article class="image">
    <?php echo JLayoutHelper::render('joomla.content.intro_image', $this->item); ?>

    <!-- Aside -->
    <?php if ($topInfo) : ?>
    <aside class="article-aside clearfix">
      
      <?php echo $this->item->event->beforeDisplayContent; ?> 

      <?php if ($params->get('show_hits')) : ?>
        <dd class="hits">
          <i class="fa fa-eye"></i>
          <?php echo JText::sprintf('TPL_MOVIES_COM_CONTENT_ARTICLE_HITS', $this->item->hits); ?>
        </dd>
      <?php endif; ?>

      <?php if ($params->get('show_vote')) : ?>
        <?php $multiples=5; ?>
        <dd class="votes">
          <i class="fa fa-star"></i>
          <div class="rating-score rating-cell rating-score-<?php echo $multiples; ?>">
              <?php echo $this->item->rating?$this->item->rating*($multiples/5):0;?>
          </div>
        </dd>
       <?php endif; ?>

    </aside>  
    <?php endif; ?>
    <!-- //Aside -->

    <div class="item-content">
    
    <?php if ($params->get('show_title')) : ?>
      <?php echo JLayoutHelper::render('joomla.content.item_title', array('item' => $this->item, 'params' => $params, 'title-tag'=>'h2')); ?>
    <?php endif; ?>

    <?php echo JLayoutHelper::render('joomla.content.info_block.block-movie', array('item' => $this->item, 'params' => $params, 'position' => 'above')); ?>

    <?php if ($params->get('show_intro')) : ?>
		<section class="article-intro clearfix">
			
			<?php echo $this->item->event->afterDisplayTitle; ?>
			
			<?php 
        $this->item->introtext = substr(strip_tags($this->item->introtext), 0, 200);
        $this->item->introtext = substr($this->item->introtext, 0, strrpos($this->item->introtext, ' ')) . " ...";
        echo $this->item->introtext;
      ?>
		</section>
    <?php endif; ?>

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
						echo JText::sprintf('TPL_COM_CONTENT_READ_MORE_TITLE');
					else :
						echo JText::_('COM_CONTENT_READ_MORE');
						echo JHtml::_('string.truncate', ($this->item->title), $params->get('readmore_limit'));
					endif; ?>
					</span>
				</a>
			</section>
		<?php endif; ?>
    </div>
	</article>
	<!-- //Article -->

<?php if ($this->item->state == 0 || strtotime($this->item->publish_up) > strtotime(JFactory::getDate())
|| ((strtotime($this->item->publish_down) < strtotime(JFactory::getDate())) && $this->item->publish_down != JFactory::getDbo()->getNullDate())) : ?>
</div>
<?php endif; ?>

<?php echo $this->item->event->afterDisplayContent; ?> 
