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

$link = '';
if (isset($displayData['item'])) {
  $item = $displayData['item'];
  $itemparams = $item->params;
  $link = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid));
}


$params  = new JRegistry($displayData);
$image = $params->get('image');
$alt = $params->get('alt');
$caption = $params->get('caption');
$size = $params->get('size');

require_once (JPATH_ROOT . '/plugins/system/jacontenttype/helpers/image.php');

$img = JAContentTypeImageHelper::getImage($image, $size);
if ($caption) $caption = 'class="caption"' . ' title="' . htmlspecialchars($caption) . '"';
?>

<?php if ($img) : ?>
  <?php if ($link) : ?>
    <a href="<?php echo $link; ?>" itemprop="url">
  <?php endif ?>
    <span itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
	   <img <?php echo $caption ?>	src="<?php echo htmlspecialchars($img); ?>" alt="<?php echo htmlspecialchars($alt); ?>"  itemprop="url"/>
      <meta itemprop="height" content="auto" />
     <meta itemprop="width" content="auto" />
    </span>
  <?php if ($link) : ?>
    </a>
  <?php endif ?>
<?php endif; ?>
