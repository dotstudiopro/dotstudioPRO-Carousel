<?php 

function ds_owl_carousel_check_main_plugin() {
	
    ?>

    <div class="update-nag">
        <p>dotstudioPRO Premium Video plugin is not installed, is inactive, or the version is too low for this add-on.  The dotstudioPRO Premium Owl Carousel plugin has been deactivated.</p>
    </div>

    <?php

}

function ds_owl_admin_animation_select($name,$className='') {
	$aryAnimations = ['bounce','flash','pulse','rubberBand','shake','swing','tada','wobble','jello','bounceIn','bounceInDown','bounceInLeft','bounceInRight','bounceInUp','bounceOut','bounceOutDown','bounceOutLeft','bounceOutRight','bounceOutUp','fadeIn','fadeInDown','fadeInDownBig','fadeInLeft','fadeInLeftBig','fadeInRight','fadeInRightBig','fadeInUp','fadeInUpBig','fadeOut','fadeOutDown','fadeOutDownBig','fadeOutLeft','fadeOutLeftBig','fadeOutRight','fadeOutRightBig','fadeOutUp','fadeOutUpBig','flipInX','flipInY','flipOutX','flipOutY','lightSpeedIn','lightSpeedOut','rotateIn','rotateInDownLeft','rotateInDownRight','rotateInUpLeft','rotateInUpRight','rotateOut','rotateOutDownLeft','rotateOutDownRight','rotateOutUpLeft','rotateOutUpRight','hinge','rollIn','rollOut','zoomIn','zoomInDown','zoomInLeft','zoomInRight','zoomInUp','zoomOut','zoomOutDown','zoomOutLeft','zoomOutRight','zoomOutUp','slideInDown','slideInLeft','slideInRight','slideInUp','slideOutDown','slideOutLeft','slideOutRight','slideOutUp'];
	$strOut = '<select name='.$name.' id='.$name.' class="'.$className.'" disabled=disabled>';
	$strOut .= '<option value="">-- None --</option>';
	for($i = 0; $i <= count($aryAnimations)-1; $i++) {
		$strOut .= '<option value='.$aryAnimations[$i].'>'.$aryAnimations[$i].'</option>';
	}
	$strOut .= '<select>';
	return $strOut;

}



function ds_owl_carousel(){
	
	wp_enqueue_script( 'owl-carousel', plugin_dir_url( __FILE__ ) . 'js/owl.carousel.min.js', array('jquery') );
	wp_enqueue_script( 'owl-carousel-custom', plugin_dir_url( __FILE__ ) . 'js/owl.carousel.custom.min.js' );
	wp_enqueue_style( 'owl-carousel-min', plugin_dir_url( __FILE__ ) . 'css/owl.carousel.min.css' );
	wp_enqueue_style( 'ds-font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css');

}

function ds_owl_carousel_html($args){

	if($args['channels'] !== '') {
			// generate the code for showing items within a channel
		return ds_owl_channel_html($args);
	} 
	if($args['category'] !== '') {
			// generate the code for showing items within a category
		return ds_owl_category_html($args);
	}

}


function ds_owl_category_html($args) {

	$category_slug = $args['category'];
	$category = get_page_by_path( '/channel-categories/' . $category_slug, OBJECT );
	$title = $args['title'] !== '' ? $args['title'] : $category->post_title;
	$opts = ds_owl_create_opts($args);
	$rndId = ds_owl_carousel_rnd_id(5);

	$carousel =  "<div id='owl-carosel-width-$rndId' class='owl-carousel-width'></div>";
	$carousel .= "<div class='owl-carousel-title' style='position:relative;'><h2>$title</h2><a class='owl-carousel-ellipsis' href='/channel-categories/$category_slug/' title='More...'>...</a></div>";
	$carousel .= "<div class='owl-carousel owl-theme' id='owl-carousel-$rndId' data-options='$opts'>";
			
	$catItems = grab_category($category_slug);
	$title = $channels->title;


	if($catItems && is_array($catItems)){

		foreach($catItems as $ch) {
			// iterate thru the channels, get the applicable thumbnails, create the HTML output

			$id =  $ch->_id;
			$thumb_id = isset( $ch->videos_thumb ) ?  $ch->videos_thumb : '';
			$slug =  $ch->slug;
			$spotlight_poster = isset( $ch->spotlight_poster ) ?  $ch->spotlight_poster : '';

			$carousel .= "<div class='center-container item'>";
			$carousel .= "	<a href='".home_url("channels/$slug")."' class='vert-center'>";
			$carousel .= "		<div>";
			$carousel .= "			<img class='' src='$spotlight_poster/1280/720' />";
			$carousel .= "		</div>";
			$carousel .= "	</a>";
			$carousel .= "</div>";				
		}
	}

	$carousel .= "</div>";
	return $carousel;
}


function ds_owl_channel_html($args) {

	if(strpos($args['channels'], ',') !== false){
		$channels = explode( ',', $args['channels'] );
	} else {
		$channels = array($args['channels']);
	}
	$rndId = ds_owl_carousel_rnd_id(5);
	$objects = ds_owl_carousel_build_objects( $channels );
	$opts = ds_owl_create_opts($args);
	$title = $args['title'] !== '' ? $args['title'] : 'Featured Channels';

	$carousel =  "<div id='owl-carosel-width-$rndId' class='owl-carousel-width'></div>";
	$carousel .= "<div class='owl-carousel-title' style='position:relative;'><h2>$title</h2></div>";
	$carousel .= "<div class='owl-carousel owl-theme' id='owl-carousel-$rndId' data-options='$opts'>";

	foreach($objects as $o){
		$description = strlen($o->description) > 150 ? substr($o->description, 0, 150)."..." : $o->description;
		$title = strlen($o->title) > 20 ? substr($o->title, 0, 20)."..." : $o->title;
		$imageexp = explode("/",$o->poster);
		$image = $imageexp[3];
		$carousel .= "<div class='center-container item'>";
		$carousel .= "	<a href='".home_url("channels/$o->slug")."' class='vert-center'>";
		$carousel .= "		<div>";
		$carousel .= "			<i class='fa fa-play-circle-o fa-3' aria-hidden='true'></i>";
		$carousel .= "			<img class='' src='https://image.dotstudiopro.com/$image/1280/720' />";
		$carousel .= "		</div>";
		$carousel .= "		<div><strong><small class='owl-carousel-subtitle'>$o->title</small></strong></div>";
		$carousel .= "	</a>";
		$carousel .= "</div>";

	}

	$carousel .= "</div>";

	return $carousel;
}


function ds_owl_create_opts($args) {
	unset($args['channels']);
	unset($args['category']);
	unset($args['title']);

	$opts = implode(', ', array_map(
	   function ($v, $k) { return sprintf("%s=%s", trim($k), trim($v)); },
	   $args,
	   array_keys($args)
	));	

	return $opts;
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



function ds_owl_carousel_build_objects($ids = array()){
	$objs = array();
	foreach($ids as $id){
		$obj = ds_owl_grab_channel_by_id($id);
		$objs[] = $obj[0];
	}
	return $objs;
}


function ds_owl_grab_channel_by_id($id) {
	global $ds_curl;
	$channel = $ds_curl->curl_command( 'single-channel-by-id', array( 'channel_slug' => str_replace( " ", "", $id ) ) );
	return $channel;
	
}


function ds_owl_carousel_display_shortcode( $atts ) {


	$args = shortcode_atts( array(

		'channels' => '',
		'category' => '',
		'title' => '',
		'autoplay' => true,
		'dots' => false,
		'autoplay_timeout' => 3000,
		'autoplay_hover_pause' => true,
		'items' => 3,
		'slide_by' => 1,
		'animate_out' => '',
		'animate_in' => '',
		'dots' => false,
		'rtl' => false,
		'nav' => false,

	), $atts, 'ds_owl_carousel' );

	if(!count($args['channels'])  || !count($args['category']))
		return;

	return ds_owl_carousel_html($args);

}
add_shortcode( 'ds_owl_carousel', 'ds_owl_carousel_display_shortcode' );

