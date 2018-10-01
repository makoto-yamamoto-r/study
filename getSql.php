<?php

$mysqli = new mysqli("localhost","root","","test");

if ($mysqli->connect_error) {
    print($mysqli->connect_error);
    exit();
}

$mysqli->set_charset("utf8");
$sql = "SELECT * FROM boardData";
$response = $mysqli->query($sql);
$data = $response->fetch_all(MYSQLI_ASSOC);

foreach($data as $value){
    printf("time:%s name:%s title:%s message:%s<br>",$value["time"],$value["name"],$value["title"],$value["message"]);
}

$mysqli->close();

?>