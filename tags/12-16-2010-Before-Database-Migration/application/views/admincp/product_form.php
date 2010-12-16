<div align = "left"><div id="msgbox" style="display:none"></div></div><br /><br />

<form id="product" method="post" <?php echo (isset($MENUITEM)) ? 'action="/admincp/product/save_update"' : 'action="/admincp/product/save_add"' ?>>
<table class="formTable">
	<tr>
		<td width = "25%" nowrap>Product Name</td>
		<td width = "75%">
			<input value="<?php echo (isset($MENUITEM) ? $MENUITEM->menuitemName : '') ?>" class="validate[required]" type="text" name="menuitemName" id="menuitemName"/><br />
		</td>
	</tr>
	
	<tr>
		<td width = "25%" nowrap>Ingredients - Items</td>
		<td width = "75%">
			<textarea value="<?php echo (isset($MENUITEM) ? $MENUITEM->menuitemName : '') ?>" class="validate[required]" name="menuitemName" id="menuitemName" rows="4" cols="30"></textarea><br />
		</td>
	</tr>

	<tr>
		<td width = "25%" colspan = "2">
			<input type = "Submit" name = "btnSubmit" id = "btnSubmit" value = "<?php echo (isset($MENUITEM)) ? 'Update Product' : 'Add Product' ?>">
			<input type = "hidden" name = "productId" id = "productId" value = "<?php echo (isset($MENUITEM) ? $MENUITEM->productId : '') ?>">
		</td>
	</tr>

</table>
</form>