<!DOCTYPE html>
<HTML <?php language_attributes(); ?>>
<HEAD>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php wp_title("") ?></title>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php
if ( is_singular() && get_option( 'thread_comments' ) )
	wp_enqueue_script( 'comment-reply' );
wp_head();
?>
</HEAD>

<BODY <?php body_class(); ?>>
<section id="wrapper">
<header id="header">
	<hgroup class="inner">
		<h1 id="site-title"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		<h3 id="site-description" class="noel-lock"><?php bloginfo( 'description' ); ?></h3>
	</hgroup>
</header><!-- #header -->

<nav class="site-navigation">
	<?php wp_nav_menu( array( 'container_class' => 'menu', 'theme_location' => 'primary' ) ); ?>
</nav>

<?php if ( is_front_page() ) : ?>
	<div id="main-banner" style="background-image:url('<?php header_image(); ?>')"></div>
<?php endif; ?>

<div id="main">