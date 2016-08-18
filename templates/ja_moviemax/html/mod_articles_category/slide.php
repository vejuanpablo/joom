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
JLoader::register('JATemplateHelper', T3_TEMPLATE_PATH . '/helper.php');

$modParams = new JRegistry($module->params);
$banner_pos = $modParams->get('module-position');
$banner_idx = (int) $modParams->get('display-order');

$col = $modParams->get('columns',4);
$count = $params->get('count',0);
$i = 0;

if ($banner_pos) {
	$banner = array($banner_idx=>$banner_pos);
	$list = ($banner_idx > 0 ? array_slice($list, 0, $banner_idx, true) : array()) + $banner + array_slice($list, $banner_idx, count($list)-$banner_idx, true);
	$count++;
}
$doc = JFactory::getDocument();
?>
<div class="category-module article-slide">

<?php foreach ($list as $item) : ?>
	<div class="item item-intro col">	
	<?php if (is_string($item)): ?>
		<?php echo $doc->getBuffer('modules', $item); ?>
	<?php else: ?>
		<article class="image"> 
			<?php echo JLayoutHelper::render('joomla.content.intro_image', $item); ?>

      <a title="<?php echo $item->title; ?>"  href="<?php echo $item->link; ?>" class="entry-link"></a>
      
			<?php if ($item->displayCategoryTitle) : ?>
			<span class="category-name">
				<?php echo $item->displayCategoryTitle; ?>							
			</span>			
			<?php endif; ?>

			<?php $multiples=5;  ?>
			<a class="rating-score rating-cell rating-score-<?php echo $multiples; ?>" href="<?php echo $item->link; ?>">
				<div class="score score-<?php echo $item->rating?$item->rating*($multiples/5):0;?>">
					<div class="score-inner">
	          <?php echo $item->rating?$item->rating*($multiples/5):0;?>
					</div>
				</div>
			</a>

			<div class="item-content">
				<header class="article-header clearfix">
					<h3 class="article-title">
						<?php if ($params->get('link_titles') == 1) : ?>
						<a title="<?php echo $item->title; ?>"  href="<?php echo $item->link; ?>">
						<?php endif; ?>
							<?php echo $item->title; ?>
						<?php if ($params->get('link_titles') == 1) : ?>
						</a>
						<?php endif; ?>
					</h3>
				</header>
	
				<?php if ($params->get('show_introtext')) : ?>
					<section class="article-intro clearfix">
						<?php echo $item->displayIntrotext; ?>
					</section>
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

				<aside class="article-aside clearfix">
          <?php if ($item->displayHits || $item->displayDate || $params->get('show_author')) : ?>
          <dl class="article-info  muted">
          	<dt class="article-info-term"></dt>

          	<?php if ($item->displayHits) : ?>
						<dd class="mod-articles-category-hits">
							<?php echo $item->displayHits; ?>
						</dd>
						<?php endif; ?>
      
						<?php if ($item->displayDate) : ?>
						<dd title="" class="published hasTooltip" data-original-title="Published: ">
							<i class="fa fa-clock-o"></i><time> <?php echo JATemplateHelper::relTime($item->displayDate); ?></time>
						</dd>
						<?php endif; ?>

						<?php if ($params->get('show_author')) : ?>
						<dd title="" class="author hasTooltip" data-original-title="Author: ">
							<?php echo $item->displayAuthorName; ?>
						</dd>
						<?php endif; ?>
					</dl>
          <?php endif; ?>
       </aside>
			</div>
		</article>
	<?php endif; ?>
	</div>
	<?php $i++; ?>
<?php endforeach; ?>
</div>

<script>
(function($) {
  $(document).ready(function() {

    $('html[dir="ltr"] .article-slide').slick({
        infinite: true,
        speed: 300,
        dots: true,
        adaptiveHeight: true,
        slidesToShow: <?php echo $col ?>,
        slidesToScroll: <?php echo $col ?>,
        responsive: [
        {
          breakpoint: 992,
          settings: {
            slidesToShow: 4,
            slidesToScroll: 4,
          }
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
      ]
    });

    $('html[dir="rtl"] .article-slide').slick({
        infinite: true,
        speed: 300,
        dots: true,
        adaptiveHeight: true,
        slidesToShow: <?php echo $col ?>,
        slidesToScroll: <?php echo $col ?>,
        rtl: true,
        responsive: [
        {
          breakpoint: 992,
          settings: {
            slidesToShow: 4,
            slidesToScroll: 4,
          }
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }        
      ]
    });

  });

})(jQuery);
</script>

