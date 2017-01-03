<?php

?>
<div class='container'>
	<h2>dotstudioCarousel Shortcode Builder</h2>
		
			<table class='form-table widefat'>
				<thead>
					
				</thead>
				<tbody>
				
					<tr>
						<td colspan=2>
							<b>Select the options below to build a new carousel shortcode.</b><br/>
						</td>
					</tr>
				
					<tr>
						<td>
							<strong>Select your channels</strong><br/>
							<?php echo ds_carousel_local_channels_list(); ?>
						</td>
					</tr>

					<tr>
						<td>
							<strong>Set your options</strong><br/>
							Time to next slide (in seconds)<input type='text' name='ttns' value='3' /><br/>
							Slides displayed at one time<input type='text' name='displayed' value='3' /><br/>
						</td>

						<td>
							<button id='ds-carousel-builder-finish'>Submit</button>
						</td>
					</tr>

					<tr>
						<td>
							<textarea id='ds-carousel-built-shortcode' style="width: 100%; height: 100px;"></textarea>
						</td>
					</tr>
					
					</tbody>
				<tfoot>
					
				</tfoot>
				</table>
	
</div>

<script>

	document.getElementById('ds-carousel-builder-finish').onclick=function(){
		var channels = document.getElementsByName('channel');
		var vals = "";
		for (var i=0, n=channels.length;i<n;i++) {
		  if (channels[i].checked) 
		  {

		  	if(vals.length > 0){

		  		vals += ",";

		  	}

		  	vals += channels[i].value;


		  }

		}

		document.getElementById('ds-carousel-built-shortcode').innerHTML = "[ds_owl_carousel channel='"+vals+"' time_to_next_slide='"+document.getElementsByName('ttns')[0].value+"' items_to_display='"+document.getElementsByName('displayed')[0].value+"']"
	}


</script>
