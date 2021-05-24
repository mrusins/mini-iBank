<?php
namespace App\Messages;


class InfoMessage {


    public function __construct() {
        if(!isset($_SESSION['infoMsg'])){
            $_SESSION['infoMsg']    = array();
        }
    }

    public function setText($message){

        $_SESSION['infoMsg'][]  = $message;

    }

    public function getText(){
        return $_SESSION['infoMsg'];
    }
}
?>
