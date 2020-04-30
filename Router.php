<?php

namespace App\Routing;

class Router
{
    private static $noMatch = true;

    private static function getUrl()
    {
        return $_SERVER['REQUEST_URI'];
    }

    private static function getMatches($pattern)
    {
        $url = self::getUrl();
        if (preg_match($pattern, $url, $matches)) {
            return $matches;
        }
        return false;
    }

    private static function process($pattern, $callback)
    {
        $pattern = "~^{$pattern}/?$~";
        $params = self::getMatches($pattern);

        if ($params) {
            if (is_callable($callback)) {
                self::$noMatch = false;
                $functionArguments = array_slice($params, 1);
                $callback(...$functionArguments);
            }
        }
    }

    public static function get($pattern, $callback)
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            return;
        }

        self::process($pattern,$callback);
    }

    public static function post($pattern, $callback)
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return;
        }
        self::process($pattern,$callback);
    }

    public static function delete($pattern, $callback)
    {
        if ($_SERVER['REQUEST_METHOD'] != 'DELETE') {
            return;
        }
        
        self::process($pattern,$callback);
    }

    public static function cleanup()
    {
        if (self::$noMatch) {
            echo "404! No Routes found";
        }
    }
}
