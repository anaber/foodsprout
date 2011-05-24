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
	.portlet-content { font-size:13px; padding:0px 5px 5px 10px; }
	.portlet-content2 { font-size:13px; padding:0px 5px 5px 5px; }
	.ui-sortable-placeholder { border: 1px dotted black; visibility: visible !important; height: 50px !important; }
	.ui-sortable-placeholder * { visibility: hidden; }
</style> 
<script>
	column_1 = 'Col 1';
	column_2 = 'Col 2';
	
	$(function() {
		$( ".column" ).sortable({
			connectWith: ".column",
			cursor: 'crosshair',
			//disabled: true,
			stop: function(event, ui) { 
				
				$(".column").each(function() {
					columnId = $(this).attr('id');
					if (columnId == 'column_1') {
						column_1 = $(this).sortable("toArray");
					} else if (columnId == 'column_2') {
						column_2 = $(this).sortable("toArray");
					}
				});
				
				$.post("/portlet/save_portlet_position", { column_1: column_1, column_2:column_2, page:'<?php echo $PAGE; ?>' },
				function(data){
					//alert(data);
				});
			}
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

<?php
if ( isset($PORTLET) && count($PORTLET) > 0 ) {
	
} else {
	$PORTLET = getDefaultPortletPosition($PAGE);
}
?>
<div style = "float:left;padding-left:5px;width:795px;">
	
	
	<div class = "clear"></div>
	
	<div id="resultsContainer" class="pd_tp1">
		<div>
			<?php
				foreach($PORTLET as $column => $array) {
			?>
			<div class="column ui-sortable" id = "<?php echo $column; ?>">
			<?php
					foreach($array as $key => $portlet) {
						$this->load->view($PAGE . '/portlet/' . $portlet);
					}
			?>
			</div>
			<?php
				}
			?>
			
		</div>
		<div class="clear"></div>
		
	</div>
	<div class = "clear"></div>
	
</div>


<div class = "clear"></div>

