<?php

namespace App\RMVC\Route;

class Route
{
    private static array $routesGet = [];
    private static array $routesPost = [];

    public static function getRoutesGet(): array
    {
        return self::$routesGet;
    }

    public static function getRoutesPost(): array
    {
        return self::$routesPost;
    }


    public static function get(string $path, array $controller): RouteConfiguration
    {
        $routeConfiguration = new RouteConfiguration($path, $controller[0], $controller[1]);
        self::$routesGet[] = $routeConfiguration;

        return $routeConfiguration;
    }

    public static function post(string $path, array $controller): RouteConfiguration
    {
        $routeConfiguration = new RouteConfiguration($path, $controller[0], $controller[1]);
        self::$routesPost[] = $routeConfiguration;

        return $routeConfiguration;
    }

    public static function redirect(string $url)
    {
        header('Location: ' . $url);
    }
}