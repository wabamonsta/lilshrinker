<?php

class urlRoute
{

    public function getController()
    {
        $getpath  =  $this->getPath();
        $controller = explode("/", $getpath);
        print_r($controller);
        if (isset($controller[1]) && $controller[1] != '') {
            return ucwords($controller[1]);
        } else {
            return "Index";
        }
    }

    public function getView()
    {
    }

    public function getPath()
    {
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $urlinfo =  parse_url($actual_link);
        return $urlinfo['path'];
    }
}
