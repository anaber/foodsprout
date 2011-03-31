<h2>Cities in <?php echo $state ?></h2>

<?php if ( ! is_null($cities)): foreach($cities as $group):?>

<div class="city city-smaller">
    <?php
    foreach($group as $city):
        $fragment = urlencode(strtolower(str_replace(' ', '-', $city->city)));
        echo anchor("$listing_url/$fragment", $city->city). '<br/>';
    endforeach;
    ?>
</div>

<?php endforeach; else: ?>
<p>There are no cities listed in this state</p>
<?php endif ?>