<?php 
	global $woocommerce;
	$cart_url = wc_get_cart_url();
	$checkout_url = wc_get_checkout_url();
?>

<div class="header-cart">
    <a href="<?php echo esc_url($cart_url); ?>" class="cart">
        <i class="icon-shopping_cart"></i>
        <span class="label number"><span class="count"><?php echo wp_specialchars_decode($woocommerce->cart->get_cart_contents_count()); ?></span></span>
        <span class="title"><?php esc_html_e('Shopping Cart','gymx'); ?></span>
    </a>
    
    <div class="function">
        <div class="widget">
        
            <h6 class="title"><?php esc_html_e('Shopping Cart','gymx'); ?></h6>
            
            <ul class="cart-overview">
            
	            <?php foreach ($woocommerce->cart->cart_contents as $cart_item_key => $cart_item) : ?>
	            
	            	<?php $_product = $cart_item['data']; ?>
	            	
	                <li>
	                    <a href="<?php echo get_permalink($cart_item['product_id']); ?>">
	                        <?php echo get_the_post_thumbnail($cart_item['product_id'], 'shop_thumbnail'); ?>
	                        <div class="description">
	                            <span class="product-title"><?php echo apply_filters('woocommerce_cart_widget_product_title', $_product->get_title(), $_product); ?></span>
	                            <span class="price number"><?php echo wc_price($_product->get_price()); ?></span>
	                        </div>
	                    </a>
	                </li>
	                
	            <?php endforeach; ?>

            </ul>
            
            <hr>
            
            <div class="cart-controls">
                <a class="ttbase-button small btn-primary <?php echo get_theme_mod('gymx_button_style', 'style-2'); ?>" href="<?php echo esc_url($checkout_url); ?>"><?php esc_html_e('Checkout','gymx'); ?></a>
                <div class="pull-right">
                    <span class="cart-total"><?php esc_html_e('Total','gymx'); ?>: </span>
                    <span class="number"><?php echo wp_specialchars_decode($woocommerce->cart->get_cart_total()); ?></span>
                </div>
            </div>
            
        </div>
    </div>
    
</div>