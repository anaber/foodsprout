<script>
	/*
	$(document).ready(function() {
		loadMapOnStartUp(38.41055825094609, -98, 3);
	});
	*/
</script>

		
<div id="restaurantname">
    <div id="logorestaurant"><?php echo '<h1>'.$RESTAURANT->restaurantChain.'</h1>';?></div> 
  </div>
  
  <!-- left column-->
  <div id="rest-main-details">	
    <div id="rest-main-img"><img src="/img/applebee-img.jpg" width="211" height="143" alt="apple-img" /></div>
    
    <div id="rest-dec">
      <div id="dec-head"><img src="/img/decription-icon.jpg" width="106" height="22" alt="dec-head" /></div>
      <div id="description-details">Welcome to our neighborhood! Applebee's Neighborhood Grill and Bar is the world's casual dinting leader, with over 2000 restaurants in 49 states</div>
    </div>
    
    <div id="location-icon"><img src="/img/location-head-icon.jpg" width="89" height="23" alt="location-head-icon" /></div>
    
    <div id="map"><iframe width="210" height="100" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=Restaurants+near+Applebee,+Wright+City,+MO,+United+States&amp;sll=42.550596,-99.730534&amp;sspn=46.743437,96.328125&amp;ie=UTF8&amp;hq=Restaurants&amp;hnear=Applebee,+Wright+City,+Warren,+Missouri+63390&amp;ll=38.820785,-91.126785&amp;spn=0.006687,0.017939&amp;z=14&amp;output=embed"></iframe>
	<br>
	<div style="color:#333;">
	<?php echo '<h1>'.$RESTAURANT->restaurantURL.'</h1>';?><br>
	</div>
    </div>
  </div>
  <!-- end left column -->
  
  <!-- center tabs -->
  <div id="tabinfo">
  
    <div id="menu-bar"> 
      <div id="suppliers">  <a href="#">Suppliers</a></div>
      <div id="menu">    <a href="#">Menu</a></div>
      <div id="comments">    <a href="#">Comments</a></div>
      <div id="add-menu"><a href="#">+ Add Menu</a></div>
    </div>
    
  	<div id="menus"> 
		
		<?php
			$this->load->view('restaurant/menu');
		?>
	
	</div>
	
  </div>
  <!-- end center tabs -->
  
  <!-- right ads -->
  <div id="add-designs">
      	<?php
			$this->load->view('includes/left/ad');
		?>
  </div>
  <!-- end right ads -->