<div id="recentlyEeaten" class="product_main_list">
    <h1>Recently Eaten Items</h1>

    <?if ( ! is_null($consumed)): ?>
        <ul class="product_list">
            <?php foreach($consumed as $product): ?>
            <li class="product_list_item clearfix">
                <?php echo img('http://dummyimage.com/80x80/000/fff') ?>

                <div class="product_description">
                    <ul>
                        <li><?php echo anchor("product/{$product->custom_url}", htmlentities(ucwords($product->name))) ?></li>
                        <?php if ($product->consumer) : ?>
                            <li>Recently eaten by <?php echo anchor('#', $product->consumer) ?></li>
                        <?php else : ?>
                            <li>Nobody from our list has eaten this yet.</li>
                        <?php endif ?>
                    </ul>
                </div>
            </li>
            <?php endforeach ?>
        </ul>
    <?php else: ?>
        <p>There are no recently eaten products.</p>
    <?php endif ?>
</div>

<div id="worstFood" class="product_main_list">
    <h1>Worst Food Items</h1>
    <? if ( ! is_null($worst)): ?>
        <ul class="product_list">
            <?php foreach($worst as $product): ?>
                <li class="product_list_item clearfix">
                    <?php echo img('http://dummyimage.com/80x80/000/fff') ?>

                    <div class="product_description">
                        <ul>
                            <li><?php echo anchor("product/{$product->custom_url}", htmlentities(ucwords($product->name))) ?></li>
                            <?php if ($product->consumer) : ?>
                                <li>Recently eaten by <?php echo anchor('#', $product->consumer) ?></li>
                            <?php else : ?>
                                <li>Nobody from our list has eaten this yet.</li>
                            <?php endif ?>
                        </ul>
                    </div>
                </li>
            <?php endforeach ?>
        </ul>
    <?php else: ?>
        <p>There are no worst products listed.</p>
    <?php endif ?>
</div>

<div id="recentlyAdded" class="product_main_list">
    <h1>Recently Added Items</h1>

    <?php if( ! is_null($recent)): ?>
    <ul class="product_list">
        <?php foreach($recent as $product): ?>
        <li class="product_list_item clearfix">
            <?php echo img('http://dummyimage.com/80x80/000/fff') ?>

            <div class="product_description">
                <ul>
                    <li><?php echo anchor("product/{$product->custom_url}", htmlentities(ucwords($product->name))) ?></li>
                    <?php if ($product->consumer) : ?>
                        <li>Recently eaten by <?php echo anchor('#', $product->consumer) ?></li>
                    <?php else : ?>
                        <li>Nobody from our list has eaten this yet.</li>
                    <?php endif ?>
                </ul>
            </div>
        </li>
        <?php endforeach ?>
    </ul>
    <?php else: ?>
    <p>There are no recently added products.</p>
    <?php endif ?>
</div>