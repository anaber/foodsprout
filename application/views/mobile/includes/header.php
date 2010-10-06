<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<meta name="apple-mobile-web-app-capable" content="yes" />
			<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
			<!-- blackberry -->
			<meta name="HandheldFriendly" content="true" > 
<title><?php echo (isset($SEO->titleTag)? $SEO->titleTag: 'Food Sprout'); ?></title>
<meta name="description" content="<?php echo (isset($SEO->metaDescription)? $SEO->metaDescription: 'Mapping our Food\'s Impact'); ?>" />
<meta name="keywords" content="<?php echo (isset($SEO->metaKeywords)? $SEO->metaKeywords: 'food source, food location'); ?>" />
<meta name="robots" content="index,follow" />
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
<link href="<?php echo base_url();?>css/mobile.css" rel="stylesheet" type="text/css" />
<?php 
if (isset ($CSS) ) {
	foreach ($CSS as $key => $css_file) {
		echo '<link href="' . base_url() . 'css/'.$css_file.'.css" rel="stylesheet" type="text/css" />';
	}
}
?>
<style>
body{margin:0; background: #2C1A0F;}
</style>
</head>
<body>
<!-- header -->
<div>
	<img src="/img/foodsprout-logo.gif" width="198" height="50">
</div>