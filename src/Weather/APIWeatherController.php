<?php

namespace Jiad\Weather;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Jiad\Modules\GeoTag;
use Jiad\Modules\Curl;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $di if implementing the interface
 * ContainerInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class APIWeatherController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;




    /**
     * @var string $db a sample member variable that gets initialised
     */
    private $db = "not active";



    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    public function initialize() : void
    {
        // Use to initialise member variables.
        $this->db = "active";
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function indexAction() : object
    {
        $title = "API Weather";
        $page = $this->di->get("page");

        // $client_ip = $this->di->get("request")->getServer("REMOTE_ADDR", "127.0.0.1");

        $data = [
            // "client_ip" => $client_ip,
        ];

        $page->add("weather/apidoc", $data);

        return $page->render([
            "title" => $title
        ]);
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function sAction($ip) : array
    {
        $geotag = $this->di->get("geotag");
        $ipInfo = $geotag->getGeoInfo($ip);

        $searchOptions = [
            "lat" => $ipInfo->latitude,
            "long" => $ipInfo->longitude
        ];

        // $curl = new Curl();
        $curl = $this->di->get("curl");
        
        $weatherInfo = $curl->sCurl($searchOptions); // Single Curl


        return [[$weatherInfo]];

        // $result = [
        //     "summary" => $weatherInfo->daily->summary
        // ];

        // foreach($weatherInfo->daily->data as $key=>$value){
        //     $result[gmdate("Y-m-d\ H:i:s", $value->time)] = [
        //         "summary" => $value->summary,
        //         "sunrise" => gmdate("H:i:s", $value->sunriseTime),
        //         "sunset" => gmdate("H:i:s", $value->sunsetTime),
        //         "temperature_high_celcius" => round(($value->temperatureHigh - 32) * 5/9, 2),
        //         "temperature_low_celcius" => round(($value->temperatureLow - 32) * 5/9, 2)
        //     ];
        // }

        // return [[$result]];
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function mAction($ip) : array
    {
        $geotag = $this->di->get("geotag");
        $ipInfo = $geotag->getGeoInfo($ip);

        $searchOptions = [
            "lat" => $ipInfo->latitude,
            "long" => $ipInfo->longitude
        ];

        // $curl = new Curl();
        $curl = $this->di->get("curl");

        $weatherInfo = $curl->mCurl($searchOptions); // Single Curl

        return [[$weatherInfo]];
        // $result = [];

        // foreach($weatherInfo as $key=>$value){
        //     $result[gmdate("Y-m-d\ H:i:s", $value["daily"]["data"][0]["time"])] = [
        //         "summary" => $value["daily"]["data"][0]["summary"],
        //         "sunrise" => gmdate("H:i:s", $value["daily"]["data"][0]["sunriseTime"]),
        //         "sunset" => gmdate("H:i:s", $value["daily"]["data"][0]["sunsetTime"]),
        //         "temperature_high_celcius" => round(($value["daily"]["data"][0]["temperatureHigh"] - 32) * 5/9, 2),
        //         "temperature_low_celcius" => round(($value["daily"]["data"][0]["temperatureLow"] - 32) * 5/9, 2)
        //     ];
        // }

        // return [[$result]];
    }
}
