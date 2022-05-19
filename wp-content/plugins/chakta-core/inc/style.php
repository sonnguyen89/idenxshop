<?php 
/*************************************************
## Chakta Typography
*************************************************/

function chakta_custom_styling() { ?>

<style type="text/css">
<?php if (get_theme_mod( 'chakta_shop_breadcrumb_bg' )) { ?>
.klb-shop-breadcrumb{
	background-image: url(<?php echo esc_url( wp_get_attachment_url(get_theme_mod( 'chakta_shop_breadcrumb_bg' )) ); ?>);
}
<?php } ?>

<?php if (get_theme_mod( 'chakta_blog_breadcrumb_bg' )) { ?>
.klb-blog-breadcrumb{
	background-image: url(<?php echo esc_url( wp_get_attachment_url(get_theme_mod( 'chakta_blog_breadcrumb_bg' )) ); ?>);
}
<?php } ?>

<?php if (get_theme_mod( 'chakta_mobile_single_sticky_cart',0 ) == 1) { ?>
@media(max-width:64rem){
	.single .product-type-simple form.cart {
	    position: fixed;
	    bottom: 0;
	    right: 0;
	    z-index: 9999;
	    background: #fff;
	    margin-bottom: 0;
	    padding: 15px;
	    -webkit-box-shadow: 0 -2px 5px rgb(0 0 0 / 7%);
	    box-shadow: 0 -2px 5px rgb(0 0 0 / 7%);
	    justify-content: space-between;
		width: 100%;
		display: flex;
		
	}

	.single .woocommerce-variation-add-to-cart {
	    display: -webkit-box;
	    display: -ms-flexbox;
	    display: flex;
	    position: fixed;
	    bottom: 0;
	    right: 0;
	    z-index: 9999;
	    background: #fff;
	    margin-bottom: 0;
	    padding: 15px;
	    -webkit-box-shadow: 0 -2px 5px rgb(0 0 0 / 7%);
	    box-shadow: 0 -2px 5px rgb(0 0 0 / 7%);
	    justify-content: space-between;
    	width: 100%;
	}
}

<?php } ?>

.form_group i {
	color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.section-title span {
	color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.red-bg {
	background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.main-btn {
	background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.main-btn:hover, .main-btn:focus {
	background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}

.lds-ellipsis span {
	background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}

.back-to-top {
	background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.header-navigation .nav-container .main-menu ul li .sub-menu li a:hover {
	background-color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.header-navigation .nav-container .main-menu ul li:hover.menu-item-has-children > a:after {
	color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.header-navigation .nav-container .main-menu ul li:hover > a {
	color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.header-navigation .navbar-toggler span {
    background-color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.header-navigation .navbar-close {
	background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.header-area-v1 .header-top .top-left ul > li .option:hover, 
.header-area-v1 .header-top .top-left ul > li .option.focus, 
.header-area-v1 .header-top .top-left ul > li .option.selected.focus {
	background-color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.header-area-v1 .header-top .top-middle p a {
	background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.header-area-v1 .header-top .top-right p i {
	color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.header-area-v1 .header-navigation .nav-container .nav-push-item .nav-tools ul li a span.count {
	color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.header-area-v2 .header-top .top-middle .info-box i {
    color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
@media only screen and (min-width: 992px) and (max-width: 1199px) {
	.header-area-v2 .header-navigation .nav-container .main-menu ul li:hover > a {
		color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
	}
}
@media only screen and (min-width: 768px) and (max-width: 991px) {
    .header-area-v2 .header-navigation .nav-container .main-menu ul li:hover > a {
		color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
	} 
}
@media (max-width: 767px) {
    .header-area-v2 .header-navigation .nav-container .main-menu ul li:hover > a {
		color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
	} 
}
.header-area-v3 .header-navigation .nav-container .main-menu ul li:hover > a {
	color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; }
.header-area-v3 .header-navigation .nav-container .main-menu ul li:hover > a:after {
    color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.sidemenu-nav .cross-icon {
    background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.sidemenu-nav ul.sidebar-menu li:hover > a, .sidemenu-nav ul.sidebar-menu li.active > a {
	color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.sidemenu-nav ul.sidebar-menu .sub-menu > li:hover > a, .sidemenu-nav ul.sidebar-menu .sub-menu > li.active > a {
	color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.header-navigation.sticky {
	background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.header-area-v3 .header-navigation.sticky {
	background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.hero-area-v1 .hero-content ul.button li a.main-btn:hover, .hero-area-v1 .hero-content ul.button li a.main-btn:focus, .hero-area-v1 .hero-content ul.button li a.main-btn.active-btn {
	background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.hero-filter {
	background-color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.hero-filter .nice-select:after {
	color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.hero-filter .main-btn:hover, .hero-filter .main-btn:focus {
	color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.hero-area-v2 .single-hero .hero-social ul.social-link li a:hover, .hero-area-v2 .single-hero .hero-social ul.social-link li a:focus {
	background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.hero-area-v3 .single-hero .hero-content ul.button li a.main-btn {
	background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.hero-area-v3 .single-hero .hero-content ul.button li a.main-btn.active-btn:hover {
	background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.hero-area-v3 .single-hero .play-button .video-popup {
	color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.breadcrumbs-section .breadcrumbs-content ul.link li a {
	color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.trendy-slide .slick-arrow, .best-slide .slick-arrow {
	background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.offer-banner-v2 .offer-wrapper .offer-content-box {
    background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.offer-banner-v3 .offer-item .offer-content .content span.span {
	color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.offer-banner-v4 .offer-item .content span.span {
	color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.chakta-features-v2 .features-slide {
    border-top: 3px solid <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
ul.social-link li a:hover, ul.social-link li a:focus {
	color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.faqs-area .faq-wrapper .card .card-header .toggle_btn:after {
	color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.faqs-area .faq-wrapper .card .card-body {
    background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.faqs-area .faq-wrapper .card .card-header[aria-expanded="true"] {
	background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.sidebar-widget-area .widget.widget_search .search-icon {
	background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.sidebar-widget-area .widget.widget_tag_cloud .tagcloud a:hover, .sidebar-widget-area .widget.widget_tag_cloud .tagcloud a:focus {
	background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.sidebar-widget-area .widget.widget_about .about-content h5 {
	color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.products-sidebar .widget.popular-product-widget .shop-item .shop-content ul.rating li i {
	color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.products-sidebar .widget.filter-widget .price-filter-range .ui-widget.ui-widget-content {
    background-color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.products-sidebar .widget.filter-widget .price-filter-range .ui-slider-handle {
    background-color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.products-sidebar .widget.filter-widget .price-filter-range .ui-slider-horizontal .ui-slider-range {
    background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.chakta-pagination ul li a:hover, .chakta-pagination ul li a:focus, .chakta-pagination ul li a.active {
	background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.gallery-section .filter-nav ul.filter-btn li.active {
	color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.gallery-section .filter-nav ul.filter-btn li.active:after {
	background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.gallery-section .gallery-item .gallery-img .gallery-overlay .gallery-content span {
	color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.testimonial-area-v1 .testimonial-slide-one ul.slick-dots li.slick-active button {
	border-color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.testimonial-area-v1 .testimonial-thumb-slide .testimonial-item.slick-current .testimonial-thumb img {
	border-color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.testimonial-area-v1 .testimonial-item .testimonial-content h5 span {
    color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.testimonial-area-v2 .testimonial-item .testimonial-thumb-title .title span, .testimonial-area-v3 .testimonial-item .testimonial-thumb-title .title span {
	color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.testimonial-area-v2 .testimonial-item .testimonial-content .quote-icon, .testimonial-area-v3 .testimonial-item .testimonial-content .quote-icon {
    color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.testimonial-area-v3 .testimonial-item .testimonial-content {
    border-top: 5px solid <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
    border-right: 5px solid <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.product-filter .filter-right .nice-select {
	background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.shop-item span.span.off {
	background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.shop-item .shop-img .shop-overlay .overlay-content ul li a.icon:hover, .shop-item .shop-img .shop-overlay .overlay-content ul li a.icon:focus {
	background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.shop-item .shop-content h3.title:hover, .shop-item .shop-content h3.title:focus {
    color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.shop-item .shop-content p.price {
    color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.shop-grid-v1 .shop-item .shop-content p.price {
    color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.shop-grid-v1 .shop-item .shop-content .icon-btn:hover, .shop-grid-v1 .shop-item .shop-content .icon-btn:focus {
      background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.shop-grid-v1 .button-box .main-btn:hover, .shop-grid-v1 .button-box .main-btn:focus, .shop-grid-v1 .button-box .main-btn.active-btn {
    background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.shop-grid-v2 .products-tab .nav-tabs .nav-link:hover, 
.shop-grid-v2 .products-tab .nav-tabs .nav-link:focus, 
.shop-grid-v2 .products-tab .nav-tabs .nav-link.active {
	color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.shop-grid-v2 .shop-item .shop-content h3.title:hover, 
.shop-grid-v2 .shop-item .shop-content h3.title:focus {
    color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.shop-grid-v2 .shop-item .shop-content p.price {
	color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.shop-grid-v3 .arrows .slick-arrow:hover {
	background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.shop-grid-v3 .shop-item .shop-content .content p.price {
	color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.shop-list-sidebar .shop-item .shop-content p.price {
	color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.single_checkbox .input-box:checked + .input_label:before {
	border-color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.input_label:after {
    background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.blog-grid-v1 .blog-item .entry-content .post-meta ul li span i {
	color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.blog-grid-v1 .blog-item .entry-content .post-meta ul li span:hover, .blog-grid-v1 .blog-item .entry-content .post-meta ul li span:focus {
	color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.blog-grid-v1 .blog-item .entry-content h3.title:hover, .blog-grid-v1 .blog-item .entry-content h3.title:focus {
    color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.blog-grid-v1 .blog-item .entry-content .main-btn:hover, .blog-grid-v1 .blog-item .entry-content .main-btn:focus {
    background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.blog-grid-v2 .blog-item .post-thumbnail .post-overlay .entry-content .post-meta ul li span:hover, .blog-grid-v2 .blog-item .post-thumbnail .post-overlay .entry-content .post-meta ul li span:focus {
	color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.blog-grid-v2 .blog-item .post-thumbnail .post-overlay .entry-content h3.title:hover, .blog-grid-v2 .blog-item .post-thumbnail .post-overlay .entry-content h3.title:focus {
	color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.blog-standard-section .blog-post-item.post-without-thumb {
	background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.blog-standard-section .blog-post-item .entry-content .post-meta ul li span i {
	color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.blog-standard-section .blog-post-item .entry-content h3.title:hover, .blog-standard-section .blog-post-item .entry-content h3.title:focus {
    color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.blog-standard-section .blog-post-item .entry-content .main-btn:hover, .blog-standard-section .blog-post-item .entry-content .main-btn:focus {
    background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.blog-details-section .post-details-wrapper .entry-content .post-meta ul li span i {
	color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.blog-details-section .post-details-wrapper .entry-content .blockquote h5:before {
	background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.blog-details-section .post-details-wrapper .single-blog-post .blog-next-prev span i {
    color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.contact-area-v2 form.contact-form .form_group .nice-select:after {
    color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.footer-area .footer_widget .widget.quick-links-widget ul.link li a:hover, .footer-area .footer_widget .widget.quick-links-widget ul.link li a:focus {
	color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.footer-area .copyright-area .copyright-text p span {
	color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.shop-overlay a.added_to_cart:hover {
    background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.shop-grid-v1 .shop-item a.tinvwl_add_to_wishlist_button:hover {
    background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.shop-overlay a.tinvwl_add_to_wishlist_button:hover {
    background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.tinv-wishlist .tinvwl-buttons-group button {
    background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.mc4wp-response p {
    color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.klbfooterwidget ul li a:hover {
    color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.klbfooterwidget ul.contact-info li i {
	color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
ol.flex-control-thumbs .slick-arrow {
	background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.woocommerce-tabs li.nav-item.active a {
    color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.woocommerce-tabs li.nav-item.active a:after {
    background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.shop-details-section .details-content-box p.price {
    color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
button,
input[type="submit"] {
    background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.product-filter .fliter-left ul li a.active,
.product-filter .fliter-left ul li a:hover {
    background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.ajax_quick_view .product_price {
    color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
ul.page-numbers li span.page-numbers.current {
    background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}

ul.page-numbers li a:hover, ul.page-numbers li a:focus {
    background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.ui-slider .ui-slider-handle {
    background-color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.ui-slider .ui-slider-range {
	background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?> !important;
	border: 1px solid <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.widget_price_filter button.button {
    background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.products-sidebar .widget ul li a:hover {
    color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
a.checkout-button,
.return-to-shop a.button.wc-backward,
p.woocommerce-mini-cart__buttons.buttons a {
    background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
nav.woocommerce-MyAccount-navigation ul li a {
    background-color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
    border: 1px solid <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.woocommerce-MyAccount-content a {
    color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.header-navigation .nav-container .main-menu ul li ul.sub-menu li a:hover {
    background-color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
ul.breadcrumb-menu li span {
    color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.klb-block-list.about-content-box ul.list li:before {
	background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.klb-image-box-two.service-item .icon {
	background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.klb-team-box.team-item .team-img .icon {
	background-color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.klb-team-box.team-item .team-info span {
	color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.header-area-v1 span.cart-count {
    background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.wpcf7 form.invalid .wpcf7-response-output, .wpcf7 form.unaccepted .wpcf7-response-output {
    border-color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.contact-info-list .list-item i {
	background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.sidebar-widget-area.blog-sidebar .widget ul li a:hover {
    color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.sidebar-widget-area ul.td-recent-post-widget li.li-have-thumbnail .td-recent-post-title-and-date h6:hover, 
.sidebar-widget-area ul.td-recent-post-widget li.li-have-thumbnail .td-recent-post-title-and-date h6:focus {
	color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.sidebar-widget-area ul.td-recent-post-widget li.li-have-thumbnail .td-recent-post-title-and-date .td-recent-widget-date span:hover a, 
.sidebar-widget-area ul.td-recent-post-widget li.li-have-thumbnail .td-recent-post-title-and-date .td-recent-widget-date span:focus a {
	color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.sidebar-widget-area ul.td-recent-post-widget li.li-have-thumbnail .td-recent-post-title-and-date .td-recent-widget-date span i {
	color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.tagcloud a:hover {
    background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
blockquote {
    border-left: 5px solid <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
a.comment-reply-link:hover, 
a.comment-reply-link:focus {
	color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>; 
}
.klb-pagination span.post-page-numbers.current, 
.klb-pagination a:hover {
    background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
@media(max-width: 600px){
	.header-area-v2 .header-navigation .navbar-toggler span {
	    background-color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
	}
}
body .wcmp_regi_main p.form-row .button {
    background: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
.woocommerce-tabs .product-vendor a {
    color: <?php echo esc_attr(get_theme_mod('chakta_main_color' )); ?>;
}
<?php if(get_theme_mod( 'chakta_preloader_image' )){ ?>
#preloader{
	background: #fff url('<?php echo esc_url( wp_get_attachment_url(get_theme_mod( 'chakta_preloader_image' )) ); ?>') no-repeat center center; 
}
<?php } ?>


header.header-area.header-area-v1 .header-top {
	background: <?php echo esc_attr(get_theme_mod('chakta_header1_top_bg' )); ?>; 
}

header.header-area.header-area-v1 ul.top-menu li a,
header.header-area.header-area-v1 .header-top .top-middle p,
header.header-area.header-area-v1 ul.top-menu > li.menu-item-has-children:after,
header.header-area.header-area-v1 li[class^="fa-"]:before {
    color: <?php echo esc_attr(get_theme_mod('chakta_header1_top_font_color' )); ?>;
}

header.header-area.header-area-v1 .header-navigation {
    background: <?php echo esc_attr(get_theme_mod('chakta_header1_bottom_bg' )); ?>;
}

header.header-area.header-area-v1 .header-navigation .nav-container .main-menu ul li > a {
    color: <?php echo esc_attr(get_theme_mod('chakta_header1_bottom_font_color' )); ?>;
}

header.header-area.header-area-v1 .header-navigation .nav-container .main-menu ul li:hover > a{
	color: <?php echo esc_attr(get_theme_mod('chakta_header1_bottom_font_hvrcolor' )); ?>;
}

.header-area-v1 .header-navigation .nav-container .nav-push-item .nav-tools ul li a{
	color: <?php echo esc_attr(get_theme_mod('chakta_header1_icon_color' )); ?>;	
}

header.header-area.header-area-v2 .header-top {
    background: <?php echo esc_attr(get_theme_mod('chakta_header2_top_bg' )); ?>;
}

header.header-area.header-area-v2 .header-top h5  {
    color: <?php echo esc_attr(get_theme_mod('chakta_header2_top_title_color' )); ?>;
}

header.header-area.header-area-v2 .header-top span{
	color: <?php echo esc_attr(get_theme_mod('chakta_header2_top_subtitle_color' )); ?>;
}

header.header-area.header-area-v2 .header-navigation.red-bg {
    background: <?php echo esc_attr(get_theme_mod('chakta_header2_bottom_bg' )); ?>;
}

.header-area-v2 .header-navigation .nav-container .main-menu ul li > a {
	color: <?php echo esc_attr(get_theme_mod('chakta_header2_bottom_font_color' )); ?>;
}

.header-area-v2 .header-navigation .nav-container .main-menu ul li:hover > a{
	color: <?php echo esc_attr(get_theme_mod('chakta_header2_bottom_font_hvrcolor' )); ?>;
}

.header-area-v2 .header-navigation .nav-container .nav-push-item .nav-tools ul li a{
	color: <?php echo esc_attr(get_theme_mod('chakta_header2_bottom_icon_color' )); ?>;
}

.footer-area .footer_widget .widget h4.widget-title{
	color: <?php echo esc_attr(get_theme_mod('chakta_footer_header_color' )); ?>;
}

.footer-area .footer_widget .widget h4.widget-title:hover{
	color: <?php echo esc_attr(get_theme_mod('chakta_footer_header_hvrcolor' )); ?>;
}

.footer-area .footer_widget .klbfooterwidget ul li a ,
.klbfooterwidget p {
	color: <?php echo esc_attr(get_theme_mod('chakta_footer_color' )); ?>;
}

.footer-area .footer_widget .klbfooterwidget ul li a:hover{
	color: <?php echo esc_attr(get_theme_mod('chakta_footer_hvrcolor' )); ?>;
}

.footer-area .copyright-area .copyright-text p{
	color: <?php echo esc_attr(get_theme_mod('chakta_footer_cpy_color' )); ?>;
}

.footer-area .copyright-area .copyright-text p:hover{
	color: <?php echo esc_attr(get_theme_mod('chakta_footer_cpy_hvrcolor' )); ?>;
}

.footer-area{
	background-color: <?php echo esc_attr(get_theme_mod('chakta_footer_bg_color' )); ?>;
}

.footer-area .copyright-area{
	border-color: <?php echo esc_attr(get_theme_mod('chakta_footer_border_color' )); ?>;
}

.header-navigation .nav-container.breakpoint-on .nav-menu{
	background-color: <?php echo esc_attr(get_theme_mod('chakta_header_sidebar_menu_bg' )); ?> ;
}

.header-navigation .nav-container.breakpoint-on .nav-menu .main-menu ul li a ,
.header-navigation .nav-container.breakpoint-on .nav-menu .main-menu > ul > li > .dd-trigger i{
	color: <?php echo esc_attr(get_theme_mod('chakta_header_sidebar_menu_color' )); ?> !important;
}

.header-navigation .nav-container.breakpoint-on .nav-menu .main-menu ul li a:hover , 
.header-navigation .nav-container.breakpoint-on .nav-menu .main-menu > ul > li > .dd-trigger i:hover{
	color: <?php echo esc_attr(get_theme_mod('chakta_header_sidebar_menu_hvrcolor' )); ?> !important;
}


<?php if (function_exists('get_wcmp_vendor_settings')) { ?>
	<?php if(is_vendor_dashboard() && is_user_logged_in()){ ?>
		.elementor-container {
			max-width: 100% !important;
		}

		.elementor-column-wrap,
		.elementor-widget-wrap {
			padding:0 !important;
		}
	<?php } ?>
<?php } ?>
</style>
<?php }
add_action('wp_head','chakta_custom_styling');

?>