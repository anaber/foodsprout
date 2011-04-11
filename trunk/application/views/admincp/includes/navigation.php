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
		<li><?php echo anchor('admincp/queue', 'Dashboard'); ?></li>
		<li><a href="#">Food Producers</a>
			<ul>
				<li><?php echo anchor('admincp/distributor', 'Distributor'); ?></li>
				<li><?php echo anchor('admincp/farm', 'Farm'); ?></li>
				<li><?php echo anchor('admincp/farmersmarket', 'Farmers Market'); ?></li>
				<li><?php echo anchor('admincp/manufacture', 'Manufacturer'); ?></li>
				<li><?php echo anchor('admincp/restaurant', 'Restaurant'); ?></li>
				<li><?php echo anchor('admincp/restaurantchain', 'Restaurant Chain'); ?></li>
				<li><a>---------------</a></li>
				<li><?php echo anchor('admincp/company', 'Conglomerates'); ?></li>
				<li><?php echo anchor('admincp/company', 'Producer Groups'); ?></li>
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

		<li><a href="#">Product</a>
			<ul>
				<li><?php echo anchor('admincp/product', 'All Products'); ?></li>
				<li><?php echo anchor('admincp/product/fructose', 'Products With Fructose'); ?></li>
			</ul>
		</li>

		<li><a href="#">Types</a>
			<ul>
				<li><?php echo anchor('admincp/producercategory', 'Producer Category'); ?></li>
				<li><?php echo anchor('admincp/producercategorygroup', 'Producer Category Group'); ?></li>
				<li><a>---------------</a></li>
				<li><?php echo anchor('admincp/producttype', 'Product Type'); ?></li>
				<li><?php echo anchor('admincp/ingredienttype', 'Ingredient Type'); ?></li>
				<li><?php echo anchor('admincp/fruittype', 'Fruit Type'); ?></li>
				<li><?php echo anchor('admincp/meattype', 'Meat Type'); ?></li>
				<li><?php echo anchor('admincp/vegetabletype', 'Vegetable Type'); ?></li>
			</ul>
		</li>
		
		<li><a href="#">Control</a>
			<ul>
				<li><?php echo anchor('admincp/city', 'City'); ?></li>
				<li><?php echo anchor('admincp/state', 'State'); ?></li>
			    <li><?php echo anchor('admincp/country', 'Country'); ?></li>
			    <li><?php echo anchor('admincp/seo', 'SEO'); ?></li>
			    <li><?php echo anchor('admincp/lottery', 'Lottery'); ?></li>
			</ul>
		</li>
		<li><a href="#">Users</a>
			<ul>
				<li><?php echo anchor('admincp/user', 'Users'); ?></li>
			    <li><?php echo anchor('admincp/usergroup', 'User Groups'); ?></li>
			    
			</ul>
		</li>
		<li><?php echo anchor('admincp/logout', 'Logout'); ?></li>
		<li><?php echo anchor('/', 'Food Sprout Home'); ?></li>
	</ul>
</div>
<br>

<?php
	}
?>
