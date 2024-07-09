<?php

namespace App\RMVC\Route;

class RouteConfiguration
{
    private string $name;
    private string $middleware;

    public function __construct(
        public string $path,
        public string $controller,
        public string $action
    )
    {
    }

    public function name(string $name) : RouteConfiguration
    {
        $this->name = $name;
        return $this;
    }

    public function middleware(string $middleware): RouteConfiguration
    {
        $this->middleware = $middleware;
        return $this;
    }
}
