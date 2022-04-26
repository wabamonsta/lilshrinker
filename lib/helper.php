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


    public function saveUrl($id, $url)
    {

        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );
        $title = $this->url_get_title($url);

        $file  =  self::urlFileLocation;
        if (!file_exists($file)) {
            $fp = fopen($file, 'w');
            fclose($fp);
        }

        $content  = json_decode(file_get_contents($file, false, stream_context_create($arrContextOptions)));

        $shortURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . "/u/" . $id;
        $newContent = array(
            'id' => $id,
            'title' => $title,
            'shortenURL' =>  $shortURL,
            'originalURL' => $url,
            'frequency' => 0
        );


        if (!is_array($content)) {
            $content = array();
        }

        // Check if Url exist and if this is true increase the frequency by 1 
        $already_exist = 0;
        $i = 0; // content index
        foreach ($content as $contentItem) {

            if ($newContent['originalURL'] == $contentItem->originalURL) {
                $already_exist  = 1;
                $content[$i]->frequency = $contentItem->frequency + 1; // assign incrementation
                $shortURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . "/u/" .  $contentItem->id;
                //Set New Content ID for reference
                $newContent['id'] = $contentItem->id;
                $newContent['shortenURL'] = $shortURL;
                $newContent['frequency'] = $content[$i]->frequency;
            }
            $i++;
        }


        if ($already_exist) {
            $content  = $content;
        } else {
            array_push($content, $newContent);
        }

        if (file_put_contents($file, json_encode($content))) {
            return $this->toJSON($newContent);
        } else {
            return false;
        }
    }

    public function getTop100()
    {
        $file  = file_get_contents(self::urlFileLocation);
        $fileToArray  = json_decode($file);
        $frequencyArraySort = array_column($fileToArray, 'frequency', 'originalURL');

        array_multisort($frequencyArraySort, SORT_DESC, $fileToArray);
        array_slice($frequencyArraySort, 0, 100);
        return $this->toJSON($frequencyArraySort);
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

    public function url_get_title($url)
    {
        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );
        $str = file_get_contents($url, false, stream_context_create($arrContextOptions));
        if (strlen($str) > 0) {
            $str = trim(preg_replace('/\s+/', ' ', $str)); // supports line breaks inside <title>
            preg_match("/\<title\>(.*)\<\/title\>/i", $str, $title); // ignore case
            return $title[1];
        }
    }
}
