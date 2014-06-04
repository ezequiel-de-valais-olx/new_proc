<?php session_start();

include('listMaker.php');
include('getData.php');

$action = $_POST["action"];

echo listData::makeList($action, $returnData);
