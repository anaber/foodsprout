<?php echo anchor('admincp/photo', 'List All Photos'); ?><br /><br />

<?php echo validation_errors() ?>
<?php if ( ! empty($UPLOAD_ERRORS)): ?>
<ul>
    <?php foreach ($UPLOAD_ERRORS as $e): ?>
    <li><?php echo $e ?></li>
    <?php endforeach ?>
</ul>
<?php endif ?>
<?php echo form_open_multipart($this->uri->uri_string(), array('id'=>'photo_form')) ?>
    <table class="formTable">
        <?php if(isset($EDIT) && $EDIT): ?>
        <tr>
            <td width="25%">
                Current Image
            </td>
            <td>
                <?php echo img('/uploads'.$PHOTO->path.'main/'.$PHOTO->photo_name) ?>
            </td>
        </tr>
        <?php endif ?>
        <tr>
            <td width="25%">File</td>
            <td width="75%">
                <input type="file" name="image" />
            </td>
        </tr>
        
        <tr>
            <td colspan="2">Choose A Type</td>
        </tr>
        
        <tr>
            <?php $checked = isset($ASSOCIATED_DATA) && ($ASSOCIATED_DATA->type=='producer'); ?> 
            <td width="25%">Producer</td>
            <td width="75%">
                <?php echo form_radio(array('name'=>'type','class'=>'radio_type'), 
                        'producer', $checked);?>
            </td>
        </tr>
               
        <tr>
            <?php $checked = isset($ASSOCIATED_DATA) && ($ASSOCIATED_DATA->type == 'product'); ?>
            <td width="25%">Product</td>
            <td width="75%">
                <?php echo form_radio(array('name'=>'type','class'=>'radio_type'), 
                        'product', $checked);?>
            </td>
        </tr>
        
        <tr>
            <td width="25%">Item</td>
            <td width="75%">
                <?php $dataValue = isset($ASSOCIATED_DATA) ? $ASSOCIATED_DATA->value:''; ?>
                <input type="text" id="id_photo_item" name="item"
                       value="<?php echo set_value('item', $dataValue) ?>"/>
                <input type="hidden" name="item_id" id="id_item" 
                   value="<?php echo isset($ASSOCIATED_DATA) ? $ASSOCIATED_DATA->id : 1 ?>"/>
            </td>
            
        </tr>
        
        <tr>
            <td width="25%">Title</td>
            <td width="75%">
                <input type="text" name="title" class="validate[required]"
                       value="<?php echo set_value('title', $PHOTO->title) ?>"/>
            </td>
        </tr>
        
        <tr>
            <td width="25%">Description</td>
            <td width="75%">
                <textarea name="description" cols="20" rows="5"><?php echo set_value('description', $PHOTO->description) ?></textarea>
            </td>
        </tr>
        
        <tr>
            <td width="25%">Thumbnail Size</td>
            <td width="75%">
                <?php
                $options = array(
                    '80_80'=>'80x80 - Product Thumbnail'
                );
                echo form_dropdown('thumb_size', $options);
                ?>
            </td>
        </tr>
        
        <tr>
            <td width="25%">Main Size</td>
            <td width="75%">
                <?php
                $options = array(
                    '120_120'=>'120x120 - Product Page Image'
                );
                echo form_dropdown('main_size', $options);
                ?>
            </td>
        </tr>
        
        <tr>
            <td width="25%">Status</td>
            <td width="75%">
                <?php
                $options = array('live'=>'Live','queue'=>'Queue','hide'=>'Hide');
                echo form_dropdown('status',$options);
                ?>
            </td>
        </tr>
        
        <tr>
            <td width="25%">&nbsp;</td>
            <td width="75%">
                <input type="hidden" value="product" id="type" />
                <input type="submit" value="Upload and Edit" name="save_edit" />
            </td>
        </tr>
        
        <tr>
            <td width="25%">&nbsp;</td>
            <td width="75%">
                <input type="submit" value="Upload and View List" name="save_list" />
            </td>
        </tr>
    </table>
<?php echo form_close() ?>

<script type="text/javascript" src="/js/jquery.autocomplete.frontend.js"></script>
<script type="text/javascript">
    function ac(){
        $('#id_photo_item').autocomplete('/admincp/photos/getItemForPhoto',{
            extraParams:{
                type:$('input[name=type]:checked').val()
            },
            cacheLength:0
        }).result(function(event, data){
            if(data){
                $('#id_item').val(data[1]);
            }
        });
    }
    $(function(){
        ac();
        $('.radio_type').change(function(){
           $('#id_photo_item').setOptions({
              extraParams: {
                  type:$('input[name=type]:checked').val()
              }
           });
           $('#id_photo_item').val(''); 
        });
    });
</script>