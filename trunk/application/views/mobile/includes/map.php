<div id = "small_map">
	<div id="small_map_canvas" style="width: 200px; height: 200px"><?php echo $map['html']; ?></div>
	<div id="address" ><?php if(isset($address[0]['address'])){ echo $address[0]['address']; }?></div>
	<div id="zipcode"><?php if(isset($address[0]['zipcode'])){ echo $address[0]['zipcode']; }?></div>
	<div id="city"><?php echo isset($address[0]['city']) ? $address[0]['city']: ''; ?></div>
</div>
	