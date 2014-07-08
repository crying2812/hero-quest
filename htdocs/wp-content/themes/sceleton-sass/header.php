<!DOCTYPE html>
<html class="no-js" dir="ltr" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<meta name="viewport" content="width=device-width, maximum-scale=1.0, minimum-scale=1.0, initial-scale=1" />
	<?php if (is_search()) { ?><meta name="robots" content="noindex, nofollow" /><?php } 
	$styledir = get_bloginfo('stylesheet_url');
	$GLOBALS['templdir'] = get_bloginfo('template_directory'); ?>
	<title><?php wp_title(''); ?></title>
	<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/favicon.ico">
	<link rel="stylesheet" href="<?php echo $styledir; ?>">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<!--[if IE]>
	  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	  <script src="<?php echo $GLOBALS['templdir']; ?>/includes/js/selectivizr-min.js"></script>
	<![endif]-->
	<!--[if lt IE 9]>
		<script src="<?php echo $GLOBALS['templdir']; ?>/includes/js/css3-mediaqueries.js"></script>
	<![endif]-->
	<script src="<?php echo $GLOBALS['templdir']; ?>/includes/js/picturefill.min.js" async></script>
	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
	wp_head(); ?>
</head>
<body <?php body_class(); ?> id="top">
	<header id="header" class="clearfix" role="banner">
		<section class="upper-header">
			<div class="page-wrap clearfix">
				<?php 
				global $current_user;
				get_currentuserinfo();
				?>
				<h1 class="current-wizard clearfix">
					<a href="<?php echo get_option('home'); ?>" class="wizard"><?php echo $current_user->display_name; ?>s Home</a>
					<?php if(is_front_page()): ?>
						<a href="<?php echo wp_logout_url(get_permalink()); ?>" class="logout-link mobile-element" data-icon="f"></a>
						<a href="#" class="reset-cards mobile-element" data-icon="a"></a>
					<?php endif; ?>
				</h1>
				<nav id="mainmenu" role="navigation">
					<ul class="clearfix mainmenu-ul">
						<?php wp_nav_menu(array('theme_location' => 'primary', 'container' => '', 'items_wrap' => '%3$s')); ?>
					</ul>
				</nav>
			</div>
		</section>
		<div class="page-wrap clearfix">
			<div class="logo-wrap"><img src="<?php echo $GLOBALS['templdir']; ?>/images/hq.png" id="logo" /></div>
			
		</div>
	</header>
	<div class="page-wrap clearfix" id="content">