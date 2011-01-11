<?php 
global $APPLICATION_FOLDER;
require_once($APPLICATION_FOLDER.'/views/errors/header.php');

?>
		<h1><?php echo $heading; ?></h1>
		<?php echo $message; ?>
<?php 
	require_once($APPLICATION_FOLDER.'/views/errors/footer.php');
?>