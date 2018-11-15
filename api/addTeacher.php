<?php
error_reporting(E_ALL & ~E_NOTICE);
header("Access-Control-Allow-Origin: *");
    foreach ($_SERVER as $k => $v) {
      if(substr($k, 0, 20) == 'HTTP_ACCESS_CONTROL_') {
        header(substr(str_replace('_', '-', str_replace('_REQUEST_', '_allow_', $k)), 5) . ': ' . $v);
      }
		}
require_once('config_inc.php'); 
$jsondata = file_get_contents('php://input');
$data = json_decode($jsondata, true);

 	if (!$data['ta_name']) {
    	exit;
 	 }
	$ta_name = ($data['ta_name']);
        $ta_pass = ($data['ta_pass']);
        $ta_email = ($data['ta_email']);
        $sql = "INSERT INTO tb_teacher (ta_name, ta_pass,ta_email) VALUES ('$ta_name', '$ta_pass','$ta_email')";
        if ($conn->query($sql) === TRUE) {
            echo "ok";
        } else {
            echo "Error Save record: " . $conn->error;
        }
        
        $conn->close();
        ?>