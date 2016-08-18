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

// no direct access
defined('_JEXEC') or die('Restricted access');

//dump ($cart,'mod cart');
// Ajax is displayed in vm_cart_products
// ALL THE DISPLAY IS Done by Ajax using "hiddencontainer" ?>

<!-- Virtuemart 2 Ajax Card -->

<button aria-expanded="false" data-toggle="dropdown" class="btn btn-cart dropdown-toggle" type="button" id="head-cart-dropdown">
  <i class="fa fa-shopping-cart"></i>
  <span class="total-product"><?php echo $data->totalProduct ?></span>
</button>
<div aria-labelledby="head-cart-dropdown" role="menu" class="dropdown-menu">
	<div class="vmCartModule <?php echo $params->get('moduleclass_sfx'); ?>" id="vmCartModule">
	<?php
	if ($show_product_list) {
		?>
		<div id="hiddencontainer" style=" display: none; ">
			<div class="vmcontainer">
				<div class="product_row">
					<span class="quantity"></span>&nbsp;x&nbsp;<span class="product_name"></span>

				<?php if ($show_price and $currencyDisplay->_priceConfig['salesPrice'][0]) { ?>
					<div class="subtotal_with_tax" style="float: right;"></div>
				<?php } ?>
				<div class="customProductData"></div><br>
				</div>
			</div>
		</div>
		<div class="vm_cart_products">
			<div class="vmcontainer">

				<?php
					foreach ($data->products as $product){
				?>
				<div class="product_row clearfix">

					<?php if ($show_price and $currencyDisplay->_priceConfig['salesPrice'][0]) { ?>
					  <div class="subtotal_with_tax"><?php echo $product['subtotal_with_tax'] ?></div>
					<?php } ?>
					
					<div class="product-item">
						<span class="quantity"><?php echo  $product['quantity'] ?></span>&nbsp;x&nbsp;<span class="product_name"><?php echo  $product['product_name'] ?></span>
					</div>
					<?php if ( !empty($product['customProductData']) ) { ?>
					<div class="customProductData"><?php echo $product['customProductData'] ?></div>

					<?php } ?>

				</div>
				<?php }
				?>
			</div>
		</div>
		<?php } ?>

		<div class="total-container">
			<div class="total" style="float: right;">
				<?php if ($data->totalProduct and $show_price and $currencyDisplay->_priceConfig['salesPrice'][0]) { ?>
				<?php echo $data->billTotal; ?>
				<?php } ?>
			</div>

			<div class="total_products"><?php echo  $data->totalProductTxt ?></div>
			<div class="show_cart">
				<?php if ($data->totalProduct) echo  $data->cart_show; ?>
			</div>
			<div style="clear:both;"></div>
				<div class="payments-signin-button" ></div>
			<noscript>
			<?php echo vmText::_('MOD_VIRTUEMART_CART_AJAX_CART_PLZ_JAVASCRIPT') ?>
			</noscript>
		</div>
	</div>
</div>

<script type="text/javascript">
if (typeof Virtuemart === "undefined")
	Virtuemart = {};

jQuery(function($) {
	Virtuemart.customUpdateVirtueMartCartModule = function(el, options){
		var base 	= this;
		var $this	= jQuery(this);
		base.$el 	= jQuery(".vmCartModule");

		base.options 	= jQuery.extend({}, Virtuemart.customUpdateVirtueMartCartModule.defaults, options);
			
		base.init = function(){
			jQuery.ajaxSetup({ cache: false })
			jQuery.getJSON(window.vmSiteurl + "index.php?option=com_virtuemart&nosef=1&view=cart&task=viewJS&format=json" + window.vmLang,
				function (datas, textStatus) {
					base.$el.each(function( index ,  module ) {
						if (datas.totalProduct > 0) {
							jQuery(module).find(".vm_cart_products").html("");
							jQuery.each(datas.products, function (key, val) {
								jQuery(module).find("#hiddencontainer .vmcontainer .product_row").clone().appendTo( jQuery(module).find(".vm_cart_products") );
								jQuery.each(val, function (key, val) {
									jQuery(module).find(".vm_cart_products ." + key).last().html(val);
								});
							});
						}
						if (jQuery('.alert-cart-empty').size()) {
							jQuery('.alert-cart-empty').remove();
						}
						jQuery(".total-product", ".head-cart").html(datas.totalProduct);
						jQuery(module).find(".show_cart").html(datas.cart_show);
						jQuery(module).find(".total_products").html(datas.totalProductTxt);
						jQuery(module).find(".total").html(datas.billTotal);
						jQuery(module).find(".total-product").html(datas.totalProduct);
					});
				}
			);			
		};
		base.init();
	};
	// Definition Of Defaults
	Virtuemart.customUpdateVirtueMartCartModule.defaults = {
		name1: 'value1'
	};

});
jQuery(document).ready(function( $ ) {
	jQuery(document).off("updateVirtueMartCartModule","body",Virtuemart.customUpdateVirtueMartCartModule);
	jQuery(document).on("updateVirtueMartCartModule","body",Virtuemart.customUpdateVirtueMartCartModule);
});
</script>