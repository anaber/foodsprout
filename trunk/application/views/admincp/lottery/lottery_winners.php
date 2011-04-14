<table cellpadding="3" cellspacing="0" border="0" id="tbllist" width="60%">	
	<tr>
		<th id="heading_id">Id</th>
		<th id="heading_user">E-mail</th>
		<th id="heading_firstName">Name</th>
		<th id="heading_date">Enroll Date</th>
	</tr>
	<?php 
		if (count($ENTRIES) > 0) 
		{
			foreach ($ENTRIES AS $value)
			{ 
	?>
	<tr>
		<td><?php echo $value->userId; ?></td>
		<td><?php echo $value->email; ?></td>
		<td><?php echo $value->firstName; ?></td>
		<td><?php echo $value->joinDate; ?></td>
	</tr>
	<?php 
			} 
		}
		else
		{
	?>
	<tr>
		<td colspan="4">No entries available.</td>
	</tr>
	<?php } ?>
</table>