<?php 

function ds_carousel_check_main_plugin() {
	
    ?>

    <div class="update-nag">
        <p>dotstudioPRO Premium Video plugin is either not installed or is inactive.  The dotstudioPRO Premium Carousel plugin has been deactivated.</p>
    </div>

    <?php

}


function ds_carousel_owl_carousel(){
	
	wp_enqueue_scripts(
	'ds-plugin-style',
	plugin_dir_url( __FILE__ ) . 'js/owl.carousel.min.js'
	);
		
}

function ds_carousel_html($objects = array(), $autoplay = true){

	$carousel = "<div class='owl-carousel'>";

	foreach($objects as $o){

		$carousel .= $o;

	}

	$carousel .= "</div>";

	return $carousel;

}

function ds_carousel_build_objects($type = "video", $ids = array()){

	

}
