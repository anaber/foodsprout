<script>
	
	$(document).ready(function() {
		$("#exploreFastFood").click(function(e) {
			e.preventDefault();
			document.frmExploreFood.submit();
		});	
	});
	
</script>



<h1>Food Sprout - Your Sustainable Food Guide</h1><br/>
	
<div id="tabs" style="clear:left;">

<div style="float:left; width:650px;" class="ui-tabs">
<div style="float:left; width:650px;">
		<?php		
			$this->load->view('home/restaurant');
		?>
</div>
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