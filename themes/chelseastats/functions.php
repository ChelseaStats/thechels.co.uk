<?php
if ( function_exists('register_sidebars') ) :

    register_sidebar(
		array(
			'id' => 'primary',
			'name' => __( 'Primary' ),
			'description' => __( 'The Right Sidebar.' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s nav nav-list">',
			'after_widget' => '<li class="divider"></li></div>',
			'before_title' => '<li class="nav-header">',
			'after_title' => '</li>'
		)
	);


	register_sidebar(
		array(
			'id' => 'Sponsor',
			'name' => __( 'Sponsor' ),
			'description' => __( 'The Sponsor bar.' ),
			'before_widget' => '<div class="sponsor">',
			'after_widget' => '</div>',
			'before_title' => '<a href="/sponsorship/">Sponsor</a>: <strong>',
			'after_title' =>  '</strong>.'
		)
	);

endif;

// add_editor_style('editor-style.css');
function register_my_menus() {
  register_nav_menus(
    array(
      'header-menu' => __( 'Header Menu' )
    )
  );
}

add_action( 'init', 'register_my_menus' );
add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10 );
add_filter( 'image_send_to_editor', 'remove_thumbnail_dimensions', 10 );
add_filter( 'the_content', 'remove_thumbnail_dimensions', 10 );

function remove_thumbnail_dimensions( $html ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}