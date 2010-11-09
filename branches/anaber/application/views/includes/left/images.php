<?php /* ?><div id="rest-main-img"><img src="/img/applebee-img.jpg" width="211" height="143" alt="apple-img" /></div><?php */?>
<?php
	//if (isset($PHOTOS)) {
	if (isset($PHOTOS) && count ($PHOTOS) > 0 ) {
?>
<div id="rest-main-img"><div id="main_image"></div></div>
<script src="<?php echo base_url()?>js/jquery.galleria.pack.js" type="text/javascript"></script>
<script type="text/javascript">
	jQuery(function($) {
		
		$('.gallery_demo_unstyled').addClass('gallery_demo'); // adds new class name to maintain degradability
		
		$('ul.gallery_demo').galleria({
			history   : false, // activates the history object for bookmarking, back-button etc.
			
			show_counter: false,
			show_imagenav: true,
			
			clickNext : true, // helper for making the image clickable
			insert    : '#main_image', // the containing selector for our main image
			onImage   : function(image,caption,thumb) { // let's add some image effects for demonstration purposes
				
				// fade in the image & caption
				if(! ($.browser.mozilla && navigator.appVersion.indexOf("Win")!=-1) ) { // FF/Win fades large images terribly slow
					image.css('display','none').fadeIn(1000);
				}
				caption.css('display','none').fadeIn(1000);
				
				// fetch the thumbnail container
				var _li = thumb.parents('li');
				
				// fade out inactive thumbnail
				_li.siblings().children('img.selected').fadeTo(500,0.3);
				
				// fade in active thumbnail
				thumb.fadeTo('fast',1).addClass('selected');
				
				// add a title for the clickable image
				image.attr('title','next >>');
			},
			
		});
	});
	
	</script> 
	<style media="screen,projection" type="text/css"> 
		#main_image img{height:133px;width:201px;}
		.nav{padding-top:10px;clear:both;}
    </style>

<ul class="gallery_demo_unstyled" style = "display:none;"> 
   	<?php
    /*
    ?>	
	<li><img src="/images/galleria/flowing-rock.jpg" alt="Flowing Rock"></li> 
    <li><img src="/images/galleria/stones.jpg" alt="Stones"></li> 
    <li class="active"><img src="/images/galleria/grass-blades.jpg" alt="Grass Blades"></li> 
    <li><img src="/images/galleria/ladybug.jpg" alt="Ladybug"></li> 
    <li><img src="/images/galleria/lightning.jpg" alt="Lightning"></li> 
    <li><img src="/images/galleria/lotus.jpg" alt="Lotus"></li> 
    <li><img src="/images/galleria/mojave.jpg" alt="Mojave"></li> 
    <li><img src="/images/galleria/pier.jpg" alt="Pier"></li> 
    <li><img src="/images/galleria/sea-mist.jpg" alt="Sea Mist"></li>
    <?php
    */	
    	$i = 0;
    	foreach ($PHOTOS as $photo) {
   	?>
   		<li<?php echo ($i == 0) ? ' class="active"' : '' ?>><img src="<?php echo $photo->thumbPhoto; ?>" alt="<?php echo $photo->title; ?>"></li>
   	<?php
   			$i++;
    	}
    	
    ?>
</ul> 
<p class="nav" align = "center"><a href="#" onclick="$.galleria.prev(); return false;"><img src = "/images/l.png" border = "0"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="$.galleria.next(); return false;"><img src = "/images/r.png" border = "0"></a></p> 
		
		
<?php		
	} else {
?>
		<div id="rest-main-img"><img src="/img/standard/restaurant-na-icon.jpg" width="201" height="133" alt="apple-img" /></div>
<?php
	}
?>