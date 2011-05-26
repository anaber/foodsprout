<a href="/restaurant/tag/<?php echo $RESTAURANT->restaurantId ?>" id="tag_restaurant"
   class="tagAte" style="font-size:13px;">I Ate Here</a>

<script type="text/javascript">
function makeNear2there(name,street,city,state) {
    var webpage = document.location.href;
    var txt = "<rem><name>" + name + "</name><street>" + street + "</street><city>" + city + "</city><state>" + state + "</state><webpage>" + webpage + "</webpage></rem>";
    var esctxt = escape(txt);
    window.open('http://www.near2there.com/ReminderFromButton.aspx?share=' + esctxt, '', 'height=600,width=450');
}
</script>

	<?php
		if (!empty ($INFO['url'])) {
	?>
	<div style="float:left;font-size:13px;width:180px;">&nbsp;Website: <a href = "<?php echo prep_url($INFO['url']); ?>" target = "_blank" style="font-size:13px;text-decoration:none;"><?php echo $INFO['url']; ?></a></div>
	<br /><br />
	<?php
		}
	?>
	<?php
		//if (!empty ($INFO['facebook']) || !empty ($INFO['twitter']) ) {
	?>
			<div style="float:left;width:180px;">
	<?php
			if (!empty ($INFO['facebook'])) {
	?>
			<a href = "<?php echo prep_url($INFO['facebook']); ?>" target = "_url"><img src = "<?php echo base_url();?>img/icons/facebook-icon-big.png" border = "0"></a>
	<?php
			}
	?>
	<?php
		if (!empty ($INFO['twitter'])) {
	?>
			<a href = "<?php echo prep_url($INFO['twitter']); ?>" target = "_url"><img src = "<?php echo base_url();?>img/icons/twitter-icon-big.png" border = "0"></a>
	<?php
			}
	?>
	<?php			
			$name = '';
			$streetAddress = '';
			$city = '';
			$state = '';
		
		$producerId = '';
		$addresses = array();
		if (isset ($RESTAURANT)) {
			$name = $RESTAURANT->restaurantName;
			$producerId = $RESTAURANT->restaurantId;
			$addresses = $RESTAURANT->addresses;
		} else if (isset ($FARM)) {
			$name = $FARM->farmName;
			$producerId = $FARM->farmId;
			$addresses = $FARM->addresses;
		} else if (isset ($MANUFACTURE)) {
			$name = $MANUFACTURE->manufactureName;
			$producerId = $MANUFACTURE->manufactureId;
			$addresses = $MANUFACTURE->addresses;
		} else if (isset ($DISTRIBUTOR)) {
			$name = $DISTRIBUTOR->distributorName;
			$producerId = $DISTRIBUTOR->distributorId;
			$addresses = $DISTRIBUTOR->addresses;
		} else if (isset ($FARMERS_MARKET)) {
			$name = $FARMERS_MARKET->farmersMarketName;
			$producerId = $FARMERS_MARKET->farmersMarketId;
			$addresses = $FARMERS_MARKET->addresses;
		}
		
		foreach($addresses as $key => $address) {
			$streetAddress = $address->address;
			$city = $address->city;
			//$city = $address->cityName;
			$state = $address->state;
			$addressId = $address->addressId;
			break;
		}

	?>
			<a onclick="makeNear2there('<?php echo addslashes($name); ?>','<?php echo $streetAddress; ?>','<?php echo $city; ?>','<?php echo $state; ?>');" href="javascript:void(0);">
      		<img src="http://www.near2there.com/images/near2therebutton2.png" alt="near2there" border = "0"/></a>
	<?php
		
	?>
				<br /><br />
				<a href = "/business/claim/<?php echo $producerId . ( !empty($addressId) ? ',' . $addressId : ''); ?>" style = "font-size:13px;">Claim this business</a>
			</div>
	<?php
		//}
	?>