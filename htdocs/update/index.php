<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

include('GitHub.php');
$deploy = new Aoloe\Deploy\GitHub();
$deploy->read();
