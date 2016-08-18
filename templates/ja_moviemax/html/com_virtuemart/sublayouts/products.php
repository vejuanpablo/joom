<?php
/**
 * ------------------------------------------------------------------------
 * JA Elicyon Template
 * ------------------------------------------------------------------------
 * Copyright (C) 2004-2011 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
 * @license - Copyrighted Commercial Software
 * Author: J.O.O.M Solutions Co., Ltd
 * Websites:  http://www.joomlart.com -  http://www.joomlancers.com
 * This file may not be redistributed in whole or significant part.
 * ------------------------------------------------------------------------
 */

defined('_JEXEC') or die('Restricted access');
$products_per_row = $viewData['products_per_row'];
$currency = $viewData['currency'];
$showRating = $viewData['showRating'];
$verticalseparator = " vertical-separator";
echo shopFunctionsF::renderVmSubLayout('askrecomjs');

$vm_fmodules = 'vm-featured';
$vm_lmodules = 'vm-latest';
$attrs = array();
$result = null;
$renderer = JFactory::getDocument()->loadRenderer('modules');
$fmodules = $renderer->render($vm_fmodules, $attrs, $result);
$lmodules = $renderer->render($vm_lmodules, $attrs, $result);

$ItemidStr = '';
$Itemid = shopFunctionsF::getLastVisitedItemId();
if(!empty($Itemid)){
	$ItemidStr = '&Itemid='.$Itemid;
}

foreach ($viewData['products'] as $type => $products ) {

	$rowsHeight = shopFunctionsF::calculateProductRowsHeights($products,$currency,$products_per_row);

	if(!empty($type) and count($products)>0){
		$productTitle = vmText::_('COM_VIRTUEMART_'.strtoupper($type).'_PRODUCT'); ?>
<div class="<?php echo $type ?>-view">
  <h4><span><?php echo $productTitle ?></span></h4>
		<?php // Start the Output
    }

	// Calculating Products Per Row
	$cellwidth = ' width'.floor ( 100 / $products_per_row );

	$BrowseTotalProducts = count($products);

	$col = 1;
	$nb = 1;
	$row = 1; ?>

<div class="row equal-height equal-height-child">
<?php
	foreach ( $products as $product ) {


		// Show the vertical seperator
		if ($nb == $products_per_row or $nb % $products_per_row == 0) {
			$show_vertical_separator = ' ';
		} else {
			$show_vertical_separator = $verticalseparator;
		}

    // Show Products ?>
	<div class="product vm-col<?php echo ' vm-col-' . $products_per_row . $show_vertical_separator ?> col">
		<div class="spacer">
			<div class="vm-product-media-container">

					<a title="<?php echo $product->product_name ?>" href="<?php echo $product->link.$ItemidStr; ?>">
						<?php
						echo $product->images[0]->displayMediaThumb('class="browseProductImage"', false);
						?>
					</a>

			</div>


				<div class="vm-product-descr-container-<?php echo $rowsHeight[$row]['product_s_desc'] ?>">
					<div class="vm-product-rating-container">
						<div class="rating-item">
						<?php echo shopFunctionsF::renderVmSubLayout('rating',array('showRating'=>$showRating, 'product'=>$product)); ?>
						</div>

						<?php if ( VmConfig::get ('display_stock', 1)) { ?>
						<div class="stock-item">
							<span class="vmicon vm2-<?php echo $product->stock->stock_level ?>" title="<?php echo $product->stock->stock_tip ?>"></span>
							</div>
						<?php }
						echo shopFunctionsF::renderVmSubLayout('stockhandle',array('product'=>$product));
						?>
					</div>

					<h2><?php echo JHtml::link ($product->link.$ItemidStr, $product->product_name); ?></h2>

          <?php if (!empty($product->customfieldsSorted)): ?>
            <div class="vm3pr-customfields-product">
              <?php $customFields = $product->customfieldsSorted;$newCustomField=array();
              if (!empty($customFields['ontop'])):
                foreach ($customFields['ontop'] AS $custom): ?>
                  <?php $newCustomField[preg_replace('/[^a-zA-Z0-9_]+/', '_', $custom->custom_title)]['value'][] = '<i class="fa fa-'.strtolower($custom->display).' '.strtolower($custom->display).'"></i>'; ?>
                  <?php $newCustomField[preg_replace('/[^a-zA-Z0-9_]+/', '_', $custom->custom_title)]['title'] = $custom->custom_title; ?>
                <?php endforeach; ?>
                <!-- Seperator between the value of every custom field.Change to anything. -->
                <?php $customSeperator=' '; ?>
                <?php $cusopenTag=''; ?>
                <?php $cusclosetag=''; ?>
                <?php foreach ($newCustomField AS $ncf) :?>
                  <span><?php echo $cusopenTag; ?><?php echo implode($ncf['value'], $cusclosetag.$customSeperator.$cusopenTag); ?></span><?php echo $cusclosetag; ?>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          <?php endif; ?>

					<?php if(!empty($rowsHeight[$row]['product_s_desc'])) { ?>
					<p class="product_s_desc">
						<?php // Product Short Description
						if (!empty($product->product_s_desc)) {
							echo shopFunctionsF::limitStringByWord ($product->product_s_desc, 60, ' ...') ?>
						<?php } ?>
					</p>
			<?php  } ?>
				</div>


			<?php //echo $rowsHeight[$row]['price'] ?>
			<div class="vm3pr-<?php echo $rowsHeight[$row]['price'] ?>"> <?php
				echo shopFunctionsF::renderVmSubLayout('prices',array('product'=>$product,'currency'=>$currency)); ?>
				<div class="clear"></div>
			</div>
			<?php //echo $rowsHeight[$row]['customs'] ?>
			<div class="vm3pr-<?php echo $rowsHeight[$row]['customfields'] ?>"> <?php
				echo shopFunctionsF::renderVmSubLayout('addtocart',array('product'=>$product,'rowHeights'=>$rowsHeight[$row], 'position' => array('ontop', 'addtocart'))); ?>
			</div>

			<!--
      <div class="vm-details-button">
				<?php // Product Details Button
				//$link = empty($product->link)? $product->canonical:$product->link;
				//echo JHtml::link($link.$ItemidStr,vmText::_ ( 'COM_VIRTUEMART_PRODUCT_DETAILS' ), array ('title' => $product->product_name, 'class' => 'product-details' ) );
				?>
			</div>
      -->

		</div>
	</div>

	<?php
    $nb ++;
  }?>
  </div>
<?php
      if(!empty($type)and count($products)>0){
        // Do we need a final closing row tag?
        //if ($col != 1) {
      ?>
    <div class="clear"></div>
	<?php if ($fmodules && $type=='featured') : ?>
	<div class="vm-featured">
		<?php echo $fmodules ?>
	</div>
	<?php endif ?>

	<?php if ($lmodules && $type=='latest') : ?>
	<div class="vm-latest">
		<?php echo $lmodules ?>
	</div>
	<?php endif ?>
  </div>
    <?php
    // }
    }
  }
