<?php

?>
<style type="text/css">
table.ds-carousel-admin > tbody > tr > td:first-child {
	text-align:right;
	width:250px;
	vertical-align:top;
}
table.ds-carousel-admin > tbody > tr > td:nth-child(2) {
	width:300px;
	vertical-align:top;
}
table.ds-carousel-admin > tbody > tr > td[colspan="2"] {
	text-align:left;
}
table.carousel-opts > tbody > tr > td {
	padding:2px;
}
#carousel-type {
	width:100%;
}
select.opts-select {
	width:100px;
}
.carousel-list {
	width:300px;
	height:200px;
	overflow-y:scroll;
	font-size:14px;
}
label {
}
</style>

<script type="text/javascript">
var $ = jQuery;
$(document).ready(function() {
	var channels, category, title;


	$('#carousel-type').change(function() {
		$('.carousel-list').css('display','none');
		//var which = '#' + $(this).val() + '-carousel-list';
		var which = $(this).val();
		$('#' + which + '-carousel-list').css('display','block');
		$('#channel-or-cat').text(which);

		$('input[name="channel"]').removeAttr('checked');
		$('input[name="category"]').removeAttr('checked');
		clearVals();
		$('#ds-carousel-built-shortcode').text('');

	});


	$('input[name="category"]').change(function() {
			category = "category='" + $(this).val() + "'";
			displayShortcode();
	});

	$('#title').keyup(function() {
			displayShortcode();
	});

	$('#ds-carousel-built-shortcode').focus(function() {
		$(this).select();
	});

	$('input[name="channel"]').change(function() {
			var channelList = $('input[name="channel"]');
			var channelCount = 0;
			clearVals();

			$.each(channelList,function() {
					if($(this).attr('checked') == 'checked') {
						channels += $(this).val() + ','
						channelCount++;
					}
			});
			if(channelCount != 0) {
				channels = "channels='" + channels.substr(0,channels.length-1) + "'";	
			}
			
			displayShortcode();
	});

	$('.opt-change').change(function() {
		displayShortcode();
	});

	function clearVals() {
		channels = '';
		category = '';
		title = '';

	}

	function getAutoplay() {
		var strOut = " autoplay='"
		strOut +=  $('#opts-autoplay').attr('checked')=='checked' ? 1 : 0
		strOut += "'";
		return strOut;
	}

	function getPauseOnHover() {
		var strOut = " autoplay_hover_pause='"
		strOut +=  $('#opts-autoplayHoverPause').attr('checked')=='checked' ? 1 : 0
		strOut += "'";
		return strOut;
	}


	function getTitle() {
		var strOut = '';
		if($('#title').val() != '') {
			strOut = " title='" + $('#title').val() + "'";
		}
		return strOut

	}

	function displayShortcode() {
		var strOut = '';
		if(category != '' || channels != '') {
			strOut = '[ds_owl_carousel '
			+ category 
			+ channels
			+ " autoplay_timeout='" + $('#opts-autoplayTimeout').val() + "'"
			+ " items='" + $('#opts-items').val() + "'"
			+ " slide_by='" + $('#opts-slide-by').val() + "'"
			+ getAutoplay()
			+ getPauseOnHover()
			+ getTitle()
			+ ']'

		}
		$('#ds-carousel-built-shortcode').text(strOut);
	}


});
</script>


<div class='container'>
	<h2>DS Carousel Shortcode Generator</h2>
		
			<table class='ds-carousel-admin form-table widefat'>
				<thead>
					
				</thead>
				<tbody>
					<tr>
						  <td></td>
						  <td></td>
						  <td></td>
					</tr>						  
					<tr>
						<td colspan="3">
							<div style="width:100%;text-align:left;">
							<b>Select the options below to build a new carousel shortcode.</b>
							</div>
						</td>
					</tr>

				  <tr>
				  	<td><strong>Select your carousel type:</strong></td>
				  	<td><select id="carousel-type">
				  		  <option value="channels">Channels Carousel</option>
				  		  <option value="category">Category Carousel</opion>
				  		  </select>
				  	</td>
				  </tr>
					<tr>
						<td>
							<strong>Select your <lable id="channel-or-cat">channels</label>:</strong>
						</td>
						<td>

							<div  id="channels-carousel-list" class="carousel-list">
							<?php echo ds_carousel_local_channels_list(); ?>
							</div>
							<div id="category-carousel-list" class="carousel-list" style="display:none;">
									<?php 
										$catList = list_categories();
										//var_dump($catList);
										foreach($catList as $cat) {
												$catName = $cat -> name;
												$catSlug = $cat -> slug;
												$strOut = '<input type="radio" name="category" id="category-'.$catName.'" value="'.$catSlug.'">';
												$strOut .= '<label for="category-'.$catName.'">'.$catName.'</label><br />';
												echo $strOut;
										}
										?>
							</div>

						</td>
					</tr>

					<tr>
						<td>
							<strong>Carousel Options:</strong>
						</td>
						<td>
								<table class='carousel-opts'>
								<tr>
										<td>Transition Time:</td>
										<td><select id="opts-autoplayTimeout" class="opts-select opt-change">
												<?php 
												for($i = 1; $i <= 10; $i++) {
													$s = $i != 1 ? 's':'';
													$sel = $i == 3 ? " selected" : "";
													echo '<option value="' . $i .'"'. $sel .'>' . $i . ' second'.$s.'</option>';
												}
												?>
												</select>
										</td>
									</tr>
									<tr>
										<td>Slides to Show:</td>
										<td><select id="opts-items" class="opts-select opt-change">
												<?php 
												for($i = 1; $i <= 8; $i++) {
													$s = $i != 1 ? 's':'';
													$sel = $i == 3 ? " selected" : "";
													echo '<option value="' . $i . '"'. $sel .'>' . $i . ' slide'.$s.'</option>';
												}
												?>
												</select>
										</td>
								</tr>
								<tr>
										<td>Slides per Transition:</td>
										<td><select id="opts-slide-by" class="opts-select opt-change">
												<?php 
												for($i = 1; $i <= 10; $i++) {
													$s = $i != 1 ? 's':'';
													echo '<option value="' . $i . '">' . $i . ' slide'.$s.'</option>';
												}
												?>
												</select>
										</td>
									</tr>
								<tr>
										<td>Autoplay:</td>
										<td><input type="checkbox" id="opts-autoplay" checked class="opt-change"></td>
								</tr>
								<tr>
										<td>Pause On Hover:</td>
										<td><input type="checkbox" id="opts-autoplayHoverPause" checked class="opt-change"></td>
								</tr>
								</table>
						</td>
					</tr>
				  <tr>
				  	<td><strong>Carousel Title:</strong><br />(leave blank for default)</td>
				  	<td><input type="text" id="title" value="" style="width:300px;"/>
				  	</td>
				  </tr>
				  <tr><td colspan="2"><strong>Copy+paste generated shortcode below:</strong><br /></td></tr>
					<tr>
						<td colspan="2">
							<textarea id='ds-carousel-built-shortcode' readonly style="width: 100%; height: 100px;"></textarea>
						</td>
					</tr>
					
					</tbody>
				</table>
	
</div>
