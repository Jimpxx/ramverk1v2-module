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
    public function sCurl(array $search) : object
    {
        $key = require(ANAX_INSTALL_PATH . "/config/api_key.php");
        $api_key = $key["darksky"];
        $lat = $search["lat"];
        $long = $search["long"];

        $url = "https://api.darksky.net/forecast/$api_key/$lat,$long";
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

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
    public function mCurl(array $search) : array
    {
        $key = require(ANAX_INSTALL_PATH . "/config/api_key.php");
        $api_key = $key["darksky"];
        $lat = $search["lat"];
        $long = $search["long"];

        $url = "https://api.darksky.net/forecast/$api_key/$lat,$long";

        $options = [
            CURLOPT_RETURNTRANSFER => true,
        ];

        $mh = curl_multi_init();
        $chAll = [];

        $time = time();
        
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
    }
}
