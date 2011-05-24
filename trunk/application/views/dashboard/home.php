<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/jquery.ui.mouse.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/jquery.ui.sortable.js"></script>




<style> 
	.column { width: 395px; float: left; padding-bottom: 20px; }
	.portlet { margin: 0 1em 1em 0; }
	/*.portlet-header { margin: 0.3em; padding-bottom: 4px; padding-left: 0.2em; }*/
	.portlet-header { padding: 5px 5px 5px 10px; }
	.portlet-header .ui-icon { float: right; }
	.portlet-content { padding: 0; }
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


<div style = "float:left;padding-left:5px;width:795px;">
	
	
	<div class = "clear"></div>
	
	<div id="resultsContainer" class="pd_tp1">
		<div>
			<div class="column ui-sortable">
			
				<div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-tl">
					<div class="portlet-header ui-widget-header">
						<!--<span class="ui-icon ui-icon-minusthick"></span>-->
						Recently Added
					</div>
					<div class="portlet-content" style = "font-size:13px;"><table width="100%" border="0" cellpadding="3" cellspacing="0"><tr style="background:#f8f8f8;"><td>Restaurant/Farm</td><td>Date Added</td></tr><tr style="border-bottom:1px solid #aaa;"><td>Andrew's BBQ</td><td>January 3, 2011</td></tr><tr style="border-bottom:1px solid #aaa;"><td>Deepak's Mexican</td><td>January 5, 2011</td></tr><tr style="border-bottom:1px solid #aaa;"><td>Oola SF</td><td>January 7, 2011</td></tr></table></div>
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
		
		
		<div class = "clear"></div>
	</div>
	<div class = "clear"></div>
	
</div>


<div class = "clear"></div>

