<?php 
    class controllerIndex extends helperUtilities{

        public function index(){
            //save url here
            if($_POST['submit']){


            }
            $this->render("createlink");
            //get view

        }

    }
    $export  = new controllerIndex();
