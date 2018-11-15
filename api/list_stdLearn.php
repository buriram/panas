<?php
error_reporting(E_ALL & ~E_NOTICE);
    header("Content-type: application/json; charset=utf-8");
    header("Access-Control-Allow-Origin: *");
    foreach ($_SERVER as $k => $v) {
      if(substr($k, 0, 20) == 'HTTP_ACCESS_CONTROL_') {
        header(substr(str_replace('_', '-', str_replace('_REQUEST_', '_allow_', $k)), 5) . ': ' . $v);
      }
		}
require_once('config_inc.php'); 

$st_class=$_GET['class_id'];
$sql = "SELECT code, first_name, last_name, class_id, 0 as chk  FROM student WHERE class_id = '$st_class' ";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	$arr = array();
    // output data of each row
    while($row = $result->fetch_assoc()) {
 		$arr[] = $row;
    }
    echo json_encode(Array(ok => true, student =>$arr), JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode(Array(ok => FALSE));
}
$conn->close();
?>