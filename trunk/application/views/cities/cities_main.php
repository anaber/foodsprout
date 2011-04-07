<p>Select a city below to view <?php echo $listing_url ?> food for that area.</p>

<?php if ( ! is_null($default_city)): ?>
    <p>Your default city is <?php echo $default_city ?></p>
<?php endif ?>
<h2>USA</h2>

<div class="city">
<a href="/<?php echo $listing_url ?>/albuquerque">Albuquerque</a><br>
<a href="/<?php echo $listing_url ?>/anchorage">Anchorage</a><br>
<a href="/<?php echo $listing_url ?>/atlanta">Atlanta</a><br>
<a href="/<?php echo $listing_url ?>/austin">Austin</a><br>
<a href="/<?php echo $listing_url ?>/baltimore">Baltimore</a><br>
<a href="/<?php echo $listing_url ?>/baton-rouge">Baton Rouge</a><br>
<a href="/<?php echo $listing_url ?>/birmingham">Birmingham</a><br>
<a href="/<?php echo $listing_url ?>/boston">Boston</a><br>

<a href="/<?php echo $listing_url ?>/buffalo">Buffalo</a><br>
<a href="/<?php echo $listing_url ?>/charleston">Charleston</a><br>
<a href="/<?php echo $listing_url ?>/charlotte">Charlotte</a><br>
<a href="/<?php echo $listing_url ?>/chicago">Chicago</a><br>
<a href="/<?php echo $listing_url ?>/cincinnati">Cincinnati</a><br>
<a href="/<?php echo $listing_url ?>/cleveland">Cleveland</a><br>
</div>

<div class="city">
<a href="/<?php echo $listing_url ?>/columbus">Columbus</a><br>

<a href="/<?php echo $listing_url ?>/dallas">Dallas</a><br>
<a href="/<?php echo $listing_url ?>/denver">Denver</a><br>
<a href="/<?php echo $listing_url ?>/des-moines">Des Moines</a><br>
<a href="/<?php echo $listing_url ?>/detroit">Detroit</a><br>
<a href="/<?php echo $listing_url ?>/fresno">Fresno</a><br>
<a href="/<?php echo $listing_url ?>/green-bay">Green Bay</a><br>
<a href="/<?php echo $listing_url ?>/hartford">Hartford</a><br>
<a href="/<?php echo $listing_url ?>/houston">Houston</a><br>
<a href="/<?php echo $listing_url ?>/indianapolis">Indianapolis</a><br>

<a href="/<?php echo $listing_url ?>/jacksonville">Jacksonville</a><br>
<a href="/<?php echo $listing_url ?>/kansas-city">Kansas City</a><br>
<a href="/<?php echo $listing_url ?>/knoxville">Knoxville</a><br>
<a href="/<?php echo $listing_url ?>/las-vegas">Las Vegas</a><br>

</div>

<div class="city">

<a href="/<?php echo $listing_url ?>/lexington">Lexington</a><br>
<a href="/<?php echo $listing_url ?>/los-angeles">Los Angeles</a><br>

<a href="/<?php echo $listing_url ?>/louisville">Louisville</a><br>
<a href="/<?php echo $listing_url ?>/memphis">Memphis</a><br>
<a href="/<?php echo $listing_url ?>/miami">Miami</a><br>
<a href="/<?php echo $listing_url ?>/milwaukee">Milwaukee</a><br>
<a href="/<?php echo $listing_url ?>/minneapolis">Minneapolis</a><br>
<a href="/<?php echo $listing_url ?>/nashville">Nashville</a><br>
<a href="/<?php echo $listing_url ?>/new-orleans">New Orleans</a><br>
<a href="/<?php echo $listing_url ?>/new-york">New York</a><br>
<a href="/<?php echo $listing_url ?>/norfolk">Norfolk</a><br>

<a href="/<?php echo $listing_url ?>/north-jersey">North Jersey</a><br>
<a href="/<?php echo $listing_url ?>/oakland">Oakland</a><br>
<a href="/<?php echo $listing_url ?>/oklahoma-city">Oklahoma City</a><br>
</div>

<div class="city">
<a href="/<?php echo $listing_url ?>/omaha">Omaha</a><br>
<a href="/<?php echo $listing_url ?>/orlando">Orlando</a><br>
<a href="/<?php echo $listing_url ?>/philadelphia">Philadelphia</a><br>
<a href="/<?php echo $listing_url ?>/phoenix">Phoenix</a><br>

<a href="/<?php echo $listing_url ?>/pittsburgh">Pittsburgh</a><br>
<a href="/<?php echo $listing_url ?>/portland">Portland</a><br>
<a href="/<?php echo $listing_url ?>/providence">Providence</a><br>
<a href="/<?php echo $listing_url ?>/raleigh">Raleigh</a><br>
<a href="/<?php echo $listing_url ?>/richmond">Richmond</a><br>
<a href="/<?php echo $listing_url ?>/rochester">Rochester</a><br>
<a href="/<?php echo $listing_url ?>/sacramento">Sacramento</a><br>
<a href="/<?php echo $listing_url ?>/salt-lake-city">Salt Lake City</a><br>
<a href="/<?php echo $listing_url ?>/san-antonio">San Antonio</a><br>

<a href="/<?php echo $listing_url ?>/san-diego">San Diego</a><br>
</div>

<div class="city">
<a href="/<?php echo $listing_url ?>/san-francisco">San Francisco</a><br>
<a href="/<?php echo $listing_url ?>/san-jose">San Jose</a><br>
<a href="/<?php echo $listing_url ?>/santa-barbara">Santa Barbara</a><br>
<a href="/<?php echo $listing_url ?>/seattle">Seattle</a><br>
<a href="/<?php echo $listing_url ?>/st-louis">St. Louis</a><br>
<a href="/<?php echo $listing_url ?>/stamford">Stamford</a><br>

<a href="/<?php echo $listing_url ?>/tampa-bay">Tampa Bay</a><br>
<a href="/<?php echo $listing_url ?>/tucson">Tucson</a><br>
<a href="/<?php echo $listing_url ?>/tulsa">Tulsa</a><br>
<a href="/<?php echo $listing_url ?>/twin-cities">Twin Cities</a><br>
<a href="/<?php echo $listing_url ?>/washington-dc">Washington DC</a><br>
</div>



<div style="clear:both;">
</div>
<br><br>
<h3>Or Browse All Cities by State</h3>

<?php foreach($states as $group): ?>
<div class="city">
    <?php
    foreach($group as $state):
        $fragment = urlencode(strtolower(str_replace(' ', '-', $state->state_name)));
        echo anchor("cities/state/$fragment", $state->state_name). '<br/>';
    endforeach;
    ?>
</div>
<?php endforeach ?>