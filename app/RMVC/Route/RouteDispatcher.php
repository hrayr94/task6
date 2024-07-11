<?php

namespace App\RMVC\Route;

class RouteDispatcher
{
    private string $requestUri = "/";
    private array $paramMap = [];
    private array $paramRequestMap = [];

    public function __construct(private RouteConfiguration $routeConfiguration)
    {
    }

    public function process()
    {
        $this->saveRequestUri();
        $this->setParamMap();
        $this->makeRegexRequest();
        $this->run();
    }

    private function saveRequestUri()
    {
        if ($_SERVER['REQUEST_URI'] !== "/") {
            $this->requestUri = $this->clean($_SERVER['REQUEST_URI']);
            $this->routeConfiguration->path = $this->clean($this->routeConfiguration->path);
        }
    }

    private function clean($str): string
    {
        return preg_replace('/(^\/)|(\/$)/', '', $str);
    }

    private function setParamMap()
    {
        $routeArray = explode("/", $this->routeConfiguration->path);

        foreach ($routeArray as $paramKey => $param) {
            if (preg_match('/{.*}/', $param)) {
                $this->paramMap[$paramKey] = preg_replace('/(^{)|(}$)/', '', $param);
            }
        }
    }

    private function makeRegexRequest()
    {
        $requestUriArray = explode("/", $this->requestUri);

        foreach ($this->paramMap as $paramKey => $param) {
            if (!isset($requestUriArray[$paramKey])) {
                return;
            }
            $this->paramRequestMap[$param] = $requestUriArray[$paramKey];
            $requestUriArray[$paramKey] = '{.*}';
        }

        $this->requestUri = implode('/', $requestUriArray);
        $this->prepareRegex();
    }

    private function prepareRegex()
    {
        $this->requestUri = str_replace('/', '\/', $this->requestUri);
    }

    private function run()
    {
        if (preg_match("/$this->requestUri/", $this->routeConfiguration->path)) {
            $this->render();
        }
    }

    public function render()
    {
        $ClassName = $this->routeConfiguration->controller;
        $action = $this->routeConfiguration->action;
        // Ensure parameters are passed as array
        print((new $ClassName())->$action(...array_values($this->paramRequestMap)));
        die();
    }
}
