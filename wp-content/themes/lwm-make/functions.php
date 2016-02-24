<?php
/**
 * @package Make Child
 */

/**
 * The theme version.
 */
define( 'TTFMAKE_CHILD_VERSION', '1.1.0' );

/**
 * Turn off the parent theme styles.
 *
 * If you would like to use this child theme to style Make from scratch, rather
 * than simply overriding specific style rules, simply remove the '//' from the
 * 'add_filter' line below. This will tell the theme not to enqueue the parent
 * stylesheet along with the child one.
 */
//add_filter( 'make_enqueue_parent_stylesheet', '__return_false' );

/**
 * Add your custom theme functions here.
 */

// add typography style sheet
function add_css_js() {
    wp_enqueue_style('typography', '//cloud.typography.com/7724174/676888/css/fonts.css');
    wp_enqueue_style('garamond','//fonts.googleapis.com/css?family=EB+Garamond');
    //wp_enqueue_style( 'FontAwesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css' );
    wp_enqueue_script('jcarousel_script', get_stylesheet_directory_uri() . '/js/jquery.jcarousel.js', array('jquery'));
    wp_enqueue_script('lwm_script', get_stylesheet_directory_uri() . '/js/lwm-script.js', array('jquery'));
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

function display_people_grid() {

    // get cat list
    $output = '<ul class="category-list">
        '.display_team_categories().'
        </ul>';
    // add people list
    $output .= display_people_list();
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
        while ( $pp_query->have_posts() ) {
            $pp_query->the_post();
            $img_thumb = get_the_post_thumbnail(get_the_ID(), 'full');
            $cat = get_the_category(get_the_ID());
            $credentials = get_field('credentials') ? ', '.get_field('credentials') : '';
            $biolink = get_field('show_bio') ? get_the_permalink(get_the_ID()) : 'javascript:void(0)';
            $output .= '
                <li>
                    <div class="list-image '.$cat[0]->slug.'">
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
        'category_name'=>'news',
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
                    <p class="excerpt">'.get_the_excerpt($post->ID).'</p>
                    <p class="date">'.get_the_date('F d, Y',$post->ID).'</p>
                </div>';
        }
        //$content .= '</div>';
    }
    return $content;
}

function display_featured_news_list() {
    $output = '
        <div class="news-list">
            <h3>News + Insights</h3>
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
                <button><a href="category/events" class="button">See All</a></button>';
        }
        //$content .= '</div>';
    }
    return $content;
}
add_shortcode( 'event_block', 'display_event_block' );

