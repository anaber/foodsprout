<script>
	var hasFructose = <?php echo ( isset($FRUCTOSE) && $FRUCTOSE) ? '1' : '0'; ?>;
</script>
<script src="<?php echo base_url()?>js/jquery.colorize.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/admin/product_search_admin.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>js/admin/admin_ajax_page_common_content.js" type="text/javascript"></script>

<?php $this->load->view('admincp/includes/ajax_paging'); ?>