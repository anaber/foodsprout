<?php $this->load->view('includes/home_header'); ?>

<table width="1004" border="0" cellpadding="0" cellspacing="0" class="home_table">
	<tr>
		<td width="356" valign="top"><span class="greentxt">Search For</span> <span style="font-size: 11px; color: #666;">(i.e. BigMac, salmon, potato chips)<br>
			<div id="rbox">
				
				<?
				
					echo form_open('search/results');
					$data = array(
					              'name'        => 'search',
					              'id'          => 'search',
					              'value'       => '',
					              'maxlength'   => '100',
					              'size'        => '28'
					            );

					echo form_input($data);
					echo form_submit('submit', 'Search');
					echo '</form>';
				
				?>
				
				</div>
				<br><br>
				<span class="greentxt">Browse</span><br>
				<div style="border: 1px solid #000; min-height:290px; background: #198C24 url(/images/grad.gif) repeat-x; color:#FFF; padding: 5px; font-size:14px;">
					Our mission is to map the world's food chain.  Start exploring it through one of the topics below:<br>
					<ul><li><? echo anchor('product', 'Products'); ?></li>
					<li><? echo anchor('company', 'Companies & Brands'); ?></li>
					<li><? echo anchor('farm', 'Farms'); ?></li>
					<li><? echo anchor('processing', 'Processing Facilities'); ?></li>
					<li><? echo anchor('distribution', 'Distribution Centers'); ?></li>
					<li><? echo anchor('meat', 'Meats'); ?></li>
					<li><? echo anchor('vegetable', 'Vegetables'); ?></li>
					</ul>
				</div>
			</td>
			
		<td width="648" class="home_td">
			<a href="/index.php/map"><img src="/images/explore-map.jpg" border="0"></a>
			</td>
	</tr>
</table>

<table width="1004" border="0" cellpadding="0" cellspacing="0" class="home_table">
	<tr>
		<td width="502" class="home_td">
			<img src="/images/rest.jpg" border="0" align="left" style="margin-right: 5px;"><span class="greentxt">Restaurants in Your Area</span><br><span style="font-size:12px;">Learn what Restaurants in your area have joined us in telling <b>YOU</b> where its food comes from!</span><br><br>
			<div align="center">
			<?
			
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
			</td>
			
		<td width="502" class="home_td" valign="top">
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
			</td>
	</tr>
</table>

<?php $this->load->view('includes/home_footer'); ?>