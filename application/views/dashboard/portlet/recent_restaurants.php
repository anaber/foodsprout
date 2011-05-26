			<div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-tl" id = "recent_restaurants">
					<div class="portlet-header ui-widget-header">
						<!--<span class="ui-icon ui-icon-minusthick"></span>-->
						Recently Added
					</div>
					<div class="portlet-content">
						<table width="100%" border="0" cellpadding="3" cellspacing="0">
					<?php
						if (count($RECENT_PRODUCERS) > 0) {
					?>	
							<tr style="background:#f8f8f8;">
								<td style = "padding-left:4px;">Restaurant/Farm</td>
								<td>Date Added</td>
							</tr>
					<?php
							foreach($RECENT_PRODUCERS as $key => $producer) {
					?>
							<tr style="border-bottom:1px solid #aaa;padding-left:4px;">
								<td><?php echo $producer->producer; ?></td>
								<td><?php echo $producer->dateAdded; ?></td>
							</tr>
					<?php
							}
						} else {
					?>
							<tr style="border-bottom:1px solid #aaa;padding-left:4px;">
								<td>You have not added any data yet</td>
							</tr>
					<?php
						}
					?>
						</table>
					</div>
				</div>