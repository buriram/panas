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


		$sql = "SELECT * FROM tb_actCheck where chk_date = '$ch_date' AND code = '$user'";
		$result =mysqli_query($conn,$sql);
		if ($result->num_rows > 0) {
			$arr = array();
			// output data of each row
			while($row = $result->fetch_assoc()) {
		 $arr[] = $row;
			}
			echo json_encode(Array(ok => true, student => $arr));
	} else {
			echo "0 results";
	}
	$conn->close();
	?>