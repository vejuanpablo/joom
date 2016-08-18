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

if (version_compare(JVERSION, '3.0', 'ge')) {
	JHtml::_('bootstrap.tooltip');
}

$lang        = JFactory::getLanguage();
$upper_limit = $lang->getUpperLimitSearchWord();
?>
<form id="searchForm" action="<?php echo JRoute::_('index.php?option=com_search'); ?>" method="post">

	<input type="hidden" name="task" value="search"/>
	<input type="hidden" name="limit" id="hiddenlimit" value="0" />

	<div class="form-search form-group">
		<input type="text" name="searchword" placeholder="<?php echo JText::_('COM_SEARCH_SEARCH_KEYWORD'); ?>"
			   id="search-searchword" size="30" maxlength="<?php echo $upper_limit; ?>"
			   value="<?php echo $this->escape($this->origkeyword); ?>" class="form-control"/>
		<button name="Search" onclick="this.form.submit()" class="btn btn-primary"
					title="<?php echo JText::_('COM_SEARCH_SEARCH'); ?>"><?php echo JText::_('TPL_SEARCH'); ?></button>
					
					<a class="btn btn-primary" role="button" data-toggle="collapse" href="#optionSearch" aria-expanded="false"><?php echo JText::_('TPL_MORE_OPTIONS'); ?></a>
	</div>

	<div class="search-box collapse" id="optionSearch" aria-expanded="false">
		<fieldset class="phrases">
			<legend><?php echo JText::_('COM_SEARCH_FOR'); ?></legend>
			<div class="phrases-box form-group">
				<?php echo str_replace('class="radio"', 'class="radio-inline"', $this->lists['searchphrase']); ?>
			</div>
			<div class="ordering-box form-group">
				<label for="ordering" class="control-label">
					<?php echo JText::_('COM_SEARCH_ORDERING'); ?>
				</label>
				<?php echo $this->lists['ordering']; ?>
			</div>
		</fieldset>

		<?php if ($this->params->get('search_areas', 1)) : ?>
			<fieldset class="only">
				<legend><?php echo JText::_('COM_SEARCH_SEARCH_ONLY'); ?></legend>
				<?php foreach ($this->searchareas['search'] as $val => $txt) :
					$checked = is_array($this->searchareas['active']) && in_array($val, $this->searchareas['active']) ? 'checked="checked"' : '';
					?>
					<label for="area-<?php echo $val; ?>" class="checkbox-inline">
						<input type="checkbox" name="areas[]" value="<?php echo $val; ?>"
								 id="area-<?php echo $val; ?>" <?php echo $checked; ?> >
						<?php echo JText::_($txt); ?>
					</label>
				<?php endforeach; ?>
			</fieldset>
		<?php endif; ?>
	</div>

</form>
