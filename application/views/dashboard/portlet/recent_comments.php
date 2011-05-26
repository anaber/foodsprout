				<div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" id = "recent_comments">
					<div class="portlet-header ui-widget-header ui-corner-all">
						<!--<span class="ui-icon ui-icon-minusthick"></span>-->
						Recent comments I've made
					</div>
					<div class="portlet-content">
						<table width="100%" border="0" cellpadding="3" cellspacing="0">
					<?php
						if (count($RECENT_PRODUCERS) > 0) {
					
							foreach($RECENT_COMMENTS as $key => $comment) {
					?>
							<tr style="border-bottom:1px solid #aaa;padding-left:4px;">
								<td><?php echo $comment->comment; ?></td>
								<td><?php echo $comment->addedOn; ?></td>
							</tr>
							<tr style="border-bottom:1px solid #aaa;padding-left:4px;">
								<td colspan = "2"><hr size="1" class="listing-dash-line1"></td>
							</tr>
					<?php
							}
						} else {
					?>
							<tr style="border-bottom:1px solid #aaa;padding-left:4px;">
								<td>You have not shared any comment yet</td>
							</tr>
					<?php
						}
					?>
						</table>
					</div>
				</div>