<?php if ( have_posts() ) :

	while ( have_posts() ) : the_post();
		
		get_template_part( 'post-formats/content', get_post_format() );

	endwhile;

elseif(isset($_GET['action']) && 'get_page' == $_GET['action'] && isset($_GET['get']) && is_numeric($_GET['get'])):

	echo 'no-posts';

else: ?>

	<div id="no-more-posts" class="alert alert-warning" role="alert">That's all folks, there are no more posts.</div>

<?php endif; ?>