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

$extrafields = new JRegistry ($this->item->attribs);
$jcontent_director = $extrafields->get('jcontent_director', '');
$jcontent_starring = $extrafields->get('jcontent_starring', '');
$jcontent_trailer = $extrafields->get('jcontent_trailer', '');
$jcontent_year = $extrafields->get('jcontent_year', '');
$extrafieldsexist = ($jcontent_director!= '' || $jcontent_starring != '' || $jcontent_trailer != '' || $jcontent_year != '');

JHtml::_('behavior.caption');
JHtml::_('bootstrap.tooltip');
?>

<div class="item-page movie-page<?php echo $this->pageclass_sfx ?> clearfix">

<?php if (!empty($this->item->pagination) && $this->item->pagination && !$this->item->paginationposition && $this->item->paginationrelative) : ?>
	<?php echo $this->item->pagination; ?>
<?php endif; ?>

<!-- Article -->
<article class="article row" itemscope itemtype="http://schema.org/Movie">
	<meta itemprop="inLanguage" content="<?php echo ($this->item->language === '*') ? JFactory::getConfig()->get('language') : $this->item->language; ?>" />

	<div class="col-sm-4 article-sidebar">
	<?php	if ($params->get('access-view')): ?>
		<?php echo JLayoutHelper::render('joomla.content.fulltext_image', array('item' => $this->item, 'params' => $params)); ?>
	<?php endif; ?>

	<!-- Aside -->
	<?php if ($topInfo || $this->print) : ?>
	<aside class="article-aside clearfix">

    <?php echo $this->item->event->beforeDisplayContent; ?>
    
	  <?php if ($topInfo): ?>
	  	<?php if ($params->get('show_hits')) : ?>
        <dd class="hits">
          <i class="fa fa-eye"></i>
          <meta itemprop="interactionCount" content="UserPageVisits:<?php echo $this->item->hits; ?>" />
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
    <?php endif; ?>

	  <?php if(!empty($this->print)) : 
	  	echo JHtml::_('icon.print_screen', $this->item, $params); 
	  	endif; 
	  ?>

	</aside>  
	<?php endif; ?>
	<!-- //Aside -->

  <?php if($extrafieldsexist) { ?>
  <div class="extrafileds-list">
    <dl>
    <?php 
      if($jcontent_director) echo '<dd itemtype="http://schema.org/Person" itemscope itemprop="director" ><span>'.JText::_('TPL_DIRECTOR').': </span><span itemprop="name">'.$jcontent_director.'</span></dd>';
      if($jcontent_starring) echo '<dd itemtype="http://schema.org/Person" itemscope itemprop="actor"><span>'.JText::_('TPL_STARRING').': </span><span itemprop="name">'.$jcontent_starring.'</span></dd>';
      if($jcontent_year) echo '<dd><span>'.JText::_('TPL_YEAR').': </span>'.$jcontent_year.'</dd>';
      if($jcontent_trailer) echo '<dd><a href="'.$jcontent_trailer.'" class="btn btn-block btn-primary" target="_blank">'.JText::_('TPL_TRAILER').'</a></dd>';
    ?>
    </dl>
  </div>
  <?php } ?>

	<!-- Show voting form -->
  <?php	if ($params->get('show_vote')): ?>
    <?php
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
    <div id="rating-info" class="rating-info pd-rating-info">
      <span><?php echo JText::_('PLG_VOTE_LABEL'); ?>: </span>
      <form class="rating-form" method="POST" action="<?php echo htmlspecialchars($uri->toString()) ?>">
          <ul class="rating-list">
              <li class="rating-current" style="width:<?php echo $this->item->rating_percentage; ?>%;"></li>
              <li><a href="javascript:void(0)" title="<?php echo JText::_('JA_1_STAR_OUT_OF_5'); ?>" class="one-star">1</a></li>
              <li><a href="javascript:void(0)" title="<?php echo JText::_('JA_2_STARS_OUT_OF_5'); ?>" class="two-stars">2</a></li>
              <li><a href="javascript:void(0)" title="<?php echo JText::_('JA_3_STARS_OUT_OF_5'); ?>" class="three-stars">3</a></li>
              <li><a href="javascript:void(0)" title="<?php echo JText::_('JA_4_STARS_OUT_OF_5'); ?>" class="four-stars">4</a></li>
              <li><a href="javascript:void(0)" title="<?php echo JText::_('JA_5_STARS_OUT_OF_5'); ?>" class="five-stars">5</a></li>
          </ul>
          <div class="rating-log">(<span><?php echo $this->item->rating ?></span> / <span><?php echo $this->item->rating_count; ?></span> votes)</div>
          <input type="hidden" name="task" value="article.vote" />
          <input type="hidden" name="hitcount" value="0" />
          <input type="hidden" name="user_rating" value="5" />
          <input type="hidden" name="url" value="<?php echo htmlspecialchars($uri->toString()) ?>" />
          <?php echo JHtml::_('form.token') ?>
      </form>
    </div>
    <!-- //Rating -->

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
  <?php endif;?>
  <!-- End showing -->
	</div>

	<div class="col-sm-8 item-content">
  	<?php if ($params->get('show_title')) : ?>
  		<?php echo JLayoutHelper::render('joomla.content.item_title', array('item' => $this->item, 'params' => $params, 'title-tag'=>'h1')); ?>
  	<?php endif; ?>
  	<?php echo $this->item->event->afterDisplayTitle; ?>
		<div class="item-main">

			<div class="article-content-main">
				<?php if (isset ($this->item->toc)) : ?>
					<?php echo $this->item->toc; ?>
				<?php endif; ?>

				<?php if (isset($urls) && ((!empty($urls->urls_position) && ($urls->urls_position == '0')) || ($params->get('urls_position') == '0' && empty($urls->urls_position))) || (empty($urls->urls_position) && (!$params->get('urls_position')))): ?>
					<?php echo $this->loadTemplate('links'); ?>
				<?php endif; ?>

				<?php	if ($params->get('access-view')): ?>

				<?php	if (!empty($this->item->pagination) AND $this->item->pagination AND !$this->item->paginationposition AND !$this->item->paginationrelative):
					echo $this->item->pagination;
				endif; ?>

				<section class="article-content clearfix" itemprop="description">
					<?php echo $this->item->text; ?>
				</section>

				<?php if ($params->get('show_tags', 1) && !empty($this->item->tags)) : ?>
					<?php echo JLayoutHelper::render('joomla.content.tags', $this->item->tags->itemTags); ?>
				<?php endif; ?>

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
	</div>
</article>
<!-- //Article -->

<?php if (!empty($this->item->pagination) && $this->item->pagination && $this->item->paginationposition && $this->item->paginationrelative): ?>
	<?php echo $this->item->pagination; ?>
<?php endif; ?>

<?php echo $this->item->event->afterDisplayContent; ?>


</div>