<script type="text/javascript">
  jQuery(function($){
    $('#addDetails').submit(function(){ 
      $.post($(this).attr('action'),$(this).serialize(), function(html) { 
        $('#response').html(html);
      })
      return false
    })
  }); 


$(function() {

	$('#consumed_date').datepick({dateFormat: 'yyyy-mm-dd', showOnFocus: true});
	
});
</script>

<div id="response">
	<h1>Add details </h1>
	<form name="addDetails" id="addDetails" method="POST" action="<?php echo base_url(); ?>product/addeaten">
	<input type="hidden" name="form_id"  id="form_id" value="<?php echo $unique_form_id; ?>" />
	<input type="hidden" name="product_id"  id="product_id" value="<?php echo $product_id; ?>" />
	<div id="selectLocation"> 
			<?php
				if(isset($addressList) && sizeof($addressList) > 0 && $addressList != FALSE ){
				 
					echo '<ul id="addressList">';
					foreach($addressList as $address){	
						
						echo '<li>
									<input style="float:left" type="radio" name="address_id" value="'.$address->address_id.'">
									<label><strong>'.$address->city.'</strong>, '.$address->address.'</label>
							</li>';
						
					}
					echo '</ul>';
					
				}
				
			?>
		</div>
		<div id="addComment">
			<label for="comment">Comment</label><br />
			<textarea id="comment" name="comment" rows="5" cols="46"></textarea>
		</div>
		<div id="consumedDate">
			<label>Consumed Date:</label> 
			<input type="text" name="consumed_date" id="consumed_date" value="<?php echo date("Y-m-d", time());?>" />
		</div>
		<div id="rating">
			<label>Rating:</label> 
			<input type="radio" value="1" name="rating" /> 1
			<input type="radio" value="2" name="rating" /> 2
			<input type="radio" value="3" name="rating" /> 3
			<input type="radio" value="4" name="rating" /> 4
			<input type="radio" value="5" name="rating" /> 5
		</div>
		
		<div id="Submit">
			<input type="submit" value="Save" />
		</div>
	</form>
</div>

