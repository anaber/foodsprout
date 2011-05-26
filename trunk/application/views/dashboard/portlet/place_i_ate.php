				<div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" id = "place_i_ate">
					<div class="portlet-header ui-widget-header ui-corner-all">
						<!--<span class="ui-icon ui-icon-minusthick"></span>-->
						Places I've recently eaten
					</div>
					<div class="portlet-content">
						<table width="100%" border="0" cellpadding="3" cellspacing="0">
					<?php
						if (count($RECENT_ATE_RESTAURANTS) > 0) {
					?>	
							<tr style="background:#f8f8f8;">
								<td style = "padding-left:4px;">Restaurant</td>
								<td style = "padding-left:4px;">Rating</td>
								<td>Date</td>
							</tr>
					<?php
							foreach($RECENT_ATE_RESTAURANTS as $key => $producer) {
					?>
							<tr style="border-bottom:1px solid #aaa;padding-left:4px;">
								<td><?php echo $producer->producer; ?></td>
								<td><?php echo $producer->rating; ?></td>
								<td><?php echo $producer->consumedDate; ?></td>
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