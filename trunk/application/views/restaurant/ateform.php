<div id="ate_this_popup">
<?php if ($PROCESSED): ?>
    <p>You have already tagged this restaurant.</p>
<?php else: ?>
    <div id="list_tag_addresses">
    <?php if($RESTAURANT->addresses):
        foreach($RESTAURANT->addresses as $ADDRESS):?>
        <ul class="list_tag_restaurants">
            <li><?php echo $RESTAURANT->restaurantName ?></li>
            <li><?php echo $ADDRESS->displayAddress ?></li>

            <li>
                <?php echo form_open("/restaurant/tag/$RESTAURANT->restaurantId/$ADDRESS_ID",
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
                        <input type="hidden" name="address_id" value="<?php echo $ADDRESS->addressId?>" />
                        <input type="hidden" name="restaurant_id" value="<?php echo $RESTAURANT->restaurantId?>" />
                        <input type="hidden" name="restaurant_slug" value="<?php echo $RESTAURANT->customURL?>"/>
                        <input type="submit" class="tag_submit" value="Select this Location" />
                    </li>

                </ul>
                <?php echo form_close();?>
            </li>
        </ul>
        <?php endforeach;
        else: ?>
        <p>There are no addresses for this producer in our records. You can
            check back later to tag this product.</p>
        <?php endif ?>
    </div>

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