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

 	if (!$data['s_code']) {
    	exit;
 	 }		
	$s_code = ($data['s_code']);
        $s_idcard = ($data['s_idcard']);
        $s_name = ($data['s_name']);
        $s_class = ($data['s_class']);
        $s_dep = ($data['s_dep']);
        $s_group = ($data['s_group']);
        $s_tel = ($data['s_tel']);
        $s_address = ($data['s_address']);
        $sql = "INSERT INTO tb_student (s_code, s_idcard,s_name, s_class,s_dep,s_group,s_tel,s_address) VALUES ('$s_code', '$s_idcard','$s_name',' $s_class','$s_dep','$s_group','$s_tel','$s_address')";
        if ($conn->query($sql) === TRUE) {
            echo "ok";
        } else {
            echo "Error Save record: " . $conn->error;
        }
        
        $conn->close();
        ?>