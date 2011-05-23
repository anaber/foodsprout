<div style = "float:left;width:400px;border:0px solid #FF0000;">
	<div id="restaurantname">
		<div id="logorestaurant">
			<h1 style="font-size: 24px;">How can FoodSprout help your restaurant gain more customers?</h1>
			<p class = "business_text">
				Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.	
			</p>
			
			<p class = "business_text">
				Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
			</p>
			<?php 
			if ($this->session->userdata('isAuthenticated') == 1 ) {
				?>
				<strong><h1><a href="/business/register">Upgrade Your Account</a></h1></strong>
				
			<?php }else{ ?> 
			
				<strong><h1><a href="/business/register">Get Started Today</a></h1></strong>
				
				<?php }?>
			
		</div>
	</div>
</div>
<div style = "float:right;margin-right:20px;width:300px;border:0px solid #FF0000;">
	
		Some graphics here
	
	
</div>

