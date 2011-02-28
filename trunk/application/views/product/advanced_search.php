<form name="advanced_search" method="post" action="<?php echo base_url();?>product/search">
	<div id="search_field">
		<label>Search for food: </label>
		<input type="text" name="search_term" id="search_term" value="<?php if(isset($search_term)) echo $search_term;?>" />
		<input type="submit" name="search_btn" id="search_btn" value="Search" />
	</div>
</form>

<hr />