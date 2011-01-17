<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script src="<?php echo base_url()?>js/google_map_v3.js" type="text/javascript"></script>
<div id="map" style="<?php echo (isset($type) && $type == 'supplier' ) ? 'padding-top:10px;' : 'padding-bottom:20px;' ?>">
<div id="map_canvas" style="width: <?php echo $width;?>px; height: <?php echo $height;?>px"></div>
</div>