<?php if ( ! empty($errors)): ?>
<ul>
    <?php foreach ($errors as $e): ?>
    <li><?php echo $e ?></li>
    <?php endforeach ?>
</ul>
<?php endif ?>

<?php
echo form_open_multipart('admincp/import/producer', array('class'=>'critical_form')),
    '<table><tr><td>',
    form_label('Upload An Excel File', 'id_file'),
    '</td><td></tr><tr><td>',
    form_upload('file', '', array('id'=>'id_file')),
    '</td></tr><tr><td colspan="2">',
    form_hidden('upload', 1),
    form_submit('', 'Import This File'),
    '</td></tr>',
    form_close();