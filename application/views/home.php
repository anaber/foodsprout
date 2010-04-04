<div id="homeMain">
		<strong class="redtxt">Our mission is to map the world's food chain, start exploring it with us</strong><br><br>
			<div id="box1">
				Products
			</div>
			<div id="box2">
				Manufactures
			</div>
			<div id="box3">
				Food Web
			</div>
			<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
	
</div>
		
<br>

<div id="homeleftbox">
			<img src="/images/rest.jpg" border="0" align="left" style="margin-right: 5px;"><span class="redtxt"><b>Restaurants in Your Area</b></span><br><span style="font-size:12px;">Learn what Restaurants in your area have joined us in telling <b>YOU</b> where its food comes from!</span><br><br>
			<div align="center">
			<?php
			
				echo form_open('search/restaurant');
				$data = array(
				              'name'        => 'restaurant_list',
				              'id'          => 'restaurant_list',
				              'value'       => '',
				              'maxlength'   => '5',
				              'size'        => '10'
				            );

				echo 'Zip Code: '.form_input($data).' ';
				echo form_submit('submit', 'Find');
				echo '</form>';
			
			?>
			</div>
</div>

<div id="homerightbox">
	<div style="padding-left:5px;">
		<span class="greentxt">Food Resources &amp; FAQs</span><br><br>
		<div style="float:left; width:220px; font-size:12px;">
			Resources for Moms<br>
			Where Food REALLY Comes From<br>
			<br>
		</div>

		<div style="float:right; width:225px; font-size:12px;">
			Our Mission<br>
			Sites We Recommend<br>
			FAQs
		</div>			
	</div>
</div>