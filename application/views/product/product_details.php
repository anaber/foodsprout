<div id="product_details" class="clearfix">
    <?php 
    if ($product->main):
        echo img('/uploads'.$product->image_path.'main/'.$product->main);
    else:
        echo img('/img/standard/distributor-na-icon-120-120.jpg');
    endif;
    ?>

    <div class="product_details_list">
        <ul class="details_list">
            <li><?php echo $product->producer_name, ', ' , ucwords($product->product_name) ?></li>
            <li>by <?php echo anchor('manufacture/'.$product->producer_url,$product->producer_name) ?></li>
        </ul>

        <?php if ($this->session->userdata('userId') && ! $has_consumed): ?>
        <span class="badge_ate">
            <a href="/product/tag_ate/<?php echo $product->custom_url ?>" class="tagAte" 
               id="tagAte_<?php echo $product->id ?>">I Ate This</a>
        </span>
        <?php endif ?>
        
    </div>

    <div id="product_details_warning">
        <img src="/images/icons/accident.png" alt="warning"/>
        <p>You should be aware the risk factor is HIGH (15/25). Find out why.</p>
    </div>
</div>

<div id="product_ingredients">
    <div id="ingredient_header" class="clearfix">
        <h1 class="product_source_header">Source The Ingredients</h1>
        <?php
        if ($products_consumed):
            foreach($products_consumed as $consumed): ?>
            <span class="product_ate_where">
                You ate at the: 
                <?php echo $consumed->producer_name ?>on 
                <?php echo $consumed->address ?>
            </span>
            <?php endforeach;
        endif;
        ?>
    </div>

    <div id="ingredient_summary">
        <h1>What's in the <?php echo ucwords($product->product_name) ?></h1>
        <ul>
            <li>The Bun</li>
            <li>Cheese</li>
            <li>Meat Patty</li>
            <li>Ketchup</li>
            <li>Mayo</li>
            <li>Lettuce</li>
        </ul>
    </div>

    <div id="ingredient_chart">
        
    </div>

    <div id="ingredient_details" class="clearfix">
        <ul class="ingredient_list">
            <?php for($i=0;$i<3;$i++):?>
            <li>
                <p>The Bun</p>
                <p>This is currently coming from <a href="#">Supplier Name</a></p>
            </li>
            <?php endfor ?>
        </ul>

        <ul class="ingredient_list">
            <li>
                <dl>
                    <dt>The Bun</dt>
                    <dd>This is currently coming from <a href="#">Supplier Name</a></dd>
                </dl>
            </li>

            <li>
                <dl>
                    <dt>The Bun</dt>
                    <dd>This is currently coming from <a href="#">Supplier Name</a></dd>
                </dl>
            </li>

            <li>
                <dl>
                    <dt>The Bun</dt>
                    <dd>This is currently coming from <a href="#">Supplier Name</a></dd>
                </dl>
            </li>
        </ul>
    </div>

    <div id="product_risk">
        <h1 id="risk_header">Risk Factors Evaluation</h1>

        <div id="risk_slider" class="clearfix">
            <img src="/images/icons/accident.png" alt="warning" id="risk_image"/>
            <div id="risk_slider_value"></div>
            <div id="risk_slider_meter"></div>
        </div>

        <div id="risk_description" class="clearfix">
            <h2>Hazard Description</h2>
            <p>
                Lorem ipsum dolor sit amet, consectetur
                adipiscing elit. Duis ac nisi arcu, vitae
                interdum orci. Quisque eget aliquam
                magna. Vivamus fermentum ultrices
                mauris, at bibendum massa luctus eget.
                Pellentesque habitant morbi tristique
                senectus et netus et malesuada fames
                ac turpis egestas. Suspendisse sit amet
                augue arcu,
            </p>

            <div class="risk_severity">
                <ul>
                    <li><em>Severity</em>:Very High</li>
                    <li><em>Likelihood</em>:Very High</li>
                </ul>
            </div>
        </div>

        <div id="risk_factors">
            <h2>Risk Factors</h2>
            <ul class="risk_factor_list clearfix">
                <li>
                    <?php echo img('http://dummyimage.com/50x50/000/fff') ?>
                    <dl>
                        <dt>Hazard Description</dt>
                        <dd>This is currently coming from <a href="#">Supplier Name</a></dd>
                    </dl>
                </li>

                <li>
                    <?php echo img('http://dummyimage.com/50x50/000/fff') ?>
                    <dl>
                        <dt>The Bun</dt>
                        <dd>This is currently coming from <a href="#">Supplier Name</a></dd>
                    </dl>
                </li>

                <li>
                    <?php echo img('http://dummyimage.com/50x50/000/fff') ?>
                    <dl>
                        <dt>The Bun</dt>
                        <dd>This is currently coming from <a href="#">Supplier Name</a></dd>
                    </dl>
                </li>

                <li>
                    <?php echo img('http://dummyimage.com/50x50/000/fff') ?>
                    <dl>
                        <dt>The Bun</dt>
                        <dd>This is currently coming from <a href="#">Supplier Name</a></dd>
                    </dl>
                </li>
            </ul>

            <ul class="risk_stats">
                <li>Health food illnesses caused directly from this product: 254,645</li>
                <li>Health food illnesses caused indirectly from this product: 254,645</li>
            </ul>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/jquery.ui.mouse.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui/jquery.ui.slider.js"></script>
<link href="<?php echo base_url()?>/css/jquery-ui/jquery.ui.slider.css" type="text/css" rel="stylesheet"/>
<link href="<?php echo base_url()?>/css/jquery-ui/jquery.ui.theme.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
$(function(){
    tagAte(); 
});
</script>