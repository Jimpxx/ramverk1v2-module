<?php
/**
 * Load the IP Verifyer as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "API for getting the weather",
            "mount" => "apiweather",
            "handler" => "\Jiad\Weather\APIWeatherController",
        ],
    ]
];
