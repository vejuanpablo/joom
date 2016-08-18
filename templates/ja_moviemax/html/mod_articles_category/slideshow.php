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
<div class="category-module article-slideshow owl-carousel owl-theme">

  <!-- Wrapper for slides -->
    <?php foreach ($list as $item) : ?>
      <div class="item">

        <?php echo JLayoutHelper::render('joomla.content.intro_image', $item); ?>
        <div class="article-container">
          <?php if ($item->displayCategoryTitle) : ?>
          <span class="category-name">
            <?php echo $item->displayCategoryTitle; ?>              
          </span>     
          <?php endif; ?>

          <header class="article-header clearfix">
            <h1 class="article-title">
              <?php if ($params->get('link_titles') == 1) : ?>
              <a title="<?php echo $item->title; ?>"  href="<?php echo $item->link; ?>">
              <?php endif; ?>
                <?php echo $item->title; ?>
              <?php if ($params->get('link_titles') == 1) : ?>
              </a>
              <?php endif; ?>
            </h1>
          </header>
  
          <?php if ($params->get('show_introtext')) : ?>
            <section class="article-intro clearfix">
              <?php echo $item->displayIntrotext; ?>
            </section>
          <?php endif; ?>

          <?php if ($params->get('show_readmore')) : ?>
            <p class="mod-articles-category-readmore">
              <a class="btn btn-inverse mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
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
                <time>
                    <i class="fa fa-clock-o"></i><?php echo JATemplateHelper::relTime($item->displayDate); ?>
                </time>
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
      </div>
    <?php endforeach; ?>

</div>

<script>
(function($){
  jQuery(document).ready(function($) {
    $(".article-slideshow").owlCarousel({
      items: 1,
      singleItem : true,
      itemsScaleUp : true,
      navigation : true,
      navigationText : ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
      pagination: true,
      merge: false,
      mergeFit: true,
      slideBy: 1,
      autoplay: true,
    });
  });
})(jQuery);
</script>
