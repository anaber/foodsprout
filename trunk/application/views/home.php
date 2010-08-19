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

<h1>Explore Your Food's Impact</h1><br/>
<div id="tabs">
<div id="homevtabs">
	<br/><ul>
		<li><a href="#tabs-1">Near Me</a></li>
		<li><a href="#tabs-2">From the Grocery</a></li>
		<li><a href="#tabs-3">From the Source</a></li>
		<!-- li><a href="#tabs-4">Recommendations</a></li -->
		<li><a href="#tabs-5">Resources</a></li>
	</ul>
</div>

<div style="float:left; width:490px;" class="ui-tabs">
	
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
	<div style="padding:5px; border-bottom:1px solid #000;">
	<img src="/img/news-twitter-bird.png" align="left"><h3>Food Sprout on Twitter</h3>
	<?php
		foreach ($TWITTERDATA as $r) {
			echo '<a href="'.$r['link'].'" style="text-decoration:none;"><span style="font-size:12px;">'.$r['description'].'</span></a><br/><br/>';
		}
	?>
	</div><br/>
	<!-- div style="border-top:1px solid #000; padding:5px;">
	<h3>Food Sprout Blog</h3>
	<?php
		foreach ($BLOGDATA as $key) {
			echo $key['title'];
			echo '<br><span style="font-size:11px;">'.$key['description'].'</span>';
		}
	?>
	</div><br/ -->
	<?php $this->load->view('includes/banners/medrec'); ?>
	<br/><!-- div id="homeleftbox">
		<a href="/map"><img src="/img/map-home.jpg" border="0" width="300"></a><span class="redtxt"><br/><b>Food Sources in Your Area</b></span><br><br><span style="font-size:14px;">Start using <a href="/map">our interactive map</a> to learn where your food comes from AND what's in it...</span><br><br -->		
	</div>
</div>