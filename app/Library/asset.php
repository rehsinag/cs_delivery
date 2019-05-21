<?php

function asset2($path)
{
    return ('/'. $path);
}

function route2($name, $parameters = [], $absolute = false)
{
    return app('url')->route($name, $parameters, $absolute);
}