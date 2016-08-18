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

$item 				= $displayData['item'];
$context 			= $displayData['context'];
$params  		  = new JRegistry($item->attribs);

$ctm_source 	= $params->get('ctm_source', 'youtube');
$ctm_thumbnail 	= $params->get('ctm_thumbnail', '');
$width 				= (int) $params->get('ctm_width', 680);
$height		 		= (int) $params->get('ctm_height', 383);

if (empty ($item->catslug)) {
  $item->catslug = $item->category_alias ? ($item->catid.':'.$item->category_alias) : $item->catid;
}
$articleUrl = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug));
$categoryUrl = JRoute::_(ContentHelperRoute::getCategoryRoute($item->catslug));
if($context == 'iframe') {
	//update to get full with, height

	JHtml::_('jquery.framework');
	$doc = JFactory::getDocument();

	$css = '
	body { overflow: hidden !important; }
	.window-mainbody, .row, .col, .article-main {
		margin:0 !important;
		padding:0 !important;
	}
	';
	$doc->addStyleDeclaration($css);
}

$play_button = ' title="Play" id="ja-btn-play" class="btn btn-border btn-border-inverse btn-rounded"><span class="sr-only">Watch the video</span><i class="fa fa-play"></i> ';


if($ctm_source == 'youtube') {
	$url = $params->get('ctm_embed_url', '');
	if ($url) {
		if(preg_match('#.*?/watch\?v\=([^&]+).*#i', $url)){
			$vid = preg_replace('#.*?/watch\?v\=([^&]+).*#i', '$1', $url);
		} elseif (preg_match('#^([a-z]+)?\://(www\.)?(youtu\.be|youtube\.com)/([^&]+)#i', $url)) {
			$vid = preg_replace('#^([a-z]+)?\://(www\.)?(youtu\.be|youtube\.com)/([^&]+)#i', '$4', $url);
		} else {
			$vid = $url;
		}
		$url = '//www.youtube.com/embed/'.$vid;
		if($context == 'list') {
			$url .= (strpos($url, '?') === false ? '?' : '&amp;').'autoplay=1';
		}
		$img_thumb = ($ctm_thumbnail == '' ? 'http://img.youtube.com/vi/'.$vid.'/mqdefault.jpg' : $ctm_thumbnail);
		echo '<img class="ja-video embed-responsive-item" width="'.$width.'" height="'.$height.'" src="'.$img_thumb.'" />';
		echo '<a onclick="javideoPlay();" '.$play_button.'</a>';
		echo '<span class="video-mask"></span>';
		?>
		<script type="text/javascript">
			var tag = document.createElement('script');

			tag.src = "https://www.youtube.com/iframe_api";
			var firstScriptTag = document.getElementsByTagName('script')[0];
			firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
			var player;
			function onYouTubeIframeAPIReady() {

			}
			function onPlayerReady(event) {
				event.target.playVideo();
				if (document.getElementById('ja-btn-play') != null) {
					document.getElementById('ja-btn-play').style.display='none';
				}
			}

			var done = false;
			function onPlayerStateChange(event) {}
			function stopVideo() {}

			function javideoPlay() {
				player = new YT.Player('videoplayer', {
				  height: '390',
				  width: '640',
				  videoId: '<?php echo $vid; ?>',
				  events: {
					'onReady': onPlayerReady,
					'onStateChange': onPlayerStateChange
				  }
				});
			}
		</script>
		<?php
	}
} elseif($ctm_source == 'vimeo') {
	$url = $params->get('ctm_embed_url', '');
	if ($url) {
		if(preg_match('#^([a-z]+)?\://.*?/([0-9]+)$#i', $url)) {
			$vid = preg_replace('#^([a-z]+)?\://.*?/([0-9]+)$#i', '$2', $url);
		} else {
			$vid = $url;
		}
		$url = '//player.vimeo.com/video/'.$vid;
		if($context == 'list') {
			$url .= (strpos($url, '?') === false ? '?' : '&amp;').'autoplay=true';
		}
		$imgid = $vid;

		$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$imgid.php"));
		$img_thumb = ($ctm_thumbnail == '' ? $hash[0]['thumbnail_large'] : $ctm_thumbnail);
		echo '<iframe id="player1" class="ja-video embed-responsive-item" src="'.$url.(strpos($url, '?') === false ? '?' : '&amp;').'api=1&amp;player_id=player1" width="'.$width.'" height="'.$height.'" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
		echo '<img class="ja-video embed-responsive-item" width="'.$width.'" height="'.$height.'" src="'.$img_thumb.'" />';
		echo '<a '.$play_button.'</a>';
		echo '<span class="video-mask"></span>';
		?>
		<script type="text/javascript">
			(function($){
				$(document).ready(function(){
					var player = $('iframe#player1');
					var playerOrigin = '*';
					var status = $('.status');

					// Listen for messages from the player
					if (window.addEventListener) {
						window.addEventListener('message', onMessageReceived, false);
					}
					else {
						window.attachEvent('onmessage', onMessageReceived, false);
					}

					// Handle messages received from the player
					function onMessageReceived(event) {
						// Handle messages from the vimeo player only
						if (!(/^https?:\/\/player.vimeo.com/).test(event.origin)) {
							return false;
						}
		
						if (playerOrigin === '*') {
							playerOrigin = event.origin;
						}
		
						var data = JSON.parse(event.data);
		
						switch (data.event) {
							case 'ready':
								onReady();
								break;
			   
							case 'playProgress':
								onPlayProgress(data.data);
								break;
				
							case 'pause':
								onPause();
								break;
			   
							case 'finish':
								onFinish();
								break;
						}
					}

					// Call the API when a button is pressed
					$('#ja-btn-play').on('click', function() {
						$('img.ja-video').remove();
						$('.video-mask').remove();
						$('.video-info').addClass('hidden-info');
						$(this).remove();
						post($(this).attr('title').toLowerCase());
					});

					// Helper function for sending a message to the player
					function post(action, value) {
						var data = {
						  method: action
						};
		
						if (value) {
							data.value = value;
						}
						
						var message = JSON.stringify(data);
						
						player[0].contentWindow.postMessage(data, playerOrigin);
					}

					function onReady() {
						status.text('ready');
		
						post('addEventListener', 'pause');
						post('addEventListener', 'finish');
						post('addEventListener', 'playProgress');
					}

					function onPause() {
						status.text('paused');
					}

					function onFinish() {
						status.text('finished');
					}

					function onPlayProgress(data) {
						status.text(data.seconds + 's played');
					}
				});
			})(jQuery);
		</script>
		<?php
	}
} elseif($ctm_source == 'local') {
	$src = $params->get('ctm_local_src');


	if($src) {
		if($context == 'list' || $context == 'featured'):
			$url = JRoute::_(ContentHelperRoute::getArticleRoute($item->id, $item->catid));
			$url .= (strpos($url, '?') === false ? '?' : '&amp;').'layout=videoplayer&amp;tmpl=component';
			if($context == 'list') {
				$url .= '&amp;autoplay=1';
			}
            ?>
            <video controls width="<?php echo $width ?>" height="<?php echo $height ?>">
                <source src="<?php echo $src ?>" type="video/mp4" />
                <source src="<?php echo $src ?>" type="video/ogg" />
            </video>    
            <?php
			//echo '<iframe class="ja-video embed-responsive-item" width="'.$width.'" height="'.$height.'" src="'.$url.'" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
		else:
			JHtml::_('jquery.framework');

			$doc = JFactory::getDocument();
			$path = JUri::root(true).'/plugins/system/jacontenttype/asset/jplayer/';
			$doc->addScript($path.'jquery.jplayer.min.js');
			$doc->addStyleSheet($path.'skin/ja.skin/jplayer.ja.skin.css');

			jimport('joomla.filesystem.file');
			$ext = JFile::getExt($src);
			$src = JUri::root().$src;

			$thumbnail = $params->get('ctm_thumbnail');

			$poster = '';
			if($thumbnail) {
				$thumbnail = JUri::root().$thumbnail;
				$poster = 'poster: "'.$thumbnail.'"';
			}
			$autoplay = '';
			if(isset($item->autoplay) && $item->autoplay) {
				$autoplay = '.jPlayer("play")';
			}
		?>

		<script type="text/javascript">
			//<![CDATA[
			(function($){
				$(document).ready(function(){
					$("#jquery_jplayer_1").jPlayer({
						ready: function () {
							$(this).jPlayer("setMedia", {
								title: "<?php echo htmlspecialchars($item->title); ?>",
								"<?php echo $ext; ?>": "<?php echo $src; ?>",
								<?php echo $poster; ?>
							})<?php echo $autoplay; ?>;
						},
						play: function() {
							$(window).resize();
							$(".jp-jplayer").not(this).jPlayer("stop");
						},

						swfPath: "<?php echo $path.'jquery.jplayer.swf'; ?>",
						supplied: "<?php echo $ext; ?>",
						size: {
							width: "<?php echo $width.'px'; ?>",
							height: "<?php echo $height.'px'; ?>",
							cssClass: ""
						},
						useStateClassSkin: true,
						autoBlur: false,
						smoothPlayBar: true,
						keyEnabled: true,
						remainingDuration: true,
						toggleDuration: true
					});
				});
			})(jQuery);
			//]]>
		</script>
		<div id="jp_container_1" class="jp-video clearfix" role="application" aria-label="media player" style="width: <?php echo $width+2; ?>px;">
			<div class="jp-type-single">
				<div id="jquery_jplayer_1" class="jp-jplayer"></div>

				<div class="jp-gui jp-interface">
            <ul class="jp-controls">
                <li><a href="javascript:;" class="jp-play" tabindex="0">play</a></li>
                <li><a href="javascript:;" class="jp-pause" tabindex="0">pause</a></li>
                <li><a href="javascript:;" class="jp-stop" tabindex="0">stop</a></li>
                <li><a href="javascript:;" class="jp-mute" tabindex="0" title="mute">mute</a></li>
                <li><a href="javascript:;" class="jp-unmute" tabindex="0" title="unmute">unmute</a></li>
                <li><a href="javascript:;" class="jp-volume-max" tabindex="0" title="max volume">max volume</a></li>
            </ul>
            <div class="jp-progress">
                <div class="jp-seek-bar">
                    <div class="jp-play-bar"></div>
                </div>
            </div>
            <div class="jp-volume-bar">
                <div class="jp-volume-bar-value"></div>
            </div>
            <div class="jp-time-holder">
                <div class="jp-current-time"></div>
                <div class="jp-duration"></div>

                <ul class="jp-toggles">
                    <li><a href="javascript:;" class="jp-repeat" tabindex="0" title="repeat">repeat</a></li>
                    <li><a href="javascript:;" class="jp-repeat-off" tabindex="0" title="repeat off">repeat off</a></li>
                </ul>
            </div>
        </div>
        <?php if($context !== 'iframe'): ?>
        <div class="jp-details">
					<div class="jp-title" aria-label="title">&nbsp;</div>
				</div>
        <?php endif; ?>
        <div class="jp-no-solution">
            <span>Update Required</span>
            To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
        </div>
			</div>
		</div>
		<?php endif; ?>
		<?php
	}
}

?>

<div class="video-info">
	<span>
		<a href="<?php echo $categoryUrl; ?>" title="<?php echo $item->category_title;?>">
		<?php echo $item->category_title;?>
		</a>
	</span>
	<!-- Override Rating Joomla -->
	<?php if ($item->params->get('show_vote')) : 
		$item->rating_percentage = 0;
      if (isset($item->rating_sum) && $item->rating_count > 0) {
        $item->rating = round($item->rating_sum / $item->rating_count, 1);
        $item->rating_percentage = $item->rating_sum / $item->rating_count * 20;
      } else {
        if (!isset($item->rating)) $item->rating = 0;
        if (!isset($item->rating_count)) $item->rating_count = 0;
        $item->rating_percentage = $item->rating * 20;
      }
      $uri = JUri::getInstance();
      
      ?>
      <div class="rating-info pd-rating-info">
        <form class="rating-form" method="POST" action="<?php echo htmlspecialchars($uri->toString()) ?>">
          <ul class="rating-list">
            <li class="rating-current" style="width:<?php echo $item->rating_percentage; ?>%;"></li>
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

	<h3><a href="<?php echo $articleUrl; ?>" title="<?php echo $item->title; ?>"><?php echo $item->title; ?></a></h3>
	<p>
		<?php echo $item->introtext ?>
	</p>
	<a class="btn btn-primary" href="<?php echo $articleUrl; ?>" title="<?php echo $item->title; ?>"><?php echo JText::_('TPL_READMORE'); ?></a>
</div>

<?php if($context == 'iframe'): ?>
	<script type="text/javascript">

		(function($){
			$(document).ready(function(){
				$(window).resize();
			});
			$(window).resize(function() {
				var container = $(window);
				var width = container.width();
				var height = container.height();

				$('iframe.ja-video, video').removeAttr('width').removeAttr('height');
				$('iframe.ja-video, video, .jp-video').css({width: width, height: height});
				$('.jp-jplayer, #jp_poster_0').css({width: width, height: height - $('.jp-interface').outerHeight(true)});
			});
		})(jQuery);
	</script>
<?php endif; ?>
