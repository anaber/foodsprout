<table cellpadding="3" cellspacing="0" border="0" id="tbllist" width="60%">	
	<tr>
		<th id="heading_id">Id</th>
		<th id="heading_user">Prize</th>
		<th id="heading_firstName">Winner</th>		
	</tr>
	<?php 
		if (count($WINNERS) > 0) 
		{
			foreach ($WINNERS AS $value)
			{ 
	?>
	<tr>
		<td><?php echo $value->lotteryPrizeId; ?></td>
		<td><?php echo $value->prize; ?></td>
		<td><?php echo $value->winner; ?></td>		
	</tr>
	<?php 
			} 
		}
		else
		{
	?>
	<tr>
		<td colspan="3">No entries available.</td>
	</tr>
	<?php } ?>
</table>