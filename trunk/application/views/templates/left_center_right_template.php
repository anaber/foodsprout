<?php
	if (isset($SEO) ) {
		$this->load->view('includes/header', array('SEO' => $SEO));
	} else {
		$this->load->view('includes/header');
	}

	if (isset ($CSS) ) {
		foreach ($CSS as $key => $css_file) {
			echo '<link href="' . base_url() . 'css/'.$css_file.'.css" rel="stylesheet" type="text/css" />';
		}
	}
?>
<?php
	if (isset($BREADCRUMB) ) {

		$this->load->view('includes/breadcrumb', array('BREADCRUMB' => $BREADCRUMB ) );
	}
	else{
	}
?>




	<div id="restaurantname">
		<div id="logorestaurant"><h1><?php echo $RESTAURANT_CHAIN->restaurantName; ?></h1></div>
	</div>

	<!-- left column-->
	<div id="rest-main-details">

	<?php
		foreach($LEFT as $key => $view) {
			if (isset($data['left'][$key]['VIEW_HEADER']) ) {
				$this->load->view('includes/block_header', array('VIEW_HEADER' => $data['left'][$key]['VIEW_HEADER'] ) );
			}

			if (isset($data['left'][$key]) ) {
				$this->load->view($view, $data['left'][$key]);
			} else {
				$this->load->view($view);
			}

		}
	/*
	?>


    <div id="location-icon"><img src="/img/location-head-icon.jpg" width="89" height="23" alt="location-head-icon" /></div>
    <div id="map"><iframe width="210" height="100" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=Restaurants+near+Applebee,+Wright+City,+MO,+United+States&amp;sll=42.550596,-99.730534&amp;sspn=46.743437,96.328125&amp;ie=UTF8&amp;hq=Restaurants&amp;hnear=Applebee,+Wright+City,+Warren,+Missouri+63390&amp;ll=38.820785,-91.126785&amp;spn=0.006687,0.017939&amp;z=14&amp;output=embed"></iframe>
		<br>
		<div style="color:#333;">
			http://www.applebees.com<br>
			128 King Street<br>
			San Francisco, CA<br>
			650-210-3100<br>
		</div>
    </div>
    <?php
    */
    ?>


	</div>
	<!-- end left column -->

  	<?php
		foreach($CENTER as $key => $view) {
			if (isset($data['center'][$key]['VIEW_HEADER']) ) {
				$this->load->view('includes/block_header', array('VIEW_HEADER' => $data['center'][$key]['VIEW_HEADER'] ) );
			}

			if (isset($data['center'][$key]) ) {
				$this->load->view($view, $data['center'][$key]);
			} else {
				$this->load->view($view);
			}
		}
  	?>




	<!-- right ads -->
	<div id="add-designs">

    <?php
		foreach($RIGHT as $key => $view) {
			if (isset($data['center'][$key]['VIEW_HEADER']) ) {
				$this->load->view('includes/block_header', array('VIEW_HEADER' => $data['center'][$key]['VIEW_HEADER'] ) );
			}

			if (isset($data['center'][$key]) ) {
				$this->load->view($view, $data['center'][$key]);
			} else {
				$this->load->view($view);
			}
		}
		/*
	?>
    	<div id="add1"><img src="/img/add-design.jpg" width="171" height="171" /></div>
		<div id="add2"><img src="/img/add-design.jpg" width="171" height="171" /></div>
	<?php
		/*
	?>

	</div>
	<!-- end right ads -->












<?php
/*
?>

<div id="main-content">
<table width = "970" border = "0" cellpadding = "0" cellspacing = "0">
	<tr>
		<td width = "170" valign = "top">
		<?php
			foreach($LEFT as $key => $view) {
				if (isset($data['left'][$key]['VIEW_HEADER']) ) {
					$this->load->view('includes/block_header', array('VIEW_HEADER' => $data['left'][$key]['VIEW_HEADER'] ) );
				}

				if (isset($data['left'][$key]) ) {
					$this->load->view($view, $data['left'][$key]);
				} else {
					$this->load->view($view);
				}

			}
		?>
		</td>

		<td width ="790" valign="top" style="padding-left:10px;">
		<?php
			foreach($CENTER as $key => $view) {
				if (isset($data['center'][$key]['VIEW_HEADER']) ) {
					$this->load->view('includes/block_header', array('VIEW_HEADER' => $data['center'][$key]['VIEW_HEADER'] ) );
				}

				if (isset($data['center'][$key]) ) {
					$this->load->view($view, $data['center'][$key]);
				} else {
					$this->load->view($view);
				}

			}
		?>
		</td>
	</tr>
</table>
</div>
<?php
*/
?>
<?php $this->load->view('includes/footer'); ?>