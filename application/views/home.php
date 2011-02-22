<script>
	
	$(document).ready(function() {
		$("#exploreFastFood").click(function(e) {
			e.preventDefault();
			document.frmExploreFood.submit();
		});	
	});
	
</script>
<script src="<?php echo base_url()?>js/jquery-ui-1.8.4.custom.min.js" type="text/javascript"></script>
<script type="text/javascript">
	$(function() {
		$("#tabs").tabs({
			
		});
	});
	</script>

<h1>Food Sprout - Your Sustainable Food Guide</h1>
<hr size="1">
	<div>
		<div style="text-align:right;padding-right:15px;">
			<img src="/img/icon_gift_certificate.jpg" alt="Sustainable Food Gift Certificates" width="59" height="50" style="float:left;clear:left;"><div style="-moz-border-radius: 4px; -webkit-border-radius: 4px; background: #e5e5e5; color: #000; -moz-box-shadow: 0 1px 0 #CCCCCC;-webkit-box-shadow: 0 1px 0 #CCCCCC; padding:5px;overflow:auto;width:680px;float:left;margin-top:10px;margin-left:2px;clear:right;"><a href="/tab">Enter</a> to win FREE gift certificates and other <a href="/tab">offers from Sustainable Restaurants</a> in your area.</div>
		</div>
	</div>
<br/>
<div id="tabs" style="clear:left;">
<div id="homevtabs">
	<br/><ul>
		<li><a href="#tabs-1" style="text-decoration:none;">Near Me</a></li>
		<li><a href="#tabs-2" style="text-decoration:none;">From the Grocery</a></li>
		<li><a href="#tabs-3" style="text-decoration:none;">From the Source</a></li>
		<!-- li><a href="#tabs-4">Recommendations</a></li -->
		<li><a href="#tabs-5" style="text-decoration:none;">Resources</a></li>
	</ul>
</div>

<div style="float:left; width:520px;" class="ui-tabs">
	
		<?php		
			$this->load->view('home/restaurant');
		?>
		<?php		
			$this->load->view('home/products');
		?>
		<?php		
			$this->load->view('home/farm');
		?>
		<?php		
			//$this->load->view('home/recommendations');
		?>
		<?php		
			$this->load->view('home/resources');
		?>
	
</div>

</div>
<div style="float:right; width:300px;">
	<div style="padding:5px;">
	<a href="/about"><img src="/img/home-banner.jpg" alt="Explore Your Food's Impact" width="300" height="250" border="0"></a>
	
	</div><br/>
	<div class="add-data">
		<a href="/user/dashboard"><img src="/img/icon-add.gif" width="60" height="60" alt="Adding Data" align="left" style="padding-right:3px;" border="0"></a>Are we missing your favorite place?  <a href="/user/dashboard">Add it now</a> and other data easily.
	</div>
	<br/>
	<?php $this->load->view('includes/banners/medrec'); ?>
	<br/>
	<div style="padding:5px;">
	<div style="padding:5px;">
	<img src="/img/news-twitter-bird.png" align="left"><h3>Food Sprout on Twitter</h3>
	<?php 
		foreach ($TWITTERDATA as $r) {
				echo '<a href="http://twitter.com/foodsprout" style="text-decoration:none;"><span style="font-size:12px;">'.$r['description'].'</span></a><br/><br/>';
			}
		?>
	<a href="http://www.facebook.com/foodsprout">Follow us on Facebook</a>
	</div>
			
	</div>
</div>