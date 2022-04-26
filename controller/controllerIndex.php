<?php
class controllerIndex extends helperUtilities
{

    public function index()
    {
        $param = ['title' => 'Shrinker'];
        if ($_POST['submit']) {
        }
        $this->render("createlink", $param);
        //get view

    }
}
$export  = new controllerIndex();
