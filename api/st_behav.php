<?php
require_once('config_inc.php'); 
	header("Content-type: application/json; charset=utf-8");
    header("Access-Control-Allow-Origin: *");
    foreach ($_SERVER as $k => $v) {
      if(substr($k, 0, 20) == 'HTTP_ACCESS_CONTROL_') {
        header(substr(str_replace('_', '-', str_replace('_REQUEST_', '_allow_', $k)), 5) . ': ' . $v);
      }
		}
	
	function jsonRemoveUnicodeSequences($struct) {
   return preg_replace("/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))", json_encode($struct));
}
		$ch_date = $_GET['ch_date'];
		$user = $_GET['user'];
		//echo 'xx'. $user;
    // Create connection


		$sql = "SELECT student.code,student.first_name,student.last_name,std_check.ch_ts FROM student
INNER JOIN std_check ON student.code = std_check.st_code where std_check.ch_date = '$ch_date' AND std_check.std_user= '$user' ORDER BY `code`";
		$result =mysqli_query($conn,$sql);
		$arr = array();
		while($row = mysqli_fetch_assoc($result)){
			$arr[] = $row;
		}
		mysqli_close($conn);
		echo jsonRemoveUnicodeSequences(Array(ok => true, student => $arr));
$conn->close();
?>