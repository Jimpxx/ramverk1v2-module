<?php

namespace Jiad\Weather;

// namespace Anax\Controller;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

// use Jiad\Modules\GeoTagMock;
use Jiad\Modules\CurlMock;

/**
 * Test the SampleController.
 */
class WeatherControllerTest extends TestCase
{
    // Create the di container.
    protected $di;



    /**
     * Prepare before each test.
     */
    protected function setUp()
    {
        global $di;

        // Setup di
        $di = new DIFactoryConfig();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        // Use a different cache dir for unit test
        $di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");

        $this->di = $di;
    }

        /**
     * Test the route "index".
     */
    public function testIndexAction()
    {
        // Setup the controller
        $controller = new WeatherController();
        $controller->setDI($this->di);
        $controller->initialize();

        $this->di->get("request")->setServer("REMOTE_ADDR", "8.8.8.8");

        // Test the controller action
        $res = $controller->indexAction();
        $body = $res->getBody();
        $this->assertStringContainsString("Get info about the weather based on your IP", $body);
    }

        /**
     * Test the route "index" (POST).
     */
    public function testIndexActionPostSingle()
    {
        // Setup the controller

        $this->di->setShared("geotag", "\Jiad\Modules\GeoTagMock");
        $this->di->setShared("curl", "\Jiad\Modules\CurlMock");

        $controller = new WeatherController();
        $controller->setDI($this->di);
        $controller->initialize();

        $this->di->get("request")->setPost("searchType", "ip");
        $this->di->get("request")->setPost("search", "8.8.8.8");
        $this->di->get("request")->setPost("time", "future");


        // Test the controller action
        $res = $controller->indexActionPost();
        $body = $res->getBody();
        $this->assertStringContainsString("Weather Results", $body);
    }

        /**
     * Test the route "index" (POST).
     */
    public function testIndexActionPostMulti()
    {
        // Setup the controller

        $this->di->setShared("geotag", "\Jiad\Modules\GeoTagMock");
        $this->di->setShared("curl", "\Jiad\Modules\CurlMock");

        $controller = new WeatherController();
        $controller->setDI($this->di);
        $controller->initialize();

        $this->di->get("request")->setPost("searchType", "ip");
        $this->di->get("request")->setPost("search", "8.8.8.8");
        $this->di->get("request")->setPost("time", "past");


        // Test the controller action
        $res = $controller->indexActionPost();
        $body = $res->getBody();
        $this->assertStringContainsString("Weather Results", $body);
    }
}
