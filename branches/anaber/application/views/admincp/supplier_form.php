<?php
/*
 * Created on Mar 1, 2010
 *
 * Author: Deepak Kumar
 */
?>
<script>
var documentLocation = '';
<?php
	if ( isset($MANUFACTURE_ID) ) {
?>
		documentLocation = '/admincp/manufacture/add_supplier/<?php echo $MANUFACTURE_ID; ?>';
<?php
	} else if ( isset($FARM_ID) ) {
?>
		documentLocation = '/admincp/farm/add_supplier/<?php echo $FARM_ID; ?>';
<?php
	} else if ( isset($RESTAURANT_ID) ) {
?>
		documentLocation = '/admincp/restaurant/add_supplier/<?php echo $RESTAURANT_ID; ?>';
<?php
	} else if ( isset($DISTRIBUTOR_ID) ) {
?>
		documentLocation = '/admincp/distributor/add_supplier/<?php echo $DISTRIBUTOR_ID; ?>';
<?php
	} else if ( isset($RESTAURANT_CHAIN_ID) ) {
?>
		documentLocation = '/admincp/restaurantchain/add_supplier/<?php echo $RESTAURANT_CHAIN_ID; ?>';
<?php
	} else if ( isset($FARMERS_MARKET_ID) ) {
?>
		documentLocation = '/admincp/farmersmarket/add_supplier/<?php echo $FARMERS_MARKET_ID; ?>';
<?php
	}
?>

var originalCompanyId = <?php echo (isset($SUPPLIER) ? $SUPPLIER->companyId : '""') ?>;

formValidated = true;

$(document).ready(function() {
	
	
	$("#supplierType").change(function () {
		$("#companyAjax").val('');
		$("#companyId").val('');
	});
	
	$("#btnReset").click(function () {
		//$("#supplierForm").reset();
		$(":input").not(":button, :submit, :reset, :hidden").each( function() {
		    this.value = this.defaultValue;
		});
		$("#companyId").val(originalCompanyId);
	});
	
	$("#companyAjax").autocomplete(
		"/admincp/company/get_companies_based_on_type",
		{
			delay:10,
			minChars:3,
			matchSubset:1,
			matchContains:1,
			cacheLength:10,
			onItemSelect:selectItem,
			onFindValue:findValue,
			formatItem:formatItem,
			autoFill:false
		}
	);
	
	$("#companyAjax").change(function () {
		if ($("#companyAjax").val() == "") {
			document.getElementById('companyId').value = '';
		}
	});
	
	// SUCCESS AJAX CALL, replace "success: false," by:     success : function() { callSuccessFunction() }, 
	$("#supplierForm").validationEngine({
		success :  function() {formValidated = true;},
		failure : function() {formValidated = false; }
	});
	
	$("#supplierForm").submit(function() {
		
		$("#msgbox").removeClass().addClass('messagebox').text('Validating...').fadeIn(1000);
		
		companyId = $("#companyId").val();
		
		if (companyId == '') {
			$("#msgbox").fadeTo(200,0.1,function() {
				//add message and change the class of the box and start fading
				$(this).html('Company not selected...').addClass('messageboxerror').fadeTo(900,1);
			});
			return false;
		}
		
		if (formValidated == false) {
			// Don't post the form.
			$("#msgbox").fadeTo(200,0.1,function() {
				//add message and change the class of the box and start fading
				$(this).html('Form validation failed...').addClass('messageboxerror').fadeTo(900,1);
			});
		} else {
			
			var formAction = '';
			var postArray = '';
			var act = '';
			
			if ($('#supplierId').val() != '' ) {
				var formAction = '/admincp/manufacture/supplier_save_update';
				postArray = {
							  supplierType:$('#supplierType').val(),
							  companyId:$('#companyId').val(),
							  companyName:$('#companyName').val(),
							  
							  manufactureId: $('#manufactureId').val(),
							  farmId: $('#farmId').val(),
							  restaurantId: $('#restaurantId').val(),
							  distributorId: $('#distributorId').val(),
							  restaurantChainId: $('#restaurantChainId').val(),
							  farmersMarketId: $('#farmersMarketId').val(),
							   
							  supplierId: $('#supplierId').val()
							};
				act = 'update';		
			} else {
				formAction = '/admincp/manufacture/supplier_save_add';
				postArray = { 
							  supplierType:$('#supplierType').val(),
							  companyId:$('#companyId').val(),
							  companyName:$('#companyName').val(),
							  
							  manufactureId: $('#manufactureId').val(),
							  farmId: $('#farmId').val(),
							  restaurantId: $('#restaurantId').val(),
							  distributorId: $('#distributorId').val(),
							  restaurantChainId: $('#restaurantChainId').val(),
							  farmersMarketId: $('#farmersMarketId').val()
							};
				act = 'add';
			}
			
			$.post(formAction, postArray,function(data) {
				
				if(data=='yes') {
					//start fading the messagebox
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						if (act == 'add') {
							$(this).html('Added...').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location = documentLocation;
							});	
						} else if (act == 'update') {
							$(this).html('Updated...').addClass('messageboxok').fadeTo(900,1, function(){
								//redirect to secure page
								document.location = documentLocation;
							});
						}
					});
				} else if(data == 'no_name') {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Either select existing company or enter new supplier name...').addClass('messageboxerror').fadeTo(900,1);
						
					});
				} else if(data == 'duplicate_company') {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Duplicate Company...').addClass('messageboxerror').fadeTo(900,1);
						
					});
				} else if(data == 'duplicate') {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						$(this).html('Duplicate Supplier...').addClass('messageboxerror').fadeTo(900,1);
					});
				} else {
					//start fading the messagebox 
					$("#msgbox").fadeTo(200,0.1,function() {
						//add message and change the class of the box and start fading
						if (act == 'add') {
							$(this).html('Not added...').addClass('messageboxerror').fadeTo(900,1);
						} else if (act == 'update') {
							$(this).html('Not updated...').addClass('messageboxerror').fadeTo(900,1);
						}
					});
				}
			});
			
		}
		
		return false; //not to post the  form physically
		
	});
	var companyId;
<?php
	if (isset($SUPPLIER)) {
?>
		reinitializeCompanyList();
		companyId = <?php echo $SUPPLIER->companyId; ?>;
		
		function reinitializeCompanyList() {
			var formAction = '/admincp/company/get_companies_based_on_type';
			postArray = { companyType:'<?php echo $SUPPLIER->supplierType; ?>' };
	
			$.post(formAction, postArray, function(data) {
				
				$('#companyId')
				    .find('option')
				    .remove();
				$('#companyId').append($("<option></option>").attr("value",'').text('--Existing Companies--'));
				
				$.each(data.results, function(i, a) {
					if (companyId != '' && companyId == a.id ) {
						$('#companyId').append($("<option></option>").attr("value",a.id).text(a.name).attr("selected",true) );
					} else {
						$('#companyId').append($("<option></option>").attr("value",a.id).text(a.name) );
					}
				});
			},
			"json");
		}
<?php	
	}
?>
	
});
	
	
	
function findValue(li) {
	
	if( li == null ) return alert("No match!");
 
	// if coming from an AJAX call, let's use the CityId as the value
	if( !!li.extra ) var sValue = li.extra[0];
 
	// otherwise, let's just display the value in the text box
	else var sValue = li.selectValue;
 
	//alert("The value you selected was: " + sValue);
	document.getElementById('companyId').value = sValue;	
}
 
function selectItem(li) {
	findValue(li);
}

function formatItem(row) {
	//return row[0] + " (id: " + row[1] + ")";
	return row[0];
}
	
</script>

<script src="<?php echo base_url()?>js/jquery.autocomplete_supplier.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo base_url()?>css/jquery.autocomplete.css" type="text/css" />

<div align = "left"><div id="msgbox" style="display:none"></div></div><br /><br />

<form id="supplierForm" method="post">
<table class="formTable">
	<tr>
		<td width = "25%" nowrap>Supplier Type</td>
		<td width = "75%">
			<select name="supplierType" id="supplierType" class="validate[required]">
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
		<td width = "25%" nowrap>Company</td>
		<td width = "75%">
			<input type="text" id="companyAjax" value="<?php echo (isset($SUPPLIER) ? $SUPPLIER->companyName : '') ?>" style="width: 200px;" />
		</td>
	</tr>
	<tr>
		<td width = "25%" nowrap>New Supplier</td>
		<td width = "75%">
			<input value="" class="validate[optional]" type="text" name="companyName" id="companyName"/><br />
		</td>
	</tr>
	<tr>
		<td colspan = "2" style = "font-size:10px;">
			<ul>
				<li>Select either existing supplier or enter new supplier</li>
				<li>If you do not want to use any of previous records, add new supplier from here.</li>
				<li>Based on the type of supplier selected from first dropdown, new manufacture, distributor, farm, restaurant (and company) will be added.</li>
				<li>Records will be added only if it is unique.</li>
			</ul>
		</td>
	</tr>
	<tr>
        <td width = "25%" nowrap>Status</td>
        <td width = "75%">
            <select name="status" id="status"  class="validate[required]">
                <option value="">--Status--</option>
                <option value="live"<?php echo ((isset($SUPPLIER) && ($SUPPLIER->status == 'live')) ? ' SELECTED' : '') ?>>Live</option>
                <option value="queue"<?php echo ((isset($SUPPLIER) && ($SUPPLIER->status == 'queue')) ? ' SELECTED' : '') ?>>Queue</option>
                <option value="queue"<?php echo ((isset($SUPPLIER) && ($SUPPLIER->status == 'hide')) ? ' SELECTED' : '') ?>>Hide</option>
            </select>
        </td>
    </tr>
	<tr>
		<td width = "25%" colspan = "2">
			<input type = "Submit" name = "btnSubmit" id = "btnSubmit" value = "<?php echo (isset($SUPPLIER)) ? 'Update Supplier' : 'Add Supplier' ?>">
			<input type = "button" name = "btnReset" id = "btnReset" value = "Reset" class = "button">
			
			<input type = "hidden" name = "supplierId" id = "supplierId" value = "<?php echo (isset($SUPPLIER) ? $SUPPLIER->supplierId : '') ?>">
			
			<input type = "hidden" name = "manufactureId" id = "manufactureId" value = "<?php echo (isset($MANUFACTURE_ID) ? $MANUFACTURE_ID : '') ?>">
			<input type = "hidden" name = "farmId" id = "farmId" value = "<?php echo (isset($FARM_ID) ? $FARM_ID : '') ?>">
			<input type = "hidden" name = "restaurantId" id = "restaurantId" value = "<?php echo (isset($RESTAURANT_ID) ? $RESTAURANT_ID : '') ?>">
			<input type = "hidden" name = "distributorId" id = "distributorId" value = "<?php echo (isset($DISTRIBUTOR_ID) ? $DISTRIBUTOR_ID : '') ?>">
			<input type = "hidden" name = "restaurantChainId" id = "restaurantChainId" value = "<?php echo (isset($RESTAURANT_CHAIN_ID) ? $RESTAURANT_CHAIN_ID : '') ?>">
			<input type = "hidden" name = "farmersMarketId" id = "farmersMarketId" value = "<?php echo (isset($FARMERS_MARKET_ID) ? $FARMERS_MARKET_ID : '') ?>">
			<input type = "hidden" name = "companyId" id = "companyId" value = "<?php echo (isset($SUPPLIER) ? $SUPPLIER->companyId : '') ?>">			
		</td>
	</tr>
</table>
</form>

<table cellpadding="3" cellspacing="0" border="0" id="tbllist" width = "50%">
	<tr>
		<th>Id</th>
		<th>Supplier</th>
	</tr>
<?php
	
	$controller = $this->uri->segment(2);
	$i = 0;
	foreach($SUPPLIERS as $supplier) :
		$i++;
		echo '<tr class="d'.($i & 1).'">';
		echo '	<td>'.anchor('/admincp/'.$controller.'/update_supplier/'.$supplier->supplierId, $supplier->supplierId).'</td>';
		echo '	<td>'.anchor('/admincp/'.$controller.'/update_supplier/'.$supplier->supplierId, $supplier->supplierName) . ' <b>(' . substr ( ucfirst($supplier->supplierType), 0, 1 ) . ')</b>' .'</td>';
		echo '</tr>';
 	endforeach;
?>
</table>
