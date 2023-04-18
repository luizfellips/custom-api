<?php
header("Content-Type: application/json");
require_once __DIR__ . '/vendor/autoload.php';

if($_GET['url']){
    $API = new App\API($_GET['url']);
    $API->execute();
}