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

function jsonRemoveUnicodeSequences($struct) {
   return preg_replace("/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))", json_encode($struct));
}

$user=$_GET['user'];
$sql = "SELECT * FROM map_sub_t WHERE ta_code= '$user' ORDER BY `maps_id`";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	$arr = array();
    // output data of each row
    while($row = $result->fetch_assoc()) {
 		$arr[] = $row;
    }
    echo jsonRemoveUnicodeSequences(Array(ok => true, subject =>$arr));
} else {
    		echo jsonRemoveUnicodeSequences(Array(ok => FALSE));
}
$conn->close();
?>