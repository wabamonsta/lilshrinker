<?php
class controllerU extends helperUtilities
{

    function index()
    {
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $urlinfo =  parse_url($actual_link);
        $getPathID  = explode("/", $urlinfo['path']);
        if (isset($getPathID['2'])) {
            $originalURL  =  $this->getURL($getPathID['2']);
            if ($originalURL) {

                header("Location:  {$originalURL}");
                exit;
            } else {
                echo  $this->toJSON(["error" => "Sorry URL does not exist"]);
            }
        }
    }
}
$export  = new controllerU();
