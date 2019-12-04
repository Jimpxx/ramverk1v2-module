<?php

namespace Jiad\Modules;

use Anax\Session\SessionInterface;

/**
 * REM Server using session to store information.
 */
class GeoTag
{
    /**
     * Get geo information about an IP address.
     *
     * @param string $ip string with IP to fetch geoinformation about.
     *
     * @return self
     */
    // public function getGeoInfo(string $ip) : object
    public function getGeoInfo(string $ip) : object
    {
        // $ip = "158.174.140.127";
        $key = require(ANAX_INSTALL_PATH . "/config/api_key.php");
        $api_key = $key["ipstack"];
        // $api_key = "ceb8dbb476fc421d779317551864704e";
        $url = "http://api.ipstack.com/$ip?access_key=$api_key";
        // $url = "http://api.ipstack.com/158.174.140.127?access_key=ceb8dbb476fc421d779317551864704e";
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        // $info = "hej";

        $info = curl_exec($ch);
        curl_close($ch);
        return json_decode($info);
    }
}
