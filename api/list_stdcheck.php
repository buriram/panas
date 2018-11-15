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
date_default_timezone_set('Asia/Bangkok');
$today_date=$_GET['date'];
$user=$_GET['user'];
$sub=$_GET['subject'];
$sql = "SELECT chk_learn.st_code, student.first_name, student.last_name, chk_learn.l_time FROM chk_learn INNER JOIN student ON chk_learn.st_code = student.code WHERE chk_learn.sub_code = '$sub' AND chk_learn.chk_add ='$user' AND l_date ='$today_date' ";
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