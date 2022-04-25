<?php
class controllerApi  extends helperUtilities
{
    function index()
    {
        header('Content-Type: application/json; charset=utf-8');
        $method = $_SERVER['REQUEST_METHOD'];
        switch ($method) {
            case 'POST':
                extract($_POST);
                $id = substr(uniqid(), 7);
                echo  $this->saveUrl($id, $url);

                break;
            case 'GET':
                echo $this->toJSON(array("Method not assigned"));
                break;
            default:
                echo $this->toJSON(array("Method not assigned"));
        }
        exit;
    }

    public function save()
    {
    }
}
$export  = new controllerApi();
