<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">

<head>
	<title>Mapping the World's Food Chain</title>
	<meta name="description" content="Mapping the World's Food Chain" />
	<meta name="keywords" content="food source, food location" />
	<meta name="robots" content="index,follow" />
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
	<link type="text/css" rel="stylesheet" media="all" href="/css/main.css" />
</head>
<body>
<div align="center"><br>
<div align="left" style="width:974px;">
	<div id="rbox">
	<a href="/"><img src="/images/logo-left.gif" border="0" align="left" style="padding-right:10px;"></a>Search For (i.e. BigMac, salmon, potato chips)<br>
		<?
		
			echo form_open('search/results');
			$data = array(
			              'name'        => 'search',
			              'id'          => 'search',
			              'value'       => '',
			              'maxlength'   => '100',
			              'size'        => '60'
			            );

			echo form_input($data);
			echo form_submit('submit', 'Search');
			echo '</form>';
		
		?><br>
		<? echo anchor('product', 'Products'); ?> | <? echo anchor('company', 'Companies'); ?> | <? echo anchor('farm', 'Farms'); ?> | <? echo anchor('meat', 'Meats'); ?> | <? echo anchor('vegetable', 'Vegetables'); ?> | <? echo anchor('processing', 'Processing Facilities'); ?>
	</div>
</div>