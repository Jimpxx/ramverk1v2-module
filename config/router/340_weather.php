<?php
/**
 * Load the IP Verifyer as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "Get the weather info",
            "mount" => "weather",
            "handler" => "\Jiad\Weather\WeatherController",
        ],
    ]
];
