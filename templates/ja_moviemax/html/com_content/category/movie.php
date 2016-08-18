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

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers');
JHtml::addIncludePath(T3_PATH.'/html/com_content');
JHtml::addIncludePath(dirname(dirname(__FILE__)));
JHtml::_('behavior.caption');
?>

<div class="blog blog-movies <?php echo $this->pageclass_sfx;?>">
	<?php if ($this->params->get('show_page_heading', 1)) : ?>
	<div class="page-header clearfix">
		<h1 class="page-title"> <?php echo $this->escape($this->params->get('page_heading')); ?> </h1>
	</div>
	<?php endif; ?>
	<?php if ($this->params->get('show_category_title', 1) or $this->params->get('page_subheading')) : ?>
  	<div class="page-subheader clearfix">
  		<h2 class="page-subtitle"><?php echo $this->escape($this->params->get('page_subheading')); ?>
			<?php if ($this->params->get('show_category_title')) : ?>
			<small class="subheading-category"><?php echo $this->category->title;?></small>
			<?php endif; ?>
  		</h2>
	</div>
	<?php endif; ?>
	
	<?php if ($this->params->get('show_tags', 1) && !empty($this->category->tags->itemTags)) : ?>
		<?php echo JLayoutHelper::render('joomla.content.tags', $this->category->tags->itemTags); ?>
	<?php endif; ?>
	
	<?php if ($this->params->get('show_description', 1) || $this->params->def('show_description_image', 1)) : ?>
	<div class="category-desc clearfix">
		<?php if ($this->params->get('show_description_image') && $this->category->getParams()->get('image')) : ?>
			<img src="<?php echo $this->category->getParams()->get('image'); ?>"/>
		<?php endif; ?>
		<?php if ($this->params->get('show_description') && $this->category->description) : ?>
			<?php echo JHtml::_('content.prepare', $this->category->description, '', 'com_content.category'); ?>
		<?php endif; ?>
	</div>
	<?php endif; ?>

	<?php if (empty($this->lead_items) && empty($this->link_items) && empty($this->intro_items)) : ?>
		<?php if ($this->params->get('show_no_articles', 1)) : ?>
			<p><?php echo JText::_('COM_CONTENT_NO_ARTICLES'); ?></p>
		<?php endif; ?>
	<?php endif; ?>

	<?php $leadingcount = 0; ?>
	<?php if (!empty($this->lead_items)) : ?>
	<div class="items-leading"><div class="row equal-height">
		<div class="col col-sm-12 col-md-8 leading-main">
			<?php foreach ($this->lead_items as &$item) : ?>
			<div class="leading leading-<?php echo $leadingcount; ?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?>">
				<?php
					$this->item = &$item;
					echo $this->loadTemplate('item');
				?>
			</div>
			<?php break; ?>
			<?php endforeach; ?>
		</div>

		<div class="col col-sm-12 col-md-4 leading-sidebar">
			<?php 
			$ads_modules = 'leading-sidebar';
			$attrs = array();
			$result = null;
			$renderer = JFactory::getDocument()->loadRenderer('modules');
			$ads = $renderer->render($ads_modules, $attrs, $result);
			if ($ads) : ?>
			<div class="banner-sidebar">
				<?php echo $ads ?>
			</div>
			<?php endif; ?>

			<?php $leadingcount = 0; ?>
			<?php foreach ($this->lead_items as &$item) : ?>
			<?php if($leadingcount > 0) : ?>
			<div class="leading leading-<?php echo $leadingcount; ?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?>">
				<?php
					$this->item = &$item;
					echo $this->loadTemplate('item');
				?>
			</div>
			<?php endif; ?>
			<?php $leadingcount++; ?>
			<?php endforeach; ?>
		</div>
		
	</div></div><!-- end items-leading -->
	<?php endif; ?>
        <?php
           if($this->pagination->pagesCurrent != 1 && $this->params->get('show_pagination') == '2'){
                foreach($this->lead_items as $lkey => $lead_item){
                    $this->intro_items[] = $lead_item;
                }
           }
		  $introcount = (count($this->intro_items));
		  $counter = 0;
	   ?>

	<?php if (!empty($this->intro_items)) : ?>
    <div id="item-container">
	<?php foreach ($this->intro_items as $key => &$item) : ?>
		<?php $rowcount = ((int) $counter % (int) $this->columns) + 1; ?>
		<?php if ($rowcount == 1) : ?>
			<?php $row = $counter / $this->columns; ?>
		<div class="items-row cols-<?php echo (int) $this->columns;?>"><div class="equal-height equal-height-child <?php echo 'row-'.$row; ?> row">
		<?php endif; ?>
				<div class="item col col-sm-<?php echo round((12 / $this->columns));?> column-<?php echo $rowcount;?> <?php echo $item->state == 0 ? ' system-unpublished' : null; ?>">
					<?php
					$this->item = &$item;
					echo $this->loadTemplate('item');
				?>
				</div><!-- end item -->
				<?php $counter++; ?>
			<?php if (($rowcount == $this->columns) or ($counter == $introcount)) : ?>			
		</div></div>
        <!-- end row -->
			<?php endif; ?>
	<?php endforeach; ?>
    </div>
  <?php endif; ?>
  <?php echo JLayoutHelper::render('joomla.content.pagination', array('params'=>$this->params, 'pagination'=>$this->pagination)); ?>
</div>