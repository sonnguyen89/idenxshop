<?php 
/*************************************************
* Catalog Ordering
*************************************************/
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 ); 
add_action( 'klb_catalog_ordering', 'woocommerce_catalog_ordering', 30 ); 

add_action( 'woocommerce_before_shop_loop', 'chakta_catalog_ordering_start', 30 );
function chakta_catalog_ordering_start(){
?>
<div class="product-filter mb-30">
	<div class="row">
		<div class="col-md-12">
			<?php echo chakta_remove_klb_filter(); ?>
			<?php wp_enqueue_style( 'klb-remove-filter'); ?>
		</div>
		<div class="col-lg-2 col-md-6 col-sm-12">
			<?php if(get_theme_mod('chakta_grid_list_view','0') == '1'){ ?>
				<div class="fliter-left">
					<ul>
						<?php if(chakta_shop_view() == 'list_view' || get_theme_mod('chakta_view_type') == 'list-view' && chakta_shop_view() != 'grid_view') { ?>
							<li><a href="<?php echo esc_url(add_query_arg('shop_view','grid_view')); ?>"><i class="fal fa-th"></i></a></li>
							<li><a class="active" href="<?php echo esc_url(add_query_arg('shop_view','list_view')); ?>"><i class="far fa-list"></i></a></li>
						<?php } else { ?>
							<li><a class="active" href="<?php echo esc_url(add_query_arg('shop_view','grid_view')); ?>"><i class="fal fa-th"></i></a></li>
							<li><a href="<?php echo esc_url(add_query_arg('shop_view','list_view')); ?>"><i class="far fa-list"></i></a></li>
						<?php } ?>
					</ul>
				</div>
			<?php } ?>
		</div>
		<div class="col-lg-10 col-md-6 col-sm-12">
			<?php do_action('klb_catalog_ordering'); ?>
		</div>
	</div>
</div>
<?php

}