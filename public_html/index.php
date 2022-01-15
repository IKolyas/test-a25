<?php

$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);

var_dump($_POST);

require('../views/main.php');
