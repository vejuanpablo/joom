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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
JHtml::addIncludePath(T3_PATH . '/html/com_content');
JHtml::addIncludePath(dirname(dirname(__FILE__)));

// Create shortcuts to some parameters.
$params   = $this->item->params;
$images   = json_decode($this->item->images);
$urls     = json_decode($this->item->urls);
$canEdit  = $params->get('access-edit');
$user     = JFactory::getUser();
$info    = $params->get('info_block_position', 2);
$aInfo1 = ($params->get('show_publish_date') || $params->get('show_category') || $params->get('show_parent_category') || $params->get('show_author'));
$aInfo2 = ($params->get('show_create_date') || $params->get('show_modify_date') || $params->get('show_hits'));
$topInfo = ($aInfo1 && $info != 1) || ($aInfo2 && $info == 0);
$botInfo = ($aInfo1 && $info == 1) || ($aInfo2 && $info != 0);
$icons = !empty($this->print) || $canEdit || $params->get('show_print_icon') || $params->get('show_email_icon');

$tplparams = JFactory::getApplication()->getTemplate(true)->params;

JHtml::_('behavior.caption');
JHtml::_('bootstrap.tooltip');
?>

<?php if ($this->params->get('show_page_heading', 1)) : ?>
	<div class="page-header clearfix">
		<h1 class="page-title"><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
	</div>
<?php endif; ?>

<div class="item-page<?php echo $this->pageclass_sfx ?> clearfix <?php if ($this->params->get('show_page_heading', 1)) : ?>has-page-header<?php endif; ?>">

<?php if (!empty($this->item->pagination) && $this->item->pagination && !$this->item->paginationposition && $this->item->paginationrelative) : ?>
	<?php echo $this->item->pagination; ?>
<?php endif; ?>

<!-- Article -->
<article class="article" itemscope itemtype="http://schema.org/Article">
<meta itemscope itemprop="mainEntityOfPage"  itemType="https://schema.org/WebPage" itemid="https://google.com/article"/>
	<meta itemprop="inLanguage" content="<?php echo ($this->item->language === '*') ? JFactory::getConfig()->get('language') : $this->item->language; ?>" />
	<meta itemprop="url" content="<?php echo $this->item->readmore_link ;?>" />
	<div class="row">
		<div class="col-sm-offset-2 col-sm-8">
			<?php if ($params->get('show_category')) : ?>
				<?php echo JLayoutHelper::render('joomla.content.info_block.category',array('item' => $this->item, 'params' => $params)); ?>
			<?php endif; ?>

			<?php if ($params->get('show_title')) : ?>
				<?php echo JLayoutHelper::render('joomla.content.item_title', array('item' => $this->item, 'params' => $params, 'title-tag'=>'h1')); ?>
			<?php endif; ?>

			<!-- Aside -->
			<?php if ($topInfo || $icons) : ?>
			<aside class="article-aside clearfix">
			  <?php if ($topInfo): ?>
			  	<?php echo JLayoutHelper::render('joomla.content.info_block.block-media', array('item' => $this->item, 'params' => $params, 'position' => 'above')); ?>
			  <?php endif; ?>
			  
			  <?php if ($icons): ?>
			  	<?php echo JLayoutHelper::render('joomla.content.icons', array('item' => $this->item, 'params' => $params, 'print' => $this->print)); ?>
			  <?php endif; ?>
			  
				<?php echo $this->item->event->afterDisplayTitle; ?>
				
			</aside>  
			<?php endif; ?>
			<!-- //Aside -->

			<!-- Intro text -->
			<?php if (isset ($this->item->introtext)) : ?>
				<div class="intro-text">
					<?php echo $this->item->introtext; ?>
				</div>
				<?php endif; ?>
			<!-- // Intro text -->
		</div>
	</div>
	<div class="item-content row">
		<?php
			$attribs = new JRegistry ($this->item->attribs);
			$content_type = $attribs->get('ctm_content_type', 'article'); 
		?>

		<?php if (($content_type=='video' && $params->get('access-view')) || ($content_type=='gallery' && $params->get('access-view'))): ?>
		<div class="item-media col-sm-offset-1 col-sm-10">
			<?php if ($content_type=='video' && $params->get('access-view') ): ?>
			<div id="ja-main-player" class="embed-responsive embed-responsive-16by9" itemprop="video">
				<div id="videoplayer">
				  <?php echo JLayoutHelper::render('joomla.content.video_play', array('item' => $this->item, 'context' => 'featured')); ?>
				</div>
			</div>
			
			<?php elseif ($content_type=='gallery' && $params->get('access-view')): ?>
			  <div itemtype="http://schema.org/VideoObject" itemscope="" itemprop="gallery" class="ja-gallery-list-wrap">
			    <?php echo JLayoutHelper::render('joomla.content.gallery_play', $this->item); ?>
			  </div>
			<?php endif; ?>
		</div>
		<?php endif; ?>

		<?php	if ($params->get('access-view') && $content_type!='video' & $content_type!='gallery'): ?>
			<div class="item-image col-sm-offset-1 col-sm-10">
				<?php echo JLayoutHelper::render('joomla.content.fulltext_image', array('item' => $this->item, 'params' => $params)); ?>
			</div>
		<?php endif; ?>

		<div class="item-main col-sm-offset-2 col-sm-8">

			<div class="article-content-main">
				<?php if (isset ($this->item->toc)) : ?>
					<?php echo $this->item->toc; ?>
				<?php endif; ?>

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
			            <li><a href="#" title="<?php echo JText::_('JA_1_STAR_OUT_OF_5'); ?>" class="one-star">1</a></li>
			            <li><a href="#" title="<?php echo JText::_('JA_2_STARS_OUT_OF_5'); ?>" class="two-stars">2</a></li>
			            <li><a href="#" title="<?php echo JText::_('JA_3_STARS_OUT_OF_5'); ?>" class="three-stars">3</a></li>
			            <li><a href="#" title="<?php echo JText::_('JA_4_STARS_OUT_OF_5'); ?>" class="four-stars">4</a></li>
			            <li><a href="#" title="<?php echo JText::_('JA_5_STARS_OUT_OF_5'); ?>" class="five-stars">5</a></li>
			          </ul>
			          <div class="rating-log">(<meta itemprop="bestRating" content="5" />
			          	<span itemprop="ratingValue"><?php echo $this->item->rating ?></span> / <span itemprop="ratingCount"><meta itemprop="worstRating" content="<?php echo $this->item->rating_count; ?>" /><?php echo $this->item->rating_count; ?></span> votes)
			          </div>
			          <input type="hidden" name="task" value="article.vote" />
			          <input type="hidden" name="hitcount" value="0" />
			          <input type="hidden" name="user_rating" value="5" />
			          <input type="hidden" name="url" value="<?php echo htmlspecialchars($uri->toString()) ?>" />
			          <?php echo JHtml::_('form.token') ?>
			        </form>
			      </div>
			      
			      <script type="text/javascript">
			        !function($){
			          $('.rating-form').each(function(){
			            var form = this;
			            $(this).find('.rating-list li a').click(function(event){
			              event.preventDefault();
			              form.user_rating.value = this.innerHTML;
			              form.submit();
			            });
			          });
			        }(window.jQuery);
			      </script>
			    <?php endif; ?>
			    <!-- //Override Rating Joomla -->

				<?php if (isset($urls) && ((!empty($urls->urls_position) && ($urls->urls_position == '0')) || ($params->get('urls_position') == '0' && empty($urls->urls_position))) || (empty($urls->urls_position) && (!$params->get('urls_position')))): ?>
					<?php echo $this->loadTemplate('links'); ?>
				<?php endif; ?>

				<?php	if ($params->get('access-view')): ?>

				<?php	if (!empty($this->item->pagination) AND $this->item->pagination AND !$this->item->paginationposition AND !$this->item->paginationrelative):
					echo $this->item->pagination;
				endif; ?>

				<section class="article-content clearfix" itemprop="articleBody">
					<?php if (isset ($this->item->toc)) : ?>
						<?php 
						echo str_replace(
							trim(strip_tags($this->item->introtext))
						, '', $this->item->text); ?>
					<?php else : ?>
						<?php echo $this->item->fulltext; ?>
					<?php endif ;?>
				</section>

				<?php if ($params->get('show_tags', 1) && !empty($this->item->tags)) : ?>
					<?php echo JLayoutHelper::render('joomla.content.tags', $this->item->tags->itemTags); ?>
				<?php endif; ?>

				<!-- footer -->
				<?php if ($botInfo) : ?>
				<footer class="article-footer clearfix">
				<?php echo JLayoutHelper::render('joomla.content.info_block.block-media', array('item' => $this->item, 'params' => $params, 'position' => 'below')); ?>
				</footer>
				<?php endif; ?>
				<!-- //footer -->

				<?php
				if (!empty($this->item->pagination) && $this->item->pagination && $this->item->paginationposition && !$this->item->paginationrelative): ?>
					<?php
					echo $this->item->pagination;
					?>
				<?php endif; ?>

				<?php if (isset($urls) && ((!empty($urls->urls_position) && ($urls->urls_position == '1')) || ($params->get('urls_position') == '1'))): ?>
					<?php echo $this->loadTemplate('links'); ?>
				<?php endif; ?>

				<?php //optional teaser intro text for guests ?>
				<?php elseif ($params->get('show_noauth') == true and  $user->get('guest')) : ?>

					<?php echo $this->item->introtext; ?>
					<?php //Optional link to let them register to see the whole article. ?>
					<?php if ($params->get('show_readmore') && $this->item->fulltext != null) :
						$link1 = JRoute::_('index.php?option=com_users&view=login');
						$link = new JURI($link1);
						?>
						<section class="readmore">
							<a href="<?php echo $link; ?>" itemprop="url">
										<span>
										<?php $attribs = json_decode($this->item->attribs); ?>
										<?php
										if ($attribs->alternative_readmore == null) :
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
				<?php endif; ?>
			</div>
		</div>
	</div> <!-- //Row -->
</article>
<!-- //Article -->

<?php if (!empty($this->item->pagination) && $this->item->pagination && $this->item->paginationposition && $this->item->paginationrelative): ?>
	<?php echo $this->item->pagination; ?>
<?php endif; ?>

<?php echo $this->item->event->afterDisplayContent; ?>


</div>