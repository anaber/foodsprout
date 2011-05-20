<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/jquery.ui.mouse.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/jquery.ui.sortable.js"></script>




<style> 
	.column { width: 315px; float: left; padding-bottom: 20px; }
	.portlet { margin: 0 1em 1em 0; }
	/*.portlet-header { margin: 0.3em; padding-bottom: 4px; padding-left: 0.2em; }*/
	.portlet-header { padding: 5px 5px 5px 10px; }
	.portlet-header .ui-icon { float: right; }
	.portlet-content { padding: 0.4em; }
	.ui-sortable-placeholder { border: 1px dotted black; visibility: visible !important; height: 50px !important; }
	.ui-sortable-placeholder * { visibility: hidden; }
</style> 
<script> 
	$(function() {
		$( ".column" ).sortable({
			connectWith: ".column"
		});
 
		$( ".portlet" ).addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" )
			.find( ".portlet-header" )
				.addClass( "ui-widget-header ui-corner-all" )
				.prepend( "<span class='ui-icon ui-icon-minusthick'></span>")
				.end()
			.find( ".portlet-content" );
 
		$( ".portlet-header .ui-icon" ).click(function() {
			$( this ).toggleClass( "ui-icon-minusthick" ).toggleClass( "ui-icon-plusthick" );
			$( this ).parents( ".portlet:first" ).find( ".portlet-content" ).toggle();
		});
 
		$( ".column" ).disableSelection();
	});
</script> 


<div style = "float:left;padding:0px;">
	
	<div>
		<div style="float:left;width:530px;"><h1>User Dashboard</h1></div>
		<div class="clear"></div>
	</div>
	<div class = "clear"></div>
	
	<div id="resultsContainer" class="pd_tp1">
		<div>
			<div class="column ui-sortable">
			
				<div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-tl">
					<div class="portlet-header ui-widget-header ui-corner-tl">
						<!--<span class="ui-icon ui-icon-minusthick"></span>-->
						Recently Added
					</div>
					<div class="portlet-content" style = "font-size:13px;">List of recently added restaurants / farms</div>
				</div>
				
				<div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all">
					<div class="portlet-header ui-widget-header ui-corner-all">
						<!--<span class="ui-icon ui-icon-minusthick"></span>-->
						My favorites list
					</div>
					<div class="portlet-content" style = "font-size:13px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec et ligula leo. Quisque sem diam, aliquet ac egestas in, commodo condimentum sem. Nulla sagittis dignissim justo id pellentesque. Donec vel metus erat. Pellentesque tellus sem, luctus vitae varius molestie</div>
				</div>
				
				<div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all">
					<div class="portlet-header ui-widget-header ui-corner-all">
						<!--<span class="ui-icon ui-icon-minusthick"></span>-->
						Recent comments I've made
					</div>
					<div class="portlet-content" style = "font-size:13px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec et ligula leo. Quisque sem diam, aliquet ac egestas in, commodo condimentum sem. Nulla sagittis dignissim justo id pellentesque. Donec vel metus erat. Pellentesque tellus sem, luctus vitae varius molestie</div>
				</div>
				
			</div>
			
			<div class="column ui-sortable">
			
				<div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all">
					<div class="portlet-header ui-widget-header ui-corner-all">
						<!--<span class="ui-icon ui-icon-minusthick"></span>-->
						Places I've recently eaten
					</div>
					<div class="portlet-content" style = "font-size:13px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec et ligula leo. Quisque sem diam, aliquet ac egestas in, commodo condimentum sem. Nulla sagittis dignissim justo id pellentesque. Donec vel metus erat. Pellentesque tellus sem, luctus vitae varius molestie</div>
				</div>
				
				<div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all">
					<div class="portlet-header ui-widget-header ui-corner-all">
						<!--<span class="ui-icon ui-icon-minusthick"></span>-->
						My current carbon score/chart
					</div>
					<div class="portlet-content" style = "font-size:13px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec et ligula leo. Quisque sem diam, aliquet ac egestas in, commodo condimentum sem. Nulla sagittis dignissim justo id pellentesque. Donec vel metus erat. Pellentesque tellus sem, luctus vitae varius molestie</div>
				</div>
				
				<div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all">
					<div class="portlet-header ui-widget-header ui-corner-all">
						<!--<span class="ui-icon ui-icon-minusthick"></span>-->
						Topics I'm following
					</div>
					<div class="portlet-content" style = "font-size:13px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec et ligula leo. Quisque sem diam, aliquet ac egestas in, commodo condimentum sem. Nulla sagittis dignissim justo id pellentesque. Donec vel metus erat. Pellentesque tellus sem, luctus vitae varius molestie</div>
				</div>
				
			</div>
		</div>
		<div class="clear"></div>
		
		
		
		
		<!--
		<div style="width: 630px; padding: 0px;" id="resultTableContainer">
		<div style="overflow: auto; padding-bottom: 10px;">
	<div class="listing-header">
<div style="float: left;"><a style="text-decoration: none;" id="175835" href="/farm/changing-seasons-farm-carnation">Changing Seasons Farm</a></div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
	<div class="listing-information">
		<b>Livestock:</b> 
Naturally Grown<br>		<b>Crop:</b> 
Farm Crops 5<br>		<b>Certification:</b> 
Certification 1, Certification 3	</div>
	<div class="listing-address-title">
		<b>Address:</b>
	</div>	<div class="listing-address">
<a style="font-size: 13px; text-decoration: none;" id="map_484239" href="#">722 W Snoqualmie River Road NE<br>Carnation, Washington 89014</a>
<br><br><a style="font-size: 13px; text-decoration: none;" id="map_490190" href="#">111 W. Evelyn Ave. Suite 115<br>Sunnyvale, California 94086</a>
	</div>
	<div class="clear"></div>
</div>
<div class="clear"></div>
<div style="overflow: auto; padding-bottom: 10px;">
	<div class="listing-header">
<div style="float: left;"><a style="text-decoration: none;" id="186046" href="/farm/new-farm-without-any-attribute11-bellevue">New farm without any attribute11</a></div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
	<div class="listing-information">
	</div>
	<div class="listing-address-title">
		<b>Address:</b>
	</div>	<div class="listing-address">
<a style="font-size: 13px; text-decoration: none;" id="map_490191" href="#">938 110th Ave. NE<br>Bellevue, Washington 98004</a>
	</div>
	<div class="clear"></div>
</div>
<div class="clear"></div>
<div style="overflow: auto; padding-bottom: 10px;">
	<div class="listing-header">
<div style="float: left;"><a style="text-decoration: none;" id="175850" href="/farm/sol-to-seed-farm-llc-carnation">Sol to Seed Farm, LLC</a></div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
	<div class="listing-information">
		<b>Livestock:</b> 
Naturally Grown<br>		<b>Crop:</b> 
Farm Crops 15<br>		<b>Certification:</b> 
Certification 1, Certification 2, Certification 4, Certification 6	</div>
	<div class="listing-address-title">
		<b>Address:</b>
	</div>	<div class="listing-address">
<a style="font-size: 13px; text-decoration: none;" id="map_484254" href="#">415 W Snoqualmie River Rd NE<br>Carnation, Washington 98014</a>
	</div>
	<div class="clear"></div>
</div>
<div class="clear"></div>
		</div>
		-->
		
		
		
		
		<div class = "clear"></div>
	</div>
	<div class = "clear"></div>
	
</div>

<div style="float:right; width:160px;">
	<?php
			$this->load->view('includes/banners/sky');
	?>
	<div class = "clear"></div>
</div>
<div class = "clear"></div>

