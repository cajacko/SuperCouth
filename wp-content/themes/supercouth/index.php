<?php
/**
 * The main template file.
 *
 * @package Charlie Jackson
 */

get_header(); ?>
	
	<section id="post-loop">
		
		<?php get_template_part( 'sections/sidebar' ); ?>
		
		<?php get_template_part( 'sections/post-loop' ); ?>
		
	</section>

	<img class="loading-img" src="<?php echo get_template_directory_uri(); ?>/inc/media/loading-posts.gif">
	
	<?php 
		/**
		 * The pagination is placed outside of the post loop 
		 * template so that it does not get loaded during an 
		 * inifinite scroll request
		 */
		if( have_posts() ) { 
			supercouth_pagination(); 
		}
	?>

<?php get_footer(); ?>