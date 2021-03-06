<?php
/*
Author: Eddie Machado
URL: http://themble.com/bones/

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, etc.
*/

// LOAD BONES CORE (if you remove this, the theme will break)
require_once( 'library/bones.php' );

// CUSTOMIZE THE WORDPRESS ADMIN (off by default)
// require_once( 'library/admin.php' );

/*********************
LAUNCH BONES
Let's get everything up and running.
*********************/

function bones_ahoy() {

  //Allow editor style.
  add_editor_style( get_stylesheet_directory_uri() . '/library/css/editor-style.css' );

  // let's get language support going, if you need it
  load_theme_textdomain( 'bonestheme', get_template_directory() . '/library/translation' );

  // USE THIS TEMPLATE TO CREATE CUSTOM POST TYPES EASILY
  require_once( 'library/custom-post-type.php' );

  // launching operation cleanup
  add_action( 'init', 'bones_head_cleanup' );
  // A better title
  add_filter( 'wp_title', 'rw_title', 10, 3 );
  // remove WP version from RSS
  add_filter( 'the_generator', 'bones_rss_version' );
  // remove pesky injected css for recent comments widget
  add_filter( 'wp_head', 'bones_remove_wp_widget_recent_comments_style', 1 );
  // clean up comment styles in the head
  add_action( 'wp_head', 'bones_remove_recent_comments_style', 1 );
  // clean up gallery output in wp
  add_filter( 'gallery_style', 'bones_gallery_style' );

  // enqueue base scripts and styles
  add_action( 'wp_enqueue_scripts', 'bones_scripts_and_styles', 999 );
  // ie conditional wrapper

  // launching this stuff after theme setup
  bones_theme_support();

  // adding sidebars to Wordpress (these are created in functions.php)
  add_action( 'widgets_init', 'bones_register_sidebars' );

  // cleaning up random code around images
  add_filter( 'the_content', 'bones_filter_ptags_on_images' );
  // cleaning up excerpt
  add_filter( 'excerpt_more', 'bones_excerpt_more' );

} /* end bones ahoy */

// let's get this party started
add_action( 'after_setup_theme', 'bones_ahoy' );


/************* OEMBED SIZE OPTIONS *************/

if ( ! isset( $content_width ) ) {
	$content_width = 680;
}

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'bones-thumb-600', 600, 150, true );
add_image_size( 'bones-thumb-300', 300, 100, true );

/*
to add more sizes, simply copy a line from above
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.

To call a different size, simply change the text
inside the thumbnail function.

For example, to call the 300 x 100 sized image,
we would use the function:
<?php the_post_thumbnail( 'bones-thumb-300' ); ?>
for the 600 x 150 image:
<?php the_post_thumbnail( 'bones-thumb-600' ); ?>

You can change the names and dimensions to whatever
you like. Enjoy!
*/

add_filter( 'image_size_names_choose', 'bones_custom_image_sizes' );

function bones_custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'bones-thumb-600' => __('600px by 150px'),
        'bones-thumb-300' => __('300px by 100px'),
    ) );
}

/*
The function above adds the ability to use the dropdown menu to select
the new images sizes you have just created from within the media manager
when you add media to your content blocks. If you add more image sizes,
duplicate one of the lines in the array and name it according to your
new image size.
*/

/************* THEME CUSTOMIZE *********************/

/* 
  A good tutorial for creating your own Sections, Controls and Settings:
  http://code.tutsplus.com/series/a-guide-to-the-wordpress-theme-customizer--wp-33722
  
  Good articles on modifying the default options:
  http://natko.com/changing-default-wordpress-theme-customization-api-sections/
  http://code.tutsplus.com/tutorials/digging-into-the-theme-customizer-components--wp-27162
  
  To do:
  - Create a js for the postmessage transport method
  - Create some sanitize functions to sanitize inputs
  - Create some boilerplate Sections, Controls and Settings
*/

function bones_theme_customizer($wp_customize) {
  // $wp_customize calls go here.
  //
  // Uncomment the below lines to remove the default customize sections 

  // $wp_customize->remove_section('title_tagline');
  // $wp_customize->remove_section('colors');
  // $wp_customize->remove_section('background_image');
  // $wp_customize->remove_section('static_front_page');
  // $wp_customize->remove_section('nav');

  // Uncomment the below lines to remove the default controls
  // $wp_customize->remove_control('blogdescription');
  
  // Uncomment the following to change the default section titles
  // $wp_customize->get_section('colors')->title = __( 'Theme Colors' );
  // $wp_customize->get_section('background_image')->title = __( 'Images' );
}

add_action( 'customize_register', 'bones_theme_customizer' );

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function bones_register_sidebars() {
	register_sidebar(array(
		'id' => 'sidebar1',
		'name' => __( 'Sidebar 1', 'bonestheme' ),
		'description' => __( 'The first (primary) sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	/*
	to add more sidebars or widgetized areas, just copy
	and edit the above sidebar code. In order to call
	your new sidebar just use the following code:

	Just change the name to whatever your new
	sidebar's id is, for example:

	register_sidebar(array(
		'id' => 'sidebar2',
		'name' => __( 'Sidebar 2', 'bonestheme' ),
		'description' => __( 'The second (secondary) sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	To call the sidebar in your template, you can just copy
	the sidebar.php file and rename it to your sidebar's name.
	So using the above example, it would be:
	sidebar-sidebar2.php

	*/
} // don't remove this bracket!


/************* COMMENT LAYOUT *********************/

// Comment Layout
function bones_comments( $comment, $args, $depth ) {
   $GLOBALS['comment'] = $comment; ?>
  <div id="comment-<?php comment_ID(); ?>" <?php comment_class('cf'); ?>>
    <article  class="cf">
      <header class="comment-author vcard">
        <?php
        /*
          this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
          echo get_avatar($comment,$size='32',$default='<path_to_url>' );
        */
        ?>
        <?php // custom gravatar call ?>
        <?php
          // create variable
          $bgauthemail = get_comment_author_email();
        ?>
        <img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5( $bgauthemail ); ?>?s=40" class="load-gravatar avatar avatar-48 photo" height="40" width="40" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
        <?php // end custom gravatar call ?>
        <?php printf(__( '<cite class="fn">%1$s</cite> %2$s', 'bonestheme' ), get_comment_author_link(), edit_comment_link(__( '(Edit)', 'bonestheme' ),'  ','') ) ?>
        <time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__( 'F jS, Y', 'bonestheme' )); ?> </a></time>

      </header>
      <?php if ($comment->comment_approved == '0') : ?>
        <div class="alert alert-info">
          <p><?php _e( 'Your comment is awaiting moderation.', 'bonestheme' ) ?></p>
        </div>
      <?php endif; ?>
      <section class="comment_content cf">
        <?php comment_text() ?>
      </section>
      <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    </article>
  <?php // </li> is added by WordPress automatically ?>
<?php
} // don't remove this bracket!


/*
This is a modification of a function found in the
twentythirteen theme where we can declare some
external fonts. If you're using Google Fonts, you
can replace these fonts, change it in your scss files
and be up and running in seconds.
*/
function bones_fonts() {
  wp_enqueue_style('googleFonts', 'http://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic');
}
add_action('wp_enqueue_scripts', 'bones_fonts');

/* add pdf as media filter option */
function modify_post_mime_types( $post_mime_types ) {
  $post_mime_types['application/pdf'] = array( __( 'PDFs' ), __( 'Manage PDFs' ), _n_noop( 'PDF <span class="count">(%s)</span>', 'PDFs <span class="count">(%s)</span>' ) );
  return $post_mime_types;
}
add_filter( 'post_mime_types', 'modify_post_mime_types' );

// add typography style sheet
function add_css_js() {
  wp_enqueue_style('typography', '//cloud.typography.com/7724174/676888/css/fonts.css');
  wp_enqueue_style('garamond','//fonts.googleapis.com/css?family=EB+Garamond');
  wp_enqueue_style( 'FontAwesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css' );
  wp_enqueue_style( 'flexslider-css', get_stylesheet_directory_uri() . '/library/flexslider/flexslider.css');
  wp_enqueue_script('flexslider', get_stylesheet_directory_uri() . '/library/flexslider/jquery.flexslider.js', array('jquery', 'bones-modernizr'));
  wp_enqueue_script('jcarousel_script', get_stylesheet_directory_uri() . '/library/js/jquery.jcarousel.js', array('jquery'));
  wp_enqueue_script('lwm_script', get_stylesheet_directory_uri() . '/library/js/lwm-script.js', array('jquery'));

}
add_action( 'wp_enqueue_scripts', 'add_css_js' );


// create people post type
function create_post_type_people() {
  register_post_type( 'people',
      array(
          'labels' => array(
              'name' => __( 'People' ),
              'singular_name' => __( 'People' )
          ),
          'public' => true,
          'has_archive' => true,
          'rewrite' => array('slug' => 'people', 'with_front' => false),
          'hierarchical' => true,
          'supports' => array('title','author','custom-fields','thumbnail','editor'),
          'taxonomies' => array('category'),
          'not-found' => __('Nothing was found. what to do?')
      )
  );
}
add_action( 'init', 'create_post_type_people' );


// remove footer credit
$footer_credit = apply_filters( 'make_show_footer_credit', false );

// add description field to menu
function add_description_to_menu($item_output, $item, $depth, $args) {
  if (strlen($item->description) > 0 ) {
    // append description after link
    //$item_output .= sprintf('<span class="description">%s</span>', esc_html($item->description));
    $item_output = sprintf('<span class="description">%s</span>', esc_html($item->description)) . $item_output;
    // insert description as last item *in* link ($input_output ends with "</a>{$args->after}")
    //$item_output = substr($item_output, 0, -strlen("</a>{$args->after}")) . sprintf('<span class="description">%s</span >', esc_html($item->description)) . "</a>{$args->after}";
  }
  return $item_output;
}
add_filter('walker_nav_menu_start_el', 'add_description_to_menu', 10, 4);



/*
 * PEOPLE SECTION
 * display all people in grid format
 * hover over image turns green with person's name
 * display tags as menu list at top; add tagname id to each tag
 * add tag as class to each person
 * when user clicks on tag item, then only people with that tag in grid appear
 * hover o
 */

function display_team_categories() {
  $categories = get_categories(array('child_of'=>get_cat_ID('Team')));
  foreach ($categories as $cat) {
    $catlist .= '<li><div class="'.$cat->slug.'">'.$cat->name.'</div></li>';
  }
  return $catlist;
}

function display_team_departments() {
  //$departments = array('advisors','client-services-team','investment-team'.'management');
  $departments1 = get_field_object('field_56ddd3c20bcbe');
  $departments2 = get_field_object('field_56de0a27401cb');
  //var_dump($departments1);
  //var_dump($departments2);
  $deptlist = $departments1['choices'] ? $departments1['choices'] : $departments2['choices'];
  $output = '';
  foreach ($deptlist as $key => $value) {
    $output .= '<li><div class="'.$key.'">'.$value.'</div></li>';
  }
  return $output;
}

function display_people_grid() {
  // get cat list
  $output = '
    <div class="people-grid">
        <ul class="category-list">
            '.display_team_departments().'
        </ul>
        <ul>
          '.display_people_list().'
        </ul>
      </div>';
  // add people list
  //$output .= ''.display_people_list().'</div>';
  return $output;
}
add_shortcode( 'people_grid', 'display_people_grid' );

function display_people_list() {
  $args = array(
      'post_type' => 'people',
      'posts_per_page' => 999,
      'order' => 'ASC'
  );
  $pp_query = new WP_Query( $args );
  $output = '';
  if ( $pp_query->have_posts() ) {
    $output .= '<ul class="people-list">';
    $deptobject = '';
    while ( $pp_query->have_posts() ) {
      $pp_query->the_post();
      $img_thumb = get_the_post_thumbnail(get_the_ID(), 'full');
      $cat = get_the_category(get_the_ID());
      if (get_field('team_department')) {
        $dept = implode(' ',get_field('team_department'));
      }
      else {
        $dept = '';
      }
      $credentials = get_field('credentials') ? ', '.get_field('credentials') : '';
      $biolink = get_field('show_bio') ? get_the_permalink(get_the_ID()) : 'javascript:void(0)';
      $output .= '
                <li>
                    <div class="list-image '.$dept.'">
                        '.$img_thumb.'
                        <a href="'.$biolink.'"><span>'.get_the_title().$credentials.' <br />'. get_field('job_title') .'</span></a>
                    </div>
                </li>';
    }
    $output .= '</ul>';
    wp_reset_postdata();
  }
  return $output;
}

function display_people_carousel() {
  $output = '
        <div class="jcarousel-wrapper">
            <div class="jcarousel">
            ' . display_people_list() . '
            </div>
            <div class="controls">
                <span class="jcarousel-control-prev"></span>
                <span class="jcarousel-control-next"></span>
            </div>
        </div>';
  return $output;
}

add_shortcode( 'people_carousel', 'display_people_carousel' );


// home news block
function get_news($n = -1) {
  $args = array(
      'numberposts'=>$n,
      'order_by'=>'date',
      'order'=> 'DESC',
      'post_status'=>'publish'
  );

  $fpresult = get_posts($args);
  if ($fpresult) {
    $content = '';
    foreach($fpresult as $post) {
      setup_postdata($post);
      $content .= '
                <div class="news-item">
                    <h4><a href="'.get_the_permalink($post->ID).'">'.get_the_title($post->ID).'</a></h4>
                    <p class="date">'.get_the_date('F d, Y',$post->ID).'</p>
                    <p class="excerpt">'.get_the_excerpt($post->ID).'</p>
                </div>';
    }
    //$content .= '</div>';
  }
  return $content;
}

function display_featured_news_list() {
  $output = '
        <div class="news-list">
            <h3>FYI</h3>
            ' . get_news(2) . '
        </div>
    ';
  return $output;
}

add_shortcode( 'news_feature', 'display_featured_news_list' );

function display_news_list() {
  $output = '
        <div class="news-list">
            ' . get_news() . '
        </div>
    ';
  return $output;
}
add_shortcode( 'news_list', 'display_news_list' );

function display_event_block() {
  $args = array(
      'numberposts'=>2,
      'category_name'=>'events',
      'order_by'=>'date',
      'order'=> 'DESC',
      'post_status'=>'publish'
  );

  $fpresult = get_posts($args);
  if ($fpresult) {
    $content = '';
    foreach($fpresult as $post) {
      setup_postdata($post);
      $content .= '
                <div class="event-item">
                    <h4><a href="'.get_the_permalink($post->ID).'">'.get_the_title($post->ID).'</a></h4>
                    <div class="excerpt">'.nl2br(get_the_content()).'</div>
                </div>
                <a href="category/events" class="button">See All</a>';
    }
    //$content .= '</div>';
  }
  return $content;
}
add_shortcode( 'event_block', 'display_event_block' );


// create post type slide
function create_post_type_slide() {
  register_post_type( 'slide',
      array(
          'labels' => array(
              'name' => __( 'Slide Images' ),
              'singular_name' => __( 'Slide' )
          ),
          'public' => true,
          'has_archive' => false,
          'rewrite' => array('slug' => 'slide', 'with_front' => false),
          'hierarchical' => true,
          'supports' => array('title','author','custom-fields','thumbnail','editor'),
          'not-found' => __('Nothing was found. what to do?')
      )
  );
}
add_action( 'init', 'create_post_type_slide' );

// display slides
function display_slides() {
  // Query Arguments
  $args = array(
      'post_type' => 'slide',
      'posts_per_page' => 15,
      'order' => 'ASC'
  );
  // The Query
  $the_query = new WP_Query( $args );
  // Check if the Query returns any posts
  if ( $the_query->have_posts() ) {
    // Start the Slider ?>

    <div class="flexslider">
      <ul class="slides">
        <?php
        // The Loop
        while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
          <?php
          // get slide image, title and caption
          $thumbid = get_post_thumbnail_id();
          $imgsrc = wp_get_attachment_image_src($thumbid, 'full')
          ?>
          <li>
            <div class="slider-image" style="background-image: url(<?php echo $imgsrc[0]; ?>)"></div>
            <div class="slider-content">
              <span class="slider-caption"><?php echo get_post_field('post_excerpt', $thumbid ); ?></span>
            </div>
          </li>
        <?php endwhile; ?>

      </ul><!-- .slides -->
    </div><!-- .flexslider -->

  <?php }

  // Reset Post Data
  wp_reset_postdata();
}


function create_post_type_case_studies() {
  register_post_type( 'case_studies',
    array(
      'labels' => array(
        'name' => __( 'Case Studies' ),
        'singular_name' => __( 'Case Study' )
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'case-studies', 'with_front' => false),
      'hierarchical' => true,
      'supports' => array('title','author','custom-fields','thumbnail','editor'),
      'taxonomies' => array('category'),
      'not-found' => __('Nothing was found. what to do?')
    )
  );
}
add_action( 'init', 'create_post_type_case_studies' );

function display_case_studies() {
  $args = array(
    'post_type' => 'case_studies',
    'numberposts' => 5,
    'order' => 'ASC',
    'post_status'=>'publish'
  );
  $cs_query = new WP_Query( $args );
  //var_dump($cs_query);
  if ($cs_query) {
    $content = '<div class="cs-list"><ul>';
    while ( $cs_query->have_posts() ) {
      $cs_query->the_post();
      $img_thumb = get_the_post_thumbnail(get_the_ID(), 'full');
      $cs_img = $img_thumb ? $img_thumb : '<img src="'.get_stylesheet_directory_uri().'/library/images/fpo.png" alt="fpo" />';
      $content .= '
        <li class="cs-item">
            <div class="cs-image"><a href="'.get_the_permalink().'">'.$cs_img.'</a></div>
            <div class="excerpt">'.get_field('teaser').' <a href="'.get_the_permalink().'">read more</a></div>
        </li>';
    }
    $content .= '</ul></div>';
  }
  return $content;
}
add_shortcode( 'case_studies', 'display_case_studies' );


/* DON'T DELETE THIS CLOSING TAG */ ?>
