<form id="supplierForm" method="post">
<table class="formTable">
	<tr>
		<td colspan = "2" style="height:5px;"></td>
	</tr>
	
	<tr>
		<td width = "25%" nowrap style="font-size:13px;">Supplier Type</td>
		<td width = "75%">
			<select name="supplierType" id="supplierType" class="validate[required]" style="width: 205px;">
			<option value = ''>--Supplier Type--</option>
			<?php
				foreach ($SUPPLIER_TYPES_2[$TABLE] as $key => $value) {
					echo '<option value="'.$key.'"' . (  ( isset($SUPPLIER) && ( $key == $SUPPLIER->supplierType )  ) ? ' SELECTED' : '' ) . '>' . $value . '</option>';
				}
			?>
			</select>
		</td>
	</tr>
	
	<tr>
		<td width = "25%" nowrap style="font-size:13px;">Company</td>
		<td width = "75%">
			<input type="text" id="companyAjax" value="<?php echo (isset($SUPPLIER) ? $SUPPLIER->companyName : '') ?>" style="width: 200px;"  class="validate[required]" />
		</td>
	</tr>
	<tr>
		<td colspan = "2" align = "right" style = "padding-right:16px;">
			<input type = "Submit" name = "btnSubmit" id = "btnSubmit" value = "Add Comment">
		</td>
	</tr>
</table>
</form>