<div id="ate_this_popup">
<?php if ($PROCESSED): ?>
    <p>You have already tagged this product.</p>
<?php else: ?>
    <?php if($ADDRESSES): ?>
        <ul>
        <?php foreach ($ADDRESSES as $ADDRESS): ?>
            <li><?php echo $PRODUCT->producer_name ?></li>
            <li><?php echo $ADDRESS->address?></li>

            <li>
                <?php echo form_open("/product/tag_ate/$PRODUCT->custom_url",
                        array('id'=>'id_form_ate')) ?>
                <ul>
                    <li class="rating">
                        <?php
                        for ($i=1;$i<6;$i++):
                            $attrs = array(
                                'name'=>'rating',
                                'id'=>'rating_'.$i,
                                'class'=>'star2'
                            );
                            if ($i == 1) $attrs['checked'] = 'checked';
                            echo form_radio($attrs,$i),
                                form_label($i, 'rating_'.$i, array('class'=>'starlabel'));
                        endfor;
                        ?>
                        <br />
                    </li>

                    <li>
                        <?php echo form_label('Comment', 'id_comment'), '<br />',
                        form_textarea(array(
                                'name'=>'comment',
                                'id' => 'id_comment',
                                'cols'=>30,
                                'rows'=>5
                                ), ''); ?>
                    </li>

                    <li>
                        <br />
                        <input type="hidden" name="address_id" value="<?php echo $ADDRESS->address_id?>" />
                        <input type="hidden" name="product_id" value="<?php echo $PRODUCT->id?>" />
                        <input type="submit" value="Select this Location" />
                    </li>
                </ul>
            </li>
        <?php endforeach ?>    
        </ul>
        <?php else: ?>
        <p>There are no addresses for this producer in our records. You can 
            check back later to tag this product.</p>
        <?php endif ?>

    <link rel="stylesheet" href="<?php echo base_url()?>js/rating/jquery.rating.css" />
    <script src="<?php echo base_url()?>js/rating/jquery.rating.pack.js"></script>
    <script src="<?php echo base_url()?>js/ajaxform/ajaxform.js"></script>
    <script src="<?php echo base_url()?>js/throbber/jquery.throbber.min.js"></script>
    <script type="text/javascript">
    $(function(){
       tagAteForm();
    });
    </script>
<?php endif; ?>
</div>