<style type="text/css">
	.formTable td.header
	{
		text-align: right;
		vertical-align: top;
		width: 30%;
	}
</style>
<script type="text/javascript">	
	$(document).ready(function() {
		$('.select-producer').click(function(e) {
			e.preventDefault();
			
		});
	});
</script>
<form name="newsfeedForm" action="<?php echo current_url(); ?>" method="post">
	<table class="formTable">
		<tr>
			<td class="header">Title: </td>
			<td width="70%"><input type="text" name="title" size="45" /></td>			
		</tr>
		<tr>
			<td class="header">Content: </td>
			<td>
				<textarea name="content" rows="10" cols="52"></textarea>
			</td>
		</tr>
		<tr>
			<td class="header">Producer: </td>
			<td><a href="#" class="select-producer">Select Producer</a></td>
		</tr>
		<tr>
			<td class="header">Product: </td>
			<td><a href="#" class="select-product">Select Product</a></td>
		</tr>
		<tr>
			<td align="center" colspan="2"><input type="submit" name="save" value="Save" /></td>
		</tr>
	</table>
</form>
<div id="popupContact">
			
</div>