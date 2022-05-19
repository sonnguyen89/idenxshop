<?php global $woocommerce; ?>
<?php $carturl = wc_get_cart_url(); ?>
<li class="dropdown cart_dropdown"><a href="<?php echo esc_url($carturl); ?>"><i class="far fa-shopping-cart"></i><span class="cart-count"><?php echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'chakta'), $woocommerce->cart->cart_contents_count);?></span></a>
	<div class="cart_box dropdown-menu dropdown-menu-right">
	    <div class="fl-mini-cart-content">
			<?php woocommerce_mini_cart(); ?>
		</div>
	</div>
</li>