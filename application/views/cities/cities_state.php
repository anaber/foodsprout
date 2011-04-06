<h2>Cities in <?php echo $state ?></h2>

<?php if ( ! is_null($cities)): foreach($cities as $group):?>

<div class="city city-smaller">
    <?php
    foreach($group as $city):
        echo anchor("$listing_url/$city->custom_url", $city->city). '<br/>';
    endforeach;
    ?>
</div>

<?php endforeach; else: ?>
<p>There are no cities listed in this state</p>
<?php endif ?>