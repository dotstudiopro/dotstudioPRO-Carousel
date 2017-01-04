<?php 

function ds_owl_carousel_check_main_plugin() {
	
    ?>

    <div class="update-nag">
        <p>dotstudioPRO Premium Video plugin is not installed, is inactive, or the version is too low for this add-on.  The dotstudioPRO Premium Owl Carousel plugin has been deactivated.</p>
    </div>

    <?php

}


function ds_owl_carousel(){
	
	wp_enqueue_script( 'owl-carousel', plugin_dir_url( __FILE__ ) . 'js/owl.carousel.min.js', array('jquery') );
	wp_enqueue_style( 'owl-carousel-min', plugin_dir_url( __FILE__ ) . 'css/owl.carousel.min.css' );
	wp_enqueue_style( 'owl-carousel-theme', plugin_dir_url( __FILE__ ) . 'css/owl.theme.default.min.css' );
	wp_enqueue_style( 'ds-carousel-style', plugin_dir_url( __FILE__ ) . 'css/style.css' );
	wp_enqueue_style( 'ds-font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css');

}

function ds_owl_carousel_html($args){

	$opts = implode(', ', array_map(
    function ($v, $k) { return sprintf("%s=%s", $k, $v); },
    $args,
    array_keys($args)
));


  $channel_slug = $args['channel'];
  $time_to_next_slide = $args['time_to_next_slide'];
	$autoplay = $args['autoplay'] ? 'true' : 'false'; 
  $items_to_display = $args['items_to_display'];

	$category = get_page_by_path( '/channel-categories/' . $channel_slug, OBJECT );
	$title = $category->post_title;

	$rndId = ds_owl_carousel_rnd_id(5);
	$carousel =  "<div id='owl-carosel-width-$rndId' class='owl-carousel-width'></div>";
	$carousel .= "<div class='owl-carousel-title' style='position:relative;'><h2>$title</h2><a class='owl-carousel-ellipsis' href='/channel-categories/$channel_slug/' title='More...'>...</a></div>";
	$carousel .= "<div class='owl-carousel owl-theme' id='owl-carousel-$rndId' data-options='$opts'>";
	
	$channels = grab_category($channel_slug);
	$title = $channels->title;


	if($channels && is_array($channels)){

		foreach($channels as $ch) {
				// iterate thru the channel, get the applicable thumbnails, create the HTML output


				$id =  $ch->_id;
				$thumb_id = isset( $ch->videos_thumb ) ?  $ch->videos_thumb : '';
				$slug =  $ch->slug;
				$spotlight_poster = isset( $ch->spotlight_poster ) ?  $ch->spotlight_poster : '';

				$carousel .= "<div class='center-container'>";
				$carousel .= "<a href='".home_url("channels/$slug")."' class='vert-center'>";
				$carousel .= "<div>";
				$carousel .= "<img class='' src='$spotlight_poster/1280/720' />";
				$carousel .= "</div>";
				$carousel .= "</a>";
				$carousel .= "</div>";				
		}
	}


	$carousel .= "</div>";

	return $carousel;

}


function ds_owl_carousel_rnd_id($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


function ds_owl_carousel_display_shortcode( $atts ) {

	$atts = shortcode_atts( array(

		'channel' => '',
		'autoplay' => true,
		'time_to_next_slide' => 3,
		'items_to_display' => 3

	), $atts, 'ds_owl_carousel' );


	if(!count($atts['channel']))
		return;

	return ds_owl_carousel_html($atts);

}
add_shortcode( 'ds_owl_carousel', 'ds_owl_carousel_display_shortcode' );

