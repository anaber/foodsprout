<p>Select a city below to view sustainable food for that area.</p>

<?php if ( ! is_null($default_city)): ?>
    <p>Your default city is <?php echo $default_city ?></p>
<?php endif ?>
<h2>USA</h2>

<div class="city">
<a href="/sustainable/albuquerque">Albuquerque</a><br>
<a href="/sustainable/anchorage">Anchorage</a><br>
<a href="/sustainable/atlanta">Atlanta</a><br>
<a href="/sustainable/austin">Austin</a><br>
<a href="/sustainable/baltimore">Baltimore</a><br>
<a href="/sustainable/baton-rouge">Baton Rouge</a><br>
<a href="/sustainable/birmingham">Birmingham</a><br>
<a href="/sustainable/boston">Boston</a><br>

<a href="/sustainable/buffalo">Buffalo</a><br>
<a href="/sustainable/charleston">Charleston</a><br>
<a href="/sustainable/charlotte">Charlotte</a><br>
<a href="/sustainable/chicago">Chicago</a><br>
<a href="/sustainable/cincinnati">Cincinnati</a><br>
<a href="/sustainable/cleveland">Cleveland</a><br>
</div>

<div class="city">
<a href="/sustainable/columbus">Columbus</a><br>

<a href="/sustainable/dallas">Dallas</a><br>
<a href="/sustainable/denver">Denver</a><br>
<a href="/sustainable/des-moines">Des Moines</a><br>
<a href="/sustainable/detroit">Detroit</a><br>
<a href="/sustainable/fresno">Fresno</a><br>
<a href="/sustainable/green-bay">Green Bay</a><br>
<a href="/sustainable/hartford">Hartford</a><br>
<a href="/sustainable/houston">Houston</a><br>
<a href="/sustainable/indianapolis">Indianapolis</a><br>

<a href="/sustainable/jacksonville">Jacksonville</a><br>
<a href="/sustainable/kansas-city">Kansas City</a><br>
<a href="/sustainable/knoxville">Knoxville</a><br>
<a href="/sustainable/las-vegas">Las Vegas</a><br>

</div>

<div class="city">

<a href="/sustainable/lexington">Lexington</a><br>
<a href="/sustainable/los-angeles">Los Angeles</a><br>

<a href="/sustainable/louisville">Louisville</a><br>
<a href="/sustainable/memphis">Memphis</a><br>
<a href="/sustainable/miami">Miami</a><br>
<a href="/sustainable/milwaukee">Milwaukee</a><br>
<a href="/sustainable/minneapolis">Minneapolis</a><br>
<a href="/sustainable/nashville">Nashville</a><br>
<a href="/sustainable/new-orleans">New Orleans</a><br>
<a href="/sustainable/new-york">New York</a><br>
<a href="/sustainable/norfolk">Norfolk</a><br>

<a href="/sustainable/north-jersey">North Jersey</a><br>
<a href="/sustainable/oakland">Oakland</a><br>
<a href="/sustainable/oklahoma-city">Oklahoma City</a><br>
</div>

<div class="city">
<a href="/sustainable/omaha">Omaha</a><br>
<a href="/sustainable/orlando">Orlando</a><br>
<a href="/sustainable/philadelphia">Philadelphia</a><br>
<a href="/sustainable/phoenix">Phoenix</a><br>

<a href="/sustainable/pittsburgh">Pittsburgh</a><br>
<a href="/sustainable/portland">Portland</a><br>
<a href="/sustainable/providence">Providence</a><br>
<a href="/sustainable/raleigh">Raleigh</a><br>
<a href="/sustainable/richmond">Richmond</a><br>
<a href="/sustainable/rochester">Rochester</a><br>
<a href="/sustainable/sacramento">Sacramento</a><br>
<a href="/sustainable/salt-lake-city">Salt Lake City</a><br>
<a href="/sustainable/san-antonio">San Antonio</a><br>

<a href="/sustainable/san-diego">San Diego</a><br>
</div>

<div class="city">
<a href="/sustainable/san-francisco">San Francisco</a><br>
<a href="/sustainable/san-jose">San Jose</a><br>
<a href="/sustainable/santa-barbara">Santa Barbara</a><br>
<a href="/sustainable/seattle">Seattle</a><br>
<a href="/sustainable/st-louis">St. Louis</a><br>
<a href="/sustainable/stamford">Stamford</a><br>

<a href="/sustainable/tampa-bay">Tampa Bay</a><br>
<a href="/sustainable/tucson">Tucson</a><br>
<a href="/sustainable/tulsa">Tulsa</a><br>
<a href="/sustainable/twin-cities">Twin Cities</a><br>
<a href="/sustainable/washington-dc">Washington DC</a><br>
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