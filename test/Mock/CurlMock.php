<?php

namespace Jiad\Modules;

/**
 * A mock class.
 */
class CurlMock extends Curl
{
    public function sCurl(array $search) : object
    {
        $data = [
            "latitude" => 58.390281677246,
            "longitude" => 13.846119880676,
            "daily" => [
                "summary" => "All good all day",
                "data" => [
                    "0" => [
                        "time" => 1509944400,
                        "summary" => "Rain starting in the afternoon, continuing until evening.",
                        "sunriseTime" => 1509967519,
                        "sunsetTime"=> 1510003982,
                        "temperatureHigh" => 66.35,
                        "temperatureLow" => 41.28
                    ],
                    "1" => [
                        "time" => 1509944400,
                        "summary" => "Rain starting in the afternoon, continuing until evening.",
                        "sunriseTime" => 1509967519,
                        "sunsetTime"=> 1510003982,
                        "temperatureHigh" => 66.35,
                        "temperatureLow" => 41.28
                    ],
                    "2" => [
                        "time" => 1509944400,
                        "summary" => "Rain starting in the afternoon, continuing until evening.",
                        "sunriseTime" => 1509967519,
                        "sunsetTime"=> 1510003982,
                        "temperatureHigh" => 66.35,
                        "temperatureLow" => 41.28
                    ]
                ],
            ],
        ];
        return json_decode(json_encode($data), false);
        // return [[$data]];
    }

    public function mCurl(array $search) : array
    {
        // $obj1 = (object) [];
        // $obj1->latitude = 58.390281677246;
        // $obj1->longitude = 13.846119880676;
        // $obj1->daily->data = [
        //     "time" =>
        // ];

        $obj1 = (object) [
            "latitude" => 58.390281677246,
            "longitude" => 13.846119880676,
            "timezone" => "Europe/Stockholm",
            "daily" => (object) [
                "data" => [
                    0 => (object) [
                        "time" => 1509944400,
                        "summary" => "Rain starting in the afternoon, continuing until evening.",
                        "sunriseTime" => 1509967519,
                        "sunsetTime"=> 1510003982,
                        "temperatureHigh" => 66.35,
                        "temperatureLow" => 41.28
                    ]
                    
                ],
            ],
        ];

        
        $data = [
            "0" => $obj1
            // "0" => [
            //     "latitude" => 58.390281677246,
            //     "longitude" => 13.846119880676,
            //     "timezone" => "Europe/Stockholm",
            //     "daily" => [
            //         "data" => [
            //             "time" => 1509944400,
            //             "summary" => "Rain starting in the afternoon, continuing until evening.",
            //             "sunriseTime" => 1509967519,
            //             "sunsetTime"=> 1510003982,
            //             "temperatureHigh" => 66.35,
            //             "temperatureLow" => 41.28
            //         ],
            //     ],
            // ],
            // "1" => [
            //     "latitude" => 58.390281677246,
            //     "longitude" => 13.846119880676,
            //     "daily" => [
            //         "data" => [
            //             "time" => 1509944400,
            //             "summary" => "Rain starting in the afternoon, continuing until evening.",
            //             "sunriseTime" => 1509967519,
            //             "sunsetTime"=> 1510003982,
            //             "temperatureHigh" => 66.35,
            //             "temperatureLow" => 41.28
            //         ],
            //     ],
            // ],
            // "2" => [
            //     "latitude" => 58.390281677246,
            //     "longitude" => 13.846119880676,
            //     "daily" => [
            //         "data" => [
            //             "time" => 1509944400,
            //             "summary" => "Rain starting in the afternoon, continuing until evening.",
            //             "sunriseTime" => 1509967519,
            //             "sunsetTime"=> 1510003982,
            //             "temperatureHigh" => 66.35,
            //             "temperatureLow" => 41.28
            //         ],
            //     ],
            // ]
        ];

        // return json_decode(json_encode($data), false);
        return $data;
    }
}
