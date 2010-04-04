<script>

var timeout    = 500;
var closetimer = 0;
var ddmenuitem = 0;

function jsddm_open()
{  jsddm_canceltimer();
   jsddm_close();
   ddmenuitem = $(this).find('ul').css('visibility', 'visible');}

function jsddm_close()
{  if(ddmenuitem) ddmenuitem.css('visibility', 'hidden');}

function jsddm_timer()
{  closetimer = window.setTimeout(jsddm_close, timeout);}

function jsddm_canceltimer()
{  if(closetimer)
   {  window.clearTimeout(closetimer);
      closetimer = null;}}

$(document).ready(function()
{  $('#jsddm > li').bind('mouseover', jsddm_open)
   $('#jsddm > li').bind('mouseout',  jsddm_timer)});

document.onclick = jsddm_close;


</script>


<?php
	if ($this->session->userdata('isAuthenticated') == 1 ) {
?>

<div>

	<ul id="jsddm">
		<li><?php echo anchor('admincp/dashboard', 'Dashboard'); ?></li>
		<li><a href="#">Food Producers</a>
			<ul>
				<li><?php echo anchor('admincp/company', 'Company'); ?></li>
				<li><?php echo anchor('admincp/farm', 'Farm'); ?></li>
				<li><?php echo anchor('admincp/distribution', 'Distribution'); ?></li>
				<li><?php echo anchor('admincp/processing', 'Processing'); ?></li>
				<li><?php echo anchor('admincp/restaurant', 'Restaurant'); ?></li>
			</ul>
		</li>
		<li><a href="#">Food Web</a>
			<ul>
				<li><?php echo anchor('admincp/animal', 'Animals'); ?></li>
			    <li><?php echo anchor('admincp/fish', 'Fish'); ?></li>
				<li><?php echo anchor('admincp/insect', 'Insects'); ?></li>
				<li><?php echo anchor('admincp/plant', 'Plants'); ?></li>
				<li><?php echo anchor('admincp/plantgroup', 'Plant Groups'); ?></li>
			</ul>
		</li>
		<li><?php echo anchor('admincp/ingredient', 'Ingredients'); ?></li>
		<li><?php echo anchor('admincp/product', 'Products'); ?></li>	
		<li><a href="#">Types</a>
			<ul>
				<li><?php echo anchor('admincp/cuisine', 'Cuisines'); ?></li>
				<li><?php echo anchor('admincp/ingredienttype', 'Ingredient Type'); ?></li>
				<li><?php echo anchor('admincp/fruittype', 'Fruit Type'); ?></li>
				<li><?php echo anchor('admincp/meattype', 'Meat Type'); ?></li>
				<li><?php echo anchor('admincp/farmtype', 'Farm Type'); ?></li>
				<li><?php echo anchor('admincp/manufacturetype', 'Manufacture Type'); ?></li>
				<li><?php echo anchor('admincp/producttype', 'Product Type'); ?></li>
				<li><?php echo anchor('admincp/restauranttype', 'Restaurant Type'); ?></li>
				<li><?php echo anchor('admincp/vegetabletype', 'Vegetable Type'); ?></li>
				
			</ul>
		</li>
		
		<li><a href="#">Geo</a>
			<ul>
				<li><?php echo anchor('admincp/state', 'State'); ?></li>
			    <li><?php echo anchor('admincp/country', 'Country'); ?></li>
			</ul>
		</li>
		
		<li><?php echo anchor('admincp/user', 'Users'); ?></li>
		<li><?php echo anchor('admincp/logout', 'Logout'); ?></li>
	</ul>
</div>
<br>

<?php
	}
?>
