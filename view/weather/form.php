<?php

namespace Anax\View;

?>


<h1>Get info about the weather based on your IP</h1>

<form method="post">
    <fieldset>
    <legend>Weather</legend>
<!-- 
    <p>
    <label for="searchType">Do you want to search by IP or Coordinates?</label>
    </p>
    <p>
    <select name="searchType" id="searchType">
    <option value="ip" default>IP</option>
    <option value="coordinates">Coordinates</option>
    </select>
    </p> -->

    <p>
        <label>IP<br>
        <input type="text" name="search" value="<?= $client_ip ?>"/>
        </label>
    </p>
<!-- 
    <p>
        <label>Coordinates<br>
        <input type="text" name="long" placeholder="Longitude"/>
        <input type="text" name="lat" placeholder="Latitude"/>
        </label>
    </p> -->

    <!-- <p>
        <label>IP:<br> 
        <input type="text" name="ip" value="<?= $client_ip ?>"/>
        </label>
    </p>

    <p>
        <label>City:<br> 
        <input type="text" name="city"/>
        </label>
    </p> -->

    <p>
    <label for="time">What timespan do you want to see?</label>
    </p>
    <p>
    <select name="time" id="time">
    <option value="future" default>Future</option>
    <option value="past">Past 30 days</option>
    </select>
    </p>

    <p>
        <input type="submit" value="Get weather" name="doWeather">
    </p>
    </fieldset>
</form>


<?php
// var_dump($info)
?>
