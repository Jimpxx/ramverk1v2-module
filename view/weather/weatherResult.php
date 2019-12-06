<?php

namespace Anax\View;

?>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>


<h1>Weather Results</h1>

<div id="map" style="height:500px"></div>


<?php if ($time == "future") { ?>
    <?php if (property_exists($weatherInfo, "daily")) { ?>
<h2>Summary of the weather for the future:</h2>

<p>Here you can see the weather for the near comming future</p>

<h4>Short summary for the week</h4>
<p><?= $weatherInfo->daily->summary ?></p>

        <?php foreach ($weatherInfo->daily->data as $key => $value) : ?>
    <div>
        <h4><?= gmdate("Y-m-d\ H:i:s", $value->time) ?></h4>
        <p>Summary: <?= $value->summary; ?></p>
        <p>Sunrise: <?= gmdate("H:i:s", $value->sunriseTime) ?></p>
        <p>Sunset: <?= gmdate("H:i:s", $value->sunsetTime) ?></p>
        <p>Temperature High: <?= round(($value->temperatureHigh - 32) * 5/9, 2) ?> Celcius</p>
        <p>Temperature Low: <?= round(($value->temperatureLow - 32) * 5/9, 2) ?> Celcius</p>
    </div>
        <?php endforeach; ?>

    <?php } else { ?>
<p>Not able to fetch weather info</p>
<code><?= $weatherInfo->error ?></code>

    <?php } ?>

<?php } ?>



<?php if ($time == "past") { ?>
    <?php if (property_exists($weatherInfo[0], "daily")) { ?>
        <!-- count($weatherInfo["0"]) > 2 -->
        <!-- property_exists($weatherInfo[0], "daily" -->
<h2>The weather for the past 30 days</h2>

        <?php foreach ($weatherInfo as $key => $value) : ?>
    <div>
        <h4><?= gmdate("Y-m-d\ H:i:s", $value->daily->data[0]->time) ?></h4>
        <p>Summary: <?= $value->daily->data[0]->summary ?></p>
        <p>Sunrise: <?= gmdate("H:i:s", $value->daily->data[0]->sunriseTime) ?></p>
        <p>Sunset: <?= gmdate("H:i:s", $value->daily->data[0]->sunsetTime) ?></p>
        <p>Temperature High: <?= round(($value->daily->data[0]->temperatureHigh - 32) * 5/9, 2) ?> Celcius</p>
        <p>Temperature Low: <?= round(($value->daily->data[0]->temperatureLow - 32) * 5/9, 2) ?> Celcius</p>
    </div>
        <?php endforeach; ?>

    <?php } else { ?>
<p>Not able to fetch weather info</p>
<code><?= $weatherInfo[0]->error ?></code>
<!-- $weatherInfo["0"]["error"] -->
    <?php } ?>

<?php } ?>




<script>
var map = L.map('map', {
    center: [<?= $ipInfo->latitude ?>, <?= $ipInfo->longitude ?>],
    // center: [51.505, -0.09],
    zoom: 13
    
});
// Creating a Layer object
var layer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

// Adding layer to the map
// map.addLayer(layer);
</script>


<?php
// var_dump($weatherInfo);
// var_dump($ipInfo);
?>
