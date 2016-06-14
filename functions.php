<?php 

function ds_carousel_check_main_plugin() {
	
    ?>

    <div class="update-nag">
        <p>dotstudioPRO Premium Video plugin is not installed, is inactive, or the version is too low for this add-on.  The dotstudioPRO Premium Carousel plugin has been deactivated.</p>
    </div>

    <?php

}


function ds_carousel_owl_carousel(){
	
	wp_enqueue_script( 'owl-carousel', plugin_dir_url( __FILE__ ) . 'js/owl.carousel.min.js', array('jquery') );

	wp_enqueue_style( 'owl-carousel-min', plugin_dir_url( __FILE__ ) . 'css/owl.carousel.min.css' );

	wp_enqueue_style( 'owl-carousel-theme', plugin_dir_url( __FILE__ ) . 'css/owl.theme.default.min.css' );
	wp_enqueue_style( 'ds-carousel-style', plugin_dir_url( __FILE__ ) . 'css/style.css' );
	wp_enqueue_style( 'ds-font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css');

}

function ds_carousel_instantiate($autoplay = true, $time_to_next_slide = 3, $items_to_display = 3){

	?>
	<script>
		jQuery(function($){

			$('body').css('overflow-x', 'hidden');

			$('.owl-carousel').css("width", $('.owl-carousel').parent().width());

			$(window).resize(function(){

				$('.owl-carousel').css("width", $('.owl-carousel').parent().width());
			});
			
			$('.owl-carousel').owlCarousel({
			    items: <?php echo $items_to_display; ?>,
   				// nav:true,
			    loop:true,
			    margin:10,
			    center:true,
			    autoplay:<?php echo $autoplay ? 'true' : 'false'; ?>,
			    autoplayTimeout:<?php echo $time_to_next_slide; ?>000,
			    autoplayHoverPause:true
			});

			$('.owl-carousel').mouseleave(function(){

				$('.owl-carousel').trigger('play.owl.autoplay',[<?php echo $time_to_next_slide; ?>000]);

			});

		});
	</script>
	<?php 

}

function ds_carousel_html($objects = array(), $autoplay = true, $time_to_next_slide = 3, $items_to_display = 3){

	$carousel = "<div class='owl-carousel owl-theme'>";

	foreach($objects as $o){

		$description = strlen($o->description) > 150 ? substr($o->description, 0, 150)."..." : $o->description;

		$title = strlen($o->title) > 50 ? substr($o->title, 0, 50)."..." : $o->title;

		$imageexp = explode("/",$o->poster);

		$image = $imageexp[3];

		$carousel .= "<div class='center-container'>";

		$carousel .= "<a href='".home_url("channels/$o->slug")."' class='vert-center'>";

		$carousel .= "<i class='fa fa-play-circle-o fa-3' aria-hidden='true'></i>";

		$carousel .= "<img class='' src='https://image.dotstudiopro.com/$image/1280/720' />";

		$carousel .= "<div><strong><small>$o->title</small></strong></div>";

		// $carousel .= "<div><small>".$description."</small></div>";

		$carousel .= "</a>";

		$carousel .= "</div>";

	}

	$carousel .= "</div>";

	ds_carousel_instantiate($autoplay, $time_to_next_slide, $items_to_display);

	return $carousel;

}

function ds_carousel_build_objects($ids = array()){

	$objs = array();

	foreach($ids as $id){

		$obj = grab_channel_by_id($id);

		$objs[] = $obj[0];

	}

	return $objs;

}

function ds_carousel_display_shortcode( $atts ) {

	$atts = shortcode_atts( array(

		'channels' => '',
		'autoplay' => true,
		'time_to_next_slide' => 3,
		'items_to_display' => 3

	), $atts, 'ds_carousel_display' );

	if(!count($atts['channels']))
		return;

	if(strpos($atts['channels'], ',') !== false){

		$channels = explode( ',', $atts['channels'] );

	} else {

		$channels = array($atts['channels']);

	}

	$objs = ds_carousel_build_objects( $channels );

	return ds_carousel_html( $objs, $atts['autoplay'], $atts['time_to_next_slide'], $atts['items_to_display'] );

}
add_shortcode( 'ds_carousel_display', 'ds_carousel_display_shortcode' );


function grab_channel_by_id($id){
	
	global $ds_curl;
	
	$channel = $ds_curl->curl_command( 'single-channel-by-id', array( 'channel_slug' => str_replace( " ", "", $id ) ) );
	
	return $channel;
	
}

function ds_carousel_local_channels_list(){

	global $wpdb;

	$channel_parent = get_page_by_path("channels");

	$channels = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."posts WHERE post_parent = ".$channel_parent->ID." ORDER BY post_name ASC");

	$channels_list = "";

	foreach($channels as $ch){

		$channels_list .= "<input type='checkbox' name='channel' value='$ch->post_name'> $ch->post_title<br/>";

	}

	return $channels_list;

}