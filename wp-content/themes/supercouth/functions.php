<?php
/**
 * SuperCouth functions and definitions.
 *
 * @package supercouth
 */
	
/* -----------------------------
TERRY PRATCHETT HEADER
----------------------------- */
	/**
	 * Adds a memorial header for Terry Pratchett, 
	 * based off the code in the clacks referrenced 
	 * in the Discworld novel "Going Postal" by 
	 * Terry Pratchett.
	 */
	function add_header_clacks( $headers ) {
	    $headers['X-Clacks-Overhead'] = 'GNU Terry Pratchett'; //Add an array value to the headers variable
	    return $headers; //Return the headers
	}
	
	add_filter( 'wp_headers', 'add_header_clacks' );

/* -----------------------------
ADD/REMOVE THEME SUPPORT
----------------------------- */	
	function supercouth_setup() {
		add_filter( 'show_admin_bar', '__return_false' ); // Always hide admin bar
		
		add_theme_support( 'post-thumbnails' );
		
		/*
		 * Add various image sizes so that images 
		 * can be progressively loaded at higher 
		 * resolutions.
		 */
		add_image_size( 'inline-image', 600, 3000, false );
		add_image_size( 'width-500', 500 );
		add_image_size( 'width-1000', 1000 );
		add_image_size( 'width-1500', 1500 );
		add_image_size( 'width-2000', 2000 );
		add_image_size( 'width-2500', 2500 );
		add_image_size( 'width-3000', 3000 );
		add_image_size( 'width-3500', 3500 );
		add_image_size( 'width-4000', 4000 );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
		
		add_theme_support( 'post-formats', array( 'image', 'video', 'gallery', 'link', 'aside', 'quote', 'status', 'audio', 'chat' ) );
	}
	
	add_action( 'after_setup_theme', 'supercouth_setup' );
	
	$defaults = array(
		'default-image'          => '',
		'width'                  => 0,
		'height'                 => 0,
		'flex-height'            => false,
		'flex-width'             => false,
		'uploads'                => true,
		'random-default'         => false,
		'header-text'            => true,
		'default-text-color'     => '',
		'wp-head-callback'       => '',
		'admin-head-callback'    => '',
		'admin-preview-callback' => '',
	);
	add_theme_support( 'custom-header', $defaults );

/* -----------------------------
ADD STYLES AND SCRIPTS
----------------------------- */
	function supercouth_scripts() {
		/*
		 * Add the bootstrap stylesheet and JavaScript
		 */
		wp_enqueue_style( 'supercouth-bootstrap-style',  get_template_directory_uri()  . '/inc/bootstrap/css/bootstrap.min.css' );
		wp_enqueue_script( 'supercouth-bootstrap-script', get_template_directory_uri()  . '/inc/bootstrap/js/bootstrap.min.js', array( 'jquery' ) );
		
		/*
		 * Add the template.js file which provides global functions used by other JavaScript files.
		 */
		wp_enqueue_script( 'supercouth-template-script', get_template_directory_uri()  . '/js/template.js', array( 'jquery' ) );
		
		/*
		 * Add the masonry script for laying out posts.
		 */
		wp_enqueue_script( 'supercouth-masonry-script', get_template_directory_uri()  . '/js/masonry.js', array( 'jquery' ) );
		
		/*
		 * Add the core setup.js file which is used on every page.
		 */
		wp_enqueue_script( 'supercouth-setup-script', get_template_directory_uri()  . '/js/setup.js', array( 'jquery' ) );
	}
	
	add_action( 'wp_enqueue_scripts', 'supercouth_scripts' );
	
/* -----------------------------
FILTER OEMBED OUTPUT
----------------------------- */	
	function supercouth_filter_oembed( $html, $url, $attr, $post_id ) {
		/**
		 * If the embed is a youTube video then 
		 * return the embed within a fixed aspect 
		 * ratio div
		 */
		if ( strpos( $html, 'youtube.com' ) !== false ) {
			$html = preg_replace( '/(width=").+?(")/', '', $html ); // Remove the width attribute
			$html = preg_replace( '/(height=").+?(")/', '', $html ); // Remove the height attribute
			$html = str_replace( 'iframe', 'iframe class="embed-responsive-item"', $html ); // Add a responsive class to the iframe
			$html = '<div class="embed-responsive embed-responsive-16by9">' . $html . '</div>';
		}
		
		return $html;
	}
	
	add_filter( 'embed_oembed_html', 'supercouth_filter_oembed', 99, 4 );
	
/* -----------------------------
REGISTER IMAGE SIZE SELECTIONS	
----------------------------- */
	function supercouth_new_image_sizes( $sizes ) {
		return array_merge( $sizes, array(
	        'inline-image' => __( 'Inline Image' ),
	        'width-500' => __( 'Width 500' ),
	        'width-1000' => __( 'Width 1000' ),
	        'width-1500' => __( 'Width 1500' ),
	        'width-2000' => __( 'Width 2000' ),
	        'width-2500' => __( 'Width 2500' ),
	        'width-3000' => __( 'Width 3000' ),
	        'width-3500' => __( 'Width 3500' ),
	        'width-4000' => __( 'Width 4000' )
	    ) );
	}
	
	add_filter( 'image_size_names_choose', 'supercouth_new_image_sizes' );

/* -----------------------------
INCREASE MAX UPLOAD SIZE	
----------------------------- */
	@ini_set( ‘upload_max_size’ , ‘10G’);
	@ini_set( ‘post_max_size’, ‘10G’);	
	@ini_set( ‘max_execution_time’, ‘300’);

/* -----------------------------
EDIT THE MORE TEXT TAG
----------------------------- */		
	function supercouth_read_more_link() {
		return '<a class="more-link" href="' . get_permalink() . '">Read more...</a>';
	}
	
	add_filter( 'the_content_more_link', 'supercouth_read_more_link' );

/* -----------------------------
GET THE CONTENT WITH FORMATTING	
----------------------------- */	
	function supercouth_get_the_content_with_formatting( $more_link_text = '(more...)', $stripteaser = 0, $more_file = '' ) {
		$content = get_the_content( $more_link_text, $stripteaser, $more_file );
		$content = apply_filters( 'the_content', $content );
		$content = str_replace( ']]>', ']]&gt;', $content ); // Can't remember what this was for, but I must have added it for a reason?...
		$content = str_replace( '<p>&nbsp;</p>', '', $content ); // Remove empty paragraphs
		$content = str_replace( '<h5>', '<h6>', $content );
		$content = str_replace( '</h5>', '</h6>', $content );
		$content = str_replace( '<h4>', '<h6>', $content );
		$content = str_replace( '</h4>', '</h6>', $content );
		$content = str_replace( '<h3>', '<h5>', $content );
		$content = str_replace( '</h3>', '</h5>', $content );
		$content = str_replace( '<h2>', '<h4>', $content );
		$content = str_replace( '</h2>', '</h4>', $content );
		$content = str_replace( '<h1>', '<h3>', $content );
		$content = str_replace( '</h1>', '</h3>', $content );

		$content = supercouth_relative_image($content);
		
		return $content;
	}
			
/* -----------------------------
POST FORMAT FUNCTION
----------------------------- */
	/**
	 * Get the video from the content and display it
	 */
	function supercouth_the_video() {
		preg_match ( "/<div class=\"embed-responsive embed-responsive-16by9\"><iframe.*<\/div>/" , supercouth_get_the_content_with_formatting(), $match );
		
		echo $match[0];
	}
	
	/**
	 * Remove the video from the content and then display the content
	 */
	function supercouth_the_video_content() {
		$content = preg_replace ( "/<p><div class=\"embed-responsive embed-responsive-16by9\"><iframe.*<\/div><\/p>/" , "" , supercouth_get_the_content_with_formatting() );
		$content = preg_replace ( "/<div class=\"embed-responsive embed-responsive-16by9\"><iframe.*<\/div>/" , "" , $content );
		echo $content;	
	}
	
	/**
	 * Get the gallery from the content and display it
	 */
	function supercouth_the_gallery() {
		preg_match ( '/<div class=\"gallery.*?<\/figure><\/div>/' , supercouth_get_the_content_with_formatting(), $match );
		
		echo $match[0];
	}
	
	/**
	 * Remove the gallery from the content and then display the content
	 */
	function supercouth_the_gallery_content() {
		echo preg_replace ( '/<div class=\"gallery.*?<\/figure><\/div>/' , "" , supercouth_get_the_content_with_formatting() );
	}

	/**
	 * Remove the gallery from the content and then display the content
	 */
	function supercouth_the_image() {
		preg_match ( "/<img.+?>/" , get_the_content(), $match );
		
		echo supercouth_relative_image($match[0]);
	}

/* -----------------------------
DISPLAY THE PAGINATION
----------------------------- */
	/**
	 * Use the Bootstrap pagination, modified from the standard WordPress pagination
	 */
	function supercouth_pagination( $args = array() ) {	    
	    $defaults = array(
	        'range'           => 4,
	        'custom_query'    => FALSE,
	        'previous_string' => __( '<i class="fa fa-chevron-left"></i>', 'text-domain' ),
	        'next_string'     => __( '<i class="fa fa-chevron-right"></i>', 'text-domain' ),
	        'before_output'   => '<div id="page-nav" class="text-center"><ul class="pagination">',
	        'after_output'    => '</ul></div>'
	    );
	    
	    $args = wp_parse_args( 
	        $args, 
	        apply_filters( 'wp_bootstrap_pagination_defaults', $defaults )
	    );
	    
	    $args['range'] = (int) $args['range'] - 1;
	    
	    if ( !$args['custom_query'] ) {
	        $args['custom_query'] = @$GLOBALS['wp_query'];
	    }
	    
	    $count = ( int ) $args['custom_query']->max_num_pages;
	    $page  = intval( get_query_var( 'paged' ) );
	    $ceil  = ceil( $args['range'] / 2 );
	    
	    if ( $count <= 1 ) {
	        return FALSE;
	    }
	    
	    if ( !$page ) {
	        $page = 1;
	    }
	    
	    if ( $count > $args['range'] ) {
	        if ( $page <= $args['range'] ) {
	            $min = 1;
	            $max = $args['range'] + 1;
	        } elseif ( $page >= ( $count - $ceil ) ) {
	            $min = $count - $args['range'];
	            $max = $count;
	        } elseif ( $page >= $args['range'] && $page < ( $count - $ceil ) ) {
	            $min = $page - $ceil;
	            $max = $page + $ceil;
	        }
	    } else {
	        $min = 1;
	        $max = $count;
	    }
	    
	    $echo = '';
	    $previous = intval( $page ) - 1;
	    $previous = esc_attr( get_pagenum_link( $previous ) );	    
	    $firstpage = esc_attr( get_pagenum_link( 1 ) );
	    
	    if ( $firstpage && (1 != $page) ) {
	        $echo .= '<li class="previous"><a href="' . $firstpage . '">' . __( 'First', 'text-domain' ) . '</a></li>';
	    }
	
	    if ( $previous && ( 1 != $page ) ) {
	        $echo .= '<li><a href="' . $previous . '" title="' . __( 'previous', 'text-domain') . '">' . $args['previous_string'] . '</a></li>';
	    }
	    
	    if ( !empty( $min ) && !empty( $max ) ) {
	        for( $i = $min; $i <= $max; $i++ ) {
	            if( $page == $i ) {
	                $echo .= '<li class="active"><span class="active">' . str_pad( ( int ) $i, 2, '0', STR_PAD_LEFT ) . '</span></li>';
	            } else {
	                $echo .= sprintf( '<li><a href="%s">%002d</a></li>', esc_attr( get_pagenum_link( $i ) ), $i );
	            }
	        }
	    }
	    
	    $next = intval( $page ) + 1;
	    $next = esc_attr( get_pagenum_link( $next ) );
	    if ( $next && ( $count != $page ) ) {
	        $echo .= '<li><a href="' . $next . '" title="' . __( 'next', 'text-domain') . '">' . $args['next_string'] . '</a></li>';
	    }
	    
	    $lastpage = esc_attr( get_pagenum_link( $count ) );
	    if ( $lastpage ) {
	        $echo .= '<li class="next"><a href="' . $lastpage . '">' . __( 'Last', 'text-domain' ) . '</a></li>';
	    }
	
	    if ( isset($echo) ) {
	        echo $args['before_output'] . $echo . $args['after_output'];
	    }
	}

/* -----------------------------
GET THE PAGE FOR AJAX
----------------------------- */
	function supercouth_get_page($query) {
		$posts_per_page = get_option('posts_per_page'); 
		$offset = $_GET['get'] * $posts_per_page;

		$query->set('offset', $offset);
		$query->set('ignore_sticky_posts', 1);
	}

	if(isset($_GET['action']) && 'get_page' == $_GET['action'] && isset($_GET['get']) && is_numeric($_GET['get'])) {
		add_action('pre_get_posts', 'supercouth_get_page');
	}

/* -----------------------------
ADJUST THE QUERY FOR PEOPLE
----------------------------- */
	function supercouth_people_query($query) {

		if($query->is_category('People')) {
			$query->set('posts_per_page', 100);
			$query->set('orderby', 'rand');
		}	
	}

	add_action('pre_get_posts', 'supercouth_people_query');

/* -----------------------------
ADJUST THE QUERY FOR PEOPLE
----------------------------- */
	function supercouth_relative_image($html) {
		$html = preg_replace_callback( 
			'/<img.*width="([0-9]*)".*height="([0-9]*)".*\/>/', 
			function($matches) {
				$string = '<div class="responsize-embed" style="padding-bottom: ';
				$string .= ($matches[2] / $matches[1])*100;
				$string .= '%;">'.$matches[0].'</div>';
				return $string;
			}, 
			$html 
		); // Remove the width attribute

		return $html;
	}

	function supercouhth_the_post_thumbnail() {
		$html = get_the_post_thumbnail();
		$html = supercouth_relative_image($html);
		echo $html;
	}