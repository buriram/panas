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

 	if (!$data['ac_title']) {
    	exit;
 	 }		
	$ac_title = ($data['ac_title']);
        $ac_note = ($data['ac_note']);

        $sql = "INSERT INTO tb_activities (ac_title, ac_note) VALUES ('$ac_title','$ac_note')";

        if ($conn->query($sql) === TRUE) {
            echo "ok";
        } else {
            echo "Error Save record: " . $conn->error;
        }
        
        $conn->close();
        ?>