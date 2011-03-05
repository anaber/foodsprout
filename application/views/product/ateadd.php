<script type="text/javascript">
  jQuery(function($){
    $('#addDetails').submit(function(){ 
      $.post($(this).attr('action'),$(this).serialize(), function(html) { 
        $('#response').html(html);
      })
      return false
    })
  })
</script>

<h1>Add details </h1>

<div id="response"></div>
<form name="addDetails" id="addDetails" method="POST" action="<?php echo base_url(); ?>product/addeaten">
	<div id="selectLocation"> 
		<?php
			if(isset($addressList) && sizeof($addressList) > 0 && $addressList != FALSE ){
			 
				echo '<ul id="addressList">';
				foreach($addressList as $address){	
					
					echo '<li>
								<input style="float:left" type="radio" name="addressId" value="'.$address->address_id.'">
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
	
	</div>
	<div id="rating">
	
	</div>
	
	<div id="Submit">
		<input type="submit" value="Save" />
	</div>
</form>

