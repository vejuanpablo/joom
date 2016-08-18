<?php
/**
 * ------------------------------------------------------------------------
 * Plugin Ajax JA Content Type
 * ------------------------------------------------------------------------
 * Copyright (C) 2004-2011 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
 * @license - GNU/GPL, http://www.gnu.org/licenses/gpl.html
 * Author: J.O.O.M Solutions Co., Ltd
 * Websites: http://www.joomlart.com - http://www.joomlancers.com
 * ------------------------------------------------------------------------
 */

defined('_JEXEC') or die;

JHtml::_('formbehavior.chosen', 'select');
// Load tooltip instance without HTML support because we have a HTML tag in the tip
JHtml::_('bootstrap.tooltip', '.noHtmlTip', array('html' => false));

$user  = JFactory::getUser();
$input = JFactory::getApplication()->input;


$session   		= $displayData['session'];
$config   		= $displayData['config'];
$state   		= $displayData['state'];
$folderList   	= $displayData['folderList'];
$require_ftp   	= $displayData['require_ftp'];
$filterExtensions = explode(',', $input->get('filter_exts', '', 'raw'));
?>
<script type='text/javascript'>
	var image_base_path = '<?php $params = JComponentHelper::getParams('com_media');
echo $params->get('image_path', 'images'); ?>/';
</script>
<form action="index.php?option=com_ajax&amp;plugin=jacontenttype&amp;view=media&amp;asset=<?php echo $input->getCmd('asset');?>&amp;author=<?php echo $input->getCmd('author'); ?>" class="form-vertical" id="imageForm" method="post" enctype="multipart/form-data">
	<div id="messages" style="display: none;">
		<span id="message"></span><?php echo JHtml::_('image', 'media/dots.gif', '...', array('width' => 22, 'height' => 12), true) ?>
	</div>
	<div class="well">
		<div class="row">
			<div class="span9 control-group">
				<div class="control-label">
					<label class="control-label" for="folder"><?php echo JText::_('COM_MEDIA_DIRECTORY') ?></label>
				</div>
				<div class="controls">
					<?php echo str_replace('<select', '<select disabled="disabled"', $folderList); ?>
					<!--<button class="btn" type="button" id="upbutton" title="<?php /*echo JText::_('COM_MEDIA_DIRECTORY_UP') */?>"><?php /*echo JText::_('COM_MEDIA_UP') */?></button>-->
					<?php if(count($filterExtensions)): ?>
						<br />
						<span class="label label-warning">
							<?php echo JText::sprintf('Legal Extensions: %s', implode(', ', $filterExtensions)); ?>
						</span>
					<?php endif; ?>
				</div>
			</div>
			<div class="pull-right">
				<button class="btn btn-primary" type="button" onclick="<?php if ($state->get('field.id')):?>window.parent.jInsertFieldValue(document.id('f_url').value,'<?php echo $state->get('field.id');?>');<?php else:?>ImageManager.onok();<?php endif;?>window.parent.SqueezeBox.close();"><?php echo JText::_('COM_MEDIA_INSERT') ?></button>
				<button class="btn" type="button" onclick="window.parent.SqueezeBox.close();"><?php echo JText::_('JCANCEL') ?></button>
			</div>
		</div>
	</div>

	<iframe id="imageframe" name="imageframe" src="index.php?option=com_ajax&amp;plugin=jacontenttype&amp;view=mediaList&amp;tmpl=component&amp;format=html&amp;folder=<?php echo $state->folder?>&amp;filter_exts=<?php echo $input->get('filter_exts', '', 'raw');?>&amp;asset=<?php echo $input->getCmd('asset');?>&amp;author=<?php echo $input->getCmd('author');?>"></iframe>

	<div class="well">
		<div class="row">
			<div class="span6 control-group">
				<div class="control-label">
					<label for="f_url"><?php echo JText::_('File URL') ?></label>
				</div>
				<div class="controls">
					<input type="text" id="f_url" value="" />
				</div>
			</div>
			<?php if (!$state->get('field.id')):?>
				<div class="span6 control-group">
					<div class="control-label">
						<label title="<?php echo JText::_('COM_MEDIA_ALIGN_DESC'); ?>" class="noHtmlTip" for="f_align"><?php echo JText::_('COM_MEDIA_ALIGN') ?></label>
					</div>
					<div class="controls">
						<select size="1" id="f_align">
							<option value="" selected="selected"><?php echo JText::_('COM_MEDIA_NOT_SET') ?></option>
							<option value="left"><?php echo JText::_('JGLOBAL_LEFT') ?></option>
							<option value="center"><?php echo JText::_('JGLOBAL_CENTER') ?></option>
							<option value="right"><?php echo JText::_('JGLOBAL_RIGHT') ?></option>
						</select>
					</div>
				</div>
			<?php endif;?>
		</div>
		<?php if (!$state->get('field.id')):?>
			<div class="row">
				<div class="span6 control-group">
					<div class="control-label">
						<label for="f_alt"><?php echo JText::_('COM_MEDIA_IMAGE_DESCRIPTION') ?></label>
					</div>
					<div class="controls">
						<input type="text" id="f_alt" value="" />
					</div>
				</div>
				<div class="span6 control-group">
					<div class="control-label">
						<label for="f_title"><?php echo JText::_('COM_MEDIA_TITLE') ?></label>
					</div>
					<div class="controls">
						<input type="text" id="f_title" value="" />
					</div>
				</div>
			</div>
			<div class="row">
				<div class="span6 control-group">
					<div class="control-label">
						<label for="f_caption"><?php echo JText::_('COM_MEDIA_CAPTION') ?></label>
					</div>
					<div class="controls">
						<input type="text" id="f_caption" value="" />
					</div>
				</div>
				<div class="span6 control-group">
					<div class="control-label">
						<label title="<?php echo JText::_('COM_MEDIA_CAPTION_CLASS_DESC'); ?>" class="noHtmlTip" for="f_caption_class"><?php echo JText::_('COM_MEDIA_CAPTION_CLASS_LABEL') ?></label>
					</div>
					<div class="controls">
						<input type="text" list="d_caption_class" id="f_caption_class" value="" />
						<datalist id="d_caption_class">
							<option value="text-left">
							<option value="text-center">
							<option value="text-right">
						</datalist>
					</div>
				</div>
			</div>
		<?php endif;?>

		<input type="hidden" id="dirPath" name="dirPath" />
		<input type="hidden" id="f_file" name="f_file" />
		<input type="hidden" id="tmpl" name="component" />
		<input type="hidden" id="format" name="html" />

	</div>
</form>

<?php if ($user->authorise('core.create', 'com_media')) : ?>
	<!--<form action="<?php /*echo JUri::base(); */?>index.php?option=com_media&amp;task=file.upload&amp;tmpl=component&amp;<?php /*echo $session->getName() . '=' . $session->getId(); */?>&amp;<?php /*echo JSession::getFormToken();*/?>=1&amp;asset=<?php /*echo $input->getCmd('asset');*/?>&amp;author=<?php /*echo $input->getCmd('author');*/?>&amp;view=images" id="uploadForm" class="form-horizontal" name="uploadForm" method="post" enctype="multipart/form-data">
		<div id="uploadform" class="well">
			<fieldset id="upload-noflash" class="actions">
				<div class="control-group">
					<div class="control-label">
						<label for="upload-file" class="control-label"><?php /*echo JText::_('COM_MEDIA_UPLOAD_FILE'); */?></label>
					</div>
					<div class="controls">
						<input type="file" id="upload-file" name="Filedata[]" multiple /><button class="btn btn-primary" id="upload-submit"><i class="icon-upload icon-white"></i> <?php /*echo JText::_('COM_MEDIA_START_UPLOAD'); */?></button>
						<p class="help-block"><?php /*echo $config->get('upload_maxsize') == '0' ? JText::_('COM_MEDIA_UPLOAD_FILES_NOLIMIT') : JText::sprintf('COM_MEDIA_UPLOAD_FILES', $config->get('upload_maxsize')); */?></p>
					</div>
				</div>
			</fieldset>
			<?php /*JFactory::getSession()->set('com_media.return_url', 'index.php?option=com_media&view=images&tmpl=component&fieldid=' . $input->getCmd('fieldid', '') . '&e_name=' . $input->getCmd('e_name') . '&asset=' . $input->getCmd('asset') . '&author=' . $input->getCmd('author')); */?>
		</div>
	</form>-->
<?php endif; ?>
