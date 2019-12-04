<?php

namespace Jiad\Modules;

/**
 * A mock class.
 */
class GeoTagMock extends GeoTag
{
    public function getGeoInfo(string $ip) : object
    {
        $data = [
            "ip" => "8.8.8.8",
            "latitude" => 58.390281677246,
            "longitude" => 13.846119880676
        ];
        return json_decode(json_encode($data), false);
        // return [[$data]];
    }
}
