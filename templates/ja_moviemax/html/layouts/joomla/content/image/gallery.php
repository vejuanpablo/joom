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
$item  			= $displayData;
$context		= '';
$params  		= @ json_decode($item->attribs, true);
$desc 			= '';
$thumbnail = '';

if (!isset($params['ctm_gallery'])) return;
$gallery = $params['ctm_gallery'];
if(is_array($gallery) && isset($gallery['src'])) {
	$thumbnail = $gallery['src'][0];
	$desc = $gallery['caption'][0];

	if(count($gallery['src']) > 1) {
		if(!defined('TELINE_GALLERY_LIST_PLAY')) {
			define('TELINE_GALLERY_LIST_PLAY', 1);
			$doc = JFactory::getDocument();
			JHtml::_('jquery.framework');
			$path = JUri::root(true).'/templates/ja_moviemax/js/gallery/';
			$doc->addStyleSheet($path.'blueimp-gallery.min.css');
			$doc->addStyleSheet($path.'bootstrap-image-gallery.css');
			$doc->addScript($path.'jquery.blueimp-gallery.min.js');
			$doc->addScript($path.'bootstrap-image-gallery.min.js');

			$galleryMarkup = JLayoutHelper::render('blueimp.gallery');
			$galleryMarkup = preg_replace('/[\r\n]+/', '', $galleryMarkup);
			$script = "
			(function ($) {
				$(document).ready(function(){
					$('body').append('".addslashes($galleryMarkup)."');
				});
			})(jQuery);
			";
			$doc->addScriptDeclaration($script);
		}
	}
}
if(!$thumbnail) {
	$images = json_decode($item->images);
	$thumbnail = @$images->image_intro;
}
if($context == 'icon') {
	$galleryId = 'ja-gallery-icon-'.$item->id;
} else {
	$galleryId = 'ja-gallery-list-'.$item->id;
}

// data to show image
$data = array();
if (is_array($displayData) && isset($displayData['img-size'])) $data['size'] = $displayData['img-size'];

if (isset($thumbnail) && !empty($thumbnail)) {
	$data['image'] = $thumbnail;
	$data['alt'] = $item->title;
	$data['caption'] = $desc;
}
?>
<?php if($context == 'icon'): ?>
	<?php if (isset($thumbnail) && !empty($thumbnail)) : ?>
		<div id="<?php echo $galleryId; ?>" class="btn-fullscreen">
			<span class="fa fa-expand fa-2x" title="<?php echo htmlspecialchars(JText::_('TPL_VIEW_FULL_SCREEN')); ?>"></span>
			<?php
				$images = array();
				foreach($gallery['src'] as $index => $src) {
					$img = new stdClass();
					$img->href = JUri::root(true).'/'.$src;
					$img->title = $gallery['caption'][$index];
					$images[] = $img;
				}
				?>
				<script type="text/javascript">
					(function ($) {
						$(document).ready(function(){
							$('#<?php echo $galleryId; ?>').on('click', function (event) {
								event.preventDefault();
								blueimp.Gallery(<?php echo json_encode($images); ?>, {
									transitionSpeed: 0,
									hidePageScrollbars:false
								});
							});
						});
					})(jQuery);
				</script>
		</div>
	<?php endif; ?>
<?php else: ?>
	<?php if (isset($thumbnail) && !empty($thumbnail)) : ?>
		<div id="<?php echo $galleryId; ?>" class="item-image ja-gallery-list">
			<?php if(is_array($gallery) && count($gallery['src']) > 1): ?>
			<span class="btn-play hasTooltip" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo JText::sprintf('TPL_NUMBER_PHOTOS_OF_SLIDESHOW', count($gallery['src'])); ?>">
				<span class="num-photos"  > <i class="fa fa-clone"></i></span>
			</span>
			<span class="gallery-mask"></span>
			<?php endif; ?>
			<?php echo JLayoutHelper::render('joomla.content.image.image', $data); ?>

			<?php if(is_array($gallery) && count($gallery['src']) > 1):
				$images = array();
				foreach($gallery['src'] as $index => $src) {
					$img = new stdClass();
					$img->href = JUri::root(true).'/'.$src;
					$img->title = $gallery['caption'][$index];
					$images[] = $img;
				}
				?>
				<script type="text/javascript">
					(function ($) {
						$(document).ready(function(){
							$('#<?php echo $galleryId; ?> .btn-play').on('click', function (event) {
								event.preventDefault();
								blueimp.Gallery(<?php echo json_encode($images); ?>, {
									transitionSpeed: 0,
									hidePageScrollbars:false
								});
							});
						});
					})(jQuery);
				</script>
			<?php endif; ?>
		</div>
	<?php endif; ?>
<?php endif; ?>
