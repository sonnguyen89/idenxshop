	<?php $headersearch = get_theme_mod('chakta_header_search','0'); ?>
	<?php $headercart   = get_theme_mod('chakta_header_cart','0'); ?>
	<?php $headeraccounticon  = get_theme_mod('chakta_header_account','0'); ?>
	<?php $sidebarmenu  = get_theme_mod('chakta_header_sidebar','0'); ?>
	<header class="header-area header-area-v2">
		<div class="header-top">
			<div class="custom-container">
				<div class="row align-items-center">
					<div class="col-lg-3">
						<div class="top-left">
							<?php if (get_theme_mod( 'chakta_logo' )) { ?>
								<a href="<?php echo esc_url( home_url( "/" ) ); ?>" class="logo" title="<?php bloginfo("name"); ?>">
									<img src="<?php echo esc_url( wp_get_attachment_url(get_theme_mod( 'chakta_logo' )) ); ?>" alt="<?php bloginfo("name"); ?>">
								</a>
							<?php } elseif (get_theme_mod( 'chakta_logo_text' )) { ?>
								<a class="logo text" href="<?php echo esc_url( home_url( "/" ) ); ?>" title="<?php bloginfo("name"); ?>">
									<span><?php echo esc_html(get_theme_mod( 'chakta_logo_text' )); ?></span>
								</a>
							<?php } else { ?>
								<a href="<?php echo esc_url( home_url( "/" ) ); ?>" class="logo" title="<?php bloginfo("name"); ?>">
									<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/logo-1.png" width="192" height="40" alt="<?php bloginfo("name"); ?>">
								</a>
							<?php } ?>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="top-middle">
							<div class="row">
								<?php $header_contact = get_theme_mod( 'chakta_header_contact' ); ?>
								<?php if( !empty( $header_contact ) ) { ?>
									<?php foreach($header_contact as $contact){ ?>
										<div class="col-lg-6">
											<div class="info-box">
												<i class="fal fa-<?php echo esc_attr($contact['contact_icon']); ?>"></i>
												<span><?php echo esc_html($contact['contact_title']); ?></span>
												<h5><?php echo esc_html($contact['contact_subtitle']); ?></h5>
											</div>
										</div>
									<?php } ?>
								<?php } ?>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<?php if($headersearch == '1'){ ?>
							<div class="top-right">
								<?php echo chakta_header_product_search(); ?>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
		<div class="header-navigation red-bg">
			<div class="custom-container">
				<div class="nav-container d-flex align-items-center justify-content-between">
					<div class="brand-logo">
						<?php if (get_theme_mod( 'chakta_logo' )) { ?>
							<a href="<?php echo esc_url( home_url( "/" ) ); ?>" title="<?php bloginfo("name"); ?>">
								<img class="img-fluid" src="<?php echo esc_url( wp_get_attachment_url(get_theme_mod( 'chakta_logo' )) ); ?>" alt="<?php bloginfo("name"); ?>">
							</a>
						<?php } elseif (get_theme_mod( 'chakta_logo_text' )) { ?>
							<a class="logo text" href="<?php echo esc_url( home_url( "/" ) ); ?>" title="<?php bloginfo("name"); ?>">
								<span><?php echo esc_html(get_theme_mod( 'chakta_logo_text' )); ?></span>
							</a>
						<?php } else { ?>
							<a href="<?php echo esc_url( home_url( "/" ) ); ?>"  title="<?php bloginfo("name"); ?>">
								<img class="img-fluid" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/logo-1.png" width="192" height="40" alt="<?php bloginfo("name"); ?>">
							</a>
						<?php } ?>
					</div>
					<div class="nav-menu">
						<div class="navbar-close">
							<div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
						</div>
						<nav class="main-menu">
							<?php 
							   wp_nav_menu(array(
							   'theme_location' => 'main-menu',
							   'container' => '',
							   'fallback_cb' => 'show_top_menu',
							   'menu_id' => '',
							   'menu_class' => '',
							   'echo' => true,
								"walker" => new chakta_description_walker(),
							   'depth' => 0 
								)); 
							 ?>
						</nav>
					</div>
					<?php if($headersearch == '1' || $headercart == '1' || $sidebarmenu == '1'){ ?>
						<div class="nav-push-item">
							<div class="nav-tools">
								<ul>
									<?php if($headeraccounticon == '1'){ ?>
										<li><a href="<?php echo wc_get_page_permalink( 'myaccount' ); ?>"><i class="fal fa-user-circle"></i></a></li>
									<?php } ?>
									<?php global $woocommerce; ?>
									<?php if($headercart == '1'){ ?>
										<?php get_template_part( 'includes/header/cart' ); ?>
									<?php } ?>
									<?php if($sidebarmenu == '1'){ ?>
										<li><a href="#" class="menu-icon"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/bar-2.png" alt="<?php bloginfo("name"); ?>"></a></li>
									<?php } ?>
								</ul>
							</div>
						</div>
					<?php } ?>
					<div class="navbar-toggler">
						<span></span><span></span><span></span>
					</div>
				</div>
			</div>
		</div>
		<?php if($sidebarmenu == '1'){ ?>
			<div class="sidebar-sidemenu">
				<div class="panel-overly"></div>
				<div class="sidemenu-nav">
					<a href="#" class="cross-icon"><i class="far fa-times"></i></a>
					<?php 
					   wp_nav_menu(array(
					   'theme_location' => 'main-menu',
					   'container' => '',
					   'fallback_cb' => 'show_top_menu',
					   'menu_id' => '',
					   'menu_class' => 'sidebar-menu',
					   'echo' => true,
						"walker" => new chakta_description_walker(),
					   'depth' => 0 
						)); 
					 ?>
				</div>
			</div>
		<?php } ?>
	</header><!--====== End Header ======-->