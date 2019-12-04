<?php

namespace Jiad\Modules;

use Anax\Session\SessionInterface;

/**
 *
 */
class Curl
{
    /**
     * Make a single curl request to DarkSky's API.
     *
     * @param string $search object with IP or City to be searched for weather information.
     *
     * @return self
     */
    // Maybe a string with only url to make it more standardized?
    public function sCurl(array $search) : object
    {
        // Break out?
        $key = require(ANAX_INSTALL_PATH . "/config/api_key.php");
        $api_key = $key["darksky"];
        $lat = $search["lat"];
        $long = $search["long"];
        // ******************************


        // $api_key = "672b4527998ddd2803d7acf40f43d52a";
        $url = "https://api.darksky.net/forecast/$api_key/$lat,$long";
        // $url = "https://api.darksky.net/forecast/672b4527998ddd2803d7acf40f43d52a/58.385750,13.571860";
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        // $info = "hej";

        $info = curl_exec($ch);
        curl_close($ch);
        return json_decode($info);
    }

    /**
     * Make multiple curl requests to Darksky's API and requesting weather for 30 days back.
     *
     * @param string $search object with IP or City to be searched for weather information.
     *
     * @return self
     */
    // Maybe a string with only url to make it more standardized?
    public function mCurl(array $search) : array
    {
        // Break out?
        $key = require(ANAX_INSTALL_PATH . "/config/api_key.php");
        $api_key = $key["darksky"];
        $lat = $search["lat"];
        $long = $search["long"];
        // ******************************


        // $api_key = "672b4527998ddd2803d7acf40f43d52a";
        $url = "https://api.darksky.net/forecast/$api_key/$lat,$long";
        // $url = "https://api.darksky.net/forecast/672b4527998ddd2803d7acf40f43d52a/58.385750,13.571860";
        
        $options = [
            CURLOPT_RETURNTRANSFER => true,
        ];

        $mh = curl_multi_init();
        $chAll = [];

        $time = time();

        // strtotime('-1 day', $todayTime);
        
        $i = 1;
        while ($i <= 30) {
            $ch = curl_init("$url,$time");
            curl_setopt_array($ch, $options);
            curl_multi_add_handle($mh, $ch);
            $chAll[] = $ch;
            $time = strtotime('-1 day', $time);
            $i++;
        }
        
        // Execute all queries simultaneously,
        // and continue when all are complete
        $running = null;
        do {
            curl_multi_exec($mh, $running);
        } while ($running);

        // Close the handles
        foreach ($chAll as $ch) {
            curl_multi_remove_handle($mh, $ch);
        }
        curl_multi_close($mh);

        // All of our requests are done, we can now access the results
        $response = [];
        foreach ($chAll as $ch) {
            $data = curl_multi_getcontent($ch);
            $response[] = json_decode($data, true);
        }

        return json_decode(json_encode($response), false);
        // return $response;
        
        
        
        
        // $ch = curl_init();

        // curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_HEADER, 0);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        // // $info = "hej";

        // $info = curl_exec($ch);
        // curl_close($ch);
        // return json_decode($info);
    }

    // public function getUsersThroughMultiCurl(array $userIds) : array
    // {
    //     $url = "https://rem.dbwebb.se/api/users";

    //     $options = [
    //         CURLOPT_RETURNTRANSFER => true,
    //     ];

    //     // Add all curl handlers and remember them
    //     // Initiate the multi curl handler
    //     $mh = curl_multi_init();
    //     $chAll = [];
    //     foreach ($userIds as $id) {
    //         $ch = curl_init("$url/$id");
    //         curl_setopt_array($ch, $options);
    //         curl_multi_add_handle($mh, $ch);
    //         $chAll[] = $ch;
    //     }

    //     // Execute all queries simultaneously,
    //     // and continue when all are complete
    //     $running = null;
    //     do {
    //         curl_multi_exec($mh, $running);
    //     } while ($running);

    //     // Close the handles
    //     foreach ($chAll as $ch) {
    //         curl_multi_remove_handle($mh, $ch);
    //     }
    //     curl_multi_close($mh);

    //     // All of our requests are done, we can now access the results
    //     $response = [];
    //     foreach ($chAll as $ch) {
    //         $data = curl_multi_getcontent($ch);
    //         $response[] = json_decode($data, true);
    //     }

    //     return $response;
    // }
}
