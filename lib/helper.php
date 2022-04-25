<?php 

class helperUtilities{

    /**
     *  Url Shortner : User will submit url to the function and a unique identifier will berpovided
     * @param $url 
     * @return: [uniqueid, originalurl]
     */
    public function urlshortener($url){

        return array(uniqid(),$url);

    }

    public function saveUrl($id,$url){

        $file  =  __DIR__."/__urllist.inc";
        if(!file_exists($file)){
            $fp = fopen($file, 'w');  
            fclsoe($fp);
        }

        $content  = json_decode(file_get_contents($file));
        array_push($content, ...array($id,$url));
        if(file_put_contents($file,$content)){
            return $_SERVER['SERVER_NAME']."/u/".$id;
        }else{
            return false;
        }

    }
}
