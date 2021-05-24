<?php
namespace App\Messages;


class ErrorMessage {


    public function __construct() {
        if(!isset($_SESSION['errorMsg'])){
            $_SESSION['errorMsg']    = array();
        }
    }

    public function setText($message){

            $_SESSION['errorMsg'][]  = $message;

    }

    public function getText(){
        return $_SESSION['errorMsg'];
    }
}
?>
