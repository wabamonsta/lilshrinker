<?php

class helperUtilities
{
    public  $result = '';
    const urlFileLocation =    __DIR__ . "/__urllist.inc";
    public function render($view, $params = null)
    {
        if (isset($param)) {
            extract($param);
        }
        include "view/" . $view . ".php";
    }


    /**
     *  Url Shortner : User will submit url to the function and a unique identifier will berpovided
     * @param $url 
     * @return: [uniqueid, originalurl]
     */
    public function urlshortener($url)
    {

        return array(uniqid(), $url);
    }

    public function saveUrl($id, $url)
    {

        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );


        $xml = @simplexml_load_string(file_get_contents($url, true, stream_context_create($arrContextOptions)));
        if (isset($xml->head->title[0])) {
            $title = ($xml->head->title[0]);
        } else {
            $title = null;
        }

        die(print_r($xml));
        $file  =  self::urlFileLocation;
        if (!file_exists($file)) {
            $fp = fopen($file, 'w');
            fclose($fp);
        }

        $content  = json_decode(file_get_contents($file, false, stream_context_create($arrContextOptions)));
        $shortURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . "u/" . $id;
        $newContent = array(
            'id' => $id,
            'title' => $title,
            'shortenURL' =>  $shortURL,
            'originalURL' => $url
        );
        if (!is_array($content)) {
            $content = array();
        }
        array_push($content, $newContent);
        if (file_put_contents($file, json_encode($content))) {
            return $this->toJSON($newContent);
        } else {
            return false;
        }
    }

    public function POST()
    {
        //Check if user using the correct method
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            http_response_code(401);
            die("Unauthorized method");
        }
    }

    public function GET()
    {
        //Check if user using the correct method
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            http_response_code(401);
            die("Unauthorized method");
        }
    }

    public function toJSON($param)
    {
        $result  = json_encode($param);
        $this->result  = $result;
        return    $this->result;
    }

    public function getURL($id)
    {
        $file  = file_get_contents(self::urlFileLocation);
        $fileToArray  = json_decode($file);

        foreach ($fileToArray as $urlItem) {
            if ($id) {
                if ($urlItem->id == $id) {
                    return $urlItem->originalURL;
                }
            }
        }
        return false;
    }

    private function show()
    {
        if (isset($this->result)) {
            echo   $this->result;
        }
    }
}
