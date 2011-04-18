<script type="text/javascript">
	$(document).ready(function() {
		 $('input.pick-winner').click( function() {
			 
		        var id = $(this).attr('id');
		        var row = $('#prize-'+id);
                    $.ajax({
                            type: 'post',
                            url: '<?php echo base_url(); ?>admincp/lottery/draw/<?php echo $this->uri->segment(4)?>',
                            data: 'pick='+id+'&lottery_id=<?php echo $this->uri->segment(4)?>',
                            beforeSend: function() {
                            	row.append('<img id="loader" src="<?php echo base_url(); ?>image/ajax-loader.gif" alt="" />')
                                },
                            success: function() {
                                $('#loader').remove();                               
                                row.append('Winner Already Chosen.');
                                $('#'+id).remove();
                            }
                        });
                    });
				
		       
		    });	
</script>
<table cellpadding="3" cellspacing="0" border="0" id="tbllist" width="60%">	
	<tr>
		<th id="heading_id">Id</th>
		<th id="heading_prize">Prize</th>
		<th id="heading_winner">Winner</th>		
	</tr>
	<?php 
		if (count($PRIZES) > 0) 
		{
			foreach ($PRIZES AS $value)
			{ 
	?>
	<tr>
		<td><?php echo $value->lotteryPrizeId; ?></td>
		<td><?php echo $value->prize; ?></td>
		<td id="prize-<?php echo $value->lotteryPrizeId; ?>"><?php echo $value->winner; ?></td>		
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