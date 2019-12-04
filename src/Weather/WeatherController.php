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
class WeatherController implements ContainerInjectableInterface
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
        $title = "Weather";
        $page = $this->di->get("page");

        $client_ip = $this->di->get("request")->getServer("REMOTE_ADDR", "127.0.0.1");

        $data = [
            "client_ip" => $client_ip,
        ];

        $page->add("weather/form", $data);

        return $page->render([
            "title" => $title
        ]);
    }


    /**
     * This is the Validate method action, it handles:
     * POST METHOD mountpoint/
     *
     * @return object
     */
    public function indexActionPost() : object
    {
        $page = $this->di->get("page");
        $title = "Weather Result";

        // Post
        // $long = $this->di->request->getPost("long");
        // $lat = $this->di->request->getPost("lat");
        $searchType = $this->di->request->getPost("searchType");
        $search = $this->di->request->getPost("search");
        $time = $this->di->request->getPost("time");
        // $doWeather = $this->di->request->getPost("doWeather");

        $test = "";

        // $searchOptions = [
        //     // "lat" => $ipInfo->latitude,
        //     // "long" => $ipInfo->longitude
        // ];

        // if ($searchType == "ip") {
        //     $test = "IP";

        $geotag = $this->di->get("geotag");
            // $geotag = new GeoTag();
            
        $ipInfo = $geotag->getGeoInfo($search);

            // $searchOptions["lat"] = $ipInfo->latitude;
            // $searchOptions["long"] = $ipInfo->longitude;

            // // $info = $module->getGeoInfo($ip);
            // $info = $module->getGeoInfo($ip);
        // }
        // else if ($searchType == "coordinates") {
        //     $test = "CITY";
        //     $ipInfo = "CITY";

        //     $searchOptions["lat"] = $lat;
        //     $searchOptions["long"] = $long;
        // }

        $searchOptions = [
            "lat" => $ipInfo->latitude,
            "long" => $ipInfo->longitude
        ];

        // $curl = new Curl();
        $curl = $this->di->get("curl");

        $error = 0;
        $type = "";

        if ($time == "future") {
            $weatherInfo = $curl->sCurl($searchOptions); // Single Curl
            // $type = "single";
        } else if ($time == "past") {
            $weatherInfo = $curl->mCurl($searchOptions); // Multi Curl
            // $type = "multi";
        }


        $data = [
            "searchType" => $searchType,
            "search" => $search,
            "time" => $time,
            "ipInfo" => $ipInfo,
            "test" => $test,
            "type" => $type,
            "error" => $error,
            "weatherInfo" => $weatherInfo
        ];

        $page->add("weather/weatherResult", $data);

        return $page->render([
            "title" => $title
        ]);
    }
}
