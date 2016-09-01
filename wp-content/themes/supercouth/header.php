<?php
/**
 * The header for the SuperCouth theme.
 *
 * @package supercouth
 */
 
 	//Used to load posts for an infinite scroll effect
	if(isset($_GET['action']) && 'get_page' == $_GET['action'] && isset($_GET['get']) && is_numeric($_GET['get'])) {
		get_template_part( 'sections/post-loop' ); //Skip all the head info and load only the posts html
		exit; //Prevent any other html or scripts from rendering
	} 
?>

	<!DOCTYPE html>
	<html lang="en-GB" id="html" data-home-url="<?php echo home_url( '/' ); ?>" class="no-js">
	
		<head>
			<meta charset="utf-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<meta name="author" content="Charlie Jackson">
			<meta property="og:description" content="<?php bloginfo( 'description' ); ?>" />
			<meta id="less-vars">
			<title><?php wp_title( '|', true, 'right' ); ?> SuperCouth</title>
			<link rel="author" href="http://charliejackson.com">
			<link rel="profile" href="http://gmpg.org/xfn/11">
			<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/inc/media/favicon.ico" />
			<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
			<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/inc/font-awesome/css/font-awesome.min.css">
			
			<?php wp_head(); ?>
			<script type="text/javascript" src="//s3.amazonaws.com/downloads.mailchimp.com/js/signup-forms/popup/embed.js" data-dojo-config="usePlainJson: true, isDebug: false"></script>
			
		</head>
	
		<body>
			<a id="top-of-page"></a>
			
			<header id="site-navigation">
				
				<a id="banner" href="/">
					<div id="logo-wrap">
						<div id="background-img">
							<div class="embed-responsive" style=" padding-bottom: <?php echo ( ( 2250 / 4000 ) * 100 ); ?>%">
								<img width="4000" height="2250" class="embed-responsive-item" src="<?php echo get_stylesheet_directory_uri(); ?>/inc/media/supercouth-background.jpg">
							</div>
						</div>
						
						<img id="logo" width="4000" height="2250" src="<?php echo get_stylesheet_directory_uri(); ?>/inc/media/supercouth-logo.png">
					</div>
					
					<div id="site-description">
						<div>
							<h1>London based improv comedy group</h1>
						</div>
					</div>
				</a>

			</header>
			
			<main data-page-id="0">