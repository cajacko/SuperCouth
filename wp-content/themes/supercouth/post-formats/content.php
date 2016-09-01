<article class="post masonry">
	<div class="article-container">
		<a class="anchor" id="post-<?php the_ID(); ?>"></a>
		
		<header class="clearfix">
			
			<?php if(has_post_thumbnail()): ?>
			
				<?php supercouhth_the_post_thumbnail(); ?>
				
			<?php endif; ?>
			
			<div class="header-title wrap">
				
				<h2><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h2>
				
			</div>
		</header>
		
		<section class="post-body wrap">
			
			<?php echo supercouth_get_the_content_with_formatting(); ?>
			
		</section>
		
		<?php get_template_part( 'sections/post-footer' ); ?>
	</div>
</article>