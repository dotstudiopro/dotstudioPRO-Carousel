<?php ?>

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
							<?php echo ds_owl_carousel_local_channels_list(); ?>
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
													echo '<option value="' . $i*1000 .'"'. $sel .'>' . $i . ' second'.$s.'</option>';
												}
												?>
												</select>
										</td>
									</tr>
								<tr>
										<td>Transition Speed:</td>
										<td><select id="opts-autoplaySpeed" class="opts-select opt-change">
												<?php 
												for($i = 1; $i <= 5; $i++) {
													$s = $i != 1 ? 's':'';
													$sel = $i == 1 ? " selected" : "";
													echo '<option value="' . $i*1000 .'"'. $sel .'>' . $i . ' second'.$s.'</option>';
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
										<td>Autoplay Direction:</td>
										<td><select id="opts-rtl" class="opts-select opt-change">
												<option value="0">Left To Right</option>
												<option value="1">Right To Left</option>
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
								<tr>
										<td>Navigation Dots:</td>
										<td><input type="checkbox" id="opts-dots" class="opt-change"></td>
								</tr>
								<tr>
										<td>Navigation Buttons:</td>
										<td><input type="checkbox" id="opts-nav" class="opt-change"></td>
								</tr>
								<tr>
										<td>No Title:</td>
										<td><input type="checkbox" id="opts-notitle" class="opt-change"></td>
								</tr>
								<tr>
									  <td>Animation In:</td>
									  <td><?php echo ds_owl_admin_animation_select('opts-animate-in','animate-type opt-change'); ?></td>
								</tr>
								<tr>
									  <td>Animation Out:</td>
									  <td><?php echo ds_owl_admin_animation_select('opts-animate-out','animate-type opt-change'); ?></td>
								</tr>
								</table>
						</td>
					</tr>
					<tr>
							<td colspan="3">
								<table class="titleinfo">
								<tbody>
							  <tr>
							  	<td style="width:200px;">&nbsp;</td>
							  	<td><strong>Carousel Title:</strong><br />(leave blank for default)</td>
							  	<td><input type="text" id="title" value="" class="textinput" style="width:300px;"/>
							  	</td>
							  </tr>
							  <tr>
							  	<td></td>
							  	<td><strong>Title CSS Class:</strong><br />(leave blank for none)</td>
							  	<td><input type="text" id="titleclass" class="textinput" value="" style="width:300px;"/>
							  	</td>
							  </tr>
								</tbody>
								</table>
							</td>
						</tr>
					</table>
				<div id="ds-shortcode">
							<label>Copy+paste generated shortcode below:</label><br />
							<textarea id="ds-carousel-built-shortcode" readonly></textarea>
				</div>
</div>
