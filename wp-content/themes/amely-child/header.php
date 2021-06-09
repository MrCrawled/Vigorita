<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Amely
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-179767261-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());


  gtag('config', 'UA-179767261-1');
</script>




	
<!-- Google Tag Manager 

<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);

})(window,document,'script','dataLayer','GTM-TVQB7VH');</script> 
-->

    
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-179767261-1"></script>




	
	<meta charset="<?php bloginfo( 'charset' ); ?>">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css" integrity="sha384-Bfad6CLCknfcloXFOyFnlgtENryhrpZCe29RTifKEixXQZ38WheV+i/6YWSzkz3V" crossorigin="anonymous">

	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>

	<?php echo Amely_Templates::favico(); ?>

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
<!-- Google Tag Manager (noscript) 
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TVQB7VH"

height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>

End Google Tag Manager (noscript) -->
<?php wp_body_open(); ?>

<?php
echo Amely_Templates::mobile_menu();
echo Amely_Templates::header_offcanvas();
?>

<?php do_action( 'amely_site_before' ); ?>

<div id="page-container">

	<?php do_action( 'amely_page_container_top' ); ?>

	<?php

	if ( amely_get_option( 'topbar_on' ) ) {
		get_template_part( 'components/topbar/topbar-' . amely_get_option( 'topbar' ) );
	}

	if ( amely_get_option( 'search_on' ) ) {
		echo Amely_Templates::search_form();
	}

	$header = apply_filters( 'amely_header_layout', amely_get_option( 'header' ) );

	$header_classes   = array( 'site-header' );
	$header_classes[] = 'header-' . $header;

	if ( ! amely_get_option( 'breadcrumbs' ) && ! amely_get_option( 'page_title_on' ) ) {
		$header_classes[] = 'has-margin-bottom';
	}

	?>
	<!-- Header -->
	<header class="<?php echo implode( ' ', $header_classes ); ?>">
		<?php get_template_part( 'components/header/header-' . amely_get_option( 'header' ) ); ?>
	</header>
	<!-- End Header -->
	<?php
	$remove_whitespace = amely_get_option( 'remove_whitespace' );
	$page_title_on     = amely_get_option( 'page_title_on' );

	$container_class = array( 'main-container' );

	if ( $remove_whitespace && ! $page_title_on ) {
		$container_class[] = 'no-whitespace';
	}

	?>

	<div class="<?php echo implode( ' ', $container_class ); ?>">

		<?php
		do_action( 'amely_main_container_top' );
		echo Amely_Templates::page_title();
		?>