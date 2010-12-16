<div align = "left"><div id="msgbox" style="display:none"></div></div><br /><br />

<form id="menuItem" method="post" <?php echo (isset($MENUITEM)) ? 'action="/admincp/restaurant/save_update"' : 'action="/admincp/restaurant/save_add"' ?>>
<table class="formTable">
	<tr>
		<td width = "25%" nowrap>Menu Item Name</td>
		<td width = "75%">
			<input value="<?php echo (isset($MENUITEM) ? $MENUITEM->menuitemName : '') ?>" class="validate[required]" type="text" name="menuitemName" id="menuitemName"/><br />
		</td>
	</tr>
	
	<tr>
		<td width = "25%" nowrap>Ingredients</td>
		<td width = "75%">
			<textarea value="<?php echo (isset($MENUITEM) ? $MENUITEM->menuitemName : '') ?>" class="validate[required]" name="menuitemName" id="menuitemName" rows="4" cols="30"></textarea><br />
		</td>
	</tr>

	<tr>
		<td width = "25%" colspan = "2">
			<input type = "Submit" name = "btnSubmit" id = "btnSubmit" value = "<?php echo (isset($MENUITEM)) ? 'Update Menu Item' : 'Add Menu Item' ?>">
			<input type = "hidden" name = "restaurant_id" id = "restaurant_id" value = "<?php echo (isset($MENUITEM) ? $MENUITEM->restaurantId : '') ?>">
		</td>
	</tr>

</table>
</form>