<?php
class controllerIndex extends helperUtilities
{

    public function index()
    {
        $param = ['title' => 'LiL Shrinker'];
        $this->render("createlink", $param);
        //get view

    }
}
$export  = new controllerIndex();
