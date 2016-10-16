<?php ob_start();

    require_once "config.php";

    $username = $_REQUEST['username'];
    $usercode = $_REQUEST['usercode'];

    if(!empty($username) and !empty($usercode)){
        $sql = "";
    }

    header("Location:main_page.php");

ob_end_flush();?>